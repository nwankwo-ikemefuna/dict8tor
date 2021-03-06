"use strict";
var Musa = function() {
    this.body = document.querySelector("body"), this.menuToggle = document.getElementById("menu-toggle"), this.sidebar = document.querySelector(".sidebar"), this.sidebarMenuToggle = document.getElementById("sidebar-menu-toggle"), this.allSidemenuLinks = document.querySelectorAll("#sidebar-menu .menu-section .nav-item a"), this.allHasChildSidemenuLinks = document.querySelectorAll("#sidebar-menu .menu-section .has-child a"), this.btnOpenChat = document.getElementById("btnOpenChat"), this.btnOpenChatBox = document.getElementById("btnOpenChatBox"), this.chatBoxWrapper = document.getElementById("chatBoxWrapper"), this.chatSidebar = document.getElementById("chatSidebar"), this.chatOverlay = document.getElementById("chatOverlay"), this.countDownBox = document.getElementById("countDownBox"), this.btnPrint = document.getElementById("btnPrint"), this.invoice = document.getElementById("invoice"), this.wizardProgress = document.getElementById("wizard-progress"), this.stepContent = document.querySelectorAll("[data-opened-step]"), this.wizardSubmit = document.getElementById("ButtonFinish"), this.wizardNextButton = document.getElementById("ButtonNext"), this.handleWizardPreviousButton = document.getElementById("ButtonPrevious"), this.wizardTab1 = document.querySelector('[data-tab="Step1"]'), this.wizardTab2 = document.querySelector('[data-tab="Step2"]'), this.wizardTab3 = document.querySelector('[data-tab="Step3"]'), this.wizardTab4 = document.querySelector('[data-tab="Step4"]'), this.tableCollapsibleRow = document.getElementsByClassName("row-collapsible")
};
Musa.prototype.init = function() {
    this.events(), this.getClosest(), this.responsiveSidebarMenu(), this.rippleEffect(), this.materialFormFieldFilledState(), this.collapseTable(), this.wizardNavigation(), this.countDown()
}, Musa.prototype.events = function() {
    musa.body.contains(this.menuToggle) && this.menuToggle.addEventListener("click", musa.toggleMenu, !1), musa.body.contains(this.sidebarMenuToggle) && this.sidebarMenuToggle.addEventListener("click", musa.toggleMenu, !1), musa.body.contains(this.btnPrint) && (this.btnPrint.onclick = function() {
        musa.printInvoice()
    });
    for (var t = 0; t < musa.allHasChildSidemenuLinks.length; t++) musa.allHasChildSidemenuLinks[t].addEventListener("click", this.openSidebarSubMenu, !1);
    musa.body.contains(document.getElementById("ButtonPrevious")) && musa.handleWizardPreviousButton.addEventListener("click", musa.handleWizardPrevious, !1), musa.body.contains(musa.wizardNextButton) && musa.wizardNextButton.addEventListener("click", musa.handleWizardNext, !1), musa.body.contains(this.btnOpenChat) && this.btnOpenChat.addEventListener("click", musa.openChat, !1), musa.body.contains(this.chatOverlay) && this.chatOverlay.addEventListener("click", musa.closeChat, !1), musa.body.contains(this.chatOverlay) && this.chatOverlay.addEventListener("click", musa.closeChat, !1), musa.body.contains(this.btnOpenChatBox) && this.btnOpenChatBox.addEventListener("click", musa.openChatBox, !1)
}, Musa.prototype.materialFormFieldFilledState = function() {
    for (var t = document.querySelectorAll(".material-form .form-control"), e = 0; e < t.length; e++) t[e].onchange = function() {
        this.classList.add("filled"), "" === this.value && this.classList.remove("filled")
    }
}, Musa.prototype.wizardNavigation = function() {
    musa.body.contains(musa.wizardTab1) && (musa.wizardTab1.onclick = function() {
        document.querySelector(".wizard-navigation .nav-item.active").classList.remove("active"), musa.wizardTab4.classList.remove("done"), musa.wizardTab2.classList.remove("done"), musa.wizardTab3.classList.remove("done"), this.classList.add("active"), musa.hideWizardSubmitButton();
        for (var t = 0; t < musa.stepContent.length; t++) musa.stepContent[t].setAttribute("data-opened-step", "false");
        document.getElementById("Step1").setAttribute("data-opened-step", "true"), musa.wizardProgressBarNullWidth(), musa.wizardNextButton.setAttribute("data-next-step", "Step2"), musa.handleWizardPreviousButton.setAttribute("data-prev-step", "")
    }), musa.body.contains(musa.wizardTab2) && (musa.wizardTab2.onclick = function() {
        document.querySelector(".wizard-navigation .nav-item.active").classList.remove("active"), musa.wizardTab3.classList.remove("done"), musa.wizardTab4.classList.remove("done"), musa.wizardTab1.classList.add("done"), this.classList.add("active"), musa.hideWizardSubmitButton();
        for (var t = 0; t < musa.stepContent.length; t++) musa.stepContent[t].setAttribute("data-opened-step", "false");
        document.getElementById("Step2").setAttribute("data-opened-step", "true"), musa.wizardProgressBarOneThirdWidth(), musa.wizardNextButton.setAttribute("data-next-step", "Step3"), musa.handleWizardPreviousButton.setAttribute("data-prev-step", "Step1")
    }), musa.body.contains(musa.wizardTab3) && (musa.wizardTab3.onclick = function() {
        document.querySelector(".wizard-navigation .nav-item.active").classList.remove("active"), musa.wizardTab4.classList.remove("done"), musa.wizardTab1.classList.add("done"), musa.wizardTab2.classList.add("done"), this.classList.add("active"), musa.hideWizardSubmitButton();
        for (var t = 0; t < musa.stepContent.length; t++) musa.stepContent[t].setAttribute("data-opened-step", "false");
        document.getElementById("Step3").setAttribute("data-opened-step", "true"), musa.wizardProgressBarTwoThirdsWidth(), musa.wizardNextButton.setAttribute("data-next-step", "Step4"), musa.handleWizardPreviousButton.setAttribute("data-prev-step", "Step2")
    }), musa.body.contains(musa.wizardTab4) && (musa.wizardTab4.onclick = function() {
        document.querySelector(".wizard-navigation .nav-item.active").classList.remove("active"), musa.wizardTab1.classList.add("done"), musa.wizardTab2.classList.add("done"), musa.wizardTab3.classList.add("done"), this.classList.add("active");
        for (var t = 0; t < musa.stepContent.length; t++) musa.stepContent[t].setAttribute("data-opened-step", "false");
        document.getElementById("Step4").setAttribute("data-opened-step", "true"), musa.showWizardSubmitButton(), musa.wizardProgressBarFullWidth(), musa.wizardNextButton.setAttribute("data-next-step", ""), musa.handleWizardPreviousButton.setAttribute("data-prev-step", "Step3")
    })
}, Musa.prototype.handleWizardNext = function() {
    for (var t, e = musa.wizardNextButton.getAttribute("data-next-step"), s = 0; s < musa.stepContent.length; s++) musa.stepContent[s].setAttribute("data-opened-step", "false");
    document.getElementById(e).setAttribute("data-opened-step", "true"), "Step2" === e ? (musa.wizardNextButton.setAttribute("data-next-step", "Step3"), musa.handleWizardPreviousButton.setAttribute("data-prev-step", "Step1"), (t = musa.wizardTab2).classList.add("active"), t.previousElementSibling.classList.remove("active"), t.previousElementSibling.classList.add("done"), musa.wizardProgressBarOneThirdWidth()) : "Step3" === e ? (musa.wizardNextButton.setAttribute("data-next-step", "Step4"), musa.handleWizardPreviousButton.setAttribute("data-prev-step", "Step2"), (t = musa.wizardTab3).classList.add("active"), t.previousElementSibling.classList.remove("active"), t.previousElementSibling.classList.add("done"), musa.wizardProgressBarTwoThirdsWidth()) : "Step4" === e && (musa.wizardNextButton.setAttribute("data-next-step", ""), musa.handleWizardPreviousButton.setAttribute("data-prev-step", "Step3"), musa.showWizardSubmitButton(), (t = musa.wizardTab4).classList.add("active"), t.previousElementSibling.classList.remove("active"), t.previousElementSibling.classList.add("done"), musa.wizardProgressBarFullWidth())
}, Musa.prototype.handleWizardPrevious = function() {
    for (var t, e = musa.handleWizardPreviousButton.getAttribute("data-prev-step"), s = 0; s < musa.stepContent.length; s++) musa.stepContent[s].setAttribute("data-opened-step", "false");
    document.getElementById(e).setAttribute("data-opened-step", "true"), "Step1" === e ? (musa.wizardNextButton.setAttribute("data-next-step", "Step2"), musa.handleWizardPreviousButton.setAttribute("data-prev-step", ""), (t = musa.wizardTab1).classList.add("active"), t.nextElementSibling.classList.remove("active"), t.nextElementSibling.classList.remove("done"), musa.wizardProgressBarNullWidth()) : "Step2" === e ? (musa.wizardNextButton.setAttribute("data-next-step", "Step3"), musa.handleWizardPreviousButton.setAttribute("data-prev-step", "Step1"), (t = musa.wizardTab2).classList.add("active"), t.nextElementSibling.classList.remove("active"), t.nextElementSibling.classList.remove("done"), musa.wizardProgressBarOneThirdWidth()) : "Step3" === e && (musa.wizardNextButton.setAttribute("data-next-step", "Step4"), musa.handleWizardPreviousButton.setAttribute("data-prev-step", "Step2"), musa.hideWizardSubmitButton(), (t = musa.wizardTab3).classList.add("active"), t.nextElementSibling.classList.remove("active"), t.nextElementSibling.classList.remove("done"), musa.wizardProgressBarTwoThirdsWidth())
}, Musa.prototype.showWizardSubmitButton = function() {
    musa.wizardSubmit.classList.add("show")
}, Musa.prototype.hideWizardSubmitButton = function() {
    musa.wizardSubmit.classList.contains("show") && musa.wizardSubmit.classList.remove("show")
}, Musa.prototype.wizardProgressBarNullWidth = function() {
    musa.wizardProgress.style.width = 0
}, Musa.prototype.wizardProgressBarOneThirdWidth = function() {
    musa.wizardProgress.style.width = "33.33%"
}, Musa.prototype.wizardProgressBarTwoThirdsWidth = function() {
    musa.wizardProgress.style.width = "66.66%"
}, Musa.prototype.wizardProgressBarFullWidth = function() {
    musa.wizardProgress.style.width = "100%"
}, Musa.prototype.openSidebarSubMenu = function() {
    for (var t = document.querySelectorAll("#sidebar-menu .menu-section .side-menu li.has-child.opened"), e = 0; e < t.length; e++) null === t[e] || s(this.parentNode, t[e]) || t[e].classList.remove("opened");

    function s(t, e) {
        for (; null != t && "BODY" !== t.tagName.toUpperCase();) {
            if (t === e) return !0;
            t = t.parentNode
        }
        return !1
    }
    this.parentNode.classList.contains("opened") ? this.parentNode.classList.remove("opened") : this.parentNode.classList.add("opened")
}, Musa.prototype.toggleMenu = function() {
    if (musa.body.classList.contains("nav-sm")) {
        var t = document.querySelector("#sidebar-menu .menu-section .side-menu li.has-child.active");
        t && t.classList.add("opened")
    }
    if (musa.body.classList.contains("nav-md")) {
        var e = document.querySelector("#sidebar-menu .menu-section .side-menu li.has-child.opened");
        e && e.classList.remove("opened")
    }
    musa.body.classList.toggle("nav-sm"), musa.body.classList.toggle("nav-md"), window.addEventListener("resize", function() {
        var t = window.innerWidth,
            e = document.documentElement.clientHeight;
        t < 576 && musa.body.classList.contains("nav-md") && (musa.sidebar.style.height = e + "px", musa.body.classList.contains("fixed-body") ? musa.body.classList.remove("fixed-body") : musa.body.classList.add("fixed-body"))
    });
    var s = window.innerWidth,
        a = document.documentElement.clientHeight;
    s < 576 && (musa.sidebar.style.height = a + "px", musa.body.classList.contains("fixed-body") ? musa.body.classList.remove("fixed-body") : musa.body.classList.add("fixed-body"))
}, Musa.prototype.responsiveSidebarMenu = function() {
    window.addEventListener("resize", function() {
        window.innerWidth < 768 && musa.body.classList.contains("nav-md") && (document.body.classList.remove("nav-md"), document.body.classList.add("nav-sm"))
    }), window.innerWidth < 768 && musa.body.classList.contains("nav-md") && (document.body.classList.remove("nav-md"), document.body.classList.add("nav-sm"))
}, Musa.prototype.collapseTable = function() {
    for (var t = 0; t < musa.tableCollapsibleRow.length; t++) musa.tableCollapsibleRow[t].onclick = function() {
        var t = document.querySelectorAll(".row-collapsible.shown");
        this.classList.contains("shown") ? this.classList.remove("shown") : this.classList.contains("shown") || (null != t[0] && t[0].classList.remove("shown"), this.classList.add("shown"))
    }
}, Musa.prototype.rippleEffect = function() {
    for (var t = document.querySelectorAll(".ripple"), e = function(t) {
            if (0 === this.querySelectorAll(".ripple-effect").length) {
                var e = document.createElement("span");
                e.classList.add("ripple-effect"), this.appendChild(e), setTimeout(function() {
                    e.parentNode.removeChild(e)
                }, 2e3)
            }
            var s = this.querySelectorAll(".ripple-effect")[0];
            if (s.classList.remove("animate"), !s.offsetHeight && !s.offsetWidth) {
                var a = Math.max(this.offsetHeight, this.offsetWidth);
                s.style.height = a + "px", s.style.width = a + "px"
            }
            var i = this.getBoundingClientRect(),
                n = i.top + window.pageYOffset,
                o = i.left + window.pageXOffset,
                r = t.pageX - o - s.offsetWidth / 2,
                d = t.pageY - n - s.offsetHeight / 2;
            s.style.top = d + "px", s.style.left = r + "px", s.classList.add("animate")
        }, s = 0; s < t.length; s++) t[s].addEventListener("click", e, !1)
}, Musa.prototype.getParents = function(t, e) {
    void 0 === e && (e = document);
    for (var s = [], a = t.parentNode; a !== e;) {
        var i = a;
        s.push(i), a = i.parentNode
    }
    return s.push(e), s
}, Musa.prototype.getClosest = function(t, e) {
    for (Element.prototype.matches || (Element.prototype.matches = Element.prototype.matchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector || Element.prototype.oMatchesSelector || Element.prototype.webkitMatchesSelector || function(t) {
            for (var e = (this.document || this.ownerDocument).querySelectorAll(t), s = e.length; 0 <= --s && e.item(s) !== this;);
            return -1 < s
        }); t && t !== document; t = t.parentNode)
        if (t.matches(e)) return t;
    return null
}, Musa.prototype.printInvoice = function() {
    window.print()
}, Musa.prototype.openChat = function() {
    musa.chatSidebar.classList.toggle("opened"), musa.chatOverlay.classList.toggle("show"), musa.body.classList.toggle("overflow-hidden")
}, Musa.prototype.closeChat = function() {
    musa.chatSidebar.classList.remove("opened"), musa.chatOverlay.classList.remove("show"), musa.body.classList.remove("overflow-hidden")
}, Musa.prototype.openChatBox = function() {
    musa.body.classList.toggle("chat-box-opened"), musa.chatBoxWrapper.classList.toggle("opened")
}, Musa.prototype.countDown = function() {
    if (musa.body.contains(this.countDownBox)) var o = new Date("Jan 21, 2020 18:11:25").getTime(),
        r = setInterval(function() {
            var t = (new Date).getTime(),
                e = o - t,
                s = Math.floor(e / 864e5),
                a = Math.floor(e % 864e5 / 36e5),
                i = Math.floor(e % 36e5 / 6e4),
                n = Math.floor(e % 6e4 / 1e3);
            document.getElementById("days").innerHTML = s, document.getElementById("hours").innerHTML = a, document.getElementById("minutes").innerHTML = i, document.getElementById("seconds").innerHTML = n, e < 0 && (clearInterval(r), this.countDownBox.innerHTML = "EXPIRED")
        }, 1e3)
};
var musa = new Musa;
musa.init();
var Slider = function() {
    this.body = document.querySelector("body")
};
Slider.prototype.init = function() {
    this.slider()
}, Slider.prototype.slider = function() {
    var t = document.head || document.getElementsByTagName("head")[0],
        o = document.createElement("style");
    o.type = "text/css";
    var e = document.querySelectorAll('input[data-attr="range-input"]'),
        s = function() {
            var t = this.getAttribute("data-color"),
                e = this.className,
                s = (this.value - this.getAttribute("min")) / (this.getAttribute("max") - this.getAttribute("min")),
                a = this.parentNode.querySelector('label[data-label="' + e + '-label"]');
            a.innerHTML = this.value;
            var i = musa.getClosest(this, ".slider");
            if (i.classList.contains("horizontal-slider") && (a.style.left = "calc( +" + 100 * s + "% - 12px"), i.classList.contains("horizontal-slider-labeled-bottom") && (a.style.top = "50px"), i.classList.contains("vertical-slider") && (a.style.bottom = 100 * s + 38 + "px"), i.classList.contains("vertical-slider-labeled-right") && (a.style.marginLeft = "78px"), i.classList.contains("rectangular-slider") && (a.style.bottom = 100 * s + 38 + "px"), this.style.height = "2px", null === localStorage.getItem("customizedColors")) {
                var n = slider.sliderColor.call(this, s, t, i, a);
                o.styleSheet ? o.styleSheet.cssText += n : o.appendChild(document.createTextNode(n))
            }
        },
        a = function() {
            var t = this.getAttribute("data-color"),
                e = this.className,
                s = (this.value - this.getAttribute("min")) / (this.getAttribute("max") - this.getAttribute("min")),
                a = this.parentNode.querySelector('label[data-label="' + e + '-label"]');
            a.innerHTML = this.value;
            var i = musa.getClosest(this, ".slider");
            null === localStorage.getItem("customizedColors") && (i.classList.contains("horizontal-slider") && (a.style.left = "calc( +" + 100 * s + "% - 12px)", a.style.borderColor = t), i.classList.contains("horizontal-slider-labeled-bottom") && (a.style.top = "70px"), i.classList.contains("rounded-slider") && (a.style.color = t, a.style.borderColor = t), i.classList.contains("vertical-slider") && (a.style.bottom = 100 * s + 20 + "px", a.style.borderColor = t), i.classList.contains("vertical-slider-labeled-right") && (a.style.marginLeft = "64px"), i.classList.contains("rectangular-slider") && (a.style.bottom = 100 * s + 20 + "px", a.style.backgroundColor = t))
        };
    t.appendChild(o);
    for (var i = 0; i < e.length; i++) {
        if (!!document.documentMode) {
            e[i].addEventListener("change", a, !1);
            var n = document.createEvent("HTMLEvents");
            n.initEvent("change", !0, !1), e[i].dispatchEvent(n)
        } else {
            e[i].addEventListener("input", s, !1);
            var r = new Event("input");
            e[i].dispatchEvent(r)
        }
    }
}, Slider.prototype.sliderColor = function(t, e, s, a) {
    return this.style.background = "-webkit-gradient(linear, left top, right top, color-stop(" + t + ", " + e + "), color-stop(" + t + ", #ddd))", s.classList.contains("horizontal-slider") && (a.style.borderColor = e), s.classList.contains("rounded-slider") && (a.style.color = e, a.style.borderColor = e), s.classList.contains("vertical-slider") && (a.style.borderColor = e), s.classList.contains("rectangular-slider") && (a.style.backgroundColor = e), "input#" + this.getAttribute("id") + "." + this.className + "::-moz-range-track { background: -webkit-gradient(linear, left top, right top, color-stop(" + t + ", " + e + "), color-stop(" + t + ", #ddd)); height: 2px;}"
};
var slider = new Slider;
slider.init();