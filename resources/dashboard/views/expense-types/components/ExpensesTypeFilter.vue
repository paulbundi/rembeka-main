<script>
import InputFilter from '../../../views/generals/InputFilter';
import DateRange from '../../generals/DateRange.vue';
import RemoteSelector from '../../generals/RemoteSelector.vue';

export default {
  name: 'ExpensesTypeFilter',
  components: {
    InputFilter,
    RemoteSelector,
    DateRange
  },
  methods: {
    handleRangeChange(value) {
     this.$emit('range-filter', value);
    }
  }
};
</script>
<template>
  <div class="card">
      <div class="card-body">
          <div class="row">

            <div class="col-4">
              <input-filter 
                module="ExpenseTypes"
                label="Search"
                class="me-3 pt-2"
              />
            </div>

            <div class="col-8">
              <div v-if="false" class="float-end">
                <a class="btn bg-primary mt-3 text-white" href="/expense-types/create">
                  <i class="bi bi-plus-circle-fill"></i>
                  Add Expense Type
                </a>
              </div>
            </div>

          </div>
      </div>
    </div>
</template>
<style scoped>

</style>