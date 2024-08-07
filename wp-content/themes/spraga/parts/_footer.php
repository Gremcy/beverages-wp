<?php if (!defined('ABSPATH')){exit;} ?>

<footer class="footer">
    <div class="footer-inner">
        <div class="footer-logo">
            <img src="<?php echo \PS::$assets_url; ?>images/logo3.svg" alt="" loading="lazy">
        </div>
        <div class="footer-right">
            <?php $list = get_field('footer_menu', \PS::$option_page); if(is_array($list) && count($list)): ?>
                <div class="footer-right-menu">
                    <?php foreach ($list as $li): ?>
                        <a href="<?php echo $li['link']; ?>" class="footer-right-menu-item"<?php if(!str_contains($li['link'], site_url())): ?> target="_blank" <?php endif; ?>><?php echo $li['text']; ?></a>
                    <?php endforeach; ?>
                    <?php $field = get_field('footer_order_text', \PS::$option_page); $file = get_field('order_file', \PS::$option_page); if($file && $field): ?>
                        <a href="<?php echo $file; ?>" class="footer-right-menu-item" target="_blank"><?php echo $field; ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="footer-right-contact">
                <?php $text = get_field('address_title', \PS::$option_page); if($text): ?>
                    <div class="footer-right-contact-title"><?php echo $text; ?></div>
                <?php endif; ?>
                <?php $text = get_field('address_text', \PS::$option_page); if($text): ?>
                    <div class="footer-right-contact-address"><?php echo str_ireplace('<br />', '</div><div class="footer-right-contact-address">', $text); ?></div>
                <?php endif; ?>
                <?php $text = get_field('email', \PS::$option_page); if($text): ?>
                    <a href="mailto:<?php echo $text; ?>" class="footer-right-contact-email"><?php echo $text; ?></a>
                <?php endif; ?>

                <div class="footer-right-contact-social">
                    <?php $text = get_field('fb', \PS::$option_page); if($text): ?>
                        <a href="<?php echo $text; ?>" target="_blank">
                            <img src="<?php echo \PS::$assets_url; ?>images/fb2.svg" alt="" loading="lazy">
                        </a>
                    <?php endif; ?>
                    <?php $text = get_field('in', \PS::$option_page); if($text): ?>
                        <a href="<?php echo $text; ?>" target="_blank">
                            <img src="<?php echo \PS::$assets_url; ?>images/insta2.svg" alt="" loading="lazy">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-gremcy">
        <span><?php _e( 'Розроблено', \PS::$theme_name ); ?> </span>
        <a href="https://gremcy.com" target="_blank">Gremcy</a>
    </div>
</footer>