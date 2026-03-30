<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ProductsIndex from '../../products/components/ProductsIndex.vue';
import ProductTable from './product-table.vue';

export default {
  components: { ProductsIndex, ProductTable },
name: 'ProductDiscountCreate',
mixins: [
	updateProperty
],
computed: {
	...mapState({
		selected: state => state.ServiceDiscounts.selected,
		user: state => state.authUser,
	}),
	rembekaCommission() {
		if(this.selectedProduct) {
			return this.selectedProduct.commission - this.selected.discount_amount;
		}
		return 0;
	},
	listingPrice() {
		if(this.selectedProduct && this.selected.discount_amount > 0) {
			let amount = this.selectedProduct.final_price - 100;
			return (amount * ((100- this.selected.discount_amount) / 100) + 100);
		}
		return '';
	},
	discountedAmount() {
		if(this.listingPrice && this.listingPrice != '') {
			return this.selectedProduct.final_price - (this.selectedProduct.final_price * (100 - this.selected.discount_amount) /100);
		}
	 return	0; 
	}
},
data() {
	return {
		orderItemModal: null,
		selectedProduct: null,
	};
},
methods: {
	...mapActions('ServiceDiscounts', ['fetchOne','persist', 'setProperty', 'attachRelations','detachRelations']),
	addProduct() {
		this.selectedProduct = null;
		this.orderItemModal = new bootstrap.Modal(document.getElementById('selecteProductModal'));
		this.orderItemModal.show();
	},
	itemChecked(item) {
		this.selectedProduct = item;
		this.updateProperty('product_id', this.selectedProduct.id)
	},
	selectProduct() {
		this.orderItemModal.hide();
	},
	handleAddProducts() {
		this.persist().then(({data}) => {
			this.$toast.success('Item added Successfully');
			setTimeout(() =>{
				window.location = "/discounted";
			},200)
		}).catch(({response}) => {
			catchValidationErrors(this, response);
    });
	},
	}
};
</script>
<template>
<div class="card">
	<div class="card-body">
		<div class="row">
	<div class="col-6 offset-2 text-center">
				<div class="mb-2 alart alert-warning"><p class="p-3">Select Product to Discount</p></div>
				<button type="button" class="btn btn-primary" @click="addProduct">Select Product</button>
			</div>
		</div>

		<div v-if="selectedProduct" class="row">
			<product-table :product="selectedProduct" />
			<hr/>
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<label>Discount Type</label>
								<select name="form" class="form-control" @change="(e) =>  updateProperty('discount_type', e.target.value)">
									<option value="2">Percentage Amount</option>
								</select>
							</div>

							<div class="form-group">
								<label>Discount Percentage</label>
								<input class="form-control" :value="selected.discount_amount" type="number" max="30"  min="1" @input="(e) => updateProperty('discount_amount', e.target.value)">
							</div>

						</div>

						<div class="col-6">
							<div class="form-group">
								<label>Commision</label>
								<input class="form-control" :value="rembekaCommission" readonly>
							</div>

							<div class="form-group">
								<label>Final Ecommerce Listing</label>
								<input class="form-control" :value="listingPrice" readonly>
							</div>

							<div class="form-group">
								<label>Discounted Amount</label>
								<input class="form-control" :value="discountedAmount" readonly>
							</div>

							<div class="form-group">
								<button class="btn btn-sm btn-success float-end" @click="handleAddProducts">Add discount</button>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

<!-- Modal -->
<div class="modal fade" id="selecteProductModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="selecteProductModal">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
				<products-index  @selected="(item) => itemChecked(item)" :show-actions="false" selectable product-only/>
      </div>
      <div class="modal-footer" v-if="selectedProduct">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" @click="selectProduct">Select Procudct</button>
      </div>
    </div>
  </div>
</div>

</div>
</template>
<style>

</style>