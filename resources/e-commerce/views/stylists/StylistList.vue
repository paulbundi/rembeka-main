
<script>
  export default {
    name: 'StylistList',
    props: {
      providerPricing: {
        type: [Object,Array],
        default: null,
      }
    },
    data() {
      return {
        provider: {},
        providerPricingId: null,
        showing: null,
      }
    },
    methods: {
      getImage(stylist){
        if(!stylist.profile ||  stylist.profile.attachments.length < 1) {
          return '/img/default.png';
        }
        let attachment =  stylist.profile.attachments;
        if(attachment && attachment.length > 0 && attachment[0].media){
          return `${attachment[0].media.url}`;
        }
        return '/img/default.png';
      },
      showSelected(item) {
        this.providerPricingId = item.id;
        this.showing = item.provider.profile;
      },
      bookStylist(providerPricing) {
        this.$emit('provider', providerPricing);
      }
    }
  };
</script>

<template>
  <div class="row">
    <div class="row col-8 col-xs-12">
      <div class="col-12">
        <input type="text" class="form-control" placeholder="search by name">
      </div>
      <!-- Product-->
      <div v-for="item in providerPricing" :key="item.id" class="col-md-4 col-sm-6 px-2 mb-4 mt-2">
        <div class="card product-card" :class="{'selected' : providerPricingId ==  item.id}" @click="()=>showSelected(item)">
           <div v-if="providerPricingId ==  item.id" class="position-absolute" style="right: 0;">
            <i class="bi bi-check-lg fw-bolder selectedSylist"></i>
          </div>

            <div class="card-img-top d-block overflow-hidden">
              <img class="product-list-image" :src="getImage(item.provider)" alt="Stylist" style="max-height:250px;">
            </div>
          <div class="card-body py-2">
            <h3 class="product-title fs-sm  mb-0">
              <a href="">{{ item.provider.first_name }} {{ item.provider.last_name }}</a>
            </h3>
            <rating :rating="5" :size="15" />

            <button 
              v-if="providerPricingId ==  item.id"
              class="btn btn-primary btn-shadow mt-3" 
              type="button"
              @click="() => bookStylist(item)"
              id="bookStylist"
            >
              <i class="ci-cart fs-lg me-2"></i>
              Book Stylist
            </button>
          </div>
        </div>
        <hr class="d-sm-none">
      </div>
      <!-- Product-->
    </div>

    <div v-if="showing" class="col-4 d-none d-sm-block">
      <label>Qualifications</label>:
      <p>{{ showing.professional_qualifications }}</p>

      <label>Work Experience</label>:
      <p>{{ showing.works_experience }}</p>
    </div>

  </div>
</template>

<style lang="scss" scoped>
.selected{
  border: global-variable-exists($name: -bs-success);
}
</style>