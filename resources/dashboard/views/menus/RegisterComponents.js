import MenusIndex from './components/menusIndex.vue';
import MenusCreate from './components/menusCreate.vue';
import MenusShow from './components/menusShow.vue';

export default (Vue) => {
  Vue.component('menus-index', MenusIndex);
  Vue.component('menus-create', MenusCreate);
  Vue.component('menus-show', MenusShow);
}