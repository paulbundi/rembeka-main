import OrderIndex from './components/OrderIndex.vue';
import CorporateOrderShow from './components/CorporateOrderShow.vue';

export default (Vue) => {
  Vue.component('corporate-orders-index', OrderIndex);
  Vue.component('corporate-orders-show', CorporateOrderShow);
  
}