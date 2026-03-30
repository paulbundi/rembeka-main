<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import BtocFilter from './btocFilter.vue';

export default {
  name: 'BtocIndex',
  components: {
    BtocFilter,
  },
  mixins: [
    pageChange,
  ],
  data() {
    return {
      loadingId: null,
    };
  },
  computed: {
    ...mapState({
      items: state => state.Btoc.items,
      loading: state => state.Btoc.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Btoc',['fetchAll', 'setProperty', 'persist', 'destroy',
    'setSelected', 'resetSelected', 'setPaginate', 'reverseTransaction'
  ]),

    fetchItems() {
      this.setProperty({ property: 'sorts', value: ['-id']});
      this.setProperty({property: 'relations', value: ['user'] });
      this.fetchAll();
    },
    handleReverseTransaction(transaction) {
      this.loadingId = transaction.id;
      this.reverseTransaction(transaction.id).then(() => {
        this.fetchItems();
        this.$toast.success('Transaction Reversed');
      }).finally(() => {
        this.loadingId = null;
      });
    }
  }
};
</script>
<template>
  <div>
    <btoc-filter/>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <h4>3031827</h4>
        <div class="table-responsive">
          <table class="table m-b-0">
            <thead>
              <tr>
              <th>Account</th>
              <th>Amount</th>
              <th>Bill Reference Number</th>
              <th>Originator Conversation ID</th>
              <th>Transaction Receipt</th>
              <th>Error Code</th>
              <th>Error Message</th>
              <th>Transaction Date</th>
              <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(withdraw, index) in items" :key="index">
                <td>
                  <span v-if="withdraw.user">
                      {{ withdraw.user.name }}<br/>
                      <span class="text-blue">{{ withdraw.user.email }}</span>
                  </span>
                </td>
                <td>{{ withdraw.amount }} </td>
                <td>{{ withdraw.bill_reference_number }} </td>
                <td>{{ withdraw.originator_conversation_id }}</td>
                <td>{{ withdraw.transaction_receipt }}</td>
                <td>{{ withdraw.error_code }}</td>
                <td>{{ withdraw.error_message }}</td>
                <td>{{ withdraw.created_at | formatDate('LL') }}</td>
                <td>
                  <span v-if="withdraw.status == 1" class="badge bg-info">INITIATED</span>
                  <span v-if="withdraw.status == 2" class="badge bg-success">CONFIRMED</span>
                  <span v-if="withdraw.status == 3" class="badge bg-dark">FAILED</span>
                  <span v-if="withdraw.status == 4" class="badge bg-danger">CANCELLED</span>
                  <span v-if="withdraw.status == 5" class="badge bg-warning">REVERSED</span>
                  <template v-if="canUserAccess('btoc.wallet-reversal') && withdraw.status == 3">
                    <div v-if="loadingId ==withdraw.id">
                        <button v-loading="true" class="btn btn-sm text-white float-end"></button>
                      </div>
                    <button v-else class="btn btn-primary btn-sm" @click="() =>handleReverseTransaction(withdraw)">Reverse to wallet</button>
                  </template>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Btoc" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>