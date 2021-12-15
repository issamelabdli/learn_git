var BLANK = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";

$.fn.imagesLoaded = function(e) {

    function t() {

        var t = $(l),

            i = $(c);

        n && (c.length ? n.reject(a, t, i) : n.resolve(a)), $.isFunction(e) && e.call(s, a, t, i)

    }



    function i(e, i) {

        e.src !== BLANK && -1 === $.inArray(e, r) && (r.push(e), i ? c.push(e) : l.push(e), $.data(e, "imagesLoaded", {

            isBroken: i,

            src: e.src

        }), o && n.notifyWith($(e), [i, a, $(l), $(c)]), a.length === r.length && (setTimeout(t), a.unbind(".imagesLoaded")))

    }

    var s = this,

        n = $.isFunction($.Deferred) ? $.Deferred() : 0,

        o = $.isFunction(n.notify),

        a = s.find("img").add(s.filter("img")),

        r = [],

        l = [],

        c = [];

    return $.isPlainObject(e) && $.each(e, function(t, i) {

        "callback" === t ? e = i : n && n[t](i)

    }), a.length ? a.bind("load.imagesLoaded error.imagesLoaded", function(e) {

        i(e.target, "error" === e.type)

    }).each(function(e, t) {

        var s = t.src,

            n = $.data(t, "imagesLoaded");

        return n && n.src === s ? void i(t, n.isBroken) : t.complete && void 0 !== t.naturalWidth ? void i(t, 0 === t.naturalWidth || 0 === t.naturalHeight) : void((t.readyState || t.complete) && (t.src = BLANK, t.src = s))

    }) : t(), n ? n.promise(s) : s

}; 
