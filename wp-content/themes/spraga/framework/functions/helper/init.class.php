<?php

namespace PS\Functions\Helper;

/**
 * Class Init
 * @package PS\Functions\Helper
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
     * constructor.
     */
    public function __construct() {
        /*
         * Call child classes
        */
        new Clear();
        new Cron();
		new Helper();
		new Images();
    }

}