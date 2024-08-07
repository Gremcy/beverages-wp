<?php

namespace PS\Functions\Seo;

/**
 * Class Show404
 * @package PS\Functions\Seo
 */
class Show404 {

    /**
     * constructor
     */
    public function __construct() {
        add_action( 'wp', array( $this, 'show_404' ) );
    }

    /**
     * show 404
     */
    public function show_404(){
        if(is_category() || is_tag() || is_post_type_archive(array('post')) || is_singular(array('post'))){
            global $wp_query;
            $wp_query->set_404();
            status_header( 404 );
            get_template_part( 404 );
            exit();
        }
    }
}