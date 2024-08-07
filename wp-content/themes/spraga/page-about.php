<?php get_header(); ?>

<body class="about-page">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3387M6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="fluid-wrapper">
        <main class="about-main">
            <?php get_template_part('parts/_header'); ?>

            <?php if(get_field('active_1')): ?>
                <div class="about-first">
                    <div class="about-first-bg">
                        <picture>
                            <?php $img = get_field('img_1_3'); if(is_array($img) && count($img)): ?>
                                <source media="(max-width: 650px)" srcset="<?php echo $img['sizes']['960x0']; ?>">
                            <?php endif; ?>
                            <?php $img = get_field('img_1_2'); if(is_array($img) && count($img)): ?>
                                <source media="(max-width: 999px)" srcset="<?php echo $img['sizes']['1600x0']; ?>">
                            <?php endif; ?>
                            <?php $img = get_field('img_1_1'); if(is_array($img) && count($img)): ?>
                                <source media="(min-width: 1000px)" srcset="<?php echo $img['sizes']['1600x0']; ?>">
                                <img src="<?php echo $img['sizes']['1600x0']; ?>" alt="" loading="lazy">
                            <?php endif; ?>
                        </picture>
                    </div>
                    <div class="about-first-content">
                        <div class="about-first-logo">
                            <img src="<?php echo \PS::$assets_url; ?>images/logo4.svg" alt="" loading="lazy">
                        </div>
                        <?php $text = get_field('title_1'); if($text): ?>
                            <h1 class="about-first-text"><?php echo $text; ?></h1>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="about-wrapper">

                <div class="about-sidebar">
                    <div class="about-sidebar-inner">
                        <?php if(get_field('active_2')): ?><a href="#about-anchor1" class="about-sidebar-item sec1"><?php echo get_field('menu_2'); ?></a><?php endif; ?>
                        <?php if(get_field('active_3')): ?><a href="#about-anchor2" class="about-sidebar-item sec2"><?php echo get_field('menu_3'); ?></a><?php endif; ?>
                        <?php if(get_field('active_4')): ?><a href="#about-anchor3" class="about-sidebar-item sec3"><?php echo get_field('menu_4'); ?></a><?php endif; ?>
                        <?php if(get_field('active_5')): ?><a href="#about-anchor4" class="about-sidebar-item sec4"><?php echo get_field('menu_5'); ?></a><?php endif; ?>
                        <?php if(get_field('active_6')): ?><a href="#about-anchor5" class="about-sidebar-item sec5"><?php echo get_field('menu_6'); ?></a><?php endif; ?>
                    </div>
                </div>

                <div class="about-content">
                    <?php if(get_field('active_2')): ?>
                        <?php $list = get_field('list_2'); if(is_array($list) && count($list)): ?>
                            <div class="about-about">
                                <div class="about-anchor1" id="about-anchor1"></div>
                                <div class="about-about-for-animation" id="section1"></div>
                                <?php foreach ($list as $li): ?>
                                    <div class="about-about-item">
                                        <div class="about-about-item-left">
                                            <div class="about-about-item-left-title"><?php echo $li['title']; ?></div>
                                            <div class="about-about-item-left-description"><?php echo $li['text']; ?></div>
                                        </div>
                                        <div class="about-about-item-right">
                                            <div class="about-about-item-right-year"><?php echo $li['year']; ?></div>
                                            <?php if(is_array($li['img']) && count($li['img'])): ?>
                                                <div class="about-about-item-right-photo">
                                                    <img src="<?php echo $li['img']['sizes']['960x0']; ?>" alt="" loading="lazy">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if(get_field('active_3')): ?>
                        <div class="about-manufacture" id="section2">
                            <div class="about-anchor2" id="about-anchor2"></div>
                            <?php $text = get_field('title_3'); if($text): ?>
                                <h2 class="about-manufacture-title"><?php echo $text; ?></h2>
                            <?php endif; ?>

                            <div class="about-manufacture-images">
                                <div class="about-manufacture-images-line">
                                    <?php $imgs = get_field('imgs_2'); if(is_array($imgs['img_1']) && count($imgs['img_1'])): ?>
                                        <div class="about-manufacture-images-line-one">
                                            <img src="<?php echo $imgs['img_1']['sizes']['960x0']; ?>" alt="" loading="lazy">
                                        </div>
                                    <?php endif; ?>
                                    <?php if(is_array($imgs['img_2']) && count($imgs['img_2'])): ?>
                                        <div class="about-manufacture-images-line-two">
                                            <img src="<?php echo $imgs['img_2']['sizes']['960x0']; ?>" alt="" loading="lazy">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="about-manufacture-images-line">
                                    <?php if(is_array($imgs['img_3']) && count($imgs['img_3'])): ?>
                                        <div class="about-manufacture-images-line-two">
                                            <img src="<?php echo $imgs['img_3']['sizes']['960x0']; ?>" alt="" loading="lazy">
                                        </div>
                                    <?php endif; ?>
                                    <?php if(is_array($imgs['img_4']) && count($imgs['img_4'])): ?>
                                        <div class="about-manufacture-images-line-one">
                                            <img src="<?php echo $imgs['img_4']['sizes']['960x0']; ?>" alt="" loading="lazy">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php $list = get_field('list_3'); if(is_array($list) && count($list)): ?>
                                <div class="about-manufacture-advantages">
                                    <?php foreach ($list as $li): ?>
                                        <div class="about-manufacture-advantages-item">
                                            <div class="about-manufacture-advantages-item-name">
                                                <?php echo $li['title']; ?><?php if($li['subtitle']): ?> <span><?php echo $li['subtitle']; ?></span><?php endif; ?>
                                            </div>
                                            <div class="about-manufacture-advantages-item-desc"><?php echo $li['text']; ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="about-manufacture-half">
                                <?php $list = get_field('list_3_2'); if(is_array($list) && count($list)): ?>
                                    <div class="about-manufacture-half-list">
                                        <ul>
                                            <?php foreach ($list as $li): ?>
                                                <li><?php echo $li['text']; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <?php $img = get_field('img_3_2'); if(is_array($img) && count($img)): ?>
                                    <div class="about-manufacture-half-image">
                                        <img src="<?php echo $img['sizes']['960x0']; ?>" alt="" loading="lazy">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="about-manufacture-standart">
                                <div class="about-manufacture-standart-left">
                                    <?php $text = get_field('title_3_2'); if($text): ?>
                                        <h2 class="about-manufacture-standart-left-title"><?php echo $text; ?></h2>
                                    <?php endif; ?>
                                    <?php $text = get_field('text_3_3'); if($text): ?>
                                        <div class="about-manufacture-standart-left-desc"><?php echo $text; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="about-manufacture-standart-right">
                                    <?php $text = get_field('text_3_4'); if($text['text']): ?>
                                        <div class="about-manufacture-standart-right-text"><?php echo $text['text']; ?></div>
                                    <?php endif; ?>
                                    <?php $imgs = get_field('text_3_4'); if(is_array($imgs['logo']) && count($imgs['logo'])): ?>
                                        <div class="about-manufacture-standart-right-logos">
                                            <?php foreach ($imgs['logo'] as $li): ?>
                                                <div class="about-manufacture-standart-right-logos-el">
                                                    <img src="<?php echo $li['sizes']['480x0']; ?>" alt="" loading="lazy">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="about-manufacture-success">
                                <div class="about-manufacture-success-img">
                                    <picture>
                                        <?php $text = get_field('banner_3_5'); if(is_array($text['img_3']) && count($text['img_3'])): ?>
                                            <source media="(max-width: 650px)" srcset="<?php echo $text['img_3']['sizes']['980x0']; ?>">
                                        <?php endif; ?>
                                        <?php if(is_array($text['img_2']) && count($text['img_2'])): ?>
                                            <source media="(max-width: 999px)" srcset="<?php echo $text['img_2']['sizes']['1600x0']; ?>">
                                        <?php endif; ?>
                                        <?php if(is_array($text['img_1']) && count($text['img_1'])): ?>
                                            <source media="(min-width: 1000px)" srcset="<?php echo $text['img_1']['sizes']['1600x0']; ?>">
                                            <img src="<?php echo $text['img_1']['sizes']['1600x0']; ?>" alt="" loading="lazy">
                                        <?php endif; ?>
                                    </picture>
                                </div>
                                <div class="about-manufacture-success-text"><?php echo $text['text']; ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(get_field('active_4')): ?>
                        <div class="about-team" id="section3">
                            <div class="about-anchor3" id="about-anchor3"></div>
                            <div class="about-team-first">
                                <?php $text = get_field('title_4'); if($text): ?>
                                    <div class="about-team-first-left"><?php echo $text; ?></div>
                                <?php endif; ?>
                                <?php $text = get_field('text_4'); if($text): ?>
                                    <div class="about-team-first-right"><?php echo $text; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="about-team-ceo">
                                <div class="about-team-ceo-left">
                                    <div class="about-team-ceo-left-top">
                                        <?php $text = get_field('title_4_2'); if($text): ?>
                                            <div class="about-team-ceo-left-title">
                                                <img src="<?php echo \PS::$assets_url; ?>images/icon18.svg" alt="" loading="lazy">
                                                <span><?php echo $text; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php $text = get_field('text_4_2'); if($text): ?>
                                            <div class="about-team-ceo-left-desc"><?php echo $text; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="about-team-ceo-left-autor">
                                        <?php $text = get_field('name_4'); if($text): ?>
                                            <p><?php echo $text; ?></p>
                                        <?php endif; ?>
                                        <?php $text = get_field('name_4_2'); if($text): ?>
                                            <span><?php echo $text; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php $img = get_field('img_4_2'); if(is_array($img) && count($img)): ?>
                                    <div class="about-team-ceo-right">
                                        <img src="<?php echo $img['sizes']['960x0']; ?>" alt="" loading="lazy">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(get_field('active_5')): ?>
                        <div class="buy-partners" id="section4">
                            <div class="about-anchor4" id="about-anchor4"></div>
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
                        </div>
                    <?php endif; ?>

                    <?php if(get_field('active_6')): ?>
                        <div class="about-contact" id="section5">
                            <div class="about-anchor5" id="about-anchor5"></div>
                            <?php $text = get_field('address_title', \PS::$option_page); if($text): ?>
                                <div class="about-contact-title"><?php echo $text; ?></div>
                            <?php endif; ?>

                            <div class="buy-contact">
                                <div class="about-contact-left">
                                    <?php $text = get_field('address_text', \PS::$option_page); if($text): ?>
                                        <div class="about-contact-left-address">
                                            <img src="<?php echo \PS::$assets_url; ?>images/icon19.svg" alt="" loading="lazy">
                                            <span><?php echo $text; ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php $text = get_field('email', \PS::$option_page); if($text): ?>
                                        <a href="mailto:<?php echo $text; ?>" class="about-contact-left-email">
                                            <img src="<?php echo \PS::$assets_url; ?>images/icon20.svg" alt="" loading="lazy">
                                            <span><?php echo $text; ?></span>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <div class="buy-contact-form-wrapper hide_if_success">
                                    <form class="buy-contact-form parsley-form">
                                        <input name="action" value="add_new_letter" type="hidden">

                                        <?php $text = get_field('letter_title'); if($text): ?>
                                            <div class="buy-contact-form-title"><?php echo $text; ?></div>
                                        <?php endif; ?>
                                        <?php $text = get_field('letter_text'); if($text): ?>
                                            <div class="buy-contact-form-description"><?php echo $text; ?></div>
                                        <?php endif; ?>

                                        <div class="hire-modal-input">
                                            <input name="name" type="text" class="inputText" autocomplete="off" />
                                            <span class="floating-label"><?php _e( 'Ваше прізвище та ім’я', \PS::$theme_name ); ?></span>
                                        </div>
                                        <div class="hire-modal-input">
                                            <input name="phone" type="text" class="inputText phone_mask" autocomplete="off" />
                                            <span class="floating-label"><?php _e( 'Номер телефону', \PS::$theme_name ); ?></span>
                                        </div>
                                        <div class="hire-modal-input">
                                            <input name="email" type="text" class="inputText parsley-check" id="email_mask" data-parsley-required="true" data-parsley-type="email" autocomplete="off" />
                                            <span class="floating-label"><?php _e( 'E-mail', \PS::$theme_name ); ?> *</span>
                                            <div class="hire-modal-input-error-text"><?php _e( 'Заповніть правильно це поле', \PS::$theme_name ); ?></div>
                                        </div>
                                        <div class="hire-modal-input">
                                            <input name="text" type="text" class="inputText" autocomplete="off" />
                                            <span class="floating-label"><?php _e( 'Запитання', \PS::$theme_name ); ?></span>
                                        </div>

                                        <button class="buy-contact-form-submit" type="submit" data-default="<?php _e( 'відправити', \PS::$theme_name ); ?>" data-wait="<?php _e( 'зачекайте', \PS::$theme_name ); ?>..">
                                            <div class="buy-contact-form-submit-circle"></div>
                                            <span><?php _e( 'відправити', \PS::$theme_name ); ?></span>
                                        </button>
                                    </form>
                                </div>

                                <div class="buy-contact-success-wrapper show_if_success">
                                    <canvas id="bubbles"></canvas>
                                    <div class="buy-contact-success-content">
                                        <?php $text = get_field('letter_title_success'); if($text): ?>
                                            <div class="buy-contact-success-title"><?php echo $text; ?></div>
                                        <?php endif; ?>
                                        <?php $text = get_field('letter_text_success'); if($text): ?>
                                            <div class="buy-contact-success-text"><?php echo $text; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php get_template_part('parts/_footer'); ?>
        </main>

        <?php get_template_part('parts/_popups'); ?>
    </div>

    <?php /* DON'T REMOVE THIS */ ?>
    <?php get_footer(); ?>
    <?php /* END */ ?>

    <?php /* WRITE SCRIPTS HERE */ ?>
    <script>
        // send letter
        var no_block = true;
        $(document).on('submit', '.buy-contact-form', function() {
            var form = $(this);
            var submit = form.find('[type="submit"]');
            if(trigger_parsley(form) && no_block) {
                // ajax
                var formData = new FormData(form[0]);
                $.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    data: formData,
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        // block
                        no_block = false;

                        // wait
                        submit.find('span').html(submit.data('wait'));
                    },
                    success: function (data) {
                        if (data.success) {
                            // success
                            $(".hide_if_success").remove();
                            $(".show_if_success").show();
                        }

                        // разрешаем повторную отправку
                        no_block = true;

                        // button
                        submit.find('span').html(submit.data('default'));
                    }
                });
            }
            return false;
        });
    </script>
    <?php /* END */ ?>

</body>
</html>