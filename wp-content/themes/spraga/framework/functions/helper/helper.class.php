<?php

namespace PS\Functions\Helper;

/**
 * Class Helper
 * @package PS\Functions\Helper
 * @since   1.0.0
 */
class Helper {

    /**
     * Init constructor.
     */
    public function __construct() {
        //
    }

    /**
     ******* GENERAL *******
     */
	 
	 // get posts by args
    public static function get_posts( $post_type, $post_status = 'publish', $posts_per_page = -1, $paged = 1, $meta_query = array(), $tax_query = array(), $post__in = array(), $post__not_in = array(), $orderby = 'menu_order', $order = 'ASC' ) {
        $args['post_type']      = $post_type;
        $args['post_status']    = $post_status;
        $args['posts_per_page'] = $posts_per_page;
        $args['paged'] = $paged;
        if ( count( $meta_query ) ) {
            $args['meta_query'] = $meta_query;
        }
        if ( count( $tax_query ) ) {
            $args['tax_query'] = $tax_query;
        }
        if ( count( $post__in ) ) {
            $args['post__in'] = $post__in;
        }
        if ( count( $post__not_in ) ) {
            $args['post__not_in'] = $post__not_in;
        }
        if($orderby){
            $args['orderby'] = $orderby;
        }
        if($order){
            $args['order'] = $order;
        }
        return query_posts( $args );
    }
	
	/**
     ******* PRODUCTS *******
     */

    // get all products
    public static function get_products(){
        // return
        return \PS\Functions\Helper\Helper::get_posts(
            'products'
        );
    }

    /**
     ******* ORDERS *******
     */

    // get all orders
    public static function get_orders(){
        // return
        global $wpdb;
        return $wpdb->get_col("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'order'");
    }

    // get random products
    public static function get_random_products($post_id = false, $num = 6){
        return \PS\Functions\Helper\Helper::get_posts(
            'products',
            'publish',
            $num,
            1,
            [],
            [],
            [],
            $post_id ? [$post_id] : [],
            'rand'
        );
    }
	
}