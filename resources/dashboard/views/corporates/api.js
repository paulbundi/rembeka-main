import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('corporates'),

  addItemRelations(payload) {
    return http.post(`/users/${payload.id}/roles`, payload);
  },

  resetPasswordLink(payload) {
    return http.post(`/user-reset-password-link/${payload}`);
  },

  transferFunds(payload) {
    return http.post(`/inter-account-transfer/`, payload);
  },

  

};
