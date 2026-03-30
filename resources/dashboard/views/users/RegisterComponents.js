import UserIndex from './components/UserIndex.vue';
import UserCreate from './components/UserCreate.vue';
import UserShow from './components/UserShow.vue';
import UserOrderItems from './components/UserOrderItems.vue';

export default (Vue) => {
  Vue.component('users-index', UserIndex);
  Vue.component('users-create', UserCreate);
  Vue.component('users-show', UserShow);
  Vue.component('user-order-items', UserOrderItems);
}