<?php

namespace PS\Functions\Shop;

/**
 * Class Liqpay
 * @package     PS\Functions\Shop
 */
class Liqpay {

    // public key
    protected $public_key;

    // private key
    protected $private_key;

    /**
     * Init constructor.
     */
    public function __construct() {
        $this->public_key  = 'i14127345104'; // sandbox_i34904480012
        $this->private_key = 'VremNjdxKbZSMrtVxMwj9BoHw8dirvrhC1COMNvg'; // sandbox_5a4Jw1F8x5I8A99gBtTg2WtJU5xOKKOSBGc2TKbo

        // результат оплаты
        if(isset($_GET['check_liqpay_result'])){
            $this->check_liqpay_result();
        }
    }

    /**
     * Генерируем форму оплаты
     */
    public function get_payment_form($order_id) {
        $return = '';

        // check
        $order_total = \PS\Functions\Shop\Helper::format_price(get_field('order_total', $order_id));
        $order_payment = get_field('order_payment', $order_id);
        $order_payment_status = get_field('order_payment_status', $order_id);
        if($order_total && $order_payment === 'variant_1' && $order_payment_status !== 'success') {
            // data
            $params = array(
                // required
                'version'             => 3,
                'action'              => 'pay',
                'amount'              => $order_total,
                'currency'            => 'UAH',
                'description'         => __('Оплата замовлення', \PS::$theme_name ) . ' ' . get_the_title($order_id),
                'order_id'            => $order_id,
                // optional
                'language'            => \PS::$current_language,
                'result_url'          => get_the_permalink(\PS::$pages['success']),
                'server_url'          => site_url( '/?check_liqpay_result=1' )
            );

            require \PS::$framework_path . '/lib/liqpay/LiqPay.php';
            $LiqPay = new \LiqPay( $this->public_key, $this->private_key );
            $return = $LiqPay->cnb_form($params);
        }

        //
        return $return;
    }

    /**
     * Проверяем результат оплаты
     */
    public function check_liqpay_result() {
        // check post-data
        if ( isset( $_POST['data'] ) && isset( $_POST['signature'] ) ) {
            $data        = $_POST['data'];
            $signature   = base64_encode( sha1( $this->private_key . $data . $this->private_key, true ) );
            $parsed_data = json_decode( base64_decode( $data ), true );
            $order_id    = (int) $parsed_data['order_id'];
            //if ( $signature == $_POST['signature'] ) {
                // success
                if ( $parsed_data['status'] == 'success' ) {
                    $pay_status = 'success';
                    $pay_info = 'Статус платежу: ' . $parsed_data['status'] . '; ' . 'ID платежу: ' . $parsed_data['payment_id'];

                    // set promocode as used
                    $promocode = get_field('order_promocode', $order_id); if($promocode){
                        $promocode_id = Promocode::get_promocode_id($promocode); if($promocode_id){
                            update_field("field_65c55376c284b", 1, $promocode_id);
                        }
                    }

                    // send email
                    $Email = new \PS\Functions\Helper\Email();
                    $Email->send_notification($order_id);
                } // error
                elseif ( $parsed_data['status'] == 'failure' || $parsed_data['status'] == 'error' ) {
                    $pay_status = 'error';
                    $pay_info = 'Статус платежу: ' . $parsed_data['status'] . '; ' . 'Помилка: ' . $parsed_data['err_code'] . ' (' . $parsed_data['err_description'] . ')' . '; ' . 'ID платежу: ' . $parsed_data['payment_id'];
                } // other
                else {
                    $pay_status = 'no';
                    $pay_info = 'Статус платежу: ' . $parsed_data['status'] . '; ' . 'ID платежу: ' . $parsed_data['payment_id'];
                }

                // save
                if($order_id){
                    update_field("field_656f68e3274fb", $pay_status, $order_id); // статус оплаты
                    update_field("field_656f690c274fc", $pay_info, $order_id); // доп.информация об оплате

                    // CRM
                    $Keycrm = new \PS\Functions\Crm\Keycrm();
                    $Keycrm->update_order_payment($order_id);
                }
            //}
        }
    }

}