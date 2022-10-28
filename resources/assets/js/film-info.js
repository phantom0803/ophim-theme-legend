var filmInfo = {};
jQuery(document).ready(function () {
    jQuery(".block-movie-content > .content img").each(function () {
        var parentElemCenter = jQuery(this).parent().css("text-align");
        if (parentElemCenter != "center") {
            jQuery(this).wrap('<div style="text-align: center"></div>');
        }
    });
    if (jQuery("#film-content-wrapper > #film-content").length > 0) {
        var contentElement = jQuery("#film-content-wrapper > #film-content")[0];
        jQuery(contentElement).css("max-height", "800px");
        jQuery(window).load(function () {
            if (
                typeof contentElement.scrollHeight == "number" &&
                contentElement.scrollHeight > 0
            ) {
                window._restoreContentHeight = currentContentHeight =
                    contentElement.scrollHeight;
                window._flagContentHeight = "small";
                if (currentContentHeight > 800) {
                    window._restoreContentHeight = currentContentHeight;
                    window._flagContentHeight = "small";
                    jQuery("#film-content-wrapper").append(
                        '<button class="expand-content" id="btn-expand-content">Hiển thị thêm</button>'
                    );
                    jQuery("#btn-expand-content").click(function () {
                        if (window._flagContentHeight == "small") {
                            if (
                                typeof contentElement.scrollHeight ==
                                    "number" &&
                                contentElement.scrollHeight > 0
                            )
                                window._restoreContentHeight =
                                    contentElement.scrollHeight;
                            jQuery(contentElement).height(
                                window._restoreContentHeight + "px"
                            );
                            window._flagContentHeight = "large";
                            jQuery("#btn-expand-content").text(
                                "Thu gọn nội dung"
                            );
                        } else {
                            fx.scrollTo("#film-content-wrapper", 300);
                            jQuery(contentElement).height("800px");
                            window._flagContentHeight = "small";
                            jQuery("#btn-expand-content").text("Hiển thị thêm");
                        }
                    });
                    jQuery(contentElement).css({
                        height: "800px",
                        "max-height": "none",
                    });
                }
            }
        });
    }
});
