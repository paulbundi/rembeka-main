import PartnersIndex from './components/PartnersIndex.vue';
import PartnersCreate from './components/PartnersCreate.vue';

export default (Vue) => {
  Vue.component('partners-index', PartnersIndex);
  Vue.component('partners-create', PartnersCreate);
}