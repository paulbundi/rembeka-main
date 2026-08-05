import ProviderInquiryIndex from './components/ProviderInquiryIndex.vue';
import ProviderInquiryCreate from './components/ProviderInquiryCreate.vue';
import ProviderInquiryShow from './components/ProviderInquiryShow.vue';

export default (Vue) => {
  Vue.component('provider-inquiries-index', ProviderInquiryIndex);
  Vue.component('provider-inquiries-create', ProviderInquiryCreate);
  Vue.component('provider-inquiries-show', ProviderInquiryShow);
}
