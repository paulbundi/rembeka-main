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
      'selected.id'() {
        this.hydrateColorVariants();
      },
      'selected.variants'() {
        this.hydrateColorVariants();
      },
      availableColors() {
        this.hydrateColorVariants();
      },
    },
    mounted() {
        this.updateProperty('type', 1);// product
        this.setMenuProperty({property: 'menuType', value: 1});
        this.fetchAvailableColors();
        this.hydrateColorVariants();
    },
    methods: {
      ...mapActions('Products', ['persist', 'setProperty', 'setSelected']),
      ...mapActions('Menus',{setMenuProperty: 'setProperty'}),
      async fetchAvailableColors() {
        try {
          const { data } = await this.$http.get('/colors');
          this.availableColors = data.data || [];
        } catch (e) {
          console.warn('Could not fetch colors', e);
        }
      },
      hydrateColorVariants() {
        if (!this.selected || this.selected.variant_type !== 'color') {
          return;
        }

        const variants = this.selected.variants || [];
        if (!variants.length) {
          return;
        }

        this.colorVariants = variants.map((variant) => {
          const match = this.availableColors.find(c => c.name === variant.color)
            || (this.selected.colors || []).find(c => c.name === variant.color);

          return {
            color_id: match ? match.id : null,
            stock: variant.stock != null ? variant.stock : 0,
          };
        });
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
<div class="pt-3">

  <!-- Section 1: Basic Info -->
  <div class="card mb-3">
    <div class="card-header py-2 bg-light"><strong>Basic Information</strong></div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Product Name <span class="text-danger">*</span></label>
          <input class="form-control" :value="selected.name" type="text" @input="(e) => updateProperty('name', e.target.value)" placeholder="e.g. Brazilian Wave Hair">
        </div>
        <div class="col-md-6">
          <label class="form-label">SKU</label>
          <input class="form-control" :value="selected.sku" type="text" @input="(e) => updateProperty('sku', e.target.value)" placeholder="e.g. BRW-001">
        </div>
        <div class="col-md-6">
          <label class="form-label">Brand</label>
          <remote-selector module="Brands" @change="(value) => updateProperty('brand_id', value)" :multiple='false' :value="selected.brand" />
        </div>
        <div class="col-md-6">
          <label class="form-label">Associated Menu <span class="text-danger">*</span></label>
          <remote-selector module="Menus" @change="(value) => updateProperty('menu_id', value)" :multiple='false' :value="selected.menu" />
        </div>
        <div class="col-md-6">
          <label class="form-label">Age Groups</label>
          <remote-selector module="AgeGroups" @change="(value) => updateProperty('age_groups', value)" />
        </div>
        <div class="col-md-6">
          <label class="form-label">Description <span class="text-danger">*</span></label>
          <textarea class="form-control" rows="3" @input="(e) => updateProperty('description', e.target.value)">{{selected.description}}</textarea>
        </div>
      </div>
    </div>
  </div>

  <!-- Section 2: Variant Type (prominent, on top) -->
  <div class="card mb-3">
    <div class="card-header py-2 bg-light"><strong>Variant Type</strong></div>
    <div class="card-body">
      <div class="d-flex gap-4">
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

      <!-- Color Variants inline under the toggle -->
      <div v-if="selected.variant_type === 'color'" class="mt-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="text-muted small">Add each color/shade option and its stock quantity.</span>
          <button type="button" class="btn btn-sm btn-outline-primary" @click="addColorVariant">
            <i class="bi bi-plus-lg"></i> Add Color
          </button>
        </div>
        <div v-if="colorVariants.length === 0" class="text-muted text-center py-3 border rounded bg-light">
          No colors added yet.
          <div><small>Need a new shade? Add it under <strong>Colors / Shades</strong> in the sidebar first.</small></div>
        </div>
        <div class="row g-2 align-items-center fw-semibold small mb-1" v-if="colorVariants.length > 0">
          <div class="col-5">Shade / Color</div>
          <div class="col-3">Stock</div>
          <div class="col-2">Preview</div>
          <div class="col-2"></div>
        </div>
        <div v-for="(variant, index) in colorVariants" :key="index" class="row g-2 align-items-center mb-2">
          <div class="col-5">
            <select class="form-select form-select-sm" v-model="variant.color_id">
              <option :value="null" disabled>Select shade...</option>
              <option v-for="color in availableColors" :key="color.id" :value="color.id">{{ color.name }}</option>
            </select>
          </div>
          <div class="col-3">
            <input type="number" class="form-control form-control-sm" v-model.number="variant.stock" min="0" placeholder="Stock">
          </div>
          <div class="col-2">
            <span v-if="getSelectedColor(variant.color_id)" class="badge"
              :class="getSelectedColor(variant.color_id).display_type === 'swatch' ? 'color-swatch-badge' : 'bg-secondary'"
              :style="getSelectedColor(variant.color_id).display_type === 'swatch' ? { backgroundColor: getSelectedColor(variant.color_id).hex_code } : {}">
              {{ getSelectedColor(variant.color_id).name }}
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

  <!-- Section 3: SEO & Visibility -->
  <div class="card mb-3">
    <div class="card-header py-2 bg-light"><strong>SEO &amp; Visibility</strong></div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">SEO Title <span class="text-danger">*</span></label>
          <textarea class="form-control" rows="2" @input="(e) => updateProperty('seo_title', e.target.value)">{{selected.seo_title}}</textarea>
        </div>
        <div class="col-md-6">
          <label class="form-label">SEO Description <span class="text-danger">*</span></label>
          <textarea class="form-control" rows="2" @input="(e) => updateProperty('seo_description', e.target.value)">{{selected.seo_description}}</textarea>
        </div>
        <div class="col-md-12">
          <label class="form-label">Search Keywords <span class="text-danger">*</span></label>
          <textarea class="form-control" rows="2" @input="(e) => updateProperty('keywords', e.target.value)">{{selected.keywords}}</textarea>
        </div>
        <div class="col-md-12">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="is_published" :checked="selected.is_published == 1" @input="(e) => updateProperty('is_published', e.target.checked)">
            <label class="form-check-label" for="is_published">Publish on e-commerce storefront</label>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-end">
    <button class="btn btn-primary px-4" @click.prevent="saveProduct">
      <i class="bi bi-check-lg me-1"></i>{{ selected.id ? 'Update Product' : 'Create Product' }}
    </button>
  </div>

</div>
</template>
<style lang="scss" scoped>
.color-swatch-badge {
  display: inline-block;
  min-width: 24px;
  height: 24px;
  padding: 0 6px;
  border-radius: 12px;
  border: 2px solid #ddd;
  color: #fff;
  font-size: 11px;
  line-height: 20px;
}
</style>
