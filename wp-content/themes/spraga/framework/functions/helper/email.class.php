<?php

namespace PS\Functions\Helper;

/**
 * Class Email
 * @package PS\Functions\Helper
 */
class Email {

    /**
     * constructor
     */
    public function __construct() {}

    // send email
    public function send_email( $to, $subject, $body, $attachments = array() ) {
        $headers   = array();
        $headers[] = 'From: spraga.com <info@' . str_ireplace(['http://', 'https://'], '', site_url()) . '>';
        $headers[] = 'Content-Type: text/html';
        $headers[] = 'charset=UTF-8';
        return wp_mail( $to, $subject, $body, $headers, $attachments );
    }

    // send notification
    public function send_notification( $post_id ) {

        // order
        if ( get_post_type( $post_id ) === 'order' ) {
            // to
            $to = get_field('order_email', \PS::$option_page);

            // subject
            $subject = 'Замовлення ' . get_the_title($post_id);

            // information
            $order_products = get_field('order_products', $post_id);
            $order_shipping = get_field('order_shipping', $post_id);
            $order_discount = get_field('order_discount', $post_id);
            $order_total = get_field('order_total', $post_id);

            $order_name = get_field('order_name', $post_id);
            $order_phone = get_field('order_phone', $post_id);
            $order_email = get_field('order_email', $post_id);
            $order_delivery = get_field('order_delivery', $post_id);
            $order_city = get_field('order_city', $post_id);
            $order_department = get_field('order_department', $post_id);
            $order_address = get_field('order_address', $post_id);

            // html
            ob_start();
            include( locate_template( 'parts/emails/order.php' ) );
            $body = ob_get_contents();
            ob_end_clean();

            // send
            $this->send_email( $order_email, $subject, $body ); // client
            return $this->send_email( $to, $subject, $body ); // admin
        }

        // letter
        elseif ( get_post_type( $post_id ) === 'letter' ) {
            // to
            $to = get_field('letter_email', \PS::$pages['about']);

            // subject
            $subject = 'Нове запитання';

            // information
            $name = get_field('name', $post_id);
            $phone = get_field('phone', $post_id);
            $email = get_field('email', $post_id);
            $text = get_field('text', $post_id);

            // html
            ob_start();
            include( locate_template( 'parts/emails/letter.php' ) );
            $body = ob_get_contents();
            ob_end_clean();

            // send
            return $this->send_email( $to, $subject, $body );
        }

        // partner
        elseif ( get_post_type( $post_id ) === 'partner' ) {
            // to
            $to = get_field('partner_email', \PS::$pages['buy']);

            // subject
            $subject = 'Стати партнером';

            // information
            $name = get_field('name', $post_id);
            $phone = get_field('phone', $post_id);
            $email = get_field('email', $post_id);
            $business = get_field('business', $post_id);
            $city = get_field('city', $post_id);

            // html
            ob_start();
            include( locate_template( 'parts/emails/partner.php' ) );
            $body = ob_get_contents();
            ob_end_clean();

            // send
            return $this->send_email( $to, $subject, $body );
        }

        // false
        else {
            return false;
        }
    }

}