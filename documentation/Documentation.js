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
    userSideMenu.classList.toggle('active');
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
