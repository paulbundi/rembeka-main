import ExpenseTypeIndex from './components/ExpenseTypeIndex.vue';
import ExpenseTypeCreate from './components/ExpenseTypeCreate.vue';

export default (Vue) => {
  Vue.component('expense-type-index', ExpenseTypeIndex);
  Vue.component('expense-type-create', ExpenseTypeCreate);
}