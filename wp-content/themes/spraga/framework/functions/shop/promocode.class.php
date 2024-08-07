<?php

namespace PS\Functions\Shop;

/**
 * Class Promocode
 * @package PS\Functions\Shop
 */
class Promocode {

    /**
     * Init constructor.
     */
    public function __construct() {}

    // format promocode
    public static function format_promocode($promocode){
        return mb_strtoupper(wp_strip_all_tags(trim($promocode), true));
    }

    // get promocode id
    public static function get_promocode_id($promocode){
        global $wpdb;

        // return
        return $promocode ? (int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_title = '{$promocode}' AND post_type = 'promocode' AND post_status = 'publish'") : 0;
    }

    // get discount by promocode
    public static function get_discount_by_promocode($promocode){
        $return = [
            'discount' => 0,
            'error' => ''
        ];

        $promocode = self::format_promocode($promocode); if($promocode){
            // 1. check existing
            $promocode_id = self::get_promocode_id($promocode); if($promocode_id){
                // 2. check using
                $used = (int)get_field('used', $promocode_id); if(!$used){
                    // 3. check date
                    $date = get_field('date', $promocode_id); if(!$date || ($date && current_time('Ymd') <= $date)){
                        // 4. apply promocode
                        $sum_in_cart = \PS\Functions\Shop\Cart::get_sum_in_cart(false, false); if($sum_in_cart){
                            $type = get_field('type', $promocode_id); if($type === 'sum'){
                                $sum = Helper::format_price(get_field('sum', $promocode_id)); if($sum){
                                    $return['discount'] = Helper::format_price($sum_in_cart > $sum ? $sum : $sum_in_cart - 1);
                                }
                            }elseif($type === 'percent'){
                                $percent = (int)get_field('percent', $promocode_id); if($percent){
                                    $return['discount'] = Helper::format_price($sum_in_cart * ($percent / 100));
                                }
                            }
                        }else{
                            $return['error'] = __( 'Промокод не діє на акційні товари', \PS::$theme_name );
                        }
                    }else{
                        $return['error'] = __( 'Термін дії цього промокоду завершився', \PS::$theme_name );
                    }
                }else{
                    $return['error'] = __( 'Цей промокод вже використано', \PS::$theme_name );
                }
            }else{
                $return['error'] = __( 'Такий промокод не знайдено', \PS::$theme_name );
            }
        }

        // return
        return $return;
    }

}