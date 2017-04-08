/*
 SignaturePad: A jQuery plugin for assisting in the creation of an HTML5 canvas
 based signature pad. Records the drawn signature in JSON for later regeneration.

 Dependencies: FlashCanvas/1.5, json2, jquery/1.3.2+

 @project ca.thomasjbradley.applications.signaturepad
 @author Thomas J Bradley <hey@thomasjbradley.ca>
 @link http://thomasjbradley.ca/lab/signature-pad
 @link http://github.com/thomasjbradley/signature-pad
 @copyright Copyright MMXI, Thomas J Bradley
 @license New BSD License
 @version 2.1.1
*/
(function (c) {
    function C(n, q) {
        function s(a, e) {
            var f = c(a.target).offset(),
                g;
            clearTimeout(o);
            o = false;
            if (typeof a.changedTouches !== "undefined") {
                g = Math.floor(a.changedTouches[0].pageX - f.left);
                f = Math.floor(a.changedTouches[0].pageY - f.top)
            } else {
                g = Math.floor(a.pageX - f.left);
                f = Math.floor(a.pageY - f.top)
            }
            if (j.x === g && j.y === f) return true;
            if (j.x === null) j.x = g;
            if (j.y === null) j.y = f;
            if (e) f += e;
            h.beginPath();
            h.moveTo(j.x, j.y);
            h.lineTo(g, f);
            h.lineCap = b.penCap;
            h.stroke();
            h.closePath();
            l.push({
                lx: g,
                ly: f,
                mx: j.x,
                my: j.y
            });
            j.x = g;
            j.y = f
        }
        function m() {
            r ? i.each(function () {
                this.ontouchmove = null
            }) : i.unbind("mousemove.signaturepad");
            j.x = null;
            j.y = null;
            l.length > 0 && c(b.output, d).val(JSON.stringify(l))
	        if (b.onPenUp && typeof b.onPenUp === "function") {
	        	b.onPenUp();
	        }
	    }
        function t() {
            m();
            h.fillStyle = b.bgColour;
            h.fillRect(0, 0, k.width, k.height);
            if (!b.displayOnly) if (b.lineWidth) {
                h.beginPath();
                h.lineWidth = b.lineWidth;
                h.strokeStyle = b.lineColour;
                h.moveTo(b.lineMargin, b.lineTop);
                h.lineTo(k.width - b.lineMargin, b.lineTop);
                h.stroke();
                h.closePath()
            }
            h.lineWidth = b.penWidth;
            h.strokeStyle = b.penColour;
            c(b.output, d).val("");
            l = []
        }
        function w(a) {
            r ? i.each(function () {
                this.addEventListener("touchmove", s, false)
            }) : i.bind("mousemove.signaturepad", s);
            s(a, 1)
        }
        function D() {
            u = false;
            if (r) i.each(function () {
                this.removeEventListener("touchstart", m);
                this.removeEventListener("touchend", m);
                this.removeEventListener("touchmove", s)
            });
            else {
                i.unbind("mousedown.signaturepad");
                i.unbind("mouseup.signaturepad");
                i.unbind("mousemove.signaturepad");
                i.unbind("mouseleave.signaturepad")
            }
            c(b.clear, d).unbind("click.signaturepad")
        }
        function x(a) {
            if (u) return false;
            u = true;
            if (typeof a.changedTouches !== "undefined") r = true;
            if (r) {
                i.each(function () {
                    this.addEventListener("touchend", m, false);
                    this.addEventListener("touchcancel", m, false)
                });
                i.unbind("mousedown.signaturepad")
            } else {
                i.bind("mouseup.signaturepad", function () {
                    m()
                });
                i.bind("mouseleave.signaturepad", function () {
                    o || (o = setTimeout(function () {
                        m();
                        clearTimeout(o);
                        o = false
                    }, 500))
                });
                i.each(function () {
                    this.ontouchstart = null
                })
            }
        }
        function v() {
            c(b.typed, d).hide();
            t();
            i.each(function () {
                this.ontouchstart = function (a) {
                    a.preventDefault();
                    x(a);
                    w(a, this)
                }
            });
            i.bind("mousedown.signaturepad", function (a) {
                x(a);
                w(a, this)
            });
            c(b.clear, d).bind("click.signaturepad", function (a) {
                a.preventDefault();
                t()
            });
            c(b.typeIt, d).bind("click.signaturepad", function (a) {
                a.preventDefault();
                y()
            });
            c(b.drawIt, d).unbind("click.signaturepad");
            c(b.drawIt, d).bind("click.signaturepad", function (a) {
                a.preventDefault()
            });
            c(b.typeIt, d).removeClass(b.currentClass);
            c(b.drawIt, d).addClass(b.currentClass);
            c(b.sig, d).addClass(b.currentClass);
            c(b.typeItDesc, d).hide();
            c(b.drawItDesc, d).show();
            c(b.clear, d).show()
        }
        function y() {
            t();
            D();
            c(b.typed, d).show();
            c(b.drawIt, d).bind("click.signaturepad", function (a) {
                a.preventDefault();
                v()
            });
            c(b.typeIt, d).unbind("click.signaturepad");
            c(b.typeIt, d).bind("click.signaturepad", function (a) {
                a.preventDefault()
            });
            c(b.output, d).val("");
            c(b.drawIt, d).removeClass(b.currentClass);
            c(b.typeIt, d).addClass(b.currentClass);
            c(b.sig, d).removeClass(b.currentClass);
            c(b.drawItDesc, d).hide();
            c(b.clear, d).hide();
            c(b.typeItDesc, d).show()
        }
        function z(a) {
            for (c(b.typed, d).html(a.replace(/>/g, "&gt;").replace(/</g, "&lt;")); c(b.typed, d).width() > k.width;) {
                a = c(b.typed, d).css("font-size").replace(/px/, "");
                c(b.typed, d).css("font-size", a - 1 + "px")
            }
        }
        function E(a, e) {
            c("p." + e.errorClass, a).remove();
            a.removeClass(e.errorClass);
            c("input, label", a).removeClass(e.errorClass)
        }
        function F(a, e, f) {
            if (a.nameInvalid) {
                e.prepend(['<p class="', f.errorClass, '">', f.errorMessage, "</p>"].join(""));
                c(f.name, e).focus();
                c(f.name, e).addClass(f.errorClass);
                c("label[for=" + c(f.name).attr("id") + "]", e).addClass(f.errorClass)
            }
            a.drawInvalid && e.prepend(['<p class="', f.errorClass, '">', f.errorMessageDraw, "</p>"].join(""))
        }
        function A() {
            var a = true,
                e = {
                    drawInvalid: false,
                    nameInvalid: false
                },
                f = [d, b],
                g = [e, d, b];
            b.onBeforeValidate && typeof b.onBeforeValidate === "function" ? b.onBeforeValidate.apply(p, f) : E.apply(p, f);
            if (b.drawOnly && l.length < 1) {
                e.drawInvalid = true;
                a = false
            }
            if (c(b.name, d).val() === "") {
                e.nameInvalid = true;
                a = false
            }
            b.onFormError && typeof b.onFormError === "function" ? b.onFormError.apply(p, g) : F.apply(p, g);
            return a
        }

        function B(a, e, f) {
            for (var g in a) if (typeof a[g] === "object") {
                e.beginPath();
                e.moveTo(a[g].mx, a[g].my);
                e.lineTo(a[g].lx, a[g].ly);
                e.lineCap = b.penCap;
                e.stroke();
                e.closePath();
                f && l.push({
                    lx: a[g].lx,
                    ly: a[g].ly,
                    mx: a[g].mx,
                    my: a[g].my
                })
            }
        }
        function G() {
            if (parseFloat((/CPU.+OS ([0-9_]{3}).*AppleWebkit.*Mobile/i.exec(navigator.userAgent) || [0, "4_2"])[1].replace("_", ".")) < 4.1) {
                c.fn.Oldoffset = c.fn.offset;
                c.fn.offset = function () {
                    var a = c(this).Oldoffset();
                    a.top -= window.scrollY;
                    a.left -= window.scrollX;
                    return a
                }
            }
            c(b.typed, d).bind("selectstart.signaturepad", function (a) {
                return c(a.target).is(":input")
            });
            i.bind("selectstart.signaturepad", function (a) {
                return c(a.target).is(":input")
            });
            !k.getContext && FlashCanvas && FlashCanvas.initElement(k);
            if (k.getContext) {
                h = k.getContext("2d");
                c(b.sig, d).show();
                if (!b.displayOnly) {
                    if (!b.drawOnly) {
                        c(b.name, d).bind("keyup.signaturepad", function () {
                            z(c(this).val())
                        });
                        c(b.name, d).bind("blur.signaturepad", function () {
                            z(c(this).val())
                        });
                        c(b.drawIt, d).bind("click.signaturepad", function (a) {
                            a.preventDefault();
                            v()
                        })
                    }
                    b.drawOnly || b.defaultAction === "drawIt" ? v() : y();
                    if (b.validateFields) c(n).is("form") ? c(n).bind("submit.signaturepad", function () {
                        return A()
                    }) : c(n).parents("form").bind("submit.signaturepad", function () {
                        return A()
                    });
                    c(b.sigNav, d).show()
                }
            }
        }
        var p = this,
            b = c.extend({}, c.fn.signaturePad.defaults, q),
            d = c(n),
            i = c(b.canvas, d),
            k = i.get(0),
            h = null,
            j = {
                x: null,
                y: null
            },
            l = [],
            o = false,
            r = false,
            u = false;
        c.extend(p, {
            init: function () {
                G()
            },
            regenerate: function (a) {
                p.clearCanvas();
                c(b.typed, d).hide();
                if (typeof a === "string") a = JSON.parse(a);
                B(a, h, true);
                c(b.output, d).length > 0 && c(b.output, d).val(JSON.stringify(l))
            },
            clearCanvas: function () {
                t()
            },
            getSignature: function () {
                return l
            },
            getSignatureString: function () {
                return JSON.stringify(l)
            },
            getSignatureImage: function () {
                var a = document.createElement("canvas"),
                    e = null;
                e = null;
                a.style.position = "absolute";
                a.style.top = "-999em";
                a.width = k.width;
                a.height = k.height;
                document.body.appendChild(a);
                !a.getContext && FlashCanvas && FlashCanvas.initElement(a);
                e = a.getContext("2d");
                e.fillStyle = b.bgColour;
                e.fillRect(0, 0, k.width, k.height);
                e.lineWidth = b.penWidth;
                e.strokeStyle = b.penColour;
                B(l, e);
                e = a.toDataURL.apply(a, arguments);
                document.body.removeChild(a);
                return e
            }
        })
    }
    c.fn.signaturePad = function (n) {
        var q = null;
        this.each(function () {
            q = new C(this, n);
            q.init()
        });
        return q
    };
    c.fn.signaturePad.defaults = {
        defaultAction: "typeIt",
        displayOnly: false,
        drawOnly: false,
        canvas: "canvas",
        sig: ".sig",
        sigNav: ".sigNav",
        bgColour: "#ffffff",
        penColour: "#145394",
        penWidth: 2,
        penCap: "round",
        lineColour: "#ccc",
        lineWidth: 2,
        lineMargin: 5,
        lineTop: 35,
        name: ".name",
        typed: ".typed",
        clear: ".clearButton",
        typeIt: ".typeIt a",
        drawIt: ".drawIt a",
        typeItDesc: ".typeItDesc",
        drawItDesc: ".drawItDesc",
        output: ".output",
        currentClass: "current",
        validateFields: true,
        errorClass: "error",
        errorMessage: "Please enter your name",
        errorMessageDraw: "Please sign the document",
        onPenUp: null,
        onBeforeValidate: null,
        onFormError: null
    }
})(jQuery);