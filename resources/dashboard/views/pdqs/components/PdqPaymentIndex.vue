<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';

export default {
  name: 'PdqPaymentIndex',
  props: {
    orderId: {
      type: Number,
      default: null,
    }
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      payments: state => state.PdqPayments.items,
      loading: state => state.PdqPayments.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('PdqPayments',['fetchAll', 'setProperty', 'setSelected', 'setPaginate',]),

    fetchItems() {
      if(this.orderId) {
        this.setProperty({ property: 'OrderId', value: this.orderId});
      }
      this.setProperty({property: 'relations', value: ['user']});
      this.setProperty({property: 'sorts', value:['-id']});

      this.fetchAll();
    },
  }
};
</script>
<template>
  <div>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">  
         <table class="table table-striped">
          <thead>
            <tr>
              <th>Account</th>
              <th>Initiator</th>
              <th>Order</th>
              <th>Amount</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(payment, index) in payments" :key="index">
              <td>
                XXXXXXXXXX{{ payment.card_number }}
              </td>
              <td>{{ payment.user.name }}</td>
              <td>{{ payment.order_id }} </td>
              <td>{{ payment.amount }}</td>
              <td>{{ payment.created_at | formatDate('LLL') }}</td>
            </tr>
            </tbody>
        </table>
        </div>
        <pagination class="pull-left" module="WalletAudits" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>