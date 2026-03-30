import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  user_id: null,
  corporate_id: null,
  description: null,
  amount: null,
  transaction_no: null,
  payment_mode: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'wallet-audits'),
  userWallet: null,
  OrderId: null,
  Initiator: null,
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

    if(state.userWallet) {
       filters.push([`auditable_id,eq,${state.userWallet}`]);
       filters.push([`auditable_type,eq,App\\Models\\User`]);
    }

    if(state.Initiator) {
      filters.push([`user_id,eq,${state.Initiator}`]);
   }

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
