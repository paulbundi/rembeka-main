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
        selected: state => state.Products.selected,
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
      },
    },
    mounted() {
        this.updateProperty('type', 1);// product
        this.setMenuProperty({property: 'menuType', value: 1});
    },
    methods: {
      ...mapActions('Products', ['persist', 'setProperty', 'setSelected']),
      ...mapActions('Menus',{setMenuProperty: 'setProperty'}),
      saveProduct() {
        this.persist().then(({data}) => {
          this.$emit('refresh', data);
          this.$toast.success('Product saved successfully');
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
      <label>Product Name</label>
      <input class="form-control" type="text" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
    </div>

    <div class="form-group">
      <label>Descriprion</label>
      <textarea  class="form-control" @input="(e) => updateProperty('description', e.target.value)">{{selected.description}}</textarea>
    </div>
    <div class="form-group">
      <label>Brand</label>
        <remote-selector 
          module="Brands" 
          @change="(value) => updateProperty('brand_id', value)" 
          :multiple='false'
          :value="selected.brand"
        />
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
  <div class="col-12 d-flex justify-content-end">
    <button class="btn btn-primary" @click.prevent="saveProduct">{{ selected.id ? 'Update': 'Create' }}</button>
  </div>

</div>
</template>
<style lang="scss" scoped>

</style>