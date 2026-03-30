import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  location_id: null,
  channel_id: null,
  cancel_reason: null,
  refund_status: null,
  otp: null,
  inquiry_id: null,
  admin_id: null,
  address_id: null,
   has_transport_cost: null,
  transport_cost: null,
  delivery_amount: null,
  store_id: null,
  driver_id: null,
  driver_paid: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'sales'),
  customerFilter: null,
  paymentStatus: null,
  rangeFilter: null,
};

/* eslint-disable no-shadow */
const actions = {
  ...commonActions(api),
  updateOrderStatus({ commit }, payload) {
    return api.updateOrderStatus(payload);
  },
  makePdqPayment({ commit }, payload) {
    return api.makePdqPayment(payload);
  }
};

const getters = {
  ...commonGetters(),

  /* eslint-disable no-shadow */
  getFilters(state, getters) {
    const filters = [];

    if (state.searchStr) {
      filters.push([`order_no,like,%${state.searchStr}%`]);
    }

    if(state.rangeFilter) {
      filters.push([`created_at,between,${state.rangeFilter.startDate}|${state.rangeFilter.endDate}`]);
    }
    if(state.paymentStatus) {
      if(state.paymentStatus == 'pending') {
        filters.push([`balance,gt,0`]);
      }else {
        filters.push([`balance,lt,0`]);

      }
    }

    return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];
    if (state.customerFilter) {
      filters.push([`customer|phone,like,${state.customerFilter}||customer|email,like,%25${state.customerFilter}%25||customer|first_name,like,%25${state.customerFilter}%25`]);
    }
    return filters;
  }
};

const mutations = {
  ...commonMutations(EMPTY_ENTITY),
};

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations,
};
