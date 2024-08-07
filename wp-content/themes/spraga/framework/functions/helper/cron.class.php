<?php

namespace PS\Functions\Helper;

/**
 * Class Cron
 * @package PS\Functions\Helper
 */
class Cron {

    /**
     * constructor
     */
    public function __construct() {
        // import
        add_action( 'init', array( $this, 'start_cron' ) );
    }

    /**
     * START CRON
     */
    public function start_cron() {
        if ( isset( $_GET['_cron'] ) ) {
            // increase time limit
            set_time_limit( 3600 ); // 1 hour

            // nova poshta
            $Shipping = new \PS\Functions\Shop\Shipping();
            $Shipping->import_cities();
            $Shipping->import_warehouses();
        }

        return true;
    }

}