import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('btoc'),
  reverseTransaction(payload) {
    return http.get(`/btoc-reverse/${payload}`,);
  },

};
