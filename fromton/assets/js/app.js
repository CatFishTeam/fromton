/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import $ from 'jquery'
window.jQuery = $;
window.$ = $;

import 'bootstrap'

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

import './components/notify.js';

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

//JS
import './_navbar'

//Images
require('../images/svg/mouse.svg');
require('../images/svg/cheese.svg');
require('../images/svg/notification.svg');
require('../images/svg/notification_new.svg');

//@TODO change to images (only for dev purpose)
require('../images/svg/roundedChesse.svg');