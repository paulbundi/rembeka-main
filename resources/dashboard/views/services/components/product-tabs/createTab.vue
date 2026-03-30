<script>
import { mapState,mapActions } from 'vuex'
import RemoteSelector from '../../../generals/RemoteSelector.vue'
import updateProperty from '../../../../mixins/updateProperty'
import catchValidationErrors from '../../../../utils/catchValidationErrors'

  export default {
    name:'CreateTab',
    components: { RemoteSelector },
    computed: {
      ...mapState({
        selected: state => state.Services.selected,
        user: state => state.authUser,
      }),
    },
    mixins: [
      updateProperty,
    ],
    data(){
      return {
        updateProviderPricing: null,
      }
    },
    watch: {
      updateProviderPricing() {
        this.updateProperty('update_provider_pricing', this.updateProviderPricing);
      }
    },
    mounted() {
      this.updateProperty('type', 2);// service
      this.setMenuProperty({property: 'menuType', value: 2});
    },
    methods: {
      ...mapActions('Services', ['persist', 'setProperty', 'setSelected']),
      ...mapActions('Menus',{setMenuProperty: 'setProperty'}),
      saveProduct() {
        this.persist().then(({data}) => {
          this.$emit('refresh', data);
          this.$toast.success('success');
        })
        .catch(({response}) => {
          catchValidationErrors(this, response);
        });
      },
    }
  };
</script>
<template>
<div class="row">
  <div class="col-6">
    <div class="form-group">
      <label>Style Name</label>
      <input class="form-control" type="text" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
    </div>

    <div class="form-group">
      <label>Product Used</label>
      <input class="form-control" type="text" :value="selected.product_used" @input="(e) => updateProperty('product_used', e.target.value)">
    </div>

    <div class="form-group">
      <label>Durability</label>
      <input class="form-control" type="text" :value="selected.durability" @input="(e) => updateProperty('durability', e.target.value)">
    </div>

    <div class="form-group">
      <label>Duration of Style</label>
      <input class="form-control" type="text" :value="selected.duration_of_style" @input="(e) => updateProperty('duration_of_style', e.target.value)">
    </div>
    <div class="form-group">
      <label>Descriprion</label>
      <textarea  class="form-control"  @input="(e) => updateProperty('description', e.target.value)">{{selected.description}}</textarea>
    </div>
    <div class="form-group">
      <label>Associated Menu</label>
        <remote-selector 
          module="Menus" 
          @change="(value) => updateProperty('menu_id', value)" 
          :multiple='false'
          :value="selected.menu"
        />
    </div>

    <div class="form-group">
      <label>Age Groups</label>
        <remote-selector 
          module="AgeGroups"
          @change="(value) => updateProperty('age_groups', value)"
        />
    </div>

  </div>

  <div class="col-6">
    <div class="form-group">
      <label>SKU</label>
      <input class="form-control" :value="selected.sku" type="text" @input="(e) => updateProperty('sku', e.target.value)">
    </div>
    <div class="form-group">
      <label>Seo Title</label>
      <textarea  class="form-control"  @input="(e) => updateProperty('seo_title', e.target.value)">{{selected.seo_title}}</textarea>
    </div>
    <div class="form-group">
      <label>Seo Description</label>
      <textarea  class="form-control"  @input="(e) => updateProperty('seo_description', e.target.value)">{{selected.seo_description}}</textarea>
    </div>
    <div class="form-group">
      <label>Search KeyWords</label>
      <textarea  class="form-control"  @input="(e) => updateProperty('keywords', e.target.value)">{{selected.keywords}}</textarea>
    </div>
    <div class="form-group">
      <input type="checkbox" :checked="selected.is_published == 1" name="is_published" @input="(e)=>updateProperty('is_published', e.target.checked)">
      <label>Publish Service On the e-commerce side.</label>
    </div>

  </div>
  <div class="col-12">
    <hr/>
    <b class="text-warning">Default Pricing</b>
    <div class="row">
      <div class="col-6">
       
        <div class="form-group">
           <label>Cost of Labour</label>
          <input type="number" class="form-control" :value="selected.cost_of_labour" name="cost_of_labour" @input="(e)=>updateProperty('cost_of_labour', e.target.value)"/>
        </div>
        
        <div class="form-group">
          <label>Rembeka Commission(%)</label>
          <input type="number" class="form-control" :value="selected.commission" name="commission" @input="(e)=>updateProperty('commission', e.target.value)" placeholder="30"/>
        </div>
      
        <div class="form-group bg-warning p-3">
          <input type="checkbox" :checked="selected.constant_commission == 1" name="constant_commission" @input="(e)=>updateProperty('constant_commission', e.target.checked)">
          <label>Use this commission irregardless of the location.</label>
        </div>
        
      </div>
      <div class="col-6">
        <div class="form-group">
          <label>Provider Cost</label>
          <input type="number" class="form-control" :value="selected.cost_of_labour * ((100 - selected.commission) /100)" name="provider_cost" readonly/>
        </div>

        <div class="form-group">
           <label>Listing Price <b>(Not rounded up)</b> </label><br/>
           <span class="hint text-danger">Price should be inclusive of platform fee</span>
          <input type="number" class="form-control" :value="selected.product_price" name="product_price" @input="(e)=>updateProperty('product_price', e.target.value)" />
        </div>

        <div class="form-group">
            <input type="checkbox" name="update_provider_pricing" v-model="updateProviderPricing">
           <label> By checking this box, you choose to reset all provider pricing to this price.<br>NB: you can edit individual provider pricing from the provider pricing menu.</label>
        </div>

      </div>
    </div>
  </div>


  <div class="col-6 offset-2 d-flex justify-content-end">
    <button class="btn btn-primary" @click.prevent="saveProduct">{{ selected.id ? 'Update': 'Create' }}</button>
  </div>

</div>
</template>
<style lang="scss" scoped>

</style>