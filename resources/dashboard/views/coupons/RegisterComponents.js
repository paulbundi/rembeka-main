import CouponIndex from './components/CouponIndex.vue';
import CouponCreate from './components/CouponCreate.vue';
import CouponShow from './components/CouponShow.vue';

export default (Vue) => {
  Vue.component('coupons-index', CouponIndex);
  Vue.component('coupons-create', CouponCreate);
  Vue.component('coupons-show', CouponShow);
}