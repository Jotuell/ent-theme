var $ = require('jquery');

require('munger');
require('foundation-sites');

$(function () {
    // Init Foundation
    $(document).foundation();

    // -----------
    // HEADER MENU
    // -----------
    var smallMenu = $('[data-small-menu]');
    var largeMenu = $('[data-large-menu]');
    var smallMenuTop, largeMenuTop;

    $(window).scroll(function () {
        if (Foundation.MediaQuery.atLeast('large')) {
            $('body').removeClass('small-scrolled');

            if (!largeMenuTop) {
                largeMenuTop = largeMenu.offset().top;
            }

            if ($('[data-search-modal]').is(':visible')) {
                $('[data-search-modal]').fadeOut();
            }

            if ($(this).scrollTop() > largeMenuTop) {
                $('body').addClass('large-scrolled');
                $('main').css('marginTop', largeMenu.height());
            } else {
                $('body').removeClass('large-scrolled');
                $('main').css('marginTop', '0');
            }
        } else {
            $('body').removeClass('large-scrolled');

            if (!smallMenuTop) {
                smallMenuTop = smallMenu.offset().top;
            }

            if ($(this).scrollTop() > smallMenuTop) {
                $('body').addClass('small-scrolled');
                $('main').css('marginTop', smallMenu.outerHeight());
            } else {
                $('body').removeClass('small-scrolled');
                $('main').css('marginTop', '0');
            }
        }
    });

    $('[data-search-toggle]').click(function (e) {
        e.preventDefault();

        if (Foundation.MediaQuery.atLeast('large')) {
            if (!$('[data-search-modal]').is(':visible')) {
                $('html, body').animate({
                    scrollTop: 0,
                }, 100, 'swing', function () {
                    setTimeout(function () {
                        $('[data-search-modal]').fadeIn({
                            complete: function () {
                                $('[data-search-modal]').find('input').focus();
                            }
                        });
                    }, 50);
                });
            } else {
                $('[data-search-modal]').fadeOut();
            }
        }
    });

    $('[data-search-modal-close]').click(function (e) {
        e.preventDefault();
        $('[data-search-modal]').fadeOut();
    });

    var menuToggle = $('[data-menu-toggle]');
    var menuToggleIcon = menuToggle.find('i');

    menuToggle.click(function (e) {
        e.preventDefault();

        $('body').toggleClass('noscroll');

        if ($('[data-large-menu]').is(':visible')) {
            $('[data-large-menu]').hide();
            menuToggleIcon.attr('class', menuToggleIcon.data('closed-class'));
        } else {
            $('[data-large-menu]').css('display', 'flex');
            $('[data-large-menu]').find('.row').scrollTop(0);
            menuToggleIcon.attr('class', menuToggleIcon.data('opened-class'));
        }
    });

    // -----
    // INDEX
    // -----
    $('[index-featured-projects]').slick({
        autoplay: true,
        autoplaySpeed: 4000,
        dots: true,
        arrows: false,
        adaptiveHeight: true,
    });

    // CELOBERT PAGE
    $('[data-client-logos]').slick({
        autoplay: true,
        autoplaySpeed: 2000,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        centerMode: true,
        variableWidth: true
    });

    // ----
    // TEAM
    // ----
    $('.team-list .team-member').hover(function () {
        var img = $(this).find('.team-member__image');
        img.css('background-image', 'url('+ img.data('team-member-alt-image') +')');
    }, function () {
        var img = $(this).find('.team-member__image');
        img.css('background-image', 'url('+ img.data('team-member-image') +')');
    });

    // --------
    // PROJECTS
    // --------
    $('[data-projects-service-filter] a').click(function(e) {
        e.preventDefault();
        var filter = $(this).data('service-id');

        $('[data-projects-service-filter] .column').removeClass('projects-service-filter__entry--active');
        $(this).parent('.column').addClass('projects-service-filter__entry--active');

        if (filter == '') {
            window.location.hash = '#service-all';
            $('[data-project]').show();
        } else {
            window.location.hash = '#service-'+ filter;

            $('[data-project]').each(function (i, el) {
                var services = $(el).data('services');
                $(el).toggle(services.indexOf(+filter) !== -1);
            });
        }
    });

    if (/^#service-/.test(window.location.hash)) {
        var service_id = window.location.hash.replace('#service-', '');
        $('[data-projects-service-filter] [data-service-id='+ service_id +']').click();
    }

    // ---------
    // GALLERIES
    // ---------
    $('[data-media-popup]').magnificPopup({ type:'image' });
    $('[data-media-gallery]').each(function () {
        /*
        var wall = new Freewall($(this));
        wall.fitWidth();
        */

        $(this).magnificPopup({
            delegate: 'a',
            type: 'image',
            /*
            image: {
                titleSrc: function(item) {
                    var author = item.el.data('author');

                    if (author.length) {
                        return item.el.attr('title') +' <small class="images-gallery__author">FOTO: '+ author +'</small>';
                    } else {
                        return item.el.attr('title');
                    }
                }
            },
            */
            gallery: {
                enabled: true,
            }
        });
    });
});
