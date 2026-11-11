(function () {
  "use strict";

  var reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  var root = document.documentElement;

  function store(key, value) {
    try { localStorage.setItem(key, value); } catch (e) {}
  }
  function read(key) {
    try { return localStorage.getItem(key); } catch (e) { return null; }
  }
  function readList(key) {
    try {
      var parsed = JSON.parse(localStorage.getItem(key) || "[]");
      return Array.isArray(parsed) ? parsed : [];
    } catch (e) { return []; }
  }

  function initTheme() {
    var buttons = document.querySelectorAll("[data-theme-toggle]");
    function setTheme(theme) {
      root.setAttribute("data-theme", theme);
      store("tc-theme-mode", theme);
      var meta = document.querySelector('meta[name="theme-color"]');
      if (meta) meta.setAttribute("content", theme === "dark" ? "#08060A" : "#FAF7F2");
      buttons.forEach(function (button) {
        button.setAttribute("aria-pressed", theme === "light" ? "true" : "false");
        button.setAttribute("aria-label", theme === "dark" ? "Switch to light mode" : "Switch to dark mode");
      });
      document.querySelectorAll("[data-theme-value]").forEach(function (label) {
        label.textContent = theme === "dark" ? "Dark" : "Light";
      });
    }
    setTheme(root.getAttribute("data-theme") === "light" ? "light" : "dark");
    buttons.forEach(function (button) {
      button.addEventListener("click", function (event) {
        var next = root.getAttribute("data-theme") === "dark" ? "light" : "dark";
        if (document.startViewTransition && !reduce) {
          root.style.setProperty("--tx", event.clientX + "px");
          root.style.setProperty("--ty", event.clientY + "px");
          document.startViewTransition(function () { setTheme(next); });
        } else {
          setTheme(next);
        }
      });
    });
    window.requestAnimationFrame(function () {
      window.requestAnimationFrame(function () { root.classList.add("theme-ready"); });
    });
  }

  function initHeader() {
    var bar = document.querySelector(".topbar");
    if (!bar) return;
    var onScroll = function () { bar.classList.toggle("is-scrolled", window.scrollY > 12); };
    onScroll();
    document.addEventListener("scroll", onScroll, { passive: true });
    var toggle = document.querySelector(".nav-toggle");
    if (!toggle) return;
    var sync = function () {
      toggle.setAttribute("aria-expanded", toggle.checked ? "true" : "false");
      toggle.setAttribute("aria-label", toggle.checked ? "Close menu" : "Open menu");
    };
    toggle.addEventListener("change", sync);
    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && toggle.checked) {
        toggle.checked = false;
        sync();
      }
    });
  }

  function initMenus() {
    var menus = document.querySelectorAll(".nav details");
    var hover = window.matchMedia("(hover: hover) and (min-width: 1101px)");
    function closeOthers(current) {
      menus.forEach(function (menu) {
        if (menu !== current) menu.open = false;
      });
    }
    menus.forEach(function (menu) {
      var item = menu.closest(".mega");
      var summary = menu.querySelector("summary");
      var timer = null;
      function open() {
        window.clearTimeout(timer);
        closeOthers(menu);
        menu.open = true;
      }
      function scheduleClose() {
        window.clearTimeout(timer);
        timer = window.setTimeout(function () { menu.open = false; }, 160);
      }
      if (summary) {
        summary.addEventListener("click", function (event) {
          if (!hover.matches) return;
          event.preventDefault();
          open();
        });
      }
      if (item) {
        item.addEventListener("mouseenter", function () {
          if (hover.matches) open();
        });
        item.addEventListener("mouseleave", function () {
          if (hover.matches) scheduleClose();
        });
        item.addEventListener("focusin", function () {
          if (hover.matches) open();
        });
      }
      menu.addEventListener("toggle", function () {
        if (!menu.open) return;
        window.setTimeout(function () { closeOthers(menu); }, 0);
      });
    });
  }

  function initMegaPreview() {
    document.querySelectorAll("[data-mega-preview]").forEach(function (root) {
      var card = root.querySelector("[data-preview-card]");
      if (!card) return;

      var img = card.querySelector("[data-preview-img]");
      var links = root.querySelectorAll("a[data-preview-image]");

      links.forEach(function (link) {
        var src = link.getAttribute("data-preview-image");
        if (!src) return;
        var preload = new Image();
        preload.src = src;
      });

      function paint(source) {
        var nextImage = source.getAttribute("data-preview-image") || source.getAttribute("data-default-image") || "";
        var nextAlt = source.getAttribute("data-preview-alt") || source.getAttribute("data-default-alt") || "";
        var nextTitle = source.getAttribute("data-preview-title") || source.getAttribute("data-default-title") || "";
        var nextHref = source.getAttribute("data-preview-href") || source.getAttribute("data-default-href") || card.getAttribute("href");

        if (img && nextImage && img.getAttribute("src") !== nextImage) {
          img.classList.add("is-switching");
          window.setTimeout(function () {
            img.setAttribute("src", nextImage);
            img.setAttribute("alt", nextAlt);
            img.classList.remove("is-switching");
          }, reduce ? 0 : 120);
        } else if (img) {
          img.setAttribute("alt", nextAlt);
        }

        if (nextTitle) card.setAttribute("aria-label", nextTitle);
        if (nextHref) card.setAttribute("href", nextHref);
      }

      function activate(link) {
        links.forEach(function (item) {
          item.classList.toggle("is-preview", item === link);
        });
        paint(link);
      }

      function reset() {
        links.forEach(function (item) {
          item.classList.remove("is-preview");
        });
        paint(card);
      }

      links.forEach(function (link) {
        link.addEventListener("mouseenter", function () { activate(link); });
        link.addEventListener("focus", function () { activate(link); });
      });

      root.addEventListener("mouseleave", reset);
    });
  }

  function initSearch() {
    var dialog = document.getElementById("site-search");
    function open() {
      if (!dialog) return;
      dialog.hidden = false;
      var field = dialog.querySelector("input, select");
      if (field) field.focus();
    }
    function close() { if (dialog) dialog.hidden = true; }
    document.querySelectorAll("[data-search-open]").forEach(function (button) {
      button.addEventListener("click", open);
    });
    document.querySelectorAll("[data-search-close]").forEach(function (button) {
      button.addEventListener("click", close);
    });
    if (dialog) {
      dialog.addEventListener("click", function (event) {
        if (event.target === dialog) close();
      });
    }
    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") close();
    });
    document.querySelectorAll("[data-search]").forEach(function (box) {
      var tabs = box.querySelectorAll("[data-search-tab]");
      var forms = box.querySelectorAll(".search-form");
      tabs.forEach(function (tab, index) {
        tab.addEventListener("click", function () {
          tabs.forEach(function (item, i) {
            item.setAttribute("aria-selected", i === index ? "true" : "false");
          });
          forms.forEach(function (form, i) {
            form.classList.toggle("is-active", i === index);
          });
        });
      });
    });
  }

  function initHero() {
    var hero = document.querySelector("[data-hero]");
    if (!hero) return;
    var slides = Array.prototype.slice.call(hero.querySelectorAll(".hero__slide"));
    var prev = hero.querySelector("[data-hero-prev]");
    var next = hero.querySelector("[data-hero-next]");
    var index = 0;
    var timer = null;
    function show(nextIndex) {
      index = (nextIndex + slides.length) % slides.length;
      slides.forEach(function (slide, i) {
        var active = i === index;
        slide.classList.toggle("is-active", active);
        slide.setAttribute("aria-hidden", active ? "false" : "true");
      });
    }
    function play() {
      if (timer) window.clearInterval(timer);
      timer = null;
      if (reduce || slides.length < 2) return;
      timer = window.setInterval(function () { show(index + 1); }, 7000);
    }
    if (prev) prev.addEventListener("click", function () { show(index - 1); play(); });
    if (next) next.addEventListener("click", function () { show(index + 1); play(); });
    var startX = null;
    hero.addEventListener("touchstart", function (event) {
      if (event.target.closest(".hero__arrow")) {
        startX = null;
        return;
      }
      startX = event.changedTouches[0].clientX;
    }, { passive: true });
    hero.addEventListener("touchend", function (event) {
      if (startX === null) return;
      var diff = event.changedTouches[0].clientX - startX;
      startX = null;
      if (Math.abs(diff) < 40) return;
      show(index + (diff < 0 ? 1 : -1));
      play();
    }, { passive: true });
    hero.addEventListener("keydown", function (event) {
      if (event.key === "ArrowRight") { show(index + 1); play(); }
      if (event.key === "ArrowLeft") { show(index - 1); play(); }
    });
    show(0);
    play();
  }

  function initWishlist() {
    var key = "tc-wish";
    function list() { return readList(key); }
    function paint() {
      var items = list();
      document.querySelectorAll("[data-wish-count]").forEach(function (node) {
        node.textContent = String(items.length);
        node.hidden = items.length === 0;
      });
      document.querySelectorAll("[data-wish]").forEach(function (button) {
        var on = items.indexOf(button.getAttribute("data-wish")) !== -1;
        button.setAttribute("aria-pressed", on ? "true" : "false");
      });
      var view = document.querySelector("[data-wishlist-view]");
      if (!view) return;
      var shown = 0;
      view.querySelectorAll("[data-slug]").forEach(function (card) {
        var keep = items.indexOf(card.getAttribute("data-slug")) !== -1;
        card.hidden = !keep;
        if (keep) shown += 1;
      });
      var empty = view.querySelector("[data-wishlist-empty]");
      if (empty) empty.hidden = shown !== 0;
    }
    document.addEventListener("click", function (event) {
      var button = event.target.closest("[data-wish]");
      if (!button) return;
      var slug = button.getAttribute("data-wish");
      var items = list().filter(function (item) { return item !== slug; });
      if (button.getAttribute("aria-pressed") !== "true") items.push(slug);
      store(key, JSON.stringify(items));
      paint();
    });
    paint();
  }

  function initCurrency() {
    var select = document.querySelector("[data-currency]");
    if (!select) return;
    var saved = read("tc-currency");
    if (saved) select.value = saved;
    function paint() {
      var option = select.selectedOptions[0];
      var code = select.value || "AED";
      var rate = option ? parseFloat(option.getAttribute("data-rate") || "1") : 1;
      if (!rate || rate <= 0) rate = 1;
      document.querySelectorAll("[data-money]").forEach(function (node) {
        var amount = parseFloat(node.getAttribute("data-money") || "0");
        if (code === "AED") {
          node.textContent = "AED " + Math.round(amount).toLocaleString("en-AE");
        } else {
          node.textContent = "approx. " + code + " " + Math.round(amount * rate).toLocaleString("en-AE");
        }
      });
    }
    select.addEventListener("change", function () {
      store("tc-currency", select.value);
      paint();
    });
    paint();
  }

  function initEnquiry() {
    var drawer = document.getElementById("enquiry-drawer");
    if (!drawer) return;
    var form = drawer.querySelector("form");
    function fill(link) {
      ["package_slug", "package", "experience", "visa", "kind"].forEach(function (name) {
        var input = form.querySelector('[name="' + name + '"]');
        if (input) input.value = "";
      });
      var kind = link.getAttribute("data-kind") || "package";
      form.kind.value = kind;
      var title = link.getAttribute("data-title") || "";
      if (kind === "package") {
        form.package_slug.value = link.getAttribute("data-slug") || "";
        form.package.value = title;
      } else if (kind === "experience") {
        form.experience.value = title;
      } else if (kind === "visa") {
        form.visa.value = title;
      }
      var label = drawer.querySelector("[data-enquiry-title]");
      if (label) label.textContent = title;
      drawer.hidden = false;
      var month = form.querySelector("[name='month']");
      if (month) month.focus();
    }
    document.addEventListener("click", function (event) {
      var link = event.target.closest("[data-enquire]");
      if (!link) return;
      event.preventDefault();
      fill(link);
    });
    drawer.addEventListener("click", function (event) {
      if (event.target === drawer) drawer.hidden = true;
    });
    drawer.querySelectorAll("[data-drawer-close]").forEach(function (button) {
      button.addEventListener("click", function () { drawer.hidden = true; });
    });
    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") drawer.hidden = true;
    });
  }

  function initRecent() {
    var current = document.querySelector("[data-recent-slug]");
    var key = "tc-recent";
    var items = readList(key);
    if (current) {
      var slug = current.getAttribute("data-recent-slug");
      items = items.filter(function (item) { return item !== slug; });
      items.unshift(slug);
      items = items.slice(0, 6);
      store(key, JSON.stringify(items));
    }
    var box = document.querySelector("[data-recent]");
    var catalogueNode = document.getElementById("recent-catalogue");
    if (!box || !catalogueNode) return;
    var catalogue = [];
    try { catalogue = JSON.parse(catalogueNode.textContent || "[]"); } catch (e) {}
    var list = box.querySelector("[data-recent-list]");
    items.forEach(function (slug) {
      var match = catalogue.filter(function (row) { return row.slug === slug; })[0];
      if (!match || !list) return;
      var item = document.createElement("li");
      var link = document.createElement("a");
      link.href = match.url;
      link.textContent = match.title;
      item.appendChild(link);
      list.appendChild(item);
    });
    box.hidden = !list || list.children.length === 0;
  }

  function initLightbox() {
    var box = document.getElementById("lightbox");
    if (!box) return;
    var image = box.querySelector("img");
    document.querySelectorAll("[data-lightbox]").forEach(function (button) {
      button.addEventListener("click", function () {
        image.src = button.getAttribute("data-lightbox");
        image.alt = button.getAttribute("data-alt") || "";
        box.hidden = false;
      });
    });
    box.addEventListener("click", function () { box.hidden = true; });
    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") box.hidden = true;
    });
  }

  function initCountdown() {
    document.querySelectorAll("[data-countdown]").forEach(function (node) {
      var end = Date.parse(node.getAttribute("data-countdown") || "");
      if (!end) return;
      var tick = function () {
        var diff = end - Date.now();
        if (diff <= 0) {
          node.textContent = "This travel window has closed.";
          return;
        }
        var days = Math.floor(diff / 86400000);
        var hours = Math.floor((diff % 86400000) / 3600000);
        node.textContent = days + " days " + hours + " hours remaining";
      };
      tick();
      window.setInterval(tick, 60000);
    });
  }

  initTheme();
  initHeader();
  initMenus();
  initMegaPreview();
  initSearch();
  initHero();
  initWishlist();
  initCurrency();
  initEnquiry();
  initRecent();
  initLightbox();
  initCountdown();
})();
