/*********************************************************************************
 Template Name: meet Multipurpose eCommerce Bootstrap 5 Template
 Description: A perfect template to build beautiful and unique Fashion websites. It comes with nice and clean design.
 Version: 1.0
 **********************************************************************************/
/* =======================================================================
 Table of Content:

 1. Preloader Loading
 2. Sticky Header
 3. Mobile Main Menu
 4. Vertical Categories Menu
 5. Setting Box dropdown
 06. Language Picker
 07. Currency Picker
 08. Quantity Plus Minus
 09. Timer Count Down
 10. Color Swacthes
 11. Show hide Product Tags
 12. Show hide Product Filters
 13. Slick Slider
 13.1 Homepage Slideshow
 13.2 Promobar Slider 1 Items
 13.3 Top Bar Slider
 13.4 Sidebar Product
 13.5 Sidebar Product
 13.6 Category Image 3 Items
 13.7 Collection Slider 3 Items
 13.8 Collection Slider 4 Items
 3.9 Collection Slider 5 Items
 13.10 Collection Slider 6 Items
 13.11 Collection Slider 8 Items
 13.12 Products Slider 3 Items
 13.13 Products Slider 4 Items
 13.14 Products Slider 5 Items
 13.15 Logo Slider 6 Items
 13.16 Testimonial Slider 1 Items
 13.17 Testimonial Slider 2 Items
 13.18 Testimonial Slider 3 Items
 13.19 Blog Slider 3 Items
 13.20 Instagram Slider
 13.21 Service Slider 5 Items
 13.22 Grid Multiple Product
 14. Infinite Scroll js
 15. Tooltip
 16. Sidebar Categories Level links
 17. Price Range Slider
 18. Shop List-grid js
 19. Image swap on click
 20. Image to background js
 21. Links for mobiles
 22. Masonry Grid
 23. Scroll Top
 24. Tabs With Accordian Responsive
 25. Product Details Page
 26. Visitor Fake Message
 27. Product Tabs
 28. Sticky Header and Product Sticky Bottom Cart
 29. Checkout Style2 Tabs
 ======================================================================= */
//  alert('here');
// Bind the morelist Show More/Less click handler exactly once at script load.
// Doing this outside the livewire:navigated listener guarantees we can never
// stack multiple handlers across wire:navigate forward/back navigations, which
// previously caused a single click to fire two slideToggles (open-then-close).
(function ($) {
    if (window.__morelistClickBound) return;
    window.__morelistClickBound = true;
    $(document).on("click", ".morelist > li.more", function () {
        var $btn = $(this);
        if ($btn.hasClass("less")) {
            $btn.text("Show More").removeClass("less");
        } else {
            $btn.text("Show Less").addClass("less");
        }
        $btn.siblings("li.toggleable").stop(true, false).slideToggle();
    });
})(jQuery);

// Header dropdowns (language, currency, setting box, account, user menu).
// These elements sit inside wire:ignore so their DOM nodes survive
// wire:navigate. Binding click handlers inside the livewire:navigated listener
// re-attaches a fresh handler on every navigation, so a single click ends up
// toggling "active" multiple times and the dropdown never visibly opens.
// Bind exactly once with event delegation so navigation can't duplicate them.
(function ($) {
    if (window.__headerDropdownsBound) return;
    window.__headerDropdownsBound = true;

    $(document).on("click", ".language-picker .default-option", function () {
        $(this).parent().toggleClass("active");
    });
    $(document).on("click", ".language-picker .select-ul li", function () {
        var currentele = $(this).html();
        $(".language-picker .default-option li").html(currentele);
        $(this).parents(".language-picker").removeClass("active");
    });

    $(document).on("click", ".currency-picker .default-option", function () {
        $(this).parent().toggleClass("active");
    });
    $(document).on("click", ".currency-picker .select-ul li", function () {
        var currentele = $(this).html();
        $(".currency-picker .default-option li").html(currentele);
        $(this).parents(".currency-picker").removeClass("active");
    });

    $(document).on("click", ".setting-link", function () {
        $("#settingsBox").toggleClass("active");
    });
    $(document).on("click", ".account-link", function () {
        $("#accountBox").toggleClass("active");
    });
    $(document).on("click", ".user-menu", function () {
        $(".user-links").toggleClass("active");
    });

    // Single outside-click closer for all header dropdowns. Bound on document
    // so it survives body morphing during wire:navigate.
    $(document).on("click", function (e) {
        var t = $(e.target);
        if (!t.closest(".language-picker").length) {
            $(".language-picker").removeClass("active");
        }
        if (!t.closest(".currency-picker").length) {
            $(".currency-picker").removeClass("active");
        }
        if (!t.closest("#settingsBox").length && !t.closest(".setting-link").length) {
            $("#settingsBox").removeClass("active");
        }
        if (!t.closest("#accountBox").length && !t.closest(".account-link").length) {
            $("#accountBox").removeClass("active");
        }
        if (!t.closest(".user-links").length && !t.closest(".user-menu").length) {
            $(".user-links").removeClass("active");
        }
    });
})(jQuery);
document.addEventListener("livewire:navigated", () => {
    (function ($) {
        // Start of use strict
        ("use strict");

        /*-----------------------------------------
         01. Preloader Loading
         -----------------------------------------*/
        function pre_loader() {
            $("#load").fadeOut();
            $("#pre-loader").delay(500).fadeOut(500);
        }
        pre_loader();

        function dismiss() {
            $(".product-notification .close").off("click.notifClose").on("click.notifClose", function () {
                $(".product-notification").fadeOut("slow").addClass("d-none");
            });
        }
        dismiss();

        /*-----------------------------------------
         02. Sticky Header
         -----------------------------------------*/
        function sticky_header() {
            if ($(".header").hasClass("header-fixed")) {
                var nav = $(".header");
                if (nav.length) {
                    $(".header-space").remove();
                    var offsetTop = nav.offset().top,
                        headerHeight = nav.height(),
                        injectSpace = $("<div class='header-space' />").css("height", headerHeight).insertAfter(nav);
                    injectSpace.hide();
                    $(window).off("scroll.stickyHeader").on("scroll.stickyHeader", function () {
                        if ($(window).scrollTop() > offsetTop) {
                            nav.addClass("is-fixed");
                            injectSpace.show();
                        } else {
                            nav.removeClass("is-fixed");
                            injectSpace.hide();
                        }
                        if ($(window).scrollTop() > 150) {
                            nav.addClass("is-small animated fadeIn");
                        } else {
                            nav.removeClass("is-small animated fadeIn");
                        }
                    });
                }
            }
        }
        sticky_header();

        /*-----------------------------------------
         02. Sticky Header
         -----------------------------------------*/
        function sticky_menu_header() {
            if ($(window).width() > 992) {
                if ($(".main-menu-outer").hasClass("header-fixed")) {
                    var nav = $(".main-menu-outer");
                    if (nav.length) {
                        $("[data-menu-space]").remove();
                        var offsetTop = nav.offset().top,
                            headerHeight = nav.height(),
                            injectSpace = $("<div />").attr("data-menu-space", "1").css("height", headerHeight).insertAfter(nav);
                        injectSpace.hide();
                        $(window).off("scroll.stickyMenu").on("scroll.stickyMenu", function () {
                            if ($(window).scrollTop() > offsetTop) {
                                nav.addClass("is-fixed");
                                injectSpace.show();
                            } else {
                                nav.removeClass("is-fixed");
                                injectSpace.hide();
                            }
                            if ($(window).scrollTop() > 150) {
                                nav.addClass("is-small animated fadeIn");
                            } else {
                                nav.removeClass("is-small animated fadeIn");
                            }
                        });
                    }
                }
            }
        }
        sticky_menu_header();

        /*-----------------------------------------
         03. Mobile Main Menu
         -----------------------------------------*/
        var selectors = {
            body: "body",
            sitenav: "#siteNav",
            navLinks: "#siteNav .lvl1 > a",
            menuToggle: ".js-mobile-nav-toggle",
            mobilenav: ".mobile-nav-wrapper",
            menuLinks: "#MobileNav .anm",
            closemenu: ".closemobileMenu",
        };

        $(selectors.navLinks).each(function () {
            if ($(this).attr("href") == window.location.pathname)
                $(this).addClass("active");
        });

        $(selectors.menuToggle).off("click.menuToggle").on("click.menuToggle", function () {
            body: "body", $(selectors.mobilenav).toggleClass("active");
            $(selectors.body).toggleClass("menuOn");
            $(selectors.menuToggle).toggleClass(
                "mobile-nav--open mobile-nav--close"
            );
        });

        $(selectors.closemenu).off("click.closemenu").on("click.closemenu", function () {
            body: "body", $(selectors.mobilenav).toggleClass("active");
            $(selectors.body).toggleClass("menuOn");
            $(selectors.menuToggle).toggleClass(
                "mobile-nav--open mobile-nav--close"
            );
        });

        $("body").off("click.mobileNavOutside").on("click.mobileNavOutside", function (event) {
            var $target = $(event.target);
            if (
                !$target.parents().is(selectors.mobilenav) &&
                !$target.parents().is(selectors.menuToggle) &&
                !$target.is(selectors.menuToggle)
            ) {
                $(selectors.mobilenav).removeClass("active");
                $(selectors.body).removeClass("menuOn");
                $(selectors.menuToggle)
                    .removeClass("mobile-nav--close")
                    .addClass("mobile-nav--open");
            }
        });

        $(selectors.menuLinks).off("click.menuLinks").on("click.menuLinks", function (e) {
            e.preventDefault();
            $(this).toggleClass("anm-angle-down-l anm-angle-up-l");
            $(this).parent().next().slideToggle();
        });

        /*--------------------------------------
         04. Vertical Categories Menu
         -------------------------------------- */
        $(".header-vertical-menu .menu-title").off("click.vMenuTitle").on("click.vMenuTitle", function (event) {
            $(".header-vertical-menu .vertical-menu-content").slideToggle(300);
            $(this).toggleClass("active");
        });

        // More Categories Open/Close
        $(".moreSlideOpen").slideUp();
        $(".moreCategories").off("click.moreCategories").on("click.moreCategories", function () {
            $(this).toggleClass("show");
            $(".moreSlideOpen").slideToggle();
        });

        // Header dropdowns (setting box, account, user menu, language picker,
        // currency picker) are bound exactly once at script load via event
        // delegation — see the IIFE near the top of this file. Re-binding them
        // here would stack a fresh handler on every wire:navigate, so a single
        // click would toggle "active" multiple times and the dropdown would
        // appear not to open.

        /*-------------------------------
         09. Timer Count Down
         ----------------------------------*/
        $("[data-countdown]").each(function () {
            var $this = $(this),
                finalDate = $(this).data("countdown");
            $this.countdown(finalDate, function (event) {
                $this.html(
                    event.strftime(
                        '<span class="days ht-count"><span class="count-inner"><span class="time-count">%-D</span> <span class="text">Days</span></span></span> <span class="hour ht-count"><span class="count-inner"><span class="time-count">%-H</span> <span class="text">Hr</span></span></span> <span class="ht-count minutes"><span class="count-inner"><span class="time-count">%M</span> <span class="text">Min</span></span></span> <span class="ht-count second"><span class="count-inner"><span class="time-count">%S</span> <span class="text">Sc</span></span></span>'
                    )
                );
            });
        });

        /*-----------------------------------
         10. Color Swacthes
         -------------------------------------*/
        function color_swacthes() {
            $.each($(".swacth-list"), function () {
                var n = $(".swatch");
                n.off("click.swatch").on("click.swatch", function () {
                    $(this).addClass("active");
                    $(this).siblings().removeClass("active");
                });
            });
        }
        color_swacthes();

        function img_swacthes() {
            var selector = ".variants-clr li";
            $(selector).off("click.imgSwatch").on("click.imgSwatch", function () {
                $(this).addClass("active");
                $(this).siblings().removeClass("active");
            });
        }
        img_swacthes();

        function size_swacthes() {
            var selector = ".variants-size li";
            $(selector).off("click.sizeSwatch").on("click.sizeSwatch", function () {
                $(this).addClass("active");
                $(this).siblings().removeClass("active");
            });
        }
        size_swacthes();

        /*-------------------------------
         11. Show hide Product Tags
         ----------------------------------*/
        $(".product-tags li").eq(4).nextAll().hide();
        $(".btnview").off("click.btnview").on("click.btnview", function () {
            $(".product-tags li").not(".filter-active").show();
            $(this).hide();
        });

        /* Show more and show less */
        // Init runs on every livewire:navigated. The click handler is bound
        // exactly once (see top of file) so it can't duplicate across
        // navigations.
        $(".morelist").each(function () {
            var $list = $(this);
            $list.children("li.more").remove();
            $list.find("li.more-item.toggleable").stop(true, true).removeClass("toggleable").show();
            var LiN = $list.find(".more-item").length;
            if (LiN > 3) {
                $list.find(".more-item")
                    .eq(2)
                    .nextAll()
                    .hide()
                    .addClass("toggleable");
                $list.append('<li class="more">Show More</li>');
            }
        });

        /*-------------------------------
         12. Show hide Product Filters
         ----------------------------------*/
        $(".btn-filter").off("click.btnFilter").on("click.btnFilter", function () {
            $(".filterbar").toggleClass("active");
        });
        $(".closeFilter").off("click.closeFilter").on("click.closeFilter", function () {
            $(".filterbar").removeClass("active");
        });
        // Hide Cart on document click
        $("body").off("click.filterOutside").on("click.filterOutside", function (event) {
            var $target = $(event.target);
            if (
                !$target.parents().is(".filterbar") &&
                !$target.is(".btn-filter")
            ) {
                $(".filterbar").removeClass("active");
            }
        });

        /*-----------------------------------------
         13. Slick Slider
         -----------------------------------------*/
        /* 13.1 Homepage Slideshow */
        function home_slider() {
            $(".home-slideshow").slick({
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: false,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 7000,
                lazyLoad: "ondemand",
            });
        }
        home_slider();
        var swiper = new Swiper(".home-mySwiper", {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            loop: true,
        });
        var swiper = new Swiper(".offers-slider", {
            slidesPerView: 3,
            spaceBetween: 10,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            breakpoints: {
                220: { slidesPerView: 1, spaceBetween: 10 },
                320: { slidesPerView: 1, spaceBetween: 10 },
                768: { slidesPerView: 2, spaceBetween: 15 },
                1024: { slidesPerView: 3, spaceBetween: 15 },
            },
        });
        var swiper = new Swiper(".offer-mySwiper", {
            slidesPerView: 4,
            spaceBetween: 30,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            loop: true,
            breakpoints: {
                200: {
                    slidesPerView: 1,
                },
                440: {
                    slidesPerView: 2,
                },
                // 540: {
                //     slidesPerView: 3,
                // },
                // 541: {
                //     slidesPerView: 4,
                // },
            },
        });

        // Initialize EVERY .category-mySwiper, not just the first. A page can
        // render this class multiple times (Popular Categories, each Category
        // Section, and the Popular Brands slider all reuse it). `new Swiper(
        // ".category-mySwiper", …)` with a string selector only ever binds the
        // first match, so every later one stayed un-initialized and its slides
        // wrapped into rows instead of becoming a single-row slider. Looping
        // over all matches fixes brands and any extra category sections. Each
        // instance scopes its own prev/next buttons to itself; the brands
        // slider has none, so querySelector returns null and Swiper just omits
        // navigation for it. Re-init guard: if a previous instance is still
        // attached (e.g. after wire:navigate), destroy it before re-creating.
        document.querySelectorAll(".category-mySwiper").forEach(function (el) {
            if (el.swiper) {
                try { el.swiper.destroy(true, true); } catch (e) {}
            }
            new Swiper(el, {
                slidesPerView: 12,
                spaceBetween: 30,
                navigation: {
                    nextEl: el.querySelector(".swiper-button-next"),
                    prevEl: el.querySelector(".swiper-button-prev"),
                },
                breakpoints: {
                    200: {
                        slidesPerView: 3,
                    },
                    440: {
                        slidesPerView: 4,
                    },
                    540: {
                        slidesPerView: 5,
                    },
                    768: {
                        slidesPerView: 6,
                    },
                    1200: {
                        slidesPerView: 12,
                    },
                },
            });
        });

        // Popular Brands slider — shared across home themes 2-6 (the default
        // "home" theme renders brands with .category-mySwiper above and is
        // handled by that loop). Each brands block can repeat per page, so we
        // initialize every match and scope its own nav buttons. Fixed-width
        // 90px brand cards slide in a single row instead of wrapping.
        document.querySelectorAll(".brands-mySwiper").forEach(function (el) {
            if (el.swiper) {
                try { el.swiper.destroy(true, true); } catch (e) {}
            }
            new Swiper(el, {
                slidesPerView: 12,
                spaceBetween: 18,
                navigation: {
                    nextEl: el.querySelector(".swiper-button-next"),
                    prevEl: el.querySelector(".swiper-button-prev"),
                },
                breakpoints: {
                    200: {
                        slidesPerView: 3,
                    },
                    440: {
                        slidesPerView: 4,
                    },
                    540: {
                        slidesPerView: 5,
                    },
                    768: {
                        slidesPerView: 7,
                    },
                    1200: {
                        slidesPerView: 12,
                    },
                },
            });
        });
        var swiper = new Swiper(".home-theme-2-category-mySwiper", {
            slidesPerView: 11,
            spaceBetween: 20,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                200: {
                    slidesPerView: 3,
                },
                440: {
                    slidesPerView: 4,
                },
                540: {
                    slidesPerView: 5,
                },
                768: {
                    slidesPerView: 6,
                },
                1200: {
                    slidesPerView: 11,
                },
            },
        });
        new Swiper(".home_theme_three_brands_swiper", {
            slidesPerView: 7,
            spaceBetween: 10,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: { slidesPerView: 3 },
                480: { slidesPerView: 4 },
                768: { slidesPerView: 5 },
                1024: { slidesPerView: 6 },
                1200: { slidesPerView: 7 },
            },
        });
        var swiper = new Swiper(".home-page-2-brands-slider", {
            slidesPerView: 6, // Number of visible slides at a time
            spaceBetween: 10, // Gap between slides
            loop: true, // Infinite looping
            autoplay: {
                delay: 3000, // Auto-slide every 3 seconds
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: { slidesPerView: 2, spaceBetween: 5 },
                480: { slidesPerView: 3, spaceBetween: 5 },
                768: { slidesPerView: 4, spaceBetween: 10 },
                1024: { slidesPerView: 8, spaceBetween: 10 },
            },
        });

        var swiper = new Swiper(".style1-mySwiper", {
            slidesPerView: 12,
            spaceBetween: 30,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                200: {
                    slidesPerView: 2,
                },
                440: {
                    slidesPerView: 2,
                },
                540: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1200: {
                    slidesPerView: 5,
                },
            },
        });
        var swiper = new Swiper(".sub_category-mySwiper", {
            slidesPerView: 5,
            spaceBetween: 20,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                200: {
                    slidesPerView: 1,
                },
                440: {
                    slidesPerView: 2,
                },
                540: {
                    slidesPerView: 3,
                },
                700: {
                    slidesPerView: 5,
                },
            },
        });
        var swiper = new Swiper(".style2-mySwiper", {
            slidesPerView: 4,
            spaceBetween: 30,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                200: {
                    slidesPerView: 2,
                },
                440: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                },
            },
        });
        /* 13.2 Promobar Slider 1 Items */
        function promo_slider_1items() {
            $(".promo-slider-1items").slick({
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 4000,
                fade: true,
                cssEase: "linear",
            });
        }
        promo_slider_1items();

        /* 13.3 Top Bar Slider */
        function top_infobar_slider() {
            $(".infobar-slider-4items").slick({
                dots: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 4000,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        top_infobar_slider();

        function topbar_slider_style1() {
            $(".topBar-slider-style1").slick({
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 4000,
                fade: true,
            });
        }
        topbar_slider_style1();

        /* 13.4 Sidebar Product */
        function menu_product_slider() {
            $(".weekly-product").slick({
                dots: false,
                slidesToShow: 2,
                slidesToScroll: 2,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 2500,
            });
        }
        menu_product_slider();

        /* 13.5 Sidebar Product */
        function side_product_slider() {
            $(".sideProSlider").slick({
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 4000,
            });
        }
        side_product_slider();

        /* 13.6 Category Image 3 Items */
        function category_image_items() {
            $(".category-image-3items").slick({
                dots: true,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 4000,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        category_image_items();

        /* 13.7 Collection Slider 3 Items */
        function collection_slider_3items() {
            $(".collection-slider-3items").slick({
                dots: true,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 4000,
                arrows: false,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        collection_slider_3items();

        function image_slider3items() {
            $(".image-text-slider3items").slick({
                dots: false,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        image_slider3items();

        function offer_slider() {
            $(".offer-slider").slick({
                dots: false,
                infinite: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                lazyLoad: "ondemand",
            });
        }
        offer_slider();

        /* 13.8 Collection Slider 4 Items */
        function collection_slider_4items() {
            $(".collection-slider-4items").slick({
                dots: false,
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 4000,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        collection_slider_4items();

        /* 13.9 Collection Slider 5 Items */
        function collection_slider_5items() {
            $(".collection-slider-5items").slick({
                dots: false,
                infinite: true,
                slidesToShow: 7,
                slidesToScroll: 1,
                arrows: true,
                autoplay: false,
                autoplaySpeed: 4000,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 6,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        collection_slider_5items();

        /* 13.10 Collection Slider 6 Items */
        function collection_slider_6items() {
            $(".collection-slider-6items").slick({
                dots: false,
                infinite: true,
                slidesToShow: 6,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 4000,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        collection_slider_6items();

        /* 13.11 Collection Slider 8 Items */
        function collection_slider_8items() {
            $(".collection-slider-8items").slick({
                dots: true,
                infinite: true,
                slidesToShow: 8,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 4000,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 7,
                        },
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 5,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 4,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                        },
                    },
                ],
            });
        }
        collection_slider_8items();

        /* 13.12 Products Slider 3 Items */
        function product_slider_3items() {
            $(".product-slider-3items").slick({
                dots: false,
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        product_slider_3items();

        /* 13.13 Products Slider 4 Items */
        function product_slider_4items() {
            $(".product-slider-4items").slick({
                dots: false,
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        product_slider_4items();

        /* 13.14 Products Slider 5 Items */
        function product_slider_5items() {
            $(".product-slider-5items").slick({
                dots: false,
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 1,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        product_slider_5items();

        /* 13.15 Logo Slider 6 Items */
        function logo_slider_6items() {
            $(".logo-slider-6items").slick({
                dots: false,
                infinite: true,
                slidesToShow: 6,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        logo_slider_6items();

        /* 13.16 Testimonial Slider 1 Items */
        function testimonial_slider_1items() {
            $(".testimonial-slider-1items").slick({
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                adaptiveHeight: true,
            });
        }
        testimonial_slider_1items();

        /* 13.17 Testimonial Slider 2 Items */
        function testimonial_slider_2items() {
            $(".testimonial-slider-2items").slick({
                dots: true,
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: true,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            arrows: false,
                        },
                    },
                ],
            });
        }
        testimonial_slider_2items();

        /* 13.18 Testimonial Slider 3 Items */
        function testimonial_slider_3items() {
            $(".testimonial-slider-3items").slick({
                // dots: true,
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 4,
                arrows: false,
                adaptiveHeight: true,
                autoplay: true,
                autoplaySpeed: 5000,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            arrows: false,
                        },
                    },
                ],
            });
        }
        testimonial_slider_3items();

        /* 13.19 Blog Slider 3 Items */
        function blog_slider_3items() {
            $(".blog-slider-3items").slick({
                dots: false,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        blog_slider_3items();

        /* 13.20 Instagram Slider */
        function instagram_slider_5items() {
            $(".instagram-slider-5items").slick({
                dots: false,
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 6000,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        instagram_slider_5items();

        /* 13.21 Service Slider 5 Items */
        function service_slider_5items() {
            $(".service-slider-5items").slick({
                dots: true,
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 4000,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
        service_slider_5items();

        /* 13.22 Grid Multiple Product */
        function multiple_product_slider() {
            $(".multiple-product").slick({
                dots: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
            });
        }
        multiple_product_slider();

        /*-----------------------------------
         Slider Refresh
         -------------------------------------*/
        function slider_refresh() {
            $(".nav-tabs .nav-item").off("click.navTabsRefresh").on("click.navTabsRefresh", function () {
                $(".tabs-listing .slick-slider").slick("refresh");
            });
        }
        slider_refresh();

        /*-----------------------------------
         14. Infinite Scroll js
         -------------------------------------*/
        function product_three_loadmore() {
            $(".product-three-loadmore .item").slice(0, 12).show();
            $(".loadMore3").off("click.loadMore3").on("click.loadMore3", function (e) {
                e.preventDefault();
                $(".product-three-loadmore .item:hidden")
                    .slice(0, 3)
                    .slideDown();
                if ($(".product-three-loadmore .item:hidden").length == 0) {
                    $(".infiniteload").html(
                        '<div class="btn btn-lg loadMore3">No more products</div>'
                    );
                }
            });
        }
        product_three_loadmore();

        function product_four_loadmore() {
            $(".product-four-loadmore .item").slice(0, 8).show();
            $(".loadMore4").off("click.loadMore4").on("click.loadMore4", function (e) {
                e.preventDefault();
                $(".product-four-loadmore .item:hidden")
                    .slice(0, 4)
                    .slideDown();
                if ($(".product-four-loadmore .item:hidden").length == 0) {
                    $(".infiniteload").html(
                        '<div class="btn btn-lg loadMore4">No more products</div>'
                    );
                }
            });
        }
        product_four_loadmore();

        function product_listview_loadmore() {
            $(".product-listview-loadmore .item").slice(0, 8).show();
            $(".loadMoreList").off("click.loadMoreList").on("click.loadMoreList", function (e) {
                e.preventDefault();
                $(".product-listview-loadmore .item:hidden")
                    .slice(0, 1)
                    .slideDown();
                if ($(".product-listview-loadmore .item:hidden").length == 0) {
                    $(".infiniteload").html(
                        '<div class="btn btn-lg loadMoreList">No more products</div>'
                    );
                }
            });
        }
        product_listview_loadmore();

        function blog_listview_loadmore() {
            $(".blog-listview-loadmore .blog-article").slice(0, 3).show();
            $(".loadMore1").off("click.loadMore1").on("click.loadMore1", function (e) {
                e.preventDefault();
                $(".blog-listview-loadmore .blog-article:hidden")
                    .slice(0, 1)
                    .slideDown();
                if (
                    $(".blog-listview-loadmore .blog-article:hidden").length ==
                    0
                ) {
                    $(".infiniteload").html(
                        '<div class="btn btn-lg loadMore1">No more Blog post</div>'
                    );
                }
            });
        }
        blog_listview_loadmore();

        /*----------------------------------
         15. Tooltip
         -----------------------------------*/
        function tooltip() {
            if ($(window).width() > 992) {
                var tooltipTriggerList = [].slice.call(
                    document.querySelectorAll('[data-bs-toggle="tooltip"]')
                );
                var tooltipList = tooltipTriggerList.map(function (
                    tooltipTriggerEl
                ) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        trigger: "hover",
                    });
                });
            }
        }
        tooltip();

        /*-----------------------------------
         16. Sidebar Categories Level links
         -------------------------------------*/
        function categories_level() {
            $(".sidebar-categories .sub-level a").off("click.catLevel").on("click.catLevel", function () {
                $(this).toggleClass("active");
                $(this).next(".sublinks").slideToggle("slow");
            });
        }
        categories_level();

        $(document).off("click.filterWidgetTitle", ".filter-widget .widget-title");
        $(document).on("click.filterWidgetTitle", ".filter-widget .widget-title", function () {
            $(this).next().slideToggle("300");
            $(this).toggleClass("active");
        });

        $(".dropdown-menu").off("click.filterDD").on("click.filterDD", function (e) {
            if ($(this).hasClass("filterDD")) {
                e.stopPropagation();
            }
        });

        /*-----------------------------------
         17. Price Range Slider
         -------------------------------------*/

        /*-----------------------------------
         18. Shop List-grid js
         -------------------------------------*/
        function grid_options() {
            $(".grid-options .mode-list").off("click.gridModeList").on("click.gridModeList", function () {
                $(".product-options")
                    .removeClass(
                        "row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2 list-style"
                    )
                    .addClass("list-style");
            });
            $(".grid-2").off("click.grid2").on("click.grid2", function () {
                $(".product-options")
                    .removeClass(
                        "row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2 list-style"
                    )
                    .addClass("row-cols-2");
            });
            $(".grid-3").off("click.grid3").on("click.grid3", function () {
                $(".product-options")
                    .removeClass(
                        "row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2 list-style"
                    )
                    .addClass("row-cols-md-3 row-cols-sm-3 row-cols-2");
            });
            $(".grid-4").off("click.grid4").on("click.grid4", function () {
                $(".product-options")
                    .removeClass(
                        "row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2 list-style"
                    )
                    .addClass(
                        "row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2"
                    );
            });
            $(".grid-5").off("click.grid5").on("click.grid5", function () {
                $(".product-options")
                    .removeClass(
                        "row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2 list-style"
                    )
                    .addClass(
                        "row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2"
                    );
            });

            var contentwidth = $(window).width();
            if (contentwidth < "1199") {
                $(".grid-options .grid-4").addClass("active");
            }
            if (contentwidth < "991") {
                $(".grid-options .grid-3").addClass("active");
            }
            if (contentwidth < "767") {
                $(".grid-options .grid-2").addClass("active");
            }

            $(".grid-options .icon-mode").off("click.iconMode").on("click.iconMode", function () {
                $(".grid-options .icon-mode.active").removeClass("active");
                $(this).addClass("active");
            });
        }
        grid_options();

        /* --------------------------------------
         20. Image to background js
         -------------------------------------- */
        $(".bg-top").parent().addClass("b-top");
        $(".bg-bottom").parent().addClass("b-bottom");
        $(".bg-center").parent().addClass("b-center");
        $(".bg-left").parent().addClass("b-left");
        $(".bg-right").parent().addClass("b-right");
        $(".bg_size_content").parent().addClass("b_size_content");
        $(".bg-img").parent().addClass("bg-size");
        $(".bg-img.blur-up").parent().addClass("");
        jQuery(".bg-img").each(function () {
            var el = $(this),
                src = el.attr("src"),
                parent = el.parent();
            parent.css({
                "background-image": "url(" + src + ")",
                "background-size": "cover",
                "background-position": "center",
                "background-repeat": "no-repeat",
            });
            el.hide();
        });

        /*-----------------------------------
         21. Links for mobiles
         -------------------------------------*/
        function footer_dropdown() {
            $(".footer-links .h4").off("click.footerDropdown").on("click.footerDropdown", function () {
                if ($(window).width() < 767) {
                    $(this).next().slideToggle();
                    $(this).toggleClass("active");
                }
            });
        }
        footer_dropdown();

        // Resize Function
        var resizeTimer;
        $(window).off("resize.delayedResize").on("resize.delayedResize", function (e) {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                $(window).trigger("delayed-resize", e);
            }, 250);
        });
        $(window).off("load.footerLR resize.footerLR").on("load.footerLR resize.footerLR", function (e) {
            if ($(window).width() > 767) {
                $(".footer-links ul").show();
            } else {
                $(".footer-links ul").hide();
            }
        });

        /* Blog Pages Sidebar Widget +/- */
        function blog_sidebar_dropdown() {
            $(".blog-sidebar .widget-title").off("click.blogSidebar").on("click.blogSidebar", function () {
                if ($(window).width() < 991) {
                    $(this).next().slideToggle("300");
                    $(this).toggleClass("active");
                }
            });
        }
        blog_sidebar_dropdown();

        $(window).off("load.blogLR resize.blogLR").on("load.blogLR resize.blogLR", function (e) {
            if ($(window).width() > 991) {
                $(".blog-sidebar .widget-content").show();
            } else {
                $(".blog-sidebar .widget-content").hide();
            }
        });

        /*-----------------------------------------
         22. Masonry Grid
         -----------------------------------------*/
        var $grid = $(".grid-masonary").masonry({
            itemSelector: ".masonary-item",
            percentPosition: true,
            columnWidth: ".grid-sizer",
        });

        // layout Masonry after each image loads
        $grid.imagesLoaded().progress(function () {
            $grid.masonry();
        });

        $(".btn-shop").off("click.btnShop").on("click.btnShop", function () {
            $(".btn-shop").removeClass("active");
            $(this).addClass("active");
            $(".products .grid-lb").removeClass("active"),
                $(this).next().addClass("active");
        });
        $(".btn-shop-close").off("click.btnShopClose").on("click.btnShopClose", function () {
            $(this).parent().removeClass("active");
            $(".btn-shop").removeClass("active");
        });

        /*-------------------------------
         23. Scroll Top
         ---------------------------------*/
        function scroll_top() {
            $("#site-scroll").off("click.siteScroll").on("click.siteScroll", function () {
                $("html, body").animate({ scrollTop: 0 }, 100);
                return false;
            });
        }
        scroll_top();
        $(window).off("scroll.siteScrollFade").on("scroll.siteScrollFade", function () {
            if ($(this).scrollTop() > 300) {
                $("#site-scroll").fadeIn();
                $("#site-scroll").removeClass("d-none");
            } else {
                $("#site-scroll").fadeOut();
                $("#site-scroll").addClass("d-none");
            }
        });

        /*-----------------------------------
         24. Tabs With Accordian Responsive
         -------------------------------------*/
        $(".tab_content").hide();
        $(".tab_content:first").show();
        /* if in tab mode */
        $("ul.tabs li").off("click.tabsLi").on("click.tabsLi", function () {
            $(".tab_content").hide();
            var activeTab = $(this).attr("rel");
            $("#" + activeTab).fadeIn();

            $("ul.tabs li").removeClass("active");
            $(this).addClass("active");

            $(".tab_drawer_heading").removeClass("d_active");
            $(".tab_drawer_heading[rel^='" + activeTab + "']").addClass(
                "d_active"
            );

            $(".productSlider").slick("refresh");
            $(".productSlider-style2").slick("refresh");
        });
        /* if in drawer mode */
        $(".tab_drawer_heading").off("click.tabDrawer").on("click.tabDrawer", function () {
            $(".tab_content").hide();
            var d_activeTab = $(this).attr("rel");
            $("#" + d_activeTab).fadeIn();

            $(".tab_drawer_heading").removeClass("d_active");
            $(this).addClass("d_active");

            $("ul.tabs li").removeClass("d_active");
            $("ul.tabs li[rel^='" + d_activeTab + "']").addClass("d_active");

            $(".productSlider").slick("refresh");
            $(".productSlider-style2").slick("refresh");
        });
        $("ul.tabs li").last().addClass("tab_last");

        /*----------------------------------
         25. Product Details Page
         ------------------------------------*/
        /* Horizontal Thumb Slider */
        function product_thumb1() {
            $(".product-thumb-horizontal").slick({
                infinite: true,
                slidesToShow: 5,
                stageMargin: 5,
                slidesToScroll: 1,
            });
        }
        product_thumb1();

        /* Vertical Thumb Slider */
        function product_thumb() {
            $(".product-thumb-vertical").slick({
                infinite: true,
                slidesToShow: 5,
                vertical: true,
                verticalSwiping: true,
                centerPadding: "0",
                draggable: true,
                slidesToScroll: 1,
            });
        }
        product_thumb();

        /*----------------------------------
         26. Visitor Fake Message
         ------------------------------------*/
        var userLimit = $(".userViewMsg").attr("data-user"),
            userTime = $(".userViewMsg").attr("data-time");
        $(".uersView").text(Math.floor(Math.random() * userLimit));
        // Clear any interval left over from a previous wire:navigate before
        // starting a new one — otherwise each navigation stacks another timer
        // that keeps running forever, steadily degrading performance.
        if (window.__userViewInterval) clearInterval(window.__userViewInterval);
        window.__userViewInterval = setInterval(function () {
            $(".uersView").text(Math.floor(Math.random() * userLimit));
        }, userTime);

        /*----------------------------------
         27. Product Tabs
         ------------------------------------*/
        $(".tab-content").hide();
        $(".tab-content:first").show();
        /* if in tab mode */
        $(".product-tabs li").off("click.productTabs").on("click.productTabs", function () {
            $(".tab-content").hide();
            var activeTab = $(this).attr("rel");
            $("#" + activeTab).fadeIn();

            $(".product-tabs li").removeClass("active");
            $(this).addClass("active");

            $(this).fadeIn();
            if ($(window).width() < 767) {
                var tabposition = $(this).offset();
                $("html, body").animate(
                    { scrollTop: tabposition.top - 70 },
                    700
                );
            }
        });

        $(".product-tabs li:first-child").addClass("active");
        $(".tab-container h3:first-child + .tab-content").show();

        /* if in drawer mode */
        $(".acor-ttl").off("click.acorTtl").on("click.acorTtl", function () {
            $(".tab-content").hide();
            var activeTab = $(this).attr("rel");
            $("#" + activeTab).fadeIn();

            $(".acor-ttl").removeClass("active");
            $(this).addClass("active");
            if ($(window).width() < 767) {
                var tabposition = $(this).offset();
                $("html, body").animate({ scrollTop: tabposition.top }, 700);
            }
        });

        /* Below 767 Accordian style */
        $(".tabs-ac-style").off("click.tabsAcStyle").on("click.tabsAcStyle", function () {
            $(".tab-content").hide();
            var activeTab = $(this).attr("rel");
            $("#" + activeTab).fadeIn();

            $(".tabs-ac-style").removeClass("active");
            $(this).addClass("active");

            $(this).fadeIn();
            if ($(window).width() < 767) {
                var tabposition = $(this).offset();
                $("html, body").animate({ scrollTop: tabposition.top }, 700);
            }
        });

        /*----------------------------
         28. Sticky Header and Product Sticky Bottom Cart
         ------------------------------ */
        function sticky_cart() {
            window.onscroll = function () {
                $(window).scrollTop() > 600 && $(".stickyCart").length
                    ? ($("body.template-product").css("padding-bottom", "70px"),
                      $(".stickyCart").slideDown())
                    : ($("body.template-product").css("padding-bottom", "0"),
                      $(".stickyCart").slideUp());
            };
            $(".stickyOptions .selectedOpt").off("click.stickySelectedOpt").on("click.stickySelectedOpt", function () {
                $(".stickyOptions ul").slideToggle("fast");
            }),
                $(".stickyOptions .vrOpt").off("click.stickyVrOpt").on("click.stickyVrOpt", function (e) {
                    var t = $(this).attr("data-val"),
                        s = $(this).attr("data-no"),
                        a = $(this).text();
                    $(".selectedOpt").text(a),
                        $(".stickyCart .selectbox").val(t).trigger("change"),
                        $(".stickyOptions ul").slideUp("fast"),
                        (this.productvariants = JSON.parse(
                            document.getElementById("ProductJson-" + i)
                                .innerHTML
                        )),
                        $(".stickyCart .product-featured-img").attr(
                            "src",
                            this.productvariants.variants[
                                s
                            ].featured_image.src.replace(
                                /(\.[^\.]*$|$)/,
                                "_60x60$&"
                            )
                        );
                });
        }
        sticky_cart();

        /*----------------------------
         29. Checkout Style2 Tabs
         ------------------------------ */
        function checkout_tabs() {
            $.each($(".step-items"), function () {
                var n = $(".nav-item");
                n.off("click.checkoutNavItem").on("click.checkoutNavItem", function () {
                    $(this).addClass("active");
                    $(this).siblings().removeClass("active");
                });
            });
        }
        checkout_tabs();
    })(jQuery);
});
$(function () {
    $("#gallery").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        infinite: true,
    });
});
// $('.home-theme-six-slick-slider').slick({
//     slidesToShow: 4,
//     slidesToScroll: 1,
//     infinite: true,
//     // dots: true,
//     autoplay: true,
//     autoplaySpeed: 10000,
//     prevArrow: '<button type="button" class="slick-prev">❮</button>',
//     nextArrow: '<button type="button" class="slick-next">❯</button>',
//     lazyLoad: 'ondemand',
//     responsive: [
//         {
//             breakpoint: 1024,
//             settings: {
//                 slidesToShow: 3
//             }
//         },
//         {
//             breakpoint: 768,
//             settings: {
//                 slidesToShow: 2
//             }
//         },
//         {
//             breakpoint: 480,
//             settings: {
//                 slidesToShow: 1
//             }
//         }
//     ]
// });
function initializeHomeThemeSixSlickSlider() {
    let slider = $(".home-theme-six-slick-slider");
    if (slider.length && !slider.hasClass("slick-initialized")) {
        slider.slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 10000,
            prevArrow: '<button type="button" class="slick-prev">❮</button>',
            nextArrow: '<button type="button" class="slick-next">❯</button>',
            lazyLoad: "ondemand",
            responsive: [
                { breakpoint: 1024, settings: { slidesToShow: 3 } },
                { breakpoint: 768, settings: { slidesToShow: 2 } },
                { breakpoint: 480, settings: { slidesToShow: 1 } },
            ],
        });
    }
}
document.addEventListener("DOMContentLoaded", function () {
    initializeHomeThemeSixSlickSlider();
});
document.addEventListener("livewire:navigated", function () {
    initializeHomeThemeSixSlickSlider();
});
var swiper = new Swiper(".home_theme_six_category_swiper", {
    slidesPerView: 4,
    slidesPerGroup: 1,
    loop: true,
    autoplay: {
        delay: 10000,
        disableOnInteraction: false,
    },
    lazy: {
        loadOnTransitionStart: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        1024: {
            slidesPerView: 3,
        },
        768: {
            slidesPerView: 2,
        },
        480: {
            slidesPerView: 1,
        },
    },
});
