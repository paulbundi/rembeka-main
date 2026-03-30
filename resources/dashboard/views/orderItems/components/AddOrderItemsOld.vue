<script>
import { mapActions, mapState } from 'vuex'
import OrderItemList from './OrderItemList.vue';
import CorporateUserSelector from '../../generals/CorporateUserSelector.vue'
import AddOrderItemsActions from '../../orders/components/partials/AddOrderItemsActions.vue';


export default {
  name: 'AddOrderItems',
  props: {
    activeModule: {
      type: String,
      default: 'Orders',
    }
  },
  components: { OrderItemList,CorporateUserSelector, AddOrderItemsActions  },
  data() {
    return {
		  providerPricingSelected: null,
      productPricingSelected: null,
      serviceOrder: {
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
    order() {
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
  
      this.serviceOrder.orderItems.push(orderLoad);
      this.orderProductItemModal.hide();
      this.setCorporateProperties();

    },

    selectService() {
      let orderLoad = {
        product: this.providerPricingSelected.product,
        provider: this.providerPricingSelected.provider,
        quantity: 1,
        productPricing: this.providerPricingSelected.amount,
        providerCost: this.providerPricingSelected.provider_cost,
        appointmentDate: null,
        appointmentTime: null,
        type: 2,
        pricing_id: this.providerPricingSelected.id,
			  beneficiary:[],
        provider_discount: null,
        percentage_commission:null,
      };

      if(this.providerPricingSelected.product.discount) {
          orderLoad = {...orderLoad,
          discounted: true,
          productPricing: this.providerPricingSelected.product.discount.payable,
        };
      }

      this.serviceOrder.orderItems.push(orderLoad);
      this.orderServiceItemModal.hide();
      this.setCorporateProperties();
	  },

    serviceItemChecked(item) {
      this.providerPricingSelected = item;
    },
    productItemChecked(item) {
      this.productPricingSelected = item;

    },
    addOrderItem() {
      let invalid = this.serviceOrder.orderItems.filter((item) => {
        if(item.type == 2 && (!item.appointmentDate || !item.appointmentTime)) {
          return true;
        }
      });
      if(invalid && invalid.length > 0) {
        this.$toast.error('Please make sure all appointments are correctly set.');
        return;
      }
      let payload = {
        id: this.order.id,
        user_id: this.user.id,
        items: {...this.serviceOrder.orderItems},
      }
      this.updateOrderItems(payload).then(() => {
        this.$store.dispatch(`${this.activeModule}/fetchOne`, {id: this.order.id});
        this.$toast.success('Order updated successfully');
        this.serviceOrder = {
          orderItems: [],
        }
      }).catch(({response}) => {
      });
    },
    removeOrderItem(index) {
		  this.order.orderItems.splice(index, 1);
	  },
    setCorporateProperties() {
      if(this.order.customer && this.order.customer.account_type == 4) {
      this.setCorporateProperty({ property: 'corporateId', value: this.order.user_id });
		  this.setCorporateProperty({ property: 'relations', value: ['user'] });
    }
    },
    handleBeneficiary(index, user) {
      if(!user) {
        return;
      }

      let updateIndex = this.serviceOrder.orderItems[index];
      let found = updateIndex.beneficiary.findIndex((item) => item.id == user.id);
      if(found != -1) {
        return;
      }
      updateIndex.beneficiary =[...updateIndex.beneficiary, user];
      this.serviceOrder.orderItems[index] = updateIndex;
    },
    handleRemoveBeneficiary(user, index) {
      let updateIndex = this.serviceOrder.orderItems[index];
      let beneficiaries = updateIndex.beneficiary.filter((item) => item.id != user.id);
      updateIndex.beneficiary = beneficiaries;
      this.serviceOrder.orderItems[index] = updateIndex;
    },
    updateProviderPricing(value,item, index){
		let providerPricing =  item.originalProductPrice;
		let providerDiscount = 0;
		if(value == '' || value == 0){
			providerPricing =  item.originalProductPrice;
		}else{
			providerDiscount	= item.originalProductPrice - (item.originalProviderCost * ((100 - value)/ 100));
			providerPricing = item.originalProductPrice - providerDiscount;
		}
    let order = this.serviceOrder;

    order.orderItems[index] = {...order.orderItems[index], productPricing:providerPricing , provider_discount: value, providerDiscount: providerDiscount};
    this.serviceOrder = {...order};
  },

  }
};
</script>

<template>
  <div class="row">
    <div class="col-12">
      <order-item-list  :active-module="activeModule"/>
    </div>
    <div class="col-12" v-if="order.customer">
      <div class="single-item-table">
        <table class="table table-striped">
            <thead v-if="order.customer.account_type != 4">
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
              <editable-order-item v-for="(item, index) in order.orderItems" :key="index" :item="item" :index="index"
                @remove-order-item="(index)=>removeOrderItem(index)"
                @update-quantity="(payload)=>handleUpdateQuantity(payload)"
                @update-provider-pricing="(payload)=>updateProviderPricing(payload)"
              />

              <template  v-for="(item, index) in serviceOrder.orderItems"> <!-- non corporate order items-->
                <tr v-if="order.customer.account_type != 4">
                  <td>
                    <div class="col-10">
                        <button class="btn btn-sm btn-danger me-2" @click="()=>removeOrderItem(index)">
                        <i class="bi bi-dash-circle"></i>
                      </button>	
                      {{ item.product.name }}
                    </div>
                  </td>
                  <td>
                      {{ item.provider.first_name }}
                      {{ item.provider.last_name }}
                  </td>
                  <td>
                    <template v-if="item.type == 2">
                      <date-picker
                        input-class="form-control"
                        :value="item.appointmentDate"
                        format="yyyy-MM-dd" 			
                        @selected="(e) => item.appointmentDate = e"
                      />
                    </template>
                  </td>
                  <td>
                    <template v-if="item.type == 2">
                      <input class="form-control" type="time" v-model="item.appointmentTime"/>
                    </template>
                  </td>

                  <td>
                    <input type="number" class="form-control w-50" min="1" v-model="item.quantity">
                  </td>
                  <td>
                    {{ item.productPricing }}
                  </td>

                  <td>
                    <input  v-if="item.type == 2" 
                      type="number" class="form-control w-50" max="100" 
                      :value="item.provider_discount"
                      @input="(e) => updateProviderPricing(e.target.value,item, index)">
									</td>

                  <td>
                    <div v-if="item.productPricing && item.quantity">
                      {{ item.productPricing * item.quantity }}
                    </div>
                    <div v-else>
                      0
                    </div>
                  </td>
                </tr>

                <tr v-else> <!-- Corporate Order Items -->
										<td>
											<div class="d-flex flex-row">
												<button class="btn btn-sm btn-danger me-2" @click="()=>removeOrderItem(index)">
													<i class="bi bi-dash-circle"></i>
												</button>	
                        <div>
												{{ item.product.name }} <br/>
												By: <span v-if="item.type == 2"  class="fw-bolder">
													{{ item.provider.first_name }}
													{{ item.provider.last_name }}
												</span>
												<span v-else class="fw-bolder">
													{{ item.provider.displayName }}
												</span>
												<span v-if="item.discounted" class="badge bg-success">Discounted</span>
                        </div>
											</div>
										</td>
										<td>
											<span v-if="item.type == 2">
											<date-picker
												input-class="form-control"
												:value="item.appointmentDate"
												format="yyyy-MM-dd" 			
												@selected="(e) => item.appointmentDate = e"
											/>
											</span>
										</td>
										
										<td>
											<span v-if="item.type == 2">
											 <input class="form-control" type="time" v-model="item.appointmentTime"/>
											</span>
										</td>

										<td>
											<input type="number" class="form-control w-50" v-model="item.quantity">
										</td>

                    <td>
											<span v-if="item.type == 2">
												Service Price: {{ Math.round((item.productPricing + Number.EPSILON) * 100) / 100}}<br/>
												Provider Discount: {{ Math.round((item.providerDiscount + Number.EPSILON) * 100) / 100}}
											</span>
											<span v-else>
												Product Price: {{item.productPricing}}<br/>
												Supplier Amount: {{item.providerCost}}
											</span>
                    </td>

                    <td>
											<input type="number" class="form-control w-50" :value="item.provider_discount" @input="(e) => updateProviderPricing(e.target.value,item, index)">
										</td>

                    <td>
											<input type="number" class="form-control w-50" max="30" min="0" v-model="item.percentage_commission">
										</td>

										<td>
											<div v-if="item.productPricing && item.quantity">
											 {{ Math.round(((item.productPricing * item.quantity ) + Number.EPSILON) * 100) / 100}}
											</div>
											<div v-else>
												0
											</div>
										</td>
									</tr>

                <tr v-if="order.customer.account_type == 4">
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

    <div class="col-12" v-if="serviceOrder && serviceOrder.orderItems.length">
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
        <button type="button" class="btn btn-primary" @click="selectService">Select Procudct</button>
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