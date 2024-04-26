(function ($) {
    'use strict';
    // if (typeof viwcaio_sc_params === 'undefined') {
    //     return false;
    // }
    $(document).ready(function () {
        setTimeout(function () {
            $(document).trigger('viwcaio_sidebar_cart_init');
        },100);
    });
    $(document).on('viwcaio_sidebar_cart_init',function () {
        if (!$('.vi-wcaio-sidebar-cart-wrap').length){
            setTimeout(function () {
                $(document).trigger('viwcaio_sidebar_cart_init');
            },100);
            return false;
        }
        if ($('.vi-wcaio-sidebar-cart-wrap:not(.vi-wcaio-sidebar-cart-wrap-init)').length) {
            $('.vi-wcaio-sidebar-cart-wrap:not(.vi-wcaio-sidebar-cart-wrap-init)').addClass('vi-wcaio-sidebar-cart-wrap-init');
            viwcaio_sidebar_cart_init();
        }
    });
    $(window).on('resize', function () {
        vi_wcaio_sc_design($('.vi-wcaio-sidebar-cart-content-wrap'));
    });

    function viwcaio_sidebar_cart_init() {
        vi_wcaio_sc_icon_toggle(true);
        $(document).on('mouseenter', '.vi-wcaio-sidebar-cart-icon-wrap', function () {
            if ($(this).hasClass('vi-wcaio-sidebar-cart-icon-wrap-click')) {
                $(this).removeClass('vi-wcaio-sidebar-cart-icon-wrap-mouseleave').addClass('vi-wcaio-sidebar-cart-icon-wrap-mouseenter');
            } else {
                vi_wcaio_sc_toggle('show');
            }
        }).on('mouseleave', '.vi-wcaio-sidebar-cart-icon-wrap', function () {
            if ($(this).hasClass('vi-wcaio-sidebar-cart-icon-wrap-mouseenter')) {
                $(this).removeClass('vi-wcaio-sidebar-cart-icon-wrap-mouseenter').addClass('vi-wcaio-sidebar-cart-icon-wrap-mouseleave');
            }
        }).on('click', '.vi-wcaio-sidebar-cart-icon-wrap', function () {
            if ($(this).hasClass('vi-wcaio-sidebar-cart-icon-wrap-click')) {
                vi_wcaio_sc_toggle('show');
            }
        });
        $(document).on('click', '.vi-wcaio-sidebar-cart-overlay, .vi-wcaio-sidebar-cart-close-wrap', function () {
            if (!$(this).hasClass('vi-wcaio-not-hidden')) {
                vi_wcaio_sc_toggle('hide');
            }
        });
        $(document).on('click keydown', '.vi-wcaio-sidebar-cart-wrap.vi-wcaio-sidebar-cart-wrap-warning', function () {
            vi_wcaio_hide_message();
        });
        $('.vi-wcaio-sidebar-cart-footer-pd-wrap-wrap:not(.vi-wcaio-disabled):not(.vi-wcaio-slide-init)').each(function () {
            vi_wcaio_sc_flexslider($(this));
        });
        if (typeof viwcaio_sc_params === 'undefined') {
            return false;
        }
        viwcaio_sidebar_cart_update();
    }

    function viwcaio_sidebar_cart_update() {
        viwcaio_sidebar_cart_refresh(
            viwcaio_sc_params.wc_ajax_url.toString().replace('%%endpoint%%', 'viwcaio_get_cart_fragments'),
            {viwcaio_get_cart_fragments: 1, vicaio_nonce: viwcaio_sc_params.nonce}
        );
        $(document.body).on('vartable_global_add_finished', function (evt) {
            // Woocommerce Variations Table - Grid - Spyros Vlachopoulos v1.4.14
            if ($('.vi-wcaio-sidebar-cart-content-open').length) {
                return true;
            }
            let cart = $('.vi-wcaio-sidebar-cart-wrap');
            let effect_after_atc = cart.data('effect_after_atc'),
                fly_to_cart = cart.data('fly_to_cart');
            if (cart.find('.vi-wcaio-sidebar-cart.vi-wcaio-disabled').length) {
                vi_wcaio_sc_icon_may_be_toggle(cart, true, true);
                cart.find('.vi-wcaio-sidebar-cart').removeClass('vi-wcaio-disabled');
            } else if ($('.vi-wcaio-sidebar-cart-icon-wrap.vi-wcaio-sidebar-cart-icon-wrap-close').length) {
                vi_wcaio_sc_icon_may_be_toggle(cart, true, true);
                cart = $('.vi-wcaio-sidebar-cart-wrap');
            }
            if (!effect_after_atc && !fly_to_cart) {
                return true;
            }
            if (effect_after_atc === 'open') {
                cart.addClass('vi-wcaio-sidebar-cart-wrap-open-atc');
            }
        });
        $(document.body).on('added_to_cart', function (evt, fragments, cart_hash, btn) {
            if (btn.hasClass('vi-wcaio-pd_plus-product-bt-atc') || $('.vi-wcaio-sidebar-cart-content-open').length) {
                return false;
            }
            if (!btn.hasClass('vi-wcaio-product-bt-atc-loading') && typeof wc_cart_fragments_params === "undefined"){
                $(document).trigger('viwcaio_after_update_cart',[{fragments:fragments,cart_hash:cart_hash}, true]);
            }
            let cart = $('.vi-wcaio-sidebar-cart-wrap');
            let effect_after_atc = cart.data('effect_after_atc'),
                fly_to_cart = cart.data('fly_to_cart');
            if (cart.find('.vi-wcaio-sidebar-cart.vi-wcaio-disabled').length) {
                vi_wcaio_sc_icon_may_be_toggle(cart, true, true);
                cart.find('.vi-wcaio-sidebar-cart').removeClass('vi-wcaio-disabled');
            } else if ($('.vi-wcaio-sidebar-cart-icon-wrap.vi-wcaio-sidebar-cart-icon-wrap-close').length) {
                vi_wcaio_sc_icon_may_be_toggle(cart, true, true);
                cart = $('.vi-wcaio-sidebar-cart-wrap');
            }
            if (!effect_after_atc && !fly_to_cart) {
                return false;
            }
            if (fly_to_cart) {
                let img_product = viwcaio_get_img_product(btn), sc_icon = $('.vi-wcaio-sidebar-cart-icon-wrap');
                if ($(img_product).length && sc_icon.length) {
                    img_product = $(img_product);
                    let img_product_wrap, img_product_t, img_top, img_left, img_width, img_height,
                        sc_icon_top = sc_icon.offset().top || cart.offset().top,
                        sc_icon_left = sc_icon.offset().left || cart.offset().left;
                    if (img_product.closest('.woocommerce-product-gallery__wrapper').length) {
                        img_product_wrap = img_product.closest('.woocommerce-product-gallery__wrapper');
                    } else if (img_product.closest('.woocommerce-product-gallery__image').length) {
                        img_product_wrap = img_product.closest('.woocommerce-product-gallery__image');
                    }
                    if (img_product_wrap && img_product_wrap.length) {
                        if (img_product_wrap.find('.flex-active-slide').length) {
                            img_product_t = img_product_wrap.find('.flex-active-slide');
                        } else if (img_product_wrap.find('.slick-active').length) {
                            img_product_t = img_product_wrap.find('.slick-active');
                        } else if (img_product_wrap.find('.active').length) {
                            img_product_t = img_product_wrap.find('.active');
                        }
                    }
                    if (!img_product_t || !$(img_product_t).length) {
                        img_product_t = img_product;
                    }
                    if (img_product_t.find('img').length) {
                        img_product_t = img_product_t.find('img').first();
                    }
                    img_top = img_product_t.offset().top;
                    img_left = img_product_t.offset().left;
                    img_width = img_product_t.width();
                    img_height = img_product_t.height();
                    $('.vi-wcaio-img-flying').remove();
                    $('body').append('<div class="vi-wcaio-img-flying"></div>');
                    let img_flying = $('div.vi-wcaio-img-flying');
                    img_product.clone().appendTo(img_flying);
                    img_flying.css({
                        'top': img_top + 'px',
                        'left': img_left + 'px',
                        'width': img_width + 'px',
                        'height': img_height + 'px'
                    }).fadeIn("slow");
                    img_flying.animate({
                        'width': (img_width * 0.6) + 'px',
                        'height': (img_height * 0.6) + 'px',
                        top: '+=' + (img_height * 0.2) + 'px',
                        left: '+=' + (img_width * 0.2) + 'px'
                    }, 400, 'swing', function () {
                        img_flying.animate({
                            top: sc_icon_top + 'px',
                            left: sc_icon_left + 'px',
                            height: '18px',
                            width: '25px'
                        }, 800, "swing", function () {
                            $('div.vi-wcaio-img-flying').fadeIn('fast', function () {
                                $('div.vi-wcaio-img-flying').remove();
                            });
                            $(document.body).trigger('viwcaio_sc_effect_after_atc', [cart, effect_after_atc]);
                        });
                    });
                } else {
                    $(document.body).trigger('viwcaio_sc_effect_after_atc', [cart, effect_after_atc]);
                }
            } else {
                $(document.body).trigger('viwcaio_sc_effect_after_atc', [cart, effect_after_atc]);
            }
        });
        $(document.body).on('viwcaio_sc_effect_after_atc', function (event, cart, effect_after_atc) {
            switch (effect_after_atc) {
                case 'open':
                    vi_wcaio_sc_toggle('show');
                    break;
                case 'shake_horizontal':
                    cart.find('.vi-wcaio-sidebar-cart-icon-wrap').removeClass('vi-wcaio-sidebar-cart-icon-wrap-mouseleave vi-wcaio-sidebar-cart-icon-wrap-open').addClass('vi-wcaio-sidebar-cart-icon-wrap-effect-shake_horizontal');
                    setTimeout(function () {
                        cart.find('.vi-wcaio-sidebar-cart-icon-wrap').removeClass('vi-wcaio-sidebar-cart-icon-wrap-effect-shake_horizontal');
                    }, 1100);
                    break;
                case 'shake_vertical':
                    cart.find('.vi-wcaio-sidebar-cart-icon-wrap').removeClass('vi-wcaio-sidebar-cart-icon-wrap-mouseleave vi-wcaio-sidebar-cart-icon-wrap-open').addClass('vi-wcaio-sidebar-cart-icon-wrap-effect-shake_vertical');
                    setTimeout(function () {
                        cart.find('.vi-wcaio-sidebar-cart-icon-wrap').removeClass('vi-wcaio-sidebar-cart-icon-wrap-effect-shake_vertical');
                    }, 1100);
                    break;
            }
        })
        $(document.body).on('click', '.vi-wcaio-sidebar-cart-pd-remove-wrap a.vi-wcaio-sidebar-cart-pd-remove', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let button = $(this);
            let wrap = button.closest('.vi-wcaio-sidebar-cart-wrap'),
                data = {
                    cart_item_key: button.data('cart_item_key'),
                    vicaio_nonce: viwcaio_sc_params.nonce
                };
            $.ajax({
                url: viwcaio_sc_params.wc_ajax_url.toString().replace('%%endpoint%%', 'viwcaio_remove_item'),
                type: 'POST',
                data: data,
                beforeSend: function () {
                    wrap.find(' .vi-wcaio-sidebar-cart-loading-wrap').removeClass('vi-wcaio-disabled');
                },
                success: function (response) {
                    if (!response || response.error) {
                        window.location.reload();
                        return false;
                    }
                    wrap.addClass('vi-wcaio-sidebar-cart-wrap-updated');
                    // $(document.body).trigger("wc_fragment_refresh");
                    $(document.body).trigger('removed_from_cart', [response.fragments, response.cart_hash, button]);
                    $(document).trigger('viwcaio_after_update_cart', [response]);
                },
                error: function () {
                    wrap.find('.vi-wcaio-sidebar-cart-loading-wrap').addClass('vi-wcaio-disabled');
                }
            });
        });
        $(document.body).on('click', '.vi-wcaio-sidebar-cart-pd-wrap .vi_wcaio_change_qty', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let qty_input = $(this).closest('.vi-wcaio-sidebar-cart-pd-quantity').find('.vi_wcaio_qty');
            let val = parseFloat(qty_input.val()),
                step = parseFloat(qty_input.attr('step')),
                min = parseFloat(qty_input.attr('min')),
                max = parseFloat(qty_input.attr('max'));
            if ($(this).hasClass('vi_wcaio_plus')) {
                if (max === val) {
                    return false;
                }
                val += step;
            } else {
                if (min === val) {
                    return false;
                }
                val -= step;
            }
            qty_input.val(val).trigger('change');
        });
        $(document.body).on('change', '.vi-wcaio-sidebar-cart-pd-wrap input.vi_wcaio_qty', function (e) {
            e.preventDefault();
            e.stopPropagation();
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
            $(this).addClass('vi_wcaio_qty_update').closest('.vi-wcaio-sidebar-cart-wrap').find('.vi-wcaio-sidebar-cart-bt-update').removeClass('vi-wcaio-disabled');
        });
        $(document.body).on('click', '.vi-wcaio-sidebar-cart-wrap .vi-wcaio-sidebar-cart-bt-update', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let button = $(this);
            let wrap = button.closest('.vi-wcaio-sidebar-cart-wrap'), data;
            if (wrap.find('.vi_wcaio_qty_update').length) {
                data = wrap.find('.vi-wcaio-sidebar-cart-products input.vi_wcaio_qty_update').serialize();
            } else {
                data = wrap.find('.vi-wcaio-sidebar-cart-products input').serialize();
            }
            if (data.search('vicaio_nonce') === -1) {
                data += '&vicaio_nonce=' + viwcaio_sc_params.nonce;
            }
            $.ajax({
                url: viwcaio_sc_params.wc_ajax_url.toString().replace('%%endpoint%%', 'viwcaio_change_quantity'),
                type: 'POST',
                data: data,
                beforeSend: function () {
                    wrap.find(' .vi-wcaio-sidebar-cart-loading-wrap').removeClass('vi-wcaio-disabled');
                },
                success: function (response) {
                    if (!response || response.error) {
                        window.location.reload();
                        return false;
                    }
                    button.addClass('vi-wcaio-disabled');
                    $(document).trigger('viwcaio_after_update_cart',[response]);
                    // $(document.body).trigger("wc_fragment_refresh");
                    // vi_wcaio_sc_icon_may_be_toggle(wrap);
                },
                error: function () {
                    wrap.find('.vi_wcaio_qty_update').removeClass('vi_wcaio_qty_update');
                    wrap.find('.vi-wcaio-sidebar-cart-loading-wrap').addClass('vi-wcaio-disabled');
                }
            })
        });
        $(document.body).on('click', '.vi-wcaio-sidebar-cart-wrap .vi-wcaio-bt-coupon-code', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let button = $(this);
            let wrap = button.closest('.vi-wcaio-sidebar-cart-wrap');
            let data = {
                vi_wcaio_coupon_code: wrap.find('.vi-wcaio-coupon-code').val() || '',
                vicaio_nonce: viwcaio_sc_params.nonce
            };
            $.ajax({
                url: viwcaio_sc_params.wc_ajax_url.toString().replace('%%endpoint%%', 'viwcaio_apply_coupon'),
                type: 'POST',
                data: data,
                beforeSend: function () {
                    wrap.find(' .vi-wcaio-sidebar-cart-loading-wrap').removeClass('vi-wcaio-disabled');
                },
                success: function (response) {
                    if (!response) {
                        window.location.reload();
                        return false;
                    }
                    if (response.message) {
                        vi_wcaio_show_message(response.message);
                    }
                    if (response.status && response.status === 'success') {
                        $(document.body).trigger("viwcaio_fragment_refresh");
                    }else {
                        wrap.find('.vi-wcaio-sidebar-cart-loading-wrap').addClass('vi-wcaio-disabled');
                    }
                },
                error: function () {
                    wrap.find('.vi-wcaio-sidebar-cart-loading-wrap').addClass('vi-wcaio-disabled');
                }
            })
        });
    }
    function viwcaio_sidebar_cart_is_refresh(){
        let options = $('.vi-wcaio-sidebar-cart-content-wrap').data('option')||{}, refresh=false;
        if (Object.keys(options).length && $('.vi-wcaio-sidebar-cart-wrap .vi-wcaio-sidebar-cart-pd-wrap').length){
            $.each(options,function (k,v){
                switch (k){
                    case 'sc_footer_cart_total':
                        if (!$('.vi-wcaio-sidebar-cart-footer-cart_total1-'+v).length){
                            refresh++;
                        }
                        break;
                    case 'sc_pd_price_style':
                        if (!$('.vi-wcaio-sidebar-cart-pd-price-'+v).length){
                            refresh++;
                        }
                        break;
                }
            });
        }
        return refresh;
    }

    function viwcaio_sidebar_cart_refresh(url, data) {
        $(document).on('viwcaio_after_update_cart', function (e, data, just_refresh_session= false){
            let fragments = data.fragments ? data.fragments : data;
            if (fragments && 'sessionStorage' in window && window.sessionStorage !== null && typeof viwcaio_sc_params !=="undefined" ) {
                let fragment_name = viwcaio_sc_params.fragment_name,
                    cart_hash_key = viwcaio_sc_params.cart_hash_key;
                sessionStorage.setItem(fragment_name, JSON.stringify(fragments));
                localStorage.setItem( cart_hash_key, data.cart_hash );
                sessionStorage.setItem( cart_hash_key, data.cart_hash  );
                if ( data.cart_hash ) {
                    sessionStorage.setItem( 'wc_cart_created', ( new Date() ).getTime() );
                }
                if (just_refresh_session){
                    return false;
                }
            }
            if (!fragments || !Object.keys(fragments).length) {
                $(document.body).trigger('wc_fragments_ajax_error');
                return false;
            }
            $.each(fragments, function (key, value) {
                $(key).replaceWith(value);
            });
            if ( typeof wc_cart_params !== 'undefined' ){
                if ($('[name="update_cart"]').length && $('[name="update_cart"]').closest('form').length){
                    let cart_form = $('[name="update_cart"]').closest('form'),
                        sidebar_pd = $('.vi-wcaio-sidebar-cart-products'),
                        update_items = 0;
                    sidebar_pd.find('.vi_wcaio_qty').each(function (k,v){
                        let name = $(v).attr('name').replace('viwcaio_','');
                        if (cart_form.find(`input[name="${name}"]`).val() != $(v).val()) {
                            update_items++;
                            cart_form.find(`input[name="${name}"]`).val($(v).val()).trigger('change');
                        }
                    });
                    if (update_items) {
                        $('[name="update_cart"]').removeAttr('disabled').trigger('click');
                    }
                }else {
                    //location.reload();
                }
            } else if ( typeof wc_checkout_params !== 'undefined' && ( typeof viwcaio_atc === "undefined" || !viwcaio_atc.length) ) {
                $(document.body).trigger("update_checkout");
            }
            $('.vi-wcaio-sidebar-cart-wrap').addClass('vi-wcaio-sidebar-cart-wrap-updated');
            $(document.body).trigger("wc_fragments_refreshed");
        });
        $(document).on('viwcaio_fragment_refresh', function (e,url='',data=''){
            if (typeof viwcaio_sc_params !== "undefined"){
                if (!url){
                    url = viwcaio_sc_params.wc_ajax_url.toString().replace('%%endpoint%%', 'viwcaio_get_cart_fragments');
                }
                if (!data){
                    data = {viwcaio_get_cart_fragments: 1, vicaio_nonce: viwcaio_sc_params.nonce};
                }
            }
            if (!url || !data){
                return false;
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                beforeSend: function () {
                    $('.vi-wcaio-sidebar-cart-wrap').find('.vi-wcaio-sidebar-cart-loading-wrap').removeClass('vi-wcaio-disabled');
                },
                success: function (response) {
                    $(document).trigger('viwcaio_after_update_cart',[response]);
                },
                error: function (e) {
                    console.log(e)
                    $('.vi-wcaio-sidebar-cart-wrap').find('.vi-wcaio-sidebar-cart-loading-wrap').addClass('vi-wcaio-disabled');
                },
                complete: function() {
                    $('.vi-wcaio-sidebar-cart-wrap').find('.vi-wcaio-sidebar-cart-loading-wrap').addClass('vi-wcaio-disabled');
                }
            });
        });
        $(document.body).on('wc_fragments_refreshed wc_fragments_ajax_error', function () {
            if ($('.vi-wcaio-sidebar-cart-wrap-open-atc').length){
                $(document.body).trigger('viwcaio_sc_effect_after_atc', [$('.vi-wcaio-sidebar-cart-wrap-open-atc').removeClass('vi-wcaio-sidebar-cart-wrap-open-atc').data('effect_after_atc')]);
                return true;
            }
            $('.vi-wcaio-sidebar-cart-wrap').find('.vi-wcaio-sidebar-cart-loading-wrap').addClass('vi-wcaio-disabled');
            $('.vi-wcaio-sidebar-cart-wrap').removeClass('vi-wcaio-sidebar-cart-wrap-updated');
            vi_wcaio_sc_icon_may_be_toggle($('.vi-wcaio-sidebar-cart-wrap'));
            $('.vi-wcaio-sidebar-cart-footer-pd-wrap-wrap:not(.vi-wcaio-disabled):not(.vi-wcaio-slide-init)').each(function () {
                vi_wcaio_sc_flexslider($(this));
            });
        });
        // Refresh when load page
        if ($('.vi-wcaio-sidebar-cart-wrap.vi-wcaio-sidebar-cart-wrap-init').length ) {
            if ($('.vi-wcaio-sidebar-cart-wrap:not(.vi-wcaio-sidebar-cart-wrap-fragments-load)').length) {
                if (viwcaio_sidebar_cart_is_refresh()){
                    setTimeout(function () {
                        $(document).trigger("viwcaio_fragment_refresh", [url, data]);
                    }, 100);
                    return false;
                }
                if (typeof wc_cart_fragments_params !== "undefined"){
                    $(document.body).on('wc_fragments_loaded',function (){
                        if ($('.vi-wcaio-sidebar-cart-wrap:not(.vi-wcaio-sidebar-cart-wrap-fragments-load)').length){
                            $('.vi-wcaio-sidebar-cart-wrap:not(.vi-wcaio-sidebar-cart-wrap-fragments-load)').addClass('vi-wcaio-sidebar-cart-wrap-fragments-load');
                            setTimeout(function () {
                                $(document).trigger("viwcaio_fragment_refresh", [url, data]);
                            }, 100);
                        }
                    });
                    return false;
                }
                $('.vi-wcaio-sidebar-cart-wrap:not(.vi-wcaio-sidebar-cart-wrap-fragments-load)').addClass('vi-wcaio-sidebar-cart-wrap-fragments-load');
                let $supports_html5_storage =  'sessionStorage' in window && window.sessionStorage !== null ;
                if (!$supports_html5_storage || typeof viwcaio_sc_params === "undefined"){
                    setTimeout(function () {
                        $(document).trigger("viwcaio_fragment_refresh", [url, data]);
                    }, 100);
                }
                let cart_hash    = sessionStorage.getItem( viwcaio_sc_params.cart_hash_key );
                // Refresh when storage changes in another tab
                $(window).on( 'storage onstorage', function ( e ) {
                    if (
                        cart_hash === e.originalEvent.key && localStorage.getItem( cart_hash ) !== sessionStorage.getItem( cart_hash )
                    ) {
                        setTimeout(function () {
                            $(document).trigger("viwcaio_fragment_refresh", [url, data]);
                        }, 100);
                    }
                });
                try {
                    let wc_fragments = JSON.parse( sessionStorage.getItem( viwcaio_sc_params.fragment_name ) ),
                        cookie_hash  = Cookies.get( 'woocommerce_cart_hash'),
                        cart_created = sessionStorage.getItem( 'wc_cart_created' ),
                        day_in_ms    = ( 24 * 60 * 60 * 1000 );
                    if ( cart_hash === null || cart_hash === undefined || cart_hash === '' ) {
                        cart_hash = '';
                    }
                    if ( cookie_hash === null || cookie_hash === undefined || cookie_hash === '' ) {
                        cookie_hash = '';
                    }

                    if ( cart_hash && ( cart_created === null || cart_created === undefined || cart_created === '' ) ) {
                        throw 'No cart_created';
                    }

                    if ( cart_created ) {
                        var cart_expiration = ( ( 1 * cart_created ) + day_in_ms ),
                            timestamp_now   = ( new Date() ).getTime();
                        if ( cart_expiration < timestamp_now ) {
                            throw 'Fragment expired';
                        }
                    }

                    if ( wc_fragments && wc_fragments['div.widget_shopping_cart_content'] && cart_hash === cookie_hash ) {
                        $.each( wc_fragments, function( key, value ) {
                            $( key ).replaceWith(value);
                        });
                    } else {
                        throw 'No fragment';
                    }

                } catch( err ) {
                    console.log(err)
                    setTimeout(function () {
                        $(document).trigger("viwcaio_fragment_refresh", [url, data]);
                    }, 100);
                }
            } else {
                $('.vi-wcaio-sidebar-cart-footer-pd-wrap-wrap:not(.vi-wcaio-disabled):not(.vi-wcaio-slide-init)').each(function () {
                    vi_wcaio_sc_flexslider($(this));
                });
            }
        }
    }

    function vi_wcaio_sc_toggle(action = '', new_effect = '') {
        let wrap = $('.vi-wcaio-sidebar-cart-content-wrap'),
            position = $('.vi-wcaio-sidebar-cart').data('position'),
            effect = $('.vi-wcaio-sidebar-cart').data('effect');
        if (action === 'hide' && wrap.hasClass('vi-wcaio-sidebar-cart-content-close')) {
            return false;
        }
        if (action === 'show' && wrap.hasClass('vi-wcaio-sidebar-cart-content-open')) {
            return false;
        }
        vi_wcaio_sc_design(wrap);
        let type = (position === 'top_left' || position === 'bottom_left') ? 'left' : 'right';
        if (action === 'start' && new_effect) {
            if (wrap.hasClass('vi-wcaio-sidebar-cart-content-close')) {
                wrap.removeClass('vi-wcaio-sidebar-cart-content-open vi-wcaio-sidebar-cart-content-open-' + effect + '-' + type);
                wrap.addClass('vi-wcaio-sidebar-cart-content-close vi-wcaio-sidebar-cart-content-close-' + new_effect + '-' + type);
            } else {
                wrap.addClass('vi-wcaio-sidebar-cart-content-open vi-wcaio-sidebar-cart-content-open-' + new_effect + '-' + type);
                wrap.removeClass('vi-wcaio-sidebar-cart-content-close vi-wcaio-sidebar-cart-content-close-' + effect + '-' + type);
            }
            $('.vi-wcaio-sidebar-cart').data('effect', new_effect);
            return false;
        }
        new_effect = new_effect ? new_effect : effect;
        let old_position = $('.vi-wcaio-sidebar-cart').data('old_position') || '';
        let old_type = old_position ? ((old_position === 'top_left' || old_position === 'bottom_left') ? 'left' : 'right') : type;
        let class_open = 'vi-wcaio-sidebar-cart-content-open vi-wcaio-sidebar-cart-content-open-' + new_effect + '-' + type,
            class_close = 'vi-wcaio-sidebar-cart-content-close vi-wcaio-sidebar-cart-content-close-' + new_effect + '-' + type,
            class_open_old = 'vi-wcaio-sidebar-cart-content-open vi-wcaio-sidebar-cart-content-open-' + effect + '-' + old_type,
            class_close_old = 'vi-wcaio-sidebar-cart-content-close vi-wcaio-sidebar-cart-content-close-' + effect + '-' + old_type + ' vi-wcaio-sidebar-cart-content-close-' + effect + '-' + type;
        if (wrap.hasClass('vi-wcaio-sidebar-cart-content-close')) {
            wrap.addClass(class_open).removeClass(class_close).removeClass(class_close_old);
            $('html').addClass('vi-wcaio-html-non-scroll');
            $('.vi-wcaio-sidebar-cart-overlay').removeClass('vi-wcaio-disabled');
            $('.vi-wcaio-sidebar-cart').data('effect', new_effect);
            vi_wcaio_sc_icon_toggle();
        } else {
            wrap.addClass(class_close).removeClass(class_open).removeClass(class_open_old);
            $('.vi-wcaio-sidebar-cart-overlay').addClass('vi-wcaio-disabled');
            $('html').removeClass('vi-wcaio-html-non-scroll');
            vi_wcaio_sc_icon_toggle(true);
        }
        $('.vi-wcaio-sidebar-cart').data('effect', new_effect);
    }

    function vi_wcaio_sc_icon_may_be_toggle(cart, show = false, added_to_cart = false) {
        $('.vi-wcaio-sidebar-cart-loading-wrap').addClass('vi-wcaio-disabled');
        if (show) {
            vi_wcaio_sc_icon_toggle(true, added_to_cart);
            return false;
        } else if (!cart) {
            vi_wcaio_sc_toggle('hide');
            vi_wcaio_sc_icon_toggle();
        }
        cart = $(cart);
        if (cart.length && (cart.data('empty_enable') || cart.find('.vi-wcaio-sidebar-cart-pd-wrap').length)) {
            if (cart.find('.vi-wcaio-sidebar-cart-pd-wrap').length) {
                $('.vi-wcaio-sidebar-cart-icon-wrap').removeClass('vi-wcaio-disabled');
            }
            return false;
        }
        vi_wcaio_sc_toggle('hide');
        $('.vi-wcaio-coupon-code').val('');
        vi_wcaio_sc_icon_toggle(true);
    }

    function vi_wcaio_sc_icon_toggle(show = false, added_to_cart = false) {
        if (show) {
            if (!added_to_cart && !$('.vi-wcaio-sidebar-cart-wrap').data('empty_enable') && !$('.vi-wcaio-sidebar-cart-wrap').find('.vi-wcaio-sidebar-cart-pd-wrap').length) {
                return false;
            }
            $('.vi-wcaio-sidebar-cart-icon-wrap').removeClass('vi-wcaio-disabled vi-wcaio-sidebar-cart-icon-wrap-close vi-wcaio-sidebar-cart-icon-wrap-mouseenter vi-wcaio-sidebar-cart-icon-wrap-mouseleave');
            $('.vi-wcaio-sidebar-cart-icon-wrap').addClass('vi-wcaio-sidebar-cart-icon-wrap-open');
        } else {
            $('.vi-wcaio-sidebar-cart-icon-wrap').addClass('vi-wcaio-sidebar-cart-icon-wrap-close');
            $('.vi-wcaio-sidebar-cart-icon-wrap').removeClass('vi-wcaio-sidebar-cart-icon-wrap-open vi-wcaio-sidebar-cart-icon-wrap-mouseenter vi-wcaio-sidebar-cart-icon-wrap-mouseleave');
        }
    }

    function viwcaio_get_img_product(btn) {
        let product = btn.closest('.vi-wcaio-sb-wrap'), img_product;//Sticky add to cart
        if (!product.length) {//Uncode
            product = btn.closest('.tmb-woocommerce');
        }
        if (!product.length) {
            product = btn.closest('.product');
        }
        if (!product.length) {
            product = btn.closest('.item-product');
        }
        if (!product.length) {//Milano
            product = btn.closest('.product-item');
        }
        if (!product.length) {//Infinite
            product = btn.closest('.gdlr-core-item-list');
        }
        if (!product.length) {//Zella
            product = btn.closest('.product-warp-item');
        }
        if (!product.length) {//WooCommerce Food plugin
            product = btn.closest('.item-grid');
        }
        if (!product.length) {
            product = btn.closest('.product__box');
        }
        if (!product.length) {
            product = btn.closest('.woo-entry-inner');
        }
        if (product.find('.vi-wcaio-sb-product-img').length) {
            img_product = product.find('.vi-wcaio-sb-product-img').first();
        } else if (product.find('.wp-post-image').length) {
            img_product = product.find('.wp-post-image').first();
        } else if (product.find('.attachment-shop_catalog').length) {//Authentic, //Zella ,Skudmart 1.0.6
            img_product = product.find('.attachment-shop_catalog').first();
        } else if (product.find('.gdlr-core-product-thumbnail').length) {//Infinite
            img_product = product.find('.gdlr-core-product-thumbnail').first();
        } else if (product.find('.woo-entry-image-main').length) {//ocean
            img_product = product.find('.woo-entry-image-main').first();
        } else if (product.find('.wp-post-image.vi-load').length) { //swatches demo
            img_product = product.find('.wp-post-image.vi-load').first();
        } else if (product.find('.attachment-woocommerce_thumbnail').length) {
            img_product = product.find('.attachment-woocommerce_thumbnail').first();
        }
        if (!img_product) {
            if (product && product.find('img')) {
                img_product = product.find('img').first();
            } else {
                img_product = false;
            }
        }
        return img_product;
    }

    function vi_wcaio_sc_design(wrap) {
        wrap = $(wrap);
        if (window.innerWidth < 782) {
            wrap.css({maxHeight: window.innerHeight});
        }
    }

    function vi_wcaio_sc_flexslider(wrap) {
        wrap = $(wrap);
        let rtl = false;
        if (wrap.closest('.vi-wcaio-sidebar-cart-rtl').length) {
            rtl = true;
        }
        wrap.find('img').each(function () {
            $(this).attr('src', $(this).data('src'));
        });
        wrap.addClass('vi-wcaio-slider-init');
        wrap.viwcaio_flexslider({
            namespace: 'vi-wcaio-slider-',
            selector: '.vi-wcaio-sidebar-cart-footer-pd-wrap .vi-wcaio-sidebar-cart-footer-pd',
            animation: 'slide',
            animationLoop: 1,
            itemWidth: 145,
            itemMargin: 10,
            controlNav: false,
            maxItems: window.outerWidth > 480 ? 2 : 1,
            reverse: rtl,
            rtl: rtl,
            move: 1,
            touch: true,
            slideshow: false,
        });
    }

    function vi_wcaio_show_message(message) {
        $('.vi-wcaio-sidebar-cart-wrap').removeClass('vi-wcaio-sidebar-cart-wrap-warning');
        if (!$('.vi-wcaio-warning-wrap').length) {
            $('body').append('<div class="vi-wcaio-warning-wrap vi-wcaio-warning-wrap-open"><div>' + message + '</div></div>');
        } else {
            $('.vi-wcaio-warning-wrap').removeClass('vi-wcaio-warning-wrap-close').addClass('vi-wcaio-warning-wrap-open');
            $('.vi-wcaio-warning-wrap > div').html(message);
        }
        setTimeout(function () {
            $('.vi-wcaio-sidebar-cart-wrap').addClass('vi-wcaio-sidebar-cart-wrap-warning');
        }, 1000);
        setTimeout(function () {
            vi_wcaio_hide_message();
        }, 15000);
    }

    function vi_wcaio_hide_message() {
        $('.vi-wcaio-sidebar-cart-wrap').removeClass('vi-wcaio-sidebar-cart-wrap-warning');
        $('.vi-wcaio-warning-wrap').addClass('vi-wcaio-warning-wrap-close').removeClass('vi-wcaio-warning-wrap-open');
    }
    window.viwcaio_sidebar_cart_is_refresh = viwcaio_sidebar_cart_is_refresh;
    window.vi_wcaio_sc_toggle = vi_wcaio_sc_toggle;
    window.vi_wcaio_sc_icon_may_be_toggle = vi_wcaio_sc_icon_may_be_toggle;
    window.vi_wcaio_sc_icon_toggle = vi_wcaio_sc_icon_toggle;
    window.vi_wcaio_sc_flexslider = vi_wcaio_sc_flexslider;
    window.vi_wcaio_show_message = vi_wcaio_show_message;
    window.vi_wcaio_hide_message = vi_wcaio_hide_message;
})(jQuery);