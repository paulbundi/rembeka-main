import TransportRequestIndex from './components/TransportRequestIndex.vue';
import TransportRequestCreate from './components/TransportRequestCreate.vue';
import TransportRequestShow from './components/TransportRequestShow.vue';

export default (Vue) => {
  Vue.component('transport-request-index', TransportRequestIndex);
  Vue.component('transport-request-create', TransportRequestCreate);
  Vue.component('transport-request-show', TransportRequestShow);
}