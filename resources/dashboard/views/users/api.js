import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('users'),

  addItemRelations(payload) {
    return http.post(`/users/${payload.id}/roles`, payload);
  },
  removeItemRelations(payload) {
    return http.post(`/users/${payload.id}/roles/detach`, payload);
  },
  resetPasswordLink(payload) {
    return http.post(`/user-reset-password-link/${payload}`);
  },

  transferFunds(payload) {
    return http.post(`/inter-account-transfer/`, payload);
  },

};
