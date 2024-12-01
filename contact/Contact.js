/**
 * Sélection du menu burger et du menu latéral
 */
const sideBurgerMenu = document.querySelector('.side-burger-menu');
const menu = document.getElementById("side-menu");

/**
 * Gestion de l'événement pour le bouton du burger
 */
document.getElementById("burger-btn").addEventListener("click", function(event) {
    event.stopPropagation(); // Empêche la fermeture immédiate après l'ouverture

    if (menu.classList.contains("active")) {
        menu.classList.remove("active");
        sideBurgerMenu.style.top = "140px";
    } else {
        menu.classList.add("active");
        sideBurgerMenu.style.top = "20px";
    }
});

/**
 * Détecte les clics ailleurs sur la page et ferme le menu latéral
 */
document.addEventListener('click', function(event) {
    if (menu.classList.contains('active') && !menu.contains(event.target) && !sideBurgerMenu.contains(event.target)) {
        menu.classList.remove('active');
        sideBurgerMenu.style.top = "170px";
    }
});

/**
 * Sélection du menu utilisateur et du menu latéral
 */
const userBurgerMenu = document.querySelector('.auth-icon img');
const userSideMenu = document.querySelector('.user-side-menu');

/**
 * Gestion de l'événement pour le clic sur le menu utilisateur
 */
userBurgerMenu.addEventListener('click', function () {
    if (userSideMenu.classList.contains('active')) {
        userSideMenu.classList.remove('active');
    } else {
        userSideMenu.classList.add('active');
    }
});

/**
 * Sélection des éléments pour la barre de recherche et la barre de navigation
 */
const searchIcon = document.querySelector('.search-icon');
const searchBar = document.querySelector('.search-bar');
const navigation = document.querySelector('nav');

/**
 * Ajuste l'affichage en fonction de la taille de l'écran
 */
function adjustLayout() {
    if (window.innerWidth <= 1100) {
        if (searchBar.classList.contains('active')) {
            navigation.style.display = 'none';
            searchBar.style.margin = '0 auto';
        } else {
            navigation.style.display = 'flex';
            searchBar.style.margin = '0';
        }
    } else {
        navigation.style.display = 'flex';
        searchBar.style.margin = '0';
    }
}

/**
 * Écouteur d'événement pour ajuster la mise en page lors du redimensionnement de la fenêtre
 */
window.addEventListener('resize', adjustLayout);

/**
 * Gestion de l'événement pour activer ou désactiver la barre de recherche
 */
searchIcon.addEventListener('click', () => {
    searchBar.classList.toggle('active');
    adjustLayout();
});

/**
 * Sélection des éléments du DOM pour les menus utilisateur et burger
 */
const userMenu = document.getElementById('user-side-menu');
const burgerMenu = document.getElementById('side-menu');
const burgerBtn = document.getElementById('burger-btn');
const userIcon = document.querySelector('.auth-icon img');

/**
 * Vérifie si un clic est en dehors d'un élément donné
 * @param {HTMLElement} element - L'élément à vérifier
 * @param {EventTarget} target - La cible du clic
 * @returns {boolean} True si le clic est en dehors de l'élément, sinon False
 */
function isClickOutside(element, target) {
    return !element.contains(target);
}

/**
 * Gestion des clics sur la page pour fermer les menus ouverts
 */
document.addEventListener('click', function (event) {
    const target = event.target;

    if (userMenu.classList.contains('active') && isClickOutside(userMenu, target) && !userIcon.contains(target)) {
        userMenu.classList.remove('active');
    }

    if (burgerMenu.classList.contains('active') && isClickOutside(burgerMenu, target) && !burgerBtn.contains(target)) {
        burgerMenu.classList.remove('active');
    }
});
