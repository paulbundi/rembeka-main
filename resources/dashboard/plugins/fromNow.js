/* eslint-disable no-unused-vars, no-param-reassign */

var dayjs = require('dayjs')
import relativeTime from "dayjs/plugin/relativeTime"
var isToday = require('dayjs/plugin/isToday')
var isSameOrBefore = require('dayjs/plugin/isSameOrBefore')


export default {
  install(Vue, options) {
    Vue.prototype.$dayjs = dayjs;

    Vue.filter('fromNow', (value) => {
      if(!value) return;

      dayjs.extend(isToday)
      if(dayjs(value).isToday()) {
        return '<span class="badge bg-danger">Today</span>';
      }

      dayjs.extend(isSameOrBefore)
      if(dayjs(value).isSameOrBefore(dayjs().add(-1, 'day'), 'day')) {
        dayjs.extend(relativeTime)
        return `<span class="badge bg-danger">${dayjs(value).fromNow()}</span>`;
      }

      dayjs.extend(relativeTime)
      return `<span class="badge bg-success">${dayjs(value).fromNow()}</span>`;
    });
  },
};
