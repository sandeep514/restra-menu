$(function () {
    "use strict";
    $(".preloder").on("click", function () {
        $(this).fadeOut();
    });
    function bindNavbar() {
        if ($(window).width() > 768) {
            $(".navbar .dropdown")
                .on("mouseover", function () {
                    $(".dropdown-toggle", this).next(".dropdown-menu").show();
                })
                .on("mouseout", function () {
                    $(".dropdown-toggle", this).next(".dropdown-menu").hide();
                });
            $(".dropdown-toggle").on("click", function () {
                if ($(this).next(".dropdown-menu").is(":visible")) {
                    window.location = $(this).attr("href");
                }
            });
        } else {
            $(".navbar-default .dropdown").off("mouseover").off("mouseout");
        }
    }
    $(window).resize(function () {
        bindNavbar();
    });
    bindNavbar();
    if ($(".special-slider").length) {
        $(".special-slider").flexslider({ animation: "slide", controlNav: false, directionNav: false, slideshow: true, slideshowSpeed: 3000 });
        $(".prev").on("click", function () {
            $(".special-slider").flexslider("prev");
            return false;
        });
        $(".next").on("click", function () {
            $(".special-slider").flexslider("next");
            return false;
        });
    }
    // if ($(".menu-items").length) {
    //     var defaultFilter = $(".tagsort-active").attr("data-filter");
    //     var $grid = $(".menu-items").isotope({ itemSelector: ".menu-item", layoutMode: "fitRows", filter: defaultFilter });
    //     $(".menu-tags").on("click", "span", function () {
    //         $(".menu-tags span").removeClass("tagsort-active");
    //         $(this).toggleClass("tagsort-active");
    //         var filterValue = $(this).attr("data-filter");
    //         $grid.isotope({ filter: filterValue });
    //     });
    // }
    // if ($(".menu-items2").length) {
    //     var defaultFilter = $(".tagsort2-active").attr("data-filter");
    //     var $grids = $(".menu-items2").isotope({ itemSelector: ".menu-item2", layoutMode: "fitRows", filter: defaultFilter });
    //     $(".menu-tags2").on("click", "span", function () {
    //         $(".menu-tags2 span").removeClass("tagsort2-active");
    //         $(this).toggleClass("tagsort2-active");
    //         var filterValue = $(this).attr("data-filter");
    //         $grids.isotope({ filter: filterValue });
    //     });
    // }
    // if ($(".menu-items3").length) {
    //     var defaultFilter = $(".tagsort3-active").attr("data-filter");
    //     var $grid3 = $(".menu-items3").isotope({ itemSelector: ".menu-item3", layoutMode: "fitRows", filter: defaultFilter });
    //     $(".menu-tags3").on("click", "span", function () {
    //         $(".menu-tags3 span").removeClass("tagsort3-active");
    //         $(this).toggleClass("tagsort3-active");
    //         var filterValue = $(this).attr("data-filter");
    //         $grid3.isotope({ filter: filterValue });
    //     });
    // }
    // if ($(".menu-items4").length) {
    //     var defaultFilter = $(".tagsort4-active").attr("data-filter");
    //     var $grid4 = $(".menu-items4").isotope({ itemSelector: ".menu-item4", layoutMode: "fitRows", filter: defaultFilter });
    //     $(".menu-tags4").on("click", "span", function () {
    //         $(".menu-tags4 span").removeClass("tagsort4-active");
    //         $(this).toggleClass("tagsort4-active");
    //         var filterValue = $(this).attr("data-filter");
    //         $grid4.isotope({ filter: filterValue });
    //     });
    // }
});
