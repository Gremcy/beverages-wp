<?php

namespace PS\Functions\Seo;

/**
 * Class Rewrite
 * @package PS\Functions\Seo
 */
class Rewrite {

    /**
     * constructor
     */
    public function __construct() {
        // query_vars
        add_filter( 'query_vars', array( $this, 'add_query_vars_filter') );

        // rewrite
        add_action('init', array( $this, 'custom_rewrite_rule' ), 10, 0);
    }

    /**
     * query vars
     */
    public function add_query_vars_filter( $vars ) {
        $vars[] = 'section';

        // return
        return $vars;
    }

    /**
     * Правила перезаписи
     */
    public function custom_rewrite_rule() {
        // blog
        add_rewrite_rule('^blog/filter/([^/]*)/page/([^/]*)/?$','index.php?page_id=' . \PS::$pages['blog'] . '&section=$matches[1]&paged=$matches[2]','top');
        add_rewrite_rule('^blog/filter/([^/]*)/?$','index.php?page_id=' . \PS::$pages['blog'] . '&section=$matches[1]','top');
        add_rewrite_rule('^blog/page/([^/]*)/?$','index.php?page_id=' . \PS::$pages['blog'] . '&paged=$matches[1]','top');
    }
}