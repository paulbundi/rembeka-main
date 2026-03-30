import ExpensesIndex from './components/ExpensesIndex.vue';
import ExpensesCreate from './components/ExpensesCreate.vue';

export default (Vue) => {
  Vue.component('expenses-index', ExpensesIndex);
  Vue.component('expenses-create', ExpensesCreate);
}