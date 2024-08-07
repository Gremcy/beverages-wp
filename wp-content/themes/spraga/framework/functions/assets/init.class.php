<?php

namespace PS\Functions\Assets;

/**
 * Class Init
 * @package PS\Functions\Assets
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
        new Files();
	}

}