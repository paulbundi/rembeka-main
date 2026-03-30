import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  name: null,
  email: null,
  phone: null,
  address: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'ctob'),
    organizationId: null,
    emailFilter: null,
    phoneFilter: null,
    OrderId: null,
};

/* eslint-disable no-shadow */
const actions = {
  ...commonActions(api),
  validatePayment({ commit }, payload) {
    return api.validatePayment(payload);
  },
  attachPaymentToOrders({ commit }, payload) { 
    return api.attachPaymentToOrders(payload);
  },
};

const getters = {
  ...commonGetters(),

  /* eslint-disable no-shadow */
  getFilters(state, getters) {
    const filters = [];

    if (state.searchStr) {
      filters.push([`name,like,%25${state.searchStr}%25`]);
    }
    if (state.emailFilter) {
      filters.push([`email,like,%25${state.emailFilter}%25`]);
    }
    if (state.phoneFilter) {
      filters.push([`phone,like,%25${state.phoneFilter}%25`]);
    }

    if (state.OrderId) {
      filters.push([`order_id,eq,${state.OrderId}`]);
    }
    

    return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];
    if (state.roleFilter) {
      filters.push([`roles|role_id,=,${state.roleFilter}`]);
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
