import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
 
};

const state = {
  ...commonState(EMPTY_ENTITY, 'customer-orders'),
  customerId: null,

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

    if(state.customerId) {
      filters.push([`user_id,eq,${state.customerId}`]);
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
