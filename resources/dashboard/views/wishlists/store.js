import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {

};

const state = {
  ...commonState(EMPTY_ENTITY, 'wishlists'),
  userId: null,
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

    if(state.userId) {
      filters.push([`user_id,eq,${state.userId}`]);
    }

    return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];
      if (state.searchStr) {
        filters.push([`user|first_name,like,%25${state.searchStr}%25,or,user|last_name,like,%25${state.searchStr}%25`]);
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
