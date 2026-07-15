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
        colorVariants: [],
        availableColors: [],
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
        this.fetchAvailableColors();
    },
    methods: {
      ...mapActions('Products', ['persist', 'setProperty', 'setSelected']),
      ...mapActions('Menus',{setMenuProperty: 'setProperty'}),
      async fetchAvailableColors() {
        try {
          const { data } = await this.$axios.get('/colors');
          this.availableColors = data.data || [];
        } catch (e) {
          console.warn('Could not fetch colors', e);
        }
      },
      addColorVariant() {
        this.colorVariants.push({ color_id: null, stock: 0 });
      },
      removeColorVariant(index) {
        this.colorVariants.splice(index, 1);
      },
      getSelectedColor(colorId) {
        if (!colorId) return null;
        return this.availableColors.find(c => c.id === colorId) || null;
      },
      saveProduct() {
        // Attach color variants data before persisting
        if (this.selected.variant_type === 'color' && this.colorVariants.length > 0) {
          this.updateProperty('color_variants', this.colorVariants);
        } else {
          this.updateProperty('color_variants', []);
        }
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
<div>
  <div class="row">
    <div class="col-6">
      <div class="form-group">
        <label class="fw-semibold">Variant Type</label>
        <div class="d-flex gap-3 mt-1">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="variant_type" id="variant_none" value="none"
              :checked="selected.variant_type === 'none' || !selected.variant_type"
              @change="(e) => updateProperty('variant_type', e.target.value)">
            <label class="form-check-label" for="variant_none">None</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="variant_type" id="variant_color" value="color"
              :checked="selected.variant_type === 'color'"
              @change="(e) => updateProperty('variant_type', e.target.value)">
            <label class="form-check-label" for="variant_color">Color Variants</label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <input type="checkbox" :checked="selected.is_published == 1" name="is_published" @input="(e)=>updateProperty('is_published', e.target.checked)">
        <label>Publish Product On the e-commerce side.</label>
      </div>
    </div>

    <div class="col-6">
      <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" @input="(e) => updateProperty('description', e.target.value)">{{selected.description}}</textarea>
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
        <textarea class="form-control" @input="(e) => updateProperty('seo_title', e.target.value)">{{selected.seo_title}}</textarea>
      </div>
      <div class="form-group">
        <label>Seo Description</label>
        <textarea class="form-control" @input="(e) => updateProperty('seo_description', e.target.value)">{{selected.seo_description}}</textarea>
      </div>
      <div class="form-group">
        <label>Search KeyWords</label>
        <textarea class="form-control" @input="(e) => updateProperty('keywords', e.target.value)">{{selected.keywords}}</textarea>
      </div>
    </div>
  </div>

  <!-- Color Variants Section (shown only when Color Variants is selected) -->
  <div v-if="selected.variant_type === 'color'" class="row mt-4">
    <div class="col-12">
      <div class="card border-primary">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <span><i class="bi bi-palette"></i> Color Options</span>
          <button type="button" class="btn btn-sm btn-light" @click="addColorVariant">
            <i class="bi bi-plus-lg"></i> Add Color
          </button>
        </div>
        <div class="card-body">
          <div v-if="colorVariants.length === 0" class="text-muted text-center py-3">
            No colors added yet. Click "Add Color" to add shade options for this product.
          </div>
          <div v-for="(variant, index) in colorVariants" :key="index" class="row mb-2 align-items-center border-bottom pb-2">
            <div class="col-5">
              <select class="form-select form-select-sm" v-model="variant.color_id">
                <option value="" disabled>Select shade code...</option>
                <option v-for="color in availableColors" :key="color.id" :value="color.id">
                  {{ color.name }}
                </option>
              </select>
            </div>
            <div class="col-3">
              <input type="number" class="form-control form-control-sm" v-model="variant.stock" min="0" placeholder="Stock">
            </div>
            <div class="col-2">
              <span v-if="getSelectedColor(variant.color_id)" class="badge" :class="getSelectedColor(variant.color_id).display_type === 'swatch' ? 'color-swatch-badge' : 'bg-secondary'">
                {{ getSelectedColor(variant.color_id)?.name }}
              </span>
            </div>
            <div class="col-2 text-end">
              <button type="button" class="btn btn-sm btn-outline-danger" @click="removeColorVariant(index)">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 d-flex justify-content-end mt-3">
    <button class="btn btn-primary" @click.prevent="saveProduct">{{ selected.id ? 'Update': 'Create' }}</button>
  </div>
</div>
</template>
<style lang="scss" scoped>
.color-swatch-badge {
  display: inline-block;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  border: 2px solid #ddd;
}
</style>
