import ServicesIndex from './components/ServicesIndex.vue';
import ServicesCreate from './components/ServicesCreate.vue';
import ServicesShow from './components/ServicesShow.vue';

export default (Vue) => {
  Vue.component('services-index', ServicesIndex);
  Vue.component('services-create', ServicesCreate);
  Vue.component('services-show', ServicesShow);
}