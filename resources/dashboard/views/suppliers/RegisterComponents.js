import SupplierIndex from './components/SupplierIndex.vue';
import SupplierCreate from './components/SupplierCreate.vue';
import SupplierShow from './components/SupplierShow.vue';

export default (Vue) => {
  Vue.component('suppliers-index', SupplierIndex);
  Vue.component('suppliers-create', SupplierCreate);
  Vue.component('suppliers-show', SupplierShow);
}