import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  first_name: null,
  last_name: null,
  email: null,
  phone: null,
  address: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'users'),
  emailFilter: null,
  phoneFilter: null,
  roleFilter: null,
  filterByAccount: null,
  organisationId: null,
  hideCorporateAccount: false,
  organizationName: null,
  userAndCorporate: null,
  returnTimes: null,
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

    if (state.organizationName) {
      filters.push([`organization_name,like,%25${state.organizationName}%25`]);
    }
    
    if (state.userAndCorporate) {
      filters.push([`first_name,like,%25${state.userAndCorporate}%25,or,last_name,like,%25${state.userAndCorporate}%25,or,organization_name,like,%25${state.userAndCorporate}%25`]);
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

    if(state.organisationId) {
      filters.push([`organization_id,eq,${state.organisationId}`]);
    }

    if(state.hideCorporateAccount) {
      filters.push([`account_type,neq,4`]);
    }

    if(state.returnTimes) {
      filters.push([`return_times,eq,${state.returnTimes}`]);
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
