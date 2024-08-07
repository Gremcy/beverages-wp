<?php

namespace PS\Functions\Crm;

/**
 * Class Keycrm
 * @package PS\Functions\Crm
 */
class Keycrm {

    /**
     * token
     * @var string
     */
    protected $token;

    /**
     * constructor
     */
    public function __construct() {
        // vars
        $this->token = 'YzM4NWQ0OTFjMjI3MzRjMGM0NTY4NDBjYmEwMzhiNWY4YmE3ZmMwNA';
    }

    // connect
    private function connect($request, $body = array(), $method = 'POST'){
        $return = false;

        // url
        $url = 'https://openapi.keycrm.app/v1/' . $request;
        // args
        $args = array();
        $args['httpversion'] = '1.1';
        $args['timeout'] = 360;
        $args['sslverify'] = false;
        $args['headers'] = array(
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Cache-Control' => 'no-cache',
            'Pragma' => 'no-cache',
            'Authorization' => 'Bearer ' . $this->token
        );
        $args['method'] = $method;
        if(count($body)){
            $args['body'] = json_encode($body, JSON_UNESCAPED_UNICODE);
        }

        // request
        $response = wp_remote_request( $url, $args );
        if( in_array(wp_remote_retrieve_response_code($response), [200, 201, 202]) ) { // all's ok
            $return = json_decode(wp_remote_retrieve_body($response), true);
        }else{
            //$return = wp_remote_retrieve_response_code($response) . ' - ' . wp_remote_retrieve_response_message( $response );
        }

        // return
        return $return;
    }

    // create order
    public function create_order( $id ) {
        if ( get_post_type( $id ) === 'order' && !get_field('order_keycrm_id', $id) ) {
            $k = 1;

            $order_products = get_field('order_products', $id);
            $order_shipping = \PS\Functions\Shop\Helper::format_price(get_field('order_shipping', $id));
            $order_promocode = get_field('order_promocode', $id);
            $order_discount = \PS\Functions\Shop\Helper::format_price(get_field('order_discount', $id));
            $order_total = \PS\Functions\Shop\Helper::format_price(get_field('order_total', $id));

            $data = [];
            $data['source_id'] = 2;
            $data['source_uuid'] = get_the_title($id);
            $data['promocode'] = $order_promocode;
            $data['manager_comment'] = ($order_promocode ? 'Промокод: ' . $order_promocode: '');
            $data['shipping_price'] = $order_shipping;

            $data['buyer'] = [
                'full_name' => get_field('order_name', $id),
                'email' => get_field('order_email', $id),
                'phone' => get_field('order_phone', $id)
            ];

            $data['shipping'] = [
                'delivery_service_id' => str_ireplace(['variant_1', 'variant_2', 'variant_3'], [2, 3, 1], get_field('order_delivery', $id)),
                'shipping_address_city' => get_field('order_city', $id),
                'shipping_secondary_line' => get_field('order_address', $id),
                'recipient_full_name' => get_field('order_name', $id),
                'recipient_phone' => get_field('order_phone', $id),
                'shipping_receive_point' => get_field('order_department', $id),
                'warehouse_ref' => get_field('order_warehouse_ref', $id)
            ];

            $data['products'] = [];
            if (is_array($order_products) && count($order_products)) {
                // calc discount for each product (except special products)
                $discount_quantity = 0;
                $discount_total = 0;
                $help_total = 0;
                $discount_per_uah = 0;
                if ($order_discount) {
                    foreach ($order_products as $product) {
                        if (!$product['old_price']) {
                            $discount_total += ($product['quantity'] * $product['price']);
                            $discount_quantity++;
                        }
                    }
                    $discount_per_uah = \PS\Functions\Shop\Helper::format_price($order_discount / $discount_total);
                }
                // end calc

                foreach ($order_products as $product) {
                    // discounts
                    $discount_amount = 0;
                    if($product['old_price']){
                        $discount_amount = \PS\Functions\Shop\Helper::format_price($product['old_price'] - $product['price']);
                    }else{
                        if($order_discount){
                            if($k === $discount_quantity){
                                $discount_amount = \PS\Functions\Shop\Helper::format_price(($order_discount - $help_total) / $product['quantity']);
                            }else {
                                $discount_amount = \PS\Functions\Shop\Helper::format_price($product['price'] * $discount_per_uah);
                                $help_total += $discount_amount * $product['quantity'];
                            }
                            $k++;
                        }
                    }

                    // fields
                    $img = get_field('img', $product['product_id']);

                    // save
                    $data['products'][] = [
                        'sku' => $product['product_sku'],
                        'picture' => isset($img['sizes']['480x0']) ? $img['sizes']['480x0'] : '',
                        'name' => $product['product'],
                        'quantity' => $product['quantity'],
                        'price' => ($product['old_price'] ?: $product['price']),
                        'discount_amount' => $discount_amount
                    ];
                }
            }

            $data['payments'][] = [
                'payment_method_id' => str_ireplace(['variant_1'], [2], get_field('order_payment', $id)),
                'amount' => $order_total,
                'status' => str_ireplace(['no', 'error', 'success'], ['not_paid', 'not_paid', 'paid'], get_field('order_payment_status', $id))
            ];

            // logs
            $log = current_time('Y-m-d H:i:s');
            $log .= ' - ';
            $log .= json_encode($data, JSON_UNESCAPED_UNICODE);
            $log .= ' - ';

            // send
            $return = $this->connect('order', $data);

            // logs
            $log .= json_encode($return, JSON_UNESCAPED_UNICODE);
            update_field("field_66a8ec16d12f3", $log, $id);

            // save order id
            if(isset($return['id'])){
                update_field("field_65f0d25e456cb", $return['id'], $id);
            }
        }

        // return
        return true;
    }

    // get order
    public function get_order( $order_keycrm_id ){
        return $this->connect('order/' . $order_keycrm_id . '?include=payments', [], 'GET');
    }

    // update order payment
    public function update_order_payment( $id ) {
        if ( get_post_type( $id ) === 'order' && get_field('order_keycrm_id', $id) ) {
            $order_keycrm_id = get_field('order_keycrm_id', $id);
            $order = self::get_order($order_keycrm_id);

            if(isset($order['payments'][0]['id'])){
                $data = [
                    'status' => str_ireplace(['no', 'error', 'success'], ['not_paid', 'not_paid', 'paid'], get_field('order_payment_status', $id)),
                    'description' => get_field('order_payment_info', $id)
                ];

                $this->connect('order/' . $order_keycrm_id . '/payment/' . $order['payments'][0]['id'], $data, 'PUT');
            }
        }

        // return
        return true;
    }

}