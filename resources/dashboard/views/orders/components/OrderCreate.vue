<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector'
import ProviderPricingIndex from '../../ProviderPricing/components/ProviderPricingIndex.vue'
import SupplierPricingIndex from '../../supplier-pricing/components/SupplierPricingIndex.vue'
import serviceHelper from './mixins/serviceHelper';
import productHelpers from '../productHelpers';
import AddOrderItemsActions from './partials/AddOrderItemsActions.vue';
import EditableOrderItem from './partials/EditableOrderItem.vue';

export default {
name: 'OrderCreate',
props: {
	id: {
		type: Number,
		default: null,
	}
},
components: { RemoteSelector, ProviderPricingIndex, SupplierPricingIndex, AddOrderItemsActions, EditableOrderItem},
mixins: [
  updateProperty,
],
data() {
	return {
		addStylistModal: null,
		hasTransportCost: 1,
		productPricingSelected: null,
		providerPricingSelected: null,
		orderServiceItemModal: null,
		orderProductItemModal: null,
		selectedInquiry: null,
		inquiryModal: null,
		totalAmount: 0,
		deliveryAmount: 0,
		provider_discount: 0,
		totalTransport:0,
		referral_code_id: null,
		referralDiscountAmount: 0,
		order: {
			orderItems: [],
		},
		assistStylist: {
			index: null,
			id: null,
			newPrice: null,
			name: null,
		}
	};
},
computed: {
  ...mapState({
    selected: state => state.Orders.selected,
		franchise: state => state.Franchises.selected,
		user: state => state.authUser,
		loading: state => state.Orders.loadingItem,
		providers: state => state.Providers.items,
		selectedReferral: state => state.Referrals.selected,
  }),
},
watch: {
	deliveryAmount() {
		this.totalPayable();
	},
	referral_code_id() {
		this.setReferralProperty({ property: 'relations', value:['user']});
		this.fetchReferralCode({id: this.referral_code_id}).then(() => {
			if(this.order.orderItems.length > 0) {
				this.totalPayable();
			}
		});
	}
},
created() {
	if (this.id) {
		this.fetchItems();
	}
	this.setPricingProperty({
		property: 'relations',
		value: ['provider'],
	});
},
mounted() {
	if(this.user.store_id) {
		this.fetchFranchise({id: this.user.store_id});
	}
},
methods: {
  ...mapActions('Orders', ['fetchOne','persist', 'setProperty', 'attachRelations']),
	...mapActions('Franchises', {fetchFranchise: 'fetchOne'}),
	...mapActions('ProviderPricings', { setPricingProperty:'setProperty' }),
	...mapActions('Referrals',{fetchReferralCode: 'fetchOne', setReferralProperty: 'setProperty'}),
  ...serviceHelper.methods,
  ...productHelpers.methods,

	fetchItems() {
		this.fetchOne({id: this.id});
	},
	attachInquiryModal() {
    this.inquiryModal = new bootstrap.Modal(document.getElementById('selecteInquiryModal'));
		this.inquiryModal.show();
	},
	handleChange(index, provider) {
		let updateIndex = this.order.orderItems[index];
		updateIndex.productPricing = provider;
		this.order.orderItems[index] = updateIndex;
	},
  createOrder() {
		let invalid = this.order.orderItems.filter((item) => {
			if(item.type == 2  && (!item.appointmentDate || !item.appointmentTime)) {
				return true;
			}
		});
		if(invalid && invalid.length > 0) {
			this.$toast.error('Please make sure all appointments are correctly set.');
			return;
		}

		this.updateProperty('order_items', this.order.orderItems);
		this.updateProperty('admin_id', this.user.id);
		this.updateProperty('delivery_amount', this.deliveryAmount);
		if (this.referral_code_id != null){
			this.updateProperty('referral_code_id', this.referral_code_id);
		}

    this.persist().then(({data}) => {
			this.$toast.success('Order Created Successfully');
			setTimeout(() => {
				window.location = '/system-orders';
			},500);
    })
		.catch(({response}) => {
      catchValidationErrors(this, response);
    });
  },
	inquirySelected(inquiry) {
		this.selectedInquiry = inquiry;
	},
	handleSelectedInquiry() {
		this.updateProperty('inquiry_id', this.selectedInquiry.id);
    this.inquiryModal.hide();
	},

	handleCheckBoxChange() {
		this.updateProperty('has_transport_cost', this.hasTransportCost);
		this.totalPayable();
	},
	handleAppointmentType(value) {
		this.updateProperty('store_id', value);
		if(value) {
			this.hasTransportCost = 0;
			this.updateProperty('has_transport_cost', this.hasTransportCost);
		}else { 
			this.hasTransportCost = 1;
			this.updateProperty('has_transport_cost', this.hasTransportCost);
		}
		this.totalPayable();
	},
	handleAddingStylistToService(index) {
		this.assistStylist.index = index
		this.addStylistModal = new bootstrap.Modal(document.getElementById('addStylistToService'));
		this.addStylistModal.show();
	},
	handleUpdateOrder() {
		let stylist =  this.providers.filter((provider) => provider.id == this.assistStylist.id)[0];
		this.assistStylist.name =  stylist.name;
		let item = {...this.order.orderItems[this.assistStylist.index],assistStylist : this.assistStylist};
		this.order.orderItems[this.assistStylist.index] = item;
		this.totalPayable();
		this.addStylistModal.hide();
		this.assistStylist = {
			index: null,
			id: null,
			newPrice: null,
			name: null,
		}
	},
	handleRemovingAssistingStylist(index) {
		let item = {...this.order.orderItems[index]};
		delete item.assistStylist;
		this.order.orderItems[index] = item;
		this.totalPayable();
	},
	attachReferral(value) {
		console.log(value);
		this.referral_code_id = value;
	}
},
};
</script>
<template>
  <div class="card">
		<div class="card-body">
			<h4 class="card-title">Create Order</h4>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label>Select Customer</label>
						<remote-selector
							module="Users"
							label="name"
							:multiple="false"
							@change="(id) => updateProperty('user_id', id)"
						/>
					</div>
					<div class="form-group">
						<label>Channel</label>
						<remote-selector
							module="Channels"
							:multiple="false"
							@change="(e) => updateProperty('channel_id', e)"
						/>
					</div>
					<div class="form-group">
						<label>Referral From </label>
						<remote-selector
								module="Referrals"
								label="code"
								:multiple="false"
								@change="(id) => attachReferral(id)"
							/>
						</div>
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" 
							:checked="selected.has_transport_cost"
							v-model="hasTransportCost"
							@change="() => handleCheckBoxChange()"
							true-value="1"
  						false-value="0"
						>
						<label class="form-check-label text-bold" for="flexSwitchCheckChecked">Order has transport cost included.</label>
					</div>
					
					<div class="form-group mb-4">
						<label>Customer Inquiry</label><br/>
						<div v-if="selected.inquiry_id">
								<b>Names :</b>{{ selectedInquiry.first_name}} {{ selectedInquiry.last_name }} <br/>
								<b>Callback Date:</b> {{ selectedInquiry.callback_date |formatDate('LL') }}
						</div>
						<button v-else type="submit" class="btn btn-sm btn-primary" @click="attachInquiryModal">Attach Inquiry</button>
					</div>

				</div>
				<div class="col-6">
					<div class="form-group">
						<label>Type</label>
						<select class="form-control" @change="(e) => handleAppointmentType(e.target.value)">
							<option value=""></option>
							<option value="">Home Call</option>
							<option v-if="franchise.id" :value="franchise.id">{{ franchise.name }}</option>
						</select>
					</div>

					<div class="form-group" v-if="!selected.store_id">
						<label>Address Location</label>
						<remote-selector 
							module="Locations"
							label='name'
							:multiple="false"
							@change="(id)=> updateProperty('location_id', id)"
							/>
					</div>

					<div class="form-group">
						<label>Customer Notes</label>
						<textarea class="form-control" rows="4" name="notes" @input="(e) => updateProperty('notes', e.target.value)">{{selected.notes}}</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="single-item-table">
						<table class="table table-striped">
							<thead>
								<th>Service/Product</th>
								<th>Provider</th>
								<th>Date</th>
								<th>Time</th>
								<th>quantity</th>
								<th>
								Provider<br/>
								<small class="ps-0">Discount(%)</small>
								</th>
								<th>@</th>
								<th>Total</th>
							</thead>
							<tbody>
								<add-order-items-actions @add-product="addProduct" @add-service="addService" />
								<editable-order-item v-for="(item, index) in order.orderItems" :key="index" :item="item" :index="index"
									@remove-order-item="(index)=>removeOrderItem(index)"
									@update-quantity="(payload)=>handleUpdateQuantity(payload)"
									@update-provider-pricing="(payload)=>updateProviderPricing(payload)"
									@add-stylist-to-service="() => handleAddingStylistToService(index)"
									@remove-assist-stylist="() => handleRemovingAssistingStylist(index)"
									
								/>
							
								<template v-if="order.orderItems && order.orderItems.length > 0">
									<tr>
										<td colspan="6"></td>
										<td><b>Delivery Fee</b></td>
										<td>
											<b><input type="number" v-model="deliveryAmount" min="100"></b>
										</td>
									</tr>

									<tr>
										<td colspan="6"></td>
										<td><b>Transport Amount</b></td>
										<td>
											<b>{{ totalTransport }}</b>
										</td>
									</tr>

									<tr>
										<td colspan="6"></td>
										<td><b>Total Order Amount</b></td>
										<td>
											<b>{{  totalAmount }}</b>
										</td>
									</tr>
									
									<tr v-if="selectedReferral && selectedReferral.id">
										<td colspan="6"></td>
										<td><b>Referral Discount</b></td>
										<td>
											<b>{{ referralDiscountAmount }}</b>
										</td>
									</tr> 
									<tr>
										<td colspan="6"></td>
										<td><b>Deposit payable</b></td>
										<td>
											<b>{{ totalAmount / 2 }}</b>
										</td>
									</tr>
								</template>
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-12" v-if="order.orderItems.length > 0">
					<div v-if="loading">
						<button v-loading="loading" class="btn btn-sm  text-white float-end"></button>
					</div>
					<button v-else class="btn btn-sm btn-primary text-white float-end" @click="createOrder">Create Order</button>
				</div>

			</div>
		</div>


<!--Service Select Modal -->
<div class="modal fade" id="selecteServiceModal" tabindex="-1" aria-labelledby="selecteServiceModal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="selecteServiceModal">Add Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="max-height:70vH ;overflow-y: scroll;">
				<provider-pricing-index  @selected="(item) => serviceItemChecked(item)"/>
      </div>
      <div class="modal-footer" v-if="providerPricingSelected">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" @click="selectService">Select Product</button>
      </div>
    </div>
  </div>
</div>

<!-- Product select Modal -->
<div class="modal fade" id="selecteProductModal" tabindex="-1" aria-labelledby="selecteProductModal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="selecteProductModal">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="max-height:70vH ;overflow-y: scroll;">
				<supplier-pricing-index  @selected="(item) => productItemChecked(item)" check-out-of-stock/>
      </div>
      <div class="modal-footer" v-if="productPricingSelected">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" @click="selectProduct">Select Product</button>
      </div>
    </div>
  </div>
</div>
  
  
<!-- Modal -->
<div class="modal fade" id="selecteInquiryModal" tabindex="-1" aria-labelledby="selecteInquiryModal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="selecteInquiryModalHeader">Attach Inquiry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="max-height:70vH ;overflow-y: scroll;">
						<inquiries-index
							isSelectable
							@selected="inquirySelected"
						/>
      </div>
			 <div class="modal-footer" v-if="selectedInquiry">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" @click="handleSelectedInquiry">Select Inquiry</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addStylistToService" tabindex="-1" aria-labelledby="addStylistToService" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStylistToServiceHeader">Attach Stylist</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
					<div class="form-group">
						<label for="">Select Stylist</label>
						<remote-selector
							module="Providers"
							label="name"
							:multiple="false"
							@change="(id) => assistStylist.id = id"
						/>
					</div>

					<div class="form-group">
						<label>New Pricing</label>
						<input type="number" class="form-control" v-model="assistStylist.newPrice"/>
					</div>

					<div class="form-group">
						<label>Commission Distribution will be 35%, 35% and Rembeka commission of 30%</label>
					</div>
      </div>
			 <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" @click="() =>handleUpdateOrder()">Update Order</button>
      </div>
    </div>
  </div>
</div>

  </div>
</template>
<style>

</style>