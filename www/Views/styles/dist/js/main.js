window.addEventListener("load", () => {
  document.querySelectorAll(".navbar_toggle_button").forEach((t) => {
    console.log(t);
    let l = document.createElement("span");
    t.append(l), t.onclick = () => {
      const o = t.getAttribute("data-target"), e = document.querySelector(o);
      e.classList.toggle("toggled"), t.classList.toggle("toggled"), e.classList.contains("toggled") ? e.style.maxHeight = e.scrollHeight + "px" : e.style.maxHeight = 0;
    };
  });
});
window.addEventListener("load", () => {
  document.querySelectorAll(".modal").forEach((t) => {
    c(t);
  });
});
const c = (t) => {
  const l = t.id;
  document.querySelectorAll('[data-modal-open="' + l + '"]').forEach((o) => {
    console.log(o), o.addEventListener("click", () => {
      n(t);
    });
  }), document.querySelectorAll("[data-modal-close]").forEach((o) => {
    o.addEventListener("click", (e) => {
      const a = e.target.closest(".modal");
      s(a);
    });
  });
}, n = (t) => {
  t.style.display = "flex";
}, s = (t) => {
  t.style.display = "none";
};
