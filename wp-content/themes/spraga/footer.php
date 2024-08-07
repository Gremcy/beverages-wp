<?php /* DON'T REMOVE THIS */ ?>
<?php wp_footer(); ?>
<?php /* END */ ?>

<script>
    /* SHOP */

    // operations in cart
    var no_block_cart = true;
    $(document).on('click', '.operations_in_cart', function(){
        if(no_block_cart){
            var button = $(this);
            var operation = button.data('operation');
            var product_id = parseInt(button.data('product_id'));
            var variant_id = parseInt(button.data('variant_id'));

            // add
            var quantity = 1;
            if(operation === 'add' && button.parents('.buy-block').find('.product-quantity').length){
                quantity = parseInt(button.parents('.buy-block').find('.product-quantity').html());
            }

            // данные
            var data = {
                'action' : 'operations_in_cart',
                'is_checkout' : $('body').hasClass('order-page') ? 1 : 0,
                'operation' : operation,
                'product_id' : product_id,
                'variant_id' : variant_id,
                'quantity' : quantity
            };

            // AJAX
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                    // blocking
                    no_block_cart = false;
                },
                success: function (data) {
                    if(data.success) {
                        if($('body').hasClass('order-page')){
                            // checkout
                            if(parseInt(data.quantity_in_cart) === 0){
                                $('.order-page .cart-totals, .order-page .order-promocode').hide();
                                $('.order-page [type="submit"]').addClass('disable').attr('disabled', 'disabled');
                            }

                            // update
                            $('.order-page .order-right .cart-goods.cart-products').remove();
                            $(data.mini_cart).insertBefore('.order-page .order-right .cart-totals');
                            $('.order-page .order-right-total').data('subtotal', parseFloat(data.sum_in_cart));

                            // promocode
                            if($('.order-page .order-promocode #promocode').val()){
                                if($('.order-promocode .order-promocode-btn').hasClass('remove')){
                                    $('.order-promocode .order-promocode-btn').removeClass('remove');
                                }
                                $('.order-promocode .order-promocode-btn').trigger('click');
                            }else{
                                calculate_total();
                            }
                        }else{
                            // cart
                            $('.ajax-loading-of-cart-quantity').html(parseInt(data.quantity_in_cart));
                            $('.ajax-loading-of-cart .cart-goods, .cart-down, .cart-empty-text').remove();
                            $(data.mini_cart).insertAfter('.ajax-loading-of-cart .cart-top');
                            if(operation === 'add'){
                                $('.header-right-cart').trigger('click');
                            }
                        }
                    }
                },
                complete: function(){
                    // blocking
                    no_block_cart = true;
                }
            });
        }

        return false;
    });
</script>

<script>
    /* FORMS */

    // forms validation
    function trigger_parsley(form){
        var valid = true;
        // check inputs
        var inputs = form.find('.parsley-check');
        inputs.each(function(){
            $(this).parent().removeClass('error');
            if($(this).is(':visible') && $(this).parsley().isValid() === false){
                $(this).parent().addClass('error');
                valid = false;
            }
        });

        // check for two spaces in input with class="parsley-check"
        inputs.each(function () {
            if ($(this).is(':visible') && $(this).attr('name') === 'name') {
                var inputValue = $(this).val().trim();
                var wordCount = inputValue.split(/\s+/).length;

                if (wordCount !== 3) {
                    $(this).parent().addClass('error');
                    valid = false;
                }
            }
        });

        // return
        return valid;
    }

    $(document).ready(function () {
        $('input.parsley-check[name="name"]:visible').on('blur', function () {
            var input = $(this);

            if (input.is(':visible') && input.attr('name') === 'name') {
                var inputValue = $(this).val().trim();
                var wordCount = inputValue.split(/\s+/).length;

                if (wordCount !== 3) {
                    $(this).parent().addClass('error');
                } else {
                    $(this).parent().removeClass('error');
                }
            }
        });
    });

    // phone
    var phones = $('.phone_mask'); if(phones.length){
        phones.each(function(){
            Inputmask({"mask": "389999999999", "clearIncomplete": true, showMaskOnHover: false}).mask($(this).get(0));
        });
    }
</script>