<script>
import { mapState } from 'vuex';
import SupplierPricingIndex from '../../../supplier-pricing/components/SupplierPricingIndex.vue';
  export default {
  components: { SupplierPricingIndex },
    name: 'ProductPricing',
    computed: {
      ...mapState({
        selected: state => state.Products.selected,
      }),
    }, 
    };
</script>
<template>
  <div v-if="selected.id">
    <supplier-pricing-index :product-id="selected.id"/>
  </div>
</template>

<style lang="scss" scoped>

</style>