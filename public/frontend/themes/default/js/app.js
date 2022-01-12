"use strict";

// Class definition
var ADW = function() {

    var _init = function() {
        $(window).on('load', function() {
            $('body').addClass('load');

            /**
             * Centre les images
             **/
            ADW_CenterImageInContainer();

            /**
             * Charge les lazyload
             **/
            ADW_ImgLoaded();
            checkStickyMenu();
            ADW_LazyLoad();
            ADW_BackgroundLazyLoad();

            /**
             * VÃ©rifie les Ã©lÃ©ments visibles
             **/
            ADW_CheckIfIsVisible();

        });


    }

    // Supprimer les accents d'une chaÃ®ne de caractÃ¨res
    var _no_accent = function(my_string) {
        var new_string = "";
        var pattern_accent = new Array(
            'Ã€', 'Ã', 'Ã‚', 'Ãƒ', 'Ã„', 'Ã…', 'Ã ', 'Ã¡', 'Ã¢', 'Ã£', 'Ã¤', 'Ã¥',
            'Ãˆ', 'Ã‰', 'ÃŠ', 'Ã‹', 'Ã¨', 'Ã©', 'Ãª', 'Ã«',
            'ÃŒ', 'Ã', 'ÃŽ', 'Ã', 'Ã¬', 'Ã­', 'Ã®', 'Ã¯',
            'Ã’', 'Ã“', 'Ã”', 'Ã•', 'Ã–', 'Ã˜', 'Ã²', 'Ã³', 'Ã´', 'Ãµ', 'Ã¶', 'Ã¸',
            'Ã™', 'Ãš', 'Ã›', 'Ãœ', 'Ã¹', 'Ãº', 'Ã»', 'Ã¼',
            'Ã¿', 'Ã‘', 'Ã±', 'Ã‡', 'Ã§', ' ', '\'', '"', '/'
        );
        var pattern_replace_accent = new Array(
            'A', 'A', 'A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a', 'a',
            'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e',
            'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i',
            'O', 'O', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'o', 'o',
            'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u',
            'y', 'N', 'n', 'C', 'c', '_', '', '', '-'
        );
        if (my_string && my_string != "") {
            new_string = _preg_replace(pattern_accent, pattern_replace_accent, my_string);
        }
        return new_string;
    }

    // Remplacer les majuscules par des minuscules
    var _no_maj = function(my_string) {
        var new_string = "";
        var pattern_accent = new Array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
            'U', 'V', 'W', 'X', 'Y', 'Z'
        );
        var pattern_replace_accent = new Array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'o', 'p', 'q', 'r', 's', 't',
            'u', 'v', 'w', 'x', 'y', 'z'
        );
        if (my_string && my_string != "") {
            new_string = _preg_replace(pattern_accent, pattern_replace_accent, my_string);
        }
        return new_string;
    }

    // Remplacer les Ã©lÃ©mants de array_pattern par arra_pattern_replace dans my_string
    var _preg_replace = function(array_pattern, array_pattern_replace, my_string) {
        var new_string = String(my_string);
        for (i = 0; i < array_pattern.length; i++) {
            var reg_exp = RegExp(array_pattern[i], "gi");
            var val_to_replace = array_pattern_replace[i];
            new_string = new_string.replace(reg_exp, val_to_replace);
        }
        return new_string;
    }

    var uniqid = function(prefix, more_entropy) {
        // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +    revised by: Kankrelune (http://www.webfaktory.info/)
        // %        note 1: Uses an internal counter (in php_js global) to avoid collision
        // *     example 1: uniqid();
        // *     returns 1: 'a30285b160c14'
        // *     example 2: uniqid('foo');
        // *     returns 2: 'fooa30285b1cd361'
        // *     example 3: uniqid('bar', true);
        // *     returns 3: 'bara20285b23dfd1.31879087'
        if (typeof prefix == 'undefined') {
            prefix = "";
        }

        var retId;
        var formatSeed = function(seed, reqWidth) {
            seed = parseInt(seed, 10).toString(16); // to hex str
            if (reqWidth < seed.length) { // so long we split
                return seed.slice(seed.length - reqWidth);
            }
            if (reqWidth > seed.length) { // so short we pad
                return Array(1 + (reqWidth - seed.length)).join('0') + seed;
            }
            return seed;
        };

        // BEGIN REDUNDANT
        if (!this.php_js) {
            this.php_js = {};
        }
        // END REDUNDANT
        if (!this.php_js.uniqidSeed) { // init seed with big random int
            this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
        }
        this.php_js.uniqidSeed++;

        retId = prefix; // start with prefix, add current milliseconds hex string
        retId += formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
        retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string
        if (more_entropy) {
            // for more entropy we add a float lower to 10
            retId += (Math.random() * 10).toFixed(8).toString();
        }

        return retId;
    }


    /**
     * S'applique sur toutes les images ayant la classe adw_image_cover
     **/
    var ADW_CenterImageInContainer = function() {
        $('.adw_image_cover').each(function() {
            let container = $(this);
            let img = container.children('img');

            // Si pas visible on ne s'en occupe pas pour le moment
            if (!ADW_IsVisible(img)) return;

            let widthContainer = parseInt(container.innerWidth());
            let heightContainer = parseInt(container.innerHeight());

            // Si la hauteur ou la largeur vaut 0
            if (widthContainer === 0 || heightContainer === 0)
                return;

            let widthImage = parseInt(img.innerWidth());
            let heightImage = parseInt(img.innerHeight());

            // Si la hauteur ou la largeur vaut 0
            if (widthImage === 0 || heightImage === 0)
                return;

            // Calcul des ratios
            let ratioContainer = widthContainer / heightContainer;
            let ratioImage = widthImage / heightImage;

            // Container plus large que haut (ou carrÃ©)
            if (ratioContainer >= 1) {
                // Image moins large et plus haute que le container (on regle sur largeur)
                if (ratioImage <= ratioContainer)
                    img.css('width', widthContainer).css('height', 'auto');

                // Image plus large et moins haute que le container (on regle sur hauteur)
                else if (ratioImage > ratioContainer)
                    img.css('height', heightContainer).css('width', 'auto');


            }
            // Container plus haut que large
            else {
                // Image moins large et plus haute que le container (on regle sur largeur)
                if (ratioImage <= ratioContainer)
                    img.css('width', widthContainer).css('height', 'auto');

                // Image plus large et moins haute que le container (on regle sur hauteur)
                else if (ratioImage > ratioContainer)
                    img.css('height', heightContainer).css('width', 'auto');

            }
        });
    }


    /**
     * GÃ©nÃ¨re les sliders du VC_Map ADW_slider
     **/
    var ADW_GenerateSlickSlider = function() {
        $('.ADW_slider').each(function() {
            let transition_type = $(this).data('transition-type') === "fade";
            let duration = $(this).data('duration');
            let transition_duration = $(this).data('transition-duration');
            let autoplay = $(this).data('autoplay') === "oui";
            let slides_to_show = $(this).data('slides-to-show');
            let slides_to_scroll = $(this).data('slides-to-scroll');
            let infinite = $(this).data('infinite') === "oui";
            let dots = $(this).data('dots') === "oui";
            let arrows = $(this).data('arrows') === "oui";

            $(this).slick({
                slide: 'li',
                fade: transition_type,
                autoplaySpeed: duration,
                speed: transition_duration,
                autoplay: autoplay,
                slidesToShow: slides_to_show,
                slidesToScroll: slides_to_scroll,
                infinite: infinite,
                dots: dots,
                arrows: arrows
            });

            if ($('.ADW_slider.full_height').length) {
                $(this).find('img').addClass('adw_image_cover_auto_fix'); // Slick slides must not be assigned a
                // width. Idem height.
            }
        });
    }


    var ADW_ResizeFullHeightSlider = function() {
        if (!$('.ADW_slider.full_height').length) return;

        var height = parseInt($(window).innerHeight());
        var wpadminbar = 0

        if ($('#wpadminbar').length)
            wpadminbar = parseInt($('#wpadminbar').innerHeight());

        height -= wpadminbar;

        $('.ADW_slider.full_height').css('height', height);
    }


    /**
     * Charge les images ayant la classe adw_lazyload et un attribut data-src si elles sont visibles
     **/
    var ADW_LazyLoad = function() {
        // On dÃ©finit un chargement de 8 images maximum par appel
        var maxPerCall = 8;
        var countCall = 0;

        // on parcourt toutes les images ayant la classe "lazyload" et pas chargÃ©e (loaded)
        $('img.adw_lazyload').not('.loaded').each(function() {

            // Si on Ã  dÃ©passÃ© le nombre d'appel max
            if (countCall >= maxPerCall)
                return false;

            // S'il n'y a pas d'attribut data-src ou s'il est vide, on le passe
            if ($(this).data('src') == undefined || $(this).data('src') == "") return;

            // Si l'Ã©lÃ©ment est visible
            if (ADW_IsVisible($(this))) {
                countCall++;

                // On ajoute l'attribut onload s'il n'existe pas
                if (typeof($(this).attr('onload')) == "undefined") {
                    if (!$(this).hasClass('smooth_arrival')) {
                        ADW_CenterImageInContainer();
                        $(this).addClass('smooth_arrival');
                        $(this).fadeIn();
                    }
                }

                $(this).addClass('loaded').attr('src', $(this).data('src')).removeAttr('data-src');
            }
        });
    }


    /**
     * Charge les background images des containers ayant la classe adw_bg_lazyload et un attribut data-background si elles
     * sont visibles
     **/
    var ADW_BackgroundLazyLoad = function() {
        // On dÃ©finit un chargement de 8 images maximum par appel
        var maxPerCall = 8;
        var countCall = 0;

        // on parcourt toutes les images ayant la classe "lazyload" et pas chargÃ©e (loaded)
        $('.adw_bg_lazyload').not('.loaded').each(function() {

            // Si on Ã  dÃ©passÃ© le nombre d'appel max
            if (countCall >= maxPerCall)
                return false;

            // S'il n'y a pas d'attribut data-background ou s'il est vide, on le passe
            if ($(this).data('background') == undefined || $(this).data('background') == "") return;

            // Si l'Ã©lÃ©ment est visible
            if (ADW_IsVisible($(this))) {
                countCall++;

                var backgrounds = $(this).data('background');
                var backgroundStr = "";
                backgrounds = backgrounds.split(",");

                $.each(backgrounds, function(index, value) {
                    backgroundStr += (backgroundStr == "") ? "" : ","; // Ajout d'une virgule s'il y en a plusieurs
                    backgroundStr += "url(" + value + ")";
                });

                $(this).addClass('loaded').css('background-image', backgroundStr).removeAttr('data-background');
            }
        });
    }


    /**
     * Charge les images ayant la classe adw_lazyload_slick et un attribut data-src
     * avant que le slider ne l'affiche.
     * Dans l'absolu on ne peut pas stopper l'Ã©vÃ©nement de changement de slide
     * De ce fait le chargement de l'image commence avant que le slider passe
     * Ã  la slide suivante, mais peut se termienr aprÃ¨s. C'est pourquoi un loeader
     * est en place.
     **/
    var ADW_LazyLoadSlick = function() {
        var firstImg = $('.ADW_slider')
            .find('.slick-active')
            .find('img.adw_lazyload_slick')
            .not('.loaded');

        if (firstImg.length) {
            if (typeof(firstImg.attr('onload')) == "undefined") {
                if (!$(this).hasClass('smooth_arrival')) {
                    ADW_CenterImageInContainer();
                    $(this).addClass('smooth_arrival');
                    $(this).fadeIn();
                }
            }
            // firstImg.attr('onload', "ADW_ImgLoaded($(this));");

            firstImg.addClass('loaded').attr('src', firstImg.data('src')).removeAttr('data-src');
        }

        $('.ADW_slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
            // Current Slick Slider
            var currentSlickSlider = $(slick.$list.context);

            // Next Slider Element
            var nextSlideElement = currentSlickSlider
                .children('.slick-list')
                .children('.slick-track')
                .children('li')
                .eq(nextSlide);

            // S'il y a des images Ã  charger
            if (nextSlideElement.find('img.adw_lazyload_slick').not('.loaded').length) {
                // On les parcourt
                nextSlideElement.find('img.adw_lazyload_slick').not('.loaded').each(function() {

                    // On ajoute l'attribut onload s'il n'existe pas
                    if (typeof($(this).attr('onload')) == "undefined") {
                        if (!$(this).hasClass('smooth_arrival')) {
                            ADW_CenterImageInContainer();
                            $(this).addClass('smooth_arrival');
                            $(this).fadeIn();
                        }
                    }
                    //$(this).attr('onload', "ADW_ImgLoaded($(this));");

                    $(this)
                        .addClass('loaded')
                        .attr('src', $(this).data('src'))
                        .removeAttr('data-src');
                });
            }
        });
    }


    /**
     * Permet une arrivÃ©e smooth des images (utilisÃ© notamment par le lazyload)
     **/
    var ADW_ImgLoaded = function(img) {
        if (img != undefined) {

            if (!img.hasClass('smooth_arrival')) {
                ADW_CenterImageInContainer();
                img.addClass('smooth_arrival');
                img.fadeIn();
            }
        }
    }


    /**
     * Ajoute automatiquement la classe "adw_is_visible" Ã   tous les Ã©lÃ©ments ayant la classe "adw_check_if_is_visible"
     * Lorsque ces derniers sont visibles (affichÃ© Ã  l'Ã©cran de l'utilisateur)
     **/
    var ADW_CheckIfIsVisible = function() {
        // On parcourt toutes les images ayant la classe "lazyload" et pas chargÃ©e (loaded)
        $('.adw_check_if_is_visible').not('.adw_is_visible').each(function() {
            if (ADW_IsVisible($(this))) {
                $(this).addClass('adw_is_visible');
            }
        });
    }


    /**
     * VÃ©rifie si l'Ã©lÃ©ment passÃ© en paramÃ¨tre est visible (sur l'Ã©cran de l'internaute). Par dÃ©faut vÃ©rifie la visibilitÃ©
     * du parent de l'Ã©lÃ©ment. Ajouter la classe force_element pour vÃ©rifier l'Ã©lÃ©ment en lui mÃªme
     * @param element DOM
     * @return bool
     **/
    var ADW_IsVisible = function(element) {
        let windowTop = parseInt($(window).scrollTop());
        let windowBottom = parseInt(windowTop + window.innerHeight);
        let E;

        if (element.hasClass('force_element'))
            E = element;
        else
            E = element.parent();

        // Si l'Ã©lÃ©ment n'est pas visible, on le passe (en cas de filtre par exemple)
        if (!E.is((':visible')))
            return false;

        let _thisOffsetTop = parseInt(E.offset().top);
        let _thisOffsetBottom = _thisOffsetTop + parseInt(E.innerHeight());

        // Si on descend : On vÃ©rifie que le haut est comprit entre le haut et le bas de la fenetre
        if (_thisOffsetTop >= windowTop && _thisOffsetTop < windowBottom) {
            return true;
        }
        // Si on monte : On vÃ©rifie que le bas est comprit entre le haut et le bas de la fenetre
        else if (_thisOffsetBottom > windowTop && _thisOffsetBottom <= windowBottom) {
            return true;
        } else {
            return false;
        }
    }

    var _siemHome = function() {

        /*** SLIDER HOME */
        Siema.prototype.addPagination = function() {
            var e = this;
            e.selector.parentNode.querySelectorAll(".dots").length < 1 && setTimeout((function() {
                var t = document.createElement("div");
                t.className = "dots";
                for (var o = function(o) {
                        var n = document.createElement("button");
                        n.className = "dot", n.textContent = o, n.addEventListener("click", (function() { return e.goTo(o) })), t.appendChild(n)
                    }, n = e.innerElements.length - e.perPage + 1, r = 0; r < n; r++) o(r);
                e.selector.parentNode.appendChild(t), e.selector.parentNode.querySelectorAll(".dot")[0].className = "dot active"
            }), 100)
        };


        var h = function() {
            var e = this.selector.parentNode,
                t = e.querySelectorAll(".dot");
            if (t.length > 0) {
                t.forEach((function(e) { e.className = "dot" }));
                var o = this.currentSlide;
                o < 0 && (o = this.innerElements.length + o);
                var n = e.querySelectorAll(".dot")[o];
                n && (n.className = "dot active")
            }
        };


        // New siema instance
        const mySiema = new Siema({
            selector: ".home-slider-wrapper",
            duration: 400,
            easing: 'ease-out',
            perPage: 1,
            startIndex: 0,
            draggable: !0,
            multipleDrag: !0,
            threshold: 20,
            loop: !0,
            rtl: !1,
            onInit: function() {
                this.addPagination()
                    // document.querySelectorAll(".home-slider-item").forEach((function(e, t) {
                    //     e.style.display = "block"
                    // }))
            },
            onChange: h,
        });
    }


    var checkStickyMenu = function() {

        var windowTop = $(window).scrollTop();
        var headerHeight = $(".header").height();

        if (windowTop >= headerHeight) {
            $("#header").addClass("sticky");
        } else {
            $("#header").removeClass("sticky");
        }

    }

    var hash = function() {

        // Smooth scroll à l'ancre au click
        $('a[href*=\\#]').on('click', function(event) {

            // hormis si c'est le bouton close du menu  
            if (!$(this).hasClass("close")) {


                if ($(this.hash).offset() == null) { // Si l'on provient d'une autre page
                    location.href = $(this).attr("href");
                } else { // Si l'on est déjà sur la page
                    $('html,body').animate({ scrollTop: $(this.hash).offset().top - 125 }, 700);
                }

                event.preventDefault();
            }
        });

        // Au chargement de la page on se rend à la section
        var hash = window.location.hash

        if (hash == '' || hash == '#' || hash == undefined) return false;


        var target = $(hash);

        headerHeight = 120;

        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

        if (target.length) {
            $('html,body').stop().animate({
                scrollTop: target.offset().top - 125 //offsets for fixed header
            }, 'linear');

        }

    }

    var table = function() {
        /**
         *  Tableaux
         **/
        $("table th").each(function() { $(this).parent().addClass("trh") });
        $("table td").each(function() {
            var table = $(this).parents("table").first();
            var index = $(this).index();
            var th = $("th:eq(" + index + ")", table).html();
            $(this).prepend("<span class='th'>" + th + "</span>");
        });
    }


    var owlCarousel = function() {

        if ($('.owl-carousel.carousel').length > 0) {
            $(".owl-carousel.carousel").each(function() {
                var owl = $(this);

                let items = owl.attr('data-items');
                let nav = owl.data('nav');
                let dots = owl.data('dots');
                let autoplay = owl.data('autoplay');
                let smartSpeed = owl.data('smartSpeed');
                let responsiveClass = owl.data('responsiveClass');
                let responsiveItem = owl.data('responsiveItem');
                //data-responsiveItem="{0: {items: 1,nav: true},500: {items: 1,margin: 20,nav: false},600: {items: 2, margin: 20,nav: false},1000: { items: 3, margin: 20, nav: true,loop: false  },1400: { items: 4,margin: 20, nav: true,loop: false }, 1700: { items: 4, margin: 90,nav: true,loop: false}}"
                owl.owlCarousel({
                    loop: true,
                    //margin: 30,
                    items: items,
                    nav: nav,
                    autoplay: autoplay,
                    smartSpeed: smartSpeed,
                    dots: dots,
                    responsiveClass: responsiveClass,
                    navText: ['<i class="las la-angle-left"></i>', '<i class="las la-angle-right"></i>'],
                    responsive: responsiveItem
                });
            });

        }
    }

    return {
        init: function() {
            _init();
            if ($('body').attr('id') == 'home') {
                _siemHome();
            }
            owlCarousel()
                /**
                 * Centre les images
                 **/
            ADW_CenterImageInContainer();
            window.addEventListener('resize', function() {
                setTimeout(function() {
                    ADW_CenterImageInContainer();
                    ADW_ResizeFullHeightSlider();
                }, 100);
            });
            ADW_ImgLoaded();

            /**
             * GÃ¨re la hauteur du slider full height
             **/
            ADW_ResizeFullHeightSlider();

            /**
             * Scroll event
             **/
            window.onscroll = function(e) {
                checkStickyMenu();
                ADW_LazyLoad();
                ADW_BackgroundLazyLoad();
                ADW_CheckIfIsVisible();
            }
            hash();
            table();
        }
    }

}();


// On document ready
KTUtil.onDOMContentLoaded(function() {
    ADW.init();
});