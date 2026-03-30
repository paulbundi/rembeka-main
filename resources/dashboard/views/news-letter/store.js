import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  email: null,
  user_id: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'news-letters'),
  emailFilter: null,
  phoneFilter: null,
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

    if (state.emailFilter) {
      filters.push([`email,like,%25${state.emailFilter}%25`]);
    }
 

    return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];
    if (state.roleFilter) {
      filters.push([`roles|role_id,=,${state.roleFilter}`]);
    }

    if (state.searchStr) {
      filters.push([`user|first_name,like,%25${state.searchStr}%25,or,user|last_name,like,%25${state.searchStr}%25`]);
    }

    if (state.phoneFilter) {
      filters.push([`user|phone,like,%25${state.phoneFilter}%25`]);
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
