<script>
import { mapState,mapActions } from 'vuex'
import updateProperty from '../../../mixins/updateProperty';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import RemoteSelector from '../../generals/RemoteSelector.vue';

  export default {
  name:'ProviderPricingCreate',
  props: {
    id: {
      type: Number,
      default: null,
    }
  },
  data() {
    return {
      inheritPricing: null,
    }
  },
  components: { RemoteSelector, },
    computed: {
      ...mapState({
        selected: state => state.ProviderPricings.selected,
        services: state => state.Services.items,
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
  watch: {
    inheritPricing() {

      if(!this.selected.product_id) {
        return;
      }

      if(this.inheritPricing) {
        let servive =  this.services.filter(item => item.id == this.selected.product_id)[0];
        this.updateProperty('cost_of_labour', servive.cost_of_labour);
        this.updateProperty('commission', servive.commission);
        this.updateProperty('service_pricing', servive.product_price);
      }
    }
  },
  methods: {
    ...mapActions('ProviderPricings', ['fetchOne','persist', 'setProperty', 'setSelected']),
    fetchItem() {
      this.setProperty({
        property: 'relations',
        value: ['product', 'provider', 'category', 'location'],
      });
      this.fetchOne({id: this.id}).then(() => {
        this.updateProperty('cost_of_labour', this.selected.product.cost_of_labour);
        this.updateProperty('commission', this.selected.product.commission);
        this.updateProperty('service_pricing', this.selected.product.product_price);
      });
    },
    saveProduct() {
      this.persist().then(({data}) => {
        this.$toast.success('success');
      })
      .catch(({response}) => {
        catchValidationErrors(this, response);
      });
    },
    handleProductChange(value) {
      this.updateProperty('cost_of_labour', null);
      this.updateProperty('commission', null);
      this.updateProperty('service_pricing', null);      
      this.inheritPricing = null;
      this.updateProperty('product_id', value)
    }
  }
  };
</script>
<template>
<div class="row">
  <div class="card">
    <div class="card-body">
      <div class="card-title">
        </div>
      <div class="row">
        <div class="col-6">
        <h4 class="text-muted mb-4">Add Provider Pricing</h4>
          <div class="form-group">
            <label>Select Service</label>
            <remote-selector 
              module="Services" 
              @change="(value) => handleProductChange(value)" 
              :multiple='false'
              :value="selected.product"
            />
          </div>

          <div class="form-group">
            <label>Select Provider</label>
            <remote-selector 
              module="Providers" 
              @change="(value) =>  updateProperty('provider_id', value)" 
              :multiple='false'
              :value="selected.provider"
              label="name"
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
        <div class="col-6">
          <h4 class="text-muted mb-4">Pricing Details</h4>
          <div v-if="!selected.id" class="form-group form-check form-switch">
            <input class="form-check-input" name="inheritPricing" v-model="inheritPricing" type="checkbox" role="switch" id="flexSwitchCheckDefault">
            <label>Inherit from Product Pricing</label>
          </div>
           <div class="form-group">
            <label>Cost of Labour</label>
            <input type="number" class="form-control" :value="selected.cost_of_labour" @input="(e) => updateProperty('cost_of_labour', e.target.value)">
          </div>
          <div class="form-group">
            <label>Rembeka Commission(%)</label>
            <input type="number" step="any" max="100" min="1" class="form-control" :value="selected.commission" @input="(e) => updateProperty('commission', e.target.value)">
          </div>
          <div class="form-group">
            <label>Provider Cost</label>
            <input type="number" class="form-control" :value="selected.cost_of_labour * ((100 - selected.commission) / 100)" readonly>
          </div>

          <div class="form-group">
            <label>E-commerce Pricing(Not rounded up)</label>
            <input type="number" class="form-control" :value="selected.service_pricing" @input="(e) => updateProperty('service_pricing', e.target.value)">
          </div>

        </div>
      </div>
 
  <div class="col-6 offset-2 d-flex justify-content-end">
    <button class="btn btn-primary" @click.prevent="saveProduct">{{ selected.id ? 'Update': 'Create' }}</button>
  </div>
    </div>
  </div>

</div>
</template>
<style lang="scss" scoped>

</style>