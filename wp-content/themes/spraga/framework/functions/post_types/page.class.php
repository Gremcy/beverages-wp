<?php

namespace PS\Functions\Post_Types;

/**
 * Class Page
 * @package PS\Functions\Post_Types
 */
class Page {

    /**
     * constructor
     */
    public function __construct() {
        add_action( 'init', array( $this, 'post_type_support' ) );
    }

    /**
     * post type
     */
    public function post_type_support() {
        remove_post_type_support( 'page', 'editor' );
        remove_post_type_support( 'page', 'comments' );
        remove_post_type_support( 'page', 'author' );
    }
}