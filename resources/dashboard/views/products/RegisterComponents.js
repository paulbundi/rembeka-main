import ProductsIndex from './components/ProductsIndex.vue';
import ProductsCreate from './components/ProductsCreate.vue';
import ProductsShow from './components/ProductsShow.vue';
import ReceiveSupplierProducts from './components/ReceiveSupplierProducts';

export default (Vue) => {
  Vue.component('products-index', ProductsIndex);
  Vue.component('products-create', ProductsCreate);
  Vue.component('products-show', ProductsShow);
  Vue.component('products-receive-products', ReceiveSupplierProducts);
  
}