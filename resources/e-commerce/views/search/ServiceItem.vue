
<script>
  export default {
    name:'ServiceItem',
    props: {
      service: {
        type: [Object, Array],
        required: true
      },
      stylist: {
        type: Object,
        default: null,
      },
      loadingType: {
        type: String, 
        default: 'eager',
      }
    },
    computed: {
      getUrl() {
       let url = `/product/${this.service.slug}/${this.service.id}`;
        if(this.stylist) {
            url = `/service/${this.service.slug}/${this.service.id}/${this.stylist.id}`;
        }
        return url;
      }
    },
    methods: {
      getImage(attachments) {
        let attachment =  attachments.attachments;
        if(attachment.length > 0 && attachment[0].media){
          return `${attachment[0].media.url}`;
        }
        return '/img/default.png';
      },
    }
  };
</script>
<template>
<div class="card product-card">
    <template v-if="service && service.discount">
      <span class="badge bg-danger badge-shadow"> {{service.discount.discount_amount}} % off</span>
    </template>
    <a class="btn-wishlist btn-sm" :href="`/wishlist/add/${service.slug}`" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist">
      <i class="ci-heart"></i>
    </a>
      <a class="card-img-top d-block overflow-hidden" :href="getUrl">
        <img :src="getImage(service)" :alt="service.name" width="280px" height="280px" :loading="loadingType">
      </a>
    <div class="card-body py-2">
      <a class="card-img-top d-block overflow-hidden" :href="getUrl">
        <h3 class="product-title fs-sm  mb-0"><a :href="getUrl">{{ service.name }}</a></h3>
      </a>
      <span class="product-meta d-block fs-sm pb-1">{{service.style}}</span>
      <rating :rating="5" :size="15" />
      <div class="d-flex justify-content-between my-2">
        <div class="product-price">
          <template v-if="service && service.discount">
            <span class="text-danger fw-bold">Ksh {{ service.discount.payable | numberFormat }}</span>
            <del class="fs-sm text-muted">{{ service.discount.product_price | numberFormat }}</del>
          </template>
          <span v-else class="text-danger fw-bold">Ksh {{service.final_price| numberFormat }}</span>
        </div>
        <a class="btn btn-primary btn-sm d-block d-sm-none mb-2" type="button" :href="getUrl"><i class="ci-cart fs-sm me-1"></i>Add to Cart</a>
      </div>
    </div>
    <div class="card-body card-body-hidden">
      <a class="btn btn-primary btn-sm d-block w-100 mb-2" type="button" :href="getUrl"><i class="ci-cart fs-sm me-1"></i>Add to Cart</a>
      <!-- <div class="text-center"><a class="nav-link-style fs-ms" @click="()=>handleQucikView(product)" data-bs-toggle="modal"><i class="ci-eye align-middle me-1"></i>Quick view</a></div> -->
    </div>
  </div>
</template>

<style lang="scss" scoped>

</style>