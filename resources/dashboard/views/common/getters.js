export default () => ({
  getNormalizedEntity(state) {
    return (entityName, id) => {
      return state.itemsNormalized.entities[entityName]
        ? state.itemsNormalized.entities[entityName][id]
        : null;
    }
  },
  getNormalizedEntities(state, getters) {
    return (entityName, ids) => {
      if (!state.itemsNormalized.entities[entityName]) {
        return [];
      }
      const out = [];
      // if ids not provided, send everything back
      ids = ids || Object.keys(state.itemsNormalized.entities[entityName]);

      ids.forEach((id) => {
        const entity = getters.getNormalizedEntity(entityName, id);
        if (entity) {
          out.push(entity);
        }
      });
      return out;
    }
  },
});
