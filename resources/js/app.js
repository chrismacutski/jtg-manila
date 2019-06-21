
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./main');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import VueLazyload from 'vue-lazyload'

Vue.use(VueLazyload, {
    preLoad: 1.3,
    attempt: 1,
    // the default is ['scroll', 'wheel', 'mousewheel', 'resize', 'animationend', 'transitionend']
    listenEvents: [ 'scroll' ]
})

import { VueperSlides, VueperSlide } from 'vueperslides'

import 'vueperslides/dist/vueperslides.css'

Vue.component('timer', require('./components/Timer.vue').default);
Vue.component('contact-form', require('./components/Contact/Form.vue').default);
Vue.component('event-form', require('./components/Event/Form.vue').default);
Vue.component('home-watch-message', require('./components/Frontend/Home/WatchMessage.vue').default);
Vue.component('history-banner', require('./components/Frontend/History/Banner.vue').default);
Vue.component('history-video-player', require('./components/Frontend/History/VideoPlayer.vue').default);
Vue.component('history-video-modal', require('./components/Frontend/History/VideoModal.vue').default);
Vue.component('video-player', require('./components/Frontend/VideoPlayer.vue').default);
Vue.component('planning-a-visit', require('./components/Frontend/Home/PlanningAVisit.vue').default);
Vue.component('member-login', require('./components/Member/Login.vue').default);
Vue.component('vueper-slides', VueperSlides);
Vue.component('vueper-slide', VueperSlide);
Vue.component('window-controller', require('./components/Chat/WindowController.vue').default);
Vue.component('member-register', require('./components/Member/Register.vue').default);
Vue.component('event-slider', require('./components/Event/Slider.vue').default);
Vue.component('home-banner-slider', require('./components/Frontend/Home/BannerSlider.vue').default);
Vue.component('permissions', require('./components/Permissions/Permissions.vue').default);
Vue.component('create-event', require('./components/Event/Create.vue').default);
Vue.component('update-event', require('./components/Event/Update.vue').default);
Vue.component('event-list', require('./components/Event/List.vue').default);
Vue.component('search-event', require('./components/Event/Frontend/Search.vue').default);

Vue.component('home-event-slider', require('./components/Frontend/Home/EventSlider.vue').default);
Vue.component('frontend-event-list', require('./components/Event/Frontend/List.vue').default);
Vue.component('show-more-events', require('./components/Event/Frontend/ShowMore.vue').default);

Vue.component('create-event-attendee', require('./components/Event/Attendees/Create.vue').default);
Vue.component('event-attendee-list', require('./components/Event/Attendees/List.vue').default);

Vue.component('create-series', require('./components/Series/Create.vue').default);

Vue.component('create-series-sermon', require('./components/Series/Sermon/Create.vue').default);

Vue.component('series-list', require('./components/Series/List.vue').default);
Vue.component('series-sermons-list', require('./components/Series/Sermons/List.vue').default);

Vue.component('search-series', require('./components/Series/Frontend/Search.vue').default);

Vue.component('search-sermons', require('./components/Sermons/Frontend/Search.vue').default);
Vue.component('show-more-sermons', require('./components/Sermons/Frontend/ShowMore.vue').default);
Vue.component('frontend-sermon-list', require('./components/Sermons/Frontend/List.vue').default);
Vue.component('frontend-sermon-show', require('./components/Sermons/Frontend/Show.vue').default);

Vue.component('search-series', require('./components/Series/Frontend/Search.vue').default);
Vue.component('show-more-series', require('./components/Series/Frontend/ShowMore.vue').default);
Vue.component('frontend-series-list', require('./components/Series/Frontend/List.vue').default);

Vue.component('home-who-whe-are', require('./components/Frontend/Home/WhoWeAre.vue').default);
Vue.component('home-map', require('./components/Frontend/Home/Map.vue').default);

import SweetModal from "sweet-modal-vue/src/plugin.js";

Vue.use(SweetModal);

import VueYouTubeEmbed from 'vue-youtube-embed';
Vue.use(VueYouTubeEmbed, { global: true, componentId: "series-youtube-video" });

import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
Vue.use(flatPickr);

Vue.config.ignoredElements = ['trix-editor'];

import Popover  from 'vue-js-popover'
Vue.use(Popover)

import VueNoty from 'vuejs-noty'
Vue.use(VueNoty);

const app = new Vue({
    el: '#app'
});
