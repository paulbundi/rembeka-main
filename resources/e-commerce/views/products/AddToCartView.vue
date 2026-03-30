<script>
import ServiceDetails from './service/ServiceDetails.vue';
import ProductDetails from './product/ProductDetails.vue';

  export default {
    name: 'AddToCartView',
    props: {
      product: {
        type: Object,
        required: true,
      },
      providerSelected: {
        type: Object,
        default: null,
      },
    },
    components: {
      ServiceDetails,
      ProductDetails,
    },
  }
</script>
<template>
  <div class="h-100 bg-light rounded-3 py-2 px-4 px-sm-5">
    <template v-if="product.type == 2">
      <service-details :product="product" :providerSelected="providerSelected"/>
    </template>

    <template v-if="product.type == 1">
      <product-details :product="product" />
    </template>

  </div>
</template>
<style lang="scss" scoped>

</style>