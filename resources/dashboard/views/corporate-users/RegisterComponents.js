import CorporateUsersIndex from './components/CorporateMembersIndex.vue';
import CorporateMembersCreate from './components/CorporateMembersCreate.vue';

export default (Vue) => {
  Vue.component('corporate-members-index', CorporateUsersIndex);
  Vue.component('corporate-members-create', CorporateMembersCreate);
}