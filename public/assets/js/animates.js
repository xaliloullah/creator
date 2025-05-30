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
            entry.target.classList.add("scale-in-center");
            observer.unobserve(entry.target); // Arrête l'observation une fois que l'animation est déclenchée
        }
    });
}

// Sélection de tous les éléments avec la classe "card"
var cards = document.querySelectorAll(".animated-scale-in-center");

// Création de l'observateur d'intersection
var observer = new IntersectionObserver(handleIntersection, options);
// Observation de chaque carte
cards.forEach(function (card) {
    card.classList.add("hidden");
    observer.observe(card);
});

$(document).ready(function () {
    // Fonction de callback pour l'Intersection Observer
    var callback = function (entries, observer) {
        entries.forEach(function (entry) {
            // Vérifier si l'élément est visible à l'écran
            if (entry.isIntersecting) {
                var $countUp = $(entry.target);
                $countUp.animate(
                    { Counter: $countUp.text() },
                    {
                        duration: 2000, // Durée de l'animation en millisecondes
                        easing: "swing", // Type d'interpolation
                        step: function () {
                            $countUp.text(Math.ceil(this.Counter));
                        },
                    }
                );

                // Une fois que l'animation a été activée, arrêter l'observer
                observer.unobserve(entry.target);
            }
        });
    };

    // Créer une instance de l'Intersection Observer
    var observer = new IntersectionObserver(callback, { threshold: 0.1 });

    // Sélectionner tous les éléments avec la classe "count-up"
    var $countUps = $(".count-up");

    // Observer chaque élément avec la classe "count-up"
    $countUps.each(function () {
        observer.observe(this);
    });
});
