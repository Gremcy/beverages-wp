<?php if (!defined('ABSPATH')){exit;} ?>

<?php $cart = \PS\Functions\Shop\Cart::get_cart(); if(is_array($cart) && count($cart)): ?>

    <div class="cart-goods cart-products show">
        <?php foreach($cart as $info): ?>
            <div class="cart-goods-item">
                <?php $img = get_field('img', $info['product_id']); if(is_array($img) && count($img)): ?>
                    <a href="<?php echo get_the_permalink($info['product_id']); ?>" class="cart-goods-item-left">
                        <img src="<?php echo $img['sizes']['960x0']; ?>" alt="" loading="lazy">
                    </a>
                <?php endif; ?>

                <div class="cart-goods-item-right">
                    <div class="cart-goods-item-right-top">
                        <div class="cart-goods-item-right-top-text">
                            <a href="<?php echo get_the_permalink($info['product_id']); ?>" class="cart-goods-item-right-top-text-name"><?php echo get_the_title($info['product_id']); ?></a>
                            <?php if(get_post_meta($info['product_id'], 'price_' . $info['variant_id'] . '_format', true) === 'glass'): ?>
                                <div class="cart-goods-item-right-top-text-pack"><?php _e( 'скляна пляшка', \PS::$theme_name ); ?></div>
                            <?php else: ?>
                                <div class="cart-goods-item-right-top-text-pack"><?php _e( 'жерстяна банка', \PS::$theme_name ); ?></div>
                            <?php endif; ?>
                        </div>
                        <a href="javascript:void(0)" class="cart-goods-item-right-top-del-btn operations_in_cart" data-operation="remove" data-product_id="<?php echo $info['product_id']; ?>" data-variant_id="<?php echo $info['variant_id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none"><rect x="0.493164" y="11.1133" width="14.9374" height="1.2" rx="0.6" transform="rotate(-45 0.493164 11.1133)" fill="#787878"/><rect x="0.910156" y="0.5" width="14.9374" height="1.2" rx="0.6" transform="rotate(45 0.910156 0.5)" fill="#787878"/></svg>
                        </a>
                    </div>
                    <div class="cart-goods-item-right-container"><?php _e( 'Ящик', \PS::$theme_name ); ?> <span>(12 <?php _e( 'шт', \PS::$theme_name ); ?><?php $text = get_field('volume', $info['product_id']); if($text): ?> х <?php echo $text; ?><?php endif; ?>)</span></div>
                    <div class="cart-goods-item-right-down">
                        <div class="cart-goods-item-right-down-quantity">
                            <div class="cart-goods-item-right-down-quantity-minus operations_in_cart" data-operation="minus" data-product_id="<?php echo $info['product_id']; ?>" data-variant_id="<?php echo $info['variant_id']; ?>">
                                <img src="<?php echo \PS::$assets_url; ?>images/minus.svg" alt="">
                            </div>
                            <div class="cart-goods-item-right-down-quantity-num"><?php echo $info['quantity']; ?></div>
                            <div class="cart-goods-item-right-down-quantity-plus operations_in_cart" data-operation="plus" data-product_id="<?php echo $info['product_id']; ?>" data-variant_id="<?php echo $info['variant_id']; ?>">
                                <img src="<?php echo \PS::$assets_url; ?>images/plus.svg" alt="">
                            </div>
                        </div>
                        <div class="cart-goods-item-right-down-price-wrapper">
                            <?php $old_price = \PS\Functions\Shop\Helper::format_price(get_post_meta($info['product_id'], 'price_' . $info['variant_id'] . '_old_price', true)); if($old_price): ?>
                                <div class="cart-goods-item-right-down-price-action show">
                                    <span class="action-old-price"><?php echo $old_price; ?> <?php _e( 'грн', \PS::$theme_name ); ?></span>
                                    <span class="action-new-price"><?php echo \PS\Functions\Shop\Helper::format_price(get_post_meta($info['product_id'], 'price_' . $info['variant_id'] . '_price', true)); ?> <?php _e( 'грн', \PS::$theme_name ); ?></span>
                                </div>
                            <?php else: ?>
                                <div class="cart-goods-item-right-down-price show"><?php echo \PS\Functions\Shop\Helper::format_price(get_post_meta($info['product_id'], 'price_' . $info['variant_id'] . '_price', true)); ?> <?php _e( 'грн', \PS::$theme_name ); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if(isset($args['is_checkout']) && $args['is_checkout']): ?>
        <?php /* nothing */ ?>
    <?php else: ?>
        <div class="cart-down">
            <div class="cart-down-top">
                <div class="cart-down-top-text"><?php _e( 'Всього', \PS::$theme_name ); ?>:</div>
                <div class="cart-down-top-price"><?php echo \PS\Functions\Shop\Cart::get_sum_in_cart($cart); ?> <?php _e( 'грн', \PS::$theme_name ); ?></div>
            </div>
            <a href="<?php echo get_the_permalink(\PS::$pages['checkout']); ?>" class="cart-down-btn"><?php _e( 'купити', \PS::$theme_name ); ?></a>
            <a href="<?php echo get_the_permalink(\PS::$pages['products']); ?>" class="cart-down-continue"><?php _e( 'продовжити покупки', \PS::$theme_name ); ?></a>
        </div>
    <?php endif; ?>

<?php else: ?>

    <?php if(isset($args['is_checkout']) && $args['is_checkout']): ?>
        <div class="order-empty show">
            <div class="order-empty-title"><?php _e( 'На жаль, кошик порожній', \PS::$theme_name ); ?></div>
            <div class="order-empty-text"><?php _e( 'Поверніться до товарів і додайте їх в кошик.', \PS::$theme_name ); ?></div>
            <a href="<?php echo get_the_permalink(\PS::$pages['products']); ?>" class="order-empty-btn"><?php _e( 'в магазин', \PS::$theme_name ); ?></a>
        </div>
    <?php else: ?>
        <div class="cart-empty-text show"><?php _e( 'На жаль, кошик порожній', \PS::$theme_name ); ?></div>
    <?php endif; ?>

<?php endif; ?>