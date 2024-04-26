jQuery(document).ready(function ($) {
    'use strict';
    $(document).on('change', '.vi-wcaio-va-qty-input', function (e) {
        let val = parseFloat($(this).val()),
            min = parseFloat($(this).attr('min')),
            max = parseFloat($(this).attr('max'));
        if (min > val) {
            val = min;
        }
        if (val > max) {
            val = max;
        }
        $(this).val(val);
    });
    $(document).on('click', '.vi-wcaio-va-change-qty', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let qty_input = $(this).closest('.vi-wcaio-va-qty-wrap').find('.vi-wcaio-va-qty-input');
        let val = parseFloat(qty_input.val()),
            step = parseFloat(qty_input.attr('step'));
        if ($(this).hasClass('vi-wcaio-va-qty-add')){
            val +=step;
        }else {
            val -=step;
        }
        qty_input.val(val).trigger('change');
    });
    $(document).on('click', '.vi-wcaio-va-product-bt-atc-cancel, .vi-wcaio-va-cart-form-overlay', function () {

        $('.vi-wcaio-va-cart-form-wrap-wrap').remove();

    });
    $(document).on('click', '.vi-wcaio-loop-variable-bt-atc:not(.vicatna-loop-atc-button)', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let button = $(this), product_id = $(this).data('product_id') || '';
        if (!product_id) {
            button= button.closest('a.vi-wcaio-loop-variable-bt-atc');
            product_id = button.data('product_id') || '';
        }
        if (!product_id) {
            window.location.href = button.attr('href');
        }
        $.ajax({
            url: viwcaio_va_params.wc_ajax_url.toString().replace('%%endpoint%%', 'viwcaio_show_variation'),
            type: 'POST',
            data: {
                product_id: product_id,
                vicaio_nonce: viwcaio_ajax_atc_params.nonce
            },
            beforeSend: function () {
                button.addClass('vi-wcaio-product-bt-atc-loading');
            },
            success: function (response) {
                if (response.status === 'error' && response.url) {
                    window.location.href = response.url;
                    return false;
                }
                $(document.body).prepend(response.html);
                $('.vi-wcaio-va-cart-swatches:not(.vi-wcaio-va-cart-swatches-init)').each(function () {
                    $(this).addClass('vi-wcaio-va-cart-swatches-init vi_wpvs_variation_form').viwcaio_get_variations(viwcaio_va_params);
                    // Babystreet theme of theAlThemist
                    if ($(this).find('.babystreet-wcs-swatches').length) {
                        $(this).babystreet_wcs_variation_swatches_form();
                    }
                });
                // WooCommerce Product Variations Swatches plugin of VillaTheme
                $(document.body).trigger('vi_wpvs_variation_form');
            },
            complete: function () {
                button.removeClass('vi-wcaio-product-bt-atc-loading');
            }
        });
    });
});