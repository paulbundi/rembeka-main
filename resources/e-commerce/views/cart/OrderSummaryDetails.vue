<script>
  export default {
    name: 'OrderSummaryDetails',
    data() {
      return {
        cart: window.store.cart,
      };
    },
  }
</script>
<template>
<div class="bg-white rounded-3 shadow-lg p-4 ms-lg-auto">
  <div class="py-2 px-xl-2">
    <div class="widget mb-3">
      <h2 class="widget-title text-center">Order summary</h2>

      <div v-for="(item, index) in cart.items" class="d-flex align-items-center py-2 border-bottom" :key="index">

        <a v-if="item.product.attachments && item.product.attachments.length > 0 && item.product.attachments[0].media" class="d-block flex-shrink-0">
          <img :src="`${item.product.attachments[0].media.url}`" width="64" alt="Product">
        </a>

        <a v-else class="d-block flex-shrink-0" href="#">
          <img src="/img/default.png" width="64" alt="Product">
        </a>

        <div class="ps-2">
          <h6 class="widget-product-title">
            <a :href="`/product/${item.product.slug}/${item.product}`">{{ item.product.name }}</a>
          </h6>
          <div class="widget-product-meta">
            <span class="text-accent me-2">Ksh {{ item.unitPrice | numberFormat }}</span>
            <span class="text-muted">x {{item.qty}}</span></div>
        </div>
      </div>

    </div>
    <ul class="list-unstyled fs-sm pb-2 border-bottom">
      <li class="d-flex justify-content-between align-items-center"><span class="me-2">Subtotal:</span><span class="text-end">{{ cart.total | numberFormat }}</span></li>
    </ul>
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="">Total Amount:</h5>
      <h5 class=""> Ksh {{ cart.total | numberFormat }} </h5>
    </div>

    <!-- <div class="d-flex justify-content-between align-items-center">
      <h5 class="">Deposit:</h5>
      <h5 class="">Ksh {{ (cart.total * 0.50) | numberFormat }}</h5>
    </div> -->
    
  </div>
</div>
</template>
<style lang="scss" scoped>

</style>