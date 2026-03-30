import CtobIndex from './components/ctobIndex.vue';
import CtobCreate from './components/ctobCreate.vue';
import CtobShow from './components/ctobShow.vue';

export default (Vue) => {
  Vue.component('ctob-index', CtobIndex);
  Vue.component('ctob-create', CtobCreate);
  Vue.component('ctob-show', CtobShow);
}