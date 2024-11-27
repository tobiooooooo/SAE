// Sélection du menu burger et du menu latéral
const sideBurgerMenu = document.querySelector('.side-burger-menu');
const menu = document.getElementById("side-menu");

// Ajout d'un événement pour le bouton du burger
document.getElementById("burger-btn").addEventListener("click", function(event) {
    event.stopPropagation();


    if (menu.classList.contains("active")) {
        menu.classList.remove("active");

        // Remettre le bouton du menu burger à sa position d'origine
        sideBurgerMenu.style.top = "170px";
    } else {
        menu.classList.add("active");

        // Repositionner le bouton du menu burger vers le haut
        sideBurgerMenu.style.top = "20px";
    }
});


document.addEventListener("click", function() {
    if (menu.classList.contains("active")) {
        menu.classList.remove("active");

        // Remettre le bouton du menu burger à sa position d'origine
        sideBurgerMenu.style.top = "160px";
    }
});













// Sélection du menu burger utilisateur et du menu latéral
const userBurgerMenu = document.querySelector('.auth-icon img');
const userSideMenu = document.querySelector('.user-side-menu');


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
            navigation.style.display = 'none';
            searchBar.style.margin = '0 auto';
        } else {
            navigation.style.display = 'flex';
            searchBar.style.margin = '0';
        }
    } else {
        navigation.style.display = 'flex'; // Affiche toujours la barre de navigation sur les écrans moyens et grands
        searchBar.style.margin = '0'; // Réinitialiser le centrage de la barre de recherche sur les grands écrans
    }
}


window.addEventListener('resize', adjustLayout);

// Ajout d'un événement au clic sur l'icône de recherche
searchIcon.addEventListener('click', () => {
    searchBar.classList.toggle('active');
    adjustLayout();
});






// Fonction pour gérer le défilement des articles
function setupArticleNavigation(row, leftButtonId, rightButtonId) {
    const leftButton = document.getElementById(leftButtonId);
    const rightButton = document.getElementById(rightButtonId);
    const articles = row.querySelectorAll('.article-card');
    let currentIndex = 0;
    const maxIndex = articles.length - 3; // Affiche 3 articles à la fois

    function showArticles() {
        articles.forEach((article, index) => {
            if (index >= currentIndex && index < currentIndex + 3) {
                article.style.display = 'block';
                setTimeout(() => {
                    article.classList.add('active');
                }, 50); // Petite temporisation pour rendre l'animation visible
            } else {
                article.style.display = 'none';
            }
        });

        // Gère l'affichage des flèches
        leftButton.style.display = currentIndex === 0 ? 'none' : 'block';
        rightButton.style.display = currentIndex === maxIndex ? 'none' : 'block';
    }

    // Défilement vers la gauche
    leftButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            showArticles();
        }
    });

    // Défilement vers la droite
    rightButton.addEventListener('click', () => {
        if (currentIndex < maxIndex) {
            currentIndex++;
            showArticles();
        }
    });

    // Affiche initialement les articles
    showArticles();
}















// Sélection des éléments du DOM
const userMenu = document.getElementById('user-side-menu');
const burgerMenu = document.getElementById('side-menu');
const burgerBtn = document.getElementById('burger-btn');
const userIcon = document.querySelector('.auth-icon img');

// Fonction pour vérifier si un clic est en dehors d'un élément
function isClickOutside(element, target) {
    return !element.contains(target);
}

// Ajouter un écouteur d'événement pour fermer les menus lorsque l'utilisateur clique ailleurs sur la page
document.addEventListener('click', function (event) {
    const target = event.target;

    // Fermer le menu utilisateur si l'utilisateur clique en dehors
    if (userMenu.classList.contains('active') && isClickOutside(userMenu, target) && !userIcon.contains(target)) {
        userMenu.classList.remove('active');
    }

    // Fermer le menu burger si l'utilisateur clique en dehors
    if (burgerMenu.classList.contains('active') && isClickOutside(burgerMenu, target) && !burgerBtn.contains(target)) {
        burgerMenu.classList.remove('active');
    }
});



// Fonction permettant d’ajouter une fonctionnalité de balayage/glissement pour les événements de souris et tactiles
function addSwipeGesture(row) {
    let isDragging = false;
    let startX = 0;
    let scrollLeft = 0;

    // Mouse events for desktop
    row.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.pageX - row.offsetLeft;
        scrollLeft = row.scrollLeft;
        row.classList.add('dragging');
    });

    row.addEventListener('mouseleave', () => {
        isDragging = false;
        row.classList.remove('dragging');
    });

    row.addEventListener('mouseup', () => {
        isDragging = false;
        row.classList.remove('dragging');
    });

    row.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - row.offsetLeft;
        const walk = (x - startX) * 1.5;
        row.scrollLeft = scrollLeft - walk;
    });

    // Touch events for mobile devices
    row.addEventListener('touchstart', (e) => {
        startX = e.touches[0].pageX;
        scrollLeft = row.scrollLeft;
    });

    row.addEventListener('touchmove', (e) => {
        const x = e.touches[0].pageX;
        const walk = (x - startX) * 1.5;
        row.scrollLeft = scrollLeft - walk;
    });
}

// Initialisation du balayage/glissement pour chaque ligne d’article
document.querySelectorAll('.row').forEach(row => {
    row.style.cursor = 'grab';
    addSwipeGesture(row);
});



















// Fonction pour créer un article
function createArticle(title, imageUrl, bodyText) {
    const articleCard = document.createElement('div');
    articleCard.classList.add('article-card');

    const img = document.createElement('img');
    img.src = imageUrl;
    img.alt = `Image for ${title}`;
    articleCard.appendChild(img);

    const h3 = document.createElement('h3');
    h3.textContent = title;
    articleCard.appendChild(h3);

    const p = document.createElement('p');
    p.textContent = bodyText;
    articleCard.appendChild(p);

    const button = document.createElement('button');
    button.classList.add('voir-plus');
    button.textContent = 'Voir plus';
    articleCard.appendChild(button);

    return articleCard;
}





// Fonction pour ajouter les articles à une section donnée
function addArticlesToSection(section, articlesData) {
    const row = section.querySelector('.row');
    articlesData.forEach(article => {
        const articleCard = createArticle(article.title, article.imageUrl, article.bodyText);
        row.appendChild(articleCard);
    });
}

// Charger les données des articles depuis un fichier JSON
// Charger les données des articles depuis un fichier JSON
document.addEventListener('DOMContentLoaded', function() {
    fetch('articles.json')
        .then(response => response.json())
        .then(data => {
            // Ajouter les articles régionaux
            const regionalSection = document.querySelectorAll('.articles')[0];
            addArticlesToSection(regionalSection, data.regional);

            // Ajouter les articles nationaux
            const nationalSection = document.querySelectorAll('.articles')[1];
            addArticlesToSection(nationalSection, data.national);

            // Initialiser le slider après avoir ajouté les articles
            initializeSlider();
        })
        .catch(error => console.error('Erreur lors du chargement des articles:', error));
});

// Appelle cette fonction après avoir ajouté les articles au DOM via fetch
function initializeSlider() {
    const regionalRow = document.querySelectorAll('.row')[0]; // Première section (régionale)
    const nationalRow = document.querySelectorAll('.row')[1]; // Deuxième section (nationale)

    setupArticleNavigation(regionalRow, 'L1', 'R1'); // Slider pour la section régionale
    setupArticleNavigation(nationalRow, 'L2', 'R2'); // Slider pour la section nationale
}

