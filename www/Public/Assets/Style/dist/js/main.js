window.onload = () => {
  document.querySelectorAll(".navbar__toggle").forEach((l) => {
    l.addEventListener("click", (c) => {
      console.log("click");
      const o = c.target;
      o.classList.toggle("active");
      const t = o.closest(".navbar");
      t.classList.toggle("toggled");
      const e = t.querySelector(".navbar__toggle-content");
      t.classList.contains("toggled") ? e.style.maxHeight = e.scrollHeight + "px" : e.style.maxHeight = "0";
    });
  });
};
