(function ($) {
    'use strict';
    $(document).ready(function () {
        $(document.body).on('mouseenter', '.vi-wcaio-menu-cart.vi-wcaio-menu-cart-show .vi-wcaio-menu-cart-nav-wrap', function () {
            let menu_content = $('.vi-wcaio-menu-cart.vi-wcaio-menu-cart-show .vi-wcaio-menu-cart-content-wrap');
            if (!menu_content.length) {
                return false;
            }
            menu_content.addClass('vi-wcaio-menu-cart-content-wrap-show');
            let left = menu_content.offset().left, width = menu_content.outerWidth();
            if ($('body').outerWidth() < (left + width)) {
                menu_content.addClass('vi-wcaio-menu-cart-content-wrap-show-right')
            }
        });
        $(document.body).on('mouseleave', '.vi-wcaio-menu-cart.vi-wcaio-menu-cart-show', function () {
            $('.vi-wcaio-menu-cart-content-wrap-show').removeClass('vi-wcaio-menu-cart-content-wrap-show');
        });
        $(document.body).on('added_to_cart', function (evt, fragments, cart_hash, btn) {
            $('.vi-wcaio-menu-cart').each(function () {
                vi_wcaio_mc_toggle($(this), true);
            });
        });
        $(document.body).on('removed_from_cart', function (evt, fragments, cart_hash, btn) {
            let mc_show = false,
                sc_product = fragments && typeof fragments['.vi-wcaio-menu-cart-text-wrap'] !== "undefined" ? fragments['.vi-wcaio-menu-cart-text-wrap'] : '';
            if (sc_product ){
                mc_show = !$(sc_product).find('.vi-wcaio-menu-cart-empty').length;
            }
            $('.vi-wcaio-menu-cart').each(function () {
                vi_wcaio_mc_toggle($(this), mc_show);
            });
        });
    });

    window.vi_wcaio_mc_toggle = function (cart, show = false) {
        cart = $(cart);
        if (show) {
            cart.removeClass('vi-wcaio-disabled');
            return false;
        }
        if (cart.data('empty_enable') || cart.find('.widget_shopping_cart_content > ul > li').length || $('.vi-wcaio-sidebar-cart-pd-wrap').length) {
            return false;
        }
        cart.addClass('vi-wcaio-disabled');
    }
})(jQuery);
