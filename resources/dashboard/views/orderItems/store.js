import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  order_id: null,
  product_id: null,
  category_id: null,
  provider_id: null,
  quantity: null,
  status: null,
  appointment_date: null,
  appointment_time: null,
  amount: null,
  discounted: null,
  discount_amount: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'order-items'),
  customerFilter: null,
  providerFilter: null,
  customerId: null,
};

/* eslint-disable no-shadow */
const actions = {
  ...commonActions(api),
  makeProviderPayment({ commit }, payload) {
    return api.makeProviderPayment(payload);
  },
  updateOrderItems({ commit }, payload) {
    return api.updateOrderItems(payload);
  }
};

const getters = {
  ...commonGetters(),

  /* eslint-disable no-shadow */
  getFilters(state, getters) {
    const filters = [];

    if (state.searchStr) {
      filters.push([`order_no,like,%25${state.searchStr}%25`]);
    }

    if(state.providerFilter) {
      filters.push([`provider_id,in,${state.providerFilter}`]);

    }
    return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];
    if (state.customerFilter) {
      filters.push([`customer|phone,like,${state.customerFilter}or||customer|email,like,%25${state.customerFilter}%25,or||customer|first_name,like,%25${state.customerFilter}%25,or`]);
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
