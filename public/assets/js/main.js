(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($("#spinner").length > 0) {
                $("#spinner").removeClass("show");
            }
        }, 1);
    };
    spinner();

    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 30) {
            $(".navbar")
                // .removeClass("bg-transparent")
                .addClass("sticky-top shadow-sm")
                .addClass("rounded-5 rounded-top-0");
        } else {
            $(".navbar")
                // .addClass("bg-transparent")
                .removeClass("sticky-top shadow-sm")
                .removeClass("rounded-5 rounded-top-0");
        }
    });

    $(document).ready(function () {
        $(".card-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            // center: true,
            margin: 24,
            dots: true,
            // loop: true,
            nav: false,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 2,
                },
                1000: {
                    items: 4,
                },
            },
        });
    });
})(jQuery);
