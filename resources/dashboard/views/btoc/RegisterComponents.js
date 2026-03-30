import BtocIndex from './components/btocIndex.vue';
import BtocCreate from './components/btocCreate.vue';
import BtocShow from './components/btocShow.vue';

export default (Vue) => {
  Vue.component('btoc-index', BtocIndex);
  Vue.component('btoc-create', BtocCreate);
  Vue.component('btoc-show', BtocShow);
}