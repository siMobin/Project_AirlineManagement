function e(e) {
  return null !== e && "object" == typeof e && "constructor" in e && e.constructor === Object;
}
function t(s, i) {
  void 0 === s && (s = {}),
    void 0 === i && (i = {}),
    Object.keys(i).forEach(r => {
      void 0 === s[r] ? (s[r] = i[r]) : e(i[r]) && e(s[r]) && Object.keys(i[r]).length > 0 && t(s[r], i[r]);
    });
}
const s = {
  body: {},
  addEventListener() {},
  removeEventListener() {},
  activeElement: {
    blur() {},
    nodeName: "",
  },
  querySelector: () => null,
  querySelectorAll: () => [],
  getElementById: () => null,
  createEvent: () => ({
    initEvent() {},
  }),
  createElement: () => ({
    children: [],
    childNodes: [],
    style: {},
    setAttribute() {},
    getElementsByTagName: () => [],
  }),
  createElementNS: () => ({}),
  importNode: () => null,
  location: {
    hash: "",
    host: "",
    hostname: "",
    href: "",
    origin: "",
    pathname: "",
    protocol: "",
    search: "",
  },
};
function i() {
  const e = "undefined" != typeof document ? document : {};
  return t(e, s), e;
}
const r = {
  document: s,
  navigator: {
    userAgent: "",
  },
  location: {
    hash: "",
    host: "",
    hostname: "",
    href: "",
    origin: "",
    pathname: "",
    protocol: "",
    search: "",
  },
  history: {
    replaceState() {},
    pushState() {},
    go() {},
    back() {},
  },
  CustomEvent: function () {
    return this;
  },
  addEventListener() {},
  removeEventListener() {},
  getComputedStyle: () => ({
    getPropertyValue: () => "",
  }),
  Image() {},
  Date() {},
  screen: {},
  setTimeout() {},
  clearTimeout() {},
  matchMedia: () => ({}),
  requestAnimationFrame: e => ("undefined" == typeof setTimeout ? (e(), null) : setTimeout(e, 0)),
  cancelAnimationFrame(e) {
    "undefined" != typeof setTimeout && clearTimeout(e);
  },
};
function n() {
  const e = "undefined" != typeof window ? window : {};
  return t(e, r), e;
}
function a(e, t) {
  return void 0 === t && (t = 0), setTimeout(e, t);
}
function l() {
  return Date.now();
}
function o(e, t) {
  void 0 === t && (t = "x");
  const s = n();
  let i, r, a;
  const l = (function (e) {
    const t = n();
    let s;
    return t.getComputedStyle && (s = t.getComputedStyle(e, null)), !s && e.currentStyle && (s = e.currentStyle), s || (s = e.style), s;
  })(e);
  return (
    s.WebKitCSSMatrix
      ? ((r = l.transform || l.webkitTransform),
        r.split(",").length > 6 &&
          (r = r
            .split(", ")
            .map(e => e.replace(",", "."))
            .join(", ")),
        (a = new s.WebKitCSSMatrix("none" === r ? "" : r)))
      : ((a = l.MozTransform || l.OTransform || l.MsTransform || l.msTransform || l.transform || l.getPropertyValue("transform").replace("translate(", "matrix(1, 0, 0, 1,")), (i = a.toString().split(","))),
    "x" === t && (r = s.WebKitCSSMatrix ? a.m41 : 16 === i.length ? parseFloat(i[12]) : parseFloat(i[4])),
    "y" === t && (r = s.WebKitCSSMatrix ? a.m42 : 16 === i.length ? parseFloat(i[13]) : parseFloat(i[5])),
    r || 0
  );
}
function d(e) {
  return "object" == typeof e && null !== e && e.constructor && "Object" === Object.prototype.toString.call(e).slice(8, -1);
}
function c(e) {
  return "undefined" != typeof window && void 0 !== window.HTMLElement ? e instanceof HTMLElement : e && (1 === e.nodeType || 11 === e.nodeType);
}
function p() {
  const e = Object(arguments.length <= 0 ? void 0 : arguments[0]),
    t = ["__proto__", "constructor", "prototype"];
  for (let s = 1; s < arguments.length; s += 1) {
    const i = s < 0 || arguments.length <= s ? void 0 : arguments[s];
    if (null != i && !c(i)) {
      const s = Object.keys(Object(i)).filter(e => t.indexOf(e) < 0);
      for (let t = 0, r = s.length; t < r; t += 1) {
        const r = s[t],
          n = Object.getOwnPropertyDescriptor(i, r);
        void 0 !== n && n.enumerable && (d(e[r]) && d(i[r]) ? (i[r].__swiper__ ? (e[r] = i[r]) : p(e[r], i[r])) : !d(e[r]) && d(i[r]) ? ((e[r] = {}), i[r].__swiper__ ? (e[r] = i[r]) : p(e[r], i[r])) : (e[r] = i[r]));
      }
    }
  }
  return e;
}
function u(e, t, s) {
  e.style.setProperty(t, s);
}
function h(e) {
  let { swiper: t, targetPosition: s, side: i } = e;
  const r = n(),
    a = -t.translate;
  let l,
    o = null;
  const d = t.params.speed;
  (t.wrapperEl.style.scrollSnapType = "none"), r.cancelAnimationFrame(t.cssModeFrameID);
  const c = s > a ? "next" : "prev",
    p = (e, t) => ("next" === c && e >= t) || ("prev" === c && e <= t),
    u = () => {
      (l = new Date().getTime()), null === o && (o = l);
      const e = Math.max(Math.min((l - o) / d, 1), 0),
        n = 0.5 - Math.cos(e * Math.PI) / 2;
      let c = a + n * (s - a);
      if (
        (p(c, s) && (c = s),
        t.wrapperEl.scrollTo({
          [i]: c,
        }),
        p(c, s))
      )
        return (
          (t.wrapperEl.style.overflow = "hidden"),
          (t.wrapperEl.style.scrollSnapType = ""),
          setTimeout(() => {
            (t.wrapperEl.style.overflow = ""),
              t.wrapperEl.scrollTo({
                [i]: c,
              });
          }),
          void r.cancelAnimationFrame(t.cssModeFrameID)
        );
      t.cssModeFrameID = r.requestAnimationFrame(u);
    };
  u();
}
function m(e, t) {
  return void 0 === t && (t = ""), [...e.children].filter(e => e.matches(t));
}
function f(e, t) {
  return n().getComputedStyle(e, null).getPropertyValue(t);
}
function v(e) {
  let t,
    s = e;
  if (s) {
    for (t = 0; null !== (s = s.previousSibling); ) 1 === s.nodeType && (t += 1);
    return t;
  }
}
function g(e, t) {
  const s = [];
  let i = e.parentElement;
  for (; i; ) t ? i.matches(t) && s.push(i) : s.push(i), (i = i.parentElement);
  return s;
}
function w(e, t, s) {
  const i = n();
  return s ? e["width" === t ? "offsetWidth" : "offsetHeight"] + parseFloat(i.getComputedStyle(e, null).getPropertyValue("width" === t ? "margin-right" : "margin-top")) + parseFloat(i.getComputedStyle(e, null).getPropertyValue("width" === t ? "margin-left" : "margin-bottom")) : e.offsetWidth;
}
let T, b, S;
function x() {
  return (
    T ||
      (T = (function () {
        const e = n(),
          t = i();
        return {
          smoothScroll: t.documentElement && t.documentElement.style && "scrollBehavior" in t.documentElement.style,
          touch: !!("ontouchstart" in e || (e.DocumentTouch && t instanceof e.DocumentTouch)),
        };
      })()),
    T
  );
}
function y(e) {
  return (
    void 0 === e && (e = {}),
    b ||
      (b = (function (e) {
        let { userAgent: t } = void 0 === e ? {} : e;
        const s = x(),
          i = n(),
          r = i.navigator.platform,
          a = t || i.navigator.userAgent,
          l = {
            ios: !1,
            android: !1,
          },
          o = i.screen.width,
          d = i.screen.height,
          c = a.match(/(Android);?[\s\/]+([\d.]+)?/);
        let p = a.match(/(iPad).*OS\s([\d_]+)/);
        const u = a.match(/(iPod)(.*OS\s([\d_]+))?/),
          h = !p && a.match(/(iPhone\sOS|iOS)\s([\d_]+)/),
          m = "Win32" === r;
        let f = "MacIntel" === r;
        return !p && f && s.touch && ["1024x1366", "1366x1024", "834x1194", "1194x834", "834x1112", "1112x834", "768x1024", "1024x768", "820x1180", "1180x820", "810x1080", "1080x810"].indexOf(`${o}x ${d}`) >= 0 && ((p = a.match(/(Version)\/([\d.]+)/)), p || (p = [0, 1, "13_0_0"]), (f = !1)), c && !m && ((l.os = "android"), (l.android = !0)), (p || h || u) && ((l.os = "ios"), (l.ios = !0)), l;
      })(e)),
    b
  );
}
function E() {
  return (
    S ||
      (S = (function () {
        const e = n();
        let t = !1;
        function s() {
          const t = e.navigator.userAgent.toLowerCase();
          return t.indexOf("safari") >= 0 && t.indexOf("chrome") < 0 && t.indexOf("android") < 0;
        }
        if (s()) {
          const s = String(e.navigator.userAgent);
          if (s.includes("Version/")) {
            const [e, i] = s
              .split("Version/")[1]
              .split(" ")[0]
              .split(".")
              .map(e => Number(e));
            t = e < 16 || (16 === e && i < 2);
          }
        }
        return {
          isSafari: t || s(),
          needPerspectiveFix: t,
          isWebView: /(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(e.navigator.userAgent),
        };
      })()),
    S
  );
}
const M = (e, t) => {
    if (!e || e.destroyed || !e.params) return;
    const s = t.closest(e.isElement ? "swiper-slide" : `.${e.params.slideClass}`);
    if (s) {
      const t = s.querySelector(`.${e.params.lazyPreloaderClass}`);
      t && t.remove();
    }
  },
  C = (e, t) => {
    if (!e.slides[t]) return;
    const s = e.slides[t].querySelector('[loading="lazy"]');
    s && s.removeAttribute("loading");
  },
  P = e => {
    if (!e || e.destroyed || !e.params) return;
    let t = e.params.lazyPreloadPrevNext;
    const s = e.slides.length;
    if (!s || !t || t < 0) return;
    t = Math.min(t, s);
    const i = "auto" === e.params.slidesPerView ? e.slidesPerViewDynamic() : Math.ceil(e.params.slidesPerView),
      r = e.activeIndex;
    if (e.params.grid && e.params.grid.rows > 1) {
      const s = r,
        n = [s - t];
      return (
        n.push(
          ...Array.from({
            length: t,
          }).map((e, t) => s + i + t)
        ),
        void e.slides.forEach((t, s) => {
          n.includes(t.column) && C(e, s);
        })
      );
    }
    const n = r + i - 1;
    if (e.params.rewind || e.params.loop)
      for (let a = r - t; a <= n + t; a += 1) {
        const t = ((a % s) + s) % s;
        (t < r || t > n) && C(e, t);
      }
    else for (let a = Math.max(r - t, 0); a <= Math.min(n + t, s - 1); a += 1) a !== r && (a > n || a < r) && C(e, a);
  };
function L(e) {
  let { swiper: t, runCallbacks: s, direction: i, step: r } = e;
  const { activeIndex: n, previousIndex: a } = t;
  let l = i;
  if ((l || (l = n > a ? "next" : n < a ? "prev" : "reset"), t.emit(`transition ${r}`), s && n !== a)) {
    if ("reset" === l) return void t.emit(`slideResetTransition ${r}`);
    t.emit(`slideChangeTransition ${r}`), "next" === l ? t.emit(`slideNextTransition ${r}`) : t.emit(`slidePrevTransition ${r}`);
  }
}
function k(e) {
  const t = this,
    s = i(),
    r = n(),
    a = t.touchEventsData;
  a.evCache.push(e);
  const { params: o, touches: d, enabled: c } = t;
  if (!c) return;
  if (!o.simulateTouch && "mouse" === e.pointerType) return;
  if (t.animating && o.preventInteractionOnTransition) return;
  !t.animating && o.cssMode && o.loop && t.loopFix();
  let p = e;
  p.originalEvent && (p = p.originalEvent);
  let u = p.target;
  if ("wrapper" === o.touchEventsTarget && !t.wrapperEl.contains(u)) return;
  if ("which" in p && 3 === p.which) return;
  if ("button" in p && p.button > 0) return;
  if (a.isTouched && a.isMoved) return;
  const h = !!o.noSwipingClass && "" !== o.noSwipingClass,
    m = e.composedPath ? e.composedPath() : e.path;
  h && p.target && p.target.shadowRoot && m && (u = m[0]);
  const f = o.noSwipingSelector ? o.noSwipingSelector : `.${o.noSwipingClass}`,
    v = !(!p.target || !p.target.shadowRoot);
  if (
    o.noSwiping &&
    (v
      ? (function (e, t) {
          return (
            void 0 === t && (t = this),
            (function t(s) {
              if (!s || s === i() || s === n()) return null;
              s.assignedSlot && (s = s.assignedSlot);
              const r = s.closest(e);
              return r || s.getRootNode ? r || t(s.getRootNode().host) : null;
            })(t)
          );
        })(f, u)
      : u.closest(f))
  )
    return void (t.allowClick = !0);
  if (o.swipeHandler && !u.closest(o.swipeHandler)) return;
  (d.currentX = p.pageX), (d.currentY = p.pageY);
  const g = d.currentX,
    w = d.currentY,
    T = o.edgeSwipeDetection || o.iOSEdgeSwipeDetection,
    b = o.edgeSwipeThreshold || o.iOSEdgeSwipeThreshold;
  if (T && (g <= b || g >= r.innerWidth - b)) {
    if ("prevent" !== T) return;
    e.preventDefault();
  }
  Object.assign(a, {
    isTouched: !0,
    isMoved: !1,
    allowTouchCallbacks: !0,
    isScrolling: void 0,
    startMoving: void 0,
  }),
    (d.startX = g),
    (d.startY = w),
    (a.touchStartTime = l()),
    (t.allowClick = !0),
    t.updateSize(),
    (t.swipeDirection = void 0),
    o.threshold > 0 && (a.allowThresholdMove = !1);
  let S = !0;
  u.matches(a.focusableElements) && ((S = !1), "SELECT" === u.nodeName && (a.isTouched = !1)), s.activeElement && s.activeElement.matches(a.focusableElements) && s.activeElement !== u && s.activeElement.blur();
  const x = S && t.allowTouchMove && o.touchStartPreventDefault;
  (!o.touchStartForcePreventDefault && !x) || u.isContentEditable || p.preventDefault(), o.freeMode && o.freeMode.enabled && t.freeMode && t.animating && !o.cssMode && t.freeMode.onTouchStart(), t.emit("touchStart", p);
}
function O(e) {
  const t = i(),
    s = this,
    r = s.touchEventsData,
    { params: n, touches: a, rtlTranslate: o, enabled: d } = s;
  if (!d) return;
  if (!n.simulateTouch && "mouse" === e.pointerType) return;
  let c = e;
  if ((c.originalEvent && (c = c.originalEvent), !r.isTouched)) return void (r.startMoving && r.isScrolling && s.emit("touchMoveOpposite", c));
  const p = r.evCache.findIndex(e => e.pointerId === c.pointerId);
  p >= 0 && (r.evCache[p] = c);
  const u = r.evCache.length > 1 ? r.evCache[0] : c,
    h = u.pageX,
    m = u.pageY;
  if (c.preventedByNestedSwiper) return (a.startX = h), void (a.startY = m);
  if (!s.allowTouchMove)
    return (
      c.target.matches(r.focusableElements) || (s.allowClick = !1),
      void (
        r.isTouched &&
        (Object.assign(a, {
          startX: h,
          startY: m,
          prevX: s.touches.currentX,
          prevY: s.touches.currentY,
          currentX: h,
          currentY: m,
        }),
        (r.touchStartTime = l()))
      )
    );
  if (n.touchReleaseOnEdges && !n.loop)
    if (s.isVertical()) {
      if ((m < a.startY && s.translate <= s.maxTranslate()) || (m > a.startY && s.translate >= s.minTranslate())) return (r.isTouched = !1), void (r.isMoved = !1);
    } else if ((h < a.startX && s.translate <= s.maxTranslate()) || (h > a.startX && s.translate >= s.minTranslate())) return;
  if (t.activeElement && c.target === t.activeElement && c.target.matches(r.focusableElements)) return (r.isMoved = !0), void (s.allowClick = !1);
  if ((r.allowTouchCallbacks && s.emit("touchMove", c), c.targetTouches && c.targetTouches.length > 1)) return;
  (a.currentX = h), (a.currentY = m);
  const f = a.currentX - a.startX,
    v = a.currentY - a.startY;
  if (s.params.threshold && Math.sqrt(f ** 2 + v ** 2) < s.params.threshold) return;
  if (void 0 === r.isScrolling) {
    let e;
    (s.isHorizontal() && a.currentY === a.startY) || (s.isVertical() && a.currentX === a.startX) ? (r.isScrolling = !1) : f * f + v * v >= 25 && ((e = (180 * Math.atan2(Math.abs(v), Math.abs(f))) / Math.PI), (r.isScrolling = s.isHorizontal() ? e > n.touchAngle : 90 - e > n.touchAngle));
  }
  if ((r.isScrolling && s.emit("touchMoveOpposite", c), void 0 === r.startMoving && ((a.currentX === a.startX && a.currentY === a.startY) || (r.startMoving = !0)), r.isScrolling || (s.zoom && s.params.zoom && s.params.zoom.enabled && r.evCache.length > 1))) return void (r.isTouched = !1);
  if (!r.startMoving) return;
  (s.allowClick = !1), !n.cssMode && c.cancelable && c.preventDefault(), n.touchMoveStopPropagation && !n.nested && c.stopPropagation();
  let g = s.isHorizontal() ? f : v,
    w = s.isHorizontal() ? a.currentX - a.previousX : a.currentY - a.previousY;
  n.oneWayMovement && ((g = Math.abs(g) * (o ? 1 : -1)), (w = Math.abs(w) * (o ? 1 : -1))), (a.diff = g), (g *= n.touchRatio), o && ((g = -g), (w = -w));
  const T = s.touchesDirection;
  (s.swipeDirection = g > 0 ? "prev" : "next"), (s.touchesDirection = w > 0 ? "prev" : "next");
  const b = s.params.loop && !n.cssMode;
  if (!r.isMoved) {
    if (
      (b &&
        s.loopFix({
          direction: s.swipeDirection,
        }),
      (r.startTranslate = s.getTranslate()),
      s.setTransition(0),
      s.animating)
    ) {
      const e = new window.CustomEvent("transitionend", {
        bubbles: !0,
        cancelable: !0,
      });
      s.wrapperEl.dispatchEvent(e);
    }
    (r.allowMomentumBounce = !1), !n.grabCursor || (!0 !== s.allowSlideNext && !0 !== s.allowSlidePrev) || s.setGrabCursor(!0), s.emit("sliderFirstMove", c);
  }
  let S;
  r.isMoved &&
    T !== s.touchesDirection &&
    b &&
    Math.abs(g) >= 1 &&
    (s.loopFix({
      direction: s.swipeDirection,
      setTranslate: !0,
    }),
    (S = !0)),
    s.emit("sliderMove", c),
    (r.isMoved = !0),
    (r.currentTranslate = g + r.startTranslate);
  let x = !0,
    y = n.resistanceRatio;
  if (
    (n.touchReleaseOnEdges && (y = 0),
    g > 0
      ? (b &&
          !S &&
          r.currentTranslate > (n.centeredSlides ? s.minTranslate() - s.size / 2 : s.minTranslate()) &&
          s.loopFix({
            direction: "prev",
            setTranslate: !0,
            activeSlideIndex: 0,
          }),
        r.currentTranslate > s.minTranslate() && ((x = !1), n.resistance && (r.currentTranslate = s.minTranslate() - 1 + (-s.minTranslate() + r.startTranslate + g) ** y)))
      : g < 0 &&
        (b &&
          !S &&
          r.currentTranslate < (n.centeredSlides ? s.maxTranslate() + s.size / 2 : s.maxTranslate()) &&
          s.loopFix({
            direction: "next",
            setTranslate: !0,
            activeSlideIndex: s.slides.length - ("auto" === n.slidesPerView ? s.slidesPerViewDynamic() : Math.ceil(parseFloat(n.slidesPerView, 10))),
          }),
        r.currentTranslate < s.maxTranslate() && ((x = !1), n.resistance && (r.currentTranslate = s.maxTranslate() + 1 - (s.maxTranslate() - r.startTranslate - g) ** y))),
    x && (c.preventedByNestedSwiper = !0),
    !s.allowSlideNext && "next" === s.swipeDirection && r.currentTranslate < r.startTranslate && (r.currentTranslate = r.startTranslate),
    !s.allowSlidePrev && "prev" === s.swipeDirection && r.currentTranslate > r.startTranslate && (r.currentTranslate = r.startTranslate),
    s.allowSlidePrev || s.allowSlideNext || (r.currentTranslate = r.startTranslate),
    n.threshold > 0)
  ) {
    if (!(Math.abs(g) > n.threshold || r.allowThresholdMove)) return void (r.currentTranslate = r.startTranslate);
    if (!r.allowThresholdMove) return (r.allowThresholdMove = !0), (a.startX = a.currentX), (a.startY = a.currentY), (r.currentTranslate = r.startTranslate), void (a.diff = s.isHorizontal() ? a.currentX - a.startX : a.currentY - a.startY);
  }
  n.followFinger && !n.cssMode && (((n.freeMode && n.freeMode.enabled && s.freeMode) || n.watchSlidesProgress) && (s.updateActiveIndex(), s.updateSlidesClasses()), n.freeMode && n.freeMode.enabled && s.freeMode && s.freeMode.onTouchMove(), s.updateProgress(r.currentTranslate), s.setTranslate(r.currentTranslate));
}
function I(e) {
  const t = this,
    s = t.touchEventsData,
    i = s.evCache.findIndex(t => t.pointerId === e.pointerId);
  if ((i >= 0 && s.evCache.splice(i, 1), ["pointercancel", "pointerout", "pointerleave"].includes(e.type))) {
    if (!("pointercancel" === e.type && (t.browser.isSafari || t.browser.isWebView))) return;
  }
  const { params: r, touches: n, rtlTranslate: o, slidesGrid: d, enabled: c } = t;
  if (!c) return;
  if (!r.simulateTouch && "mouse" === e.pointerType) return;
  let p = e;
  if ((p.originalEvent && (p = p.originalEvent), s.allowTouchCallbacks && t.emit("touchEnd", p), (s.allowTouchCallbacks = !1), !s.isTouched)) return s.isMoved && r.grabCursor && t.setGrabCursor(!1), (s.isMoved = !1), void (s.startMoving = !1);
  r.grabCursor && s.isMoved && s.isTouched && (!0 === t.allowSlideNext || !0 === t.allowSlidePrev) && t.setGrabCursor(!1);
  const u = l(),
    h = u - s.touchStartTime;
  if (t.allowClick) {
    const e = p.path || (p.composedPath && p.composedPath());
    t.updateClickedSlide((e && e[0]) || p.target), t.emit("tap click", p), h < 300 && u - s.lastClickTime < 300 && t.emit("doubleTap doubleClick", p);
  }
  if (
    ((s.lastClickTime = l()),
    a(() => {
      t.destroyed || (t.allowClick = !0);
    }),
    !s.isTouched || !s.isMoved || !t.swipeDirection || 0 === n.diff || s.currentTranslate === s.startTranslate)
  )
    return (s.isTouched = !1), (s.isMoved = !1), void (s.startMoving = !1);
  let m;
  if (((s.isTouched = !1), (s.isMoved = !1), (s.startMoving = !1), (m = r.followFinger ? (o ? t.translate : -t.translate) : -s.currentTranslate), r.cssMode)) return;
  if (r.freeMode && r.freeMode.enabled)
    return void t.freeMode.onTouchEnd({
      currentPos: m,
    });
  let f = 0,
    v = t.slidesSizesGrid[0];
  for (let a = 0; a < d.length; a += a < r.slidesPerGroupSkip ? 1 : r.slidesPerGroup) {
    const e = a < r.slidesPerGroupSkip - 1 ? 1 : r.slidesPerGroup;
    void 0 !== d[a + e] ? m >= d[a] && m < d[a + e] && ((f = a), (v = d[a + e] - d[a])) : m >= d[a] && ((f = a), (v = d[d.length - 1] - d[d.length - 2]));
  }
  let g = null,
    w = null;
  r.rewind && (t.isBeginning ? (w = r.virtual && r.virtual.enabled && t.virtual ? t.virtual.slides.length - 1 : t.slides.length - 1) : t.isEnd && (g = 0));
  const T = (m - d[f]) / v,
    b = f < r.slidesPerGroupSkip - 1 ? 1 : r.slidesPerGroup;
  if (h > r.longSwipesMs) {
    if (!r.longSwipes) return void t.slideTo(t.activeIndex);
    "next" === t.swipeDirection && (T >= r.longSwipesRatio ? t.slideTo(r.rewind && t.isEnd ? g : f + b) : t.slideTo(f)), "prev" === t.swipeDirection && (T > 1 - r.longSwipesRatio ? t.slideTo(f + b) : null !== w && T < 0 && Math.abs(T) > r.longSwipesRatio ? t.slideTo(w) : t.slideTo(f));
  } else {
    if (!r.shortSwipes) return void t.slideTo(t.activeIndex);
    t.navigation && (p.target === t.navigation.nextEl || p.target === t.navigation.prevEl) ? (p.target === t.navigation.nextEl ? t.slideTo(f + b) : t.slideTo(f)) : ("next" === t.swipeDirection && t.slideTo(null !== g ? g : f + b), "prev" === t.swipeDirection && t.slideTo(null !== w ? w : f));
  }
}
function z() {
  const e = this,
    { params: t, el: s } = e;
  if (s && 0 === s.offsetWidth) return;
  t.breakpoints && e.setBreakpoint();
  const { allowSlideNext: i, allowSlidePrev: r, snapGrid: n } = e,
    a = e.virtual && e.params.virtual.enabled;
  (e.allowSlideNext = !0), (e.allowSlidePrev = !0), e.updateSize(), e.updateSlides(), e.updateSlidesClasses();
  const l = a && t.loop;
  !("auto" === t.slidesPerView || t.slidesPerView > 1) || !e.isEnd || e.isBeginning || e.params.centeredSlides || l ? (e.params.loop && !a ? e.slideToLoop(e.realIndex, 0, !1, !0) : e.slideTo(e.activeIndex, 0, !1, !0)) : e.slideTo(e.slides.length - 1, 0, !1, !0),
    e.autoplay &&
      e.autoplay.running &&
      e.autoplay.paused &&
      (clearTimeout(e.autoplay.resizeTimeout),
      (e.autoplay.resizeTimeout = setTimeout(() => {
        e.autoplay && e.autoplay.running && e.autoplay.paused && e.autoplay.resume();
      }, 500))),
    (e.allowSlidePrev = r),
    (e.allowSlideNext = i),
    e.params.watchOverflow && n !== e.snapGrid && e.checkOverflow();
}
function A(e) {
  const t = this;
  t.enabled && (t.allowClick || (t.params.preventClicks && e.preventDefault(), t.params.preventClicksPropagation && t.animating && (e.stopPropagation(), e.stopImmediatePropagation())));
}
function G() {
  const e = this,
    { wrapperEl: t, rtlTranslate: s, enabled: i } = e;
  if (!i) return;
  let r;
  (e.previousTranslate = e.translate), e.isHorizontal() ? (e.translate = -t.scrollLeft) : (e.translate = -t.scrollTop), 0 === e.translate && (e.translate = 0), e.updateActiveIndex(), e.updateSlidesClasses();
  const n = e.maxTranslate() - e.minTranslate();
  (r = 0 === n ? 0 : (e.translate - e.minTranslate()) / n), r !== e.progress && e.updateProgress(s ? -e.translate : e.translate), e.emit("setTranslate", e.translate, !1);
}
function D(e) {
  const t = this;
  M(t, e.target), t.params.cssMode || ("auto" !== t.params.slidesPerView && !t.params.autoHeight) || t.update();
}
let _ = !1;
function V() {}
const N = (e, t) => {
  const s = i(),
    { params: r, el: n, wrapperEl: a, device: l } = e,
    o = !!r.nested,
    d = "on" === t ? "addEventListener" : "removeEventListener",
    c = t;
  n[d]("pointerdown", e.onTouchStart, {
    passive: !1,
  }),
    s[d]("pointermove", e.onTouchMove, {
      passive: !1,
      capture: o,
    }),
    s[d]("pointerup", e.onTouchEnd, {
      passive: !0,
    }),
    s[d]("pointercancel", e.onTouchEnd, {
      passive: !0,
    }),
    s[d]("pointerout", e.onTouchEnd, {
      passive: !0,
    }),
    s[d]("pointerleave", e.onTouchEnd, {
      passive: !0,
    }),
    (r.preventClicks || r.preventClicksPropagation) && n[d]("click", e.onClick, !0),
    r.cssMode && a[d]("scroll", e.onScroll),
    r.updateOnWindowResize ? e[c](l.ios || l.android ? "resize orientationchange observerUpdate" : "resize observerUpdate", z, !0) : e[c]("observerUpdate", z, !0),
    n[d]("load", e.onLoad, {
      capture: !0,
    });
};
const B = (e, t) => e.grid && t.grid && t.grid.rows > 1;
var F = {
  init: !0,
  direction: "horizontal",
  oneWayMovement: !1,
  touchEventsTarget: "wrapper",
  initialSlide: 0,
  speed: 300,
  cssMode: !1,
  updateOnWindowResize: !0,
  resizeObserver: !0,
  nested: !1,
  createElements: !1,
  enabled: !0,
  focusableElements: "input, select, option, textarea, button, video, label",
  width: null,
  height: null,
  preventInteractionOnTransition: !1,
  userAgent: null,
  url: null,
  edgeSwipeDetection: !1,
  edgeSwipeThreshold: 20,
  autoHeight: !1,
  setWrapperSize: !1,
  virtualTranslate: !1,
  effect: "slide",
  breakpoints: void 0,
  breakpointsBase: "window",
  spaceBetween: 0,
  slidesPerView: 1,
  slidesPerGroup: 1,
  slidesPerGroupSkip: 0,
  slidesPerGroupAuto: !1,
  centeredSlides: !1,
  centeredSlidesBounds: !1,
  slidesOffsetBefore: 0,
  slidesOffsetAfter: 0,
  normalizeSlideIndex: !0,
  centerInsufficientSlides: !1,
  watchOverflow: !0,
  roundLengths: !1,
  touchRatio: 1,
  touchAngle: 45,
  simulateTouch: !0,
  shortSwipes: !0,
  longSwipes: !0,
  longSwipesRatio: 0.5,
  longSwipesMs: 300,
  followFinger: !0,
  allowTouchMove: !0,
  threshold: 5,
  touchMoveStopPropagation: !1,
  touchStartPreventDefault: !0,
  touchStartForcePreventDefault: !1,
  touchReleaseOnEdges: !1,
  uniqueNavElements: !0,
  resistance: !0,
  resistanceRatio: 0.85,
  watchSlidesProgress: !1,
  grabCursor: !1,
  preventClicks: !0,
  preventClicksPropagation: !0,
  slideToClickedSlide: !1,
  loop: !1,
  loopedSlides: null,
  loopPreventsSliding: !0,
  rewind: !1,
  allowSlidePrev: !0,
  allowSlideNext: !0,
  swipeHandler: null,
  noSwiping: !0,
  noSwipingClass: "swiper-no-swiping",
  noSwipingSelector: null,
  passiveListeners: !0,
  maxBackfaceHiddenSlides: 10,
  containerModifierClass: "swiper-",
  slideClass: "swiper-slide",
  slideActiveClass: "swiper-slide-active",
  slideVisibleClass: "swiper-slide-visible",
  slideNextClass: "swiper-slide-next",
  slidePrevClass: "swiper-slide-prev",
  wrapperClass: "swiper-wrapper",
  lazyPreloaderClass: "swiper-lazy-preloader",
  lazyPreloadPrevNext: 0,
  runCallbacksOnInit: !0,
  _emitClasses: !1,
};
function H(e, t) {
  return function (s) {
    void 0 === s && (s = {});
    const i = Object.keys(s)[0],
      r = s[i];
    "object" == typeof r && null !== r
      ? (["navigation", "pagination", "scrollbar"].indexOf(i) >= 0 &&
          !0 === e[i] &&
          (e[i] = {
            auto: !0,
          }),
        i in e && "enabled" in r
          ? (!0 === e[i] &&
              (e[i] = {
                enabled: !0,
              }),
            "object" != typeof e[i] || "enabled" in e[i] || (e[i].enabled = !0),
            e[i] ||
              (e[i] = {
                enabled: !1,
              }),
            p(t, s))
          : p(t, s))
      : p(t, s);
  };
}
const $ = {
    eventsEmitter: {
      on(e, t, s) {
        const i = this;
        if (!i.eventsListeners || i.destroyed) return i;
        if ("function" != typeof t) return i;
        const r = s ? "unshift" : "push";
        return (
          e.split(" ").forEach(e => {
            i.eventsListeners[e] || (i.eventsListeners[e] = []), i.eventsListeners[e][r](t);
          }),
          i
        );
      },
      once(e, t, s) {
        const i = this;
        if (!i.eventsListeners || i.destroyed) return i;
        if ("function" != typeof t) return i;
        function r() {
          i.off(e, r), r.__emitterProxy && delete r.__emitterProxy;
          for (var s = arguments.length, n = new Array(s), a = 0; a < s; a++) n[a] = arguments[a];
          t.apply(i, n);
        }
        return (r.__emitterProxy = t), i.on(e, r, s);
      },
      onAny(e, t) {
        const s = this;
        if (!s.eventsListeners || s.destroyed) return s;
        if ("function" != typeof e) return s;
        const i = t ? "unshift" : "push";
        return s.eventsAnyListeners.indexOf(e) < 0 && s.eventsAnyListeners[i](e), s;
      },
      offAny(e) {
        const t = this;
        if (!t.eventsListeners || t.destroyed) return t;
        if (!t.eventsAnyListeners) return t;
        const s = t.eventsAnyListeners.indexOf(e);
        return s >= 0 && t.eventsAnyListeners.splice(s, 1), t;
      },
      off(e, t) {
        const s = this;
        return !s.eventsListeners || s.destroyed
          ? s
          : s.eventsListeners
          ? (e.split(" ").forEach(e => {
              void 0 === t
                ? (s.eventsListeners[e] = [])
                : s.eventsListeners[e] &&
                  s.eventsListeners[e].forEach((i, r) => {
                    (i === t || (i.__emitterProxy && i.__emitterProxy === t)) && s.eventsListeners[e].splice(r, 1);
                  });
            }),
            s)
          : s;
      },
      emit() {
        const e = this;
        if (!e.eventsListeners || e.destroyed) return e;
        if (!e.eventsListeners) return e;
        let t, s, i;
        for (var r = arguments.length, n = new Array(r), a = 0; a < r; a++) n[a] = arguments[a];
        "string" == typeof n[0] || Array.isArray(n[0]) ? ((t = n[0]), (s = n.slice(1, n.length)), (i = e)) : ((t = n[0].events), (s = n[0].data), (i = n[0].context || e)), s.unshift(i);
        return (
          (Array.isArray(t) ? t : t.split(" ")).forEach(t => {
            e.eventsAnyListeners &&
              e.eventsAnyListeners.length &&
              e.eventsAnyListeners.forEach(e => {
                e.apply(i, [t, ...s]);
              }),
              e.eventsListeners &&
                e.eventsListeners[t] &&
                e.eventsListeners[t].forEach(e => {
                  e.apply(i, s);
                });
          }),
          e
        );
      },
    },
    update: {
      updateSize: function () {
        const e = this;
        let t, s;
        const i = e.el;
        (t = void 0 !== e.params.width && null !== e.params.width ? e.params.width : i.clientWidth),
          (s = void 0 !== e.params.height && null !== e.params.height ? e.params.height : i.clientHeight),
          (0 === t && e.isHorizontal()) ||
            (0 === s && e.isVertical()) ||
            ((t = t - parseInt(f(i, "padding-left") || 0, 10) - parseInt(f(i, "padding-right") || 0, 10)),
            (s = s - parseInt(f(i, "padding-top") || 0, 10) - parseInt(f(i, "padding-bottom") || 0, 10)),
            Number.isNaN(t) && (t = 0),
            Number.isNaN(s) && (s = 0),
            Object.assign(e, {
              width: t,
              height: s,
              size: e.isHorizontal() ? t : s,
            }));
      },
      updateSlides: function () {
        const e = this;
        function t(t) {
          return e.isHorizontal()
            ? t
            : {
                width: "height",
                "margin-top": "margin-left",
                "margin-bottom ": "margin-right",
                "margin-left": "margin-top",
                "margin-right": "margin-bottom",
                "padding-left": "padding-top",
                "padding-right": "padding-bottom",
                marginRight: "marginBottom",
              }[t];
        }
        function s(e, s) {
          return parseFloat(e.getPropertyValue(t(s)) || 0);
        }
        const i = e.params,
          { wrapperEl: r, slidesEl: n, size: a, rtlTranslate: l, wrongRTL: o } = e,
          d = e.virtual && i.virtual.enabled,
          c = d ? e.virtual.slides.length : e.slides.length,
          p = m(n, `.${e.params.slideClass}, swiper-slide`),
          h = d ? e.virtual.slides.length : p.length;
        let v = [];
        const g = [],
          T = [];
        let b = i.slidesOffsetBefore;
        "function" == typeof b && (b = i.slidesOffsetBefore.call(e));
        let S = i.slidesOffsetAfter;
        "function" == typeof S && (S = i.slidesOffsetAfter.call(e));
        const x = e.snapGrid.length,
          y = e.slidesGrid.length;
        let E = i.spaceBetween,
          M = -b,
          C = 0,
          P = 0;
        if (void 0 === a) return;
        "string" == typeof E && E.indexOf("%") >= 0 ? (E = (parseFloat(E.replace("%", "")) / 100) * a) : "string" == typeof E && (E = parseFloat(E)),
          (e.virtualSize = -E),
          p.forEach(e => {
            l ? (e.style.marginLeft = "") : (e.style.marginRight = ""), (e.style.marginBottom = ""), (e.style.marginTop = "");
          }),
          i.centeredSlides && i.cssMode && (u(r, "--swiper-centered-offset-before", ""), u(r, "--swiper-centered-offset-after", ""));
        const L = i.grid && i.grid.rows > 1 && e.grid;
        let k;
        L && e.grid.initSlides(h);
        const O = "auto" === i.slidesPerView && i.breakpoints && Object.keys(i.breakpoints).filter(e => void 0 !== i.breakpoints[e].slidesPerView).length > 0;
        for (let u = 0; u < h; u += 1) {
          let r;
          if (((k = 0), p[u] && (r = p[u]), L && e.grid.updateSlide(u, r, h, t), !p[u] || "none" !== f(r, "display"))) {
            if ("auto" === i.slidesPerView) {
              O && (p[u].style[t("width")] = "");
              const n = getComputedStyle(r),
                a = r.style.transform,
                l = r.style.webkitTransform;
              if ((a && (r.style.transform = "none"), l && (r.style.webkitTransform = "none"), i.roundLengths)) k = e.isHorizontal() ? w(r, "width", !0) : w(r, "height", !0);
              else {
                const e = s(n, "width"),
                  t = s(n, "padding-left"),
                  i = s(n, "padding-right"),
                  a = s(n, "margin-left"),
                  l = s(n, "margin-right"),
                  o = n.getPropertyValue("box-sizing");
                if (o && "border-box" === o) k = e + a + l;
                else {
                  const { clientWidth: s, offsetWidth: n } = r;
                  k = e + t + i + a + l + (n - s);
                }
              }
              a && (r.style.transform = a), l && (r.style.webkitTransform = l), i.roundLengths && (k = Math.floor(k));
            } else (k = (a - (i.slidesPerView - 1) * E) / i.slidesPerView), i.roundLengths && (k = Math.floor(k)), p[u] && (p[u].style[t("width")] = `${k}px`);
            p[u] && (p[u].swiperSlideSize = k), T.push(k), i.centeredSlides ? ((M = M + k / 2 + C / 2 + E), 0 === C && 0 !== u && (M = M - a / 2 - E), 0 === u && (M = M - a / 2 - E), Math.abs(M) < 0.001 && (M = 0), i.roundLengths && (M = Math.floor(M)), P % i.slidesPerGroup == 0 && v.push(M), g.push(M)) : (i.roundLengths && (M = Math.floor(M)), (P - Math.min(e.params.slidesPerGroupSkip, P)) % e.params.slidesPerGroup == 0 && v.push(M), g.push(M), (M = M + k + E)), (e.virtualSize += k + E), (C = k), (P += 1);
          }
        }
        if (((e.virtualSize = Math.max(e.virtualSize, a) + S), l && o && ("slide" === i.effect || "coverflow" === i.effect) && (r.style.width = `${e.virtualSize + E}px`), i.setWrapperSize && (r.style[t("width")] = `${e.virtualSize + E}px`), L && e.grid.updateWrapperSize(k, v, t), !i.centeredSlides)) {
          const t = [];
          for (let s = 0; s < v.length; s += 1) {
            let r = v[s];
            i.roundLengths && (r = Math.floor(r)), v[s] <= e.virtualSize - a && t.push(r);
          }
          (v = t), Math.floor(e.virtualSize - a) - Math.floor(v[v.length - 1]) > 1 && v.push(e.virtualSize - a);
        }
        if (d && i.loop) {
          const t = T[0] + E;
          if (i.slidesPerGroup > 1) {
            const s = Math.ceil((e.virtual.slidesBefore + e.virtual.slidesAfter) / i.slidesPerGroup),
              r = t * i.slidesPerGroup;
            for (let e = 0; e < s; e += 1) v.push(v[v.length - 1] + r);
          }
          for (let s = 0; s < e.virtual.slidesBefore + e.virtual.slidesAfter; s += 1) 1 === i.slidesPerGroup && v.push(v[v.length - 1] + t), g.push(g[g.length - 1] + t), (e.virtualSize += t);
        }
        if ((0 === v.length && (v = [0]), 0 !== E)) {
          const s = e.isHorizontal() && l ? "marginLeft" : t("marginRight");
          p.filter((e, t) => !(i.cssMode && !i.loop) || t !== p.length - 1).forEach(e => {
            e.style[s] = `${E}px`;
          });
        }
        if (i.centeredSlides && i.centeredSlidesBounds) {
          let e = 0;
          T.forEach(t => {
            e += t + (E || 0);
          }),
            (e -= E);
          const t = e - a;
          v = v.map(e => (e <= 0 ? -b : e > t ? t + S : e));
        }
        if (i.centerInsufficientSlides) {
          let e = 0;
          if (
            (T.forEach(t => {
              e += t + (E || 0);
            }),
            (e -= E),
            e < a)
          ) {
            const t = (a - e) / 2;
            v.forEach((e, s) => {
              v[s] = e - t;
            }),
              g.forEach((e, s) => {
                g[s] = e + t;
              });
          }
        }
        if (
          (Object.assign(e, {
            slides: p,
            snapGrid: v,
            slidesGrid: g,
            slidesSizesGrid: T,
          }),
          i.centeredSlides && i.cssMode && !i.centeredSlidesBounds)
        ) {
          u(r, "--swiper-centered-offset-before", -v[0] + "px"), u(r, "--swiper-centered-offset-after", e.size / 2 - T[T.length - 1] / 2 + "px");
          const t = -e.snapGrid[0],
            s = -e.slidesGrid[0];
          (e.snapGrid = e.snapGrid.map(e => e + t)), (e.slidesGrid = e.slidesGrid.map(e => e + s));
        }
        if ((h !== c && e.emit("slidesLengthChange"), v.length !== x && (e.params.watchOverflow && e.checkOverflow(), e.emit("snapGridLengthChange")), g.length !== y && e.emit("slidesGridLengthChange"), i.watchSlidesProgress && e.updateSlidesOffset(), !(d || i.cssMode || ("slide" !== i.effect && "fade" !== i.effect)))) {
          const t = `${i.containerModifierClass}backface-hidden`,
            s = e.el.classList.contains(t);
          h <= i.maxBackfaceHiddenSlides ? s || e.el.classList.add(t) : s && e.el.classList.remove(t);
        }
      },
      updateAutoHeight: function (e) {
        const t = this,
          s = [],
          i = t.virtual && t.params.virtual.enabled;
        let r,
          n = 0;
        "number" == typeof e ? t.setTransition(e) : !0 === e && t.setTransition(t.params.speed);
        const a = e => (i ? t.slides[t.getSlideIndexByData(e)] : t.slides[e]);
        if ("auto" !== t.params.slidesPerView && t.params.slidesPerView > 1)
          if (t.params.centeredSlides)
            (t.visibleSlides || []).forEach(e => {
              s.push(e);
            });
          else
            for (r = 0; r < Math.ceil(t.params.slidesPerView); r += 1) {
              const e = t.activeIndex + r;
              if (e > t.slides.length && !i) break;
              s.push(a(e));
            }
        else s.push(a(t.activeIndex));
        for (r = 0; r < s.length; r += 1)
          if (void 0 !== s[r]) {
            const e = s[r].offsetHeight;
            n = e > n ? e : n;
          }
        (n || 0 === n) && (t.wrapperEl.style.height = `${n}px`);
      },
      updateSlidesOffset: function () {
        const e = this,
          t = e.slides,
          s = e.isElement ? (e.isHorizontal() ? e.wrapperEl.offsetLeft : e.wrapperEl.offsetTop) : 0;
        for (let i = 0; i < t.length; i += 1) t[i].swiperSlideOffset = (e.isHorizontal() ? t[i].offsetLeft : t[i].offsetTop) - s - e.cssOverflowAdjustment();
      },
      updateSlidesProgress: function (e) {
        void 0 === e && (e = (this && this.translate) || 0);
        const t = this,
          s = t.params,
          { slides: i, rtlTranslate: r, snapGrid: n } = t;
        if (0 === i.length) return;
        void 0 === i[0].swiperSlideOffset && t.updateSlidesOffset();
        let a = -e;
        r && (a = e),
          i.forEach(e => {
            e.classList.remove(s.slideVisibleClass);
          }),
          (t.visibleSlidesIndexes = []),
          (t.visibleSlides = []);
        let l = s.spaceBetween;
        "string" == typeof l && l.indexOf("%") >= 0 ? (l = (parseFloat(l.replace("%", "")) / 100) * t.size) : "string" == typeof l && (l = parseFloat(l));
        for (let o = 0; o < i.length; o += 1) {
          const e = i[o];
          let d = e.swiperSlideOffset;
          s.cssMode && s.centeredSlides && (d -= i[0].swiperSlideOffset);
          const c = (a + (s.centeredSlides ? t.minTranslate() : 0) - d) / (e.swiperSlideSize + l),
            p = (a - n[0] + (s.centeredSlides ? t.minTranslate() : 0) - d) / (e.swiperSlideSize + l),
            u = -(a - d),
            h = u + t.slidesSizesGrid[o];
          ((u >= 0 && u < t.size - 1) || (h > 1 && h <= t.size) || (u <= 0 && h >= t.size)) && (t.visibleSlides.push(e), t.visibleSlidesIndexes.push(o), i[o].classList.add(s.slideVisibleClass)), (e.progress = r ? -c : c), (e.originalProgress = r ? -p : p);
        }
      },
      updateProgress: function (e) {
        const t = this;
        if (void 0 === e) {
          const s = t.rtlTranslate ? -1 : 1;
          e = (t && t.translate && t.translate * s) || 0;
        }
        const s = t.params,
          i = t.maxTranslate() - t.minTranslate();
        let { progress: r, isBeginning: n, isEnd: a, progressLoop: l } = t;
        const o = n,
          d = a;
        if (0 === i) (r = 0), (n = !0), (a = !0);
        else {
          r = (e - t.minTranslate()) / i;
          const s = Math.abs(e - t.minTranslate()) < 1,
            l = Math.abs(e - t.maxTranslate()) < 1;
          (n = s || r <= 0), (a = l || r >= 1), s && (r = 0), l && (r = 1);
        }
        if (s.loop) {
          const s = t.getSlideIndexByData(0),
            i = t.getSlideIndexByData(t.slides.length - 1),
            r = t.slidesGrid[s],
            n = t.slidesGrid[i],
            a = t.slidesGrid[t.slidesGrid.length - 1],
            o = Math.abs(e);
          (l = o >= r ? (o - r) / a : (o + a - n) / a), l > 1 && (l -= 1);
        }
        Object.assign(t, {
          progress: r,
          progressLoop: l,
          isBeginning: n,
          isEnd: a,
        }),
          (s.watchSlidesProgress || (s.centeredSlides && s.autoHeight)) && t.updateSlidesProgress(e),
          n && !o && t.emit("reachBeginning toEdge"),
          a && !d && t.emit("reachEnd toEdge"),
          ((o && !n) || (d && !a)) && t.emit("fromEdge"),
          t.emit("progress", r);
      },
      updateSlidesClasses: function () {
        const e = this,
          { slides: t, params: s, slidesEl: i, activeIndex: r } = e,
          n = e.virtual && s.virtual.enabled,
          a = e => m(i, `.${s.slideClass}${e}, swiper-slide ${e}`)[0];
        let l;
        if (
          (t.forEach(e => {
            e.classList.remove(s.slideActiveClass, s.slideNextClass, s.slidePrevClass);
          }),
          n)
        )
          if (s.loop) {
            let t = r - e.virtual.slidesBefore;
            t < 0 && (t = e.virtual.slides.length + t), t >= e.virtual.slides.length && (t -= e.virtual.slides.length), (l = a(`[data-swiper-slide-index="${t}"]`));
          } else l = a(`[data-swiper-slide-index="${r}"]`);
        else l = t[r];
        if (l) {
          l.classList.add(s.slideActiveClass);
          let e = (function (e, t) {
            const s = [];
            for (; e.nextElementSibling; ) {
              const i = e.nextElementSibling;
              t ? i.matches(t) && s.push(i) : s.push(i), (e = i);
            }
            return s;
          })(l, `.${s.slideClass}, swiper-slide`)[0];
          s.loop && !e && (e = t[0]), e && e.classList.add(s.slideNextClass);
          let i = (function (e, t) {
            const s = [];
            for (; e.previousElementSibling; ) {
              const i = e.previousElementSibling;
              t ? i.matches(t) && s.push(i) : s.push(i), (e = i);
            }
            return s;
          })(l, `.${s.slideClass}, swiper-slide`)[0];
          s.loop && 0 === !i && (i = t[t.length - 1]), i && i.classList.add(s.slidePrevClass);
        }
        e.emitSlidesClasses();
      },
      updateActiveIndex: function (e) {
        const t = this,
          s = t.rtlTranslate ? t.translate : -t.translate,
          { snapGrid: i, params: r, activeIndex: n, realIndex: a, snapIndex: l } = t;
        let o,
          d = e;
        const c = e => {
          let s = e - t.virtual.slidesBefore;
          return s < 0 && (s = t.virtual.slides.length + s), s >= t.virtual.slides.length && (s -= t.virtual.slides.length), s;
        };
        if (
          (void 0 === d &&
            (d = (function (e) {
              const { slidesGrid: t, params: s } = e,
                i = e.rtlTranslate ? e.translate : -e.translate;
              let r;
              for (let n = 0; n < t.length; n += 1) void 0 !== t[n + 1] ? (i >= t[n] && i < t[n + 1] - (t[n + 1] - t[n]) / 2 ? (r = n) : i >= t[n] && i < t[n + 1] && (r = n + 1)) : i >= t[n] && (r = n);
              return s.normalizeSlideIndex && (r < 0 || void 0 === r) && (r = 0), r;
            })(t)),
          i.indexOf(s) >= 0)
        )
          o = i.indexOf(s);
        else {
          const e = Math.min(r.slidesPerGroupSkip, d);
          o = e + Math.floor((d - e) / r.slidesPerGroup);
        }
        if ((o >= i.length && (o = i.length - 1), d === n)) return o !== l && ((t.snapIndex = o), t.emit("snapIndexChange")), void (t.params.loop && t.virtual && t.params.virtual.enabled && (t.realIndex = c(d)));
        let p;
        (p = t.virtual && r.virtual.enabled && r.loop ? c(d) : t.slides[d] ? parseInt(t.slides[d].getAttribute("data-swiper-slide-index") || d, 10) : d),
          Object.assign(t, {
            previousSnapIndex: l,
            snapIndex: o,
            previousRealIndex: a,
            realIndex: p,
            previousIndex: n,
            activeIndex: d,
          }),
          t.initialized && P(t),
          t.emit("activeIndexChange"),
          t.emit("snapIndexChange"),
          a !== p && t.emit("realIndexChange"),
          (t.initialized || t.params.runCallbacksOnInit) && t.emit("slideChange");
      },
      updateClickedSlide: function (e) {
        const t = this,
          s = t.params,
          i = e.closest(`.${s.slideClass}, swiper-slide`);
        let r,
          n = !1;
        if (i)
          for (let a = 0; a < t.slides.length; a += 1)
            if (t.slides[a] === i) {
              (n = !0), (r = a);
              break;
            }
        if (!i || !n) return (t.clickedSlide = void 0), void (t.clickedIndex = void 0);
        (t.clickedSlide = i), t.virtual && t.params.virtual.enabled ? (t.clickedIndex = parseInt(i.getAttribute("data-swiper-slide-index"), 10)) : (t.clickedIndex = r), s.slideToClickedSlide && void 0 !== t.clickedIndex && t.clickedIndex !== t.activeIndex && t.slideToClickedSlide();
      },
    },
    translate: {
      getTranslate: function (e) {
        void 0 === e && (e = this.isHorizontal() ? "x" : "y");
        const { params: t, rtlTranslate: s, translate: i, wrapperEl: r } = this;
        if (t.virtualTranslate) return s ? -i : i;
        if (t.cssMode) return i;
        let n = o(r, e);
        return (n += this.cssOverflowAdjustment()), s && (n = -n), n || 0;
      },
      setTranslate: function (e, t) {
        const s = this,
          { rtlTranslate: i, params: r, wrapperEl: n, progress: a } = s;
        let l,
          o = 0,
          d = 0;
        s.isHorizontal() ? (o = i ? -e : e) : (d = e), r.roundLengths && ((o = Math.floor(o)), (d = Math.floor(d))), (s.previousTranslate = s.translate), (s.translate = s.isHorizontal() ? o : d), r.cssMode ? (n[s.isHorizontal() ? "scrollLeft" : "scrollTop"] = s.isHorizontal() ? -o : -d) : r.virtualTranslate || (s.isHorizontal() ? (o -= s.cssOverflowAdjustment()) : (d -= s.cssOverflowAdjustment()), (n.style.transform = `translate3d(${o}px, ${d}px, 0px)`));
        const c = s.maxTranslate() - s.minTranslate();
        (l = 0 === c ? 0 : (e - s.minTranslate()) / c), l !== a && s.updateProgress(e), s.emit("setTranslate", s.translate, t);
      },
      minTranslate: function () {
        return -this.snapGrid[0];
      },
      maxTranslate: function () {
        return -this.snapGrid[this.snapGrid.length - 1];
      },
      translateTo: function (e, t, s, i, r) {
        void 0 === e && (e = 0), void 0 === t && (t = this.params.speed), void 0 === s && (s = !0), void 0 === i && (i = !0);
        const n = this,
          { params: a, wrapperEl: l } = n;
        if (n.animating && a.preventInteractionOnTransition) return !1;
        const o = n.minTranslate(),
          d = n.maxTranslate();
        let c;
        if (((c = i && e > o ? o : i && e < d ? d : e), n.updateProgress(c), a.cssMode)) {
          const e = n.isHorizontal();
          if (0 === t) l[e ? "scrollLeft" : "scrollTop"] = -c;
          else {
            if (!n.support.smoothScroll)
              return (
                h({
                  swiper: n,
                  targetPosition: -c,
                  side: e ? "left" : "top",
                }),
                !0
              );
            l.scrollTo({
              [e ? "left" : "top"]: -c,
              behavior: "smooth",
            });
          }
          return !0;
        }
        return (
          0 === t
            ? (n.setTransition(0), n.setTranslate(c), s && (n.emit("beforeTransitionStart", t, r), n.emit("transitionEnd")))
            : (n.setTransition(t),
              n.setTranslate(c),
              s && (n.emit("beforeTransitionStart", t, r), n.emit("transitionStart")),
              n.animating ||
                ((n.animating = !0),
                n.onTranslateToWrapperTransitionEnd ||
                  (n.onTranslateToWrapperTransitionEnd = function (e) {
                    n && !n.destroyed && e.target === this && (n.wrapperEl.removeEventListener("transitionend", n.onTranslateToWrapperTransitionEnd), (n.onTranslateToWrapperTransitionEnd = null), delete n.onTranslateToWrapperTransitionEnd, s && n.emit("transitionEnd"));
                  }),
                n.wrapperEl.addEventListener("transitionend", n.onTranslateToWrapperTransitionEnd))),
          !0
        );
      },
    },
    transition: {
      setTransition: function (e, t) {
        const s = this;
        s.params.cssMode || (s.wrapperEl.style.transitionDuration = `${e}ms`), s.emit("setTransition", e, t);
      },
      transitionStart: function (e, t) {
        void 0 === e && (e = !0);
        const s = this,
          { params: i } = s;
        i.cssMode ||
          (i.autoHeight && s.updateAutoHeight(),
          L({
            swiper: s,
            runCallbacks: e,
            direction: t,
            step: "Start",
          }));
      },
      transitionEnd: function (e, t) {
        void 0 === e && (e = !0);
        const s = this,
          { params: i } = s;
        (s.animating = !1),
          i.cssMode ||
            (s.setTransition(0),
            L({
              swiper: s,
              runCallbacks: e,
              direction: t,
              step: "End",
            }));
      },
    },
    slide: {
      slideTo: function (e, t, s, i, r) {
        void 0 === e && (e = 0), void 0 === t && (t = this.params.speed), void 0 === s && (s = !0), "string" == typeof e && (e = parseInt(e, 10));
        const n = this;
        let a = e;
        a < 0 && (a = 0);
        const { params: l, snapGrid: o, slidesGrid: d, previousIndex: c, activeIndex: p, rtlTranslate: u, wrapperEl: m, enabled: f } = n;
        if ((n.animating && l.preventInteractionOnTransition) || (!f && !i && !r)) return !1;
        const v = Math.min(n.params.slidesPerGroupSkip, a);
        let g = v + Math.floor((a - v) / n.params.slidesPerGroup);
        g >= o.length && (g = o.length - 1);
        const w = -o[g];
        if (l.normalizeSlideIndex)
          for (let h = 0; h < d.length; h += 1) {
            const e = -Math.floor(100 * w),
              t = Math.floor(100 * d[h]),
              s = Math.floor(100 * d[h + 1]);
            void 0 !== d[h + 1] ? (e >= t && e < s - (s - t) / 2 ? (a = h) : e >= t && e < s && (a = h + 1)) : e >= t && (a = h);
          }
        if (n.initialized && a !== p) {
          if (!n.allowSlideNext && (u ? w > n.translate && w > n.minTranslate() : w < n.translate && w < n.minTranslate())) return !1;
          if (!n.allowSlidePrev && w > n.translate && w > n.maxTranslate() && (p || 0) !== a) return !1;
        }
        let T;
        if ((a !== (c || 0) && s && n.emit("beforeSlideChangeStart"), n.updateProgress(w), (T = a > p ? "next" : a < p ? "prev" : "reset"), (u && -w === n.translate) || (!u && w === n.translate))) return n.updateActiveIndex(a), l.autoHeight && n.updateAutoHeight(), n.updateSlidesClasses(), "slide" !== l.effect && n.setTranslate(w), "reset" !== T && (n.transitionStart(s, T), n.transitionEnd(s, T)), !1;
        if (l.cssMode) {
          const e = n.isHorizontal(),
            s = u ? w : -w;
          if (0 === t) {
            const t = n.virtual && n.params.virtual.enabled;
            t && ((n.wrapperEl.style.scrollSnapType = "none"), (n._immediateVirtual = !0)),
              t && !n._cssModeVirtualInitialSet && n.params.initialSlide > 0
                ? ((n._cssModeVirtualInitialSet = !0),
                  requestAnimationFrame(() => {
                    m[e ? "scrollLeft" : "scrollTop"] = s;
                  }))
                : (m[e ? "scrollLeft" : "scrollTop"] = s),
              t &&
                requestAnimationFrame(() => {
                  (n.wrapperEl.style.scrollSnapType = ""), (n._immediateVirtual = !1);
                });
          } else {
            if (!n.support.smoothScroll)
              return (
                h({
                  swiper: n,
                  targetPosition: s,
                  side: e ? "left" : "top",
                }),
                !0
              );
            m.scrollTo({
              [e ? "left" : "top"]: s,
              behavior: "smooth",
            });
          }
          return !0;
        }
        return (
          n.setTransition(t),
          n.setTranslate(w),
          n.updateActiveIndex(a),
          n.updateSlidesClasses(),
          n.emit("beforeTransitionStart", t, i),
          n.transitionStart(s, T),
          0 === t
            ? n.transitionEnd(s, T)
            : n.animating ||
              ((n.animating = !0),
              n.onSlideToWrapperTransitionEnd ||
                (n.onSlideToWrapperTransitionEnd = function (e) {
                  n && !n.destroyed && e.target === this && (n.wrapperEl.removeEventListener("transitionend", n.onSlideToWrapperTransitionEnd), (n.onSlideToWrapperTransitionEnd = null), delete n.onSlideToWrapperTransitionEnd, n.transitionEnd(s, T));
                }),
              n.wrapperEl.addEventListener("transitionend", n.onSlideToWrapperTransitionEnd)),
          !0
        );
      },
      slideToLoop: function (e, t, s, i) {
        if ((void 0 === e && (e = 0), void 0 === t && (t = this.params.speed), void 0 === s && (s = !0), "string" == typeof e)) {
          e = parseInt(e, 10);
        }
        const r = this;
        let n = e;
        return r.params.loop && (r.virtual && r.params.virtual.enabled ? (n += r.virtual.slidesBefore) : (n = r.getSlideIndexByData(n))), r.slideTo(n, t, s, i);
      },
      slideNext: function (e, t, s) {
        void 0 === e && (e = this.params.speed), void 0 === t && (t = !0);
        const i = this,
          { enabled: r, params: n, animating: a } = i;
        if (!r) return i;
        let l = n.slidesPerGroup;
        "auto" === n.slidesPerView && 1 === n.slidesPerGroup && n.slidesPerGroupAuto && (l = Math.max(i.slidesPerViewDynamic("current", !0), 1));
        const o = i.activeIndex < n.slidesPerGroupSkip ? 1 : l,
          d = i.virtual && n.virtual.enabled;
        if (n.loop) {
          if (a && !d && n.loopPreventsSliding) return !1;
          i.loopFix({
            direction: "next",
          }),
            (i._clientLeft = i.wrapperEl.clientLeft);
        }
        return n.rewind && i.isEnd ? i.slideTo(0, e, t, s) : i.slideTo(i.activeIndex + o, e, t, s);
      },
      slidePrev: function (e, t, s) {
        void 0 === e && (e = this.params.speed), void 0 === t && (t = !0);
        const i = this,
          { params: r, snapGrid: n, slidesGrid: a, rtlTranslate: l, enabled: o, animating: d } = i;
        if (!o) return i;
        const c = i.virtual && r.virtual.enabled;
        if (r.loop) {
          if (d && !c && r.loopPreventsSliding) return !1;
          i.loopFix({
            direction: "prev",
          }),
            (i._clientLeft = i.wrapperEl.clientLeft);
        }
        function p(e) {
          return e < 0 ? -Math.floor(Math.abs(e)) : Math.floor(e);
        }
        const u = p(l ? i.translate : -i.translate),
          h = n.map(e => p(e));
        let m = n[h.indexOf(u) - 1];
        if (void 0 === m && r.cssMode) {
          let e;
          n.forEach((t, s) => {
            u >= t && (e = s);
          }),
            void 0 !== e && (m = n[e > 0 ? e - 1 : e]);
        }
        let f = 0;
        if ((void 0 !== m && ((f = a.indexOf(m)), f < 0 && (f = i.activeIndex - 1), "auto" === r.slidesPerView && 1 === r.slidesPerGroup && r.slidesPerGroupAuto && ((f = f - i.slidesPerViewDynamic("previous", !0) + 1), (f = Math.max(f, 0)))), r.rewind && i.isBeginning)) {
          const r = i.params.virtual && i.params.virtual.enabled && i.virtual ? i.virtual.slides.length - 1 : i.slides.length - 1;
          return i.slideTo(r, e, t, s);
        }
        return i.slideTo(f, e, t, s);
      },
      slideReset: function (e, t, s) {
        return void 0 === e && (e = this.params.speed), void 0 === t && (t = !0), this.slideTo(this.activeIndex, e, t, s);
      },
      slideToClosest: function (e, t, s, i) {
        void 0 === e && (e = this.params.speed), void 0 === t && (t = !0), void 0 === i && (i = 0.5);
        const r = this;
        let n = r.activeIndex;
        const a = Math.min(r.params.slidesPerGroupSkip, n),
          l = a + Math.floor((n - a) / r.params.slidesPerGroup),
          o = r.rtlTranslate ? r.translate : -r.translate;
        if (o >= r.snapGrid[l]) {
          const e = r.snapGrid[l];
          o - e > (r.snapGrid[l + 1] - e) * i && (n += r.params.slidesPerGroup);
        } else {
          const e = r.snapGrid[l - 1];
          o - e <= (r.snapGrid[l] - e) * i && (n -= r.params.slidesPerGroup);
        }
        return (n = Math.max(n, 0)), (n = Math.min(n, r.slidesGrid.length - 1)), r.slideTo(n, e, t, s);
      },
      slideToClickedSlide: function () {
        const e = this,
          { params: t, slidesEl: s } = e,
          i = "auto" === t.slidesPerView ? e.slidesPerViewDynamic() : t.slidesPerView;
        let r,
          n = e.clickedIndex;
        const l = e.isElement ? "swiper-slide" : `.${t.slideClass}`;
        if (t.loop) {
          if (e.animating) return;
          (r = parseInt(e.clickedSlide.getAttribute("data-swiper-slide-index"), 10)),
            t.centeredSlides
              ? n < e.loopedSlides - i / 2 || n > e.slides.length - e.loopedSlides + i / 2
                ? (e.loopFix(),
                  (n = e.getSlideIndex(m(s, `${l}[data-swiper-slide-index="${r}"]`)[0])),
                  a(() => {
                    e.slideTo(n);
                  }))
                : e.slideTo(n)
              : n > e.slides.length - i
              ? (e.loopFix(),
                (n = e.getSlideIndex(m(s, `${l}[data-swiper-slide-index="${r}"]`)[0])),
                a(() => {
                  e.slideTo(n);
                }))
              : e.slideTo(n);
        } else e.slideTo(n);
      },
    },
    loop: {
      loopCreate: function (e) {
        const t = this,
          { params: s, slidesEl: i } = t;
        if (!s.loop || (t.virtual && t.params.virtual.enabled)) return;
        m(i, `.${s.slideClass}, swiper-slide`).forEach((e, t) => {
          e.setAttribute("data-swiper-slide-index", t);
        }),
          t.loopFix({
            slideRealIndex: e,
            direction: s.centeredSlides ? void 0 : "next",
          });
      },
      loopFix: function (e) {
        let { slideRealIndex: t, slideTo: s = !0, direction: i, setTranslate: r, activeSlideIndex: n, byController: a, byMousewheel: l } = void 0 === e ? {} : e;
        const o = this;
        if (!o.params.loop) return;
        o.emit("beforeLoopFix");
        const { slides: d, allowSlidePrev: c, allowSlideNext: p, slidesEl: u, params: h } = o;
        if (((o.allowSlidePrev = !0), (o.allowSlideNext = !0), o.virtual && h.virtual.enabled)) return s && (h.centeredSlides || 0 !== o.snapIndex ? (h.centeredSlides && o.snapIndex < h.slidesPerView ? o.slideTo(o.virtual.slides.length + o.snapIndex, 0, !1, !0) : o.snapIndex === o.snapGrid.length - 1 && o.slideTo(o.virtual.slidesBefore, 0, !1, !0)) : o.slideTo(o.virtual.slides.length, 0, !1, !0)), (o.allowSlidePrev = c), (o.allowSlideNext = p), void o.emit("loopFix");
        const m = "auto" === h.slidesPerView ? o.slidesPerViewDynamic() : Math.ceil(parseFloat(h.slidesPerView, 10));
        let f = h.loopedSlides || m;
        f % h.slidesPerGroup != 0 && (f += h.slidesPerGroup - (f % h.slidesPerGroup)), (o.loopedSlides = f);
        const v = [],
          g = [];
        let w = o.activeIndex;
        void 0 === n ? (n = o.getSlideIndex(o.slides.filter(e => e.classList.contains(h.slideActiveClass))[0])) : (w = n);
        const T = "next" === i || !i,
          b = "prev" === i || !i;
        let S = 0,
          x = 0;
        if (n < f) {
          S = Math.max(f - n, h.slidesPerGroup);
          for (let e = 0; e < f - n; e += 1) {
            const t = e - Math.floor(e / d.length) * d.length;
            v.push(d.length - t - 1);
          }
        } else if (n > o.slides.length - 2 * f) {
          x = Math.max(n - (o.slides.length - 2 * f), h.slidesPerGroup);
          for (let e = 0; e < x; e += 1) {
            const t = e - Math.floor(e / d.length) * d.length;
            g.push(t);
          }
        }
        if (
          (b &&
            v.forEach(e => {
              (o.slides[e].swiperLoopMoveDOM = !0), u.prepend(o.slides[e]), (o.slides[e].swiperLoopMoveDOM = !1);
            }),
          T &&
            g.forEach(e => {
              (o.slides[e].swiperLoopMoveDOM = !0), u.append(o.slides[e]), (o.slides[e].swiperLoopMoveDOM = !1);
            }),
          o.recalcSlides(),
          "auto" === h.slidesPerView && o.updateSlides(),
          h.watchSlidesProgress && o.updateSlidesOffset(),
          s)
        )
          if (v.length > 0 && b)
            if (void 0 === t) {
              const e = o.slidesGrid[w],
                t = o.slidesGrid[w + S] - e;
              l ? o.setTranslate(o.translate - t) : (o.slideTo(w + S, 0, !1, !0), r && (o.touches[o.isHorizontal() ? "startX" : "startY"] += t));
            } else r && o.slideToLoop(t, 0, !1, !0);
          else if (g.length > 0 && T)
            if (void 0 === t) {
              const e = o.slidesGrid[w],
                t = o.slidesGrid[w - x] - e;
              l ? o.setTranslate(o.translate - t) : (o.slideTo(w - x, 0, !1, !0), r && (o.touches[o.isHorizontal() ? "startX" : "startY"] += t));
            } else o.slideToLoop(t, 0, !1, !0);
        if (((o.allowSlidePrev = c), (o.allowSlideNext = p), o.controller && o.controller.control && !a)) {
          const e = {
            slideRealIndex: t,
            slideTo: !1,
            direction: i,
            setTranslate: r,
            activeSlideIndex: n,
            byController: !0,
          };
          Array.isArray(o.controller.control)
            ? o.controller.control.forEach(t => {
                !t.destroyed && t.params.loop && t.loopFix(e);
              })
            : o.controller.control instanceof o.constructor && o.controller.control.params.loop && o.controller.control.loopFix(e);
        }
        o.emit("loopFix");
      },
      loopDestroy: function () {
        const e = this,
          { params: t, slidesEl: s } = e;
        if (!t.loop || (e.virtual && e.params.virtual.enabled)) return;
        e.recalcSlides();
        const i = [];
        e.slides.forEach(e => {
          const t = void 0 === e.swiperSlideIndex ? 1 * e.getAttribute("data-swiper-slide-index") : e.swiperSlideIndex;
          i[t] = e;
        }),
          e.slides.forEach(e => {
            e.removeAttribute("data-swiper-slide-index");
          }),
          i.forEach(e => {
            s.append(e);
          }),
          e.recalcSlides(),
          e.slideTo(e.realIndex, 0);
      },
    },
    grabCursor: {
      setGrabCursor: function (e) {
        const t = this;
        if (!t.params.simulateTouch || (t.params.watchOverflow && t.isLocked) || t.params.cssMode) return;
        const s = "container" === t.params.touchEventsTarget ? t.el : t.wrapperEl;
        t.isElement && (t.__preventObserver__ = !0),
          (s.style.cursor = "move"),
          (s.style.cursor = e ? "grabbing" : "grab"),
          t.isElement &&
            requestAnimationFrame(() => {
              t.__preventObserver__ = !1;
            });
      },
      unsetGrabCursor: function () {
        const e = this;
        (e.params.watchOverflow && e.isLocked) ||
          e.params.cssMode ||
          (e.isElement && (e.__preventObserver__ = !0),
          (e["container" === e.params.touchEventsTarget ? "el" : "wrapperEl"].style.cursor = ""),
          e.isElement &&
            requestAnimationFrame(() => {
              e.__preventObserver__ = !1;
            }));
      },
    },
    events: {
      attachEvents: function () {
        const e = this,
          t = i(),
          { params: s } = e;
        (e.onTouchStart = k.bind(e)), (e.onTouchMove = O.bind(e)), (e.onTouchEnd = I.bind(e)), s.cssMode && (e.onScroll = G.bind(e)), (e.onClick = A.bind(e)), (e.onLoad = D.bind(e)), _ || (t.addEventListener("touchstart", V), (_ = !0)), N(e, "on");
      },
      detachEvents: function () {
        N(this, "off");
      },
    },
    breakpoints: {
      setBreakpoint: function () {
        const e = this,
          { realIndex: t, initialized: s, params: i, el: r } = e,
          n = i.breakpoints;
        if (!n || (n && 0 === Object.keys(n).length)) return;
        const a = e.getBreakpoint(n, e.params.breakpointsBase, e.el);
        if (!a || e.currentBreakpoint === a) return;
        const l = (a in n ? n[a] : void 0) || e.originalParams,
          o = B(e, i),
          d = B(e, l),
          c = i.enabled;
        o && !d ? (r.classList.remove(`${i.containerModifierClass}grid`, `${i.containerModifierClass}grid-column`), e.emitContainerClasses()) : !o && d && (r.classList.add(`${i.containerModifierClass}grid`), ((l.grid.fill && "column" === l.grid.fill) || (!l.grid.fill && "column" === i.grid.fill)) && r.classList.add(`${i.containerModifierClass}grid-column`), e.emitContainerClasses()),
          ["navigation", "pagination", "scrollbar"].forEach(t => {
            if (void 0 === l[t]) return;
            const s = i[t] && i[t].enabled,
              r = l[t] && l[t].enabled;
            s && !r && e[t].disable(), !s && r && e[t].enable();
          });
        const u = l.direction && l.direction !== i.direction,
          h = i.loop && (l.slidesPerView !== i.slidesPerView || u);
        u && s && e.changeDirection(), p(e.params, l);
        const m = e.params.enabled;
        Object.assign(e, {
          allowTouchMove: e.params.allowTouchMove,
          allowSlideNext: e.params.allowSlideNext,
          allowSlidePrev: e.params.allowSlidePrev,
        }),
          c && !m ? e.disable() : !c && m && e.enable(),
          (e.currentBreakpoint = a),
          e.emit("_beforeBreakpoint", l),
          h && s && (e.loopDestroy(), e.loopCreate(t), e.updateSlides()),
          e.emit("breakpoint", l);
      },
      getBreakpoint: function (e, t, s) {
        if ((void 0 === t && (t = "window"), !e || ("container" === t && !s))) return;
        let i = !1;
        const r = n(),
          a = "window" === t ? r.innerHeight : s.clientHeight,
          l = Object.keys(e).map(e => {
            if ("string" == typeof e && 0 === e.indexOf("@")) {
              const t = parseFloat(e.substr(1));
              return {
                value: a * t,
                point: e,
              };
            }
            return {
              value: e,
              point: e,
            };
          });
        l.sort((e, t) => parseInt(e.value, 10) - parseInt(t.value, 10));
        for (let n = 0; n < l.length; n += 1) {
          const { point: e, value: a } = l[n];
          "window" === t ? r.matchMedia(`(min-width: ${a}px)`).matches && (i = e) : a <= s.clientWidth && (i = e);
        }
        return i || "max";
      },
    },
    checkOverflow: {
      checkOverflow: function () {
        const e = this,
          { isLocked: t, params: s } = e,
          { slidesOffsetBefore: i } = s;
        if (i) {
          const t = e.slides.length - 1,
            s = e.slidesGrid[t] + e.slidesSizesGrid[t] + 2 * i;
          e.isLocked = e.size > s;
        } else e.isLocked = 1 === e.snapGrid.length;
        !0 === s.allowSlideNext && (e.allowSlideNext = !e.isLocked), !0 === s.allowSlidePrev && (e.allowSlidePrev = !e.isLocked), t && t !== e.isLocked && (e.isEnd = !1), t !== e.isLocked && e.emit(e.isLocked ? "lock" : "unlock");
      },
    },
    classes: {
      addClasses: function () {
        const e = this,
          { classNames: t, params: s, rtl: i, el: r, device: n } = e,
          a = (function (e, t) {
            const s = [];
            return (
              e.forEach(e => {
                "object" == typeof e
                  ? Object.keys(e).forEach(i => {
                      e[i] && s.push(t + i);
                    })
                  : "string" == typeof e && s.push(t + e);
              }),
              s
            );
          })(
            [
              "initialized",
              s.direction,
              {
                "free-mode": e.params.freeMode && s.freeMode.enabled,
              },
              {
                autoheight: s.autoHeight,
              },
              {
                rtl: i,
              },
              {
                grid: s.grid && s.grid.rows > 1,
              },
              {
                "grid-column": s.grid && s.grid.rows > 1 && "column" === s.grid.fill,
              },
              {
                android: n.android,
              },
              {
                ios: n.ios,
              },
              {
                "css-mode": s.cssMode,
              },
              {
                centered: s.cssMode && s.centeredSlides,
              },
              {
                "watch-progress": s.watchSlidesProgress,
              },
            ],
            s.containerModifierClass
          );
        t.push(...a), r.classList.add(...t), e.emitContainerClasses();
      },
      removeClasses: function () {
        const { el: e, classNames: t } = this;
        e.classList.remove(...t), this.emitContainerClasses();
      },
    },
  },
  j = {};
class X {
  constructor() {
    let e, t;
    for (var s = arguments.length, r = new Array(s), n = 0; n < s; n++) r[n] = arguments[n];
    1 === r.length && r[0].constructor && "Object" === Object.prototype.toString.call(r[0]).slice(8, -1) ? (t = r[0]) : ([e, t] = r), t || (t = {}), (t = p({}, t)), e && !t.el && (t.el = e);
    const a = i();
    if (t.el && "string" == typeof t.el && a.querySelectorAll(t.el).length > 1) {
      const e = [];
      return (
        a.querySelectorAll(t.el).forEach(s => {
          const i = p({}, t, {
            el: s,
          });
          e.push(new X(i));
        }),
        e
      );
    }
    const l = this;
    (l.__swiper__ = !0),
      (l.support = x()),
      (l.device = y({
        userAgent: t.userAgent,
      })),
      (l.browser = E()),
      (l.eventsListeners = {}),
      (l.eventsAnyListeners = []),
      (l.modules = [...l.__modules__]),
      t.modules && Array.isArray(t.modules) && l.modules.push(...t.modules);
    const o = {};
    l.modules.forEach(e => {
      e({
        params: t,
        swiper: l,
        extendParams: H(t, o),
        on: l.on.bind(l),
        once: l.once.bind(l),
        off: l.off.bind(l),
        emit: l.emit.bind(l),
      });
    });
    const d = p({}, F, o);
    return (
      (l.params = p({}, d, j, t)),
      (l.originalParams = p({}, l.params)),
      (l.passedParams = p({}, t)),
      l.params &&
        l.params.on &&
        Object.keys(l.params.on).forEach(e => {
          l.on(e, l.params.on[e]);
        }),
      l.params && l.params.onAny && l.onAny(l.params.onAny),
      Object.assign(l, {
        enabled: l.params.enabled,
        el: e,
        classNames: [],
        slides: [],
        slidesGrid: [],
        snapGrid: [],
        slidesSizesGrid: [],
        isHorizontal: () => "horizontal" === l.params.direction,
        isVertical: () => "vertical" === l.params.direction,
        activeIndex: 0,
        realIndex: 0,
        isBeginning: !0,
        isEnd: !1,
        translate: 0,
        previousTranslate: 0,
        progress: 0,
        velocity: 0,
        animating: !1,
        cssOverflowAdjustment() {
          return Math.trunc(this.translate / 2 ** 23) * 2 ** 23;
        },
        allowSlideNext: l.params.allowSlideNext,
        allowSlidePrev: l.params.allowSlidePrev,
        touchEventsData: {
          isTouched: void 0,
          isMoved: void 0,
          allowTouchCallbacks: void 0,
          touchStartTime: void 0,
          isScrolling: void 0,
          currentTranslate: void 0,
          startTranslate: void 0,
          allowThresholdMove: void 0,
          focusableElements: l.params.focusableElements,
          lastClickTime: 0,
          clickTimeout: void 0,
          velocities: [],
          allowMomentumBounce: void 0,
          startMoving: void 0,
          evCache: [],
        },
        allowClick: !0,
        allowTouchMove: l.params.allowTouchMove,
        touches: {
          startX: 0,
          startY: 0,
          currentX: 0,
          currentY: 0,
          diff: 0,
        },
        imagesToLoad: [],
        imagesLoaded: 0,
      }),
      l.emit("_swiper"),
      l.params.init && l.init(),
      l
    );
  }
  getSlideIndex(e) {
    const { slidesEl: t, params: s } = this,
      i = v(m(t, `.${s.slideClass}, swiper-slide`)[0]);
    return v(e) - i;
  }
  getSlideIndexByData(e) {
    return this.getSlideIndex(this.slides.filter(t => 1 * t.getAttribute("data-swiper-slide-index") === e)[0]);
  }
  recalcSlides() {
    const { slidesEl: e, params: t } = this;
    this.slides = m(e, `.${t.slideClass}, swiper-slide`);
  }
  enable() {
    const e = this;
    e.enabled || ((e.enabled = !0), e.params.grabCursor && e.setGrabCursor(), e.emit("enable"));
  }
  disable() {
    const e = this;
    e.enabled && ((e.enabled = !1), e.params.grabCursor && e.unsetGrabCursor(), e.emit("disable"));
  }
  setProgress(e, t) {
    const s = this;
    e = Math.min(Math.max(e, 0), 1);
    const i = s.minTranslate(),
      r = (s.maxTranslate() - i) * e + i;
    s.translateTo(r, void 0 === t ? 0 : t), s.updateActiveIndex(), s.updateSlidesClasses();
  }
  emitContainerClasses() {
    const e = this;
    if (!e.params._emitClasses || !e.el) return;
    const t = e.el.className.split(" ").filter(t => 0 === t.indexOf("swiper") || 0 === t.indexOf(e.params.containerModifierClass));
    e.emit("_containerClasses", t.join(" "));
  }
  getSlideClasses(e) {
    const t = this;
    return t.destroyed
      ? ""
      : e.className
          .split(" ")
          .filter(e => 0 === e.indexOf("swiper-slide") || 0 === e.indexOf(t.params.slideClass))
          .join(" ");
  }
  emitSlidesClasses() {
    const e = this;
    if (!e.params._emitClasses || !e.el) return;
    const t = [];
    e.slides.forEach(s => {
      const i = e.getSlideClasses(s);
      t.push({
        slideEl: s,
        classNames: i,
      }),
        e.emit("_slideClass", s, i);
    }),
      e.emit("_slideClasses", t);
  }
  slidesPerViewDynamic(e, t) {
    void 0 === e && (e = "current"), void 0 === t && (t = !1);
    const { params: s, slides: i, slidesGrid: r, slidesSizesGrid: n, size: a, activeIndex: l } = this;
    let o = 1;
    if (s.centeredSlides) {
      let e,
        t = i[l] ? i[l].swiperSlideSize : 0;
      for (let s = l + 1; s < i.length; s += 1) i[s] && !e && ((t += i[s].swiperSlideSize), (o += 1), t > a && (e = !0));
      for (let s = l - 1; s >= 0; s -= 1) i[s] && !e && ((t += i[s].swiperSlideSize), (o += 1), t > a && (e = !0));
    } else if ("current" === e)
      for (let d = l + 1; d < i.length; d += 1) {
        (t ? r[d] + n[d] - r[l] < a : r[d] - r[l] < a) && (o += 1);
      }
    else
      for (let d = l - 1; d >= 0; d -= 1) {
        r[l] - r[d] < a && (o += 1);
      }
    return o;
  }
  update() {
    const e = this;
    if (!e || e.destroyed) return;
    const { snapGrid: t, params: s } = e;
    function i() {
      const t = e.rtlTranslate ? -1 * e.translate : e.translate,
        s = Math.min(Math.max(t, e.maxTranslate()), e.minTranslate());
      e.setTranslate(s), e.updateActiveIndex(), e.updateSlidesClasses();
    }
    let r;
    if (
      (s.breakpoints && e.setBreakpoint(),
      [...e.el.querySelectorAll('[loading="lazy"]')].forEach(t => {
        t.complete && M(e, t);
      }),
      e.updateSize(),
      e.updateSlides(),
      e.updateProgress(),
      e.updateSlidesClasses(),
      s.freeMode && s.freeMode.enabled && !s.cssMode)
    )
      i(), s.autoHeight && e.updateAutoHeight();
    else {
      if (("auto" === s.slidesPerView || s.slidesPerView > 1) && e.isEnd && !s.centeredSlides) {
        const t = e.virtual && s.virtual.enabled ? e.virtual.slides : e.slides;
        r = e.slideTo(t.length - 1, 0, !1, !0);
      } else r = e.slideTo(e.activeIndex, 0, !1, !0);
      r || i();
    }
    s.watchOverflow && t !== e.snapGrid && e.checkOverflow(), e.emit("update");
  }
  changeDirection(e, t) {
    void 0 === t && (t = !0);
    const s = this,
      i = s.params.direction;
    return (
      e || (e = "horizontal" === i ? "vertical" : "horizontal"),
      e === i ||
        ("horizontal" !== e && "vertical" !== e) ||
        (s.el.classList.remove(`${s.params.containerModifierClass}${i}`),
        s.el.classList.add(`${s.params.containerModifierClass}${e}`),
        s.emitContainerClasses(),
        (s.params.direction = e),
        s.slides.forEach(t => {
          "vertical" === e ? (t.style.width = "") : (t.style.height = "");
        }),
        s.emit("changeDirection"),
        t && s.update()),
      s
    );
  }
  changeLanguageDirection(e) {
    const t = this;
    (t.rtl && "rtl" === e) || (!t.rtl && "ltr" === e) || ((t.rtl = "rtl" === e), (t.rtlTranslate = "horizontal" === t.params.direction && t.rtl), t.rtl ? (t.el.classList.add(`${t.params.containerModifierClass}rtl`), (t.el.dir = "rtl")) : (t.el.classList.remove(`${t.params.containerModifierClass}rtl`), (t.el.dir = "ltr")), t.update());
  }
  mount(e) {
    const t = this;
    if (t.mounted) return !0;
    let s = e || t.params.el;
    if (("string" == typeof s && (s = document.querySelector(s)), !s)) return !1;
    (s.swiper = t), s.parentNode && s.parentNode.host && (t.isElement = !0);
    const i = () => `.${(t.params.wrapperClass || "").trim().split(" ").join(".")}`;
    let r = (() => {
      if (s && s.shadowRoot && s.shadowRoot.querySelector) {
        return s.shadowRoot.querySelector(i());
      }
      return m(s, i())[0];
    })();
    return (
      !r &&
        t.params.createElements &&
        ((r = (function (e, t) {
          void 0 === t && (t = []);
          const s = document.createElement(e);
          return s.classList.add(...(Array.isArray(t) ? t : [t])), s;
        })("div", t.params.wrapperClass)),
        s.append(r),
        m(s, `.${t.params.slideClass}`).forEach(e => {
          r.append(e);
        })),
      Object.assign(t, {
        el: s,
        wrapperEl: r,
        slidesEl: t.isElement ? s.parentNode.host : r,
        hostEl: t.isElement ? s.parentNode.host : s,
        mounted: !0,
        rtl: "rtl" === s.dir.toLowerCase() || "rtl" === f(s, "direction"),
        rtlTranslate: "horizontal" === t.params.direction && ("rtl" === s.dir.toLowerCase() || "rtl" === f(s, "direction")),
        wrongRTL: "-webkit-box" === f(r, "display"),
      }),
      !0
    );
  }
  init(e) {
    const t = this;
    if (t.initialized) return t;
    return (
      !1 === t.mount(e) ||
        (t.emit("beforeInit"),
        t.params.breakpoints && t.setBreakpoint(),
        t.addClasses(),
        t.updateSize(),
        t.updateSlides(),
        t.params.watchOverflow && t.checkOverflow(),
        t.params.grabCursor && t.enabled && t.setGrabCursor(),
        t.params.loop && t.virtual && t.params.virtual.enabled ? t.slideTo(t.params.initialSlide + t.virtual.slidesBefore, 0, t.params.runCallbacksOnInit, !1, !0) : t.slideTo(t.params.initialSlide, 0, t.params.runCallbacksOnInit, !1, !0),
        t.params.loop && t.loopCreate(),
        t.attachEvents(),
        [...t.el.querySelectorAll('[loading="lazy"]')].forEach(e => {
          e.complete
            ? M(t, e)
            : e.addEventListener("load", e => {
                M(t, e.target);
              });
        }),
        P(t),
        (t.initialized = !0),
        P(t),
        t.emit("init"),
        t.emit("afterInit")),
      t
    );
  }
  destroy(e, t) {
    void 0 === e && (e = !0), void 0 === t && (t = !0);
    const s = this,
      { params: i, el: r, wrapperEl: n, slides: a } = s;
    return (
      void 0 === s.params ||
        s.destroyed ||
        (s.emit("beforeDestroy"),
        (s.initialized = !1),
        s.detachEvents(),
        i.loop && s.loopDestroy(),
        t &&
          (s.removeClasses(),
          r.removeAttribute("style"),
          n.removeAttribute("style"),
          a &&
            a.length &&
            a.forEach(e => {
              e.classList.remove(i.slideVisibleClass, i.slideActiveClass, i.slideNextClass, i.slidePrevClass), e.removeAttribute("style"), e.removeAttribute("data-swiper-slide-index");
            })),
        s.emit("destroy"),
        Object.keys(s.eventsListeners).forEach(e => {
          s.off(e);
        }),
        !1 !== e &&
          ((s.el.swiper = null),
          (function (e) {
            const t = e;
            Object.keys(t).forEach(e => {
              try {
                t[e] = null;
              } catch (s) {}
              try {
                delete t[e];
              } catch (s) {}
            });
          })(s)),
        (s.destroyed = !0)),
      null
    );
  }
  static extendDefaults(e) {
    p(j, e);
  }
  static get extendedDefaults() {
    return j;
  }
  static get defaults() {
    return F;
  }
  static installModule(e) {
    X.prototype.__modules__ || (X.prototype.__modules__ = []);
    const t = X.prototype.__modules__;
    "function" == typeof e && t.indexOf(e) < 0 && t.push(e);
  }
  static use(e) {
    return Array.isArray(e) ? (e.forEach(e => X.installModule(e)), X) : (X.installModule(e), X);
  }
}
function Y(e) {
  let { swiper: t, extendParams: s, on: r, emit: a } = e;
  const l = i(),
    o = n();
  function d(e) {
    if (!t.enabled) return;
    const { rtlTranslate: s } = t;
    let r = e;
    r.originalEvent && (r = r.originalEvent);
    const d = r.keyCode || r.charCode,
      c = t.params.keyboard.pageUpDown,
      p = c && 33 === d,
      u = c && 34 === d,
      h = 37 === d,
      m = 39 === d,
      f = 38 === d,
      v = 40 === d;
    if (!t.allowSlideNext && ((t.isHorizontal() && m) || (t.isVertical() && v) || u)) return !1;
    if (!t.allowSlidePrev && ((t.isHorizontal() && h) || (t.isVertical() && f) || p)) return !1;
    if (!(r.shiftKey || r.altKey || r.ctrlKey || r.metaKey || (l.activeElement && l.activeElement.nodeName && ("input" === l.activeElement.nodeName.toLowerCase() || "textarea" === l.activeElement.nodeName.toLowerCase())))) {
      if (t.params.keyboard.onlyInViewport && (p || u || h || m || f || v)) {
        let e = !1;
        if (g(t.el, `.${t.params.slideClass}, swiper-slide`).length > 0 && 0 === g(t.el, `.${t.params.slideActiveClass}`).length) return;
        const r = t.el,
          a = r.clientWidth,
          l = r.clientHeight,
          d = o.innerWidth,
          c = o.innerHeight,
          p = (function (e) {
            const t = n(),
              s = i(),
              r = e.getBoundingClientRect(),
              a = s.body,
              l = e.clientTop || a.clientTop || 0,
              o = e.clientLeft || a.clientLeft || 0,
              d = e === t ? t.scrollY : e.scrollTop,
              c = e === t ? t.scrollX : e.scrollLeft;
            return {
              top: r.top + d - l,
              left: r.left + c - o,
            };
          })(r);
        s && (p.left -= r.scrollLeft);
        const u = [
          [p.left, p.top],
          [p.left + a, p.top],
          [p.left, p.top + l],
          [p.left + a, p.top + l],
        ];
        for (let t = 0; t < u.length; t += 1) {
          const s = u[t];
          if (s[0] >= 0 && s[0] <= d && s[1] >= 0 && s[1] <= c) {
            if (0 === s[0] && 0 === s[1]) continue;
            e = !0;
          }
        }
        if (!e) return;
      }
      t.isHorizontal() ? ((p || u || h || m) && (r.preventDefault ? r.preventDefault() : (r.returnValue = !1)), (((u || m) && !s) || ((p || h) && s)) && t.slideNext(), (((p || h) && !s) || ((u || m) && s)) && t.slidePrev()) : ((p || u || f || v) && (r.preventDefault ? r.preventDefault() : (r.returnValue = !1)), (u || v) && t.slideNext(), (p || f) && t.slidePrev()), a("keyPress", d);
    }
  }
  function c() {
    t.keyboard.enabled || (l.addEventListener("keydown", d), (t.keyboard.enabled = !0));
  }
  function p() {
    t.keyboard.enabled && (l.removeEventListener("keydown", d), (t.keyboard.enabled = !1));
  }
  (t.keyboard = {
    enabled: !1,
  }),
    s({
      keyboard: {
        enabled: !1,
        onlyInViewport: !0,
        pageUpDown: !0,
      },
    }),
    r("init", () => {
      t.params.keyboard.enabled && c();
    }),
    r("destroy", () => {
      t.keyboard.enabled && p();
    }),
    Object.assign(t.keyboard, {
      enable: c,
      disable: p,
    });
}
function W(e) {
  let { swiper: t, extendParams: s, on: i, emit: r } = e;
  const o = n();
  let d;
  s({
    mousewheel: {
      enabled: !1,
      releaseOnEdges: !1,
      invert: !1,
      forceToAxis: !1,
      sensitivity: 1,
      eventsTarget: "container",
      thresholdDelta: null,
      thresholdTime: null,
      noMousewheelClass: "swiper-no-mousewheel",
    },
  }),
    (t.mousewheel = {
      enabled: !1,
    });
  let c,
    p = l();
  const u = [];
  function h() {
    t.enabled && (t.mouseEntered = !0);
  }
  function m() {
    t.enabled && (t.mouseEntered = !1);
  }
  function f(e) {
    return !(t.params.mousewheel.thresholdDelta && e.delta < t.params.mousewheel.thresholdDelta) && !(t.params.mousewheel.thresholdTime && l() - p < t.params.mousewheel.thresholdTime) && ((e.delta >= 6 && l() - p < 60) || (e.direction < 0 ? (t.isEnd && !t.params.loop) || t.animating || (t.slideNext(), r("scroll", e.raw)) : (t.isBeginning && !t.params.loop) || t.animating || (t.slidePrev(), r("scroll", e.raw)), (p = new o.Date().getTime()), !1));
  }
  function v(e) {
    let s = e,
      i = !0;
    if (!t.enabled) return;
    if (e.target.closest(`.${t.params.mousewheel.noMousewheelClass}`)) return;
    const n = t.params.mousewheel;
    t.params.cssMode && s.preventDefault();
    let o = t.el;
    "container" !== t.params.mousewheel.eventsTarget && (o = document.querySelector(t.params.mousewheel.eventsTarget));
    const p = o && o.contains(s.target);
    if (!t.mouseEntered && !p && !n.releaseOnEdges) return !0;
    s.originalEvent && (s = s.originalEvent);
    let h = 0;
    const m = t.rtlTranslate ? -1 : 1,
      v = (function (e) {
        let t = 0,
          s = 0,
          i = 0,
          r = 0;
        return (
          "detail" in e && (s = e.detail),
          "wheelDelta" in e && (s = -e.wheelDelta / 120),
          "wheelDeltaY" in e && (s = -e.wheelDeltaY / 120),
          "wheelDeltaX" in e && (t = -e.wheelDeltaX / 120),
          "axis" in e && e.axis === e.HORIZONTAL_AXIS && ((t = s), (s = 0)),
          (i = 10 * t),
          (r = 10 * s),
          "deltaY" in e && (r = e.deltaY),
          "deltaX" in e && (i = e.deltaX),
          e.shiftKey && !i && ((i = r), (r = 0)),
          (i || r) && e.deltaMode && (1 === e.deltaMode ? ((i *= 40), (r *= 40)) : ((i *= 800), (r *= 800))),
          i && !t && (t = i < 1 ? -1 : 1),
          r && !s && (s = r < 1 ? -1 : 1),
          {
            spinX: t,
            spinY: s,
            pixelX: i,
            pixelY: r,
          }
        );
      })(s);
    if (n.forceToAxis)
      if (t.isHorizontal()) {
        if (!(Math.abs(v.pixelX) > Math.abs(v.pixelY))) return !0;
        h = -v.pixelX * m;
      } else {
        if (!(Math.abs(v.pixelY) > Math.abs(v.pixelX))) return !0;
        h = -v.pixelY;
      }
    else h = Math.abs(v.pixelX) > Math.abs(v.pixelY) ? -v.pixelX * m : -v.pixelY;
    if (0 === h) return !0;
    n.invert && (h = -h);
    let g = t.getTranslate() + h * n.sensitivity;
    if ((g >= t.minTranslate() && (g = t.minTranslate()), g <= t.maxTranslate() && (g = t.maxTranslate()), (i = !!t.params.loop || !(g === t.minTranslate() || g === t.maxTranslate())), i && t.params.nested && s.stopPropagation(), t.params.freeMode && t.params.freeMode.enabled)) {
      const e = {
          time: l(),
          delta: Math.abs(h),
          direction: Math.sign(h),
        },
        i = c && e.time < c.time + 500 && e.delta <= c.delta && e.direction === c.direction;
      if (!i) {
        c = void 0;
        let l = t.getTranslate() + h * n.sensitivity;
        const o = t.isBeginning,
          p = t.isEnd;
        if (
          (l >= t.minTranslate() && (l = t.minTranslate()),
          l <= t.maxTranslate() && (l = t.maxTranslate()),
          t.setTransition(0),
          t.setTranslate(l),
          t.updateProgress(),
          t.updateActiveIndex(),
          t.updateSlidesClasses(),
          ((!o && t.isBeginning) || (!p && t.isEnd)) && t.updateSlidesClasses(),
          t.params.loop &&
            t.loopFix({
              direction: e.direction < 0 ? "next" : "prev",
              byMousewheel: !0,
            }),
          t.params.freeMode.sticky)
        ) {
          clearTimeout(d), (d = void 0), u.length >= 15 && u.shift();
          const s = u.length ? u[u.length - 1] : void 0,
            i = u[0];
          if ((u.push(e), s && (e.delta > s.delta || e.direction !== s.direction))) u.splice(0);
          else if (u.length >= 15 && e.time - i.time < 500 && i.delta - e.delta >= 1 && e.delta <= 6) {
            const s = h > 0 ? 0.8 : 0.2;
            (c = e),
              u.splice(0),
              (d = a(() => {
                t.slideToClosest(t.params.speed, !0, void 0, s);
              }, 0));
          }
          d ||
            (d = a(() => {
              (c = e), u.splice(0), t.slideToClosest(t.params.speed, !0, void 0, 0.5);
            }, 500));
        }
        if ((i || r("scroll", s), t.params.autoplay && t.params.autoplayDisableOnInteraction && t.autoplay.stop(), l === t.minTranslate() || l === t.maxTranslate())) return !0;
      }
    } else {
      const s = {
        time: l(),
        delta: Math.abs(h),
        direction: Math.sign(h),
        raw: e,
      };
      u.length >= 2 && u.shift();
      const i = u.length ? u[u.length - 1] : void 0;
      if (
        (u.push(s),
        i ? (s.direction !== i.direction || s.delta > i.delta || s.time > i.time + 150) && f(s) : f(s),
        (function (e) {
          const s = t.params.mousewheel;
          if (e.direction < 0) {
            if (t.isEnd && !t.params.loop && s.releaseOnEdges) return !0;
          } else if (t.isBeginning && !t.params.loop && s.releaseOnEdges) return !0;
          return !1;
        })(s))
      )
        return !0;
    }
    return s.preventDefault ? s.preventDefault() : (s.returnValue = !1), !1;
  }
  function g(e) {
    let s = t.el;
    "container" !== t.params.mousewheel.eventsTarget && (s = document.querySelector(t.params.mousewheel.eventsTarget)), s[e]("mouseenter", h), s[e]("mouseleave", m), s[e]("wheel", v);
  }
  function w() {
    return t.params.cssMode ? (t.wrapperEl.removeEventListener("wheel", v), !0) : !t.mousewheel.enabled && (g("addEventListener"), (t.mousewheel.enabled = !0), !0);
  }
  function T() {
    return t.params.cssMode ? (t.wrapperEl.addEventListener(event, v), !0) : !!t.mousewheel.enabled && (g("removeEventListener"), (t.mousewheel.enabled = !1), !0);
  }
  i("init", () => {
    !t.params.mousewheel.enabled && t.params.cssMode && T(), t.params.mousewheel.enabled && w();
  }),
    i("destroy", () => {
      t.params.cssMode && w(), t.mousewheel.enabled && T();
    }),
    Object.assign(t.mousewheel, {
      enable: w,
      disable: T,
    });
}
Object.keys($).forEach(e => {
  Object.keys($[e]).forEach(t => {
    X.prototype[t] = $[e][t];
  });
}),
  X.use([
    function (e) {
      let { swiper: t, on: s, emit: i } = e;
      const r = n();
      let a = null,
        l = null;
      const o = () => {
          t && !t.destroyed && t.initialized && (i("beforeResize"), i("resize"));
        },
        d = () => {
          t && !t.destroyed && t.initialized && i("orientationchange");
        };
      s("init", () => {
        t.params.resizeObserver && void 0 !== r.ResizeObserver
          ? t &&
            !t.destroyed &&
            t.initialized &&
            ((a = new ResizeObserver(e => {
              l = r.requestAnimationFrame(() => {
                const { width: s, height: i } = t;
                let r = s,
                  n = i;
                e.forEach(e => {
                  let { contentBoxSize: s, contentRect: i, target: a } = e;
                  (a && a !== t.el) || ((r = i ? i.width : (s[0] || s).inlineSize), (n = i ? i.height : (s[0] || s).blockSize));
                }),
                  (r === s && n === i) || o();
              });
            })),
            a.observe(t.el))
          : (r.addEventListener("resize", o), r.addEventListener("orientationchange", d));
      }),
        s("destroy", () => {
          l && r.cancelAnimationFrame(l), a && a.unobserve && t.el && (a.unobserve(t.el), (a = null)), r.removeEventListener("resize", o), r.removeEventListener("orientationchange", d);
        });
    },
    function (e) {
      let { swiper: t, extendParams: s, on: i, emit: r } = e;
      const a = [],
        l = n(),
        o = function (e, s) {
          void 0 === s && (s = {});
          const i = new (l.MutationObserver || l.WebkitMutationObserver)(e => {
            if (t.__preventObserver__) return;
            if (1 === e.length) return void r("observerUpdate", e[0]);
            const s = function () {
              r("observerUpdate", e[0]);
            };
            l.requestAnimationFrame ? l.requestAnimationFrame(s) : l.setTimeout(s, 0);
          });
          i.observe(e, {
            attributes: void 0 === s.attributes || s.attributes,
            childList: void 0 === s.childList || s.childList,
            characterData: void 0 === s.characterData || s.characterData,
          }),
            a.push(i);
        };
      s({
        observer: !1,
        observeParents: !1,
        observeSlideChildren: !1,
      }),
        i("init", () => {
          if (t.params.observer) {
            if (t.params.observeParents) {
              const e = g(t.el);
              for (let t = 0; t < e.length; t += 1) o(e[t]);
            }
            o(t.el, {
              childList: t.params.observeSlideChildren,
            }),
              o(t.wrapperEl, {
                attributes: !1,
              });
          }
        }),
        i("destroy", () => {
          a.forEach(e => {
            e.disconnect();
          }),
            a.splice(0, a.length);
        });
    },
  ]);
export { Y as K, W as M, X as S };
