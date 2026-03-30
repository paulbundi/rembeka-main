import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  user_id: null,
  card_number: null,
  receipt_id: null,
  order_id: null,
  amount: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'pdq-payments'),
  OrderId: null,
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
    if(state.OrderId) {
      filters.push([`order_id,eq,${state.OrderId}`]);
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
