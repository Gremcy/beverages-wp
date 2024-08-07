<?php

namespace PS\Functions\Plugins;

/**
 * Class Init
 * @package     PS\Functions\Plugins
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
        new ACF();
		new CyrToLat();
        new Qtranslate();
    }

}