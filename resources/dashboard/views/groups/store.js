import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  id: null,
  name: null,
  description : null,
  product_id: null,
  from_sales: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'groups'),
 
};

/* eslint-disable no-shadow */
const actions = {
  ...commonActions(api),
  refreshMembers({ commit }, payload) {
    return api.refreshMembers(payload);
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
    return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];
   
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
