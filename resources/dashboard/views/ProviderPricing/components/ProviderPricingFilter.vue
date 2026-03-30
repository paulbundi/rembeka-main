<script>
import { mapActions } from 'vuex';
import updateProperty from '../../../mixins/updateProperty';
import InputFilter from '../../../views/generals/InputFilter';

export default {
  name: 'ProviderPricingFilter',
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
    ...mapActions('ProviderPricings', ['fetchAll','setProperty']),
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
          <div v-if="canUserAccess('products.create') && config.addPricing" class="float-end">
            <a class="btn bg-primary mt-3 text-white" href="/service-pricings/create">
              <i class="bi bi-plus-circle"></i>
              Add Service Pricing
            </a>
          </div>
        <div class="row">
          <div class="col-4">
            <label>Provider</label>
            <remote-selector 
              module="Providers"
              label="name"
              :multiple="false"
              @change="(provider)=>updatefilters('providerId', provider)"
            />
          </div>

          <div class="col-4">
            <input-filter 
              module="ProviderPricings"
              label="Product"
              class="me-3"
            />
          </div>

          <div v-if="config.addPricing" class="col-4">
            <label>Category</label>
            <remote-selector 
              module="Categories"
              @change="(categoryId)=>updatefilters('categoryId', categoryId)"
            />
          </div>
          <div v-if="false" class="col-4">
            <label>Location</label>
            <remote-selector 
              module="Locations"
              @change="(provider)=>updatefilters('locationId', provider)"
            />
          </div>

        </div>
      </div>
    </div>
</template>

<style>

</style>