
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

let key = document.head.querySelector('meta[name="pusher-key"]');
let port = document.head.querySelector('meta[name="pusher-port"]');
let encrypted = document.head.querySelector('meta[name="pusher-encrypted"]');
let wsHost = document.head.querySelector('meta[name="pusher-ws-host"]');

if (key) {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: key.content,
        wsHost: wsHost.content,
        wsPort: port.content,
        // wssPort: port.content,
        disableStats: true,
        encrypted: encrypted.content
    });
} else {
    console.error('Pusher Key not found');
}

window.collect = require('collect.js');
window.moment = require('moment');

require('../../node_modules/jquery-migrate/dist/jquery-migrate.min.js');

window.waypoint = require('../../node_modules/waypoints/lib/jquery.waypoints.min.js');

window.jqueryEasing = require('../../node_modules/jquery.easing/jquery.easing.1.3.min.js');
window.stellar = require( '../../node_modules/jquery.stellar/jquery.stellar.js');
window.AOS = require('../../node_modules/aos/dist/aos.js');
window.Scrollax = require('../../node_modules/scrollax/scrollax.min.js');

window.moment   = require('moment');