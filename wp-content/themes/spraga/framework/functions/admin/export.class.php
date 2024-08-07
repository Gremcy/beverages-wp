<?php

namespace PS\Functions\Admin;

/**
 * Class Export
 * @package PS\Functions\Admin
 */
class Export {

    /**
     * constructor
     */
    public function __construct() {
        // buttons
        add_action('restrict_manage_posts', array($this, 'export_button'));

        // xls
        add_action('init', array($this, 'lets_export'));
    }

    /**
     * buttons
     */
    public function export_button() {
        global $pagenow;
        if (is_admin() && $pagenow === 'edit.php') {
            $post_type = isset($_GET['post_type']) ? sanitize_text_field($_GET['post_type']) : '';

            if ($post_type === 'order') {
                $xml_content = $this->generate_orders_xml();
                $dom = new \DOMDocument();
                $dom->loadXML($xml_content);
                $dom->formatOutput = true;
                $formattedXML = $dom->saveXML();

                $xml_file_path = ABSPATH . 'wp-content/uploads/orders_export.xml';
                file_put_contents($xml_file_path, $formattedXML);

                echo '<div class="alignleft actions">';
                echo '<a href="' . home_url('/wp-content/uploads/orders_export.xml') . '" id="export_posts" class="button" style="background: #0071A1; color: #F3F5F6" download>Експорт в XML</a>';
                echo '</div>';
            }elseif($post_type === 'promocode'){
                echo '<div class="alignleft actions" style="float: right">';
                echo '<a href="/wp-admin/edit.php?post_type=' . $_GET['post_type'] . '&export=1" id="export_posts" class="button" style="background: #0071a1; color: #f3f5f6">Експорт в XLS</a>';
                echo '</div>';
            }
        }
    }

    /**
     * XML
     */
    private function generate_orders_xml() {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><orders></orders>');

        global $wp_query;
        \PS\Functions\Helper\Helper::get_orders();
        $custom_query = $wp_query;
        if ($custom_query->have_posts()) {
            while ($custom_query->have_posts()) {
                $custom_query->the_post();

                $k = 1;
                $id = get_the_ID();
                $date = get_the_time('d.m.Y H:i', $id);
                $order_products = get_field('order_products', $id);
                $order_shipping = \PS\Functions\Shop\Helper::format_price(get_field('order_shipping', $id));
                $order_promocode = get_field('order_promocode', $id);
                $order_discount = \PS\Functions\Shop\Helper::format_price(get_field('order_discount', $id));
                $order_total = \PS\Functions\Shop\Helper::format_price(get_field('order_total', $id));

                if (is_array($order_products) && count($order_products)) {
                    // calc discount for each product (except special products)
                    $discount_quantity = 0;
                    $discount_total = 0;
                    $help_total = 0;
                    $discount_per_uah = 0;
                    if($order_discount){
                        foreach ($order_products as $product) {
                            if(!$product['old_price']){
                                $discount_total += ($product['quantity'] * $product['price']);
                                $discount_quantity++;
                            }
                        }
                        $discount_per_uah = \PS\Functions\Shop\Helper::format_price($order_discount / $discount_total);
                    }
                    // end calc

                    $orderElement = $xml->addChild('order');
                    $orderElement->addChild('id', $id);
                    $orderElement->addChild('date', $date);

                    $productsElement = $orderElement->addChild('products');
                    foreach ($order_products as $product) {
                        $productElement = $productsElement->addChild('product');
                        $productElement->addChild('sku', $product['product_sku']);
                        $productElement->addChild('name', $product['product']);
                        $productElement->addChild('quantity', $product['quantity']);
                        $productElement->addChild('price', $product['price']);
                        if($order_discount && !$product['old_price']){
                            if($k === $discount_quantity){
                                $productElement->addChild('discount', \PS\Functions\Shop\Helper::format_price(($order_discount - $help_total) / $product['quantity']));
                            }else {
                                $product_discount = \PS\Functions\Shop\Helper::format_price($product['price'] * $discount_per_uah);
                                $productElement->addChild('discount', $product_discount);
                                $help_total += $product_discount * $product['quantity'];
                            }
                            $k++;
                        }else{
                            $productElement->addChild('discount', 0);
                        }
                    }

                    $orderElement->addChild('shipping', $order_shipping);
                    $orderElement->addChild('promocode', $order_promocode);
                    $orderElement->addChild('total', $order_total);
                    $orderElement->addChild('phone', get_field('order_phone', $id));
                    $orderElement->addChild('email', get_field('order_email', $id));
                    $orderElement->addChild('name', get_field('order_name', $id));
                    $orderElement->addChild('delivery', str_ireplace(['variant_1', 'variant_2', 'variant_3'], ['у відділення Нової пошти', 'кур’єрська доставка Нова пошта', 'самовивіз'], get_field('order_delivery', $id)));
                    $orderElement->addChild('city', get_field('order_city', $id));
                    $orderElement->addChild('department', get_field('order_department', $id));
                    $orderElement->addChild('address', get_field('order_address', $id));
                    $orderElement->addChild('payment', str_ireplace(['variant_1'], ['онлайн оплата'], get_field('order_payment', $id)));
                    $orderElement->addChild('payment_status', str_ireplace(['no', 'error', 'success'], ['не оплачено', 'помилка оплати', 'успішно оплачено'], get_field('order_payment_status', $id)));
                    $orderElement->addChild('payment_info', get_field('order_payment_info', $id));
                    $orderElement->addChild('status', str_ireplace(['new', 'sent', 'completed', 'canceled'], ['нове', 'відправлене', 'виконане', 'скасоване'], get_post_status($id)));
                }
            }
        }
        wp_reset_query();

        return $xml->asXML();
    }

    /**
     * XLS
     */
    public function lets_export(){
        if ( is_admin() && isset($_GET['export']) && isset($_GET['post_type'])) {
            global $wpdb;
            require_once \PS::$framework_path . '/lib/phpspreadsheet/autoload.php';

            $title = '';
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // promocode
            if ($_GET['post_type'] === 'promocode') {
                $title = 'Промокоди';

                $sheet
                    ->setCellValue('A1', 'Промокод')
                    ->setCellValue('B1', 'Тип промокоду')
                    ->setCellValue('C1', 'Знижка')
                    ->setCellValue('D1', 'Дата, до якої діє')
                    ->setCellValue('E1', 'Вже використаний?')
                    ->setCellValue('F1', 'Дата створення');

                // get posts
                $posts = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_type = '{$_GET['post_type']}' AND post_status = 'publish' ORDER BY ID ASC" );
                if ( is_array($posts) && count($posts) ){
                    $n = 2;
                    foreach ($posts as $post_id) {
                        $sheet->setCellValueExplicit('A' . $n, get_the_title( $post_id ), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                        $type = get_field('type', $post_id);
                        if($type === 'sum'){
                            $sheet->setCellValueExplicit('B' . $n, 'на фіксовану суму', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        }elseif($type === 'percent'){
                            $sheet->setCellValueExplicit('B' . $n, 'на % знижки від суми', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        }

                        if($type === 'sum'){
                            $sheet->setCellValueExplicit('C' . $n, get_field('sum', $post_id) . ' грн', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        }elseif($type === 'percent'){
                            $sheet->setCellValueExplicit('C' . $n, get_field('percent', $post_id) . ' %', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        }

                        $date = get_field('date', $post_id);
                        $sheet->setCellValueExplicit('D' . $n, $date ? mb_substr($date, 6, 2) . '.' . mb_substr($date, 4, 2) . '.' . mb_substr($date, 0, 4): '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                        $sheet->setCellValueExplicit('E' . $n, get_field('used', $post_id) ? 'так' : '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->setCellValueExplicit('F' . $n, get_the_time('d.m.Y H:i', $post_id), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                        $n++;
                    }
                }
            }

            // Rename worksheet
            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle($title);
            $spreadsheet->getActiveSheet()->getStyle('A1:Z1000')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            foreach (range('A', 'Z') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }
            $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="spraga_' . $_GET['post_type'] . '_' . current_time('dmY') . '.xlsx"');
            header('Cache-Control: max-age=0');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        }
    }

}