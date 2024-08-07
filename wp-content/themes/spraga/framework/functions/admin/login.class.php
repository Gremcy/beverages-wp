<?php

namespace PS\Functions\Admin;

/**
 * Class Login
 * @package PS\Functions\Admin
 */
class Login {

    /**
     * constructor
     */
    public function __construct() {
        add_action( 'login_enqueue_scripts', array( $this, 'custom_login_logo' ) );
        add_filter( 'login_headerurl', array( $this, 'my_login_logo_url' ) );
        add_filter( 'login_headertext', array( $this, 'my_login_logo_url_title' ) );
    }

    /**
     * Логотип при входе в админку
     */
    public function custom_login_logo() { ?>
        <style>
            #login h1 a {
                width: 150px;
                height: 150px;
                background-image: url('<?php echo \PS::$assets_url; ?>images/admin/madeby.png');
                background-size: 150px 150px;
                margin-bottom: 40px;
            }
        </style>
    <?php }

    /**
     * Ссылка с логотипа
     */
    public function my_login_logo_url() {
        return '';
    }

    /**
     * Подпись логотипа
     */
    public function my_login_logo_url_title() {
        return '';
    }
}