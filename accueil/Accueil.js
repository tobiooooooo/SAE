// Sélection du menu burger et du menu latéral
const sideBurgerMenu = document.querySelector('.side-burger-menu');

// Fonction pour créer un article
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

// Fonction pour gérer le défilement des articles
function setupArticleNavigation(row, leftButtonId, rightButtonId) {
    const leftButton = document.getElementById(leftButtonId);
    const rightButton = document.getElementById(rightButtonId);
    const articles = row.querySelectorAll('.article-card');
    let currentIndex = 0;
    const maxIndex = articles.length - 3; // Affiche 3 articles à la fois

    function showArticles() {
        articles.forEach((article, index) => {
            article.classList.remove('active');
            if (index >= currentIndex && index < currentIndex + 3) {
                article.style.display = 'block';
                setTimeout(() => {
                    article.classList.add('active');
                }, 50); // Petite temporisation pour rendre l'animation visible
            } else {
                article.style.display = 'none';
            }
        });
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

// Appelle cette fonction après avoir ajouté les articles au DOM via fetch
function initializeSlider() {
    const regionalRow = document.querySelectorAll('.row')[0]; // Première section (régionale)
    const nationalRow = document.querySelectorAll('.row')[1]; // Deuxième section (nationale)

    setupArticleNavigation(regionalRow, 'L1', 'R1'); // Slider pour la section régionale
    setupArticleNavigation(nationalRow, 'L2', 'R2'); // Slider pour la section nationale
}











// Function to add swipe/drag functionality for both mouse and touch events
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
        if (!isDragging) return; // Stop function if not dragging
        e.preventDefault();
        const x = e.pageX - row.offsetLeft;
        const walk = (x - startX) * 1.5; // Adjust the scroll sensitivity
        row.scrollLeft = scrollLeft - walk;
    });

    // Touch events for mobile devices
    row.addEventListener('touchstart', (e) => {
        startX = e.touches[0].pageX;
        scrollLeft = row.scrollLeft;
    });

    row.addEventListener('touchmove', (e) => {
        const x = e.touches[0].pageX;
        const walk = (x - startX) * 1.5; // Adjust the swipe sensitivity
        row.scrollLeft = scrollLeft - walk;
    });
}

// Initialization of swipe/drag for each article row
document.querySelectorAll('.row').forEach(row => {
    row.style.cursor = 'grab'; // Add cursor for dragging
    addSwipeGesture(row);
});


