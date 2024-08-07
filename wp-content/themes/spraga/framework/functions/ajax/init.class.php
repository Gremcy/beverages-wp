<?php

namespace PS\Functions\Ajax;

/**
 * Class Init
 * @package     PS\Functions\Ajax
 * @since       1.0.0
 */
class Init {

    /**
     * Enable initialization
     * @return bool
     */
    public static function is_initialize() {
        if(defined('DOING_AJAX') && DOING_AJAX === true){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Init constructor.
     */
    public function __construct() {
        /*
         * Call child classes
         */
        new Letter();
        new Partner();
    }

}