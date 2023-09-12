import { S as e, K as r, M as t } from "./swiper_vendor.js";
!(function () {
  const e = document.createElement("link").relList;
  if (!(e && e.supports && e.supports("modulepreload"))) {
    for (const e of document.querySelectorAll('link[rel="modulepreload"]')) r(e);
    new MutationObserver(e => {
      for (const t of e) if ("childList" === t.type) for (const e of t.addedNodes) "LINK" === e.tagName && "modulepreload" === e.rel && r(e);
    }).observe(document, {
      childList: !0,
      subtree: !0,
    });
  }
  function r(e) {
    if (e.ep) return;
    e.ep = !0;
    const r = (function (e) {
      const r = {};
      return e.integrity && (r.integrity = e.integrity), e.referrerpolicy && (r.referrerPolicy = e.referrerpolicy), "use-credentials" === e.crossorigin ? (r.credentials = "include") : "anonymous" === e.crossorigin ? (r.credentials = "omit") : (r.credentials = "same-origin"), r;
    })(e);
    fetch(e.href, r);
  }
})();
!(function (s) {
  const o = s.querySelector(".travel-slider-planet"),
    i = s.querySelector(".travel-slider-cities"),
    n = s.querySelector(".swiper"),
    l = s.querySelectorAll(".swiper-slide");
  i && i.classList.add("travel-slider-cities-" + (l.length > 4 ? "8" : "4")),
    new e(n, {
      modules: [r, t],
      speed: 600,
      grabCursor: !0,
      slidesPerView: "auto",
      centeredSlides: !0,
      spaceBetween: 24,
      watchSlidesProgress: !0,
      keyboard: !0,
      mousewheel: !0,
      breakpoints: {
        512: {
          spaceBetween: 32,
        },
        1024: {
          spaceBetween: 64,
        },
      },
      on: {
        progress(e, r) {
          if (!o) return;
          const t = e.slides.length > 4 ? 360 - 45 * (8 - e.slides.length + 1) : 270;
          o.style.transform = `translate(-50%, -50%) rotate(${t * -r}deg)`;
        },
        setTransition(e, r) {
          o && (o.style.transitionDuration = `${r}ms`);
        },
      },
    });
})(document.querySelector(".travel-slider"));
