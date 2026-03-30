<script>
import { mapActions, mapState } from 'vuex';
import InputFilter from '../../../views/generals/InputFilter';
import RemoteSelector from '../../generals/RemoteSelector.vue';

export default {
  name: 'ExpensesFilter',
  components: {
    InputFilter,
    RemoteSelector,
  },
  methods: {
    handleExpenseType(value) {
      this.$emit('expenseType', value);
    },
    handleUserFilter(value) {
      this.$emit('userFilter', value);
    }
  }
};
</script>
<template>
  <div class="card">
      <div class="card-body">
          <div class="row">
            <div class="col-2">
              <input-filter 
                module="Expenses"
                label="Search.."
                class="me-3 pt-2"
              />
            </div>
            
            <div class="col-3">
              <label>User</label>
              <remote-selector
                module="Users"
                label="name"
                input-class="form-control"
                @change="(e) => handleUserFilter(e)"
              />
            </div>

            <div class="col-3">
              <label>Expense Type</label>
              <remote-selector
                module="ExpenseTypes"
                label="name"
                input-class="form-control"
                @change="(e) => handleExpenseType(e)"
              />
            </div>

            <div class="col-4">
              <div v-if="canUserAccess('expenses.create')" class="float-end">
                <a class="btn bg-primary mt-3 text-white" href="/expenses/create">
                  <i class="bi bi-plus-circle-fill"></i>
                  Add Expense
                </a>
              </div>
            </div>

          </div>
      </div>
    </div>
</template>
<style scoped>

</style>