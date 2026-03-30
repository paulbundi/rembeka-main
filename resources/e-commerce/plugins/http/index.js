import axios from 'axios'
import interceptors from './interceptors';

// allow use http client without Vue instance
export const http = axios.create({
    baseURL: window.axiosDefaults.baseURL,
    headers: {
      Accept: 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': window.axiosDefaults.token,
    },
  });

// receive store and data by options
export default function install(Vue, { store }) {
  interceptors(http, store);
  // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/defineProperty
  Object.defineProperty(Vue.prototype, '$http', {
    get() {
      return http;
    },
  });
}
