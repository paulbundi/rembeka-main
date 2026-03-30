import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {

  first_name:null,
  last_name:null,
  user_id:null,
  name:null,
  email:null,
  phone:null,
  national_id:null,
  kra_pin:null,
  address:null,
  slug:null,
  description:null,
  type:null,
  status:null,
  rating:null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'suppliers'),
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
      filters.push([`first_name,like,${state.searchStr}%25,or,name,like,${state.searchStr}%25,or`]);
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
