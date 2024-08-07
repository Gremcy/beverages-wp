<?php

namespace PS\Functions\Shop;

/**
 * Class Shipping
 * @package PS\Functions\Shop
 */
class Shipping {

    /**
     * connect url
     */
    protected $nova_poshta_url;

    /**
     * connect key
     */
    protected $nova_poshta_key;

    /**
     * iso table
     */
    protected $iso_table;

    /**
     * constructor
     */
    public function __construct() {
        // url
        $this->nova_poshta_url = 'https://api.novaposhta.ua/v2.0/json/';

        // key
        $this->nova_poshta_key = get_field('nova_poshta_key', \PS::$option_page);

        // table
        $this->iso_table = array(
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G', 'Ґ' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE', 'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'Y', 'Й' => 'J', 'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K', 'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS', 'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g', 'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye', 'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'y', 'й' => 'j', 'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k', 'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ў' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'shh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
        );
    }

    /**
     * API NOVA POSHTA
     */

    // connect
    private function connect_with_nova_poshta( $body = array() ) {
        $return         = false;
        $body['apiKey'] = $this->nova_poshta_key;

        // args
        $args                = array();
        $args['httpversion'] = '1.1';
        $args['timeout']     = 3600; // timeout
        $args['body']        = json_encode( $body );

        // send
        $response = wp_remote_post( $this->nova_poshta_url, $args );
        if ( wp_remote_retrieve_response_code( $response ) == 200 ) { // all's ok
            $return = json_decode( htmlspecialchars_decode( wp_remote_retrieve_body( $response ) ), true );
        } else {
            $return = wp_remote_retrieve_response_code($response) . ' - ' . wp_remote_retrieve_response_message( $response );
        }

        // return
        return $return;
    }

    // cities
    public function get_cities( $Page = 1 ) {
        // request
        $body   = array(
            'modelName'        => 'Address',
            'calledMethod'     => 'getCities',
            'methodProperties' => array(
                'Page' => $Page,
                'Limit' => 150
            )
        );
        $result = self::connect_with_nova_poshta( $body );

        // return
        return ( isset( $result['success'] ) && $result['success'] == '1' ) ? $result : false;
    }

    // warehouses
    public function get_warehouses( $TypeOfWarehouseRef, $Page = 1 ) {
        // request
        $body   = array(
            'modelName'        => 'AddressGeneral',
            'calledMethod'     => 'getWarehouses',
            'methodProperties' => array(
                'TypeOfWarehouseRef' => $TypeOfWarehouseRef,
                'Page'     => $Page,
                'Limit'    => 500
            )
        );
        $result = self::connect_with_nova_poshta( $body );

        // return
        return ( isset( $result['success'] ) && $result['success'] == '1' ) ? $result : false;
    }


    /**
     * IMPORT
     */

    // import of cities
    public function import_cities() {
        global $wpdb;

        // get cities
        $cities = self::get_cities();
        if ( is_array( $cities['data'] ) && count( $cities['data'] ) ) {
            // clear table
            $wpdb->query( "TRUNCATE TABLE {$wpdb->prefix}np_cities" );

            // get total pages
            $total_pages = (int) ceil( $cities['info']['totalCount'] / 150 );

            // insert into DB
            for ( $n = 1; $n <= $total_pages; $n ++ ) {
                $_cities = self::get_cities( $n );
                if ( is_array( $_cities['data'] ) && count( $_cities['data'] ) ) {
                    foreach ( $_cities['data'] as $city ) {
                        // insert
                        $wpdb->insert(
                            $wpdb->prefix . 'np_cities',
                            array(
                                'ref'                  => $city['Ref'],
                                'search_uk'            => str_ireplace('  ', ' ', trim(wp_strip_all_tags($city['Description'], true))),
                                'search_en'            => strtr(str_ireplace('  ', ' ', trim(wp_strip_all_tags($city['Description'], true))), apply_filters('ctl_table', $this->iso_table))
                            ),
                            array(
                                '%s',
                                '%s',
                                '%s'
                            )
                        );
                    }
                }
            }
        }

        // return
        return true;
    }

    // import of warehouses
    public function import_warehouses() {
        global $wpdb;

        // clear table
        $wpdb->query( "TRUNCATE TABLE {$wpdb->prefix}np_warehouses" );

        // get warehouses
        foreach (['841339c7-591a-42e2-8233-7a0a00f0ed6f', '9a68df70-0267-42a8-bb5c-37f427e36ee4'] as $type){ // без поштоматів
            $warehouses = self::get_warehouses($type);
            if ( is_array( $warehouses['data'] ) && count( $warehouses['data'] ) ) {
                // get total pages
                $total_pages = (int) ceil( $warehouses['info']['totalCount'] / 500 );

                for ( $n = 1; $n <= $total_pages; $n ++ ) {
                    $_warehouses = self::get_warehouses( $type, $n );
                    if ( is_array( $_warehouses['data'] ) && count( $_warehouses['data'] ) ) {
                        // insert into DB
                        foreach ( $_warehouses['data'] as $warehouse ) {
                            // insert
                            $wpdb->insert(
                                $wpdb->prefix . 'np_warehouses',
                                array(
                                    'ref'                  => $warehouse['Ref'],
                                    'cityref'              => $warehouse['CityRef'],
                                    'search_uk'            => str_ireplace('  ', ' ', trim(wp_strip_all_tags($warehouse['Description'], true))),
                                    'search_en'            => strtr(str_ireplace('  ', ' ', trim(wp_strip_all_tags($warehouse['Description'], true))), apply_filters('ctl_table', $this->iso_table))
                                ),
                                array(
                                    '%s',
                                    '%s',
                                    '%s',
                                    '%s'
                                )
                            );
                        }
                    }
                }
            }
        }

        // return
        return true;
    }

}