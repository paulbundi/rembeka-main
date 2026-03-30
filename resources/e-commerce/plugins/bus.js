/* eslint-disable no-param-reassign */
import Vue from 'vue';

const bus = new Vue();

export default {
  install(VueInstance) {
    Object.defineProperties(VueInstance.prototype, {
      $bus: {
        get() {
          return bus;
        },
      },
      $confirm: {
        get() {
          return (payload = {}) => (new Promise((resolve, reject) => {
            bus.$emit('confirm', { ...payload, resolve, reject });
          }));
        },
      },
    });
  },
};
