import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  user_id: null,
  inquiry_id: null,
  activity: 1,
  title: null,
  description: null,
  acivity_link: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'inquiry-activities'),
  inquiryId: null,
 
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
    if (state.inquiryId) {
      filters.push([`inquiry_id,eq,${state.inquiryId}`]);
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
