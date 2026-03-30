import getMultiQueryString from '../../store/getMultiQueryString';
import { getData } from '../../utils/get';
import { http } from '../../plugins/http';
import config from './config';

export default ENDPOINT => ({
  getRoot() {
    return `/${config.prefix.api}${ENDPOINT}`;
  },

  fetchAll(payload) {
    const query = getMultiQueryString(payload);

    return http
      .get(`${this.getRoot()}?${query}`)
      .then(getData);
  },

  fetchOne(payload) {
    const query = getMultiQueryString(payload);

    return http.get(`${this.getRoot()}/${payload.id}?${query}`)
      .then(getData);
  },

  store(payload) {
    return http.post(`${this.getRoot()}`, payload)
      .then(getData);
  },

  update(payload) {
    return http.put(`${this.getRoot()}/${payload.id}`, payload)
      .then(getData);
  },

  destroy(id) {
    return http.delete(`${this.getRoot()}/${id}`);
  },

  attachRelations(payload) {
    const data = {};
    data.data = payload.data;
    data.pivots = payload.pivots;
    return http.post(`${this.getRoot()}/${payload.id}/${payload.relation}`, data)
      .then(getData);
  },

  attachMultiRelations(payload) {
    const data = {};
    data.items = payload.items;
    data.relations = payload.relations;

    return http.post(`${this.getRoot()}/multi/${payload.relation}`, data)
      .then(getData);
  },

  fetchRelation(payload) {
    const query = getMultiQueryString(payload);
    const { relation, id } = payload;

    return http
      .get(`${this.getRoot()}/${id}/${relation}?${query}`)
      .then(getData);
  },

  detachRelations(payload) {
    const data = {
      data: {
        data: payload.data,
        pivots: payload.pivots,
      },
    };

    return http.delete(`${this.getRoot()}/${payload.id}/${payload.relation}`, data)
      .then(getData);
  },

  detachMultiRelations(payload) {
    const data = {};
    data.items = payload.items;
    data.relations = payload.relations ? payload.relations : null;

    return http.delete(`${this.getRoot()}/multi/${payload.relation}`, { data })
      .then(getData);
  },

  updatePivots(payload) {
    const data = {};
    data.data = payload.data;
    data.pivots = payload.pivots;

    return http.put(`${this.getRoot()}/${payload.id}/${payload.relation}/update-pivots`, data)
      .then(getData);
  },
});
