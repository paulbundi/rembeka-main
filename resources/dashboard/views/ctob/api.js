import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('ctob'),
  validatePayment(paylaod) {
    return http.post('/validate-c2b', paylaod);
  },
  attachPaymentToOrders(paylaod) {
    return http.post('/attach-payment-to-order', paylaod);
  },
  
};
