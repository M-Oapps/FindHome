(function (root, factory) {
  if (typeof define === "function" && define.amd) {
    define(["jquery"], factory);
  } else if (typeof exports === "object") {
    module.exports = factory(require("jquery"));
  } else {
    root.jquery_mmenu_js = factory(root.jQuery);
  }
})(this, function (jQuery) {
  /*!
   * jQuery mmenu v7.3.2
   * @requires jQuery 1.7.0 or later
   *
   * mmenujs.com
   *
   * Copyright (c) Fred Heusschen
   * www.frebsite.nl
   *
   * License: CC-BY-NC-4.0
   * http://creativecommons.org/licenses/by-nc/4.0/
   */
  !(function (t) {
    var e,
      n,
      i,
      s,
      a,
      r = "mmenu";
    (t[r] && t[r].version > "7.3.2") ||
      ((t[r] = function (t, e, n) {
        return (
          (this.$menu = t),
          (this._api = [
            "bind",
            "getInstance",
            "initPanels",
            "openPanel",
            "closePanel",
            "closeAllPanels",
            "setSelected",
          ]),
          (this.opts = e),
          (this.conf = n),
          (this.vars = {}),
          (this.cbck = {}),
          (this.mtch = {}),
          "function" == typeof this.___deprecated && this.___deprecated(),
          this._initWrappers(),
          this._initAddons(),
          this._initExtensions(),
          this._initHooks(),
          this._initMenu(),
          this._initPanels(),
          this._initOpened(),
          this._initAnchors(),
          this._initMatchMedia(),
          "function" == typeof this.___debug && this.___debug(),
          this
        );
      }),
      (t[r].version = "7.3.2"),
      (t[r].uniqueId = 0),
      (t[r].wrappers = {}),
      (t[r].addons = {}),
      (t[r].defaults = {
        hooks: {},
        extensions: [],
        wrappers: [],
        navbar: {
          add: !0,
          title: "Menu",
          titleLink: "parent",
        },
        onClick: {
          setSelected: !0,
        },
        slidingSubmenus: !0,
      }),
      (t[r].configuration = {
        classNames: {
          divider: "Divider",
          inset: "Inset",
          nolistview: "NoListview",
          nopanel: "NoPanel",
          panel: "Panel",
          selected: "Selected",
          spacer: "Spacer",
          vertical: "Vertical",
        },
        clone: !1,
        language: null,
        openingInterval: 25,
        panelNodetype: "ul, ol, div",
        transitionDuration: 400,
      }),
      (t[r].prototype = {
        getInstance: function () {
          return this;
        },
        initPanels: function (t) {
          this._initPanels(t);
        },
        openPanel: function (e, s) {
          if (
            (this.trigger("openPanel:before", e),
            e &&
              e.length &&
              (e.is("." + n.panel) || (e = e.closest("." + n.panel)),
              e.is("." + n.panel)))
          ) {
            var a = this;
            if (
              ("boolean" != typeof s && (s = !0),
              e.parent("." + n.listitem + "_vertical").length)
            )
              e
                .parents("." + n.listitem + "_vertical")
                .addClass(n.listitem + "_opened")
                .children("." + n.panel)
                .removeClass(n.hidden),
                this.openPanel(
                  e
                    .parents("." + n.panel)
                    .not(function () {
                      return t(this).parent(
                        "." + n.listitem + "_vertical"
                      ).length;
                    })
                    .first()
                ),
                this.trigger("openPanel:start", e),
                this.trigger("openPanel:finish", e);
            else {
              if (e.hasClass(n.panel + "_opened")) return;
              var l = this.$pnls.children("." + n.panel),
                o = this.$pnls.children("." + n.panel + "_opened");
              if (!t[r].support.csstransitions)
                return (
                  o.addClass(n.hidden).removeClass(n.panel + "_opened"),
                  e.removeClass(n.hidden).addClass(n.panel + "_opened"),
                  this.trigger("openPanel:start", e),
                  void this.trigger("openPanel:finish", e)
                );
              l.not(e).removeClass(n.panel + "_opened-parent");
              for (var d = e.data(i.parent); d; )
                (d = d.closest("." + n.panel)).parent(
                  "." + n.listitem + "_vertical"
                ).length || d.addClass(n.panel + "_opened-parent"),
                  (d = d.data(i.parent));
              l
                .removeClass(n.panel + "_highest")
                .not(o)
                .not(e)
                .addClass(n.hidden),
                e.removeClass(n.hidden);
              var c = function () {
                  o.removeClass(n.panel + "_opened"),
                    e.addClass(n.panel + "_opened"),
                    e.hasClass(n.panel + "_opened-parent")
                      ? (o.addClass(n.panel + "_highest"),
                        e.removeClass(n.panel + "_opened-parent"))
                      : (o.addClass(n.panel + "_opened-parent"),
                        e.addClass(n.panel + "_highest")),
                    a.trigger("openPanel:start", e);
                },
                h = function () {
                  o.removeClass(n.panel + "_highest").addClass(n.hidden),
                    e.removeClass(n.panel + "_highest"),
                    a.trigger("openPanel:finish", e);
                };
              s && !e.hasClass(n.panel + "_noanimation")
                ? setTimeout(function () {
                    a.__transitionend(
                      e,
                      function () {
                        h();
                      },
                      a.conf.transitionDuration
                    ),
                      c();
                  }, a.conf.openingInterval)
                : (c(), h());
            }
            this.trigger("openPanel:after", e);
          }
        },
        closePanel: function (t) {
          this.trigger("closePanel:before", t);
          var e = t.parent();
          e.hasClass(n.listitem + "_vertical") &&
            (e.removeClass(n.listitem + "_opened"),
            t.addClass(n.hidden),
            this.trigger("closePanel", t)),
            this.trigger("closePanel:after", t);
        },
        closeAllPanels: function (t) {
          this.trigger("closeAllPanels:before"),
            this.$pnls
              .find("." + n.listview)
              .children()
              .removeClass(n.listitem + "_selected")
              .filter("." + n.listitem + "_vertical")
              .removeClass(n.listitem + "_opened");
          var e = this.$pnls.children("." + n.panel),
            i = t && t.length ? t : e.first();
          this.$pnls
            .children("." + n.panel)
            .not(i)
            .removeClass(n.panel + "_opened")
            .removeClass(n.panel + "_opened-parent")
            .removeClass(n.panel + "_highest")
            .addClass(n.hidden),
            this.openPanel(i, !1),
            this.trigger("closeAllPanels:after");
        },
        togglePanel: function (t) {
          var e = t.parent();
          e.hasClass(n.listitem + "_vertical") &&
            this[
              e.hasClass(n.listitem + "_opened") ? "closePanel" : "openPanel"
            ](t);
        },
        setSelected: function (t) {
          this.trigger("setSelected:before", t),
            this.$menu
              .find("." + n.listitem + "_selected")
              .removeClass(n.listitem + "_selected"),
            t.addClass(n.listitem + "_selected"),
            this.trigger("setSelected:after", t);
        },
        bind: function (t, e) {
          (this.cbck[t] = this.cbck[t] || []), this.cbck[t].push(e);
        },
        trigger: function () {
          var t = Array.prototype.slice.call(arguments),
            e = t.shift();
          if (this.cbck[e])
            for (var n = 0, i = this.cbck[e].length; n < i; n++)
              this.cbck[e][n].apply(this, t);
        },
        matchMedia: function (t, e, n) {
          var i = {
            yes: e,
            no: n,
          };
          (this.mtch[t] = this.mtch[t] || []), this.mtch[t].push(i);
        },
        i18n: function (e) {
          return t[r].i18n(e, this.conf.language);
        },
        _initHooks: function () {
          for (var t in this.opts.hooks) this.bind(t, this.opts.hooks[t]);
        },
        _initWrappers: function () {
          this.trigger("initWrappers:before");
          for (var e = 0; e < this.opts.wrappers.length; e++) {
            var n = t[r].wrappers[this.opts.wrappers[e]];
            "function" == typeof n && n.call(this);
          }
          this.trigger("initWrappers:after");
        },
        _initAddons: function () {
          var e;
          for (e in (this.trigger("initAddons:before"), t[r].addons))
            t[r].addons[e].add.call(this),
              (t[r].addons[e].add = function () {});
          for (e in t[r].addons) t[r].addons[e].setup.call(this);
          this.trigger("initAddons:after");
        },
        _initExtensions: function () {
          this.trigger("initExtensions:before");
          var t = this;
          for (var e in (this.opts.extensions.constructor === Array &&
            (this.opts.extensions = {
              all: this.opts.extensions,
            }),
          this.opts.extensions))
            (this.opts.extensions[e] = this.opts.extensions[e].length
              ? n.menu + "_" + this.opts.extensions[e].join(" " + n.menu + "_")
              : ""),
              this.opts.extensions[e] &&
                (function (e) {
                  t.matchMedia(
                    e,
                    function () {
                      this.$menu.addClass(this.opts.extensions[e]);
                    },
                    function () {
                      this.$menu.removeClass(this.opts.extensions[e]);
                    }
                  );
                })(e);
          this.trigger("initExtensions:after");
        },
        _initMenu: function () {
          this.trigger("initMenu:before");
          this.conf.clone &&
            ((this.$orig = this.$menu),
            (this.$menu = this.$orig.clone()),
            this.$menu
              .add(this.$menu.find("[id]"))
              .filter("[id]")
              .each(function () {
                t(this).attr("id", n.mm(t(this).attr("id")));
              })),
            this.$menu.attr(
              "id",
              this.$menu.attr("id") || this.__getUniqueId()
            ),
            (this.$pnls = t('<div class="' + n.panels + '" />')
              .append(this.$menu.children(this.conf.panelNodetype))
              .prependTo(this.$menu)),
            this.$menu.addClass(n.menu).parent().addClass(n.wrapper),
            this.trigger("initMenu:after");
        },
        _initPanels: function (e) {
          this.trigger("initPanels:before", e),
            (e = e || this.$pnls.children(this.conf.panelNodetype));
          var i = t(),
            s = this,
            a = function (e) {
              e.filter(s.conf.panelNodetype).each(function (e) {
                var r = s._initPanel(t(this));
                if (r) {
                  s._initNavbar(r), s._initListview(r), (i = i.add(r));
                  var l = r
                    .children("." + n.listview)
                    .children("li")
                    .children(s.conf.panelNodetype)
                    .add(r.children("." + s.conf.classNames.panel));
                  l.length && a(l);
                }
              });
            };
          a(e), this.trigger("initPanels:after", i);
        },
        _initPanel: function (t) {
          this.trigger("initPanel:before", t);
          if (t.hasClass(n.panel)) return t;
          if (
            (this.__refactorClass(t, this.conf.classNames.panel, n.panel),
            this.__refactorClass(t, this.conf.classNames.nopanel, n.nopanel),
            this.__refactorClass(
              t,
              this.conf.classNames.inset,
              n.listview + "_inset"
            ),
            t.filter("." + n.listview + "_inset").addClass(n.nopanel),
            t.hasClass(n.nopanel))
          )
            return !1;
          var e =
            t.hasClass(this.conf.classNames.vertical) ||
            !this.opts.slidingSubmenus;
          t.removeClass(this.conf.classNames.vertical);
          var s = t.attr("id") || this.__getUniqueId();
          t.is("ul, ol") &&
            (t.removeAttr("id"), t.wrap("<div />"), (t = t.parent())),
            t.attr("id", s),
            t.addClass(n.panel + " " + n.hidden);
          var a = t.parent("li");
          return (
            e ? a.addClass(n.listitem + "_vertical") : t.appendTo(this.$pnls),
            a.length && (a.data(i.child, t), t.data(i.parent, a)),
            this.trigger("initPanel:after", t),
            t
          );
        },
        _initNavbar: function (e) {
          if (
            (this.trigger("initNavbar:before", e),
            !e.children("." + n.navbar).length)
          ) {
            var s = e.data(i.parent),
              a = t('<div class="' + n.navbar + '" />'),
              r = this.__getPanelTitle(e, this.opts.navbar.title),
              l = "";
            if (s && s.length) {
              if (s.hasClass(n.listitem + "_vertical")) return;
              if (s.parent().is("." + n.listview))
                var o = s.children("a, span").not("." + n.btn + "_next");
              else
                o = s
                  .closest("." + n.panel)
                  .find('a[href="#' + e.attr("id") + '"]');
              var d = (s = (o = o.first()).closest("." + n.panel)).attr("id");
              switch (
                ((r = this.__getPanelTitle(
                  e,
                  t("<span>" + o.text() + "</span>").text()
                )),
                this.opts.navbar.titleLink)
              ) {
                case "anchor":
                  l = o.attr("href") || "";
                  break;
                case "parent":
                  l = "#" + d;
              }
              a.append(
                '<a class="' +
                  n.btn +
                  " " +
                  n.btn +
                  "_prev " +
                  n.navbar +
                  '__btn" href="#' +
                  d +
                  '" />'
              );
            } else if (!this.opts.navbar.title) return;
            this.opts.navbar.add && e.addClass(n.panel + "_has-navbar"),
              a
                .append(
                  '<a class="' +
                    n.navbar +
                    '__title"' +
                    (l.length ? ' href="' + l + '"' : "") +
                    ">" +
                    r +
                    "</a>"
                )
                .prependTo(e),
              this.trigger("initNavbar:after", e);
          }
        },
        _initListview: function (e) {
          this.trigger("initListview:before", e);
          var s = this.__childAddBack(e, "ul, ol");
          this.__refactorClass(
            s,
            this.conf.classNames.nolistview,
            n.nolistview
          );
          var a = s
            .not("." + n.nolistview)
            .addClass(n.listview)
            .children()
            .addClass(n.listitem);
          this.__refactorClass(
            a,
            this.conf.classNames.selected,
            n.listitem + "_selected"
          ),
            this.__refactorClass(
              a,
              this.conf.classNames.divider,
              n.listitem + "_divider"
            ),
            this.__refactorClass(
              a,
              this.conf.classNames.spacer,
              n.listitem + "_spacer"
            ),
            a
              .children("a, span")
              .not("." + n.btn)
              .addClass(n.listitem + "__text");
          var r = e.data(i.parent);
          if (r && r.is("." + n.listitem) && !r.children("." + n.btn).length) {
            var l = r.children("a, span").first(),
              o = t(
                '<a class="' +
                  n.btn +
                  " " +
                  n.btn +
                  "_next " +
                  n.listitem +
                  '__btn" href="#' +
                  e.attr("id") +
                  '" />'
              );
            o.insertAfter(l),
              l.is("span") &&
                (o.addClass(n.listitem + "__text").html(l.html()), l.remove());
          }
          this.trigger("initListview:after", e);
        },
        _initOpened: function () {
          this.trigger("initOpened:before");
          var t = this.$pnls
              .find("." + n.listitem + "_selected")
              .removeClass(n.listitem + "_selected")
              .last()
              .addClass(n.listitem + "_selected"),
            e = t.length
              ? t.closest("." + n.panel)
              : this.$pnls.children("." + n.panel).first();
          this.openPanel(e, !1), this.trigger("initOpened:after");
        },
        _initAnchors: function () {
          this.trigger("initAnchors:before");
          var e = this;
          a.$body.on(s.click + "-oncanvas", "a[href]", function (i) {
            var s = t(this),
              a = s.attr("href"),
              l = e.$menu.find(s).length,
              o = s.is("." + n.listitem + " > a"),
              d = s.is('[rel="external"]') || s.is('[target="_blank"]');
            if (l && a.length > 1 && "#" == a.slice(0, 1))
              try {
                var c = e.$menu.find(a);
                if (c.is("." + n.panel))
                  return (
                    e[
                      s.parent().hasClass(n.listitem + "_vertical")
                        ? "togglePanel"
                        : "openPanel"
                    ](c),
                    void i.preventDefault()
                  );
              } catch (t) {}
            var h = {
              close: null,
              setSelected: null,
              preventDefault: "#" == a.slice(0, 1),
            };
            for (var p in t[r].addons) {
              var f = t[r].addons[p].clickAnchor.call(e, s, l, o, d);
              if (f) {
                if ("boolean" == typeof f) return void i.preventDefault();
                "object" == typeof f && (h = t.extend({}, h, f));
              }
            }
            l &&
              o &&
              !d &&
              (e.__valueOrFn(s, e.opts.onClick.setSelected, h.setSelected) &&
                e.setSelected(t(i.target).parent()),
              e.__valueOrFn(
                s,
                e.opts.onClick.preventDefault,
                h.preventDefault
              ) && i.preventDefault(),
              e.__valueOrFn(s, e.opts.onClick.close, h.close) &&
                e.opts.offCanvas &&
                "function" == typeof e.close &&
                e.close());
          }),
            this.trigger("initAnchors:after");
        },
        _initMatchMedia: function () {
          var t = this;
          for (var e in this.mtch)
            !(function () {
              var n = e,
                i = window.matchMedia(n);
              t._fireMatchMedia(n, i),
                i.addListener(function (e) {
                  t._fireMatchMedia(n, e);
                });
            })();
        },
        _fireMatchMedia: function (t, e) {
          for (
            var n = e.matches ? "yes" : "no", i = 0;
            i < this.mtch[t].length;
            i++
          )
            this.mtch[t][i][n].call(this);
        },
        _getOriginalMenuId: function () {
          var t = this.$menu.attr("id");
          return this.conf.clone && t && t.length && (t = n.umm(t)), t;
        },
        __api: function () {
          var e = this,
            n = {};
          return (
            t.each(this._api, function (t) {
              var i = this;
              n[i] = function () {
                var t = e[i].apply(e, arguments);
                return void 0 === t ? n : t;
              };
            }),
            n
          );
        },
        __valueOrFn: function (t, e, n) {
          if ("function" == typeof e) {
            var i = e.call(t[0]);
            if (void 0 !== i) return i;
          }
          return ("function" != typeof e && void 0 !== e) || void 0 === n
            ? e
            : n;
        },
        __getPanelTitle: function (e, n) {
          var s;
          return (
            "function" == typeof this.opts.navbar.title &&
              (s = this.opts.navbar.title.call(e[0])),
            void 0 === s && (s = e.data(i.title)),
            void 0 !== s
              ? s
              : "string" == typeof n
              ? this.i18n(n)
              : this.i18n(t[r].defaults.navbar.title)
          );
        },
        __refactorClass: function (t, e, n) {
          return t
            .filter("." + e)
            .removeClass(e)
            .addClass(n);
        },
        __findAddBack: function (t, e) {
          return t.find(e).add(t.filter(e));
        },
        __childAddBack: function (t, e) {
          return t.children(e).add(t.filter(e));
        },
        __filterListItems: function (t) {
          return t.not("." + n.listitem + "_divider").not("." + n.hidden);
        },
        __filterListItemAnchors: function (t) {
          return this.__filterListItems(t)
            .children("a")
            .not("." + n.btn + "_next");
        },
        __openPanelWoAnimation: function (t) {
          t.hasClass(n.panel + "_noanimation") ||
            (t.addClass(n.panel + "_noanimation"),
            this.__transitionend(
              t,
              function () {
                t.removeClass(n.panel + "_noanimation");
              },
              this.conf.openingInterval
            ),
            this.openPanel(t));
        },
        __transitionend: function (t, e, n) {
          var i = !1,
            a = function (n) {
              (void 0 !== n && n.target != t[0]) ||
                (i ||
                  (t.off(s.transitionend),
                  t.off(s.webkitTransitionEnd),
                  e.call(t[0])),
                (i = !0));
            };
          t.on(s.transitionend, a),
            t.on(s.webkitTransitionEnd, a),
            setTimeout(a, 1.1 * n);
        },
        __getUniqueId: function () {
          return n.mm(t[r].uniqueId++);
        },
      }),
      (t.fn[r] = function (e, l) {
        !(function () {
          if (t[r].glbl) return;
          (a = {
            $wndw: t(window),
            $docu: t(document),
            $html: t("html"),
            $body: t("body"),
          }),
            (n = {}),
            (i = {}),
            (s = {}),
            t.each([n, i, s], function (t, e) {
              e.add = function (t) {
                t = t.split(" ");
                for (var n = 0, i = t.length; n < i; n++) e[t[n]] = e.mm(t[n]);
              };
            }),
            (n.mm = function (t) {
              return "mm-" + t;
            }),
            n.add(
              "wrapper menu panels panel nopanel navbar listview nolistview listitem btn hidden"
            ),
            (n.umm = function (t) {
              return "mm-" == t.slice(0, 3) && (t = t.slice(3)), t;
            }),
            (i.mm = function (t) {
              return "mm-" + t;
            }),
            i.add("parent child title"),
            (s.mm = function (t) {
              return t + ".mm";
            }),
            s.add(
              "transitionend webkitTransitionEnd click scroll resize keydown mousedown mouseup touchstart touchmove touchend orientationchange"
            ),
            (t[r]._c = n),
            (t[r]._d = i),
            (t[r]._e = s),
            (t[r].glbl = a);
        })();
        var o = t();
        return (
          this.each(function () {
            var n = t(this);
            if (!n.data(r)) {
              var i = jQuery.extend(!0, {}, t[r].defaults, e),
                s = jQuery.extend(!0, {}, t[r].configuration, l),
                a = new t[r](n, i, s);
              a.$menu.data(r, a.__api()), (o = o.add(a.$menu));
            }
          }),
          o
        );
      }),
      (t[r].i18n =
        ((e = {}),
        function (n, i) {
          switch (typeof n) {
            case "object":
              return (
                "string" == typeof i &&
                  (void 0 === e[i] && (e[i] = {}), t.extend(e[i], n)),
                e
              );
            case "string":
              return ("string" == typeof i && void 0 !== e[i] && e[i][n]) || n;
            case "undefined":
            default:
              return e;
          }
        })),
      (t[r].support = {
        touch: "ontouchstart" in window || navigator.msMaxTouchPoints || !1,
        csstransitions:
          "undefined" == typeof Modernizr ||
          void 0 === Modernizr.csstransitions ||
          Modernizr.csstransitions,
      }));
  })(jQuery);
  !(function (e) {
    var t,
      n,
      i,
      o,
      r = "offCanvas";
    (e.mmenu.addons[r] = {
      setup: function () {
        if (this.opts[r]) {
          var n = this.opts[r],
            i = this.conf[r];
          (o = e.mmenu.glbl),
            (this._api = e.merge(this._api, ["open", "close", "setPage"])),
            "object" != typeof n && (n = {}),
            (n = this.opts[r] = e.extend(!0, {}, e.mmenu.defaults[r], n)),
            "string" != typeof i.page.selector &&
              (i.page.selector = "> " + i.page.nodetype),
            (this.vars.opened = !1);
          var s = [t.menu + "_offcanvas"];
          this.bind("initMenu:after", function () {
            var e = this;
            this._initBlocker(),
              this.setPage(o.$page),
              this._initWindow_offCanvas(),
              this.$menu
                .addClass(s.join(" "))
                .parent("." + t.wrapper)
                .removeClass(t.wrapper),
              this.$menu[i.menu.insertMethod](i.menu.insertSelector);
            var n = window.location.hash;
            if (n) {
              var r = this._getOriginalMenuId();
              r &&
                r == n.slice(1) &&
                setTimeout(function () {
                  e.open();
                }, 1e3);
            }
          }),
            this.bind("setPage:after", function (e) {
              o.$blck && o.$blck.children("a").attr("href", "#" + e.attr("id"));
            }),
            this.bind("open:start:sr-aria", function () {
              this.__sr_aria(this.$menu, "hidden", !1);
            }),
            this.bind("close:finish:sr-aria", function () {
              this.__sr_aria(this.$menu, "hidden", !0);
            }),
            this.bind("initMenu:after:sr-aria", function () {
              this.__sr_aria(this.$menu, "hidden", !0);
            }),
            this.bind("initBlocker:after:sr-text", function () {
              o.$blck
                .children("a")
                .html(
                  this.__sr_text(
                    this.i18n(this.conf.screenReader.text.closeMenu)
                  )
                );
            });
        }
      },
      add: function () {
        (t = e.mmenu._c),
          (n = e.mmenu._d),
          (i = e.mmenu._e),
          t.add("slideout page no-csstransforms3d"),
          n.add("style");
      },
      clickAnchor: function (e, n) {
        var i = this;
        if (this.opts[r]) {
          var s = this._getOriginalMenuId();
          if (s && e.is('[href="#' + s + '"]')) {
            if (n) return this.open(), !0;
            var a = e.closest("." + t.menu);
            if (a.length) {
              var p = a.data("mmenu");
              if (p && p.close)
                return (
                  p.close(),
                  i.__transitionend(
                    a,
                    function () {
                      i.open();
                    },
                    i.conf.transitionDuration
                  ),
                  !0
                );
            }
            return this.open(), !0;
          }
          if (o.$page)
            return (s = o.$page.first().attr("id")) &&
              e.is('[href="#' + s + '"]')
              ? (this.close(), !0)
              : void 0;
        }
      },
    }),
      (e.mmenu.defaults[r] = {
        blockUI: !0,
        moveBackground: !0,
      }),
      (e.mmenu.configuration[r] = {
        menu: {
          insertMethod: "prependTo",
          insertSelector: "body",
        },
        page: {
          nodetype: "div",
          selector: null,
          noSelector: [],
          wrapIfNeeded: !0,
        },
      }),
      (e.mmenu.prototype.open = function () {
        if ((this.trigger("open:before"), !this.vars.opened)) {
          var e = this;
          this._openSetup(),
            setTimeout(function () {
              e._openFinish();
            }, this.conf.openingInterval),
            this.trigger("open:after");
        }
      }),
      (e.mmenu.prototype._openSetup = function () {
        var s = this,
          a = this.opts[r];
        this.closeAllOthers(),
          o.$page.each(function () {
            e(this).data(n.style, e(this).attr("style") || "");
          }),
          o.$wndw.trigger(i.resize + "-" + r, [!0]);
        var p = [t.wrapper + "_opened"];
        a.blockUI && p.push(t.wrapper + "_blocking"),
          "modal" == a.blockUI && p.push(t.wrapper + "_modal"),
          a.moveBackground && p.push(t.wrapper + "_background"),
          o.$html.addClass(p.join(" ")),
          setTimeout(function () {
            s.vars.opened = !0;
          }, this.conf.openingInterval),
          this.$menu.addClass(t.menu + "_opened");
      }),
      (e.mmenu.prototype._openFinish = function () {
        var e = this;
        this.__transitionend(
          o.$page.first(),
          function () {
            e.trigger("open:finish");
          },
          this.conf.transitionDuration
        ),
          this.trigger("open:start"),
          o.$html.addClass(t.wrapper + "_opening");
      }),
      (e.mmenu.prototype.close = function () {
        if ((this.trigger("close:before"), this.vars.opened)) {
          var i = this;
          this.__transitionend(
            o.$page.first(),
            function () {
              i.$menu.removeClass(t.menu + "_opened");
              var r = [
                t.wrapper + "_opened",
                t.wrapper + "_blocking",
                t.wrapper + "_modal",
                t.wrapper + "_background",
              ];
              o.$html.removeClass(r.join(" ")),
                o.$page.each(function () {
                  var t = e(this).data(n.style);
                  e(this).attr("style", t);
                }),
                (i.vars.opened = !1),
                i.trigger("close:finish");
            },
            this.conf.transitionDuration
          ),
            this.trigger("close:start"),
            o.$html.removeClass(t.wrapper + "_opening"),
            this.trigger("close:after");
        }
      }),
      (e.mmenu.prototype.closeAllOthers = function () {
        o.$body
          .find("." + t.menu + "_offcanvas")
          .not(this.$menu)
          .each(function () {
            var t = e(this).data("mmenu");
            t && t.close && t.close();
          });
      }),
      (e.mmenu.prototype.setPage = function (n) {
        this.trigger("setPage:before", n);
        var i = this,
          s = this.conf[r];
        (n && n.length) ||
          ((n = o.$body
            .find(s.page.selector)
            .not("." + t.menu)
            .not("." + t.wrapper + "__blocker")),
          s.page.noSelector.length && (n = n.not(s.page.noSelector.join(", "))),
          n.length > 1 &&
            s.page.wrapIfNeeded &&
            (n = n.wrapAll("<" + this.conf[r].page.nodetype + " />").parent())),
          n.addClass(t.page + " " + t.slideout).each(function () {
            e(this).attr("id", e(this).attr("id") || i.__getUniqueId());
          }),
          (o.$page = n),
          this.trigger("setPage:after", n);
      }),
      (e.mmenu.prototype._initWindow_offCanvas = function () {
        o.$wndw.off(i.keydown + "-" + r).on(i.keydown + "-" + r, function (e) {
          if (o.$html.hasClass(t.wrapper + "_opened") && 9 == e.keyCode)
            return e.preventDefault(), !1;
        });
        var e = 0;
        o.$wndw.off(i.resize + "-" + r).on(i.resize + "-" + r, function (n, i) {
          if (
            1 == o.$page.length &&
            (i || o.$html.hasClass(t.wrapper + "_opened"))
          ) {
            var r = o.$wndw.height();
            (i || r != e) && ((e = r), o.$page.css("minHeight", r));
          }
        });
      }),
      (e.mmenu.prototype._initBlocker = function () {
        var n = this,
          s = this.opts[r],
          a = this.conf[r];
        this.trigger("initBlocker:before"),
          s.blockUI &&
            (o.$blck ||
              (o.$blck = e(
                '<div class="' + t.wrapper + "__blocker " + t.slideout + '" />'
              ).append("<a />")),
            o.$blck
              .appendTo(a.menu.insertSelector)
              .off(i.touchstart + "-" + r + " " + i.touchmove + "-" + r)
              .on(
                i.touchstart + "-" + r + " " + i.touchmove + "-" + r,
                function (e) {
                  e.preventDefault(),
                    e.stopPropagation(),
                    o.$blck.trigger(i.mousedown + "-" + r);
                }
              )
              .off(i.mousedown + "-" + r)
              .on(i.mousedown + "-" + r, function (e) {
                e.preventDefault(),
                  o.$html.hasClass(t.wrapper + "_modal") ||
                    (n.closeAllOthers(), n.close());
              }),
            this.trigger("initBlocker:after"));
      });
  })(jQuery);
  !(function (t) {
    var i,
      n,
      e = "screenReader";
    (t.mmenu.addons[e] = {
      setup: function () {
        var r = this,
          a = this.opts[e],
          s = this.conf[e];
        t.mmenu.glbl,
          "boolean" == typeof a &&
            (a = {
              aria: a,
              text: a,
            }),
          "object" != typeof a && (a = {}),
          (a = this.opts[e] = t.extend(!0, {}, t.mmenu.defaults[e], a)).aria &&
            (this.bind("initAddons:after", function () {
              this.bind("initMenu:after", function () {
                this.trigger("initMenu:after:sr-aria");
              }),
                this.bind("initNavbar:after", function () {
                  this.trigger("initNavbar:after:sr-aria", arguments[0]);
                }),
                this.bind("openPanel:start", function () {
                  this.trigger("openPanel:start:sr-aria", arguments[0]);
                }),
                this.bind("close:start", function () {
                  this.trigger("close:start:sr-aria");
                }),
                this.bind("close:finish", function () {
                  this.trigger("close:finish:sr-aria");
                }),
                this.bind("open:start", function () {
                  this.trigger("open:start:sr-aria");
                }),
                this.bind("initOpened:after", function () {
                  this.trigger("initOpened:after:sr-aria");
                });
            }),
            this.bind("updateListview", function () {
              this.$pnls
                .find("." + i.listview)
                .children()
                .each(function () {
                  r.__sr_aria(t(this), "hidden", t(this).is("." + i.hidden));
                });
            }),
            this.bind("openPanel:start", function (t) {
              var n = this.$menu
                  .find("." + i.panel)
                  .not(t)
                  .not(t.parents("." + i.panel)),
                e = t.add(
                  t
                    .find(
                      "." + i.listitem + "_vertical ." + i.listitem + "_opened"
                    )
                    .children("." + i.panel)
                );
              this.__sr_aria(n, "hidden", !0), this.__sr_aria(e, "hidden", !1);
            }),
            this.bind("closePanel", function (t) {
              this.__sr_aria(t, "hidden", !0);
            }),
            this.bind("initPanels:after", function (n) {
              var e = n.find("." + i.btn).each(function () {
                r.__sr_aria(
                  t(this),
                  "owns",
                  t(this).attr("href").replace("#", "")
                );
              });
              this.__sr_aria(e, "haspopup", !0);
            }),
            this.bind("initNavbar:after", function (t) {
              var n = t.children("." + i.navbar);
              this.__sr_aria(n, "hidden", !t.hasClass(i.panel + "_has-navbar"));
            }),
            a.text &&
              "parent" == this.opts.navbar.titleLink &&
              this.bind("initNavbar:after", function (t) {
                var n = t.children("." + i.navbar),
                  e = !!n.children("." + i.btn + "_prev").length;
                this.__sr_aria(n.children("." + i.title), "hidden", e);
              })),
          a.text &&
            (this.bind("initAddons:after", function () {
              this.bind("setPage:after", function () {
                this.trigger("setPage:after:sr-text", arguments[0]);
              }),
                this.bind("initBlocker:after", function () {
                  this.trigger("initBlocker:after:sr-text");
                });
            }),
            this.bind("initNavbar:after", function (t) {
              var n = t.children("." + i.navbar),
                e = this.i18n(s.text.closeSubmenu);
              n.children("." + i.btn + "_prev").html(this.__sr_text(e));
            }),
            this.bind("initListview:after", function (t) {
              var e = t.data(n.parent);
              if (e && e.length) {
                var a = e.children("." + i.btn + "_next"),
                  o = this.i18n(
                    s.text[
                      a.parent().is("." + i.listitem + "_vertical")
                        ? "toggleSubmenu"
                        : "openSubmenu"
                    ]
                  );
                a.append(r.__sr_text(o));
              }
            }));
      },
      add: function () {
        (i = t.mmenu._c), (n = t.mmenu._d), t.mmenu._e, i.add("sronly");
      },
      clickAnchor: function (t, i) {},
    }),
      (t.mmenu.defaults[e] = {
        aria: !0,
        text: !0,
      }),
      (t.mmenu.configuration[e] = {
        text: {
          closeMenu: "Close menu",
          closeSubmenu: "Close submenu",
          openSubmenu: "Open submenu",
          toggleSubmenu: "Toggle submenu",
        },
      }),
      (t.mmenu.prototype.__sr_aria = function (t, i, n) {
        t.prop("aria-" + i, n)[n ? "attr" : "removeAttr"]("aria-" + i, n);
      }),
      (t.mmenu.prototype.__sr_role = function (t, i) {
        t.prop("role", i)[i ? "attr" : "removeAttr"]("role", i);
      }),
      (t.mmenu.prototype.__sr_text = function (t) {
        return '<span class="' + i.sronly + '">' + t + "</span>";
      });
  })(jQuery);
  !(function (o) {
    var t,
      n,
      e,
      r = "scrollBugFix";
    (o.mmenu.addons[r] = {
      setup: function () {
        var n = this.opts[r];
        this.conf[r];
        (e = o.mmenu.glbl),
          o.mmenu.support.touch &&
            this.opts.offCanvas &&
            this.opts.offCanvas.blockUI &&
            ("boolean" == typeof n &&
              (n = {
                fix: n,
              }),
            "object" != typeof n && (n = {}),
            (n = this.opts[r] = o.extend(!0, {}, o.mmenu.defaults[r], n)).fix &&
              (this.bind("open:start", function () {
                this.$pnls.children("." + t.panel + "_opened").scrollTop(0);
              }),
              this.bind("initMenu:after", function () {
                this["_initWindow_" + r]();
              })));
      },
      add: function () {
        (t = o.mmenu._c), o.mmenu._d, (n = o.mmenu._e);
      },
      clickAnchor: function (o, t) {},
    }),
      (o.mmenu.defaults[r] = {
        fix: !0,
      }),
      (o.mmenu.prototype["_initWindow_" + r] = function () {
        var s = this;
        o(document)
          .off(n.touchmove + "-" + r)
          .on(n.touchmove + "-" + r, function (o) {
            e.$html.hasClass(t.wrapper + "_opened") && o.preventDefault();
          });
        var i = !1;
        e.$body
          .off(n.touchstart + "-" + r)
          .on(
            n.touchstart + "-" + r,
            "." + t.panels + "> ." + t.panel,
            function (o) {
              e.$html.hasClass(t.wrapper + "_opened") &&
                (i ||
                  ((i = !0),
                  0 === o.currentTarget.scrollTop
                    ? (o.currentTarget.scrollTop = 1)
                    : o.currentTarget.scrollHeight ===
                        o.currentTarget.scrollTop +
                          o.currentTarget.offsetHeight &&
                      (o.currentTarget.scrollTop -= 1),
                  (i = !1)));
            }
          )
          .off(n.touchmove + "-" + r)
          .on(
            n.touchmove + "-" + r,
            "." + t.panels + "> ." + t.panel,
            function (n) {
              e.$html.hasClass(t.wrapper + "_opened") &&
                o(this)[0].scrollHeight > o(this).innerHeight() &&
                n.stopPropagation();
            }
          ),
          e.$wndw
            .off(n.orientationchange + "-" + r)
            .on(n.orientationchange + "-" + r, function () {
              s.$pnls
                .children("." + t.panel + "_opened")
                .scrollTop(0)
                .css({
                  "-webkit-overflow-scrolling": "auto",
                })
                .css({
                  "-webkit-overflow-scrolling": "touch",
                });
            });
      });
  })(jQuery);
  return jQuery.mmenu;
});
