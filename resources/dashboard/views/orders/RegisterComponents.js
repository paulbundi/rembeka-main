import OrderIndex from './components/OrderIndex.vue';
import OrderCreate from './components/OrderCreate.vue';
import OrderShow from './components/OrderShow.vue';
import CreateCorporateOrder from './components/CreateCorporateOrder.vue';
import OrderStatus from './components/OrderStatus.vue';

export default (Vue) => {
  Vue.component('orders-index', OrderIndex);
  Vue.component('orders-create', OrderCreate);
  Vue.component('orders-show', OrderShow);
  Vue.component('corporate-orders-create', CreateCorporateOrder);
  Vue.component('order-status', OrderStatus);
  
}