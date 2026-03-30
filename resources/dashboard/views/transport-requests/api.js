import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('transport-requests'),

  transportRequestApprove(payload) {
    return http.get(`/transport-request-approve/${payload}`);
  },

  transportRequestDenny(payload) {
    return http.get(`/transport-request-denny/${payload}`);
  },

};
