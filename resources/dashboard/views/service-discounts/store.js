import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  product_id: null,
  discount_type: 1,
  discount_amount: 0,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'discounted')
};

/* eslint-disable no-shadow */
const actions = {
  ...commonActions(api),
};

const getters = {
  ...commonGetters(),

  /* eslint-disable no-shadow */
  getFilters(state, getters) {
    const filters = [];
    return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];

    filters.push([`product|type,=,2`]);

    if (state.searchStr) {
      filters.push([`product|name,like,%25${state.searchStr}%25,or`]);
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
