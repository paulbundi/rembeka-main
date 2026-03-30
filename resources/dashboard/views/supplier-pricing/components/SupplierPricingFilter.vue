<script>
import { mapActions } from 'vuex';
import updateProperty from '../../../mixins/updateProperty';
import InputFilter from '../../../views/generals/InputFilter';

export default {
  name: 'SupplierPricingFilter',
  props: {
    config: {
      type: Object,
      default: null,
    }
  },
  components: {
    InputFilter,
  },
  mixins: [
    updateProperty,
  ],
  methods: {
    ...mapActions('SupplierPricings', ['fetchAll','setProperty']),
    updatefilters(property, value) {
      this.setProperty({property: property, value: value});
      this.fetchAll();
    }
  }
};
</script>
<template>
  <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-3">
            <label>Supplier</label>
            <remote-selector 
              module="Suppliers"
              label="displayName"
              :multiple="false"
              @change="(supplier)=>updatefilters('supplierId', supplier)"
            />
          </div>

          <div class="col-3">
            <input-filter 
              module="SupplierPricings"
              label="Product"
              class="me-3"
            />
          </div>

          <div v-if="config.addPricing" class="col-3">
            <label>Category</label>
            <remote-selector 
              module="Categories"
              @change="(categoryId)=>updatefilters('categoryId', categoryId)"
            />
          </div>


          <div class="col-2 offset-1">
            <div class="d-grid gap-2">
              <div v-if="canUserAccess('products.create') && config.addPricing">
                <a class="btn bg-primary text-white w-100" href="/product-pricings/create">
                  <i class="bi bi-plus-circle"></i>
                  New Product Pricing
                </a>
              </div>

              <div v-if="canUserAccess('products.create') && config.addPricing">
                <a class="btn bg-success text-white w-100" href="/receive-supplier-products">
                  <i class="bi bi-receipt"></i>
                  Receive Products
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<style>

</style>