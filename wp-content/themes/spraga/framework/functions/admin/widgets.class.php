<?php

namespace PS\Functions\Admin;

/**
 * Class Widgets
 * @package PS\Functions\Admin
 */
class Widgets {

    /**
     * constructor
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'remove_dashboard_meta' ) );
        add_action( 'wp_dashboard_setup', array( $this, 'customwidgets_add_dashboard_widgets' ) );
    }

    /**
     * Удаляем виджеты
     */
    public function remove_dashboard_meta() {
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // комментарии
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // черновик
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal'); // активность
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
    }

    /**
     * Добавляем виджеты
     */
    public function customwidgets_add_dashboard_widgets() {
        wp_add_dashboard_widget('dashboard_widget_madeby', __( 'Made by', \PS::$theme_name ), array( $this, 'dashboard_widget_madeby' ));
    }

    /**
     * Виджет разработчика
     */
    public function dashboard_widget_madeby(){
        echo '<div style="text-align: center; padding: 25px 0">';
        echo '<img src="'.\PS::$assets_url.'images/admin/madeby.png" style="width: 150px; height: 150px">';
        echo '</div>';
    }
}