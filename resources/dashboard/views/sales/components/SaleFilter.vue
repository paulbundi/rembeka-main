<script>
import InputFilter from '../../../views/generals/InputFilter';
import DateRange from '../../generals/DateRange.vue';

export default {
  name: 'SaleFilter',
  components: {
    InputFilter,
    DateRange,
  },
  methods: {
    handleRangeChange(value) {
     this.$emit('range-filter', value);
    },
    handlePaymentStatus(e) {
      this.$emit('payment-filter', e.target.value);
    }
  }
};
</script>
<template>
  <div class="card">
      <div class="card-body">
        <div class="d-flex flex-row justify-content-between">
          <div class="d-flex">
              <input-filter 
                module="Sales"
                :min-char-length="1"
                label="Order No."
                class="me-3"
              />
              <input-filter
                module="Sales"
                label="Email/Name."
                store-property="customerFilter"
                class="me-3"
              />
              <div class="ms-2 col-3">
                <label>Payment</label>
                <select class="form-control" @change="handlePaymentStatus">
                  <option value=""></option>
                  <option value="pending">Pending Balance</option>
                  <option value="overPay">OverPayment</option>
                </select>
              </div>
              <div class="col-3 ms-1">
                <label>Created At</label>
                <date-range @changed="handleRangeChange"/>
              </div>
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