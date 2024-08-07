<?php

namespace PS\Functions\Shop;

/**
 * Class Cart
 * @package PS\Functions\Shop
 */
class Cart {

    /**
     * constructor
     */
    public function __construct() {
        //
    }

    /**
     * OPERATIONS
     */

    // получить товары в корзине
    public static function get_cart() {
        $cart = array();
        if(isset($_SESSION['user_cart'])){
            $cart = json_decode( $_SESSION['user_cart'], true );
        }
        return $cart;
    }

    // запись товаров в корзину
    public static function update_cart( $cart ) {
        if($_SESSION['user_cart'] = json_encode($cart, JSON_UNESCAPED_UNICODE)){
            return true;
        }
        return false;
    }

    // добавление в корзину
    public static function add_product($product_id, $variant_id, $quantity = 1) {
        $cart = self::get_cart();
        $product_check = Helper::has_price($product_id); // проверяем товар

        // добавляем в корзину
        if(is_array($cart) && $product_check){
            if(isset($cart[$product_id . $variant_id])){
                $cart[$product_id . $variant_id]['quantity'] += $quantity; // увеличиваем кол-ство
            }else{
                $cart[$product_id . $variant_id] = array();
                $cart[$product_id . $variant_id]['product_id'] = $product_id;
                $cart[$product_id . $variant_id]['variant_id'] = $variant_id;
                $cart[$product_id . $variant_id]['quantity'] = $quantity;
            }
        }

        // запись
        return self::update_cart( $cart );
    }

    // уменьшение кол-ства / удаление из корзины
    public static function remove_product($product_id, $variant_id, $remove = false) {
        $cart = self::get_cart();

        // смотрим, есть ли такой товар в корзине
        if(is_array($cart)){
            if(isset($cart[$product_id . $variant_id])){
                if ($remove === true) { // удаление
                    unset($cart[$product_id . $variant_id]);
                } elseif ($remove === false && (int)$cart[$product_id . $variant_id]['quantity'] > 1) { // уменьшение кол-ства
                    $cart[$product_id . $variant_id]['quantity'] -= 1;
                }
            }
        }

        // запись
        return self::update_cart( $cart );
    }

    // clear cart
    public static function clear_cart() {
        return self::update_cart([]);
    }

    /**
     * INFORMATION
     */

    // get quantity of products
    public static function get_quantity_in_cart($cart = false){
        $return = 0;
        $cart = $cart ?: self::get_cart();

        // count
        if(is_array($cart) && count($cart)){
            foreach ($cart as $info){
                $return += $info['quantity'];
            }
        }

        // return
        return (int)$return;
    }

    // get sum of products
    public static function get_sum_in_cart($cart = false, $include_discount_products = true){
        $return = 0;
        $cart = $cart ?: self::get_cart();

        // count
        if(is_array($cart) && count($cart)){
            foreach ($cart as $info){
                if($include_discount_products){
                    $return += Helper::format_price(get_post_meta($info['product_id'], 'price_' . $info['variant_id'] . '_price', true)) * $info['quantity'];
                }else{
                    if(!Helper::format_price(get_post_meta($info['product_id'], 'price_' . $info['variant_id'] . '_old_price', true))){ // if not has old price
                        $return += Helper::format_price(get_post_meta($info['product_id'], 'price_' . $info['variant_id'] . '_price', true)) * $info['quantity'];
                    }
                }
            }
        }

        // return
        return Helper::format_price($return);
    }

    /**
     * HTML
     */

    // get cart (html)
    public static function get_cart_html($is_checkout = false) {
        ob_start();
        get_template_part('parts/elements/cart', null, ['is_checkout' => $is_checkout]);
        return ob_get_clean();
    }

}