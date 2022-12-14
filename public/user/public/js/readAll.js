/*
 * jQuery.ReadAll ia a jQuery plugin to shrink large blocks of content and place a read more button below.
 * Created by Anders Fj舁lstr - anders@morriz.net - http://www.morriz.net
 * For documentation see https://github.com/morriznet/jquery.readall
 * Released under MIT license
 * version 1.1
 */

! function(e) {
    e.fn.readall = function(s) {
        var t = e.extend({ showheight: 96, showrows: null, animationspeed: 200, btnTextShowmore: "Đọc thêm", btnTextShowless: "Rút gọn", btnClassShowmore: "readall-button", btnClassShowless: "readall-button" }, s);
        return e(this).each(function() {
            var s = e(this),
                a = function() { return s[0].scrollHeight };
            if (null != t.showrows) {
                var h = Math.floor(1.5 * parseFloat(s.css("font-size")));
                t.showheight = h * t.showrows
            }
            s.addClass("readall").css({ overflow: "hidden" });
            var o = function(h) {
                var o = s.parent().find("button." + t.btnClassShowmore.replace(/\s+/g, ".") + ", button." + t.btnClassShowless.replace(/\s+/g, "."));
                a() > t.showheight + e(o).outerHeight() ? e(o).is(":visible") && null != h || (s.css({ height: t.showheight + "px", "max-height": t.showheight + "px" }), e(o).text(t.btnTextShowmore), s.addClass("readall-hide"), e(o).removeClass(t.btnClassShowless).addClass(t.btnClassShowmore), e(o).show()) : (e(o).is(":visible") || null == h) && (s.css({ height: "", "max-height": "" }), s.removeClass("readall-hide"), e(o).hide())
            };
            if (s.parent().not("readall-wrapper")) {
                s.wrap(e("<div />").addClass("readall-wrapper"));
                var l = e("<button />").addClass(t.btnClassShowmore).text(t.btnTextShowmore).on('click', function(h) { h.preventDefault(), s.hasClass("readall-hide") ? s.css({ height: t.showheight + "px", "max-height": "" }).animate({ height: a() + "px" }, t.animationspeed, function() { s.css({ height: "" }), e(l).text(t.btnTextShowless) }) : s.animate({ height: t.showheight + "px" }, t.animationspeed, function() { s.css({ "max-height": t.showheight + "px" }), e(l).text(t.btnTextShowmore) }), s.toggleClass("readall-hide"), e(this).toggleClass(t.btnClassShowmore).toggleClass(t.btnClassShowless) });
                s.after(l), e(window).on("orientationchange resize", o), o(null)
            }
        }), this
    }
}(jQuery);