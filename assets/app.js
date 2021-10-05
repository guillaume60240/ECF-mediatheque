/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

//animation page d'accueil
const titleSpans = document.querySelectorAll('h2 span');
const btns = document.querySelectorAll('button');
const ul = document.querySelectorAll('.category');


window.addEventListener('load', () => {

    const TL = gsap.timeline({paused: true});

    TL.staggerFrom(titleSpans, 1, {top: -50, opacity: 0, ease: "power2.out"}, 0.3)
    TL.staggerFrom(btns, 1, {opacity: 0, ease: "power2.out"}, 0.3, '-=1.5')
    TL.staggerFrom(ul, 1, {opacity: 0, ease: "power2.out"}, 0.3, '-=1.5');

    TL.play();
})