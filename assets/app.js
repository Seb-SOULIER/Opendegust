/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import './js/search';
import './js/map';
import './js/concat-form';
import './js/register-provider';
import './js/register-customer';
import './js/offer-variation-info';
import './js/files';

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
require('slick-carousel');

window.bootstrap = require('bootstrap');

$('#productCarousel').slick({
    centerMode: true,
    centerPadding: '60px',
    slidesToShow: 4,
    responsive: [
        {
            breakpoint: 768,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 3
            }
        },
        {
            breakpoint: 480,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1
            }
        }
    ]
});
