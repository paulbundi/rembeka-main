import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {};

const state = {
  ...commonState(EMPTY_ENTITY, 'supplier-invoices'),
  supplierId: null,
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
    if (state.supplierId) {
      filters.push([`supplier_id,eq,${state.supplierId}`]);
    }
     return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];
    if (state.searchStr) {
      filters.push([`product|name,like,%25${state.searchStr}%25`]);
    }

    // if (state.locationId) {
    //   filters.push([`provider.locations|locations.id,eq,${state.locationId}`]);
    // }
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
