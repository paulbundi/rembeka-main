import { http } from '../../plugins/http';
import { getData } from '../../utils/get';
import common from '../common/api';

export default {
  ...common('roles'),

  fetchPermissions() {
    return http.get(`/roles-permissions`).then(getData);
  },

  addItemRelations(payload) {
    return http.post(`/roles/${payload.id}/users`, payload);
  }
};
