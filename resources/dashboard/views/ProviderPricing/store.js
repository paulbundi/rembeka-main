import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  product_id: null,
  category_id: null,
  provider_id: null,
  location_id: null,
  cost_of_labour: null,
  service_pricing: null,
  commission: null,
  service_location: null,
  status: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'provider-pricings'),
  providerId: null,
  categoryId: null,
  locationId: null,
  productId: null,
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
    if (state.providerId) {
      filters.push([`provider_id,eq,${state.providerId}`]);
    }
    if (state.categoryId) {
      filters.push([`provider_id,eq,${state.categoryId}`]);
    }

    if (state.productId) {
      filters.push([`product_id,eq,${state.productId}`]);
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
