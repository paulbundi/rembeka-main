import SaleIndex from './components/SaleIndex.vue';
import SaleCreate from './components/SaleCreate.vue';
import SaleShow from './components/SaleShow.vue';

export default (Vue) => {
  Vue.component('sales-index', SaleIndex);
  Vue.component('sales-create', SaleCreate);
  Vue.component('sales-show', SaleShow);
}