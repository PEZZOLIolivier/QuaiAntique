/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

import Lightbox from 'bs5-lightbox';

const $ = require('jquery');

document.querySelectorAll('.my-lightbox-toggle').forEach(el => el.addEventListener('click', Lightbox.initialize));

let liveToast = document.getElementById('liveToast')

if (liveToast) {
    liveToast.classList.add('show');
}





