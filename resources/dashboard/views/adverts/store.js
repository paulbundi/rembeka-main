import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  name: null,
  call_to_action_url: null,
  call_to_action: null,
  type: 1,
  product_id: null,
  status: null,
  audit: null,
  banner_image: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'adverts'),
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
