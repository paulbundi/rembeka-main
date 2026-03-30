<script>
import { mapActions, mapState } from 'vuex';
import OrderStatus from './OrderStatus.vue';
import CorporateOrderItems from './CorporateOrderItems.vue';

export default {
  components: { OrderStatus, CorporateOrderItems },
  name: 'CorporateOrderShow',
  props: {
    id: {
      type: Number,
      required: true,
    }
  },
  data() {
    return{
      selectedRole: null,
      reason: null,
    };
  },
  computed: {
    ...mapState({
      order: state => state.Orders.selected,
      loading: state => state.Orders.loading,
      user: state => state.authUser,
    }),
    noActions() {
      return [3,4,7,9].includes(this.order.status);
    }
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('Orders', [
      'fetchOne', 'setProperty', 'attachRelations','removeItemRelations',
      'updateOrderStatus', 'resendInvoice', 'payOrderFromWallet',
    ]),
    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['customer','location', 'items' ,'items.product','items.category', 'items.provider']
      });
      this.fetchOne({ id: this.id });
    },
    handleOrderChange(value) {
      if(value ==2) {
        this.cancelOrderModal.show();
      }else{
        let payload = {
          'id' : this.id,
          'value':value,
          'user_id': this.user.id,
        };
        this.$confirm({title: 'Order Confirmation', message: 'Confirmed Customer is avialable on set time and deposit has been paid'}).then(() => {
          this.updateOrderStatus(payload).then(() => {
            this.cancelOrderModal.hide();
					  this.$toast.success('success');
            this.fetchItems();
          })
        });
      }
    },
    handleCancelOrder() {
        let payload = {
          'id' : this.id,
          'value':2,
          'user_id': this.user.id,
          'reasons': this.reason,
        };
          this.updateOrderStatus(payload).then(() => {
					  this.$toast.success('success');
            this.fetchItems();
          });
      },
    requestForPayment(order) {
      this.resendInvoice(order.id).then((data) => {
          this.$toast.success('Invoice reset');
      }).catch((erorr) => {
        console.log(error);
      });
    },
  }
};
</script>
<template>
<div class="row">
  <div class="col-12 card">
    <div v-loading="loading" class="card-body">
      <div class="table-responsive single-item-table">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Order No.</th>
              <th>notes</th>
              <th>Status</th>
              <th>Amount</th>
              <th>Deposit</th>
              <th>Balance</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{order.id}}</td>
              <td>
                {{order.order_no}} <br/>
                <small>{{order.created_at | formatDate('LLL')}}</small>
              </td>
              <td>{{order.notes}}</td>
              <td>
                <order-status :status="order.status" />
              </td>
              <td>
                  Total C:{{order.amount}} <br/>
                <small v-if="order.transport_cost" class="text-primary">
                  Trans C: {{ order.transport_cost }}
                </small>
              </td>
              <td>{{order.paid}}</td>
              <td>{{order.balance}}</td>
              <td>
                <div class="dropdown show">
                  <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${order.id}`" data-bs-display="static" aria-expanded="false" class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${order.id}`">
                    <a class="dropdown-item" :href="`/system-orders/${order.id}/invoice`" target="_blank">Invoice</a>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  <corporate-order-items :no-actions="noActions"/>
</div>
</template>
<style>

</style>