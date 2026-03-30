import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  title: null,
  permissions: [],
  description: null,
  organization_id: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'roles'),
  permissions: null,
  roleFilter: null,
};

/* eslint-disable no-shadow */
const actions = {
  ...commonActions(api),
  
  fetchPermissions() {
    return api.fetchPermissions();
  },

  attachRelations({ commit }, payload) {
    return api.addItemRelations(payload);
  },

};

const getters = {
  ...commonGetters(),

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
