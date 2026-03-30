import OrderItemIndex from './components/OrderItemIndex.vue';
import OrderItemEdit from './components/OrderItemEdit.vue';
import CalendarIndex from './components/CalendarIndex.vue';

export default (Vue) => {
  Vue.component('order-item-index', OrderItemIndex);
  Vue.component('order-item-edit', OrderItemEdit);
  Vue.component('calendar-index', CalendarIndex);
}