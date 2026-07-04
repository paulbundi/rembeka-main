import ColorIndex from './components/ColorIndex.vue';
import ColorCreate from './components/ColorCreate.vue';

export default (Vue) => {
  Vue.component('color-index', ColorIndex);
  Vue.component('color-create', ColorCreate);
}