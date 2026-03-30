import ChannelIndex from './components/channelsIndex.vue';
import ChannelCreate from './components/channelsCreate.vue';
import ChannelShow from './components/channelsShow.vue';

export default (Vue) => {
  Vue.component('channels-index',ChannelIndex);
  Vue.component('channels-create',ChannelCreate);
  Vue.component('channels-show',ChannelShow);
}