var _titleSllipsis = null;
var _loadFbSDk = null;
jQuery(document).ready(function () {
    try {
        jQuery("#mega-menu-1").dcMegaMenu({
            speed: "fast",
            effect: "slide",
        });
    } catch (err) {
        console.error(err.message);
    }
    try {
        jQuery(".last-film-box").each(function () {
            var currentId = jQuery(this).attr("id");
            var categoryId = jQuery(this).attr("data-categoryid");
            if (typeof currentId == "string" && typeof categoryId == "string") {
                jQuery("#" + currentId).carouFredSel({
                    auto: false,
                    prev: "#prev" + categoryId,
                    next: "#next" + categoryId,
                });
            }
        });
        if (
            typeof topSliderInit == "undefined" &&
            (typeof FX_DEVICE_SMALL == "undefined" ||
                !FX_DEVICE_SMALL ||
                typeof FX_DEVICE_TOUTCH == "undefined" ||
                !FX_DEVICE_TOUTCH)
        ) {
            jQuery("#movie-carousel-top").carouFredSel({
                auto: false,
                prev: "#prevTop",
                next: "#nextTop",
            });
            window.topSliderInit = true;
            // eval('console.log("topSliderInit")');
        }
    } catch (err) {
        console.error(err.message);
    }
    try {
        jQuery("#tabs-movie").tabs();
    } catch (err) {
        console.error(err.message);
    }
    _titleSllipsis = function () {
        if (typeof window.localStorage != "undefined") return true;
        jQuery(
            ".movie-title-1, .movie-title-2, .news-title-1 a, .name-en a"
        ).ellipsis();
    };
});
