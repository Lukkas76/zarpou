var App = function() {
    var q, p, m, f, g, i, j, e, o, c;
    var d = function() {
        q = jQuery("html");
        p = jQuery("body");
        m = jQuery("#page-container");
        f = jQuery("#sidebar");
        g = jQuery("#sidebar-scroll");
        i = jQuery("#side-overlay");
        j = jQuery("#side-overlay-scroll");
        e = jQuery("#header-navbar");
        o = jQuery("#main-container");
        c = jQuery("#page-footer")
    };
    var r = function() {
        h(false, "init");
        jQuery('[data-toggle="block-option"]').on("click", function() {
            h(jQuery(this).parents(".block"), jQuery(this).data("action"))
        })
    };
    var h = function(s, u) {
        var v = "si si-size-fullscreen";
        var z = "si si-size-actual";
        var y = "si si-arrow-up";
        var t = "si si-arrow-down";
        if (u === "init") {
            jQuery('[data-toggle="block-option"][data-action="fullscreen_toggle"]').each(function() {
                var B = jQuery(this);
                B.html('<i class="' + (jQuery(this).closest(".block").hasClass("block-opt-fullscreen") ? z : v) + '"></i>')
            });
            jQuery('[data-toggle="block-option"][data-action="content_toggle"]').each(function() {
                var B = jQuery(this);
                B.html('<i class="' + (B.closest(".block").hasClass("block-opt-hidden") ? t : y) + '"></i>')
            })
        } else {
            var x = (s instanceof jQuery) ? s : jQuery(s);
            if (x.length) {
                var A = jQuery('[data-toggle="block-option"][data-action="fullscreen_toggle"]', x);
                var w = jQuery('[data-toggle="block-option"][data-action="content_toggle"]', x);
                switch (u) {
                    case "fullscreen_toggle":
                        x.toggleClass("block-opt-fullscreen");
                        x.hasClass("block-opt-fullscreen") ? jQuery(x).scrollLock() : jQuery(x).scrollLock("off");
                        if (A.length) {
                            if (x.hasClass("block-opt-fullscreen")) {
                                jQuery("i", A).removeClass(v).addClass(z)
                            } else {
                                jQuery("i", A).removeClass(z).addClass(v)
                            }
                        }
                        break;
                    case "fullscreen_on":
                        x.addClass("block-opt-fullscreen");
                        jQuery(x).scrollLock();
                        if (A.length) {
                            jQuery("i", A).removeClass(v).addClass(z)
                        }
                        break;
                    case "fullscreen_off":
                        x.removeClass("block-opt-fullscreen");
                        jQuery(x).scrollLock("off");
                        if (A.length) {
                            jQuery("i", A).removeClass(z).addClass(v)
                        }
                        break;
                    case "content_toggle":
                        x.toggleClass("block-opt-hidden");
                        if (w.length) {
                            if (x.hasClass("block-opt-hidden")) {
                                jQuery("i", w).removeClass(y).addClass(t)
                            } else {
                                jQuery("i", w).removeClass(t).addClass(y)
                            }
                        }
                        break;
                    case "content_hide":
                        x.addClass("block-opt-hidden");
                        if (w.length) {
                            jQuery("i", w).removeClass(y).addClass(t)
                        }
                        break;
                    case "content_show":
                        x.removeClass("block-opt-hidden");
                        if (w.length) {
                            jQuery("i", w).removeClass(t).addClass(y)
                        }
                        break;
                    case "refresh_toggle":
                        x.toggleClass("block-opt-refresh");
                        if (jQuery('[data-toggle="block-option"][data-action="refresh_toggle"][data-action-mode="demo"]', x).length) {
                            setTimeout(function() {
                                x.removeClass("block-opt-refresh")
                            }, 2000)
                        }
                        break;
                    case "state_loading":
                        x.addClass("block-opt-refresh");
                        break;
                    case "state_normal":
                        x.removeClass("block-opt-refresh");
                        break;
                    case "close":
                        x.hide();
                        break;
                    case "open":
                        x.show();
                        break;
                    default:
                        return false
                }
            }
        }
    };
    var l = function() {
        jQuery('[data-toggle="class-toggle"]').on("click", function() {
            var s = jQuery(this);
            jQuery(s.data("target").toString()).toggleClass(s.data("class").toString());
            if (q.hasClass("no-focus")) {
                s.blur()
            }
        })
    };
    var a = function() {
        jQuery('[data-toggle="appear"]').each(function() {
            var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            var v = jQuery(this);
            var u = v.data("class") ? v.data("class") : "animated fadeIn";
            var s = v.data("offset") ? v.data("offset") : 0;
            var t = (q.hasClass("ie9") || w < 992) ? 0 : (v.data("timeout") ? v.data("timeout") : 0);
            v.appear(function() {
                setTimeout(function() {
                    v.removeClass("visibility-hidden").addClass(u)
                }, t)
            }, {
                accY: s
            })
        })
    };
    var n = function() {
        jQuery(".js-datepicker").add(".input-daterange").datepicker({
            weekStart: 1,
            autoclose: true,
            todayHighlight: true,
            language: "pt-BR",
            startDate: new Date()
        });
        jQuery(".js-datepicker-config-aula").add(".input-daterange").datepicker({
            weekStart: 1,
            autoclose: true,
            todayHighlight: true,
            language: "pt-BR",
            startDate: new Date()
        })
    };
    var b = function() {
        jQuery(".js-masked-date").mask("99/99/9999");
        jQuery(".js-masked-date-dash").mask("99-99-9999");
        jQuery(".js-masked-phone").mask("(999) 999-9999");
        jQuery(".js-masked-celphone").mask("(99) 9999-9999?9");
        jQuery(".js-masked-cep").mask("99999-999");
        jQuery(".js-masked-cpf").mask("999.999.999-99");
        jQuery(".js-masked-hour").mask("99:99");
        jQuery(".js-masked-taxid").mask("99-9999999");
        jQuery(".js-masked-ssn").mask("999-99-9999");
        jQuery(".js-masked-pkey").mask("a*-999-a999")
    };
    var k = function() {
        jQuery(".js-select2").select2()
    };
    return {
        init: function(s) {
            switch (s) {
                case "uiInit":
                    d();
                    break;
                case "uiLayout":
                    uiLayout();
                    break;
                case "uiNav":
                    uiNav();
                    break;
                case "uiBlocks":
                    r();
                    break;
                case "uiForms":
                    uiForms();
                    break;
                case "uiHandleTheme":
                    uiHandleTheme();
                    break;
                case "uiToggleClass":
                    l();
                    break;
                case "uiScrollTo":
                    uiScrollTo();
                    break;
                case "uiYearCopy":
                    uiYearCopy();
                    break;
                default:
                    d();
                    r();
                    l()
            }
        },
        layout: function(s) {
            uiLayoutApi(s)
        },
        blocks: function(t, s) {
            h(t, s)
        },
        initHelper: function(s) {
            switch (s) {
                case "appear":
                    a();
                    break;
                case "datepicker":
                    n();
                    break;
                case "masked-inputs":
                    b();
                    break;
                case "select2":
                    k();
                    break;
                default:
                    return false
            }
        },
        initHelpers: function(t) {
            if (t instanceof Array) {
                for (var s in t) {
                    App.initHelper(t[s])
                }
            } else {
                App.initHelper(t)
            }
        }
    }
}();
var OneUI = App;
jQuery(function() {
    if (typeof angular == "undefined") {
        App.init()
    }
});