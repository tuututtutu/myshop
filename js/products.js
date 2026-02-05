/* Filtre Été / Hiver */
const filters = document.querySelectorAll(".filter");
const cards = document.querySelectorAll(".card");

filters.forEach(btn => {
  btn.addEventListener("click", () => {
    filters.forEach(b => b.classList.remove("active"));
    btn.classList.add("active");

    const season = btn.dataset.season;
    cards.forEach(card => {
      // On utilise "flex" ou "block", la grille parente gérera le reste
      if (season === "all" || card.dataset.season === season) {
        card.style.display = "flex"; 
      } else {
        card.style.display = "none";
      }
    });
  });
});