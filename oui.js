// Select the burger menu and the navigation elements
const burgerMenu = document.querySelector('.burger-menu img');
const navMenu = document.querySelector('nav ul');

// Toggle the visibility of the navigation menu on burger menu click
burgerMenu.addEventListener('click', () => {
    navMenu.classList.toggle('active');
});
