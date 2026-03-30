import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
};

const state = {
  ...commonState(EMPTY_ENTITY, 'stk-request'),
  orderNo: null,
  OrderId: null,
};

/* eslint-disable no-shadow */
const actions = {
  ...commonActions(api),
  verifyStkTopup({context}, payload) {
    return api.verifyStkTopup(payload);
  }
};

const getters = {
  ...commonGetters(),

  /* eslint-disable no-shadow */
  getFilters(state, getters) {
    const filters = [];

    if (state.searchStr) {
      filters.push([`name,like,%25${state.searchStr}%25`]);
    }

    if (state.orderNo) {
      filters.push([`reference_id,like,%25${state.orderNo}%25`]);
    }

    if (state.OrderId) {
      filters.push([`order_id,eq,${state.OrderId}`]);
    }
    
    return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];
    if (state.searchStr) {
      filters.push([`users|first_name,like,%25${state.roleFilter}%25`]);
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
