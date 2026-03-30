<script>
import { mapActions, mapState } from 'vuex'
import OrderItemList from './OrderItemList.vue';
import CorporateUserSelector from '../../generals/CorporateUserSelector.vue'
import AddOrderItemsActions from '../../orders/components/partials/AddOrderItemsActions.vue';
import EditableOrderItem from '../../orders/components/partials/EditableOrderItem.vue';
import serviceHelper from '../../orders/components/mixins/serviceHelper';


export default {
  name: 'AddOrderItems',
  props: {
    activeModule: {
      type: String,
      default: 'Orders',
    }
  },
  components: { OrderItemList,CorporateUserSelector, AddOrderItemsActions, EditableOrderItem  },
  data() {
    return {
		  providerPricingSelected: null,
      productPricingSelected: null,
      order: {
        orderItems: [],
      }
    };
  },
  computed: {
    ...mapState({
      user: state => state.authUser,
    }),
    storeModule() {
      return this.activeModule
        .split('/')
        .reduce((a, b) => {
          return a[b];
        }, this.$store.state);
    },
    stateOrder() {
      return this.storeModule.selected;
    }
  },
  create() {
    this.setPricingProperty({
      property: 'relations',
      value: ['provider'],
    });
  },
  methods: {
    ...mapActions('OrderItems', ['updateOrderItems',]),
	  ...mapActions('ProviderPricings', { setPricingProperty:'setProperty'}),
	  ...mapActions('CorporateUsers', {setCorporateProperty: 'setProperty'}),
    ...serviceHelper.methods,

    addOrderServiceItems() {
      this.orderServiceItemModal = new bootstrap.Modal(document.getElementById('selecteServiceModal'));
      this.orderServiceItemModal.show();
    },
    addOrderProductItems() {
      this.orderProductItemModal = new bootstrap.Modal(document.getElementById('selecteProductModal'));
      this.orderProductItemModal.show();
    },
    selectProduct() {
      let orderLoad = {
        product: this.productPricingSelected.product,
        provider: this.productPricingSelected.supplier,
        quantity: 1,
        type: 1,
        size: this.productPricingSelected.size,
        productPricing: this.productPricingSelected.amount,
        providerCost: this.productPricingSelected.supplier_price,
        pricing_id:  this.productPricingSelected.id,
			  beneficiary:[],
      };
  
      if(this.productPricingSelected.product.discount) {
          orderLoad = {...orderLoad,
          discounted: true,
          productPricing: this.productPricingSelected.product.discount.payable,
        };
      }
  
      this.order.orderItems.push(orderLoad);
      this.orderProductItemModal.hide();

    },
    serviceItemChecked(item) {
      this.providerPricingSelected = item;
    },
    productItemChecked(item) {
      this.productPricingSelected = item;

    },
    addOrderItem() {
      let invalid = this.order.orderItems.filter((item) => {
        if(item.type == 2 && (!item.appointmentDate || !item.appointmentTime)) {
          return true;
        }
      });
      if(invalid && invalid.length > 0) {
        this.$toast.error('Please make sure all appointments are correctly set.');
        return;
      }
      let payload = {
        id: this.stateOrder.id,
        user_id: this.user.id,
        items: {...this.order.orderItems},
      }
      this.updateOrderItems(payload).then(() => {
        this.$store.dispatch(`${this.activeModule}/fetchOne`, {id: this.stateOrder.id});
        this.$toast.success('Order updated successfully');
        this.order = {
          orderItems: [],
        }
      }).catch(({response}) => {
      });
    },
    removeOrderItem(index) {
		  this.stateOrder.orderItems.splice(index, 1);
	  },
    handleSelectService() {
      this.selectService();
      if(this.stateOrder.customer && this.stateOrder.customer.account_type == 4) {
        this.setCorporateProperty({ property: 'corporateId', value: this.stateOrder.user_id });
        this.setCorporateProperty({ property: 'relations', value: ['user'] });
      }
    },
    handleBeneficiary(index, user) {
      if(!user) {
        return;
      }

      let updateIndex = this.order.orderItems[index];
      let found = updateIndex.beneficiary.findIndex((item) => item.id == user.id);
      if(found != -1) {
        return;
      }
      updateIndex.beneficiary =[...updateIndex.beneficiary, user];
      this.order.orderItems[index] = updateIndex;
    },
    handleRemoveBeneficiary(user, index) {
      let updateIndex = this.order.orderItems[index];
      let beneficiaries = updateIndex.beneficiary.filter((item) => item.id != user.id);
      updateIndex.beneficiary = beneficiaries;
      this.order.orderItems[index] = updateIndex;
    },
  }
};
</script>

<template>
  <div class="row">
    <div class="col-12">
      <order-item-list  :active-module="activeModule"/>
    </div>
    <div class="col-12" v-if="stateOrder.customer">
      <div class="single-item-table">
        <table class="table table-striped">
            <thead v-if="stateOrder.customer.account_type != 4">
              <th>Service/Product</th>
              <th>Provider</th>
              <th>Date</th>
              <th>Time</th>
              <th>quantity</th>
              <th>@</th>
              <th>Provider Discount(%)</th>
              <th>Total</th>
            </thead>
            <thead v-else>
                <th>Service/Product</th>
                <th>Date</th>
                <th>Time</th>
                <th>quantity</th>
                <th>@</th>
                <th>Provider Discount(%)</th>
                <th>Rembeka Commission</th>
                <th>Total</th>
              </thead>
            <tbody>
							<add-order-items-actions @add-product="addOrderProductItems" @add-service="addOrderServiceItems" />
              <template v-for="(item, index) in order.orderItems">
                <editable-order-item :item="item" :index="index"
                  @remove-order-item="(index)=>removeOrderItem(index)"
                  @update-quantity="(payload)=>handleUpdateQuantity(payload)"
                  @update-provider-pricing="(payload)=>updateProviderPricing(payload)"
                />

                <tr v-if="stateOrder.customer.account_type == 4">
                  <td colspan="8">
                    <div class="row">
                      <div class="col-4">
                        <label>Attach beneficiary</label>
                        <corporate-user-selector
                          module="CorporateUsers"
                          label='name'
                          :multiple="false"
                          @change="(cUser)=> handleBeneficiary(index ,cUser)"
                        />
                      </div>

                      <div class="col-8">
                        <button v-for="user in  item.beneficiary"  v-if="user" class="btn btn-sm btn-outline-dark me-1">
                            {{user.first_name}} 
                            {{user.last_name}} 
                            <span class="cursor-pointer" @click="() => handleRemoveBeneficiary(user, index)">
                              <i class="bi bi-x-lg"></i>
                            </span>
                          </button>
                      </div>
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
        </table>
      </div>
    </div>

    <div class="col-12" v-if="order && order.orderItems.length">
      <button type="button" class="btn btn-primary float-end" @click="addOrderItem">Update Order</button>
    </div>


<!-- Add Service Modal -->
<div class="modal fade" id="selecteServiceModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Service Item To Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="max-height:70vH ;overflow-y: scroll;">
				<provider-pricing-index  @selected="(item) => serviceItemChecked(item)"/>
      </div>
      <div class="modal-footer" v-if="providerPricingSelected">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" @click="handleSelectService">Select Service</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="selecteProductModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Product Item To Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="max-height:70vH ;overflow-y: scroll;">

				<supplier-pricing-index  @selected="(item) => productItemChecked(item)" check-out-of-stock/>
      </div>
      <div class="modal-footer" v-if="productPricingSelected">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" @click="selectProduct">Select Procudct</button>
      </div>
    </div>
  </div>
</div>

  </div>
</template>

<style scoped>
#selecteServiceModal, #selecteProductModal{
  background: #0000009e;
}
</style>