import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  id: null,
  name: null,
  sku: null,
  description: null,
  keywords: null,
  seo_title: null,
  seo_description: null,
  status: 1,
  menu_id: null,
  type: null,
  product_used: null,
  duration_of_style: null,
  durability: null,
  update_provider_pricing: null,
  age_groups: [],
  category_id: null,
  cost_of_labour: null,
  provider_cost: null,
  commission: null,
  product_price: null,
  is_published: 1,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'products'),
    filterByMenu: null,
    filterByCategory: null,
    filterByStatus: null,
    filterByType: 1,
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

    if (state.searchStr) {
      filters.push([`name,like,%25${state.searchStr}%25`]);
    }
    if (state.filterByMenu && state.filterByMenu.length > 0) {
      filters.push([`menu_id,in,[${state.filterByMenu}]`]);
    }
    if(state.filterByCategory && state.filterByCategory.length > 0) {
      filters.push([`category_id,in,[${state.filterByCategory}]`]);
    }
    if(state.filterByType && state.filterByType.length > 0) {
      filters.push([`type,in,[${state.filterByType}]`]);
    }
    if(state.filterByStatus && state.filterByStatus.length > 0) {
      filters.push([`status,in,[${state.filterByStatus}]`]);
    }

    
    return filters;
  },

  getHasFilters(state, getters) {
    const filters = [];
    if (state.roleFilter) {
      filters.push([`roles|role_id,=,${state.roleFilter}`]);
    }
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
