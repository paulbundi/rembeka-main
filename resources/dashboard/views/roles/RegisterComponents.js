import RoleIndex from './components/RoleIndex.vue';
import RoleCreate from './components/RoleCreate.vue';
import RoleShow from './components/RoleShow.vue';

export default (Vue) => {
Vue.component('role-index', RoleIndex);
Vue.component('role-create', RoleCreate);
Vue.component('role-show', RoleShow);
}