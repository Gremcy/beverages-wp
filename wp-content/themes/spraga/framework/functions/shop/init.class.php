<?php

namespace PS\Functions\Shop;

/**
 * Class Init
 * @package PS\Functions\Shop
 * @since   1.0.0
 */
class Init {

    /**
     * enable initialization
     */
    public static function is_initialize() {
        return true;
    }

    /**
     * constructor
     */
    public function __construct() {
        new Ajax();
        new Liqpay();
        new Payment();
    }

}