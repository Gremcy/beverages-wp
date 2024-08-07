<?php

namespace PS\Functions\Admin;

/**
 * Class Init
 * @package     PS\Functions\Admin
 * @since       1.0.0
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
     * Init constructor.
     */
    public function __construct() {
        /*
         * Call child classes
         */
        new Columns();
        new Export();
        new Login();
        new Widgets();
    }

}