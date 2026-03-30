import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('sales'),
  updateOrderStatus(payload) {
    return http.post(`/orders-confirm/${payload.id}`, payload);
  },
};
