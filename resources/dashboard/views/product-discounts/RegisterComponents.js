import ProductDiscountIndex from './components/ProductDiscountIndex.vue';
import ProductDiscountCreate from './components/ProductDiscountCreate.vue';
import ProductDiscountShow from './components/ProductDiscountShow.vue';

export default (Vue) => {
  Vue.component('product-discounts-index', ProductDiscountIndex);
  Vue.component('product-discounts-create', ProductDiscountCreate);
  Vue.component('product-discounts-show', ProductDiscountShow);
}