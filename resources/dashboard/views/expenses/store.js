import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
    user_id: null,
    expense: [],
  };

const state = {
  ...commonState(EMPTY_ENTITY, 'expenses'),
  expenseType: [],
  userFilter: [],
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

    if (state.searchStr) {
      filters.push([`description,like,%25${state.searchStr}%25`]);
    }

    if(state.expenseType && state.expenseType.length) {
      filters.push([`expense_type_id,in,${state.expenseType}`]);
    }

    if(state.userFilter && state.userFilter.length) {
      filters.push([`user_id,in,${state.userFilter}`]);
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
