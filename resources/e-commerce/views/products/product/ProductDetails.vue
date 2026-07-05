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
     if (this.product.variants && this.product.variants.length > 0) {
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
      }
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

    <div v-if="product.variants && product.variants.length > 0" class="fs-sm mb-4">
      <span class="text-heading fw-medium me-1">Color:</span>
      <span class="text-muted" id="colorOption">{{ selectedVariant ? selectedVariant.color : '' }}</span>
    </div>
    <div v-if="product.variants && product.variants.length > 0" class="position-relative me-n4 mb-3">
        <div v-for="(variant, index) in product.variants" :key="variant.id" class="form-check form-option form-check-inline mb-2">
          <input class="form-check-input" type="radio" name="color" :id="`variant-${variant.id}`" :value="variant.color" v-model="formOrder.color">
          <label class="form-option-label rounded-circle" :for="`variant-${variant.id}`" @click="handleVariantSelect(variant)">
            <span class="form-option-color rounded-circle" :style="variant.image ? `background-image: url(${variant.image})` : 'background-color: #ccc'"></span>
          </label>
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

</style>