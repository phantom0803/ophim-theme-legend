jQuery(document).ready(function () {
    jQuery("#list_actor_carousel").carouFredSel({
        auto: false,
        prev: "#prevActor",
        next: "#nextActor",
    });
    if (
        typeof window.screen.width == "undefined" ||
        window.screen.width > 480
    ) {
        jQuery(".movie-meta-info").slimScroll({
            height: "277px",
            railVisible: true,
            alwaysVisible: true,
        });
    }
    var score_current = jQuery("#score_current").val();
    var hint_current = jQuery("#hint_current").val();
    jQuery("#hint").html(hint_current);
    jQuery("#score").html(score_current + " ĐIỂM");

    function scorehint(score) {
        var text = "";
        if (score == "1") {
            text = "Dở tệ";
        }
        if (score == "2") {
            text = "Dở";
        }
        if (score == "3") {
            text = "Không hay";
        }
        if (score == "4") {
            text = "Ko hay lắm";
        }
        if (score == "5") {
            text = "Bình thường";
        }
        if (score == "6") {
            text = "Xem được";
        }
        if (score == "7") {
            text = "Có vẻ hay";
        }
        if (score == "8") {
            text = "Hay";
        }
        if (score == "9") {
            text = "Rất hay";
        }
        if (score == "10") {
            text = "Hay tuyệt";
        }
        return text;
    }
    jQuery("#star").raty({
        half: false,
        score: function () {
            return jQuery(this).attr("data-score");
        },
        mouseover: function (score, evt) {
            jQuery("#score").html(score + " ĐIỂM");
            jQuery("#hint").html(scorehint(score));
        },
        mouseout: function (score, evt) {
            var score_current = jQuery("#score_current").val();
            var hint_current = jQuery("#hint_current").val();
            jQuery("#hint").html(hint_current);
            jQuery("#score").html(score_current + " ĐIỂM");
        },
        click: function (score, evt) {
            jQuery
                .ajax({
                    url: URL_POST_RATING,
                    type: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    data: JSON.stringify({
                        rating: score,
                    }),
                })
                .done(function (data) {
                    fx.displayMessage("Cảm ơn bạn đã đánh giá bộ phim này!");
                });
        },
    });
    jQuery("#star").css("width", "200px");
    jQuery(".box-rating #hint").css("font-size", "12px");
});
