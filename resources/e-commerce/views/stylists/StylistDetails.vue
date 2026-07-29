<script>
import StylistProfile from './StylistProfile.vue'
import StylistRating from './StylistRating.vue';
  export default {
  components: { StylistProfile, StylistRating },
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
  <div class="row sticky-container-holder mx-sm-4" style="margin-top:6em;">
    <div class="col-12 col-sm-4 sticky-area card">
      <stylist-profile :stylist="stylist"/>
    </div>

    <div class="col-12 col-sm-8">
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