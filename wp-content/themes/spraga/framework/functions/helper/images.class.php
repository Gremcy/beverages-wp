<?php

namespace PS\Functions\Helper;

/**
 * Class Images
 * @package PS\Functions\Helper
 */
class Images {

    /**
     * constructor
     */
    public function __construct() {
        add_filter( 'jpeg_quality', array( $this, 'images_quality') );
        add_action( 'after_setup_theme', array( $this, 'images_additional_sizes') );
    }

    /**
     * quality
     */
    public function images_quality() {
        return 100;
    }

    /**
     * sizes
     */
    public function images_additional_sizes() {
        add_image_size( '100x100', 100, 100, true );
        add_image_size( '150x0', 150 );
        add_image_size( '480x0', 480 );
        add_image_size( '960x0', 960 );
        add_image_size( '1280x0', 1280 );
        add_image_size( '1600x0', 1600 );
    }

}