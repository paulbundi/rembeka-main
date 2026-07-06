<script>
import BookOnWhatsApp from '../BookOnWhatsApp.vue';
  export default {
    components: { BookOnWhatsApp },
    name: 'ProductDetails',
    props: {
      product: {
        type: Object,
        required: true,
      },
    },
    data() {
      return {
        currentUrl: null,
        errors: [],
        activeItem: {},
        selectedVariant: null,
        formOrder: {
          pricing_id: null,
          variant_id: null,
          color: null,
          quantity: 1,
          type: 1,
        },
      };
    },
    created() {
      this.activeItem = this.product.supplier_price[0];
      if (this.product.variant_type === 'color' && this.product.variants && this.product.variants.length > 0) {
        this.selectedVariant = this.product.variants[0];
        this.formOrder.variant_id = this.product.variants[0].id;
        this.formOrder.color = this.product.variants[0].color;
      }
    },
    mounted() {
      this.currentUrl = encodeURI(window.location.href);      
    },
    methods: {
      handleAddToCart() {
        this.formOrder.pricing_id = this.activeItem.id;
        this.$axios.post('/add-to-cart', this.formOrder).then(({data}) => {
          this.$bus.$emit('cartUpdated', data.data);
          this.$toast.success('Cart updated');
          this.animateCart();
        }).catch(({response}) => {
            if (response.status == 422) {
              this.errors = response.data.errors;
            }
        });
      },
      handleSizeChange(selectedIndex) {
        this.activeItem = this.product.supplier_price[selectedIndex];
      },
      handleVariantSelect(variant) {
        this.selectedVariant = variant;
        this.formOrder.variant_id = variant.id;
        this.formOrder.color = variant.color;
      },
      getVariantDisplayType(variant) {
        return variant?.attributes?.find?.(attr => attr.attribute === 'color')?.display_type || 'pill';
      },
      getVariantHexCode(variant) {
        return variant?.attributes?.find?.(attr => attr.attribute === 'color')?.hex_code || null;
      },
      // Determines if a variant name is a known CSS color or a business code
      isBusinessCode(colorName) {
        if (!colorName) return true;
        const cssColors = ['red', 'blue', 'green', 'purple', 'wine', 'burgundy', 'yellow', 'black', 'white', 'orange', 'pink'];
        return !cssColors.includes(colorName.toLowerCase());
      },
      // Check if variant has an associated color swatch from the product_color pivot
      getVariantSwatchColor(variant) {
        if (!this.product.colors || !variant) return null;
        const matchingColor = this.product.colors.find(c => c.name === variant.color);
        if (matchingColor && matchingColor.display_type === 'swatch' && matchingColor.hex_code) {
          return matchingColor.hex_code;
        }
        return null;
      },
      getVariantDisplayMode(variant) {
        if (!this.product.colors || !variant) return 'pill';
        const matchingColor = this.product.colors.find(c => c.name === variant.color);
        return matchingColor?.display_type || 'pill';
      },
    },
  };
</script>
<template>
  <div>
    <div class="d-flex justify-content-between">
      <div class="d-flex flex-column mb-2">
        <h1 class="h5">
          {{ product.name }}
          <small v-if="product.discount" class="badge bg-danger">
            {{parseInt(product.discount.discount_amount)}}% off
          </small>
        </h1>
        <span v-if="product.category">{{ product.category.name }}</span>
        <small>{{product.description}}</small>
      </div>
      <div>
        <a :href="`/wishlist/add/${product.slug}`" class="btn btn-icon btn-sm btn-secondary mb-1" type="submit" data-bs-toggle="tooltip" title="Add to Wishlist">
          <i class="ci-heart fs-lg"></i>
        </a>
      </div>
    </div>

    <span class="text-danger fw-bold">Ksh {{activeItem.amount}}</span>
    <p> Size: {{activeItem.size}} {{activeItem.unit.name }}</p>

    <!-- Color Variant Selector - Pill Based UI -->
    <div v-if="product.variant_type === 'color' && product.variants && product.variants.length > 0" class="fs-sm mb-4">
      <span class="text-heading fw-medium me-1">Choose Color:</span>
      <span class="text-muted" id="colorOption">{{ selectedVariant ? selectedVariant.color : '' }}</span>
    </div>
    <div v-if="product.variant_type === 'color' && product.variants && product.variants.length > 0" class="position-relative me-n4 mb-3">
      <div class="d-flex flex-wrap gap-2">
        <div v-for="(variant, index) in product.variants" :key="variant.id" 
          class="color-option" 
          :class="{ 'selected': selectedVariant && selectedVariant.id === variant.id }"
          @click="handleVariantSelect(variant)">
          
          <!-- Swatch display for named CSS colors (Red, Blue, Purple, etc.) -->
          <template v-if="getVariantDisplayMode(variant) === 'swatch' && getVariantSwatchColor(variant)">
            <div class="color-swatch-circle" :style="{ backgroundColor: getVariantSwatchColor(variant) }">
              <i v-if="selectedVariant && selectedVariant.id === variant.id" class="ci-check text-white"></i>
            </div>
          </template>
          
          <!-- Pill display for business codes (1B, 27, 613, etc.) -->
          <template v-else>
            <span class="color-pill-label" :class="{ 'selected': selectedVariant && selectedVariant.id === variant.id }">
              <i v-if="selectedVariant && selectedVariant.id === variant.id" class="ci-check me-1"></i>
              {{ variant.color }}
            </span>
          </template>
        </div>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-12 col-sm-6">
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center pb-1">
            <label class="form-label" for="product-size">Size:</label>
          </div>
          <select class="form-select" required id="product-size" @change="(e) => handleSizeChange(e.target.value)">
            <option v-for="(pricing,i) in product.supplier_price" :value="i">{{pricing.size}}</option>
          </select>
        </div>
      </div>

      <div class="col-6 d-none d-sm-block">
        <book-on-whats-app :url="currentUrl"/>
      </div>

      <div class="col-12 col-sm-6">
        <div class="form-group">
          <label for="quantity">Quantity</label>
          <input type="number" class="form-control" name="quantity" v-model="formOrder.quantity" min="1">
        </div>
      </div>

      <div class="col-12 col-sm-6 mt-2 d-flex flex-column">
        <button 
          class="btn btn-primary btn-shadow mt-3" 
          type="button"
          @click="handleAddToCart"
          id="add-to-cart-button"
        >
          <i class="ci-cart fs-lg me-2"></i>
          Add to Cart
        </button>
      </div>

      <div class="col-12 d-block d-sm-none">
        <book-on-whats-app :url="currentUrl"/>
      </div>

    </div>

  </div>
</template>

<style lang="scss" scoped>
.color-option {
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  transition: all 0.2s ease;
  
  &:hover {
    .color-pill-label {
      border-color: #c12c5d;
      background-color: #fff1f6;
    }
    .color-swatch-circle {
      border-color: #c12c5d;
      transform: scale(1.05);
    }
  }
  
  &.selected {
    .color-pill-label {
      border-color: #c12c5d;
      background-color: #fff1f6;
      color: #c12c5d;
      font-weight: 600;
    }
    .color-swatch-circle {
      border-color: #c12c5d;
      box-shadow: 0 0 0 3px #fff1f6;
    }
  }
}

.color-pill-label {
  display: inline-flex;
  align-items: center;
  padding: 8px 16px;
  border: 2px solid #e0e0e0;
  border-radius: 24px;
  font-size: 13px;
  font-weight: 500;
  color: #333;
  background-color: #fff;
  transition: all 0.2s ease;
  min-width: 44px;
  justify-content: center;
}

.color-swatch-circle {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border: 2px solid #e0e0e0;
  border-radius: 50%;
  transition: all 0.2s ease;
  
  i {
    font-size: 16px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
  }
}
</style>