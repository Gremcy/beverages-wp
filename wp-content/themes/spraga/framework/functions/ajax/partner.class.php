<?php

namespace PS\Functions\Ajax;

/**
 * Class Partner
 * @package     PS\Functions\Ajax
 * @since       1.0.0
 */
class Partner {

    public function __construct() {
        add_action( 'wp_ajax_add_new_partner', array( $this, 'add_new_partner' ) );
        add_action( 'wp_ajax_nopriv_add_new_partner', array( $this, 'add_new_partner' ) );
    }

    // add partner
    public function add_new_partner() {
        $return = [
            'success' => false
        ];

        // 1. vars
        $name = isset($_POST['name']) ? wp_strip_all_tags($_POST['name'], true) : '';
        $phone = isset($_POST['phone']) ? wp_strip_all_tags($_POST['phone'], true) : '';
        $email = isset($_POST['email']) ? wp_strip_all_tags($_POST['email'], true) : '';
        $business = isset($_POST['business']) ? wp_strip_all_tags($_POST['business'], true) : '';
        $city = isset($_POST['city']) ? wp_strip_all_tags($_POST['city'], true) : '';
        if($email){

            // 2. save letter
            $post_data = array(
                'post_title' => '',
                'post_type'   => 'partner',
                'post_status' => 'publish',
                'post_author' => 1
            );
            $post_id = wp_insert_post($post_data);
            if($post_id){
                // update title
                $update_data = array(
                    'ID'         => $post_id,
                    'post_title' => '#' . sprintf( '%05d', $post_id )
                );
                wp_update_post( $update_data );

                // fields
                update_field("field_64c39be29b8d2", $name, $post_id);
                update_field("field_64c39be89b8d3", $phone, $post_id);
                update_field("field_64c39bf7f80e3", $email, $post_id);
                update_field("field_64c39c06f80e4", $business, $post_id);
                update_field("field_64c39c142ca52", $city, $post_id);

                // 5. send email
                $Email = new \PS\Functions\Helper\Email();
                $Email->send_notification($post_id);

                // success
                $return['success'] = true;
            }

        }

        // echo
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        exit();
    }
}