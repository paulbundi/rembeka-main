import StoreIndex from './components/StoreIndex.vue';
import StoreCreate from './components/StoreCreate.vue';

export default (Vue) => {
Vue.component('store-index', StoreIndex);
Vue.component('store-create', StoreCreate);

}