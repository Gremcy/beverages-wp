<?php

namespace PS\Functions\Ajax;

/**
 * Class Letter
 * @package     PS\Functions\Ajax
 * @since       1.0.0
 */
class Letter {

    public function __construct() {
        add_action( 'wp_ajax_add_new_letter', array( $this, 'add_new_letter' ) );
        add_action( 'wp_ajax_nopriv_add_new_letter', array( $this, 'add_new_letter' ) );
    }

    // add letter
    public function add_new_letter() {
        $return = [
            'success' => false
        ];

        // 1. vars
        $name = isset($_POST['name']) ? wp_strip_all_tags($_POST['name'], true) : '';
        $phone = isset($_POST['phone']) ? wp_strip_all_tags($_POST['phone'], true) : '';
        $email = isset($_POST['email']) ? wp_strip_all_tags($_POST['email'], true) : '';
        $text = isset($_POST['text']) ? wp_strip_all_tags($_POST['text'], true) : '';
        if($email){

            // 2. save letter
            $post_data = array(
                'post_title' => '',
                'post_type'   => 'letter',
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
                update_field("field_64c39c5fc07eb", $name, $post_id);
                update_field("field_64c39c5fc0862", $phone, $post_id);
                update_field("field_64c39c5fc08cc", $email, $post_id);
                update_field("field_64c39c5fc091c", $text, $post_id);

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