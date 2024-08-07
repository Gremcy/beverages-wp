<?php

namespace PS\Functions\Seo;

/**
 * Class Init
 * @package PS\Functions\Seo
 * @since   1.0.0
 */
class Init {

    /**
     * Enable initialization
     * @return bool
     */
    public static function is_initialize() {
        return true;
    }

    /**
     * constructor
     */
    public function __construct() {
        /*
        * Call child classes
        */
        new Meta();
        new Rewrite();
		new Show404();
    }

}