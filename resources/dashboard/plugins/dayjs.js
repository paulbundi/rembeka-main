/* eslint-disable no-unused-vars, no-param-reassign */

var dayjs = require('dayjs')
var localizedFormat = require('dayjs/plugin/localizedFormat')


export default {
  install(Vue, options) {
    Vue.prototype.$dayjs = dayjs;

    Vue.filter('formatDate', (value, format) => {
      if (!value) return '';
      dayjs.extend(localizedFormat);
      return dayjs(value).format(format);
    });
  },
};
