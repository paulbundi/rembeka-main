<script>
import StylistProfile from './StylistProfile.vue'
import StylistRating from './StylistRating.vue';
import StylistServiceList from './StylistServiceList.vue'
  export default {
  components: { StylistProfile, StylistServiceList, StylistRating },
    name:'StylistDetails',
    props: {
      stylist: {
        type: [Object, Array],
        required: true,
      }
    }
  };
</script>
<template>
  <div class="row sticky-container-holder mx-sm-4" id="product-list-show" style="margin-top:6em;">
    <div class="col-12 col-sm-3 sticky-area card">
      <stylist-profile :stylist="stylist"/>
    </div>
    
    <div class="col-12 col-sm-6">
      <h4 class="mt-sm-2">Book My Services</h4>
      <stylist-service-list :stylist="stylist"/>
    </div>

    <div class="col-12 col-sm-3">
      <stylist-rating :stylist="stylist"/>
    </div>

  </div>
</template>

<style lang="scss" scoped>
.sticky-container-holder{
  align-items: flex-start;
}
.sticky-area {
  position: -webkit-sticky;
  position: sticky;
  top: 4rem;
}
</style>