/**
 * Main theme JavaScript file
 */
(function($) {
    'use strict';

    // Mobile menu toggle
    $('.menu-toggle').on('click', function() {
        $(this).toggleClass('is-active');
        $('.main-navigation').toggleClass('is-active');
    });

    // Keyboard navigation for dropdown menus
    $('.main-navigation').find('a').on('focus blur', function() {
        $(this).parents('li').toggleClass('focus');
    });

    // Smooth scroll to anchor links
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
                return false;
            }
        }
    });

    // Back to top button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').addClass('show');
        } else {
            $('.back-to-top').removeClass('show');
        }
    });

    $('.back-to-top').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

})(jQuery); 