import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import getters from './getters'
import modules from './modules'
import mutations from './mutations'
import state from './state'

Vue.use(Vuex)

// lets setup the state before initializing the store.
Object.keys(window.store).forEach((key) => {
  state[key] = window.store[key];
});

Object.keys(window.vuex).forEach((key) => {
  state[key] = window.vuex[key];
});

export default new Vuex.Store({
  actions,
  getters,
  modules,
  mutations,
  state,
  strict: process.env.NODE_ENV !== 'production',
})
