import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('stk-request'),
  verifyStkTopup(payload) {
    return http.get(`/confirm-stk/${payload}`);
  }
};
