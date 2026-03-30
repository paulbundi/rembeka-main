import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('order-items'),

  makeProviderPayment( payload) {
    return http.get(`/provider-payment/${payload.id}`);
  },

  updateOrderItems( payload) {
    return http.post('/add-order-items', payload);
  }

};
