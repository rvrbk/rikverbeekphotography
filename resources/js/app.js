if('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
    });
}

import vue from 'vue';
import vuerouter from 'vue-router';
import vuex from 'vuex';
import axios from 'axios';
import es6_promise from 'es6-promise';
import lodash from 'lodash';

import app from './components/app';
import wall from './components/wall';

vue.use(vuerouter);
vue.use(vuex);

window.axios = axios;
window._ = lodash;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
   window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
   console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

const store = new vuex.Store({
    state: {
        loading: false,
        progression: 0
    },
    mutations: {
        progress(state, amount) {
            state.progression = amount; 
        },
        load(state) {
            state.loading = true;
        },
        loaded(state) {
            state.loading = false;
        } 
    }
});

const router = new vuerouter({
    routes: [{
        path: '/',
        component: app,
        children: [{
            path: '/',
            component: wall
        }]
    }]
});

new vue({
    el: '#app',
    store,
    router
});
