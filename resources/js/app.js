require('./bootstrap');

window.Vue = require('vue');


import VueRouter from 'vue-router'
import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import { routes } from './routes';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

// Vue.component('header-views', require('./chuyenWebAdmin/layoutComponent/headerComponent.vue').default);
// Vue.component('footer-views', require('./chuyenWebAdmin/layoutComponent/footerComponent.vue').default);


// gọi tocken ra 
var strGetToken = localStorage.getItem('token-chuyenWeb');

if (strGetToken !== '') {
    var checkLogin = routes;
} else {
    var checkLogin = routerUser;
}

const router = new VueRouter({
    mode: 'history',
    routes: checkLogin // short for `routes: routes`
})

const app = new Vue({
    el: '#app',
    router: router,
    template: '<chuyenweb-app-view></chuyenweb-app-view>',
});