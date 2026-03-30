import LocationIndex from './components/locationIndex.vue';
import LocationCreate from './components/locationCreate.vue';

export default (Vue) => {
  Vue.component('locations-index', LocationIndex);
  Vue.component('locations-create', LocationCreate);
}