<script>
import StylistFilter from './StylistFilter.vue';
import StylistList from './StylistList.vue';
export default {
  components: { StylistList, StylistFilter },
    name: 'MeetOurStylist',
    props: {
      productPricing: {
        type: Object,
        require: true,
      }
    },
    data() {
      return {
        providerPricing: null,
      }
    },
    created(){
      this.fetchStylist();
    },
    methods: {
      fetchStylist() {
        this.$axios.get(`/stylists/${this.productPricing.product_id}`).then(({ data }) => {
          this.providerPricing = data.data.data;
        });
      },
      handleSelectedProvider(provider) {
        this.$emit('selectedProvider', provider);
      },
      handleSearch(searchParams){
        this.$axios.get('/filter-stylist', { params:{...searchParams, productId:this.productPricing.product_id }}).then(({data}) => {
        }).catch((error) => {
          console.log(error);
        })
      }
    }
  };
</script>
<template>
  <div  class="row">
      <div class="col-3">
        <stylist-filter @search="handleSearch"/>
      </div>
     <div class="col-9">
       <stylist-list :providerPricing="providerPricing" @provider="handleSelectedProvider"/>
     </div>
  </div>
</template>
<style lang="scss" scoped>

</style>