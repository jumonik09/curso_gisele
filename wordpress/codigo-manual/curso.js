(() => {
  const course = document.querySelector("[data-gv-aquarela]");
  if (!course) return;

  const preview = course.querySelector("[data-preview]");
  const video = preview?.querySelector("video[data-source]");
  const source = video?.dataset.source;

  if (source) {
    const play = preview.querySelector(".play");
    const status = preview.querySelector(".player-status");

    video.addEventListener("loadedmetadata", () => {
      status.hidden = true;
      play.hidden = false;
    }, { once: true });

    video.addEventListener("error", () => {
      status.textContent = video.hidden ? "Vídeo em breve" : "Vídeo indisponível no momento";
      video.hidden = true;
      play.hidden = true;
      status.hidden = false;
    });

    play.addEventListener("click", () => {
      play.hidden = true;
      video.hidden = false;
      video.focus();
      video.play().catch(() => {
        // Os controles nativos permitem tentar novamente.
      });
    });

    video.src = source;
  }

  if (!window.matchMedia("(prefers-reduced-motion: no-preference)").matches
      || !("IntersectionObserver" in window)) return;

  const observer = new IntersectionObserver((entries, currentObserver) => {
    for (const entry of entries) {
      if (!entry.isIntersecting) continue;
      entry.target.classList.add("arrived");
      currentObserver.unobserve(entry.target);
    }
  }, { threshold: 0.15 });

  course.querySelectorAll(".preview .section-intro, .about-copy, .artist .section-intro, .offer-inner")
    .forEach((section) => observer.observe(section));
})();
