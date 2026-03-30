<script>
import { mapActions } from 'vuex';
  export default {
    name: 'ReceiveSupplierProducts',
    data() {
      return {
        orderProductItemModal: null,
        supplierPricingSelected: null,
        activeIndex: null,
        supplier_id: null,
        invoiceNo: null,
        supplied:{
          productsItems: [{
            id: null,
            productPricing: null,
            newStock: null,
          }],
        },
      };
    },
    computed: {
      totalAmount () {
        let sum = 0;
        if(this.supplied.productsItems && this.supplied.productsItems.length > 0) {
          this.supplied.productsItems.forEach((item) => {
            if(item.productPricing){
              sum  +=  item.newStock * item.productPricing.supplier_price;
            }
          });
        }
      return sum;
      },
    },
    methods: {
      ...mapActions('SupplierPricings', ['receiveSupplierProducts', 'setProperty', 'fetchAll']),

      addItem() {
        this.supplied.productsItems = [...this.supplied.productsItems,{
          id: null,
          productPricing: null,
          newStock: null,
          }
        ];
      },
      removeItem(index) {
		    this.supplied.productsItems.splice(index, 1);
      },
      selectProductPricing(index) {
        this.activeIndex = index;
        this.orderProductItemModal = new bootstrap.Modal(document.getElementById('selecteProductModal'));
        this.orderProductItemModal.show();
      },
      handleSupplier( value) {
        this.supplier_id = value;
        this.setProperty({property: 'supplierId', value: value});
        this.fetchAll();
      },
      itemChecked(item) {
        this.supplierPricingSelected = item;
      },
      selectProduct() {
        let updateIndex = this.supplied.productsItems[this.activeIndex];
        updateIndex.productPricing = this.supplierPricingSelected,
        updateIndex.id = this.supplierPricingSelected.id,
		    this.supplied.productsItems[this.activeIndex] = updateIndex;

        this.orderProductItemModal.hide();
      },
      receiveProducts() {
        let payload = {
          supplier_id: this.supplier_id,
          invoice_no: this.invoiceNo,
          items: {...this.supplied.productsItems}
        };

        if(!payload.supplier_id || !payload.invoice_no) {
          this.$toast.error('Please fill all the fields');
          return;
        }

		let invalid = this.supplied.productsItems.filter((item) => {
			if(!item.id || !item.newStock) {
				return true;
			}
		});
		if(invalid && invalid.length > 0) {
			this.$toast.error('Please ensure invoice items are entered correctly.');
			return;
		}
        this.receiveSupplierProducts(payload).then((data) => {
          this.$toast.success('Stock update');
          window.location = '/product-pricings'
        });
      }
    }
  };
</script>
<template>
  <div>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Select Supplier</label>
                <remote-selector 
                  module="Suppliers" 
                  @change="(value) => handleSupplier(value)" 
                  :multiple='false'
                  label="displayName"
                />
              </div>
              <div class="form-group">
                  <label>Invoice No/ PO</label>
                  <input type="text" class="form-control" v-model="invoiceNo"/>
              </div>
              
            </div>
          </div>

          <div class="row">

            <div class="col-12">
              <table class="table table-striped">
								<thead>
									<th>#</th>
									<th>Quantity</th>
									<th>Value</th>
									<th>Total</th>
								</thead>
								<tbody>
									<tr>
										<td colspan="7">
											<button class="btn btn-sm btn-primary me-2" @click="addItem">
												<i class="bi bi-plus-circle"></i>
											</button>
										</td>
									</tr>
									<tr v-for="(item, index) in supplied.productsItems" :key="index">
										<td style="min-width: 300px;">
											<div class="d-flex flex-row align-center">
													<button class="btn btn-sm btn-danger me-2" @click="()=>removeItem(index)">
														<i class="bi bi-dash-circle"></i>
													</button>

                          <div class="flex-grow-1">
                              <button  v-if="!item.productPricing" class="btn btn-sm btn-success" @click="() => selectProductPricing(index)">
                                Select Item
                              </button>
                              <div v-else class="">
                                <b>{{item.productPricing.product.name}}</b><br/>
                                <span>
                                  Packaging Unit: {{item.productPricing.unit.name}}<br/>
                                  Size: {{item.productPricing.size}}<br/>
                                  Available Stock: {{item.productPricing.instock}}<br/>
                                  Re-order level: {{item.productPricing.re_order_level}}
                                </span>
                              </div>
                          </div>
											</div>
										</td>
										<td>
											<input class="form-control" min="1" type="number" v-model="item.newStock">
										</td>

										<td>
											<b v-if="item.productPricing">{{ item.productPricing.supplier_price }}</b>
										</td>

										<td>
											<b v-if="item.productPricing">{{ item.newStock * item.productPricing.supplier_price }}</b>
										</td>

									</tr>

								<template v-if="supplied.productsItems && supplied.productsItems.length > 0">
									<tr>
										<td colspan="3" class="text-end" >
											<b>Total Amount</b>
										</td>
										<td>
											<b>{{  totalAmount }}</b>
										</td>
									</tr>
								</template>
								</tbody>
						</table>
            </div>

            <div class="col-12">
              <button class="btn btn-sm btn-primary float-end" @click="receiveProducts">Receice Products</button>
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
				<supplier-pricing-index  @selected="(item) => itemChecked(item)"/>
      </div>
      <div class="modal-footer" v-if="supplierPricingSelected">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" @click="selectProduct">Select Procudct</button>
      </div>
    </div>
  </div>
</div>
  
  </div>
</template>



<style lang="scss" scoped>

</style>