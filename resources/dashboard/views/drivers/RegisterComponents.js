import DriverIndex from './components/DriverIndex.vue';
import DriverCreate from './components/DriverCreate.vue';
import DriversShow from './components/DriverShow.vue';

export default (Vue) => {
  Vue.component('drivers-index', DriverIndex);
  Vue.component('drivers-create', DriverCreate);
  Vue.component('drivers-show', DriversShow);
}