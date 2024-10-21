// Sélection du menu burger et du menu latéral
const sideBurgerMenu = document.querySelector('.side-burger-menu');
const menu = document.getElementById("side-menu");

// Ajout d'un événement pour le bouton du burger
document.getElementById("burger-btn").addEventListener("click", function(event) {
    event.stopPropagation(); // Empêche la fermeture immédiate après l'ouverture

    // Toggle active class pour afficher ou cacher le menu
    if (menu.classList.contains("active")) {
        menu.classList.remove("active");
        sideBurgerMenu.style.top = "140px";  // Position initiale sous le logo
    } else {
        menu.classList.add("active");
        sideBurgerMenu.style.top = "20px";  // Position en haut lors de l'ouverture
    }
});

// Ajout d'un événement pour détecter les clics ailleurs sur la page et fermer le menu
document.addEventListener('click', function(event) {
    if (menu.classList.contains('active') && !menu.contains(event.target) && !sideBurgerMenu.contains(event.target)) {
        menu.classList.remove('active');
        sideBurgerMenu.style.top = "140px";  // Revenir à la position initiale
    }
});

// Sélection du menu burger utilisateur et du menu latéral
const userBurgerMenu = document.querySelector('.auth-icon img');
const userSideMenu = document.querySelector('.user-side-menu');

// Ajout d'un événement pour le clic sur le menu burger utilisateur
userBurgerMenu.addEventListener('click', function () {
    if (userSideMenu.classList.contains('active')) {
        userSideMenu.classList.remove('active');
    } else {
        userSideMenu.classList.add('active');
    }
});

// Sélection des éléments pour la barre de recherche et la barre de navigation
const searchIcon = document.querySelector('.search-icon');
const searchBar = document.querySelector('.search-bar');
const navigation = document.querySelector('nav');

// Fonction pour ajuster l'affichage en fonction de la taille de l'écran
function adjustLayout() {
    if (window.innerWidth <= 1100) {
        if (searchBar.classList.contains('active')) {
            navigation.style.display = 'none'; // Cache la barre de navigation si la barre de recherche est active en petit format
            searchBar.style.margin = '0 auto'; // Centrer la barre de recherche sur petit format
        } else {
            navigation.style.display = 'flex'; // Affiche la barre de navigation si la barre de recherche n'est pas active
            searchBar.style.margin = '0'; // Réinitialiser le centrage de la barre de recherche
        }
    } else {
        navigation.style.display = 'flex'; // Affiche toujours la barre de navigation sur les écrans moyens et grands
        searchBar.style.margin = '0'; // Réinitialiser le centrage de la barre de recherche sur les grands écrans
    }
}

// Ajout de l'événement resize pour ajuster la mise en page dynamiquement
window.addEventListener('resize', adjustLayout);

// Ajout d'un événement au clic sur l'icône de recherche
searchIcon.addEventListener('click', () => {
    searchBar.classList.toggle('active'); // Active ou désactive la barre de recherche
    adjustLayout(); // Ajuste l'affichage immédiatement après le clic
});
