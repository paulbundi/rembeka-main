import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  user_id: null,
  notes: null,
  status: null, 
  location_id: null, 
  channel_id: null,
  order_items: [],
  has_transport_cost: 1,
  delivery_amount: null,
  store_id: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'orders'),
  customerFilter: null,
  rangeFilter: null,
  paymentFilter: null,
  providerFilter: null,
};

/* eslint-disable no-shadow */
const actions = {
  ...commonActions(api),
  updateOrderStatus({ commit }, payload) {
    return api.updateOrderStatus(payload);
  },
  resendInvoice({ commit }, payload) {
    return api.resendInvoice(payload);
  },
  payOrderFromWallet({ commit }, payload) {
    return api.payOrderFromWallet(payload);
  },
  reworkPayable({ commit }, payload) {
    return api.reworkPayable(payload);
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

    if(state.paymentFilter) {
       if(state.paymentFilter == 'balance') {
          filters.push([`balance,gt,0`]);
       }
       if(state.paymentFilter == 'fullypaid') {
        filters.push([`balance,eq,0`]);
       }
        if(state.paymentFilter == 'overpayment') {
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

    if  (state.providerFilter) {
      filters.push([`items|provider_id,=,${state.providerFilter}`]);
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
