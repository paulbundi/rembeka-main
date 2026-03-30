import * as TYPES from './types';

export default {

  setFetching({ commit }, fetching) {
    commit(TYPES.MAIN_SET_FETCHING, fetching);
  },

  setProperty({ commit }, payload) {
    commit(TYPES.MAIN_SET_PROPERTY, payload);
  },
};
