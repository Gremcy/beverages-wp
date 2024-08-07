<?php

namespace PS\Functions\Admin;

/**
 * Class Columns
 * @package PS\Functions\Admin
 */
class Columns {

    /**
     * constructor
     */
    public function __construct() {
        // orders
        add_filter('manage_edit-order_columns', array( $this, 'columns_head_only_order'), 15);
        add_filter('manage_order_posts_custom_column', array( $this, 'columns_content_only_order'), 10, 2);

        // products
        add_filter('manage_edit-products_columns', array( $this, 'columns_head_only_products'), 15);
        add_filter('manage_products_posts_custom_column', array( $this, 'columns_content_only_products'), 10, 2);

        // promocode
        add_filter('manage_edit-promocode_columns', array( $this, 'columns_head_only_promocode'), 15);
        add_filter('manage_promocode_posts_custom_column', array( $this, 'columns_content_only_promocode'), 10, 2);

        // letters
        add_filter('manage_edit-letter_columns', array( $this, 'columns_head_only_letter'), 15);
        add_filter('manage_letter_posts_custom_column', array( $this, 'columns_content_only_letter'), 10, 2);

        // partners
        add_filter('manage_edit-partner_columns', array( $this, 'columns_head_only_letter'), 15);
        add_filter('manage_partner_posts_custom_column', array( $this, 'columns_content_only_letter'), 10, 2);
    }

    /**
     * orders
     */
    public function columns_head_only_order($defaults) {
        unset($defaults['title']);
        unset($defaults['date']);
        $defaults['title'] = 'ID';
        $defaults['total'] = 'Замовлення';
        $defaults['shipping'] = 'Доставка';
        $defaults['payment'] = 'Оплата';
        $defaults['crm'] = 'Відправлено в CRM?';
        $defaults['status'] = 'Статус';
        $defaults['date'] = 'Дата';
        return $defaults;
    }

    public function columns_content_only_order($column_name, $post_ID) {
        // total
        if ($column_name == 'total') {
            $order_products = get_field('order_products', $post_ID);
            $order_promocode = get_field('order_promocode', $post_ID);
            $order_shipping = get_field('order_shipping', $post_ID);
            $order_total = get_field('order_total', $post_ID); // btn generate xml

            if(is_array($order_products) && count($order_products)){
                foreach($order_products as $li){
                    echo $li['product'] . ': ' . $li['quantity'] . ' x ' . $li['price'] . ' ' .  'грн<br>';
                }
            }

            echo 'Доставка: ' . $order_shipping . ' ' .  'грн<br>';
            if($order_promocode){
                echo 'Знижка: -' . get_field('order_discount', $post_ID) . ' ' .  'грн<br>';
            }
            echo '<b>Всього: ' . $order_total . ' ' .  'грн</b>';
        }
        // shipping
        elseif ($column_name == 'shipping') {
            echo '<b>' . get_field('order_phone', $post_ID) . '</b><br>';
            echo '<b>' . get_field('order_email', $post_ID) . '</b><br>';
            echo get_field('order_name', $post_ID) . '<br><br>';

            if(get_field('order_delivery', $post_ID) === 'variant_1'){
                echo 'у відділення Нової пошти: <br>';
                echo get_field('order_city', $post_ID) . '<br>' . get_field('order_department', $post_ID);
            }elseif(get_field('order_delivery', $post_ID) === 'variant_2'){
                echo 'кур’єрська доставка Нова пошта: <br>';
                echo get_field('order_city', $post_ID) . '<br>' . get_field('order_address', $post_ID);
            }else{
                echo 'самовивіз';
            }
        }
        // payment
        elseif ($column_name == 'payment') {
            $pay_statuses = array('no' => '<b style="color:#999">[не оплачено]</b>', 'error' => '<b style="color:#c7254e">[помилка оплати]</b>', 'success' => '<b style="color:#58bc00">[оплачено]</b>');

            if(get_field('order_payment', $post_ID) === 'variant_1'){
                echo 'онлайн оплата<br>';
            }
            echo $pay_statuses[get_field('order_payment_status', $post_ID)];
            echo (get_field('order_payment_info', $post_ID) ? '<br>' . get_field('order_payment_info', $post_ID) : '');
        }
        // crm
        elseif ($column_name == 'crm') {
            echo get_field('order_keycrm_id', $post_ID) ? '<div class="ws_icon_image icon16 dashicons dashicons-yes"></div>' : '-';
        }
        // status
        elseif ($column_name == 'status') {
            echo '<strong>' . str_ireplace(['new', 'sent', 'completed', 'canceled'], ['нове', 'відправлене', 'виконане', 'скасоване'], get_post_status($post_ID)) . '</strong>';
        }
    }

    /**
     * products
     */
    public function columns_head_only_products($defaults) {
        unset($defaults['title']);
        unset($defaults['date']);
        $defaults['img'] = 'Фото';
        $defaults['title'] = 'Назва продукту';
        $defaults['price'] = 'Ціна / формат';
        $defaults['volume'] = 'Об\'єм';
        $defaults['date'] = 'Дата';
        return $defaults;
    }

    public function columns_content_only_products($column_name, $post_ID) {
        // image
        if ($column_name == 'img') {
            $img = get_field('img', $post_ID);
            echo (is_array($img) ? "<img src='" . $img['sizes']['100x100'] . "'>" : "-");
        }
        // price
        elseif ($column_name == 'price') {
            $list = get_field('price'); if(is_array($list) && count($list)){
                foreach ($list as $m => $li){
                    if($li['format'] || $li['price']){
                        echo $li['format'] === 'glass' ? 'скляна пляшка' : 'жерстяна банка';
                        if($li['price']){
                            echo ' - ' . ($li['old_price'] ? '<s>' . $li['old_price'] . ' грн</s> ' : '') . '<b>' . $li['price'] . ' грн</b>';
                        }
                        echo '<br>';
                    }
                }
            }else{
                echo '-';
            }
        }
        // volume
        elseif ($column_name == 'volume') {
            echo get_field('volume', $post_ID);
        }
    }

    /**
     * promocode
     */
    public function columns_head_only_promocode($defaults) {
        unset($defaults['title']);
        unset($defaults['date']);
        $defaults['title'] = 'Промокод';
        $defaults['type'] = 'Тип промокоду';
        $defaults['discount'] = 'Знижка';
        $defaults['until'] = 'Дата, до якої діє';
        $defaults['used'] = 'Вже використаний?';
        $defaults['date'] = 'Дата';
        return $defaults;
    }

    public function columns_content_only_promocode($column_name, $post_ID) {
        // type
        if ($column_name == 'type') {
            $type = get_field('type', $post_ID);
            if($type === 'sum'){
                echo 'на фіксовану суму';
            }elseif($type === 'percent'){
                echo 'на % знижки від суми';
            }
        }
        // discount
        elseif ($column_name == 'discount') {
            $type = get_field('type', $post_ID);
            if($type === 'sum'){
                echo get_field('sum', $post_ID) . ' грн';
            }elseif($type === 'percent'){
                echo get_field('percent', $post_ID) . ' %';
            }
        }
        // until
        elseif ($column_name == 'until') {
            $date = get_field('date', $post_ID);
            echo $date ? mb_substr($date, 6, 2) . '.' . mb_substr($date, 4, 2) . '.' . mb_substr($date, 0, 4): '-';
        }
        // used
        elseif ($column_name == 'used') {
            echo get_field('used', $post_ID) ? '<div class="ws_icon_image icon16 dashicons dashicons-yes"></div>' : '-';
        }
    }

    /**
     * letter
     */
    public function columns_head_only_letter($defaults) {
        unset($defaults['title']);
        unset($defaults['date']);
        $defaults['title'] = __( 'ID', \PS::$theme_name );
        $defaults['name'] = __( 'ім’я', \PS::$theme_name );
        $defaults['phone'] = __( 'Телефон', \PS::$theme_name );
        $defaults['email'] = __( 'E-mail', \PS::$theme_name );
        $defaults['date'] = __( 'Дата', \PS::$theme_name );
        return $defaults;
    }

    public function columns_content_only_letter($column_name, $post_ID) {
        // name
        if ($column_name == 'name') {
            echo get_field('name', $post_ID);
        }
        // phone
        elseif ($column_name == 'phone') {
            echo get_field('phone', $post_ID);
        }
        // email
        elseif ($column_name == 'email') {
            echo get_field('email', $post_ID);
        }
    }

}