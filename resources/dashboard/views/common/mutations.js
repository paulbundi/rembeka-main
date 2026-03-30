/* eslint-disable no-shadow */
import {
  set as _set,
  difference as _difference,
  union as _union,
} from 'lodash';

import {
  RESET_SELECTED,
  SET_SELECTED,
  SET_SEARCH_STRING, SET_PROPERTY,
  SET_TOTAL,
  SET_CURRENT_PAGE,
  SET_FORM_TYPE,
  SET_LOADING_ITEMS,
  SET_LOADING_ITEM,
  UPDATE_ONE_OF_ITEMS,
  UPDATE_ONE_OF_ITEMS_PROPERTY,
  REMOVE_ITEMS_RELATIONS,
  ADD_ITEMS_RELATIONS,
  UPDATE_ITEMS_RELATIONS,
  REMOVE_ITEM_FROM_ITEMS,
  SET_NORMALIZED_PROPERTY,
  ADD_NORMALIZED_ENTITIES,
  REMOVE_NORMALIZED_ENTITIES,
  UPDATE_NORMALIZED_ENTITY,
  ADD_NORMALIZED_ENTITY_RELATIONS,
  REMOVE_NORMALIZED_ENTITY_RELATIONS,
} from './types';

export default emptyEntity => ({
  [SET_CURRENT_PAGE](state, payload) {
    state.pagination.page = payload;
  },
  [SET_TOTAL](state, payload) {
    state.pagination.total = payload;
  },
  [RESET_SELECTED](state) {
    state.selected = { ...emptyEntity };
    state.formType = 'create';
  },
  [SET_SELECTED](state, payload) {
    state.selected = { ...payload };
    state.formType = 'edit';
  },
  [SET_SEARCH_STRING](state, payload) {
    state.searchStr = payload;
  },
  [SET_FORM_TYPE](state, payload) {
    state.formType = payload;
  },
  [SET_LOADING_ITEMS](state, payload) {
    state.loadingItems = payload;
  },
  [SET_LOADING_ITEM](state, payload) {
    state.loadingItem = payload;
  },
  [SET_PROPERTY](state, { property, subProperty, value }) {
    if (subProperty) {
      state[property] = {
        ...state[property],
        [subProperty]: value,
      };

      return;
    }

    _set(state, property, value);
  },

  [UPDATE_ONE_OF_ITEMS](state, payload) {
    const index = state.items.findIndex(i => i.id === payload.itemId);
    if (index === -1) {
      return;
    }
    const items = [...state.items];

    // only update the properties of the given item
    if (payload.onlyGivenProperties) {
      Object.keys(payload.item).forEach((k) => {
        items[index][k] = payload.item[k];
      });
    } else {
      // over write whole object
      items[index] = { ...payload.item };
    }

    state.items = [...items];
  },

  [UPDATE_ONE_OF_ITEMS_PROPERTY](state, payload) {
    const items = [...state.items];
    const index = items.findIndex(i => i.id === payload.item.id);
    if (index === -1) {
      return;
    }
    _set(items[index], payload.property, payload.value);
    state.items = items;
  },

  [REMOVE_ITEMS_RELATIONS](state, payload) {
    const index = state.items.findIndex(i => i.id === payload.item.id);
    if (index === -1) {
      return;
    }
    payload.relations.forEach((r) => {
      const rels = state.items[index][payload.relationName];
      const relationIndex = rels.findIndex(rel => rel.id === r.id);
      if (relationIndex === -1) {
        return;
      }
      rels.splice(relationIndex, 1);
    });
  },

  [ADD_ITEMS_RELATIONS](state, payload) {
    const index = state.items.findIndex(i => i.id === payload.item.id);
    if (index === -1) {
      return;
    }
    payload.relations.forEach((r) => {
      const rels = state.items[index][payload.relationName];
      if (rels.findIndex(rel => rel.id === r.id) === -1) {
        rels.push({ ...r });
      }
    });
  },

  [UPDATE_ITEMS_RELATIONS](state, payload) {
    const index = state.items.findIndex(i => i.id === payload.item.id);
    if (index === -1) {
      return;
    }
    payload.relations.forEach((r) => {
      const rels = state.items[index][payload.relationName];
      const itemIndex = rels.findIndex(rel => rel.id === r.id);

      if (itemIndex === -1) {
        rels.push(r);
        return;
      }

      rels[itemIndex] = r;
    });
  },

  [REMOVE_ITEM_FROM_ITEMS](state, item) {
    const index = state.items.findIndex(i => i.id === item.id);
    if (index === -1) {
      return;
    }
    state.items.splice(index, 1);
  },

  [SET_NORMALIZED_PROPERTY](state, {
    entityName,
    id,
    property,
    value,
  }) {
    const obj = state.itemsNormalized.entities[entityName][id];
    _set(obj, property, value);
  },

  [ADD_NORMALIZED_ENTITIES](state, { entities, entityName }) {
    if (!state.itemsNormalized.entities[entityName]) {
      state.itemsNormalized.entities[entityName] = {};
    }
    entities.forEach((e) => {
      state.itemsNormalized.entities[entityName][e.id] = { ...e };
    });
  },

  [REMOVE_NORMALIZED_ENTITIES](state, { entityIds, entityName }) {
    entityIds.forEach((eId) => {
      delete state.itemsNormalized.entities[entityName][eId];
    });
    if (state.namespace && entityName === state.namespace) {
      state.itemsNormalized.result = _difference(state.itemsNormalized.result, entityIds);
    }
  },

  [UPDATE_NORMALIZED_ENTITY](state, { item, id, entityName }) {
    const i = { ...item };
    entityName = entityName || state.namespace;
    id = id || item.id;

    if (!state.itemsNormalized.entities[entityName]) {
      state.itemsNormalized.entities[entityName] = {};
    }
    Object.keys(i).forEach((key) => {
      state.itemsNormalized.entities[entityName][id][key] = i[key];
    });
  },

  [ADD_NORMALIZED_ENTITY_RELATIONS](state, {
    id,
    relations,
    relationName,
    entityName,
  }) {
    entityName = entityName || state.namespace;

    const current = state.itemsNormalized.entities[entityName][id][relationName];
    state.itemsNormalized.entities[entityName][id][relationName] = _union(current, relations);
  },

  [REMOVE_NORMALIZED_ENTITY_RELATIONS](state, {
    id,
    relations,
    relationName,
    entityName,
  }) {
    entityName = entityName || state.namespace;

    const current = state.itemsNormalized.entities[entityName][id][relationName];
    state.itemsNormalized.entities[entityName][id][relationName] = _difference(current, relations);
  },
});
