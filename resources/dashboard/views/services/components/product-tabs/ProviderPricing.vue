<script>
import { mapState } from 'vuex';
import ProviderPricingIndex from '../../../ProviderPricing/components/ProviderPricingIndex.vue';
  export default {
  components: { ProviderPricingIndex },
    name: 'ProviderPricing',
    computed: {
      ...mapState({
        selected: state => state.Services.selected,
      }),
    }, 
    };
</script>
<template>
  <div v-if="selected.id">
    <provider-pricing-index :product-id="selected.id" />
  </div>
</template>

<style lang="scss" scoped>

</style>