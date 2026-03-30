import Vue from 'vue';
// Global Theme Requirements
import 'bootstrap-icons/font/bootstrap-icons.css'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'
import "./modules/bootstrap";

import DateRangePicker from 'vue2-daterange-picker'
import httpPlugin from './plugins/http';
import translation from './plugins/translation';
import store from './store';
import registerComponents from './vue-components';
import dayjs from './plugins/dayjs';
import {loading} from './plugins/loading';
import 'izitoast/dist/css/iziToast.min.css';
import VueIziToast from 'vue-izitoast';
import bus from './plugins/bus';
import canUserAccess from './mixins/canUserAccess';
import isValidEmail from './mixins/isValidEmail';
import DatePicker from 'vuejs-datepicker';
import 'bootstrap';
import fromNow from '../dashboard/plugins/fromNow';
import numberFormat from './plugins/numberFormat';


Vue.use(dayjs);
Vue.use(fromNow);
Vue.directive('loading', loading)
Vue.use(httpPlugin, { store })
Vue.use(VueIziToast, { position: "topRight"});
Vue.mixin(canUserAccess);
Vue.use(numberFormat);
Vue.mixin(isValidEmail);
Vue.use(bus);
Vue.use(translation);
Vue.component('date-picker', DatePicker);
Vue.component('date-range-picker', DateRangePicker);

registerComponents(Vue);

/* eslint-disable no-new */
new Vue({
  el: '#app-dashboard',
  store,
});
