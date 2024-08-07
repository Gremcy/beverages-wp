<?php

namespace PS\Functions\Shop;

/**
 * Class Payment
 * @package PS\Functions\Shop
 */
class Payment {

    // MerchantId
    protected $merchant_id;

    // SecretKey
    protected $secret_key;

    /**
     * Init constructor.
     */
    public function __construct() {
        $this->merchant_id = 1536982;
        $this->secret_key = 'NYBTp4S0Gzj2eQMH2Ov9iyPBTg1Xk3Gt';

        // результат оплаты
        if(isset($_GET['check_fondy_result'])){
            $this->check_fondy_result();
        }
    }

    /**
     * Генерируем форму оплаты
     */
    public function get_payment_link($order_id) {
        $return = '';

        // check
        $order_total = \PS\Functions\Shop\Helper::format_price(get_field('order_total', $order_id));
        $order_payment = get_field('order_payment', $order_id);
        $order_payment_status = get_field('order_payment_status', $order_id);
        if($order_total && $order_payment === 'variant_1' && $order_payment_status !== 'success') {

            // generate link
            require \PS::$framework_path . '/lib/fondy/autoload.php';
            \Cloudipsp\Configuration::setMerchantId($this->merchant_id);
            \Cloudipsp\Configuration::setSecretKey($this->secret_key);

            $data = [
                'order_id' => $order_id,
                'order_desc' => __('Оплата замовлення', \PS::$theme_name ) . ' ' . get_the_title($order_id),
                'currency' => 'UAH',
                'amount' => (int)($order_total * 100),
                'sender_email' => get_field('order_email', $order_id),
                'lang' => \PS::$current_language,
                'response_url' => get_the_permalink(\PS::$pages['success']),
                'server_callback_url' => site_url('/?check_fondy_result=1')
            ];

            $request = \Cloudipsp\Checkout::url($data);
            $return = $request->getUrl();
        }

        // return
        return $return;
    }

    /**
     * Проверяем результат оплаты
     */
    public function check_fondy_result() {
        $callbackData = json_decode(file_get_contents('php://input'), TRUE); //if request in json
        if ($callbackData){
            require \PS::$framework_path . '/lib/fondy/autoload.php';
            \Cloudipsp\Configuration::setMerchantId($this->merchant_id);
            \Cloudipsp\Configuration::setSecretKey($this->secret_key);

            $result = new \Cloudipsp\Result\Result($callbackData);
            $data = $result->getData();

            // check
            if(isset($data['order_id']) && isset($data['order_status'])){
                // успешный платеж
                if($data['order_status'] == 'approved'){
                    $pay_status = 'success';
                    $pay_info = 'Статус платежу: ' . $data['order_status'] . '; ' . 'ID платежу: ' . $data['payment_id'];

                    // set promocode as used
                    $promocode = get_field('order_promocode', $data['order_id']); if($promocode){
                        $promocode_id = Promocode::get_promocode_id($promocode); if($promocode_id){
                            update_field("field_65c55376c284b", 1, $promocode_id);
                        }
                    }

                    // send email
                    $Email = new \PS\Functions\Helper\Email();
                    $Email->send_notification($data['order_id']);
                }
                // ошибка оплаты
                elseif($data['order_status'] == 'failure'){
                    $pay_status = 'error';
                    $pay_info = 'Статус платежу: ' . $data['order_status'] . '; ' . 'Помилка: ' . $data['response_code'] . ' (' . $data['response_description'] . ')' . '; ' . 'ID платежу: ' . $data['payment_id'];
                }
                // другое
                else{
                    $pay_status = 'no';
                    $pay_info = 'Статус платежу: ' . $data['order_status'] . '; ' . 'ID платежу: ' . $data['payment_id'];
                }

                // save
                if($data['order_id']){
                    update_field("field_656f68e3274fb", $pay_status, $data['order_id']); // статус оплаты
                    update_field("field_656f690c274fc", $pay_info, $data['order_id']); // доп.информация об оплате

                    // CRM
                    $Keycrm = new \PS\Functions\Crm\Keycrm();
                    $Keycrm->update_order_payment($data['order_id']);
                }
            }

            // exit
            exit();
        }
    }

}