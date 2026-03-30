import ServiceDiscountIndex from './components/ServiceDiscountIndex.vue';
import ServiceDiscountCreate from './components/ServiceDiscountCreate.vue';
import ServiceDiscountShow from './components/ServiceDiscountShow.vue';

export default (Vue) => {
  Vue.component('service-discounts-index', ServiceDiscountIndex);
  Vue.component('service-discounts-create', ServiceDiscountCreate);
  Vue.component('service-discounts-show', ServiceDiscountShow);
}