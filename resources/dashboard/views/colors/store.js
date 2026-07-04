import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  name: null,
  slug: null,
  hex_code: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'colors'),
};

const actions = {
  ...commonActions(api),
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