<?php

namespace PS\Functions\Plugins;

/**
 * Class Qtranslate
 * @package PS\Functions\Plugins
 */
class Qtranslate {

    /**
     * constructor
     */
    public function __construct() {
        // MO files
        add_action('after_setup_theme', array( $this, 'lang_theme_setup' ));

        // remove generator
        remove_action('wp_head', 'qtranxf_wp_head_meta_generator');

        // remove column in admin
        remove_filter('manage_posts_columns', 'qtranxf_language_column_header');
        remove_filter('manage_posts_custom_column', 'qtranxf_language_column');
        remove_filter('manage_pages_columns', 'qtranxf_language_column_header');
        remove_filter('manage_pages_custom_column', 'qtranxf_language_column');
    }

    // MO files
    public function lang_theme_setup(){
        load_theme_textdomain(\PS::$theme_name, get_template_directory() . '/languages');
    }
	
	// get current languages
    public static function get_languages() {
        global $q_config;
        if ( is_404() ) {
            $url = get_option( 'home' );
        } else {
            $url = '';
        }
        $languages = [];
        foreach ( qtranxf_getSortedLanguages() as $language ) {
            $languages[] = array(
                'active' => $language == $q_config['language'],
                'code' => $language,
                'name' => $q_config['language_name'][ $language ],
                'url'  => qtranxf_convertURL( $url, $language, false, true )
            );
        }

        return $languages;
    }

    // site url
    public static function current_site_url( $path = '' ) {
        global $q_config;
        $language_suffix = ( \PS::$current_language === $q_config['default_language'] ? '' : '/' . \PS::$current_language );
        return site_url( $language_suffix . ( $path ?: '/' ) );
    }

}