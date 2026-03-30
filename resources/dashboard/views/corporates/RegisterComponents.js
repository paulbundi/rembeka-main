import CorporateIndex from './components/CorporateIndex.vue';
import CorporateCreate from './components/CreateCorporate.vue';
import CorporateShow from './components/CorporateShow.vue';

export default (Vue) => {
  Vue.component('corporate-users-index', CorporateIndex);
  Vue.component('corporate-users-create', CorporateCreate);
  Vue.component('corporate-users-show', CorporateShow);
}