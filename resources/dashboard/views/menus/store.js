import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  name: null,
  description : null,
  parent_id : null,
  status : 0,
  icon: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'menus'),
  filterMenuBy: 'ParentOnly',
  menuType: null,
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

    if(state.menuType) {
      filters.push([`type,eq,${state.menuType}`]);
    }

    if (state.filterMenuBy == 'parentOnly') {
      filters.push([`parent_id,eq,null`]);
    }else {

      filters.push([`parent_id,neq,null`]);

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
