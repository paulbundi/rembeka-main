<script>
import InputFilter from '../../../views/generals/InputFilter';
import DateRange from '../../generals/DateRange.vue';

export default {
  name: 'OrderFilter',
  components: {
    InputFilter,
    DateRange,
  },
  methods: {
    handleRangeChange(value) {
     this.$emit('range-filter', value);
    },
    handleChange(value) {
     this.$emit('payment-filter', value.target.value);
    }
  }
};
</script>
<template>
<div class="card">
  <div class="card-body">
    <div class="d-flex flex-row justify-content-between">
      <div class="row">
        <div class="col-4">
          <input-filter 
            module="Orders"
            :min-char-length="1"
            label="Order No."
            class="me-3"
          />
        </div> 
        <div class="col-5">
            <label>Payment Status</label>
            <select class="form-control" @change="handleChange">
              <option value=""></option>
              <option value="balance">Pending balance</option>
              <option value="fullypaid">Fully Paid</option>
            </select>
        </div>
      </div>
      <div class="col-2">
        <label>Created At</label>
        <date-range @changed="handleRangeChange"/>
      </div>

      <div>

      <div v-if="canUserAccess('orders.create')"  class="btn-group">
        <a class="btn btn-primary float-end" href="/system-orders/create">
          <i class="bi bi-plus-circle"></i>
          Create Order
        </a>
        <button type="button" class="btn btn-sm btn-success  dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">          
          <li>
            <a class="dropdown-item" href="/corporate-orders/create">
              <i class="bi bi-plus-circle"></i>
              Create Corporate Order
            </a>
          </li>
        </ul>
      </div>
       
      </div>
    </div>
  </div>
</div>
</template>

<style>

</style>