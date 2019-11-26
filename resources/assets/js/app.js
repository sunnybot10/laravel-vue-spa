require('./bootstrap');

import Vue from 'vue';
import swalPlugin from './utilities/VueSweetalert2';
import { Form, HasError, AlertError, AlertErrors, AlertSuccess } from 'vform';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import {routes} from './routes';
import StoreData from './store';
import MainApp from './components/MainApp.vue';
import {initialize} from './helpers/general';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.use(VueRouter);
Vue.use(Vuex);

const VueInputMask = require('vue-inputmask').default;

const options = {
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
}

Vue.use(VueProgressBar, options);

Vue.filter('myDate',function(created){
    return moment(created).format('DD MMM YYYY, h:mm');
});

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.use(VueInputMask);

window.Fire =  new Vue();

const store = new Vuex.Store(StoreData);

const router = new VueRouter({
	routes,
	mode:'history'
});

initialize(store, router);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        MainApp
    }
});
