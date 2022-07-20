// -----------------------------

//   js index
/* =================== */
/*  
 
 
 
 
 */
// -----------------------------


(function ($) {
    "use strict";


    /*---------------------
     mobile menu
     --------------------- */
    jQuery('.stellarnav').stellarNav({
        theme: 'light',
        breakpoint: 960,
        position: 'right',
        phoneBtn: '',
        locationBtn: ''
    });

    /*-----------------
     sticky
     -----------------*/
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 160) {
            $('.header-bottom').addClass('navbar-fixed-top');
        } else {
            $('.header-bottom').removeClass('navbar-fixed-top');
        }
    });

    /*-----------------
     scroll-up
     -----------------*/
    $.scrollUp({
        scrollText: '<i class="fa fa-arrow-up" aria-hidden="true"></i>',
        easingType: 'linear',
        scrollSpeed: 500,
        animation: 'fade'
    });

    /*------------------------------
     counter
     ------------------------------ */
    $('.counter-up').counterUp();

    /*---------------------
     smooth scroll
     --------------------- */
    $('.smoothscroll').on('click', function (e) {
        e.preventDefault();
        var target = this.hash;

        $('html, body').stop().animate({
            'scrollTop': $(target).offset().top - 80
        }, 1200);
    });


    /*---------------------
     countdown
     --------------------- */
    $('[data-countdown]').each(function () {
        var $this = $(this),
                finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function (event) {
            $this.html(event.strftime('<span class="cdown days"><span class="time-count">%-D</span> <p>Days</p></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Hour</p></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>Min</p></span> <span class="cdown second"> <span><span class="time-count">%S</span> <p>Sec</p></span>'));
        });
    });

    /*---------------------
     fancybox
     --------------------- */
    $('[data-fancybox]').fancybox({
        image: {
            protect: true
        }
    });

    /*---------------------
     masonary
     --------------------- */
    $('#container').imagesLoaded(function () { //image loaded

        // filter items on button click
        $('.gallery-menu').on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({filter: filterValue});
            $('.gallery-menu').find('.checked').removeClass('checked');
            $(this).addClass('checked');
        });

        // masonary activation
        var $grid = $('.grid_container').isotope({
            itemSelector: '.grid',
            percentPosition: true,
            masonry: {
                // use outer width of grid-sizer for columnWidth
                columnWidth: '.grid'
            }
        })
    });

    /*---------------------
     hero carousel
     --------------------- */
    function hero_carousel() {
        var owl = $(".hero-carousel");
        owl.owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            navigation: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            nav: true,
            items: 1,
            smartSpeed: 2000,
            dots: false,
            autoplay: false,
            autoplayTimeout: 4000,
            center: true,
            rtl: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                760: {
                    items: 1
                }
            }
        });
    }
    hero_carousel();

    /*---------------------
     testimonial-carousel carousel
     --------------------- */
    function testimonial_carousel() {
        var owl = $(".testimonial-carousel");
        owl.owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            navigation: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            nav: true,
            items: 1,
            smartSpeed: 2000,
            dots: true,
            autoplay: true,
            autoplayTimeout: 4000,
            center: true,
            animateOut: 'fadeOut',
            rtl: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                760: {
                    items: 1
                }
            }
        });
    }
    testimonial_carousel();


}(jQuery));
