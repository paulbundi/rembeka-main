import Vue from 'vue';
import 'bootstrap-icons/font/bootstrap-icons.css'
import httpPlugin from './plugins/http';
import translation from './plugins/translation';
import store from './store';
import registerComponents from './vue-components';
import dayjs from './plugins/dayjs';
import {loading} from './plugins/loading';
import 'izitoast/dist/css/iziToast.min.css';
import VueIziToast from 'vue-izitoast';
import bus from './plugins/bus';
import axios from 'axios';
import numberFormat from './plugins/numberFormat';

Vue.use(dayjs);
Vue.directive('loading', loading)
Vue.use(numberFormat);
Vue.use(httpPlugin, { store })
Vue.use(VueIziToast, { position: "topRight"});
Vue.use(bus);
Vue.use(translation);

Vue.prototype.$axios = axios;

registerComponents(Vue);

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
});


