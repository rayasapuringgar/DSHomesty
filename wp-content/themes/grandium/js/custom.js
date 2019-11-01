(function ($) {
	"use strict";

    /*-- VARIABLES --*/
	var window_width = $(window).innerWidth(),
	    window_height = $(window).innerHeight(),
        site_backtop = $(".site-backtop"),
        site_loading = $(".site-loading");
    /*-- VARIABLES END--*/

    /*-- FUNCTIONS --*/
    function backTop() {
		if ($(window).scrollTop() > 40 && window_width > 767) {
			$(site_backtop).fadeIn();
		} else {
			$(site_backtop).fadeOut();
		}
	}
    function loadingStop() {
		$(site_loading).delay(100).fadeOut("slow");
	}
    /*-- FUNCTIONS END --*/

	/*-- BACK TOP --*/
    $(".site-backtop").on("click", function (e) {
        e.preventDefault();
		$("body, html").animate({scrollTop: 0}, 800);
    });
	/*-- BACK TOP END --*/

    /*-- HEADER MENU --*/
    $(".site-header .header-nav li.sub > a").on("click", function (e) {
        if (window_width < 1200) {
            e.preventDefault();
            var parent = $(this).parent("li"),
                target = $(this).siblings("ul");

            if (parent.hasClass("active")) {
                target.hide();
                parent.removeClass("active");
            } else {
                target.show();
                parent.addClass("active");
            }
        }
    });
	/*-- HEADER MENU END --*/

	/*-- HEADER TOGGLE MENU --*/
    $(".site-header .header-toggle").on("click", function (e) {
        e.preventDefault();
        var parent = $(".site-header"),
            target = $(".site-header .header-nav");

        if (target.is(":visible")) {
            parent.removeClass("nav-open");
        } else {
            parent.addClass("nav-open");
        }
    });
	/*-- HEADER TOGGLE MENU END --*/

    /*-- BACKGROUND IMAGES --*/
    $("[data-background]").each(function () {
        var src = $(this).data("background");
        if (src) {
            $(this).css("background-image", "url(" + src + ")");
        }
    });
	/*-- BACKGROUND IMAGES END --*/

    /*-- MAGNIFIC POPUP --*/
    if ($(".popup-photo").length) {
        $(".popup-photo").magnificPopup({
            type: 'image'
        });
    }
    if ($(".grandium-popup-gallery").length) {
        $(".grandium-popup-gallery").magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    }
    if ($(".popup-video").length) {
        $(".popup-video").magnificPopup({
            type: 'iframe'
        });
    }
    /*-- MAGNIFIC POPUP --*/


    /*-- FITVIDS --*/
    if ($(".video-full").length) {
        $(".video-full").fitVids();
    }
    /*-- FITVIDS END --*/

    /*-- WIDGET SLIDER --*/
    if ($(".widget-slider").length) {

		var h_el = $(".widget-slider .widget-carousel"),
			autoplay = h_el.attr('data-autoplay'),
			speed = h_el.attr('data-speed'),
			timeout = h_el.attr('data-timeout'),
			auto_play = autoplay ? true : false,
			time_out = timeout ? parseInt(timeout) : 5000,
			data_speed = speed ? parseInt(speed) : 250;

        $(".widget-slider .widget-carousel").owlCarousel({
            items: 1,
            nav: true,
            navText: ["", ""],
            dots: true,
            autoplay: auto_play,
            autoplayTimeout: time_out,
            smartSpeed: data_speed,
            autoHeight: true,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            onInitialized: function () {
                $(".site-header").addClass("header-over");

                if ($(".widget-rooms-carousel.top-over").length) {
                    $(".widget-slider").addClass("has-rooms");
                }
            }
        });
    }
	/*-- WIDGET SLIDER END --*/

    /*-- WIDGET GALLERY GRID --*/
    if ($(".widget-gallery-grid").length) {
        $(".widget-gallery-grid .gallery-item a").imagesLoaded({background: true}, function () {

            // Isotope
            var isotope_photos = $(".widget-gallery-grid .row");

            // Isotope Popups
            isotope_photos.on("arrangeComplete", function () {
                $(".widget-gallery-grid").magnificPopup({
                    delegate: '.isotope-item:visible a',
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                });
            });

            // Isotope Run
            isotope_photos.isotope({itemSelector: ".isotope-item"});

            // Isotope Filter
            $(".widget-filter-top ul li a").on("click", function (e) {
                e.preventDefault();
                var filter_value = $(this).attr("data-filter");
                isotope_photos.isotope({filter: filter_value});
                $(".widget-filter-top ul li").removeClass("active");
                $(this).parent("li").addClass("active");
            });
        });
    }
    /*-- WIDGET GALLERY GRID END --*/

    /*-- WIDGET GALLERY CAROUSEL --*/
    if ($(".widget-gallery-carousel").length) {
        $(".widget-gallery-carousel .widget-carousel").owlCarousel({
            center: true,
            loop: true,
            nav: true,
            navText: ["", ""],
            dots: false,
            mouseDrag: false,
            responsive: {
                0: {items: 1},
                768: {items: 3}
            }
        });
    }
	/*-- WIDGET GALLERY CAROUSEL END --*/

    /*-- WIDGET ROOMS CAROUSEL --*/
    if ($(".widget-rooms-carousel").length) {
		var rooms_el = $(".widget-rooms-carousel .widget-carousel"),
			autoplay = rooms_el.attr('data-autoplay'),
			speed = rooms_el.attr('data-speed'),
			timeout = rooms_el.attr('data-timeout'),
			lgitems = rooms_el.attr('data-lgitems'),
			mditems = rooms_el.attr('data-mditems'),
			auto_play = autoplay ? true : false,
			time_out = timeout ? parseInt(timeout) : 5000,
			data_speed = speed ? parseInt(speed) : 250,
			lg_items = lgitems ? parseInt(lgitems) : 3,
			md_items = mditems ? parseInt(mditems) : 2;
        $(".widget-rooms-carousel .widget-carousel").owlCarousel({
			autoplay: auto_play,
            autoplayTimeout: time_out,
            smartSpeed: data_speed,
            responsive: {
                0: {items: 1},
                991: {items: md_items},
                1200: {items: lg_items}
            }
        });
    }
	/*-- WIDGET ROOMS CAROUSEL END --*/

    /*-- WIDGET ROOMS DETAIL --*/
    if ($(".widget-rooms-detail").length) {

        var sync1 = $(".widget-rooms-detail .room-slider .owl-carousel"),
            sync2 = $(".widget-rooms-detail .room-thumbnails .owl-carousel");

        sync1.owlCarousel({
            items: 1,
            nav: true,
            navText: ["", ""],
            dots: false,
            mouseDrag: false
        }).on("changed.owl.carousel", function (e) {
            sync2.trigger("to.owl.carousel", [e.item.index, 250, true]);
        });

        sync2.owlCarousel({
            margin: 20,
            dots: false,
            responsive: {
                0: {items: 1},
                768: {items: 2},
                991: {items: 3}
            }
        }).on("click", ".owl-item a", function (e) {
            e.preventDefault();
            sync1.trigger("to.owl.carousel", [$(this).parent().index(), 250, true]);
        });
    }
	/*-- WIDGET ROOMS DETAIL END --*/

    /*-- WIDGET BLOG LIST --*/
    if ($(".widget-blog-list").length) {
        $(".widget-blog-list .media-gallery .media-carousel").owlCarousel({
            items: 1,
            navText: ["", ""]
        });
    }
	/*-- WIDGET BLOG LIST END --*/

    /*-- WIDGET BLOG CAROUSEL --*/
    if ($(".widget-blog-carousel").length) {
		var blog_el = $(".widget-blog-carousel .widget-carousel"),
			autoplay = blog_el.attr('data-autoplay'),
			speed = blog_el.attr('data-speed'),
			timeout = blog_el.attr('data-timeout'),
			lgitems = blog_el.attr('data-lgitems'),
			mditems = blog_el.attr('data-mditems'),
			smitems = blog_el.attr('data-smitems'),
			auto_play = autoplay ? true : false,
			time_out = timeout ? parseInt(timeout) : 5000,
			data_speed = speed ? parseInt(speed) : 250,
			lg_items = lgitems ? parseInt(lgitems) : 4,
			md_items = mditems ? parseInt(mditems) : 3,
			sm_items = smitems ? parseInt(smitems) : 2;

        $(".widget-blog-carousel .widget-carousel").owlCarousel({
			autoplay: auto_play,
            autoplayTimeout: time_out,
            smartSpeed: data_speed,
            autoHeight: true,
            responsive: {
                0: {items: 1},
                768: {items: sm_items},
                992: {items: md_items},
                1200: {items: lg_items}
            },
            onRefreshed: function () {
                var items = $(".widget-blog-carousel .widget-carousel .blog-item"),
                    height = 0;

                items.removeAttr("style");
                items.each(function () {
                    if ($(this).height() > height) {
                        height = $(this).height();
                    }
                });
                items.css("height", height);
            }
        });

        $(".widget-blog-carousel .media-gallery .media-carousel").owlCarousel({
            items: 1,
            mouseDrag: false,
            navText: ["", ""]
        });
    }
	/*-- WIDGET BLOG CAROUSEL END --*/

    /*-- WIDGET BLOG SINGLE --*/
    if ($(".widget-blog-single").length) {
        $(".widget-blog-single .media-gallery .media-carousel").owlCarousel({
            items: 1,
            nav: true,
            dots: false,
            navText: ["", ""],
            mouseDrag: false,
            autoplay: true
        });
    }
	/*-- WIDGET BLOG SINGLE END --*/

    /*-- WIDGET TESTIMONIALS CAROUSEL --*/
    if ($(".widget-testimonials-carousel").length) {
		var tes_el = $(".widget-testimonials-carousel .widget-carousel"),
			autoplay = tes_el.attr('data-autoplay'),
			speed = tes_el.attr('data-speed'),
			timeout = tes_el.attr('data-timeout'),
			mditems = tes_el.attr('data-mditems'),
			smitems = tes_el.attr('data-smitems'),
			auto_play = autoplay ? true : false,
			time_out = timeout ? parseInt(timeout) : 5000,
			data_speed = speed ? parseInt(speed) : 250,
			md_items = mditems ? parseInt(mditems) : 3,
			sm_items = smitems ? parseInt(smitems) : 2;

        $(".widget-testimonials-carousel .widget-carousel").owlCarousel({
            margin: 40,
			autoplay: auto_play,
            autoplayTimeout: time_out,
            smartSpeed: data_speed,
            responsive: {
                0: {items: 1},
                768: {items: sm_items},
                992: {items: md_items}
            }
        });
    }
	/*-- WIDGET TESTIMONIALS CAROUSEL END --*/

    /*-- WIDGET FEATURES CAROUSEL --*/
    if ($(".widget-features-carousel").length) {
        $(".widget-features-carousel .widget-carousel").owlCarousel({
            margin: 40,
            responsive: {
                0: {items: 1},
                768: {items: 2},
                992: {items: 3},
                1200: {items: 5}
            }
        });
    }
	/*-- WIDGET FEATURES CAROUSEL END --*/


    /*-- WIDGET TEAM CAROUSEL --*/
    if ($(".widget-team-carousel").length) {
        $(".widget-team-carousel .widget-carousel").owlCarousel({
            margin: 50,
            responsive: {
                0: {items: 1},
                768: {items: 2},
                992: {items: 3},
                1200: {items: 4}
            }
        });
    }
	/*-- WIDGET TEAM CAROUSEL END --*/

	if ($('.site-header.sticky-header').size()) {

        var $nav = $('.site-header.sticky-header');
        var $navTop = $nav.offset().top+100;
        var pegarNav = function () {
            var $scrollTop = $(window).scrollTop();
            if ($scrollTop < $navTop) {
                $nav.removeClass('fixed')
            } else {
                $nav.addClass('fixed')
            }
        };

        $(window).on('scroll',pegarNav);
    }

	/*-- WINDOW SCROLL --*/
	$(window).scroll(function () {
		backTop();
	});
	/*-- WINDOW SCROLL END --*/

	/*-- WINDOW LOAD --*/
	$(window).load(function () {
		loadingStop();
	});
	/*-- WINDOW LOAD END --*/

	/*-- WINDOW RESIZE --*/
	$(window).resize(function () {
        window_width = $(window).innerWidth();
	    window_height = $(window).innerHeight();
	});
	/*-- WINDOW RESIZE END --*/

})(jQuery);
