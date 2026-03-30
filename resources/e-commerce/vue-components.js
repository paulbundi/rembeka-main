import CartHover from './views/cart/cartHover.vue';
import AddToCartView from './views/products/AddToCartView.vue';
import MainSearchBar from './views/search/MainSearchBar.vue';
import ProductSearchPage from './views/search/ProductSearchPage.vue';
import CartCreate from './views/cart/CartCreate';
import Rating from './plugins/rating.vue';
import OrderSummaryDetails from './views/cart/OrderSummaryDetails.vue';
import UserIcon from './views/commons/UserIcon.vue';
import CartCreateSummaryDetails from './views/cart/CartCreateSummaryDetails.vue';
import StylistDetails from './views/stylists/StylistDetails';
import ProductTreasurePage from './views/search/ProductTreasurePage.vue';

export default (Vue) => {
  Vue.component('cart-hover', CartHover);
  Vue.component('add-to-cart-view', AddToCartView);
  Vue.component('main-search-bar', MainSearchBar);
  Vue.component('product-search-page', ProductSearchPage);
  Vue.component('cart-create', CartCreate);
  Vue.component('rating', Rating);
  Vue.component('order-summary-details', OrderSummaryDetails);
  Vue.component('user-icon', UserIcon);
  Vue.component('cart-create-summary-details', CartCreateSummaryDetails);
  Vue.component('stylist-show-details',StylistDetails);
  Vue.component('product-treasure-page',ProductTreasurePage);
}