// Options de l'observateur d'intersection
var options = {
    root: null, // Utilise la fenêtre comme zone d'affichage
    rootMargin: "0px", // Pas de marge supplémentaire
    threshold: 0.001, // Déclenche l'observation dès que 10% de l'élément est visible
};

// Fonction de callback lorsqu'un élément entre dans la zone d'affichage
function handleIntersection(entries, observer) {
    entries.forEach(function (entry) {
        if (entry.isIntersecting) {
            entry.target.classList.remove("hidden");
            entry.target.classList.add("fade-in-up");
            observer.unobserve(entry.target); // Arrête l'observation une fois que l'animation est déclenchée
        }
    });
}

// Sélection de tous les éléments avec la classe "card"
var cards = document.querySelectorAll(".animated-fade-up");

// Création de l'observateur d'intersection
var observer = new IntersectionObserver(handleIntersection, options);

// Observation de chaque carte
cards.forEach(function (card) {
    card.classList.add("hidden");
    observer.observe(card);
});
