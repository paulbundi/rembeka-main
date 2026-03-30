import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  organization_name: null,
  email: null,
  phone: null,
  address: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'corporates'),
  emailFilter: null,
  phoneFilter: null,
  roleFilter: null,
  filterByAccount: 4,
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
  
  transferFunds({context}, payload) {
    return  api.transferFunds(payload);
  },
  
};

const getters = {
  ...commonGetters(),

  /* eslint-disable no-shadow */
  getFilters(state, getters) {
    const filters = [];

    if (state.searchStr) {
      filters.push([`first_name,like,%25${state.searchStr}%25,or,last_name,like,%25${state.searchStr}%25`]);
    }
    if (state.emailFilter) {
      filters.push([`email,like,%25${state.emailFilter}%25`]);
    }
    if (state.phoneFilter) {
      filters.push([`phone,like,%25${state.phoneFilter}%25`]);
    }

    if(state.filterByAccount) {
      filters.push([`account_type,eq,${state.filterByAccount}`]);
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
