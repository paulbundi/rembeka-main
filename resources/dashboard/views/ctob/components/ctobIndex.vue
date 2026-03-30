<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import CtobFilter from './ctobFilter.vue';

export default {
  name: 'CtoBIndex',
  props: {
    orderId: {
      type: Number,
      default: null,
    },
  },
  components: {
    CtobFilter,
  },
  mixins: [
    pageChange,
  ],
  data() {
    return {
      orderNo:  null,
      paymentId: null,
    }
  },
  computed: {
    ...mapState({
      payments: state => state.Ctob.items,
      loading: state => state.Ctob.loadingItems,
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
    ...mapActions('Ctob',['fetchAll', 'setProperty', 'setPaginate', 'attachPaymentToOrders']),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['organization', 'user', 'order'],
      });
      this.setProperty({property: 'sorts', value:['-id']});
      this.fetchAll();
    },
    showOrderModal(payment) {
      this.paymentId = payment.id;
      $("#getOrderModal").modal('show');
    },
    attachPayment() {

      if(!this.orderNo || this.orderNo.length < 4) {
        this.$toast.error('Invalid Order Number');
        return;
      }
      const payload = {
        orderNo: this.orderNo.toUpperCase(),
        payment_id: this.paymentId,
      };

      this.attachPaymentToOrders(payload).then(({data}) => {
        this.$toast.success('Success');
        $("#getOrderModal").modal('hide');
        this.fetchAll();
      }).catch(() => {
        this.$toast.error('error');
      })
    }
  }
};
</script>
<template>
  <div>
    <ctob-filter v-if="!orderId"/>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive" :class="{'single-item-table': orderId}">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>User</th>
                <th>Invoice Number</th>
                <th>Amount</th>
                <th>Transaction Id</th>
                <th>Bill Reference</th>
                <th>Transacting Phone</th>
                <th>Payer Names</th>
                <th>Status</th>
                <th>Description</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(payment, index) in payments" :key="index">
                <td>
                  <span v-if="payment.user">
                        {{ payment.user.name }}<br/>
                        <small class="text-primary">{{ payment.user.email }}</small><br/>
                        <small class="text-primary">{{ payment.user.phone }}</small><br/>
                    </span>
                  <div v-if="payment.order">
                      <a :href="`/system-orders/${payment.order.id}`" class="btn btn-sm btn-success">view order</a>
                  </div>
                </td>
                <td>{{ payment.trans_id }} </td>
                <td>{{ payment.amount | numberFormat }} </td>
                <td>
                  {{ payment.bill_ref_no }}
                  <button v-if="!payment.bill_ref_no && !payment.invoice_number" class="btn btn-sm btn-primary" @click="() =>showOrderModal(payment)">Attach order</button>
                </td>
                <td>{{ payment.invoice_number }}</td>
                <td>{{ payment.phone }}</td>
                <td>{{ payment.first_name }} {{ payment.middle_name }} {{ payment.last_name }}</td>
                <td>
                  <span v-if="payment.status == 1" class="badge bg-primary"> Pending </span>
                  <span v-if="payment.status == 2" class="badge bg-success"> Accepted </span>
                  <span v-if="payment.status == 3" class="badge bg-danger">  Canceled </span>
                </td>
                <td>{{ payment.response_description }}</td>
                <td>{{ payment.created_at | formatDate('LLLL') }} </td>
              </tr>
              </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Users" @page-change="pageChange"/>
      </div>
    </div>

        <!-- Attach order modal -->
        <div class="modal fade" id="getOrderModal" tabindex="-1" aria-labelledby="getOrderModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="getOrderModalLabel">Attach Payment to Orders</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <label>Enter Order Number</label>
              <input type="text" v-model="orderNo" class="form-control" placeholder="RO1" style="text-transform:uppercase"/>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="attachPayment">Pay</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<style>

</style>