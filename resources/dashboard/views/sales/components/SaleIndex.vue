<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import SaleFilter from './SaleFilter.vue';
import OrderStatus from '../../orders/components/OrderStatus.vue';

export default {
  name: 'SaleIndex',
  components: {
    SaleFilter,
    OrderStatus,
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      sales: state => state.Sales.items,
      loading: state => state.Sales.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Sales',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['customer','location','channel', 'admin', 'store'],
      });
       this.setProperty({
        property: 'relationCounts',
        value: ['items'],
      });
      this.setProperty({property: 'sorts', value:['-id']});
      this.fetchAll();
    },
    deleteOrder(order) {
      this.$confirm().then(() => {
        this.destroy(order.id).then(() => {
         	this.$toast.success('Order deleted Successfully');
        });
      })
    },
    requestForPayment(order) {
      this.resendInvoice(order.id).then((data) => {
          this.$toast.success('SMS sent and invoice shared via email');
      }).catch((erorr) => {
        console.log(error);
      });
    },
    handleRangeFilter(value) {
      this.setProperty({property: 'rangeFilter', value:value});
      this.fetchItems();
    },
    handlePaymentFilter(value) {
      this.setProperty({property: 'paymentStatus', value:value});
      this.fetchItems();

    }
  }
};
</script>
<template>
  <div>
    <sale-filter 
      @range-filter="handleRangeFilter"
      @payment-filter="handlePaymentFilter"
    />
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Order No.</th>
                <th>TYPE</th>
                <th>Customer Details</th>
                <th>notes</th>
                <th>Location</th>
                <th>Status</th>
                <th>Items</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Balance</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in sales" :key="order.id">
                <td>
                  <a class="text-decoration-none" :href="`/sales/${order.id}`">{{ order.order_no }}</a><br/>
                  <small>{{order.created_at | formatDate('LLL')}}</small><br/>
                  <small class="badge bg-success" v-if="order.channel">
                    {{ order.channel.name }}
                  </small><br/>
                  <small class="badge bg-dark" v-if="order.payment_on_delivery == 1">
                    Payment On Delivery
                  </small><br/>
                  <small v-if="order.admin">By: <b class="text-primary">{{order.admin.name}}</b></small>
                </td>

                <td>
                  <span v-if="order.store" class="badge bg-success">
                    {{ order.store.name }} 
                  </span>
                  <span v-else class="badge bg-primary">
                    DTC
                  </span>
                </td>

                <td>
                  <span v-if="order.customer && order.customer.account_type == 4">
                    {{ order.customer.organization_name }}<br/>
                  </span>
                  <span v-else >
                    {{order.customer.first_name }} {{order.customer.last_name }}<br/>
                  </span>                  {{order.customer.phone }}<br/>
                  {{order.customer.email }}<br/>
                  <span v-if="order.customer.account_type == 4" class="badge bg-warning">Corporate</span>
                  <span v-if="order.customer.return_times" class="badge bg-success"> x {{order.customer.return_times}}</span>
                </td>
                <td>{{order.notes}}</td>
                <td>
                  <span v-if="order.location">
                    {{order.location.name}}
                  </span>
                </td>
                <td>
                  <order-status :status="order.status" />
                </td>
                <td>{{order.items_count}}</td>

                <td>{{order.amount}}</td>
                <td>{{order.paid}}</td>
                <td>{{order.balance}}</td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${order.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${order.id}`">
                      <a class="dropdown-item" :href="`/sales/${order.id}`">view</a>
                      <a class="dropdown-item" :href="`/system-orders/${order.id}/invoice`" target="_blank">Invoice</a>
                      <button v-if="order.balance > 0" class="dropdown-item" @click="() => requestForPayment(order)">Request for payment</button>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Sales" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>