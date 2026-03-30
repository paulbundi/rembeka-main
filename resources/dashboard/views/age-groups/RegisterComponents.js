import AgeGroupIndex from './components/AgeGroupIndex.vue';
import AgeGroupCreate from './components/AgeGroupCreate.vue';
import AgeGroupShow from './components/AgeGroupShow.vue';

export default (Vue) => {
  Vue.component('age-group-index', AgeGroupIndex);
  Vue.component('age-group-create', AgeGroupCreate);
  Vue.component('age-group-show', AgeGroupShow);
}