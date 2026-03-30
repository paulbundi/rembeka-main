import { http } from '../../plugins/http';
import common from '../common/api';

export default {
  ...common('supplier-pricings'),

  receiveSupplierProducts(payload) {
    return http.post('/supplier-receive-products', payload);
  },

};
