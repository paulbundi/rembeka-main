import SupplierPricing from './components/SupplierPricingIndex.vue';
import SupplierPricingCreate from './components/SupplierPricingCreate.vue';

export default (Vue) => {
  Vue.component('supplier-pricing-index', SupplierPricing);
  Vue.component('supplier-pricing-create', SupplierPricingCreate);
}