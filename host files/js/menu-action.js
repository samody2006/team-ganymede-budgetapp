let hamburgerMenu = document.querySelector('i.fa-bars');
let smallNav = document.querySelector('.small-nav');

const hamburgerMenuAction = () =>{
    smallNav.classList.toggle('hidden');
};
hamburgerMenu.addEventListener('click', hamburgerMenuAction);