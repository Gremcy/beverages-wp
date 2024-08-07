<?php

namespace PS\Functions\Post_Types;

/**
 * Class Promocode
 * @package PS\Functions\Post_Types
 */
class Promocode {

    /**
     * constructor
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_post_type' ) );
    }

    /**
     * post type
     */
    public function register_post_type() {
        $labels = array(
            'name'               => __( 'Промокоди', \PS::$theme_name ),
            'add_new'            => __( 'Додати промокод', \PS::$theme_name ),
            'new_item'           => __( 'Новий промокод', \PS::$theme_name )
        );

        $args = array(
            'labels'             => $labels,
            'show_ui'             => true,
            'public'              => false,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'hierarchical'        => false,
            'query_var'           => false,
            'supports'            => array( 'title' ),
            'has_archive'         => false
        );

        register_post_type( 'promocode', $args );
    }
}