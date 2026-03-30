<script>
import { mapActions, mapState } from 'vuex'
import pageChange from '../../../mixins/pageChange';
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors';

export default {
  name: 'PaymentForm',
  mixins: [
    updateProperty,
    pageChange,
  ],
  computed: {
    ...mapState({
      selected: state => state.WalletTops.selected,
      corporate: state => state.Corporates.selected,
      user: state => state.authUser,
    }),
  },
  methods: {
    ...mapActions('WalletTops',['setProperty', 'persist']),
    accountTopUp() {

      this.updateProperty('user_id', this.user.id);
      this.updateProperty('corporate_id', this.corporate.id);

      this.persist().then(() => {
        this.$toast.success('Wallet updated successfully');
        this.$emit('refreshPage');
      }).catch(({response}) => {
      catchValidationErrors(this, response);
      });
    }
  }
}
</script>
<template>
  <div>
    <form>
      <div class="my-2">
        <label>Transaction Number</label>
        <input type="text" class="form-control" :value="selected.transaction_no" @input="(e) => updateProperty('transaction_no', e.target.value)"/>
      </div>
      <div class="my-2">
        <label>Description</label>
        <textarea class="form-control" @input="(e) => updateProperty('description', e.target.value)">{{selected.description}}</textarea>
      </div>
      <div class="my-2">
        <label>Amount</label>
        <input type="number" min="0" :value="selected.amount" class="form-control" @input="(e) => updateProperty('amount', e.target.value)"/>
      </div>
      <div class="my-2">
        <label>Payment Mode</label>
        <select class="form-control" :value="selected.payment_mode" @change="(e) => updateProperty('payment_mode', e.target.value)">
          <option value="1">Cheque</option>
          <option value="2">Mpesa</option>
          <option value="3">Bank Deposit</option>
        </select>
      </div>
    </form>
    <div class="col-12 mt-2">

      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      <button type="button" class="btn btn-primary float-end" @click="accountTopUp">Top up</button>
    </div>
  </div>
</template>

<style>

</style>