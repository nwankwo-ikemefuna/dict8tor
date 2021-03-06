"use strict";
var Charts = function() {};
Charts.prototype.init = function() {}, Charts.prototype.pieChart = function(t, a) {
    var r = document.getElementById(t),
        e = document.createElement("div");
    e.classList.add("chart-responsive");
    var l, n, s, i, o, u, c, h, g, d, p, m, w, b = (i = [], o = (l = a).size / 2, w = m = p = d = g = h = c = u = 0, l.sectors.map(function(t, e) {
            u = 360 * t.percentage / 100, c = (n = 180 < u ? 360 - u : u) * Math.PI / 180, h = Math.sqrt(2 * o * o - 2 * o * o * Math.cos(c)), g = n <= 90 ? o * Math.sin(c) : o * Math.sin((180 - n) * Math.PI / 180), d = Math.sqrt(h * h - g * g), m = d, u <= 180 ? (p = o + g, s = 0) : (p = o - g, s = 1), i.push({
                percentage: t.percentage,
                name: t.name,
                color: t.color,
                arcSweep: s,
                L: o,
                X: p,
                Y: m,
                R: w
            }), w += u
        }), i),
        A = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    A.setAttributeNS(null, "style", "width: " + a.size + "px; height: " + a.size + "px"), document.body.contains(r) && (e.appendChild(A), r.appendChild(e)), b.map(function(t) {
        var e = document.createElementNS("http://www.w3.org/2000/svg", "path");
        e.setAttributeNS(null, "fill", t.color), e.setAttributeNS(null, "d", "M" + t.L + "," + t.L + " L" + t.L + ",0 A" + t.L + "," + t.L + " 1 " + t.arcSweep + ",1 " + t.X + ", " + t.Y + " z"), e.setAttributeNS(null, "transform", "rotate(" + t.R + ", " + t.L + ", " + t.L + ")");
        var l = document.createElement("p"),
            n = document.createElement("i");
        n.classList.add("fa", "fa-circle", "m-r-5"), n.style.color = t.color, l.appendChild(n), l.innerHTML += t.name + ": " + t.percentage + "%", document.body.contains(r) && 1 == a.labels && r.appendChild(l), A.appendChild(e)
    })
}, Charts.prototype.generateAreaChart = function(g, d) {
    var t, p, m, e, w, l = document.createElement("div"),
        n = document.getElementById(g),
        b = 10,
        a = d.width,
        r = d.height,
        A = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    if (l.classList.add("chart-responsive"), document.body.contains(n)) var s = n.parentNode.offsetWidth,
        i = n.parentNode.offsetHeight; - 1 !== a.toString().indexOf("%") ? (t = !0, a = a.substring(0, a.length - 1) * s / 100) : t = !1, m = (a - 3 * (p = 6 * a / 100)) / (d.xAxis.categories.length - 1), A.setAttributeNS(null, "style", "width: " + a + "px; height: " + r + "px"), e = -1 !== r.toString().indexOf("%") ? ((r = r.substring(0, r.length - 1) * i / 100) - 20 - b) / (d.yAxis.labels.length - 1) : (r - 20 - b) / (d.yAxis.labels.length - 1), A.setAttributeNS(null, "style", "width: " + a + "px; height: " + r + "px");
    var x = D(d.yAxis.labels.length, e)[D(d.yAxis.labels.length, e).length - 1],
        o = D(d.xAxis.categories.length, m)[D(d.xAxis.categories.length, m).length - 1],
        S = x / d.yAxis.labels[d.yAxis.labels.length - 1];
    var u, c = (u = [], d.series.map(function(t, e) {
            u.push({
                name: t.name,
                data: t.data,
                color: t.color
            })
        }), u),
        N = document.createElementNS("http://www.w3.org/2000/svg", "g");
    N.setAttributeNS(null, "class", "markers");
    var f = document.createElementNS("http://www.w3.org/2000/svg", "g");
    f.setAttributeNS(null, "class", "circles");
    var h = document.createElementNS("http://www.w3.org/2000/svg", "g"),
        v = document.createElementNS("http://www.w3.org/2000/svg", "g");
    h.setAttributeNS(null, "class", "grid x-grid"), v.setAttributeNS(null, "class", "grid y-grid");
    for (var y = 0; y < d.xAxis.categories.length; y++) {
        var C = document.createElementNS("http://www.w3.org/2000/svg", "line");
        C.setAttributeNS(null, "x1", D(d.xAxis.categories.length, m)[y] + p), C.setAttributeNS(null, "x2", D(d.xAxis.categories.length, m)[y] + p), C.setAttributeNS(null, "y1", b), C.setAttributeNS(null, "y2", x), h.appendChild(C)
    }
    for (y = 0; y < d.yAxis.labels.length; y++) {
        var E = document.createElementNS("http://www.w3.org/2000/svg", "line");
        E.setAttributeNS(null, "x1", p), E.setAttributeNS(null, "x2", o + p), E.setAttributeNS(null, "y1", b + D(d.yAxis.labels.length, e)[y]), E.setAttributeNS(null, "y2", b + D(d.yAxis.labels.length, e)[y]), v.appendChild(E)
    }
    A.appendChild(h), A.appendChild(v), c.map(function(t) {
        var e = document.createElementNS("http://www.w3.org/2000/svg", "path"),
            l = document.createElementNS("http://www.w3.org/2000/svg", "g"),
            n = D(d.xAxis.categories.length, m),
            a = [];
        n.unshift(0), a[0] = x + b, l.setAttributeNS(null, "class", "points");
        for (var r = 0; r < t.data.length; r++) {
            a.push(b + x - S * t.data[r]);
            var s = document.createElementNS("http://www.w3.org/2000/svg", "text");
            s.textContent = t.name + ": " + t.data[r], s.setAttributeNS(null, "fill", "#616161"), s.setAttributeNS(null, "class", "marker marker-" + g), s.setAttributeNS(null, "y", b + x - S * t.data[r] + 3), s.setAttributeNS(null, "x", D(d.xAxis.categories.length, m)[r] + p + p / 4), s.setAttributeNS(null, "fill-opacity", 0), N.appendChild(s);
            var i = document.createElementNS("http://www.w3.org/2000/svg", "circle");
            i.setAttributeNS(null, "cx", D(d.xAxis.categories.length, m)[r] + p), i.setAttributeNS(null, "cy", b + x - S * t.data[r]), i.setAttribute("data-value", t.data[r]), i.setAttribute("fill", "#ffffff"), l.appendChild(i), 1 == d.tooltips && f.appendChild(l)
        }
        w = "M";
        var o = [],
            u = D(d.xAxis.categories.length, m)[D(d.xAxis.categories.length, m).length - 1] + p,
            c = x - S * t.data[t.data.length - 1],
            h = b + x;
        for (r = 0; r < n.length; r++) n[r] = p + n[r] + "," + a[r], o.push(n[r]);
        for (o.push(u + "," + c), o = o.join(" L");
            "0" === o.charAt(0);) o = o.substr(1);
        w = w + o + " L" + u + "," + h + " Z", e.setAttributeNS(null, "d", w), e.setAttributeNS(null, "fill", t.color), A.appendChild(e), 1025 < window.innerWidth && A.appendChild(f), 1 == d.tooltips && 1025 < window.innerWidth && A.appendChild(N)
    });
    var L = document.createElementNS("http://www.w3.org/2000/svg", "g"),
        B = document.createElementNS("http://www.w3.org/2000/svg", "g");
    L.setAttributeNS(null, "class", "labels x-labels"), B.setAttributeNS(null, "class", "labels y-labels");
    for (y = 0; y < d.xAxis.categories.length; y++) {
        var M = document.createElementNS("http://www.w3.org/2000/svg", "text");
        M.setAttributeNS(null, "x", D(d.xAxis.categories.length, m)[y] + p), M.setAttributeNS(null, "y", 10 + x + 20), 1 == d.labels && (M.textContent = d.xAxis.categories[y], L.appendChild(M))
    }
    for (y = 0; y < d.yAxis.labels.length; y++) {
        var X = document.createElementNS("http://www.w3.org/2000/svg", "text");
        X.setAttributeNS(null, "x", p / 2);
        var k = D(d.yAxis.labels.length, e).reverse();
        X.setAttributeNS(null, "y", k[y] + 10), 1 == d.labels && (X.textContent = d.yAxis.labels[y], B.appendChild(X))
    }

    function D(t, e) {
        for (var l = [], n = 0; n < t; n++) l.push(n * e);
        return l
    }
    A.appendChild(L), A.appendChild(B), document.body.contains(n) && (t ? n.appendChild(A) : (l.appendChild(A), n.appendChild(l))), document.body.contains(n) && (n.onmouseover = function(t) {
        var e = this.getBoundingClientRect().left;
        if (t.pageX >= e && t.pageX <= e + this.offsetWidth) {
            for (var l = document.getElementsByTagNameNS("http://www.w3.org/2000/svg", "circle"), n = [], a = 0; a < l.length; a++) {
                n.push(l[a].getAttribute("cx"));
                for (var r = 0; r < n.length; r++) n[r] >= t.pageX - e - m / 2 && n[r] <= t.pageX - e + m / 2 ? l[a].setAttributeNS(null, "r", 5) : l[a].setAttributeNS(null, "r", 0)
            }
            var s = document.getElementsByClassName("marker-" + g),
                i = [];
            for (a = 0; a < s.length; a++) {
                i.push(s[a].getAttribute("x"));
                for (r = 0; r < i.length; r++) i[r] >= t.pageX - e - m / 2 && i[r] <= t.pageX - e + m / 2 && 1 == d.tooltips ? s[a].setAttributeNS(null, "fill-opacity", 1) : s[a].setAttributeNS(null, "fill-opacity", 0)
            }
        }
    })
}, Charts.prototype.areaChart = function(t, e) {
    if (document.body.contains(document.getElementById(t))) {
        var l = function() {
            setTimeout(function() {
                document.getElementById(t).innerHTML = "", charts.generateAreaChart(t, e)
            }, 200)
        };
        l(), musa.menuToggle.addEventListener("click", l, !1), window.addEventListener("resize", function() {
            l()
        })
    }
}, Charts.prototype.generateColumnChart = function(s, i) {
    var t, a, o, e, l = document.createElement("div"),
        n = document.getElementById(s),
        r = i.barWidth,
        u = i.width,
        c = i.height,
        h = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    if (l.classList.add("chart-responsive"), document.body.contains(n)) var g = n.parentNode.offsetWidth,
        d = n.parentNode.offsetHeight; - 1 !== u.toString().indexOf("%") ? (t = !0, u = u.substring(0, u.length - 1) * g / 100) : t = !1, o = (u - 3 * (a = 6 * u / 100)) / (i.xAxis.categories.length - 1), h.setAttributeNS(null, "style", "width: " + u + "px; height: " + c + "px"), e = -1 !== c.toString().indexOf("%") ? ((c = c.substring(0, c.length - 1) * d / 100) - 20 - 10) / (i.yAxis.labels.length - 1) : (c - 20 - 10) / (i.yAxis.labels.length - 1), h.setAttributeNS(null, "style", "width: " + u + "px; height: " + c + "px");
    var p = X(i.yAxis.labels.length, e)[X(i.yAxis.labels.length, e).length - 1],
        m = X(i.xAxis.categories.length, o)[X(i.xAxis.categories.length, o).length - 1],
        w = p / i.yAxis.labels[i.yAxis.labels.length - 1];
    var b, A = (b = [], i.series.map(function(t, e) {
            b.push({
                name: t.name,
                data: t.data,
                color: t.color
            })
        }), b),
        x = document.createElementNS("http://www.w3.org/2000/svg", "g");
    x.setAttributeNS(null, "class", "markers");
    var S = document.createElementNS("http://www.w3.org/2000/svg", "g"),
        N = document.createElementNS("http://www.w3.org/2000/svg", "g");
    S.setAttributeNS(null, "class", "grid x-grid"), N.setAttributeNS(null, "class", "grid y-grid");
    for (var f = 0; f < i.xAxis.categories.length; f++) {
        var v = document.createElementNS("http://www.w3.org/2000/svg", "line");
        v.setAttributeNS(null, "x1", X(i.xAxis.categories.length, o)[f] + a), v.setAttributeNS(null, "x2", X(i.xAxis.categories.length, o)[f] + a), v.setAttributeNS(null, "y1", 10), v.setAttributeNS(null, "y2", p), S.appendChild(v)
    }
    for (f = 0; f < i.yAxis.labels.length; f++) {
        var y = document.createElementNS("http://www.w3.org/2000/svg", "line");
        y.setAttributeNS(null, "x1", a), y.setAttributeNS(null, "x2", m + a + r), y.setAttributeNS(null, "y1", 10 + X(i.yAxis.labels.length, e)[f]), y.setAttributeNS(null, "y2", 10 + X(i.yAxis.labels.length, e)[f]), N.appendChild(y)
    }
    h.appendChild(S), h.appendChild(N), A.map(function(t) {
        for (var e = 0; e < t.data.length; e++) {
            var l = document.createElementNS("http://www.w3.org/2000/svg", "text");
            l.textContent = t.name + ": " + t.data[e], l.setAttributeNS(null, "fill", "#616161"), l.setAttributeNS(null, "class", "marker marker-" + s), l.setAttributeNS(null, "y", p - w * t.data[e] + 3), l.setAttributeNS(null, "x", X(i.xAxis.categories.length, o)[e] + a), l.setAttributeNS(null, "fill-opacity", 0), x.appendChild(l);
            var n = document.createElementNS("http://www.w3.org/2000/svg", "rect");
            n.setAttributeNS(null, "x", X(t.data.length, o)[e] + a), n.setAttributeNS(null, "y", -(10 + p)), n.setAttributeNS(null, "height", w * t.data[e]), n.setAttributeNS(null, "width", r), n.setAttributeNS(null, "transform", "scale(1,-1)"), n.setAttributeNS(null, "fill", t.color), h.appendChild(n)
        }
        1 == i.tooltips && 1025 < window.innerWidth && h.appendChild(x)
    });
    var C = document.createElementNS("http://www.w3.org/2000/svg", "g"),
        E = document.createElementNS("http://www.w3.org/2000/svg", "g");
    C.setAttributeNS(null, "class", "labels x-labels"), E.setAttributeNS(null, "class", "labels y-labels");
    for (f = 0; f < i.xAxis.categories.length; f++) {
        var L = document.createElementNS("http://www.w3.org/2000/svg", "text");
        L.setAttributeNS(null, "x", X(i.xAxis.categories.length, o)[f] + r / 2 + a), L.setAttributeNS(null, "y", 10 + p + 20), 1 == i.labels && (L.textContent = i.xAxis.categories[f], C.appendChild(L))
    }
    for (f = 0; f < i.yAxis.labels.length; f++) {
        var B = document.createElementNS("http://www.w3.org/2000/svg", "text");
        B.setAttributeNS(null, "x", a / 2);
        var M = X(i.yAxis.labels.length, e).reverse();
        B.setAttributeNS(null, "y", M[f] + 10), 1 == i.labels && (B.textContent = i.yAxis.labels[f], E.appendChild(B))
    }

    function X(t, e) {
        for (var l = [], n = 0; n < t; n++) l.push(n * e);
        return l
    }
    h.appendChild(C), h.appendChild(E), document.body.contains(n) && (t ? n.appendChild(h) : (l.appendChild(h), n.appendChild(l))), document.body.contains(n) && (n.onmouseover = function(t) {
        var e = this.getBoundingClientRect().left;
        if (t.pageX >= e && t.pageX <= e + this.offsetWidth)
            for (var l = document.getElementsByClassName("marker-" + s), n = [], a = 0; a < l.length; a++) {
                n.push(l[a].getAttribute("x"));
                for (var r = 0; r < n.length; r++) n[r] >= t.pageX - e - o / 2 && n[r] <= t.pageX - e + o / 2 && 1 == i.tooltips ? l[a].setAttributeNS(null, "fill-opacity", 1) : l[a].setAttributeNS(null, "fill-opacity", 0)
            }
    })
}, Charts.prototype.columnChart = function(t, e) {
    if (document.body.contains(document.getElementById(t))) {
        var l = function() {
            setTimeout(function() {
                document.getElementById(t).innerHTML = "", charts.generateColumnChart(t, e)
            }, 300)
        };
        l(), musa.menuToggle.addEventListener("click", l, !1), window.addEventListener("resize", function() {
            l()
        })
    }
};
var charts = new Charts;
charts.init(), charts.pieChart("pieChart", {
    size: 200,
    labels: !0,
    sectors: [{
        percentage: 45,
        name: "Serie 1",
        color: "#4DD0E1"
    }, {
        percentage: 21,
        name: "Serie 2",
        color: "#6d5cae"
    }, {
        percentage: 11,
        name: "Serie 3",
        color: "#0aa89e"
    }, {
        percentage: 23,
        name: "Serie 4",
        color: "#fa0"
    }]
}), charts.pieChart("pieChart1", {
    size: 50,
    labels: !1,
    sectors: [{
        percentage: 30,
        name: "Serie 1",
        color: "#4DD0E1"
    }, {
        percentage: 70,
        name: "Serie 2",
        color: "#fa0"
    }]
}), charts.areaChart("areaChart", {
    width: "96%",
    height: 300,
    tooltips: !0,
    labels: !0,
    xAxis: {
        categories: ["2012", "2013", "2014", "2015", "2016", "2017"]
    },
    yAxis: {
        labels: ["0", "5", "10", "15", "20"]
    },
    series: [{
        name: "Serie 1",
        data: [2, 9, 10, 7.3, 5.5, 17],
        color: "#efecf1"
    }, {
        name: "Serie 2",
        data: [7.7, 6, 7.8, 4, 2, 15],
        color: "#4DD0E1"
    }]
}), charts.areaChart("areaChart1", {
    width: 80,
    height: 80,
    tooltips: !1,
    labels: !1,
    xAxis: {
        categories: ["2012", "2013", "2014", "2015", "2016", "2017"]
    },
    yAxis: {
        labels: ["0", "5", "10", "15", "20"]
    },
    series: [{
        name: "Samsung",
        data: [7.7, 6, 7.8, 4, 2, 15],
        color: "#0aa89e"
    }]
}), charts.areaChart("exampleAreaChart", {
    width: "100%",
    height: 300,
    tooltips: !0,
    labels: !0,
    xAxis: {
        categories: ["2012", "2013", "2014", "2015", "2016", "2017"]
    },
    yAxis: {
        labels: ["0", "5", "10", "15", "20"]
    },
    series: [{
        name: "Serie 1",
        data: [2, 9, 10, 7.3, 5.5, 17],
        color: "#efecf1"
    }, {
        name: "Serie 2",
        data: [7.7, 6, 7.8, 4, 2, 15],
        color: "#4DD0E1"
    }]
}), charts.columnChart("columnChart", {
    width: "90%",
    height: 300,
    barWidth: 14,
    tooltips: !0,
    labels: !0,
    xAxis: {
        categories: ["0.0", "1.0", "2.0", "3.0", "4.0", "5.0", "6.0", "7.0", "8.0", "9.0", "10.0"]
    },
    yAxis: {
        labels: ["0", "20", "40", "60", "80", "100"]
    },
    series: [{
        name: "Serie 1",
        data: [15, 18, 22, 29, 39, 37, 55, 67, 61, 50, 42],
        color: "#efecf1"
    }, {
        name: "Serie 2",
        data: [2, 6, 7.8, 4, 12, 15, 10, 7.3, 19, 17, 8.3],
        color: "#4DD0E1"
    }]
}), charts.columnChart("columnChart1", {
    width: 80,
    height: 80,
    barWidth: 7,
    tooltips: !1,
    labels: !1,
    xAxis: {
        categories: ["0.0", "1.0", "2.0", "3.0", "4.0", "5.0", "6.0", "7.0"]
    },
    yAxis: {
        labels: ["0", "20", "40", "60"]
    },
    series: [{
        name: "Apple",
        data: [5, 18, 20, 28, 35, 40, 15, 7],
        color: "#6d5cae"
    }]
});