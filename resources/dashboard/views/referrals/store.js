import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {};

const state = {
  ...commonState(EMPTY_ENTITY, 'referrals'),
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
      filters.push([`code,like,%25${state.searchStr}%25`]);
    }
    return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];
    if (state.roleFilter) {
      filters.push([`owner|first_name,like,%25${state.roleFilter}%25`]);
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
