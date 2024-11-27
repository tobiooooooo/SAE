const sideBurgerMenu = document.querySelector('.side-burger-menu');
const menu = document.getElementById("side-menu");

document.getElementById("burger-btn").addEventListener("click", function(event) {
    event.stopPropagation();
    if (menu.classList.contains("active")) {
        menu.classList.remove("active");
        sideBurgerMenu.style.top = "170px";
    } else {
        menu.classList.add("active");
        sideBurgerMenu.style.top = "20px";
    }
});

document.addEventListener("click", function() {
    if (menu.classList.contains("active")) {
        menu.classList.remove("active");
        sideBurgerMenu.style.top = "160px";
    }
});

const userBurgerMenu = document.querySelector('.auth-icon img');
const userSideMenu = document.querySelector('.user-side-menu');

userBurgerMenu.addEventListener('click', function () {
    if (userSideMenu.classList.contains('active')) {
        userSideMenu.classList.remove('active');
    } else {
        userSideMenu.classList.add('active');
    }
});

const searchIcon = document.querySelector('.search-icon');
const searchBar = document.querySelector('.search-bar');
const navigation = document.querySelector('nav');

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

window.addEventListener('resize', adjustLayout);

searchIcon.addEventListener('click', () => {
    searchBar.classList.toggle('active');
    adjustLayout();
});

function setupArticleNavigation(row, leftButtonId, rightButtonId) {
    const leftButton = document.getElementById(leftButtonId);
    const rightButton = document.getElementById(rightButtonId);
    const articles = row.querySelectorAll('.article-card');
    let currentIndex = 0;
    const maxIndex = articles.length - 3;

    function showArticles() {
        articles.forEach((article, index) => {
            if (index >= currentIndex && index < currentIndex + 3) {
                article.style.display = 'block';
                setTimeout(() => {
                    article.classList.add('active');
                }, 50);
            } else {
                article.style.display = 'none';
            }
        });

        leftButton.style.display = currentIndex === 0 ? 'none' : 'block';
        rightButton.style.display = currentIndex === maxIndex ? 'none' : 'block';
    }

    leftButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            showArticles();
        }
    });

    rightButton.addEventListener('click', () => {
        if (currentIndex < maxIndex) {
            currentIndex++;
            showArticles();
        }
    });

    showArticles();
}

const userMenu = document.getElementById('user-side-menu');
const burgerMenu = document.getElementById('side-menu');
const burgerBtn = document.getElementById('burger-btn');
const userIcon = document.querySelector('.auth-icon img');

function isClickOutside(element, target) {
    return !element.contains(target);
}

document.addEventListener('click', function (event) {
    const target = event.target;

    if (userMenu.classList.contains('active') && isClickOutside(userMenu, target) && !userIcon.contains(target)) {
        userMenu.classList.remove('active');
    }

    if (burgerMenu.classList.contains('active') && isClickOutside(burgerMenu, target) && !burgerBtn.contains(target)) {
        burgerMenu.classList.remove('active');
    }
});

function addSwipeGesture(row) {
    let isDragging = false;
    let startX = 0;
    let scrollLeft = 0;

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

document.querySelectorAll('.row').forEach(row => {
    row.style.cursor = 'grab';
    addSwipeGesture(row);
});

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

function addArticlesToSection(section, articlesData) {
    const row = section.querySelector('.row');
    articlesData.forEach(article => {
        const articleCard = createArticle(article.title, article.imageUrl, article.bodyText);
        row.appendChild(articleCard);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    fetch('articles.json')
        .then(response => response.json())
        .then(data => {
            const regionalSection = document.querySelectorAll('.articles')[0];
            addArticlesToSection(regionalSection, data.regional);

            const nationalSection = document.querySelectorAll('.articles')[1];
            addArticlesToSection(nationalSection, data.national);

            initializeSlider();
        })
        .catch(error => console.error('Erreur lors du chargement des articles:', error));
});

function initializeSlider() {
    const regionalRow = document.querySelectorAll('.row')[0];
    const nationalRow = document.querySelectorAll('.row')[1];

    setupArticleNavigation(regionalRow, 'L1', 'R1');
    setupArticleNavigation(nationalRow, 'L2', 'R2');
}
