import CategoriesIndex from './components/categoriesIndex.vue';
import CategoriesCreate from './components/categoriesCreate.vue';
import CategoriesShow from './components/categoriesShow.vue';

export default (Vue) => {
  Vue.component('categories-index', CategoriesIndex);
  Vue.component('categories-create', CategoriesCreate);
  Vue.component('categories-show', CategoriesShow);
}