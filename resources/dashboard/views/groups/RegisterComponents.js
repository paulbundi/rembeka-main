import GroupsIndex from './components/GroupsIndex.vue';
import GroupsShow from './components/GroupsShow.vue';

export default (Vue) => {
  Vue.component('groups-index', GroupsIndex);
  Vue.component('groups-show', GroupsShow);
}