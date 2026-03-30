<script>
import { mapState,mapActions } from 'vuex'
import updateProperty from '../../../mixins/updateProperty';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import RemoteSelector from '../../generals/RemoteSelector.vue';

  export default {
  name:'SupplierPricingCreate',
  props: {
    id: {
      type: Number,
      default: null,
    }
  },
 data() {
	return {
    // loading: false,
		pricing:{
			productPricing: [{
				size: null,
				unit_id: null,
				supplier_price: null,
				mark_up_percentage: null,
        re_order_level: null,
        amount: null,
        listing_amount: null,
        configs: {
          colors: [],
        },
			}],
		},
	};
},
  components: { RemoteSelector, },
    computed: {
      ...mapState({
        selected: state => state.SupplierPricings.selected,
        loading: state=> state.SupplierPricings.loadingItem,
        products: state => state.Products.items,
        user: state => state.authUser,
      }),
    },
    mixins: [
    updateProperty,
  ],
  created() {
    if(this.id) {
      this.fetchItem();
    }
  },
 
  mounted() {
    this.setProductProperty({ property: 'filterByType', value: 1});
  },
  methods: {
    ...mapActions('SupplierPricings', ['fetchOne','persist', 'setProperty', 'setSelected']),
    ...mapActions('Products', {setProductProperty: 'setProperty', value: 'value'}),

    fetchItem() {
      this.setProperty({
        property: 'relations',
        value: ['product', 'supplier', 'category', 'unit'],
      });
      this.fetchOne({id: this.id}).then(() => {
        let editIndex = {...this.pricing.productPricing[0], ...this.selected};
        this.pricing.productPricing = [{...editIndex}];
      });
    },
    addItem() {
      this.pricing.productPricing = 	[...this.pricing.productPricing, {
        size: null,
        unit_id: null,
        supplier_price: null,
        mark_up_percentage: null,
        amount: null,
        listing_amount: null,
        re_order_level: null,
        configs: {
          colors: [],
        },
        }
      ];
    },
    removeExpenseItem(index) {
      this.pricing.productPricing.splice(index, 1);
    },
    saveProduct() {
      if(this.selected.id) {
        this.setSelected({...this.selected, ...this.pricing.productPricing[0]});
        console.log(this.selected);
      }else {
        this.updateProperty('productPricing', this.pricing.productPricing);
      }
      this.persist().then(({data}) => {
        this.$toast.success('success');
        setTimeout(() =>{
              window.location = '/product-pricings';
        },500)
      })
      .catch(({response}) => {
        catchValidationErrors(this, response);
      });
    },
    handleChange(value, index) {
      let updateIndex = this.pricing.productPricing[index];
      updateIndex.unit_id = value;
      this.pricing.productPricing[index] = updateIndex;
    },
    handleProductChange(value) {
      this.updateProperty('product_id', value)
    },
    getValue(item, index) {
      let amount = 0
      if(!item.supplier_price){
         return amount;
      }
      amount = parseFloat(item.supplier_price) + item.supplier_price * (item.mark_up_percentage/100)

      let updateIndex = this.pricing.productPricing[index];
      updateIndex.listing_amount = amount;
      updateIndex.amount = Math.ceil(amount/10) * 10;
      this.pricing.productPricing[index] = updateIndex;

      return amount;
    }
  }
  };
</script>
<template>
<div class="row">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-12">
        <h4 class="mb-4 text-success">Add Provider Pricing</h4>
          <div class="form-group">
            <label>Select Product</label>
            <remote-selector 
              module="Products" 
              @change="(value) => handleProductChange(value)" 
              :multiple='false'
              :value="selected.product"
            />
          </div>

          <div class="form-group">
            <label>Select Supplier</label>
            <remote-selector 
              module="Suppliers" 
              @change="(value) =>  updateProperty('supplier_id', value)" 
              :multiple='false'
              :value="selected.supplier"
              label="displayName"
            />
          </div>

          <div class="form-group">
            <label>Product/Service Category</label>
            <remote-selector 
              module="Categories" 
              @change="(value) =>  updateProperty('category_id', value)" 
              :multiple='false'
              :value="selected.category"
            />
          </div>

        </div>
        <div class="col-12">
          <h4 class="text-muted mb-4">Pricing Details</h4>
          	<table class="table table-striped">
								<thead>
									<th>#</th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</thead>
								<tbody>
									<tr v-if="!id">
										<td colspan="7">
											<button class="btn btn-sm btn-primary me-2" @click="addItem">
												<i class="bi bi-plus-circle"></i>
											</button>
										</td>
									</tr>
									<tr v-for="(item, index) in pricing.productPricing" :key="index">
										<td>
											<div class="d-flex flex-row align-center">
                        <button class="btn btn-sm btn-danger me-2" @click="()=>removeExpenseItem(index)">
                          <i class="bi bi-dash-circle"></i>
                        </button>

												<div class="flex-grow-1">
													<small>Unit Package</small>
													<remote-selector
														module="UnitMeasures"
														:multiple="false"
														@change="(e) => handleChange(e, index)"
                            :value="selected.unit"
													/>

													<div class="">
														<small>Size</small>
														<input class="form-control" min="1" type="text" v-model="item.size">
													</div>
												</div>
											</div>
										</td>

                    <td>
                      <label>Available Colors</label><br/>
                      <input type="checkbox" v-model="item.configs.colors" value="Black">Black<br/>
                      <input type="checkbox" v-model="item.configs.colors" value="White">White<br/>
                      <input type="checkbox" v-model="item.configs.colors" value="Grey">Grey<br/>
                      <input type="checkbox" v-model="item.configs.colors" value="Brown">Brown
                    </td>
                    
                    <td>
                      <div class="form-group">
                        <label>Supplier Price</label>
                        <input type="number" class="form-control" v-model="item.supplier_price">
                      </div>
                        <div class="form-group">
                        <label>Re-Order Level</label>
                        <input type="number" class="form-control" v-model="item.re_order_level">
                      </div>
                    </td>

										<td>
                      <div class="form-group">
                        <label>% Mark up</label>
                        <input class="form-control" min="1" type="number" v-model="item.mark_up_percentage">
                      </div>
                      <div class="form-group">
                      </div>
										</td>
										<td>
                      <div class="form-group">
                        <label>Amount</label>
                        <input class="form-control" min="1" type="number" :value="getValue(item, index)" readonly>
                      </div>
                      <div class="form-group">
                        <label>Final Listing Amount</label>
                        <input class="form-control" min="1" type="number" :value="item.amount" readonly>
                      </div>
										</td>
									</tr>
								</tbody>
						</table>
        </div>
      </div>
 
  <div class="col-12  d-flex justify-content-end">
    <div v-if="loading">
      <button v-loading="loading" class="btn btn-sm  text-white"></button>
    </div>
    <button v-else class="btn btn-primary" @click.prevent="saveProduct">{{ selected.id ? 'Update': 'Create' }}</button>
  </div>
    </div>
  </div>

</div>
</template>
<style lang="scss" scoped>
label{
  font-weight: Bolder;
}
</style>