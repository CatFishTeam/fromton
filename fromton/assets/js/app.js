//Dependencies
import $ from 'jquery'
window.jQuery = $;
window.$ = $;

import 'bootstrap'
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

import swal from 'sweetalert';

import './global';

//Components
import './components/navbar'
import './components/rating'
import './components/notify.js';
import './components/searchbar.js';
import './components/konami.js';

//Images
require('../images/svg/mouse.svg');
require('../images/svg/cheese.svg');
require('../images/svg/notification.svg');
require('../images/svg/notification_new.svg');
require('../images/svg/like.svg');
require('../images/svg/dislike.svg');

//@TODO change to images (only for dev purpose)
require('../images/svg/roundedChesse.svg');