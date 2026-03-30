
<script>
import { mapActions, mapState } from 'vuex';
import catchValidationErrors from '../../../utils/catchValidationErrors'

export default {
  name:'TransferFunds',
  data() {
    return {
        loading: false,
        amount: 0,
        description: null,
        receiving_account: null,
    };
  },
  computed: {
    ...mapState({
      corporate: state => state.Corporates.selected,
      user: state => state.authUser,
    }),
  },
  methods: {
    ...mapActions('Corporates',['transferFunds']),

    handletransferFunds() {
      if(this.amount < 1 || this.amount > this.corporate.amount || !this.description) {
        this.$toast.error('Please provide a reason and a valid amount to transfer');
         return;
      }

      if(this.receiving_account == null) {
        this.$toast.error('Please select the receiving account');
        return;
      }
      if(this.name > this.corporate.amount) {
          this.$toast.error('Too much money! Not good :)');
        return;
      }

      let payload = {
        amount: this.amount,
        description: this.description,
        receiving_account: this.receiving_account,
        user_id:this.user.id,
        giving_account: this.corporate.id,
      };

      this.loading = true;

      this.transferFunds(payload).then(() => {
        this.$toast.success('Transfer made successfully');
        this.$emit('refreshPage');
      }).catch(({response}) => {
        catchValidationErrors(this, response);
      }).finally(() => {
        this.loading = false;
      })

    }
  }
};
</script>

<template>
  <div>
    <div class="my-2">
      <label>Amount</label>
      <input type="number" min="0" class="form-control" v-model="amount"/>
    </div>

    <div class="my-2">
      <label>Description</label>
      <textarea class="form-control" v-model="description">{{description}}</textarea>
    </div>

    <div class="my-2">
      <label>Select Recipient wallet</label>
      <remote-selector
          module="Users"
          label="name"
          filter-property="userAndCorporate"
          :multiple="false"
          @change="(id) => receiving_account = id"
        />
    </div>
    <div class="mt-4">
        <button class="btn btn-primary float-end" :disabled="loading" @click="handletransferFunds">Transfer</button>
    </div>
  </div>
</template>


<style lang="scss" scoped>

</style>