<?php

namespace PS\Functions\Helper;

/**
 * Class Clear
 * @package PS\Functions\Helper
 * @since   1.0.0
 */
class Clear {

    /**
     * Init constructor.
     */
    public function __construct() {
        remove_action( 'wp_head', 'wp_generator' ); // remove WP tag

        remove_action( 'wp_head', 'feed_links_extra', 3 ); // remove extra feeds
        remove_action( 'wp_head', 'feed_links', 2 ); // remove general feeds
        remove_action( 'wp_head', 'rsd_link' ); // remove RSD link
        remove_action( 'wp_head', 'wlwmanifest_link' ); // remove manifest link
        remove_action( 'wp_head', 'index_rel_link' ); // remove index link
        remove_action( 'wp_head', 'parent_post_rel_link', 10 ); // remove prev link
        remove_action( 'wp_head', 'start_post_rel_link', 10 ); // remove start link
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10); // remove links to adjacent posts
        remove_action( 'wp_head', 'wp_shortlink_wp_head'); // remove shortlink
        remove_action( 'wp_head', 'wp_resource_hints', 2 );

        // disable admin bar
        add_filter( 'the_generator', '__return_false' );
        add_filter( 'show_admin_bar','__return_false' );

        // disable emoji
        remove_action( 'wp_head', 'print_emoji_detection_script', 7);
        remove_action( 'wp_print_styles', 'print_emoji_styles' );

        // disbale json
        remove_action( 'wp_head', 'rest_output_link_wp_head' );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
        remove_action( 'template_redirect', 'rest_output_link_header', 11 );

        // disbale xmlrpc
        add_filter( 'xmlrpc_enabled', '__return_false' );

        // disable X-Pingback to header
        add_filter( 'wp_headers', array( $this, 'disable_x_pingback' ) );

        // disable styles and scripts
        add_action( 'wp_footer', array( $this, 'deregister_scripts' ) );
        add_action( 'wp_print_styles', array( $this, 'deregister_styles' ) );
		
		// disable sitemap
		remove_action( 'init', 'wp_sitemaps_get_server' );

        // allow svg
        add_filter( 'upload_mimes', array( $this, 'cc_mime_types' ) );
		
		// robots
        remove_filter( 'wp_robots', 'wp_robots_max_image_preview_large' );
		
        // registration letters
        remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
        remove_action( 'edit_user_created_user', 'wp_send_new_user_notifications' );
        add_filter( 'send_password_change_email', '__return_false' );

        // disable json
        add_filter( 'rest_authentication_errors', array( $this, 'qode_disable_rest_api') );
		
		// remove language selector
        add_filter( 'login_display_language_dropdown', '__return_false' );
    }

    // disable scripts
    public function deregister_scripts(){
        wp_deregister_script( 'wp-embed' );
    }

    // disable styles
    public function deregister_styles(){
        wp_deregister_style( 'dashicons' );
		wp_deregister_style( 'wp-block-library' );
		wp_deregister_style( 'global-styles' );
		wp_deregister_style( 'classic-theme-styles' );
    }

    // disable X-Pingback to header
    public function disable_x_pingback( $headers ){
        unset($headers['X-Pingback']);
        return $headers;
    }

    // allow svg
    public function cc_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    // disable json
    function qode_disable_rest_api( $access ) {
        return new \WP_Error( 'rest_disabled', __( 'The WordPress REST API has been disabled.' ), array( 'status' => rest_authorization_required_code() ) );
    }
}