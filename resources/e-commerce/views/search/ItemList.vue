<script>
import QuickView from './QuickView.vue';
import NoResults from './NoResults.vue';
import ServiceItem from './ServiceItem.vue';
import ProductItem from './ProductItem.vue';

  export default {
  components: { QuickView, NoResults, ServiceItem, ProductItem },
    name: 'ItemList',
    props:{
      products: {
        type:[Object, Array],
        default() {
            return {}
        },
      },
      loadingData: {
        type: Boolean,
        default: true,
      },
    },
    data() {
        return {
          quickViewProduct: null,
          lazyLoadLimit: 9,
        }
    },
    methods: {
 
      handleQuickView(product) {
        this.quickViewProduct = product;
        this.$refs.showModal.click();
      },
      handleClearFilters() {
        this.$emit('clearFilters');
      }
    }
  };
</script>
<template>
<div class="row mx-n2 mt-4">
  <template v-for="(product, index) in products" >
    <div v-if="product.type == 2" class="col-md-4 col-sm-6 px-2 mb-4" :key="`item-${product.id}`">
      <service-item :service="product" :loading-type="index >lazyLoadLimit ? 'lazy':'eager'" />
    </div>
    
    <div v-if="product.type == 1" v-for="pricing in product.supplier_price" class="col-md-4 col-sm-6 px-2 mb-4" :key="`item${pricing.id}`">
      <product-item v-if="pricing.amount > 0" :product="product" :pricing="pricing"  :loading-type="index >lazyLoadLimit ? 'lazy':'eager'"/>
    </div>

    
    <hr class="d-sm-none">
  </template>

  <div v-if="loadingData" class="w-100 h-100 d-flex mt-4 align-items-center justify-content-center">
    <div class="spinner-border text-muted"></div>
  </div>

  <div v-if="products.length == 0 && loadingData != true" class="col-12">
    <no-results @clearFilters="handleClearFilters"/>
  </div>

<!-- Button trigger modal TODO use ref instead of below hack-->
<button  type="button" id="showModal" ref="showModal" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#quicViewModal"></button>
  <!-- quick view modal Modal -->
<div class="modal fade" id="quicViewModal" ref="quickView" tabindex="-1" aria-labelledby="quicViewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="quicViewModalLabel">Quick View</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <quick-view :product="quickViewProduct"/>
      </div>
    </div>
  </div>
</div>
</div>
</template>

<style lang="scss" scoped>

</style>