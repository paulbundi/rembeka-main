/* eslint-disable no-unused-vars */
import {
  RESET_SELECTED,
  SET_SELECTED,
  SET_SEARCH_STRING,
  SET_PROPERTY,
  SET_CURRENT_PAGE,
  SET_TOTAL,
  SET_FORM_TYPE,
  SET_LOADING_ITEMS,
  SET_LOADING_ITEM,
  UPDATE_ONE_OF_ITEMS,
  UPDATE_ONE_OF_ITEMS_PROPERTY,
  REMOVE_ITEMS_RELATIONS,
  ADD_ITEMS_RELATIONS,
  REMOVE_ITEM_FROM_ITEMS,
  UPDATE_ITEMS_RELATIONS,
} from './types';

export default API => ({
  changePage({ commit }, payload) {
    commit(SET_CURRENT_PAGE, payload);
  },

  setSearchString({ commit }, payload) {
    commit(SET_SEARCH_STRING, payload);
  },

  setProperty({ commit }, payload) {
    commit(SET_PROPERTY, payload);
  },

  /*
   * Payload: {
   *   itemId
   *   item
   * }
   */
  setOneOfItems({ commit }, payload) {
    commit(UPDATE_ONE_OF_ITEMS, payload);
  },

  /*
   * Payload: {
   *   item: the item
   *   property
   *   value
   * }
   */
  setPropertyInItems({ commit }, payload) {
    commit(UPDATE_ONE_OF_ITEMS_PROPERTY, payload);
  },

  /*
   * Payload: {
   *   item: the item
   *   relationName: the name of the relation to add
   *   relations: an array of items to add
   * }
   */
  addItemRelations({ commit }, payload) {
    commit(ADD_ITEMS_RELATIONS, payload);
  },

  /*
   * Payload: {
   *   item: the item
   *   relationName: the name of the relation to remove
   *   relations: an array of items to remove
   * }
   */
  removeItemRelations({ commit }, payload) {
    commit(REMOVE_ITEMS_RELATIONS, payload);
  },

  /*
   * Payload: {
   *   item: the item
   *   relationName: the name of the relation to remove
   *   relations: an array of items to remove
   * }
   */
  updateItemRelations({ commit }, payload) {
    commit(UPDATE_ITEMS_RELATIONS, payload);
  },

  removeItemFromItems({ commit }, item) {
    commit(REMOVE_ITEM_FROM_ITEMS, item);
  },

  fetchAll({
    commit,
    state,
    getters,
    dispatch,
  }, refreshTotal = true) {
    dispatch('setFilters');
    dispatch('setHasFilters');

    const requestParams = {
      relations: state.relations,
      filters: state.filters,
      has: state.hasFilters,
      count: state.relationCounts,
      sort: state.sorts,
    };

    if (state.fields.length) {
      requestParams.fields = state.fields;
    }

    if (state.pagination.paginate) {
      requestParams.page = state.pagination.page;
      requestParams.perPage = state.pagination.perPage;
    }

    dispatch('setLoading', { type: SET_LOADING_ITEMS, value: true });
    return API
      .fetchAll(requestParams)
      .then(({ data, meta }) => {
        commit(SET_PROPERTY, { property: 'items', value: data });

        if (refreshTotal && state.pagination.paginate) {
          commit(SET_TOTAL, meta.total);
        }
        dispatch('setLoading', { type: SET_LOADING_ITEMS, value: false });

        return data;
      });
  },

  fetchOne({ commit, state, dispatch }, payload) {
    payload.relations = payload.relations || state.relations;
    payload.count = payload.relationCounts || state.relationCounts;

    dispatch('setLoading', { type: SET_LOADING_ITEM, value: true });
    return API
      .fetchOne(payload)
      .then((response) => {
        if (payload.setSelected !== false) {
          commit(SET_SELECTED, response.data);
        }

        dispatch('setLoading', { type: SET_LOADING_ITEM, value: false });

        return response;
      });
  },

  resetSelected({ commit }) {
    return commit(RESET_SELECTED);
  },

  setSelected({ commit }, payload) {
    commit(SET_SELECTED, payload);
  },

  setFormTypeCreate({ commit }, payload) {
    commit(SET_FORM_TYPE, 'create');
  },

  setFormTypeEdit({ commit }, payload) {
    commit(SET_FORM_TYPE, 'edit');
  },

  persist({ state, dispatch }) {
    dispatch('setLoading', { type: SET_LOADING_ITEM, value: true });
    if (state.formType === 'create') {
      return API.store(state.selected)
        .then((response) => {
          dispatch('resetSelected');

          dispatch('setLoading', { type: SET_LOADING_ITEM, value: false });

          return response;
        });

    }
    return API.update(state.selected)
      .then((response) => {
        dispatch('setSelected', response.data);
        dispatch('setLoading', { type: SET_LOADING_ITEM, value: false });

        return response;
      });

  },

  destroy({ dispatch }, id) {
    return API.destroy(id)
      .then(() => {
        dispatch('resetSelected');
        dispatch('removeItemFromItems', { id })
      });
  },

  fetchRelation(context, payload) {
    return API.fetchRelation(payload);
  },

  attachRelations(context, payload) {
    return API.attachRelations(payload);
  },

  attachMultiRelations(context, payload) {
    return API.attachMultiRelations(payload);
  },

  detachRelations(context, payload) {
    return API.detachRelations(payload);
  },

  detachMultiRelations(context, payload) {
    return API.detachMultiRelations(payload);
  },

  updatePivots(context, payload) {
    return API.updatePivots(payload);
  },

  setLoading({ commit, state }, { type, value }) {
    commit(type, value);

    if (value) {
      window.setTimeout(() => {
        commit(type, false);
      }, 20000);
    }
  },

  setFilters({ commit, getters, state }, filters) {
    filters = filters || getters.getFilters;

    commit(SET_PROPERTY, {
      property: 'filters',
      value: filters,
    })

    return filters;
  },

  addFilter({ commit, state }, filter) {
    const filters = state.filters.slice();
    filters.push(filter);
    commit(SET_PROPERTY, {
      property: 'filters',
      value: filters,
    })

    return filters;
  },

  setHasFilters({ commit, getters, state }, filters) {
    filters = filters || getters.getHasFilters;

    commit(SET_PROPERTY, {
      property: 'hasFilters',
      value: filters,
    })

    return filters;
  },

  addHasFilter({ commit, state }, filter) {
    const filters = state.hasFilters.slice();
    filters.push(filter);
    commit(SET_PROPERTY, {
      property: 'hasFilters',
      value: filters,
    })

    return filters;
  },

  setPaginate({ commit, getters }, paginate) {
    commit(SET_PROPERTY, {
      property: 'pagination',
      subProperty: 'paginate',
      value: paginate,
    })
  },
});
