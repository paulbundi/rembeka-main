import ProviderPricing from './components/ProviderPricingIndex.vue';
import ProviderPricingCreate from './components/ProviderPricingCreate.vue';

export default (Vue) => {
  Vue.component('provider-pricing-index', ProviderPricing);
  Vue.component('provider-pricing-create', ProviderPricingCreate);
}