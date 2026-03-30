import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  product_id: null,
  category_id: null,
  supplier_id: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'supplier-pricings'),
  supplierId: null,
  categoryId: null,
  locationId: null,
  productId: null,
  supplierName: null,
};

/* eslint-disable no-shadow */
const actions = {
  ...commonActions(api),
  receiveSupplierProducts({ commit }, payload) {
    return api.receiveSupplierProducts(payload);
  }

};

const getters = {
  ...commonGetters(),

  /* eslint-disable no-shadow */
  getFilters(state, getters) {
    const filters = [];
    if (state.supplierId) {
      filters.push([`supplier_id,eq,${state.supplierId}`]);
    }
    if (state.categoryId) {
      filters.push([`category_id,eq,${state.categoryId}`]);
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
