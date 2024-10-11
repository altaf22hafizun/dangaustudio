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
                .addClass("sticky-top shadow-sm");
        } else {
            $(".navbar")
                // .addClass("bg-transparent")
                .removeClass("sticky-top shadow-sm");
        }
    });
})(jQuery);
