import { set as _set } from 'lodash';
import * as TYPES from './types';

/* eslint-disable no-param-reassign */
export default {
  [TYPES.MAIN_SET_FETCHING](state, fetching) {
    state.fetching = fetching;
  },
  [TYPES.MAIN_SET_PROPERTY](state, { property, value }) {
    _set(state, property, value);
  },
};
