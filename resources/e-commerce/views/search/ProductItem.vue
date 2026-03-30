
<script>
  export default {
    name:'ProductItem',
    props: {
      product: {
        type: [Object, Array],
        required: true
      },
      pricing: {
        type: [Object, Array],
        required: true,
      },
      loadingType: {
        type: String, 
        default: 'eager',
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
  <template v-if="product && product.discount">
    <span class="badge bg-danger badge-shadow"> {{product.discount.discount_amount}} % off</span>
  </template>
  <a class="btn-wishlist btn-sm" :href="`/wishlist/add/${product.slug}`" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist">
    <i class="ci-heart"></i>
  </a>
    <a class="card-img-top d-block overflow-hidden" :href="`/product/${product.slug}/${product.id}`"  style="max-height:250px;">
      <img class="product-list-image" :src="getImage(product)" :alt="product.name" :loading="loadingType">
    </a>
  <div class="card-body py-2">
    <a class="card-img-top d-block overflow-hidden" :href="`/product/${product.slug}/${product.id}`">
      <h3 class="product-title fs-sm  mb-0"><a :href="`/product/${product.slug}/${product.id}`">{{ product.name }}</a></h3>
    </a>
    <a class="product-meta d-block fs-sm pb-1" href="#">{{pricing.size}} {{pricing.unit.name}}</a>
    <rating :rating="5" :size="15" />
    <div class="d-flex justify-content-between my-2">
      <div class="product-price">
        <template v-if="product && product.discount">
          <span class="text-danger fw-bold">Ksh {{ product.discount.payable | numberFormat }}</span>
          <del class="fs-sm text-muted">{{ product.discount.product_price | numberFormat }}</del>
        </template>
        <span v-else class="text-danger fw-bold">Ksh {{pricing.amount| numberFormat }}</span>
      </div>
      <a class="btn btn-primary btn-sm d-block d-sm-none mb-2" type="button" :href="`/product/${product.slug}/${product.id}`"><i class="ci-cart fs-sm me-1"></i>Add to Cart</a>
    </div>
  </div>
  <div class="card-body card-body-hidden">
    <a class="btn btn-primary btn-sm d-block w-100 mb-2" type="button" :href="`/product/${product.slug}/${product.id}`"><i class="ci-cart fs-sm me-1"></i>Add to Cart</a>
    <!-- <div class="text-center"><a class="nav-link-style fs-ms" @click="()=>handleQucikView(product)" data-bs-toggle="modal"><i class="ci-eye align-middle me-1"></i>Quick view</a></div> -->
  </div>
</div>
</template>

<style lang="scss" scoped>

</style>