import MediaIndex from './components/MediaIndex.vue';
import MediaCreate from './components/MediaCreate.vue';
import MediaShow from './components/MediaShow.vue';

export default (Vue) => {
  Vue.component('media-index', MediaIndex);
  Vue.component('media-create', MediaCreate);
  Vue.component('media-show', MediaShow);
}