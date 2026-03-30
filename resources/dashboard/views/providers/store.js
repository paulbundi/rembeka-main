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
  location_id: null,
  national_id: null,
  kra_pin: null,
  address: null,
  assign_service_by: 1,
  short_description: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'providers'),
  emailFilter: null,
  phoneFilter: null,
  roleFilter: null,
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
      filters.push([`first_name,like,%25${state.searchStr}%25,or,last_name,like,%25${state.searchStr}%25`]);
    }
    if (state.emailFilter) {
      filters.push([`email,like,%25${state.emailFilter}%25`]);
    }
    if (state.phoneFilter) {
      filters.push([`phone,like,%25${state.phoneFilter}%25`]);
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
