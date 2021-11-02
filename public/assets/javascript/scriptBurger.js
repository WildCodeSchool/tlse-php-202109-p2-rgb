const burgerMenu = document.querySelector(".nav__menu__burgerButton__img");
const menuList = document.querySelector(".nav__menu__ul");
const nav = document.querySelector(".nav");
burgerMenu.addEventListener('click', toggleMenu);

function toggleMenu(){
    console.log("bien reçu le click");
    menuList.classList.toggle('nav__menu__ul--toogle')
    nav.classList.toggle('navOpen')
}