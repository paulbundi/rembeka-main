<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import WalletAuditFilter from './partials/WalletAuditFilter.vue';
import catchValidationErrors from '../../../utils/catchValidationErrors';

export default {
  name: 'WalletAudits',
  props: {
    id: {
      type: Number,
      default: null,
    },
    corporateView: {
      type: Boolean,
      default: false,
    },
    orderId: {
      type: Number,
      default: null,
    }
  },
  components: {WalletAuditFilter},
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      audits: state => state.WalletAudits.items,
      loading: state => state.WalletAudits.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('WalletAudits',['fetchAll', 'setProperty', 'setSelected', 'setPaginate',]),

    fetchItems() {
      
      if(this.id) {
        this.setProperty({ property: 'userWallet', value: this.id});
      }

      if(this.orderId) {
        this.setProperty({ property: 'OrderId', value: this.orderId});
      }
      
      this.setProperty({property: 'relations', value: ['user', 'auditable']});
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
        <wallet-audit-filter/>
        <div class="table-responsive">  
         <table class="table table-striped">
          <thead>
            <tr>
              <template v-if="!corporateView">
                <th>Account</th>
                <th>Initiator</th>
              </template>
              <th>Description</th>
              <th>Effect</th>
              <th>Previous Balance</th>
              <th>Amount</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(audit, index) in audits" :key="index">
              <template v-if="!corporateView">
              <td>
                <span v-if="audit.auditable">
                  {{ audit.auditable.name }}<br/>
                  <small class="text-blue">{{ audit.auditable.email }}</small><br/>
                  <small class="text-blue">{{ audit.auditable.phone }}</small>
                </span>
              </td>
              <td>{{ audit.user.name }}</td>
              </template>
              <td>{{ audit.description }} </td>
              <td>
                  <span v-if="audit.effect_type == 2" class="badge bg-success">Credit</span>
                  <span v-else class="badge bg-primary">Debit</span>
              </td>
              <td>{{ audit.previous_balance }}</td>
              <td>{{ audit.amount }}</td>
              <td>{{ audit.created_at | formatDate('LLL') }}</td>
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