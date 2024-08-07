<?php get_header(); ?>

<body class="product-page">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3387M6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="fluid-wrapper">
        <main class="product-main">
            <?php get_template_part('parts/_header'); ?>

            <?php if(get_field('active_2')): ?>
                <div class="product-first">
                    <?php $list = get_field('imgs'); if(is_array($list) && count($list)): ?>
                        <div class="product-first-left">
                            <div class="product-first-slider-wrapper">
                                <div class="product-first-slider-arrows">
                                    <div class="slick-prev">
                                        <img src="<?php echo \PS::$assets_url; ?>images/arr1.svg" alt="" loading="lazy">
                                    </div>
                                    <div class="slick-next">
                                        <img src="<?php echo \PS::$assets_url; ?>images/arr2.svg" alt="" loading="lazy">
                                    </div>
                                </div>
                                <div class="product-first-slider">
                                    <?php foreach ($list as $li): ?>
                                        <div class="product-first-slider-item">
                                            <img src="<?php echo $li['sizes']['960x0']; ?>" alt="" loading="lazy">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="product-first-right">
                        <div class="product-first-right-center">
                            <h1 class="product-first-right-name"><?php echo mb_strtolower(get_the_title()); ?></h1>

                            <div class="product-first-right-about">
                                <?php $text = get_field('subtitle_2'); if($text): ?><?php echo $text; ?><?php endif; ?>
                                <?php $text = get_field('color_2'); if($text): ?>
                                    <div class="product-first-right-about-circle" style="background: <?php echo $text; ?>"></div>
                                <?php endif; ?>
                            </div>

                            <?php $text = get_field('text_2'); if($text): ?>
                                <div class="product-first-right-description"><?php echo $text; ?></div>
                            <?php endif; ?>


                            <?php
                            $text_1 = get_field('title_3_1');
                            $text_2 = get_field('title_3_2');
                            $text_3 = get_field('text_3');
                            if($text_1 || $text_2 || $text_3): ?>
                                <div class="product-first-right-bottom">
                                    <div class="product-first-right-bottom-probiotik">
                                        <?php if($text_1): ?>
                                            <span><?php echo $text_1; ?></span>
                                        <?php endif; ?>

                                        <?php if($text_2): ?>
                                            <img src="<?php echo \PS::$assets_url; ?>images/arr3.svg" alt="" loading="lazy">
                                            <span><?php echo $text_2; ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if($text_3): ?>
                                        <div class="product-first-right-bottom-save"><?php echo $text_3; ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php $prices = get_field('price'); if(is_array($prices) && count($prices)): ?>
                                <div class="product-first-right-btns">
                                    <?php foreach ($prices as $n => $li): ?>
                                        <div class="product-first-right-btns-el<?php if(\PS\Functions\Shop\Helper::has_price(get_the_ID())): ?> has-price<?php if($n === 0): ?> active<?php endif; ?><?php endif; ?>" data-id="<?php echo $n; ?>"><?php if($li['format'] === 'glass'): ?><?php _e( 'скляна пляшка', \PS::$theme_name ); ?><?php else: ?><?php _e( 'жерстяна банка', \PS::$theme_name ); ?><?php endif; ?> <?php $text = get_field('volume'); if($text): ?> <?php echo $text; ?><?php endif; ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if(\PS\Functions\Shop\Helper::has_price(get_the_ID())): ?>
                            <?php if(is_array($prices) && count($prices)): ?>
                                <?php foreach ($prices as $n => $li): ?>
                                    <div class="buy-block" data-id="<?php echo $n; ?>"<?php if($n !== 0): ?> style="display: none"<?php endif; ?>>
                                        <div class="product-first-select">
                                            <div class="product-first-select-container">
                                                <?php if($li['format'] === 'glass'): ?>
                                                    <div class="product-first-select-container-bottles show">
                                                        <img src="<?php echo \PS::$assets_url; ?>images/bottles.svg" alt="">
                                                    </div>
                                                <?php else: ?>
                                                    <div class="product-first-select-container-cans show">
                                                        <img src="<?php echo \PS::$assets_url; ?>images/cans.svg" alt="">
                                                    </div>
                                                <?php endif; ?>
                                                <span><?php _e( 'Ящик', \PS::$theme_name ); ?></span>
                                            </div>

                                            <?php $old_price = \PS\Functions\Shop\Helper::format_price($li['old_price']); if($old_price): ?>
                                                <div class="product-first-select-price-action show">
                                                    <div class="product-first-select-price-action-percent">-<?php echo 100 - round(\PS\Functions\Shop\Helper::format_price($li['price'])/$old_price*100); ?>%</div>
                                                    <div class="product-first-select-price-action-price">
                                                        <span class="action-old-price"><?php echo $old_price; ?> <?php _e( 'грн', \PS::$theme_name ); ?></span>
                                                        <span class="action-new-price"><?php echo \PS\Functions\Shop\Helper::format_price($li['price']); ?> <?php _e( 'грн', \PS::$theme_name ); ?></span>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="product-first-select-price show"><?php echo \PS\Functions\Shop\Helper::format_price($li['price']); ?> <?php _e( 'грн', \PS::$theme_name ); ?></div>
                                            <?php endif; ?>

                                            <div class="product-first-select-quantity">
                                                <div class="product-first-select-quantity-minus product-operation" data-operation="minus">
                                                    <img src="<?php echo \PS::$assets_url; ?>images/minus.svg" alt="">
                                                </div>
                                                <div class="product-first-select-quantity-num product-quantity">1</div>
                                                <div class="product-first-select-quantity-plus product-operation" data-operation="plus">
                                                    <img src="<?php echo \PS::$assets_url; ?>images/plus.svg" alt="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="product-first-addcart">
                                            <div class="product-first-addcart-price product-subtotal" data-price="<?php echo \PS\Functions\Shop\Helper::format_price($li['price']); ?>"><?php echo \PS\Functions\Shop\Helper::format_price($li['price']); ?> <?php _e( 'грн', \PS::$theme_name ); ?></div>
                                            <div class="product-first-addcart-btn operations_in_cart" data-operation="add" data-product_id="<?php echo get_the_ID(); ?>" data-variant_id="<?php echo $n; ?>"><?php _e( 'додати в кошик', \PS::$theme_name ); ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <div class="product-first-nova">
                                <div class="product-first-nova-item">
                                    <div class="product-first-nova-logo">
                                        <img src="<?php echo \PS::$assets_url; ?>images/nova.png" alt="">
                                    </div>
                                    <div class="product-first-nova-text"><?php _e( 'Доставка здійснюється Новою поштою.', \PS::$theme_name ); ?><br><?php _e( 'У відділення', \PS::$theme_name ); ?> - <?php the_field('price_1', \PS::$option_page); ?> <?php _e( 'грн', \PS::$theme_name ); ?>. <?php _e( 'Кур’єрська доставка', \PS::$theme_name ); ?> - <?php the_field('price_2', \PS::$option_page); ?> <?php _e( 'грн', \PS::$theme_name ); ?>.</div>
                                </div>
                                <div class="product-first-nova-item">
                                    <div class="product-first-nova-logo">
                                        <img src="<?php echo \PS::$assets_url; ?>images/geoicon.svg" alt="">
                                    </div>
                                    <div class="product-first-nova-text"><?php _e( 'Самовивіз за адресою', \PS::$theme_name ); ?> <?php the_field('address_3', \PS::$option_page); ?> - <?php _e( 'безкоштовно', \PS::$theme_name ); ?>.</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(get_field('active_3')): ?>
                <?php $list = get_field('list_3'); if(is_array($list) && count($list)): ?>
                    <div class="product-advantage">
                        <div class="product-advantage-container">
                            <?php foreach ($list as $li): ?>
                                <div class="product-advantage-item">
                                    <?php if(is_array($li['img']) && count($li['img'])): ?>
                                        <div class="product-advantage-item-icon">
                                            <img src="<?php echo $li['img']['sizes']['150x0']; ?>" alt="" loading="lazy">
                                        </div>
                                    <?php endif; ?>
                                    <div class="product-advantage-item-text"><?php echo $li['text']; ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(get_field('active_4')): ?>
                <div class="product-third">
                    <div class="product-third-left">
                        <div class="product-third-left-top">
                            <?php $text = get_field('title_4'); if($text): ?>
                                <h2 class="product-third-left-title"><?php echo $text; ?></h2>
                            <?php endif; ?>
                            <?php $text = get_field('text_4'); if($text): ?>
                                <div class="product-third-left-text"><?php echo $text; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="product-third-left-bottom">
                            <?php $text = get_field('title_5'); if($text): ?>
                                <h2 class="product-third-left-title"><?php echo $text; ?></h2>
                            <?php endif; ?>
                            <?php $list = get_field('list_5'); if(is_array($list) && count($list)): ?>
                                <div class="product-third-left-table">
                                    <?php foreach ($list as $li): ?>
                                        <div class="product-third-left-table-el">
                                            <div class="product-third-left-table-el-left"><?php echo $li['col_1']; ?></div>
                                            <div class="product-third-left-table-el-right"><?php echo $li['col_2']; ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php $img = get_field('img_4'); if(is_array($img) && count($img)): ?>
                        <div class="product-third-right">
                            <img src="<?php echo $img['sizes']['960x0']; ?>" alt="" loading="lazy">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if(get_field('active_5')): ?>
                <div class="home-buy-fluid">
                    <div class="home-buy-centered">
                        <?php $text = get_field('title_1', \PS::$pages['buy']); if($text): ?>
                            <h3 class="home-buy-title"><?php echo $text; ?></h3>
                        <?php endif; ?>
                        <?php $list = get_field('list_1', \PS::$pages['buy']); if(is_array($list) && count($list)): ?>
                            <?php foreach ($list as $li): ?>
                                <div class="home-buy-category">
                                    <div class="home-buy-category-name"><?php echo $li['title']; ?></div>
                                    <?php if(is_array($li['list']) && count($li['list'])): ?>
                                        <div class="home-buy-category-container">
                                            <?php foreach ($li['list'] as $img): ?>
                                                <div class="home-buy-category-element">
                                                    <img src="<?php echo $img['sizes']['480x0']; ?>" alt="" loading="lazy">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(get_field('active_6')): ?>
                <?php
                global $wp_query;
                \PS\Functions\Helper\Helper::get_random_products(get_the_ID());
                $custom_query = $wp_query;
                ?>
                <?php if ( $custom_query->have_posts() ): ?>
                    <div class="product-other">
                        <h2 class="product-other-title"><?php _e( 'Інші напої', \PS::$theme_name ); ?></h2>
                        <div class="product-other-slider-wrapper">
                            <div class="product-other-slider-arrows">
                                <div class="slick-prev">
                                    <img src="<?php echo \PS::$assets_url; ?>images/arr1.svg" alt="" loading="lazy">
                                </div>
                                <div class="slick-next">
                                    <img src="<?php echo \PS::$assets_url; ?>images/arr2.svg" alt="" loading="lazy">
                                </div>
                            </div>
                            <div class="product-other-slider">
                                <?php while ( $custom_query->have_posts() ): $custom_query->the_post(); ?>
                                    <div class="product-other-slider-item">
                                        <?php $img = get_field('img'); if(is_array($img) && count($img)): ?>
                                            <a href="<?php echo get_the_permalink(); ?>" class="product-other-slider-item-images">
                                                <img src="<?php echo $img['sizes']['960x0']; ?>" alt="" loading="lazy">
                                            </a>
                                        <?php endif; ?>

                                        <div class="product-other-slider-item-bottom">
                                            <?php if(\PS\Functions\Shop\Helper::has_price(get_the_ID())): ?>
                                                <a href="javascript:void(0)" class="home-products-item-bottom-buy operations_in_cart" data-operation="add" data-product_id="<?php echo get_the_ID(); ?>" data-variant_id="0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none"><path d="M13.8192 28.488C15.0619 28.488 16.0693 27.4806 16.0693 26.2379C16.0693 24.9952 15.0619 23.9878 13.8192 23.9878C12.5765 23.9878 11.5691 24.9952 11.5691 26.2379C11.5691 27.4806 12.5765 28.488 13.8192 28.488Z" fill="#231F20"/><path d="M23.2162 28.488C24.4589 28.488 25.4663 27.4806 25.4663 26.2379C25.4663 24.9952 24.4589 23.9878 23.2162 23.9878C21.9735 23.9878 20.9661 24.9952 20.9661 26.2379C20.9661 27.4806 21.9735 28.488 23.2162 28.488Z" fill="#231F20"/><path d="M1.43346 5.86427C3.49747 5.86427 5.56148 5.86427 7.62548 5.86427C7.24551 5.57482 6.86554 5.2857 6.48557 4.99625C8.04328 10.4378 9.60134 15.8793 11.1591 21.3209C11.304 21.8271 11.769 22.1889 12.299 22.1889C16.4635 22.1889 20.6276 22.1889 24.7921 22.1889C25.3406 22.1889 25.7628 21.8234 25.932 21.3209C27.1712 17.6431 28.4105 13.9653 29.6497 10.2875C29.8976 9.55152 29.2454 8.79124 28.5098 8.79124C22.036 8.79124 15.5627 8.79124 9.08897 8.79124C7.56435 8.79124 7.56435 11.1555 9.08897 11.1555C15.5627 11.1555 22.036 11.1555 28.5098 11.1555C28.1298 10.6566 27.7498 10.1578 27.3698 9.65926C26.1306 13.3371 24.8914 17.0148 23.6522 20.6926C24.0322 20.4032 24.4121 20.1141 24.7921 19.8246C20.6276 19.8246 16.4635 19.8246 12.299 19.8246C12.6789 20.1141 13.0589 20.4032 13.4389 20.6926C11.8812 15.2511 10.3231 9.80956 8.7654 4.36802C8.6205 3.8614 8.15576 3.5 7.62582 3.5C5.56181 3.5 3.49781 3.5 1.4338 3.5C-0.0911573 3.5 -0.0911573 5.86427 1.43346 5.86427Z" fill="#231F20"/></svg>
                                                    <span><?php _e( 'купити', \PS::$theme_name ); ?></span>
                                                </a>

                                                <?php $prices = get_field('price'); if(is_array($prices) && count($prices)): ?>
                                                    <?php foreach ($prices as $n => $li): ?>
                                                        <?php if($n === 0): ?>
                                                            <div class="cart-goods-item-right-down-price-wrapper">
                                                                <?php $old_price = \PS\Functions\Shop\Helper::format_price($li['old_price']); if($old_price): ?>
                                                                    <div class="cart-goods-item-right-down-price-action show">
                                                                        <span class="action-old-price"><?php echo $old_price; ?> <?php _e( 'грн', \PS::$theme_name ); ?></span>
                                                                        <span class="action-new-price"><?php echo \PS\Functions\Shop\Helper::format_price($li['price']); ?> <?php _e( 'грн', \PS::$theme_name ); ?>/12 <?php _e( 'шт', \PS::$theme_name ); ?></span>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="cart-goods-item-right-down-price show"><?php echo \PS\Functions\Shop\Helper::format_price($li['price']); ?> <?php _e( 'грн', \PS::$theme_name ); ?>/12 <?php _e( 'шт', \PS::$theme_name ); ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <a href="<?php echo get_the_permalink(); ?>" class="product-other-slider-item-link"><?php _e( 'про напій', \PS::$theme_name ); ?></a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
            <?php endif; ?>

            <?php get_template_part('parts/_footer'); ?>
        </main>

        <?php get_template_part('parts/_popups'); ?>
    </div>

    <?php /* DON'T REMOVE THIS */ ?>
    <?php get_footer(); ?>
    <?php /* END */ ?>

    <?php /* WRITE SCRIPTS HERE */ ?>
    <script>
        // tabs
        $(document).on('click', '.product-first-right-btns-el.has-price', function() {
            $('.product-first-right-btns-el.has-price').removeClass('active');
            $(this).addClass('active');

            $('.buy-block').hide();
            $('.buy-block[data-id="' + $(this).data('id') + '"]').show();

            return false;
        });

        // quantity / subtotal
        $(document).on('click', '.product-operation', function() {
            var block = $(this).parents('.buy-block');
            var operation = $(this).data('operation');
            var quantity = parseInt(block.find('.product-quantity').html());
            var price = parseFloat(block.find('.product-subtotal').data('price'));

            if(operation === 'minus'){
                block.find('.product-quantity').html(quantity > 1 ? quantity - 1 : quantity);
            }else{
                block.find('.product-quantity').html(quantity + 1);
            }
            block.find('.product-subtotal').html(price * parseInt(block.find('.product-quantity').html()) + ' ' + '<?php _e( 'грн', \PS::$theme_name ); ?>')

            return false;
        });
    </script>
    <?php /* END */ ?>

</body>
</html>