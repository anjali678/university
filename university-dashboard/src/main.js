import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import './assets/js/custom.js';
import './assets/main.css'
import './assets/scss/sb-admin-2.scss';
import './assets/css/sb-admin-2.min.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '@fortawesome/fontawesome-free/css/all.min.css'

import { createApp } from 'vue'
import App from './App.vue'
import store from './store';
import router from './router';
import axios from './axios';

const app = createApp(App);

app.use(store);
app.use(router);
app.config.globalProperties.$axios = axios; // Register axios globally
app.mount('#app');
