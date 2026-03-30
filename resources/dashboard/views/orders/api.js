import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('orders'),

    updateOrderStatus(payload) {
      return http.post(`/orders-confirm/${payload.id}`, payload);
    },
    resendInvoice(payload) {
      return http.get(`/orders-ask-for-payment/${payload}`);
    },
    payOrderFromWallet(payload) {
      return http.post(`/order-wallet-payment`,payload);
    },
    reworkPayable(payload) {
      return http.get(`/order-re-work-payable/${payload.id}`);
    },
    makePdqPayment(payload) {
      return http.post(`/order-pdq-payment`,payload);
    },
    
};
