<script>
import { mapActions, mapState } from 'vuex';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import CtobIndex from '../../ctob/components/ctobIndex.vue';
import OrderItems from '../../orderItems/components/OrderItemIndex.vue';
import PdqPaymentIndex from '../../pdqs/components/PdqPaymentIndex.vue';
import StkIndex from '../../stk/components/StkIndex.vue';
import PayFromWallet from '../../wallets/components/PayFromWallet.vue';
import OderAddress from '../../sales/components/partials/OderAddress.vue';
export default {
  components: { OrderItems, CtobIndex, StkIndex, PayFromWallet, PdqPaymentIndex, OderAddress },
  name: 'OrderShow',
  props: {
    id: {
      type: Number,
      required: true,
    }
  },
  data() {
    return{
      selectedRole: null,
      cancelOrderModal: null,
      pdQModal: null,
      reason: null,
      card_number: null,
      receipt_no: null,
      amount: null,
      makingPayment: false,

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
  mounted() {
    this.cancelOrderModal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
    this.pdQModal = new bootstrap.Modal(document.getElementById('pdqPayments'));
  },
  methods: {
    ...mapActions('Orders', [
      'fetchOne', 'setProperty', 'attachRelations','removeItemRelations',
      'updateOrderStatus', 'resendInvoice', 'payOrderFromWallet', 'reworkPayable',
      'makePdqPayment',
    ]),
    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['customer','location', 'items' ,'items.product','items.category', 'items.provider', 'items.assistingProvider','items.supplier', 'channel']
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
        this.$confirm({title: 'Order Confirmation', message: 'Confirmed Customer is available on set time and deposit has been paid'}).then(() => {
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
          'reason': this.reason,
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
    reWorkPayableAmount(order) {
      this.reworkPayable({id: order.id}).then(() => {
        this.fetchOne({ id: this.id });
        this.$toast.success('Order value fixed');
      });
    },
    showPdqModal() {
      this.pdQModal.show();
    },
    handleMakePayment() {
      this.makingPayment = true;
      let payload =  {
        order_id: this.order.id,
        card_number: this.card_number,
        receipt_no: this.receipt_no,
        amount: this.amount,
        user_id: this.user.id,
      }
      this.makePdqPayment(payload).then(() => {
        this.fetchOne({ id: this.id });
        this.pdQModal.hide();
      }).catch(({response}) => {
        catchValidationErrors(this, response);

      }).finally(() => {
        this.makingPayment = false;

      });
    }
  }
};
</script>
<template>
<div class="row">
  <div v-loading="loading" class="col-12">
    <div class="row">
      <div v-if="order.address" class="col-4">
          <oder-address :address="order.address" />
        </div>
      <div class="col-4">
        <template v-if="order.status != 3">
          <pay-from-wallet :order="order" />
        </template>
      </div>
  
      <div v-if="order.balance > 0" class="col-4 d-flex justify-content-end align-items-center" :class='{"offset-4": !order.address_id }'>
        <div>
          <button type="button" class="btn btn-primary" @click="showPdqModal">
            PDQ payment
          </button>
        </div>
      </div>
    </div>

    <div class="card col-12">
      <div class="card-body">
        <h5 class="text-danger" v-if="order.status == 3"> <b class="badge bg-danger">ORDER CANCEL</b>: {{ order.cancel_reason}}</h5>
        <div class="table-responsive single-item-table">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Order No.</th>
                <th>Customer Details</th>
                <th>notes</th>
                <th>Location</th>
                <th>Status</th>
                <th>Items</th>
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
                  <small>{{order.created_at | formatDate('LLL')}}</small><br/>
                  <small class="badge bg-success" v-if="order.channel">
                    {{ order.channel.name }}
                  </small><br/>
                </td>
                <td>
                  <span v-if="order.customer">
                    {{order.customer.name }} <br/>
                    <b>{{  order.customer.phone}}</b> <br/>
                    <small>{{  order.customer.email}}</small><br/>
                    <span v-if="order.customer.account_type == 4" class="badge bg-warning">Corporate</span>
                    <span v-if="order.customer.return_times" class="badge bg-success"> x {{order.customer.return_times}}</span>
                     <span  v-if="user.return_times > 5"> <i class="bi bi-bookmark-heart-fill text-warning"></i></span>
                  </span>
                </td>
                <td>{{order.notes}}</td>
                <td>
                  <span v-if="order.location">
                      {{order.location.name}}
                    </span>
                </td>
                <td>
                  <order-status :status="order.status" />
                  <div v-if="[1,10].includes(order.status)" class="">
                    <select class="form-control" name="status" @change="(e) => handleOrderChange(e.target.value)">
                      <option></option>
                      <option value="1" v-if="order.paid > 0">Confirm</option>
                      <option value="2">Cancel</option>
                    </select>
                  </div>
                </td>
                <td>{{order.items_count}}</td>
                <td>
                    Total C:{{order.amount | numberFormat}} <br/>
                  <small v-if="order.transport_cost" class="text-primary">
                    Trans C: {{ order.transport_cost }} <br/>
                  </small>
                  <small v-if="order.referral_code_id" class="text-primary">
                    Referral D: {{ order.referral_discount }} <br/>
                  </small>
                </td>
                <td>
                  {{order.paid | numberFormat}}
                  <div v-if="order.over_paid == 1">
                    <span class="badge bg-warning">Over Paid</span>
                  </div>
                </td>
                <td>{{order.balance | numberFormat }}</td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${order.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${order.id}`">
                      <button v-if="order.amount < 1" class="dropdown-item" @click="() => reWorkPayableAmount(order)">Re-Calculate</button>
                      <a class="dropdown-item" :href="`/system-orders/${order.id}/invoice`" target="_blank">Invoice</a>
                      <button v-if="order.balance > 0" class="dropdown-item" @click="() => requestForPayment(order)">Request for payment</button>
                      <button v-if="canUserAccess('orders.cancel')" class="dropdown-item" @click="() => handleOrderChange(2)">Cancel Order</button>
                      <!-- <a class="dropdown-item" href="#" @click="()=>deleteUser(order)">Delete</a> -->
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <order-items :no-actions="noActions"/>
  
  <h4>STK Push Payment</h4>
  <stk-index :order-id="id"/>
  
  <h4>Mpesa Direct Deposits</h4>
  <ctob-index :order-id="id"/>

  <h4>Wallet payment</h4>
  <wallet-audit-index :order-id="id"/>

  <h4>PDQ payment</h4>
  <pdq-payment-index :order-id="id"/>

  <!-- cancellation modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelOrderModalHeader">Cancel order Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label>Reason</label>
        <textarea class="form-control" v-model="reason"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" @click="handleCancelOrder">Submit</button>
      </div>
    </div>
  </div>
</div>


<!-- PDQ Payments -->
<div class="modal fade" id="pdqPayments" tabindex="-1" aria-labelledby="pdqPayments" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pdqPaymentsHeader">PDQ payments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
        <div class="form-group">
          <label>Customer Card(las 4 digits)</label>
          <input type="text" class="form-control" v-model="card_number" />
        </div>
        <div class="form-group">
          <label>Receipt No</label>
          <input type="text" class="form-control" v-model="receipt_no" />
        </div>
        <div class="form-group">
          <label>Amount</label>
          <input type="number" class="form-control" v-model="amount" />
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button v-if="makingPayment" v-loading="makingPayment" class="btn btn-sm text-white float-end"></button>
          <button v-else type="button" class="btn btn-primary" @click="handleMakePayment">Submit</button>
      </div>
    </div>
  </div>
</div>

<!--update delivery fees-->
  <div class="modal fade" id="updateDeliveryCost" tabindex="-1" aria-labelledby="updateDeliveryCost" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updateDeliveryCostHeader">Delivery Cost</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="modal-body">
              <div class="form-group">
                <label>Oder Delivery / Transport Cost</label>
                <input type="number" class="form-control" :value="order.delivery_amount" @input="(e) => updateProperty('delivery_amount', e.target.value)" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button v-if="makingPayment" v-loading="makingPayment" class="btn btn-sm text-white float-end"></button>
                <button v-else type="button" class="btn btn-primary" @click="() => handleUpdateDeliveryCost()">Update</button>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
</template>
<style>

</style>