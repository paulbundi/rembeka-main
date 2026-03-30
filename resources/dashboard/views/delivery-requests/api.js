import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('delivery-requests'),

  transportRequestApprove(payload) {
    return http.get(`/delivery-request-approve/${payload}`);
  },

  transportRequestDenny(payload) {
    return http.get(`/delivery-request-denny/${payload}`);
  },

};
