<?php

namespace PS\Functions\Post_Types;

/**
 * Class Partner
 * @package PS\Functions\Post_Types
 */
class Partner {

    /**
     * constructor
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_post_type' ) );
        add_action( 'admin_menu', array( $this, 'count_new_post' ) );
    }

    /**
     * post type
     */
    public function register_post_type() {
        $labels = array(
            'name'               => __( 'Стати партнером', \PS::$theme_name ),
            'add_new'            => __( 'Додати лист', \PS::$theme_name ),
            'new_item'           => __( 'Новий лист', \PS::$theme_name )
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

        register_post_type( 'partner', $args );
    }

    /**
     * Добавить в меню количество новых результатов
     */
    public function count_new_post() {
        global $menu, $wpdb;
        $count = $wpdb->get_var( "SELECT COUNT(ID) FROM {$wpdb->posts} WHERE post_type = 'partner' and post_status = 'publish'" );
        foreach ($menu as $key => $item) {
            if ($item[2] == 'edit.php?post_type=partner') {
                $menu[$key][0] .= " <span class='awaiting-mod count-{$count}'><span class='pending-count'>{$count}</span></span>";
            }
        }
    }

}