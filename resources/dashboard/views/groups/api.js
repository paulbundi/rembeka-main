import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('groups'),

  refreshMembers(payload) {
    return http.get(`/group-members-refresh/${payload.id}`);
  }
};
