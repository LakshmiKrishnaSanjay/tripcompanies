(function () {
  "use strict";

  var tabs = Array.prototype.slice.call(document.querySelectorAll("[data-hp-tab]"));

  function select(tab, focus) {
    tabs.forEach(function (item) {
      var active = item === tab;
      item.setAttribute("aria-selected", active ? "true" : "false");
      item.tabIndex = active ? 0 : -1;
      var panel = document.getElementById(item.getAttribute("aria-controls"));
      if (panel) {
        panel.hidden = !active;
      }
    });
    if (focus) {
      tab.focus();
    }
  }

  tabs.forEach(function (tab, index) {
    tab.tabIndex = tab.getAttribute("aria-selected") === "true" ? 0 : -1;
    tab.addEventListener("click", function () {
      select(tab, false);
    });
    tab.addEventListener("keydown", function (event) {
      if (event.key !== "ArrowRight" && event.key !== "ArrowLeft") {
        return;
      }
      event.preventDefault();
      var step = event.key === "ArrowRight" ? 1 : -1;
      select(tabs[(index + step + tabs.length) % tabs.length], true);
    });
  });
})();
