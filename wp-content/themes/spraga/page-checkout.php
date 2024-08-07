<?php $cart = \PS\Functions\Shop\Cart::get_cart(); if(!is_array($cart) || !count($cart)): ?>
    <?php wp_redirect(get_home_url()); exit(); ?>
<?php else: ?>
    <?php get_header(); ?>

    <body class="order-page">
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3387M6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <div class="fluid-wrapper">
            <main class="order-main">
                <?php get_template_part('parts/_header'); ?>

                <form class="order-fluid parsley-form" id="order_ajax_form">
                    <input name="action" value="add_new_order" type="hidden">
                    <input name="language" value="<?php echo \PS::$current_language; ?>" type="hidden">

                    <div class="order-content">
                        <div class="order-left">
                            <div class="order-left-title"><?php echo get_the_title(); ?></div>

                            <div class="order-left-personal active">
                                <div class="order-left-personal-num">1</div>
                                <div class="order-left-personal-data">
                                    <div class="order-left-personal-data-heading"><?php _e( 'Особисті дані', \PS::$theme_name ); ?></div>
                                    <div class="order-left-personal-input">
                                        <input type="text" name="name" class="parsley-check" placeholder="<?php _e( 'Ваше прізвище, ім’я та по батькові', \PS::$theme_name ); ?> *" data-parsley-required="true" autocomplete="off">
                                        <div class="error-text"><?php _e( 'Заповніть правильно це поле', \PS::$theme_name ); ?></div>
                                    </div>
                                    <div class="order-left-personal-input">
                                        <input type="text" name="phone" class="parsley-check phone_mask" placeholder="<?php _e( 'Номер телефону', \PS::$theme_name ); ?> *" data-parsley-required="true" autocomplete="off">
                                        <div class="error-text"><?php _e( 'Заповніть правильно це поле', \PS::$theme_name ); ?></div>
                                    </div>
                                    <div class="order-left-personal-input">
                                        <input type="text" name="email" class="parsley-check" placeholder="<?php _e( 'E-mail', \PS::$theme_name ); ?> *" data-parsley-required="true" data-parsley-type="email" autocomplete="off" autocomplete="off">
                                        <div class="error-text"><?php _e( 'Заповніть правильно це поле', \PS::$theme_name ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="order-left-delivery">
                                <div class="order-left-delivery-num">2</div>
                                <div class="order-left-delivery-data">
                                    <div class="order-left-delivery-data-title"><?php _e( 'Доставка', \PS::$theme_name ); ?></div>
                                    <div class="order-left-delivery-radio">
                                        <input type="radio" id="variant_1" name="delivery" value="variant_1" data-price="<?php the_field('price_1', \PS::$option_page); ?>" checked>
                                        <label for="variant_1"><?php _e( 'У відділення Нової пошти', \PS::$theme_name ); ?> <span>(<?php the_field('price_1', \PS::$option_page); ?> <?php _e( 'грн', \PS::$theme_name ); ?>)</span></label>

                                        <input type="radio" id="variant_2" name="delivery" value="variant_2" data-price="<?php the_field('price_2', \PS::$option_page); ?>">
                                        <label for="variant_2"><?php _e( 'Кур’єрська доставка Нова пошта', \PS::$theme_name ); ?> <span>(<?php the_field('price_2', \PS::$option_page); ?> <?php _e( 'грн', \PS::$theme_name ); ?>)</span></label>

                                        <?php $text = get_field('address_3', \PS::$option_page); if($text): ?>
                                            <input type="radio" id="variant_3" name="delivery" value="variant_3" data-price="0">
                                            <label for="variant_3"><?php _e( 'Самовивіз', \PS::$theme_name ); ?> <span>(<?php echo $text; ?>)</span> <span>(0 <?php _e( 'грн', \PS::$theme_name ); ?>)</span></label>
                                        <?php endif; ?>
                                    </div>

                                    <div class="order-left-delivery-data-input delivery-fields variant_1 variant_2">
                                        <input id="city" type="text" name="city" class="parsley-check" placeholder="<?php _e( 'Місто/село', \PS::$theme_name ); ?> *" data-ref="" data-parsley-required="true" autocomplete="off">
                                        <div class="error-text"><?php _e( 'Заповніть правильно це поле', \PS::$theme_name ); ?></div>
                                    </div>
                                    <div class="order-left-delivery-data-input delivery-fields variant_1">
                                        <input id="warehouse" type="text" name="post" class="parsley-check" placeholder="<?php _e( 'Відділення Нової пошти', \PS::$theme_name ); ?> *" data-parsley-required="true" autocomplete="off">
                                        <div class="error-text"><?php _e( 'Заповніть правильно це поле', \PS::$theme_name ); ?></div>
                                    </div>
                                    <div class="order-left-delivery-data-input delivery-fields variant_2" style="display: none">
                                        <input type="text" name="address" class="parsley-check" placeholder="<?php _e( 'Адреса доставки', \PS::$theme_name ); ?> *" data-parsley-required="true" autocomplete="off">
                                        <div class="error-text"><?php _e( 'Заповніть правильно це поле', \PS::$theme_name ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="order-left-delivery pay">
                                <div class="order-left-delivery-num">3</div>
                                <div class="order-left-delivery-data">
                                    <div class="order-left-delivery-data-title"><?php _e( 'Оплата', \PS::$theme_name ); ?></div>
                                    <div class="order-left-delivery-radio">
                                        <input type="radio" id="variant_4" name="pay" value="variant_1" checked>
                                        <label for="variant_4"><?php _e( 'Онлайн оплата', \PS::$theme_name ); ?> (Visa / Mastercard)</label>
                                    </div>

                                    <div class="order-promocode">
                                        <div class="order-promocode-title"><?php _e( 'Промокод', \PS::$theme_name ); ?></div>
                                        <div class="order-promocode-input">
                                            <input type="text" id="promocode" name="promocode" placeholder="<?php _e( 'Введіть промокод', \PS::$theme_name ); ?>" autocomplete="off">
                                            <div class="order-promocode-input-error"></div>
                                            <div class="order-promocode-input-success"><?php _e( 'промокод застосовано', \PS::$theme_name ); ?></div>
                                        </div>
                                        <div class="order-promocode-btn" data-default="<?php _e( 'застосувати', \PS::$theme_name ); ?>" data-wait="<?php _e( 'зачекайте', \PS::$theme_name ); ?>.." data-remove="<?php _e( 'видалити', \PS::$theme_name ); ?>"><?php _e( 'застосувати', \PS::$theme_name ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <?php $text = get_field('order_text', \PS::$option_page); if($text): ?>
                                <?php $file = get_field('order_file', \PS::$option_page); if($file): ?>
                                    <div class="order-left-copyright">
                                        <?php echo str_replace(['[[',']]'], ['<a href="'. $file .'">', '</a>'], $text); ?>
                                    </div>
                                <?php else: ?>
                                    <div class="order-left-copyright"><?php echo str_replace(['[[',']]'], ['', ''], $text); ?></div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <button type="submit" class="order-left-submit-btn" data-default="<?php _e( 'оплатити', \PS::$theme_name ); ?>" data-wait="<?php _e( 'зачекайте', \PS::$theme_name ); ?>.."><?php _e( 'оплатити', \PS::$theme_name ); ?></button>
                        </div>

                        <div class="order-right">
                            <?php get_template_part('parts/elements/cart', null, ['is_checkout' => true]); ?>

                            <div class="cart-goods cart-totals show">
                                <div class="order-right-total" data-subtotal="<?php echo \PS\Functions\Shop\Cart::get_sum_in_cart($cart); ?>">
                                    <div class="order-right-total-delivery shipping">
                                        <div class="order-right-total-delivery-name"><?php _e( 'Доставка', \PS::$theme_name ); ?>:</div>
                                        <div class="order-right-total-delivery-sum"><span><?php the_field('price_1', \PS::$option_page); ?></span> <?php _e( 'грн', \PS::$theme_name ); ?></div>
                                    </div>
                                    <div class="order-right-total-delivery promocode" style="color: #ff0041; display: none">
                                        <div class="order-right-total-delivery-name"><?php _e( 'Знижка по промокоду', \PS::$theme_name ); ?>:</div>
                                        <div class="order-right-total-delivery-sum">-<span>0</span> <?php _e( 'грн', \PS::$theme_name ); ?></div>
                                    </div>
                                    <div class="order-right-total-price total">
                                        <div class="order-right-total-price-name"><?php _e( 'Всього', \PS::$theme_name ); ?>:</div>
                                        <div class="order-right-total-price-sum"><span><?php echo \PS\Functions\Shop\Cart::get_sum_in_cart($cart) + get_field('price_1', \PS::$option_page); ?></span> <?php _e( 'грн', \PS::$theme_name ); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="order-mobile-copyright">
                            <?php $text = get_field('order_text', \PS::$option_page); if($text): ?>
                                <div class="order-mobile-copyright-text"><?php echo $text; ?></div>
                            <?php endif; ?>

                            <button type="submit" class="order-mobile-copyright-btn" data-default="<?php _e( 'оплатити', \PS::$theme_name ); ?>" data-wait="<?php _e( 'зачекайте', \PS::$theme_name ); ?>.."><?php _e( 'оплатити', \PS::$theme_name ); ?></button>
                        </div>
                    </div>
                </form>

                <?php get_template_part('parts/_footer'); ?>
            </main>

            <?php get_template_part('parts/_popups'); ?>

            <div class="liqpay-form" style="display: none"></div>
        </div>

        <?php /* DON'T REMOVE THIS */ ?>
        <?php get_footer(); ?>
        <?php /* END */ ?>

        <?php /* WRITE SCRIPTS HERE */ ?>
        <style>
            .autocomplete-suggestions { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; border: 1px solid #9f9f9f; background: #FFF; cursor: default; overflow: auto; }
            .autocomplete-suggestion { font-family: Myriad Pro; font-size: 18px; letter-spacing: 0.18px; padding: 5px; white-space: nowrap; overflow: hidden; }
            .autocomplete-no-suggestion { padding: 5px;}
            .autocomplete-selected { background: #F0F0F0; }
            .autocomplete-suggestions strong { font-weight: bold; color: #000; }
        </style>

        <script>
            // cities autocomplete
            $(document).ready(function () {
                var city_input = $('.order-page #city');
                var warehouse_input = $('.order-page #warehouse');

                city_input.autocomplete({
                    serviceUrl: '/wp-admin/admin-ajax.php',
                    params: {
                        'action' : 'city_autocomplete'
                    },
                    type: 'POST',
                    dataType: 'json',
                    minChars: 1,
                    autoSelectFirst: true,
                    triggerSelectOnValidInput: true,
                    showNoSuggestionNotice: true,
                    noSuggestionNotice: '<?php _e( 'Нічого не знайдено', \PS::$theme_name ); ?>',
                    onSelect: function (suggestion) {
                        // hide errors
                        trigger_parsley(city_input);

                        // set city ref
                        city_input.data('ref', suggestion.data);

                        // warehouses autocomplete
                        warehouse_input.val('').autocomplete({
                            serviceUrl: '/wp-admin/admin-ajax.php',
                            params: {
                                'action' : 'warehouses_autocomplete',
                                'city' : city_input.data('ref')
                            },
                            type: 'POST',
                            dataType: 'json',
                            minChars: 0,
                            autoSelectFirst: true,
                            triggerSelectOnValidInput: true,
                            showNoSuggestionNotice: true,
                            noSuggestionNotice: '<?php _e( 'Нічого не знайдено', \PS::$theme_name ); ?>',
                            onSelect: function (suggestion) {
                                // hide errors
                                trigger_parsley(warehouse_input);
                            }
                        });
                    }
                });
            });
        </script>

        <script>
            // calculate total sum
            function calculate_total(){
                var subtotal = parseFloat($('.order-right-total').data('subtotal'));
                var shipping = parseFloat($('.order-right-total .shipping span').text());
                var promocode = parseFloat($('.order-right-total .promocode span').text());
                var total = subtotal + shipping - promocode;
                $('.order-right-total .total span').text(total);
            }
        </script>

        <script>
            // change delivery method
            $(document).on('change', 'input[name="delivery"]', function (){
                var val = $(this).val();
                var price = parseFloat($(this).data('price'));

                // hide/show variants
                $('.delivery-fields').hide();
                $('.delivery-fields.' + val).show();

                // change sum
                $('.order-right-total .shipping span').html(price);
                calculate_total();

                return false;
            });
        </script>

        <script>
            // apply/remove promocode
            var no_block_promocode = true;
            $(document).on('click', '.order-promocode .order-promocode-btn', function() {
                var submit = $(this);
                if(no_block_promocode) {
                    if(submit.hasClass('remove')){
                        // remove
                        $('.order-promocode #promocode').val('');
                        $('.order-promocode .order-promocode-input-success').hide();

                        $('.order-main .order-right-total-delivery.promocode span').text(0);
                        $('.order-main .order-right-total-delivery.promocode').hide();
                        calculate_total();

                        submit.html(submit.data('default')).removeClass('remove');
                    }else{
                        // apply
                        var promocode = $('.order-promocode #promocode').val();
                        if(promocode){
                            // ajax
                            $.ajax({
                                url: '/wp-admin/admin-ajax.php',
                                data: {
                                    action: 'apply_promocode',
                                    promocode: promocode
                                },
                                type: 'POST',
                                dataType: 'json',
                                beforeSend: function () {
                                    // block
                                    no_block_promocode = false;

                                    // error
                                    $('.order-promocode .order-promocode-input').removeClass('error');
                                    $('.order-promocode .order-promocode-input-error').html('');
                                    $('.order-promocode .order-promocode-input-success').hide();

                                    // wait
                                    submit.html(submit.data('wait'));
                                },
                                success: function (data) {
                                    // discount
                                    var discount = parseFloat(data.discount);
                                    $('.order-main .order-right-total-delivery.promocode span').text(discount);
                                    if(discount){
                                        $('.order-main .order-right-total-delivery.promocode').show();
                                    }else{
                                        $('.order-main .order-right-total-delivery.promocode').hide();
                                    }
                                    calculate_total();

                                    // error
                                    if(data.error){
                                        $('.order-promocode .order-promocode-input').addClass('error');
                                        $('.order-promocode .order-promocode-input-error').html(data.error);

                                        // button
                                        submit.html(submit.data('default'));
                                    }else{
                                        $('.order-promocode .order-promocode-input-success').show();
                                        submit.addClass('remove').html(submit.data('remove'));
                                    }
                                },
                                complete: function (){
                                    // разрешаем повторную отправку
                                    no_block_promocode = true;
                                }
                            });
                        }else{
                            $('.order-promocode .order-promocode-input').addClass('error');
                            $('.order-promocode .order-promocode-input-error').html('<?php _e( 'Заповніть правильно це поле', \PS::$theme_name ); ?>');
                        }
                    }
                }

                return false;
            });
        </script>

        <script>
            // create new order
            var no_block_order = true;
            $(document).on('submit', '#order_ajax_form', function() {
                var form = $(this);
                var submit = form.find('[type="submit"]');
                if(trigger_parsley(form) && no_block_order) {
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
                            no_block_order = false;

                            // wait
                            submit.html(submit.data('wait'));
                        },
                        success: function (data) {
                            if (data.success) {
                                // online payment
                                if(data.pay_link) {
                                    window.location.href = data.pay_link;
                                } else if (data.pay_form) {
                                    $('.liqpay-form').html(data.pay_form);
                                } else {
                                    window.location.href = '<?php echo get_the_permalink(\PS::$pages['success']); ?>';
                                }
                            }else{
                                $.each(data.errors, function( index, value ) {
                                    $('[name="' + value + '"]').parent().addClass('error');
                                });
                            }
                        },
                        complete: function (){
                            // онлайн-оплата
                            setTimeout(function () {
                                if ($('.liqpay-form form').length) {
                                    $('.liqpay-form form').trigger('submit');
                                }
                            }, 1000);

                            setTimeout(function () {
                                // разрешаем повторную отправку
                                no_block_order = true;

                                // button
                                submit.html(submit.data('default'));
                            }, 2000);
                        }
                    });
                }

                return false;
            });
        </script>
        <?php /* END */ ?>

    </body>
    </html>
<?php endif; ?>