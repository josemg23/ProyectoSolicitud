/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
import 'vue-search-select/dist/VueSearchSelect.css';
import { ModelListSelect } from 'vue-search-select';
import { MultiListSelect } from 'vue-search-select';
Vue.component('ModelListSelect', ModelListSelect);
Vue.component('MultiListSelect', MultiListSelect);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import JsonViewer from 'vue-json-viewer';
import 'vue-json-viewer/style.css';
Vue.use(JsonViewer)
import VueJsonPretty from 'vue-json-pretty';
import 'vue-json-pretty/lib/styles.css';
Vue.component('VueJsonPretty', VueJsonPretty);

import money from 'v-money';
// register directive v-money and component <money>
Vue.use(money, { precision: 4 })
import Vue2Filters from 'vue2-filters';

Vue.use(Vue2Filters);


import VueCompositionAPI from '@vue/composition-api';

Vue.use(VueCompositionAPI);


Vue.component('currency-input', require('./components/CurrencyInput.vue').default);
require('./indicadores');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// const app = new Vue({
//     el: '#app',
// });
