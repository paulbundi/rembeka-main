import { i18next } from '../translations';

export default {
  /* eslint-disable no-param-reassign */
  install: (Vue) => {
    Vue.prototype.$t = i18next;
  },
}
