<?php

namespace PS\Functions\Shop;

use Error;
use Exception;
use Throwable;

/**
 * Class Ajax
 * @package     PS\Functions\Shop
 * @since       1.0.0
 */
class Ajax
{

    public function __construct()
    {
        /**
         * CART
         */

        // oprations in cart
        add_action('wp_ajax_operations_in_cart', array($this, 'operations_in_cart'));
        add_action('wp_ajax_nopriv_operations_in_cart', array($this, 'operations_in_cart'));

        /**
         * PROMOCODES
         */

        // apply promocode
        add_action('wp_ajax_apply_promocode', array($this, 'apply_promocode'));
        add_action('wp_ajax_nopriv_apply_promocode', array($this, 'apply_promocode'));

        /**
         * CHECKOUT
         */

        // city select
        add_action('wp_ajax_city_autocomplete', array($this, 'city_autocomplete'));
        add_action('wp_ajax_nopriv_city_autocomplete', array($this, 'city_autocomplete'));

        // warehouse select
        add_action('wp_ajax_warehouses_autocomplete', array($this, 'warehouses_autocomplete'));
        add_action('wp_ajax_nopriv_warehouses_autocomplete', array($this, 'warehouses_autocomplete'));

        // create new order
        add_action('wp_ajax_add_new_order', array($this, 'add_new_order'));
        add_action('wp_ajax_nopriv_add_new_order', array($this, 'add_new_order'));
    }

    /**
     * CART
     */

    // operations in cart
    public function operations_in_cart()
    {
        $return = array(
            'success' => false
        );

        // check
        if (isset($_POST['operation'])) {
            // vars
            $operation = wp_strip_all_tags(trim($_POST['operation']));
            $is_checkout = (int)$_POST['is_checkout'];

            // proccess
            $available_operations = array(
                'add', // добавление товара
                'plus', // аналог добавления товара
                'minus', // уменьшение кол-ства товара
                'remove', // удаление товара
            );
            if (in_array($operation, $available_operations)) {
                // нужные данные
                $product_id = (int)$_POST['product_id'];
                $variant_id = (int)$_POST['variant_id'];
                $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

                // смотрим, какая это операция
                if ($operation == 'add') {
                    // добавление
                    Cart::add_product($product_id, $variant_id, $quantity);
                } elseif ($operation == 'plus') {
                    // увеличение кол-ства
                    Cart::add_product($product_id, $variant_id);
                } elseif ($operation == 'minus') {
                    // уменьшение кол-ства
                    Cart::remove_product($product_id, $variant_id);
                } elseif ($operation == 'remove') {
                    // удаление
                    Cart::remove_product($product_id, $variant_id, true);
                }

                // ответ
                $return['success'] = true;
                $return['quantity_in_cart'] = Cart::get_quantity_in_cart($return['cart']);
                $return['sum_in_cart'] = Cart::get_sum_in_cart($return['cart']);
                $return['mini_cart'] = Cart::get_cart_html($is_checkout);
            }
        }

        // return
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        exit();
    }

    /**
     * PROMOCODES
     */

    // apply promocode
    public function apply_promocode()
    {
        // check
        $return = Promocode::get_discount_by_promocode($_POST['promocode']);

        // return
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        exit();
    }


    /**
     * CHECKOUT
     */

    // city select
    public function city_autocomplete()
    {
        global $wpdb;
        $current_language = \PS::$current_language;
        $out = array(
            'suggestions' => array()
        );

        // query
        $query = wp_strip_all_tags($_POST['query'], true);
        if ($query) {
            $result = $wpdb->get_results("SELECT ref, search_{$current_language} as search FROM {$wpdb->prefix}np_cities WHERE search_{$current_language} LIKE '{$query}%' ORDER BY search_{$current_language} ASC", ARRAY_A);
            if (is_array($result) && count($result)) {
                foreach ($result as $city) {
                    $out['suggestions'][] = array(
                        'data' => $city['ref'],
                        'value' => $city['search']
                    );
                }
            }
        }

        // return
        echo json_encode($out, JSON_UNESCAPED_UNICODE);
        exit();
    }

    // warehouse select
    public function warehouses_autocomplete()
    {
        global $wpdb;
        $current_language = \PS::$current_language;
        $out = array(
            'suggestions' => array()
        );

        // query
        $query = wp_strip_all_tags($_POST['query'], true);
        $city = wp_strip_all_tags($_POST['city'], true);
        if ($city) {
            $result = $wpdb->get_results("SELECT ref, search_{$current_language} as search FROM {$wpdb->prefix}np_warehouses WHERE cityref = '{$city}' AND search_{$current_language} LIKE '%{$query}%' ORDER BY search_{$current_language} ASC", ARRAY_A);
            foreach ($result as $warehouse) {
                $out['suggestions'][] = array(
                    'data' => $warehouse['ref'],
                    'value' => $warehouse['search']
                );
            }
        }

        // return
        echo json_encode($out, JSON_UNESCAPED_UNICODE);
        exit();
    }

    public static function get_warehouse_id($city, $name)
    {
        global $wpdb;
        $current_language = \PS::$current_language;
        $city_ref = $wpdb->get_var("SELECT ref FROM {$wpdb->prefix}np_cities WHERE search_{$current_language} = '{$city}'");
        return $city_ref ? $wpdb->get_var("SELECT ref FROM {$wpdb->prefix}np_warehouses WHERE cityref = '{$city_ref}' AND search_{$current_language} = '{$name}'") : '';
    }

    // create new order
    public function add_new_order()
    {
        global $wpdb;
        $current_language = wp_strip_all_tags($_POST['language'], true);
        $success = false;
        $errors = [];

        // data
        $name = wp_strip_all_tags($_POST['name'], true);
        $phone = wp_strip_all_tags($_POST['phone'], true);
        $email = wp_strip_all_tags($_POST['email'], true);

        $delivery = wp_strip_all_tags($_POST['delivery'], true);
        $city = wp_strip_all_tags($_POST['city'], true);
        $_post = wp_strip_all_tags($_POST['post'], true);
        $address = wp_strip_all_tags($_POST['address'], true);

        $pay = wp_strip_all_tags($_POST['pay'], true);
        $promocode = Promocode::format_promocode($_POST['promocode']);
        $promocode_info = Promocode::get_discount_by_promocode($promocode);

        $ip = wp_strip_all_tags(isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'], true);

        // проверка заполнения
        if ($phone) {
            // check city
            if ($delivery === 'variant_1' || $delivery === 'variant_2') {
                $check_city = (int)$wpdb->get_var("SELECT id FROM {$wpdb->prefix}np_cities WHERE search_{$current_language} = '{$city}'");
                if (!$check_city) {
                    $errors[] = 'city';
                }
            }
            // check post
            if ($delivery === 'variant_1') {
                $check_post = (int)$wpdb->get_var("SELECT id FROM {$wpdb->prefix}np_warehouses WHERE search_{$current_language} = '{$_post}'");
                if (!$check_post) {
                    $errors[] = 'post';
                }
            }
            if (count($errors) === 0) {
                $post_data = array(
                    'post_title' => '',
                    'post_type' => 'order',
                    'post_status' => 'new',
                    'post_author' => 1
                );
                $post_id = wp_insert_post($post_data);
                if ($post_id) {
                    // update title
                    $update_data = array(
                        'ID' => $post_id,
                        'post_title' => '#' . sprintf('%06d', $post_id)
                    );
                    wp_update_post($update_data);

                    // save fields
                    $total = 0;
                    $cart = \PS\Functions\Shop\Cart::get_cart();
                    if (is_array($cart) && count($cart)) {
                        foreach ($cart as $info) {
                            if (\PS\Functions\Shop\Helper::has_price($info['product_id'])) {
                                $row = array(
                                    'field_657348f591554' => $info['product_id'],
                                    'field_6582a5ea4f78a' => get_post_meta($info['product_id'], 'price_' . $info['variant_id'] . '_sku', true),
                                    'field_656f6609033a2' => get_the_title($info['product_id']) . ' (' . (get_post_meta($info['product_id'], 'price_' . $info['variant_id'] . '_format', true) === 'glass' ? 'скляна пляшка' : 'жерстяна банка') . ')',
                                    'field_656f6615033a3' => $info['quantity'],
                                    'field_656f6624033a4' => \PS\Functions\Shop\Helper::format_price(get_post_meta($info['product_id'], 'price_' . $info['variant_id'] . '_price', true)),
                                    'field_65f0178815f40' => \PS\Functions\Shop\Helper::format_price(get_post_meta($info['product_id'], 'price_' . $info['variant_id'] . '_old_price', true))
                                );
                                add_row('field_656f65f3033a1', $row, $post_id);

                                // total
                                $total += \PS\Functions\Shop\Helper::format_price($row['field_656f6615033a3'] * $row['field_656f6624033a4']);
                            }
                        }
                    }

                    // promocode / new!
                    if ($promocode && !$promocode_info['error']) {
                        update_field("field_65c55caf54ab5", $promocode, $post_id);
                        update_field("field_65c55cc154ab6", \PS\Functions\Shop\Helper::format_price($promocode_info['discount']), $post_id);

                        $total -= \PS\Functions\Shop\Helper::format_price($promocode_info['discount']);
                    }

                    update_field("field_656f67d25902e", $delivery, $post_id);
                    if ($delivery === 'variant_1') {
                        $total += \PS\Functions\Shop\Helper::format_price(get_field('price_1', \PS::$option_page));
                        update_field("field_656f6634edfcb", \PS\Functions\Shop\Helper::format_price(get_field('price_1', \PS::$option_page)), $post_id);

                        update_field("field_656f684091632", $city, $post_id);
                        update_field("field_656f684f91633", $_post, $post_id);
                        update_field("field_65f0d230456ca", self::get_warehouse_id($city, $_post), $post_id);
                    } elseif ($delivery === 'variant_2') {
                        $total += \PS\Functions\Shop\Helper::format_price(get_field('price_2', \PS::$option_page));
                        update_field("field_656f6634edfcb", \PS\Functions\Shop\Helper::format_price(get_field('price_2', \PS::$option_page)), $post_id);

                        update_field("field_656f684091632", $city, $post_id);
                        update_field("field_656f686f91634", $address, $post_id);
                    } else {
                        update_field("field_656f6634edfcb", 0, $post_id);
                    }
                    update_field("field_656f6652edfcc", \PS\Functions\Shop\Helper::format_price($total), $post_id);

                    update_field("field_656f6665c84b0", $name, $post_id);
                    update_field("field_656f669d36082", $phone, $post_id);
                    update_field("field_656f678e36083", $email, $post_id);

                    update_field("field_656f68a5274fa", $pay, $post_id);
                    update_field("field_656f68e3274fb", 'no', $post_id);

                    update_field("field_65733e0799afb", $ip, $post_id);

                    // clear cart
                    Cart::clear_cart();

                    // CRM
                    $Keycrm = new \PS\Functions\Crm\Keycrm();
                    $Keycrm->create_order($post_id);

                    // send email
                    //$Email = new \PS\Functions\Helper\Email();
                    //$Email->send_notification($post_id);

                    // online payment
                    if ($pay === 'variant_1') {
                        $Payment = new Liqpay();
                        $pay_form = $Payment->get_payment_form($post_id);
                    }

                    // success
                    $success = true;
                }
            }
        }

        // echo
        $response_data = array(
            'success' => $success,
            'errors' => $errors,
            'order_id' => $post_id ?? '',
            'pay_form' => $pay_form ?? ''
        );

        echo json_encode($response_data, JSON_UNESCAPED_UNICODE);
        exit();
    }

}