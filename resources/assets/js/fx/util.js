var ajaxFailedHandle = function (jqXHR, textStatus, errorThrown) {
    return false;
};
var fx = {
    displayCenter: function (html, func, useOverlay) {
        var htmlId = "fxOverlay" + Math.random().toString().replace(".", "");
        var htmlCode =
            '<div style="position: fixed;left: -1000px;top:-1000px;z-index:9999;max-width:100%;" id="' +
            htmlId +
            '" class="_fxOverlayCenter">' +
            html +
            "</div>";
        if (typeof useOverlay != "undefined" && useOverlay) {
            htmlCode =
                '<div id="' +
                htmlId +
                '-bg" class="fxoverlay"></div>' +
                htmlCode;
        }
        if (jQuery("._fxOverlayCenter").length > 0) {
            jQuery("._fxOverlayCenter").fadeOut("fast", function () {
                jQuery("body").append(htmlCode);
            });
        } else {
            jQuery("body").append(htmlCode);
        }
        var boxWith = jQuery("#" + htmlId).width();
        var boxHeight = jQuery("#" + htmlId).height();
        var winWidth = jQuery(window).width();
        var winHeight = jQuery(window).height();
        var left = Math.floor((winWidth - boxWith) / 2);
        var top = Math.floor((winHeight - boxHeight) / 2);
        jQuery("#" + htmlId).css({
            display: "none",
            left: left + "px",
            top: top + "px",
        });
        jQuery("#" + htmlId + " .fxClose").click(function () {
            jQuery("#" + htmlId).fadeOut("fast", function () {
                var bgId = jQuery(this).attr("id");
                jQuery("#" + bgId + "-bg").fadeOut("fast", function () {
                    jQuery(this).remove();
                });
                jQuery(this).remove();
            });
        });
        jQuery("#" + htmlId).fadeIn("fast", function () {
            if (typeof func == "function") {
                func();
                console.log("Đã gọi hàm callback");
            }
            console.log("Đã mở overlayPopup _fxOverlayCenter#" + htmlId);
        });
        return htmlId;
    },
    showLoad: function () {
        jQuery(
            "#fxloading,#fxLoading,#fx-loading,._fxLoading,.fx-loading"
        ).fadeIn("fast");
    },
    hideLoad: function (handler) {
        jQuery(
            "#fxloading,#fxLoading,#fx-loading,._fxLoading,.fx-loading"
        ).fadeOut("fast");
    },
    removeMessage: function (messageId) {
        jQuery("#" + messageId).slideUp("slow", function () {
            jQuery(this).remove();
        });
    },
    displayMessage: function (msg) {
        if (typeof msg != "string") {
            console.error("msg không phải là string");
            console.error(msg);
            return false;
        }
        if (typeof this.messageIndex == "undefined") this.messageIndex = 10000;
        this.messageIndex++;
        if (typeof this.lastMessageId == "undefined") this.lastMessageId = "";
        if (this.lastMessageId) {
            jQuery("#" + this.lastMessageId).fadeOut("fast", function () {
                jQuery(this).remove();
            });
        }
        var messageId = "_fxMsg_" + Math.random().toString().replace(".", "");
        this.lastMessageId = messageId;
        jQuery("body").prepend(
            '<div class="noty_bar noty_theme_default noty_layout_top noty_information" id="' +
                messageId +
                '" style="cursor: pointer; display: none; overflow: hidden; height: auto;z-index:' +
                this.messageIndex +
                ';">\
			<div class="noty_message">\
				<span class="noty_text">\
				' +
                msg +
                "\
				</span>\
			</div>\
		</div>"
        );
        jQuery("#" + messageId).click(function () {
            jQuery(this).slideUp("slow", function () {
                jQuery(this).remove();
            });
        });
        setTimeout("fx.removeMessage('" + messageId + "')", 2500);
        jQuery("#" + messageId).slideDown("fast");
    },
    displayPopup: function (title, content, func, useOverlay) {
        if (typeof title != "string") var title = "";
        if (typeof content != "string") var content = "";
        if (typeof func != "function") var func = function () {};
        if (typeof useOverlay == "undefined") var useOverlay = 0;
        var html =
            '<div class="modal modal-light" id="popup-container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: block; position:static; width: auto; outline: none;max-width:100%;">\
			<div class="modal-dialog" style="width: auto; min-width: 400px;">\
				<div class="modal-content">\
				<div class="modal-header">\
					<button type="button" class="close btn-close-popup fxClose" data-dismiss="modal" aria-hidden="true">×</button>\
					<h4 class="modal-title" id="popup-header">' +
            title +
            '</h4>\
				</div>\
				<div class="modal-body" id="popup-body" style="padding: 20px;">\
				' +
            content +
            '	\
				</div>\
				<!-- div class="modal-footer" id="popup-footer">\
					<button id="btn-close-popup" class="fxClose btn-close-popup btn btn-default">Đóng</button>\
				</div -->\
				</div><!-- /.modal-content -->\
			</div><!-- /.modal-dialog -->\
		</div>';
        return this.displayCenter(html, func, useOverlay);
    },
    errorStatusHandler: function (data) {
        console.log("errorStatusHandler:");
        console.log(data);
        if (typeof data != "object") {
            console.error("data phải là 1 đối tượng:");
            console.error(data);
            return false;
        }
        if (
            typeof data._fxErrorHandled != "undefined" &&
            data._fxErrorHandled
        ) {
            return false;
        }
        if (
            typeof data._fxError == "string" &&
            jQuery.trim(data._fxError) != ""
        ) {
            fx.messageBox("Có lỗi xảy ra", data._fxError);
        } else if (
            typeof data._fxErrors == "object" &&
            data._fxErrors.length > 0
        ) {
            var errorStr = data._fxErrors.join("<br />");
            fx.messageBox("Có lỗi xảy ra", errorStr);
            console.log(data._fxErrors);
        } else if (
            typeof data._fxHtml == "string" &&
            jQuery.trim(data._fxHtml) != ""
        ) {
            fx.displayCenter(data._fxHtml);
        } else {
            alert(
                "Xảy ra lỗi không mong muốn, bật cửa sổ consolse để xem chi tiết."
            );
        }
    },
    scrollTo: function (selector, scrollTime) {
        if (typeof scrollTime != "number" || scrollTime < 1000)
            var scrollTime = 1000;
        if (jQuery(selector).length == 0) {
            console.error(
                "Không xác định được selector: " +
                    selector +
                    " để tìm vị trí cuộn."
            );
            return false;
        }
        var boxOffset = jQuery(selector).offset();
        var currentScrollTop = jQuery(document).scrollTop();
        if (
            typeof boxOffset == "object" &&
            typeof currentScrollTop == "number" &&
            boxOffset.top != currentScrollTop
        ) {
            jQuery("body,html").animate(
                {
                    scrollTop: boxOffset.top,
                },
                scrollTime
            );
        } else {
            console.error("boxOffset:");
            console.log(boxOffset);
            console.error("currentScrollTop");
            console.log(currentScrollTop);
        }
    },
};
fx.getCookie = function (name) {
    var regStr = "/" + name + "=([^;]*)/i";
    eval("var cookieReg=" + regStr);
    var results = cookieReg.exec(document.cookie);
    if (results != null && results.length > 1) return results[1];
    return "";
};
fx.messageBox = function (title, message, buttons, callback, useOverlay) {
    var _title = "Thông báo",
        _message = "",
        _buttons = [
            {
                text: "OK",
                href: "javascript:void(0);",
                title: "Đóng cửa sổ này lại",
                callback: function () {},
            },
        ];
    var _callback = function () {};
    var _useOverlay = false;
    if (typeof message == "string") _message = message;
    if (typeof title == "string") _title = title;
    if (typeof buttons == "object") {
        if (buttons instanceof Array) {
            var tmpButtons = [];
            for (var i = 0; i < buttons.length; i++) {
                var button = buttons[i];
                if (typeof button.text == "string") {
                    if (typeof button.title != "string") button.title = "";
                    if (typeof button.href != "string")
                        button.href = "javascript:void(0);";
                    tmpButtons.push(button);
                }
            }
            if (tmpButtons.length > 0) _buttons = tmpButtons;
        } else {
            _buttons[0] = buttons;
        }
    }
    if (typeof callback == "function") {
        _callback = callback;
    }
    if (typeof useOverlay != "undefined") {
        _useOverlay = useOverlay;
    }
    var messageBoxId = Math.random().toString().replace(".", "");
    var buttonHtml = "";
    for (var i = 0; i < _buttons.length; i++) {
        buttonHtml +=
            '<a id="button-' +
            i +
            '" class="btn btn-default" title="' +
            _buttons[i].title +
            '" href="' +
            _buttons[i].href +
            '">' +
            _buttons[i].text +
            "</a>";
    }
    var html =
        '<div class="modal modal-light messagebox-container" id="' +
        messageBoxId +
        '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: block; position:static; width: auto; outline: none;max-width:100%;box-sizing:border-box;-webkit-box-sizing:border-box;">\
			<div class="modal-dialog" style="width: auto; min-width: 320px;">\
				<div class="modal-content">\
				<div class="modal-header">\
					<button type="button" class="close btn-close-popup fxClose" data-dismiss="modal" aria-hidden="true">×</button>\
					<h4 class="modal-title" id="popup-header">' +
        _title +
        '</h4>\
				</div>\
				<div class="modal-body" id="popup-body" style="padding: 20px;">\
				' +
        _message +
        '	\
				</div>\
				<div class="modal-footer" id="popup-footer">\
					' +
        buttonHtml +
        "\
				</div>\
				</div><!-- /.modal-content -->\
			</div><!-- /.modal-dialog -->\
		</div>";
    var htmlId = this.displayCenter(html, null, _useOverlay);
    for (var i = 0; i < _buttons.length; i++) {
        jQuery("#button-" + i).attr("data-order", i);
        jQuery("#button-" + i).click(function () {
            var currentPath = window.location.pathname;
            var order = jQuery(this).attr("data-order");
            if (typeof _buttons[order].callback == "function")
                _buttons[order].callback();
            jQuery("#" + htmlId).fadeOut("fast", function () {
                jQuery(this).remove();
            });
            jQuery("#" + htmlId + "-bg").fadeOut("fast", function () {
                jQuery(this).remove();
            });
            if (currentPath != window.location.pathname) {
                console.log(currentPath);
                console.log(window.location.pathname);
                return false;
            }
            return true;
        });
    }
    if (typeof _callback == "function") _callback();
};
fx.watchingMessbox = function (title, message, buttons, callback, useOverlay) {
    var _title = "Thông báo",
        _message = "",
        _buttons = [
            {
                text: "OK",
                href: "javascript:void(0);",
                title: "Đóng cửa sổ này lại",
                callback: function () {},
            },
        ];
    var _callback = function () {};
    var _useOverlay = false;
    if (typeof message == "string") _message = message;
    if (typeof title == "string") _title = title;
    if (typeof buttons == "object") {
        if (buttons instanceof Array) {
            var tmpButtons = [];
            for (var i = 0; i < buttons.length; i++) {
                var button = buttons[i];
                if (typeof button.text == "string") {
                    if (typeof button.title != "string") button.title = "";
                    if (typeof button.href != "string")
                        button.href = "javascript:void(0);";
                    tmpButtons.push(button);
                }
            }
            if (tmpButtons.length > 0) _buttons = tmpButtons;
        } else {
            _buttons[0] = buttons;
        }
    }
    if (typeof callback == "function") {
        _callback = callback;
    }
    if (typeof useOverlay != "undefined") {
        _useOverlay = useOverlay;
    }
    var messageBoxId = Math.random().toString().replace(".", "");
    var buttonHtml = "";
    for (var i = 0; i < _buttons.length; i++) {
        buttonHtml +=
            '<button id="' +
            _buttons[i].id +
            '" class="' +
            _buttons[i].selector +
            '" title="' +
            _buttons[i].title +
            '">' +
            _buttons[i].text +
            "</button>";
    }
    var html =
        '<div class="watching-messbox-overlay" id="watching-messbox-overlay"></div>\
	        <div class="watching-messbox-wrapper" id="watching-messbox-wrapper" style="left: 50%; top: 50%; margin-top: -84px; margin-left: -300px;">\
			<div class="watching-messbox-header">' +
        title +
        '</div>\
			<div class="watching-messbox-body">' +
        message +
        '</div>\
			<div class="watching-messbox-footer">\
			' +
        buttonHtml +
        "\
				</div>\
			</div>";
    var htmlId = this.displayCenter(html, null, false);
    for (var i = 0; i < _buttons.length; i++) {
        jQuery("#" + _buttons[i].id).attr("data-order", i);
        jQuery("#" + _buttons[i].id).click(function () {
            var currentPath = window.location.pathname;
            var order = jQuery(this).attr("data-order");
            if (typeof _buttons[order].callback == "function")
                _buttons[order].callback();
            jQuery("#" + htmlId).fadeOut("fast", function () {
                jQuery(this).remove();
            });
            jQuery("#" + htmlId + "-bg").fadeOut("fast", function () {
                jQuery(this).remove();
            });
            if (currentPath != window.location.pathname) {
                console.log(currentPath);
                console.log(window.location.pathname);
                return false;
            }
            return true;
        });
    }
    if (typeof _callback == "function") _callback();
};
fx.localStorage = {
    check: function () {
        if (typeof window.localStorage == "undefined") {
            console.error(
                "Trình duyệt của bạn không hỗ trợ localStorage của Html5"
            );
            return false;
        }
        return true;
    },
    set: function (name, value) {
        if (!fx.localStorage.check()) return false;
        if (typeof name != "string" || typeof value != "string") {
            console.error(
                "name và value  muốn lưu trong localStorage phải là string"
            );
            return false;
        }
        window.localStorage.setItem(name, value);
        return true;
    },
    get: function (name) {
        if (!fx.localStorage.check()) return false;
        if (typeof name != "string") {
            console.error(
                "name của record muốn lấy từ localStorage phải là string"
            );
            return false;
        }
        var value = window.localStorage.getItem(name);
        if (value == null) return "";
        return value;
    },
};
fx.callReady = function () {
    jQuery(document).ready();
};
fx.fireReadyDelay = function () {
    setTimeout("fx.callReady()", 2000);
};
jQuery.ajaxSetup({
    beforeSend: function (jqXHR, settings) {
        if (typeof fx.token == "string") {
            if (settings.url.indexOf("?") == -1)
                settings.url += "?_fxToken=" + escape(fx.token);
            else settings.url += "&_fxToken=" + escape(fx.token);
        }
        if (typeof settings.silentLoad == "undefined" || !settings.silentLoad) {
            fx.showLoad();
        }
    },
    complete: function (jqXHR, textStatus) {
        fx.hideLoad();
        if (textStatus == "success") {
        }
    },
    success: function (data) {
        // if (typeof data.status != "undefined" && !data.status) {
        //     console.error("Xảy ra lỗi khi xử lý trên server !");
        //     fx.errorStatusHandler(data);
        // }
    },
    error: function (jqXHR, textStatus, errorThrown) {
        if (typeof jqXHR.silentError != "undefined" && jqXHR.silentError)
            return false;
        if (typeof this.silentError != "undefined" && this.silentError)
            return false;
        console.error("ajax lỗi khi gửi/nhận !");
        console.warn("errorThrown:" + errorThrown);
        console.warn("Loại lỗi:" + textStatus);
        console.warn("Nội dung phản hồi:");
        console.warn(jqXHR.responseText);
        console.log(jqXHR);
        console.log(this);
        switch (textStatus) {
            case "timeout":
                // alert('Không nhận được trả lời từ máy chủ. Vui lòng thử lại.');
                fx.messageBox(
                    "Lỗi",
                    "Không nhận được trả lời từ máy chủ. Vui lòng thử lại."
                );
                break;
            case "parsererror":
                // alert('Dữ liệu máy chủ trả về bị lỗi. Vui lòng thử lại.');
                fx.messageBox(
                    "Lỗi",
                    "Dữ liệu máy chủ trả về bị lỗi. Vui lòng thử lại."
                );
                break;
            case "error":
                if (errorThrown === "")
                    fx.messageBox(
                        "Lỗi",
                        "Không kết nối được với máy chủ. Vui lòng thử lại sau."
                    );
                else if (errorThrown !== 0 && errorThrown !== "0")
                    fx.messageBox(
                        "Lỗi",
                        "Lỗi máy chủ: " + errorThrown + ". Vui lòng thử lại."
                    );
                break;
            default:
                fx.messageBox(
                    "Lỗi",
                    "Xảy ra lỗi khi gửi yêu cầu, vui lòng thử lại."
                );
        }
    },
});
var isToutchDevice = null;
var FX_DEVICE_TOUTCH = false;
var FX_DEVICE_SMALL = false;
jQuery(document).ready(function () {
    isToutchDevice = function () {
        try {
            document.createEvent("TouchEvent");
            return true;
        } catch (e) {}
        try {
            return "ontouchstart" in document.documentElement;
        } catch (e) {}
        return false;
    };
    if (isToutchDevice()) {
        jQuery("body").addClass("fx-device-toutch");
        FX_DEVICE_TOUTCH = true;
    } else {
        FX_DEVICE_TOUTCH = false;
    }
    try {
        if (jQuery(window).width() <= 480 || jQuery(window).height() <= 480) {
            jQuery("body").addClass("fx-device-small");
            FX_DEVICE_SMALL = true;
        } else {
            FX_DEVICE_SMALL = false;
        }
    } catch (e) {
        FX_DEVICE_SMALL = false;
    }
});
