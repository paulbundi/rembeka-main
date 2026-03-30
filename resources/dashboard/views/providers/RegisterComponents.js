import ProviderIndex from './components/ProviderIndex.vue';
import ProviderCreate from './components/ProviderCreate.vue';
import ProviderEdit from './components/ProviderEdit.vue';
import ProviderShow from './components/ProviderShow.vue';

export default (Vue) => {
  Vue.component('providers-index', ProviderIndex);
  Vue.component('providers-create', ProviderCreate);
  Vue.component('providers-edit', ProviderEdit);
  Vue.component('providers-show', ProviderShow);
}