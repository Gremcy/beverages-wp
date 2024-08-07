<?php

namespace PS\Functions\Shop;

/**
 * Class Helper
 * @package PS\Functions\Shop
 */
class Helper {

    /**
     * constructor
     */
    public function __construct() {
        //
    }

    /**
     * GENERAL
     */

    // price format
    public static function format_price($price){
        $return = 0;
        if($price){
            $return = number_format($price, 2, '.', '');
        }
        return str_ireplace('.00', '', $return);
    }

    /**
     * PRODUCTS
     */

    // check price
    public static function has_price( $product_id ) {
        $active = false;

        // check
        if(get_post_status($product_id) === 'publish'){
            $prices = get_field('price', $product_id); if(is_array($prices) && count($prices)){
                foreach ($prices as $price){
                    if(self::format_price($price['price'])){
                        $active = true;
                    }else{
                        $active = false;
                    }
                }
            }
        }

        return $active;
    }



}