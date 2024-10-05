// Sélection du menu burger et du menu latéral
const burgerMenu = document.querySelector('.burger-menu img');
const sideMenu = document.querySelector('.side-menu');
const sideBurgerMenu = document.querySelector('.side-burger-menu');

// Ajout d'un événement pour le bouton du burger
document.getElementById("burger-btn").addEventListener("click", function() {
    var menu = document.getElementById("side-menu");

    // Toggle active class pour afficher ou cacher le menu
    if (menu.classList.contains("active")) {
        menu.classList.remove("active");

        // Remettre le bouton du menu burger à sa position d'origine
        sideBurgerMenu.style.top = "120px";  // Position initiale sous le logo
    } else {
        menu.classList.add("active");

        // Repositionner le bouton du menu burger vers le haut
        sideBurgerMenu.style.top = "20px";  // Position en haut lors de l'ouverture
    }
});
