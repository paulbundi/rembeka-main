<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import StkFilter from './StkFilter.vue';

export default {
  name: 'StkIndex',
  props: {
    orderId: {
      type: Number,
      default: null,
    },
  },
  components: {
    StkFilter,
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      payments: state => state.Stk.items,
      loading: state => state.Stk.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    if(this.orderId) {
      this.setProperty({property: 'OrderId', value: this.orderId});
    }
    this.fetchItems();
  },
  methods: {
    ...mapActions('Stk',['fetchAll', 'setProperty', 'setSelected', 'setPaginate', 'verifyStkTopup']),

    fetchItems() {
      
      this.setProperty({
        property: 'relations',
        value: ['user', 'order'],
      });
      this.setProperty({property: 'sorts', value:['-id']});

      this.fetchAll();
    },
    confirm(id) {
      this.verifyStkTopup(id).then(() => {
        this.fetchItems();
      }).catch((e) => {
        
      });
    }
  }
};
</script>
<template>
  <div>
    <stk-filter v-if="!orderId"/>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive" :class="{'single-item-table': orderId}">  
         <table class="table table-striped">
          <thead>
            <tr>
              <th>Account</th>
              <th>Amount</th>
              <th>Checkout Request Id ID</th>
              <th>Response Code</th>
              <th>Description</th>
              <th>Customer Message</th>
              <th>Reference Id</th>
              <th>Status</th>
              <th>Time</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(stk, index) in payments" :key="index">
              <td>
                <span v-if="stk.user">
                  {{ stk.user.first_name }} {{ stk.user.last_name }}<br/>
                  <small class="text-blue">{{ stk.user.email }}</small><br/>
                  <small class="text-blue">{{ stk.user.phone }}</small>
                </span>
              </td>
              <td>{{ stk.amount }} </td>
              <td>{{ stk.checkout_request_id }}</td>
              <td>{{ stk.response_code }}</td>
              <td>{{ stk.response_description }}</td>
              <td>{{ stk.customer_message }}</td>
              <td>{{ stk.reference_id }}</td>
              <td>
                <span v-if="stk.status == 1" class="badge bg-primary">Pending</span>
                <span v-if="stk.status == 2" class="badge bg-success">Accepted</span>
                <span v-if="stk.status == 3" class="badge bg-danger"> Canceled</span>
                <span v-if="stk.status == 4" class="badge bg-secondary"> Has Issues</span>
              <span v-if="stk.status == 4" class="badge bg-info"> Issue Resolved</span>
              </td>
              <td>{{ stk.created_at | formatDate('LLLL') }} </td>
              <td>
                  <button
                    v-if="canUserAccess('stk-push.validate') && stk.status == 1"
                    class="btn btn-sm btn-outline-success"
                    @click="() => confirm(stk.id)"
                  >
                    Verify
                  </button> 
              </td>
            </tr>
            </tbody>
        </table>
        </div>
        <pagination class="pull-left" module="Users" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>