<?php

namespace PS\Functions\Post_Types;

/**
 * Class Order
 * @package PS\Functions\Post_Types
 */
class Order {

    /**
     * constructor
     */
    public function __construct() {
        // post type
        add_action( 'init', array( $this, 'register_post_type' ) );
        // post status
        add_action( 'init', array( $this, 'register_post_status' ) );
        // select for statuses
        add_action( 'admin_footer-post.php', array( $this, 'post_status_list' ) );
        // filtering fix
        add_action( 'pre_get_posts', array( $this, 'query' ) );
        //
        add_action( 'admin_menu', array( $this, 'count_new_post' ) );
    }

    /**
     * post type
     */
    public function register_post_type() {
        if ( post_type_exists( 'order' ) ) {
            return;
        }

        $labels = array(
            'name'     => 'Замовлення',
            'add_new'  => 'Додати замовлення',
            'new_item' => 'Нове замовлення'
        );

        $args = array(
            'labels'              => $labels,
            'show_ui'             => true,
            'public'              => false,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'hierarchical'        => false,
            'query_var'           => false,
            'supports'            => array( 'title' ),
            'has_archive'         => false
        );

        register_post_type( 'order', $args );
    }

    /**
     * post status
     */
    public function register_post_status() {

        $order_statuses = array(
            'new'        => array(
                'label'                     =>  'Нове',
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( '<i class="fa-light fa-bag-shopping"></i> Нові <span class="count">(%s)</span>', '<i class="far fa-shopping-cart"></i> Нові <span class="count">(%s)</span>')
            ),
            'sent'       => array(
                'label'                     =>  'Відправлене',
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( '<i class="fa-light fa-truck"></i> Відправлені <span class="count">(%s)</span>', '<i class="far fa-truck"></i> Відправлені <span class="count">(%s)</span>')
            ),
            'completed'  => array(
                'label'                     =>  'Виконане',
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( '<i class="fa-solid fa-check"></i> Виконані <span class="count">(%s)</span>', '<i class="far fa-check"></i> Виконані <span class="count">(%s)</span>')
            ),
            'canceled'   => array(
                'label'                     =>  'Скасоване',
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( '<i class="fa-solid fa-xmark"></i> Скасовані <span class="count">(%s)</span>', '<i class="far fa-times"></i> Скасовані <span class="count">(%s)</span>')
            )
        );

        foreach ( $order_statuses as $order_status => $values ) {
            register_post_status( $order_status, $values );
        }
    }

    /**
     * select for statuses
     */
    function post_status_list() {
        global $post;

        $optionselected = '';
        $statusname     = '';

        if ( $post->post_type == 'order' ) {
            if ( $post->post_status == 'new' ) {
                $optionselected = ' selected="selected"';
                $statusname     = "$('#post-status-display').text('Нове');";
            } elseif ( $post->post_status == 'sent' ) {
                $optionselected = ' selected="selected"';
                $statusname     = "$('#post-status-display').text('Відправлене');";
            } elseif ( $post->post_status == 'completed' ) {
                $optionselected = ' selected="selected"';
                $statusname     = "$('#post-status-display').text('Виконане');";
            } elseif ( $post->post_status == 'canceled' ) {
                $optionselected = ' selected="selected"';
                $statusname     = "$('#post-status-display').text('Скасоване');";
            }

            ?>

            <script>
                jQuery(function ($) {
                    jQuery('input#publish').attr('name', 'save').val('<?php echo 'Оновити'; ?>');
                    jQuery('select#post_status option').remove();
                    jQuery('select#post_status')
                        .append('<option value="new"<?php echo $post->post_status == 'new' ? $optionselected : ''; ?>><?php echo 'Нове'; ?></option>')
                        .append('<option value="sent"<?php echo $post->post_status == 'sent' ? $optionselected : ''; ?>><?php echo 'Відправлене'; ?></option>')
                        .append('<option value="completed"<?php echo $post->post_status == 'completed' ? $optionselected : ''; ?>><?php echo 'Виконане'; ?></option>')
                        .append('<option value="canceled"<?php echo $post->post_status == 'canceled' ? $optionselected : ''; ?>><?php echo 'Скасоване'; ?></option>');
                    <?php echo $statusname; ?>
                });
            </script>

            <?php
        }
    }

    /**
     * filtering fix
     */
    public function query( $query ) {
        if ( is_admin() && $query->is_main_query() ) {
            if ( $query->query['post_type'] == 'order' && ! isset( $_GET['post_status'] ) ) {
                $query->set( 'post_status', array(
                    'new',
                    'sent',
                    'completed',
                    'canceled'
                ) );
            }
        }
    }

    /**
     * Добавить в меню количество новых результатов
     */
    public function count_new_post() {
        global $menu, $wpdb;
        $count = $wpdb->get_var( "SELECT COUNT(ID) FROM {$wpdb->posts} WHERE post_type = 'order' and post_status = 'new'" );
        foreach ($menu as $key => $item) {
            if ($item[2] == 'edit.php?post_type=order') {
                $menu[$key][0] .= " <span class='awaiting-mod count-{$count}'><span class='pending-count'>{$count}</span></span>";
            }
        }
    }

}