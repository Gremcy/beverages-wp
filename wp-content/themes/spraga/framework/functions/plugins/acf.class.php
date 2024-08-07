<?php

namespace PS\Functions\Plugins;

/**
 * Class ACF
 * @package PS\Functions\Plugins
 */
class ACF {

    /**
     * constructor
     */
    public function __construct() {
        // option page
        add_action('init', array( $this, 'register_option_page' ), 20);

        // saving post
        add_action( 'acf/save_post', array( $this, 'my_acf_save_post' ), 20 );
		
		// disable post types
        add_filter( 'acf/settings/enable_post_types', '__return_false' );
		
        // translating
        add_filter('acf/prepare_field/type=text', array( $this, 'my_acf_prepare_field' ));
        add_filter('acf/prepare_field/type=textarea', array( $this, 'my_acf_prepare_field' ));
		
        // fix for object/relationship fields
        add_filter('acf/fields/post_object/query', array( $this, 'fix_relationship_query'), 10, 3);
        add_filter('acf/fields/relationship/query', array( $this, 'fix_relationship_query'), 10, 3);
		
        // fix for translating of object/relationship field
        add_filter('acf/fields/post_object/result', array( $this, 'my_relationship_result'), 10, 4);
        add_filter('acf/fields/relationship/result', array( $this, 'my_relationship_result'), 10, 4);

        // wysiwyg field
        add_filter( 'acf/fields/wysiwyg/toolbars', array( $this, 'my_toolbars') );
    }

    /**
     * Option page
     */
    public function register_option_page(){
        if( function_exists('acf_add_options_page') ) {
            acf_add_options_page(array(
                'page_title' 	=> __( 'Налаштування', \PS::$theme_name ),
                'menu_slug' 	=> 'other'
            ));
        }
    }

    /**
     * Saving post
     */
    public function my_acf_save_post( $post_id ) {
        if(get_post_type($post_id) === 'promocode'){

            $promocode = get_the_title(); if($promocode){
                global $wpdb;
                $promocode_exist = (int)$wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_title = '{$promocode}' AND ID <> {$post_id} AND post_type = 'promocode' AND post_status = 'publish'"); if($promocode_exist){
                    $update_data = array(
                        'ID'         => $post_id,
                        'post_title' => mb_strtoupper(wp_generate_password(8, false))
                    );
                    wp_update_post( $update_data );
                }
            }else{
                $update_data = array(
                    'ID'         => $post_id,
                    'post_title' => mb_strtoupper(wp_generate_password(8, false))
                );
                wp_update_post( $update_data );
            }

        }elseif($post_id === 'options'){

            // import cities
            $nova_poshta_update = (int)get_field('nova_poshta_update', \PS::$option_page); if($nova_poshta_update){
                // increase time limit
                set_time_limit( 3600 ); // 1 hour

                // import
                $Shipping = new \PS\Functions\Shop\Shipping();
                $Shipping->import_cities();

                // reset
                update_field( 'field_657732ff7a456', '', \PS::$option_page );
            }

            // import warehouses
            $nova_poshta_update_2 = (int)get_field('nova_poshta_update_2', \PS::$option_page); if($nova_poshta_update_2){
                // increase time limit
                set_time_limit( 3600 ); // 1 hour

                // import
                $Shipping = new \PS\Functions\Shop\Shipping();
                $Shipping->import_warehouses();

                // reset
                update_field( 'field_658054dbe03ea', '', \PS::$option_page );
            }

            // generate promocodes
            $generate_promocode = (int)get_field('generate_promocode', \PS::$option_page); if($generate_promocode){
                // increase time limit
                set_time_limit( 3600 ); // 1 hour

                $generate_promocode_quantity = (int)get_field('generate_promocode_quantity', \PS::$option_page); if($generate_promocode_quantity){
                    for($n = 1; $n <= $generate_promocode_quantity; $n++){
                        $post_data = array(
                            'post_title' => mb_strtoupper(wp_generate_password(8, false)),
                            'post_type'   => 'promocode',
                            'post_status' => 'publish',
                            'post_author' => 1
                        );
                        $post_id = wp_insert_post($post_data);
                        if($post_id){
                            $type = get_field('generate_promocode_type', \PS::$option_page);
                            update_field("field_65c55290685b1", $type, $post_id);

                            if($type === 'sum'){
                                update_field("field_65c552f0685b2", get_field('generate_promocode_sum', \PS::$option_page), $post_id);
                            }elseif($type === 'percent'){
                                update_field("field_65c55319483cd", get_field('generate_promocode_percent', \PS::$option_page), $post_id);
                            }

                            update_field("field_65c55339965e4", get_field('generate_promocode_date', \PS::$option_page), $post_id);
                            update_field("field_65c55376c284b", '', $post_id);
                        }
                    }
                }

                // reset
                update_field( 'field_65f06741681b2', '', \PS::$option_page );
                update_field( 'field_65f0657268247', '', \PS::$option_page );
                update_field( 'field_65f066fa2e284', 'sum', \PS::$option_page );
                update_field( 'field_65f06766681b3', '', \PS::$option_page );
                update_field( 'field_65f067d96e1b5', '', \PS::$option_page );
                update_field( 'field_65f067fb6e1b6', '', \PS::$option_page );
            }

        }
    }

    /**
     * Translating
     */
    public function my_acf_prepare_field( $field ) {
        if(isset($field['wrapper']['class'])){
            $class_arr = explode(' ', $field['wrapper']['class']);
            if( !in_array('not_translate_it', $class_arr)) {
                $field['class'] = 'i18n-multilingual';
            }
        }
        return $field;
    }

    /**
     * Fix relationship/object query
     */
    public function fix_relationship_query( $args, $field, $post_id ) {
        // remove itself
        $args['post__not_in'] = array($post_id);
        // return
        return $args;
    }

    /**
     * Fix for translating of object/relationship field
     */
    public function my_relationship_result( $title, $post, $field, $post_id ) {
        // check for qtranlate format
        if(stripos($title, '[:') !== false){
            $title = substr($title, 5, stripos($title, '[:', 5) - 5);
        }
        // return
        return $title;
    }

    /**
     * Wysiwyg field
     */
    public function my_toolbars( $toolbars ){
        // change
        $toolbars['Basic'][1] = [
            'bold',
            'italic',
            'underline',
            'strikethrough',
            'forecolor',
            'link',
            'pastetext',
            'removeformat'
        ];

        $toolbars['Full'][1] = [
            //'formatselect',
            'bold',
            'italic',
            'underline',
            'strikethrough',
            'forecolor',
            'alignleft',
            'aligncenter',
            'alignright',
            'bullist',
            //'numlist',
            'link',
            'pastetext',
            'removeformat'
        ];
        $toolbars['Full'][2] = [];

        return $toolbars;
    }

}