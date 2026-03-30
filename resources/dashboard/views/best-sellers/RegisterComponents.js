import BestSellersIndex from './components/BestSellerIndex.vue';
import BestSellersCreate from './components/BestSellerCreate.vue';
import BestSellersShow from './components/BestSellerShow.vue';

export default (Vue) => {
  Vue.component('best-sellers-index', BestSellersIndex);
  Vue.component('best-sellers-create', BestSellersCreate);
  Vue.component('best-sellers-show', BestSellersShow);
}