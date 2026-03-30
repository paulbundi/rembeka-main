import InquiriesIndex from './components/InquiriesIndex.vue';
import InquiriesCreate from './components/InquiriesCreate.vue';
import InquiriesShow from './components/InquiriesShow.vue';

export default (Vue) => {
  Vue.component('inquiries-index', InquiriesIndex);
  Vue.component('inquiries-create', InquiriesCreate);
  Vue.component('inquiries-show', InquiriesShow);
}