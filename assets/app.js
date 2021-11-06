/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// You can specify which plugins you need
import { Tooltip, Toast, Popover, Carousel } from 'bootstrap';
import './bootstrap.bundle.js';
// start the Stimulus application
import './bootstrap';
//animation page d'accueil
const titleSpans = document.querySelectorAll('h2 span');
const btns = document.querySelectorAll('button');
const titleCategory = document.querySelectorAll('.title-category span');
const ul = document.querySelectorAll('.category');



window.addEventListener('load', () => {

    const TL = gsap.timeline({paused: true});

    TL.staggerFrom(titleSpans, 1, {top: -50, opacity: 0, ease: "power2.out"}, 0.3)
    TL.staggerFrom(btns, 1, {opacity: 0, ease: "power2.out"}, 0.3, '-=2')
    TL.staggerFrom(titleCategory, 1, {opacity: 0, ease: "power2.out"}, 0.3, '-=2')
    TL.staggerFrom(ul, 1, {opacity: 0, ease: "power2.out"}, 0.3, '-=1.5');

    TL.play();
})

//fleche toggler nav
const navBtnToggler = document.querySelector('#navBtnToggler');
const navBtnTogglerSpan = document.querySelector('#navBtnTogglerSpan');

navBtnToggler.addEventListener('click', () => {
    if(navBtnToggler.classList.value === "navbar-toggler collapsed"){
        navBtnTogglerSpan.innerHTML = 'Les genres &darr;';
    }else if(navBtnToggler.classList.value === "navbar-toggler"){
        navBtnTogglerSpan.innerHTML = 'Les genres &uarr;';
    }
})

//Animation catalogue
const bookCard  = document.querySelectorAll('.books-card'); 
//on crée les options de l'observer
let options = {
    root: null,
    rootMargin: '-15% 0px',
    threshold: 0
}
// on crée la fonction de l'observer
function handleIntersect(entries){
    entries.forEach(entry => {
        if(entry.isIntersecting){
            entry.target.style.opacity = 1;
            observer.unobserve(entry.target);
        }
    })
}
//on crée l'observer
const observer = new IntersectionObserver(handleIntersect, options);

//on lance l'observer sur chaque élément
bookCard.forEach(card => {
    observer.observe(card);
})