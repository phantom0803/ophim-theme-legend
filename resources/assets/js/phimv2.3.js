if (!pautonext) var pautonext = !0;
if (!resizePlayer) var resizePlayer = !1;
var light = 0;
var expandPlayer = 0;
if (!miniPlayer) var miniPlayer = !1;
jQuerycookie = {
    getItem: function (a) {
        return (
            decodeURIComponent(
                document.cookie.replace(
                    new RegExp(
                        "(?:(?:^|.*;)\\s*" +
                            encodeURIComponent(a).replace(
                                /[\-\.\+\*]/g,
                                "\\jQuery&"
                            ) +
                            "\\s*\\=\\s*([^;]*).*jQuery)|^.*jQuery"
                    ),
                    "jQuery1"
                )
            ) || null
        );
    },
    setItem: function (a, b, c, d, e, f) {
        if (!a || /^(?:expires|max\-age|path|domain|secure)jQuery/i.test(a))
            return !1;
        var g = "";
        if (c)
            switch (c.constructor) {
                case Number:
                    g =
                        c === 1 / 0
                            ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT"
                            : "; max-age=" + c;
                    break;
                case String:
                    g = "; expires=" + c;
                    break;
                case Date:
                    g = "; expires=" + c.toUTCString();
            }
        return (
            (document.cookie =
                encodeURIComponent(a) +
                "=" +
                encodeURIComponent(b) +
                g +
                (e ? "; domain=" + e : "") +
                (d ? "; path=" + d : "") +
                (f ? "; secure" : "")),
            !0
        );
    },
    removeItem: function (a, b, c) {
        return !(
            !a ||
            !this.hasItem(a) ||
            ((document.cookie =
                encodeURIComponent(a) +
                "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" +
                (c ? "; domain=" + c : "") +
                (b ? "; path=" + b : "")),
            0)
        );
    },
    hasItem: function (a) {
        return new RegExp(
            "(?:^|;\\s*)" +
                encodeURIComponent(a).replace(/[\-\.\+\*]/g, "\\jQuery&") +
                "\\s*\\="
        ).test(document.cookie);
    },
    keys: function () {
        for (
            var a = document.cookie
                    .replace(
                        /((?:^|\s*;)[^\=]+)(?=;|jQuery)|^\s*|\s*(?:\=[^;]*)?(?:\1|jQuery)/g,
                        ""
                    )
                    .split(/\s*(?:\=[^;]*)?;\s*/),
                b = 0;
            b < a.length;
            b++
        )
            a[b] = decodeURIComponent(a[b]);
        return a;
    },
};
function LightToggle() {
    if (light == 0) {
        jQuery("body").append(
            '<div id="light-overlay" style="position: fixed; z-index: 999; background-color: rgb(0, 0, 0); opacity: 0.98; top: 0px; left: 0px; width: 100%; height: 100%;overflow:hidden"></div>'
        );
        jQuery("#watch-block").css({
            "z-index": "1000",
            position: "relative",
        });
        jQuery("#light-status").html("Bật đèn");
        if (expandPlayer == 0) {
            jQuery("#btn-expand").click();
        }
        light = 1;
    } else {
        jQuery("div#light-overlay").remove();
        jQuery("#watch-block").css({
            "z-index": "1",
            position: "relative",
        });
        jQuery("#light-status").html("Tắt đèn");
        light = 0;
    }
}
jQuery(document).ready(function () {
    jQuery("#btn-autonext").on("click", function () {
        return (
            pautonext
                ? (jQuery("#autonext-status").html("Tắt"), (pautonext = !1))
                : (jQuery("#autonext-status").html("Bật"), (pautonext = !0)),
            !1
        );
    }),
        jQuery("#btn-light").on("click", function () {
            LightToggle();
        }),
        jQuery("#btn-toggle-error").on("click", function () {
            jQuery
                .ajax({
                    url: URL_POST_REPORT_ERROR,
                    type: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    data: JSON.stringify({
                        message: "",
                    }),
                })
                .done(function (data) {
                    fx.displayMessage(
                        "Thông báo của bạn đã được gửi đi, BQT sẽ khắc phục trong thời gian sớm nhất. Thank!"
                    );
                });

            jQuery(this).remove();
        }),
        jQuery("#btn-expand").on("click", function () {
            if (0 == resizePlayer) {
                var orgPlayerSize = {};
                (orgPlayerSize.width = jQuery("#media-player-box").width()),
                    (orgPlayerSize.height =
                        jQuery("#media-player-box").height());
                var a = 980,
                    b = {
                        width: a - 20,
                        height: Math.ceil((a / 16) * 9) + 40,
                    },
                    c = jQuery("#block-comment").offset().top;
                jQuery("#sidebar").animate({
                    marginTop: c,
                }),
                    jQuery("#block-player").animate({
                        width: a,
                    }),
                    jQuery("#media-player-box,#media-player").animate({
                        width: b.width,
                        height: b.height,
                    }),
                    fx.scrollTo("#watch-block", 1e3),
                    jQuery("#expand-status").html("Thu nhỏ"),
                    (resizePlayer = !0);
            } else
                jQuery("#sidebar").animate({
                    marginTop: 0,
                }),
                    jQuery("#block-player").animate({
                        width: "670px",
                    }),
                    jQuery("#media-player-box,#media-player").animate({
                        width: "100%",
                        height: "365px",
                    }),
                    fx.scrollTo("#watch-block", 1e3),
                    jQuery("#expand-status").html("Phóng to"),
                    (resizePlayer = !1);
            return !1;
        }),
        jQuery("#reload-list-server").on("click", function () {
            jQuery
                .ajax({
                    url: PlayerLoad,
                    type: "POST",
                    dataType: "JSON",
                    data: "filmLoadserver=1&filmId=" + filmInfo.filmID,
                })
                .done(function (a) {
                    void 0 !== a._fxStatus && a._fxStatus && location.reload(),
                        console.log(a);
                });
        }),
        jQuery("#btn-remove-ad").on("click", function () {
            return (
                jQuery("div.ad-container").remove(),
                jQuery(this).remove(),
                fx.scrollTo("#watch-block", 1e3),
                !1
            );
        });
});
var $cookie = {
    getItem: function (sKey) {
        return (
            decodeURIComponent(
                document.cookie.replace(
                    new RegExp(
                        "(?:(?:^|.*;)\\s*" +
                            encodeURIComponent(sKey).replace(
                                /[\-\.\+\*]/g,
                                "\\$&"
                            ) +
                            "\\s*\\=\\s*([^;]*).*$)|^.*$"
                    ),
                    "$1"
                )
            ) || null
        );
    },
    setItem: function (sKey, sValue, vEnd, sPath, sDomain, bSecure) {
        if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) {
            return false;
        }
        var sExpires = "";
        if (vEnd) {
            switch (vEnd.constructor) {
                case Number:
                    sExpires =
                        vEnd === Infinity
                            ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT"
                            : "; max-age=" + vEnd;
                    break;
                case String:
                    sExpires = "; expires=" + vEnd;
                    break;
                case Date:
                    sExpires = "; expires=" + vEnd.toUTCString();
                    break;
            }
        }
        document.cookie =
            encodeURIComponent(sKey) +
            "=" +
            encodeURIComponent(sValue) +
            sExpires +
            (sDomain ? "; domain=" + sDomain : "") +
            (sPath ? "; path=" + sPath : "") +
            (bSecure ? "; secure" : "");
        return true;
    },
    removeItem: function (sKey, sPath, sDomain) {
        if (!sKey || !this.hasItem(sKey)) {
            return false;
        }
        document.cookie =
            encodeURIComponent(sKey) +
            "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" +
            (sDomain ? "; domain=" + sDomain : "") +
            (sPath ? "; path=" + sPath : "");
        return true;
    },
    hasItem: function (sKey) {
        return new RegExp(
            "(?:^|;\\s*)" +
                encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") +
                "\\s*\\="
        ).test(document.cookie);
    },
    keys: /* optional method: you can safely remove it! */ function () {
        var aKeys = document.cookie
            .replace(
                /((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g,
                ""
            )
            .split(/\s*(?:\=[^;]*)?;\s*/);
        for (var nIdx = 0; nIdx < aKeys.length; nIdx++) {
            aKeys[nIdx] = decodeURIComponent(aKeys[nIdx]);
        }
        return aKeys;
    },
};
function downloadFilm() {
    fx.displayMessage(
        "Bấm vào hình ICON DOWNLOAD ở khung PLAYER xem phim để tải bộ phim này"
    );
}
if (navigator.userAgent.indexOf("Chrome") != -1) {
    var element = new Image();
    var devtoolsOpen = false;
    element.__defineGetter__("id", function () {
        devtoolsOpen = true;
    });
    setInterval(function () {
        devtoolsOpen = false;
        document.getElementById("output").innerHTML += devtoolsOpen
            ? window.location.replace("https://xemphimlau.com")
            : "";
    }, 1000);
} else {
    $(document).keydown(function (e) {
        return 123 != e.keyCode && !e.ctrlKey && !e.shiftKey && void 0;
    }),
        $(document).on("contextmenu", function (e) {
            e.preventDefault();
        }),
        (function e() {
            try {
                !(function e(t) {
                    (1 === ("" + t / t).length && t % 20 != 0) ||
                        function () {}.constructor("debugger")(),
                        e(++t);
                })(0);
            } catch (t) {
                setTimeout(e, 1e3);
            }
        })();
}
