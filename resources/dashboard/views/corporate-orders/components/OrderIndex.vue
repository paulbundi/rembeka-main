<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import OrderFilter from './OrderFilter.vue';
import OrderStatus from './OrderStatus.vue';

export default {
  name: 'OrderIndex',
  components: {
    OrderFilter,
    OrderStatus,
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      orders: state => state.Orders.items,
      loading: state => state.Orders.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
     this.setProperty({
      property: 'pagination',
      subProperty: 'perPage',
      value: 20
    });
    this.fetchItems();
  },
  methods: {
    ...mapActions('Orders',[
        'fetchAll', 'setProperty', 'persist', 'destroy',
        'setSelected', 'resetSelected', 'setPaginate', 'resendInvoice'
      ]),

    fetchItems() {
      this.setProperty({ property: 'orderOwnerId', value: this.user.id});
      this.setProperty({property: 'relationCounts',value: ['items']});
      this.setProperty({property: 'sorts', value:['-id']});
      this.fetchAll();
    },
    handleRangeFilter(range) {
      this.setProperty({property: 'rangeFilter', value:range});
      this.fetchItems();
    },
    handlePaymentFilter(value) {
      this.setProperty({property: 'paymentFilter', value:value});
      this.fetchItems();
    }
  }
};
</script>
<template>
  <div>
    <order-filter  @range-filter="handleRangeFilter" @payment-filter="handlePaymentFilter"/>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Order No.</th>
                <th>notes</th>
                <th>Status</th>
                <th>Service Items</th>
                <th>Amount</th>
                <th>Balance</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in orders" :key="order.id">
                <td>
                  {{order.id}}
                </td>
                <td>
                  <a class="text-decoration-none" :href="`/corporate-orders/${order.id}`">{{ order.order_no }}</a><br/>
                  <small>{{order.created_at | formatDate('LLL')}}</small><br/>
                </td>
                <td>{{order.notes}}</td>
                <td>
                  <order-status :status="order.status" />
                </td>
                <td>{{order.items_count}}</td>

                <td>{{order.amount}}</td>
                <td>{{order.balance}}</td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${order.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${order.id}`">
                      <a class="dropdown-item" :href="`/corporate-orders/${order.id}`">view</a>
                      <a class="dropdown-item" :href="`/system-orders/${order.id}/invoice`" target="_blank">Invoice</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Orders" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>