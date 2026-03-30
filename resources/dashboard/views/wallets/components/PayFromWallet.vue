<script>
import { mapActions } from 'vuex';
  export default {
    name: 'PayFromWallet',
    props: {
      order:{
        type: Object,
        required: true,
      }
    },
    methods: {
      ...mapActions('Orders', ['payOrderFromWallet']),
      payFromWallet() {
      if(this.order.customer == null) {
        return;
      }
      this.payOrderFromWallet({orderId: this.order.id}).then(() => {
				this.$toast.success('success');
        setTimeout(() => {
          window.location.reload();
        },500)

      }).catch(({response}) => {
        this.$toast.error('Please check wallet Balance');
      });
    }
    }
  };
</script>
<template>
  <div class="h-100">
    <div v-if="order.balance > 0 && order.customer" class="card h-100" :class="order.customer.account_type == 4? 'bg-dark': 'bg-secondary'">
      <div class="card-body">
        <h6 class="fw-bold text-white">{{order.customer.account_type == 4 ? 'Corporate': 'Names'}} : {{ order.customer.name }}</h6>
        <h6 class="fw-bold text-white">Wallet Amount:  {{ order.customer.wallet }}</h6>
        <h6 class="fw-bold text-white">Order balance:  {{ order.balance }}</h6>
        
          <button v-if="order.customer.wallet != 0 && canUserAccess('corporates.pay-orders')" class="btn btn-primary btn-sm" @click="payFromWallet">Pay from wallet</button>
          <b v-if="order.customer.wallet < 1 " class="fw-bold text-warning">Please top up wallet</b>
      </div>
    </div>
    <div v-else class="card">
      <div class="card-body">
        <b class="text-primary">Order Paid</b>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>

</style>