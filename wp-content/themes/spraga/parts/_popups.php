<?php if (!defined('ABSPATH')){exit;} ?>

<div class="menu-overlay"></div>

<div class="menu-wrapper">
    <div class="menu-close js-menu-close">
        <img src="<?php echo \PS::$assets_url; ?>images/close.svg" alt="" loading="lazy">
    </div>

    <div class="menu-overlay"></div>

    <div class="menu-content">
        <div class="menu-logo">
            <img src="<?php echo \PS::$assets_url; ?>images/logo1.svg" alt="" loading="lazy">
        </div>

        <?php $list = get_field('header_menu', \PS::$option_page); if(is_array($list) && count($list)): ?>
            <div class="menu-links">
                <?php foreach ($list as $li): ?>
                    <a href="<?php echo $li['link']; ?>" class="menu-links-item"><?php echo $li['text']; ?></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php $languages = \PS\Functions\Plugins\Qtranslate::get_languages(); if(is_array($languages) && count($languages) > 1): ?>
            <div class="menu-langs">
                <?php foreach ($languages as $m => $language): ?>
                    <a href="<?php echo $language['url']; ?>" class="menu-langs-item<?php if($language['active']): ?> active<?php endif; ?>"><?php echo $language['name']; ?></a>
                    <?php if($m === 0): ?>
                        <div class="menu-langs-separator">/</div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="menu-social">
            <?php $text = get_field('fb', \PS::$option_page); if($text): ?>
                <a href="<?php echo $text; ?>" class="menu-social-item" target="_blank">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_701_680)"><rect x="1.12903" y="1.12903" width="25.7419" height="25.7419" rx="5.87097" stroke="#231F20" stroke-width="2.25806"/><path d="M14.79 15.0043V22.4001H11.6329V15.0043H8.68628V11.9439H11.6329V9.64867C11.6329 7.01471 13.3956 5.6001 15.9826 5.6001C17.2236 5.6001 18.3022 5.65987 18.6136 5.69573V8.1185H16.7895C15.3819 8.1185 14.79 9.07486 14.79 9.96746V11.9439H18.4732L18.0523 15.0043H14.79Z" fill="#231F20"/></g><defs><clipPath id="clip0_701_680"><rect width="28" height="28" fill="white"/></clipPath></defs></svg>
                </a>
            <?php endif; ?>
            <?php $text = get_field('in', \PS::$option_page); if($text): ?>
                <a href="<?php echo $text; ?>" class="menu-social-item" target="_blank">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_701_683)"><path d="M7.7777 -0.000732422C2.70971 -0.000732422 -0.000244141 2.33265 -0.000244141 7.77721V20.2219C-0.000244141 25.6665 2.70971 27.9998 7.7777 27.9998H20.2224C25.667 27.9998 28.0003 25.6665 28.0003 20.2219V7.77721C28.0003 2.33265 25.667 -0.000732422 20.2224 -0.000732422H7.7777ZM7.7777 2.39932H20.2224C24.5003 2.39932 25.6003 5.20427 25.6003 7.77721V20.2219C25.6003 22.7949 23.9169 25.5998 20.2224 25.5998H7.7777C4.66652 25.5998 2.39981 23.9352 2.39981 20.0275V7.58276C2.39981 5.00982 4.08317 2.39932 7.7777 2.39932ZM21.3224 4.9272C20.9098 4.9272 20.5141 5.0911 20.2224 5.38283C19.9307 5.67455 19.7668 6.07022 19.7668 6.48279C19.7668 6.89536 19.9307 7.29103 20.2224 7.58276C20.5141 7.87449 20.9098 8.03838 21.3224 8.03838C21.7349 8.03838 22.1306 7.87449 22.4223 7.58276C22.7141 7.29103 22.878 6.89536 22.878 6.48279C22.878 6.07022 22.7141 5.67455 22.4223 5.38283C22.1306 5.0911 21.7349 4.9272 21.3224 4.9272ZM14 6.22162C9.71129 6.22162 6.22211 9.7108 6.22211 13.9996C6.22211 18.2883 9.71129 21.7775 14 21.7775C18.2888 21.7775 21.778 18.2883 21.778 13.9996C21.778 9.7108 18.2888 6.22162 14 6.22162ZM14 9.03197C16.573 9.03197 18.9678 11.1298 18.9678 13.9996C18.9678 16.8693 16.573 18.9674 14 18.9674C11.4271 18.9674 9.03229 17.1607 9.03229 13.9996C9.03229 10.8384 11.4271 9.03197 14 9.03197Z" fill="#231F20"/></g><defs><clipPath id="clip0_701_683"><rect width="28" height="28" fill="white"/></clipPath></defs></svg>
                </a>
            <?php endif; ?>
        </div>

        <?php if(!is_page(\PS::$pages['checkout'])): ?>
            <div class="menu-cart">
                <div class="menu-cart-quantity ajax-loading-of-cart-quantity"><?php echo \PS\Functions\Shop\Cart::get_quantity_in_cart(); ?></div>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none"><path d="M13.8194 28.988C15.0621 28.988 16.0696 27.9806 16.0696 26.7379C16.0696 25.4952 15.0621 24.4878 13.8194 24.4878C12.5767 24.4878 11.5693 25.4952 11.5693 26.7379C11.5693 27.9806 12.5767 28.988 13.8194 28.988Z" fill="#231F20"/><path d="M23.2159 28.988C24.4586 28.988 25.466 27.9806 25.466 26.7379C25.466 25.4952 24.4586 24.4878 23.2159 24.4878C21.9732 24.4878 20.9658 25.4952 20.9658 26.7379C20.9658 27.9806 21.9732 28.988 23.2159 28.988Z" fill="#231F20"/><path d="M1.43346 6.36427C3.49747 6.36427 5.56148 6.36427 7.62548 6.36427C7.24551 6.07482 6.86554 5.7857 6.48557 5.49625C8.04328 10.9378 9.60134 16.3793 11.1591 21.8209C11.304 22.3271 11.769 22.6889 12.299 22.6889C16.4635 22.6889 20.6276 22.6889 24.7921 22.6889C25.3406 22.6889 25.7628 22.3234 25.932 21.8209C27.1712 18.1431 28.4105 14.4653 29.6497 10.7875C29.8976 10.0515 29.2454 9.29124 28.5098 9.29124C22.036 9.29124 15.5627 9.29124 9.08897 9.29124C7.56435 9.29124 7.56435 11.6555 9.08897 11.6555C15.5627 11.6555 22.036 11.6555 28.5098 11.6555C28.1298 11.1566 27.7498 10.6578 27.3698 10.1593C26.1306 13.8371 24.8914 17.5148 23.6522 21.1926C24.0322 20.9032 24.4121 20.6141 24.7921 20.3246C20.6276 20.3246 16.4635 20.3246 12.299 20.3246C12.6789 20.6141 13.0589 20.9032 13.4389 21.1926C11.8812 15.7511 10.3231 10.3096 8.7654 4.86802C8.6205 4.3614 8.15576 4 7.62582 4C5.56181 4 3.49781 4 1.4338 4C-0.0911573 4 -0.0911573 6.36427 1.43346 6.36427Z" fill="#231F20"/></svg>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if(!is_page(\PS::$pages['checkout'])): ?>
    <div class="cart-wrapper ajax-loading-of-cart">
        <div class="cart-overlay"></div>
        <div class="cart-content">
            <div class="cart-top">
                <div class="cart-top-name"><?php _e( 'Кошик', \PS::$theme_name ); ?></div>
                <div class="cart-close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38" fill="none"><rect x="7.98633" y="29.2266" width="29.8747" height="1.17927" rx="0.589633" transform="rotate(-45 7.98633 29.2266)" fill="#231F20"/><rect x="8.82031" y="8" width="29.8747" height="1.17927" rx="0.589633" transform="rotate(45 8.82031 8)" fill="#231F20"/></svg>
                </div>
            </div>
            <?php get_template_part('parts/elements/cart', null, ['is_checkout' => false]); ?>
        </div>
    </div>
<?php endif; ?>