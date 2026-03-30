import api from './api';
import commonActions from '../common/actions';
import commonState from '../common/state';
import commonGetters from '../common/getters';
import commonMutations from '../common/mutations';

const EMPTY_ENTITY = {
  first_name: null,
  last_name: null,
  email: null,
  phone: null,
  channel_id: null,
  description: null,
  callback_date: null,
  status: null,
  user_id: null,
  social_name: null,
};

const state = {
  ...commonState(EMPTY_ENTITY, 'inquiries'),
    emailFilter: null,
    phoneFilter: null,
    rangeFilter: null,
    assignedUsers: null,
    inquiriesChannels: null,
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
      filters.push([`first_name,like,%25${state.searchStr}%25`]);
    }
    if (state.emailFilter) {
      filters.push([`email,like,%25${state.emailFilter}%25`]);
    }
    if (state.phoneFilter) {
      filters.push([`phone,like,%25${state.phoneFilter}%25`]);
    }

    if(state.rangeFilter) {
      filters.push([`callback_date,between,${state.rangeFilter.startDate}|${state.rangeFilter.endDate}`]);
    }

    if(state.assignedUsers && state.assignedUsers.length > 0) {
      filters.push([`assigned_id,in,${state.assignedUsers}`]);
    }

    if(state.inquiriesChannels && state.inquiriesChannels.length > 0) {
      filters.push([`channel_id,in,${state.inquiriesChannels}`]);
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
