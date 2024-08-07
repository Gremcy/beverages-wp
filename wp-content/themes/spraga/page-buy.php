<?php get_header(); ?>

<body class="buy-page">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3387M6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="fluid-wrapper">
        <main class="buy-main">
            <?php get_template_part('parts/_header'); ?>

            <?php if(get_field('active_1')): ?>
                <div class="buy-partners">
                    <div class="home-buy-fluid">
                        <div class="home-buy-centered">
                            <?php $text = get_field('title_1'); if($text): ?>
                                <div class="home-buy-title"><?php echo $text; ?></div>
                            <?php endif; ?>
                            <?php $list = get_field('list_1'); if(is_array($list) && count($list)): ?>
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

            <?php if(get_field('active_2')): ?>
                <div class="buy-contact">
                    <?php $img = get_field('img_2'); if(is_array($img) && count($img)): ?>
                        <div class="buy-contact-image">
                            <img src="<?php echo $img['sizes']['960x0']; ?>" alt="" loading="lazy">
                        </div>
                    <?php endif; ?>

                    <div class="buy-contact-form-wrapper">
                        <form class="buy-contact-form parsley-form">
                            <input name="action" value="add_new_partner" type="hidden">

                            <?php $text = get_field('title_2'); if($text): ?>
                                <div class="buy-contact-form-title"><?php echo $text; ?></div>
                            <?php endif; ?>
                            <?php $text = get_field('text_2'); if($text): ?>
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
                                <input name="business" type="text" class="inputText" autocomplete="off" />
                                <span class="floating-label"><?php _e( 'Тип бізнесу (кав’ярня, магазин чи інше)', \PS::$theme_name ); ?></span>
                            </div>
                            <div class="hire-modal-input">
                                <input name="city" type="text" class="inputText" autocomplete="off" />
                                <span class="floating-label"><?php _e( 'Місто та область', \PS::$theme_name ); ?></span>
                            </div>

                            <button class="buy-contact-form-submit" type="submit" data-default="<?php _e( 'відправити', \PS::$theme_name ); ?>" data-wait="<?php _e( 'зачекайте', \PS::$theme_name ); ?>..">
                                <div class="buy-contact-form-submit-circle"></div>
                                <span><?php _e( 'відправити', \PS::$theme_name ); ?></span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="buy-contact-test" style="display: none">
                    <?php $img = get_field('img_2'); if(is_array($img) && count($img)): ?>
                        <div class="buy-contact-image">
                            <img src="<?php echo $img['sizes']['960x0']; ?>" alt="" loading="lazy">
                        </div>
                    <?php endif; ?>

                    <div class="buy-contact-success-wrapper show">
                        <canvas id="bubbles"></canvas>
                        <div class="buy-contact-success-content">
                            <?php $text = get_field('title_3'); if($text): ?>
                                <div class="buy-contact-success-title"><?php echo $text; ?></div>
                            <?php endif; ?>
                            <?php $text = get_field('text_3'); if($text): ?>
                                <div class="buy-contact-success-text"><?php echo $text; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
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
                            $(".buy-contact").remove();
                            $(".buy-contact-test").show();
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