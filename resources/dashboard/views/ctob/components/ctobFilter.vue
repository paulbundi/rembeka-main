<script>
import { mapActions } from 'vuex';
import InputFilter from '../../../views/generals/InputFilter';
import catchValidationErrors from '../../../utils/catchValidationErrors';

export default {
  name: 'OrderFilter',
  components: {
    InputFilter,
  },
  data() {
    return {
      transaction_id: null,
      loading: false,
    }
  },
  methods: {
    ...mapActions('Ctob',['validatePayment', 'fetchAll']),
    showValidateTransactionModal() {
      $('#validatePayment').modal('show');
    },
    handleValidatePayment() {
      this.loading = true;
      this.validatePayment({transaction_id: this.transaction_id}).then(() => {
        this.$toast.success('Request Made');
        $('#validatePayment').modal('hide');
        this.setInterval(() => {
          this.fetchAll();
        }, 2000);
      }).catch(({response}) => {
        catchValidationErrors(this, response)
      }).finally(() => {
        this.loading = false;
      });
    }
  }
};
</script>
<template>
  <div class="card">
    <div class="card-body">
      <h6>Filter</h6>
      <div class="d-flex flex-row justify-content-between">
        <div class="d-flex">
            <input-filter 
              module="Users"
              label="Names"
              class="me-3"
            />
            <input-filter 
              module="Users"
              label="Email"
              store-property="emailFilter"
              class="me-3"
            />
            <input-filter 
              module="Users"
              label="Phone"
              store-property="phoneFilter"
            />
        </div>
        <button class="btn btn-sm btn-primary" @click="showValidateTransactionModal">Validate Transaction</button>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="validatePayment" tabindex="-1" aria-labelledby="validatePaymentLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="validatePaymentLabel">Confirm Payment</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <label>Enter Mpesa confirmation Id</label>
              <input type="text" v-model="transaction_id" class="form-control" placeholder="XCHGFFDD" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button v-if="loading == false" type="button" class="btn btn-primary" @click="handleValidatePayment">Validate Payment</button>
            <button v-loading="loading" class="btn text-white float-end"></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>

</style>