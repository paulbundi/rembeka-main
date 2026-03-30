<script>
import { mapActions, mapState } from 'vuex'
import ItemStatus from './ItemStatus.vue'
import OrderItemEdit from './OrderItemEdit.vue';
import catchValidationErrors from '../../../utils/catchValidationErrors';

  export default {
  name: 'OrderItemList',
  props: {
    noActions: {
      type: Boolean,
      default: false,
    },
    activeModule: {
      type: String,
      default: 'Orders',
    }
  },
  components: { ItemStatus, OrderItemEdit },
  data() {
    return {
      paymentModal: null,
      editOrderItemModal: null,
      payingLoader: false,
    };
  },
  computed: {
    ...mapState({
      selected: state => state.OrderItems.selected,
      user: state => state.authUser,
    }),
    storeModule() {
      return this.activeModule
        .split('/')
        .reduce((a, b) => {
          return a[b];
        }, this.$store.state);
    },
    items() {
      return this.storeModule.selected.items;
    },
    order() {
      return this.storeModule.selected;
    },
    loading() {
      return this.storeModule.loading
    },
  },
  methods: {
    ...mapActions('OrderItems', ['setSelected', 'makeProviderPayment', 'destroy']),
    handleEdit(item) {
      this.setSelected(item);
      this.editOrderItemModal = new bootstrap.Modal(document.getElementById('editOrderItem'));
      this.editOrderItemModal.show();
    },
    handleOrderUpdated() {
      this.editOrderItemModal.hide();
      location.reload();
    },
    providerPaymentModal(item) {
      this.setSelected(item);
      this.paymentModal = new bootstrap.Modal(this.$refs.providerPayment, { backdrop: 'static' });
      this.paymentModal.show();
    },
    handleProviderPayment() {
      this.payingLoader = true;
      this.makeProviderPayment(this.selected).then(() => {
        this.$toast.success('Payment made successfully')
        setTimeout(() =>{
          window.location.reload();
        },500)
        this.paymentModal.hide();
      }).catch(({response}) => {
          catchValidationErrors(this, response);
        }).finally(() => {
          this.payingLoader = false;
        });
    },
    handleDelete(item) {
      this.$confirm().then(() => {
        this.destroy(item.id).then(() => {
          this.$toast.success('Item removed successfully');
          location.reload();
        }).catch(({response}) => {
            catchValidationErrors(this, response);
        });
      })
    },
  }
};
</script>
<template>
  <div class="col-12">
    <div class="table-responsive single-item-table">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Product / Service </th>
                <th>Date : Time</th>
                <th>Quantity</th>
                <th>Pricing</th>
                <th>Provider Payment</th>
                <th>Commission</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <template  v-for="item in items">
                <tr>
                  <td>{{ item.id }}</td>
                  <td>
                    <span v-if="item.type == 1" class="badge bg-dark">
                        Product
                    </span>
                     <span v-else class="badge bg-warning">
                        Service
                    </span> :
                    <small>{{ item.product.name }}</small>
                    (<small>{{ item.category.name }}</small>) <br/>

                    <span class="badge bg-primary mt-2">Provider:</span> 
                    <small v-if="item.type == 2 && item.provider">
                      {{  item.provider.first_name }} 
                      {{  item.provider.last_name }}
                    </small>

                    <span v-if="item.assisting_provider">
                        <small class="badge bg-success">Assisting:</small>
                        <small>{{ item.assisting_provider.name}}</small>
                    </span>

                    <small class="badge bg-primary mt-2" v-if="item.type == 1 && item.supplier">
                      {{  item.supplier.displayName }} 
                    </small>
                  </td>
           
                  <td>{{ item.appointment_date| formatDate('ll') }}<br/> {{ item.appointment_time }}</td>
                  <td>{{ item.quantity }}</td>
                  <td>
                    Service Pricing : {{ item.service_pricing | numberFormat }}<br/>
                    Charged : {{ item.amount | numberFormat }}<br/>
                    <span v-if="item.discounted" class="badge bg-success">
                      - {{ item.total_discount }}
                    </span>
                  </td>

                  <td>
                    <small v-if="item.provider_discount">
                      Provider Cost: {{ item.provider_cost | numberFormat }}<br/>
                      Provider discount : {{ item.provider_discount | numberFormat }}% <br/>
                      Discount Amount : {{ item.provider_discount_amount | numberFormat }}<br/>
                    </small>
                    <small class="fw-bolder">Provider Earning: {{ item.provider_amount | numberFormat }}</small><br/>
                    <small>Payment Status:</small>
                    <span v-if="item.provider_paid" class="badge bg-success">
                      Provider Paid
                    </span>
                    <span v-else class="badge bg-primary">
                      Pending
                    </span>
                  </td>
                  <td>
                    <template  v-if="item.rembeka_discount_amount > 0">
                      <span class="badge bg-success mt-0">Discounted</span><br/>
                      <small>Discount:</small> {{ item.rembeka_discount }}% <br/>
                      <small>Discount Amount:</small> {{ item.rembeka_discount_amount | numberFormat }} <br/>
                    </template>
                    
                    <small class="fw-bolder">Commission: {{ item.percentage_commission }}</small>
                  </td>
                  <td>
                      <div class="dropdown show">
                        <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${item.id}`" data-bs-display="static" aria-expanded="false" class="">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${item.id}`">
                          <button v-if="canUserAccess('orders.update')" class="dropdown-item btn" @click="() => handleEdit(item)">Edit</button>
                          <button v-if="canUserAccess('orders.remove-items') && !noActions" class="dropdown-item btn" @click="() => handleDelete(item)">Remove Item</button>
                          <span v-if="order.balance < 1 && item.provider_paid !=1" >
                            <button v-if="canUserAccess('providers.pay-provider')" class="dropdown-item btn" @click="() => providerPaymentModal(item)">
                              <span v-if="item.type == 2">Pay Provider</span>
                              <span v-if="item.type == 1">Pay Supplier</span>
                            </button>
                          </span>
                        </div>
                      </div>
                  </td>
                </tr>
                <tr v-if="item.beneficiary">
                  <td colspan="11">
                    <div class="d-flex">
                      <b class="me-3">Corporate Beneficiaries</b>
                      <div>
                        <button v-for="user in  item.beneficiary"  v-if="user" class="btn btn-sm btn-outline-dark me-1">
                          {{user.first_name}} 
                          {{user.last_name}} 
                        </button>
                      </div>
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
    </div>


<!-- Modal -->
<div class="modal fade" id="editOrderItem" tabindex="-1" aria-labelledby="editItem" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editItem">Edit Order Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <order-item-edit @updated="handleOrderUpdated"/>
      </div>
    </div>
  </div>
</div>

<!-- Provider Payment Modal -->
<div class="modal fade" ref="providerPayment" id="providerPayment" tabindex="-1" aria-labelledby="providerPayment" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="providerPaymentHeader">{{ selected.type == 1 ? 'Supplier Payment' : 'Provider Payment' }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <h4>Amount will be paid to Account Wallet.</h4>
          <hr/>
          <table>
            <tr v-if="selected.provider">
              <td><b>Provider</b></td>
              <td><b>{{ selected.provider.name  }}</b></td>
            </tr>
            <tr>
              <td><b>Service Cost : </b></td><td> {{ selected.amount }} </td>
            </tr>
            <tr>
              <td><b>Commission : </b></td><td> {{ selected.percentage_commission }} </td>
            </tr>

            <tr>
              <td><b class="me-2">{{ selected.type == 1 ? 'Supplier' : 'Provider' }} Amount : </b></td><td> {{ selected.provider_amount }} </td>
            </tr>
          </table>

          <hr/>
          <table v-if="selected.assisting_provider">
            <tr>
              <td><b>Provider</b></td>
              <td><b>{{ selected.assisting_provider.name }}</b></td>
            </tr>
            <tr>
              <td><b>Service Cost : </b></td><td> {{ selected.amount }} </td>
            </tr>
            <tr>
              <td><b>Commission : </b></td><td> {{ selected.percentage_commission }} </td>
            </tr>

            <tr>
              <td><b class="me-2">{{ selected.type == 1 ? 'Supplier' : 'Provider' }} Amount : </b></td><td> {{ selected.provider_amount }} </td>
            </tr>
          </table>
          
      </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        				
					<div v-if="payingLoader">
						<button v-loading="payingLoader" class="btn btn-sm text-white float-end"></button>
					</div>
					<button v-else class="btn btn-primary text-white float-end" @click="handleProviderPayment">Pay</button>
				</div>
      </div>
    </div>
  </div>
</div>
</template>
<style lang="scss" scoped>

</style>