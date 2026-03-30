import DeliveryRequestIndex from './components/DeliveryRequestIndex.vue';
import DeliveryRequestCreate from './components/DeliveryRequestCreate.vue';
import DeliveryRequestShow from './components/DeliveryRequestShow.vue';

export default (Vue) => {
  Vue.component('delivery-request-index', DeliveryRequestIndex);
  Vue.component('delivery-request-create', DeliveryRequestCreate);
  Vue.component('delivery-request-show', DeliveryRequestShow);
}