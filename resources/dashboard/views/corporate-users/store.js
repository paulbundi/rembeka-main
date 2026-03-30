import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  corporate_id: null,
  user_id: null,
  spend_limit: null,
  limit_period: null,
  limit_hit: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'corporate-users'),
  emailFilter: null,
  phoneFilter: null,
  roleFilter: null,
  corporateId: null,
};

/* eslint-disable no-shadow */
const actions = {
  ...commonActions(api),
  attachRelations({ commit }, payload) {
    return api.addItemRelations(payload);
  },
  removeItemRelations({context}, payload) {
    return  api.removeItemRelations(payload);
  },
  resetPasswordLink({context}, payload) {
    return  api.resetPasswordLink(payload);
  },
  
};

const getters = {
  ...commonGetters(),

  /* eslint-disable no-shadow */
  getFilters(state, getters) {
    const filters = [];
    if (state.corporateId) {
      filters.push([`corporate_id,eq,${state.corporateId}`]);
    }
    return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];

    if (state.searchStr) {
      filters.push([`user|first_name,like,%25${state.searchStr}%25,or,user|last_name,like,%25${state.searchStr}%25`]);
    }
    
    if (state.emailFilter) {
      filters.push([`user|email,like,${state.emailFilter},or`]);
    }
    if (state.phoneFilter) {
      filters.push([`user|phone,like,${state.phoneFilter},or`]);
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
