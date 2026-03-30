<script>
  export default {
    name:'CartCreate',
    data() {
      return {
        cart: null,
      }
    },
    created() {
      this.cart  = window.store.cart;
    },
    methods: {
      handleRemove(item) {
        window.location.href = `/remove-from-cart/${item.id}`; 
      }
    }
  }
</script>
<template>
  <section class="col-lg-10">
    <!-- Item-->
    <div v-if="Object.keys(cart.items).length > 0">
      <div v-for="(item, index) in cart.items" :key="index" class="d-sm-flex justify-content-between align-items-center my-2 pb-3 border-bottom">
        <div class="d-block d-sm-flex align-items-center text-center text-sm-start">

          <a v-if="item.product.attachments && item.product.attachments.length > 0 && item.product.attachments[0].media" class="d-inline-block flex-shrink-0 mx-auto me-sm-4">
            <img :src="`${item.product.attachments[0].media.url}`" width="160" alt="Product">
          </a>
          <a v-else class="d-inline-block flex-shrink-0 mx-auto me-sm-4">
            <img src="/img/default.png" width="160" alt="Product">
          </a>

          <div class="pt-2">
            <h3 class="product-title fs-base mb-2"><a :href="`/product/${item.product.slug}/${item.product.id}`">{{ item.product.name }}</a></h3>
            <div v-if="item.type == 2">
              <div class="fs-sm" v-if="item.providerDetails"><span class="text-muted me-2">By: {{ item.providerDetails }}</span></div>
              <div class="fs-sm"><span class="text-muted me-2">Date: {{ item.fullAppointmentDate }}</span></div>
            </div>

            <div class="fs-lg text-accent pt-2">Ksh {{ item.total | numberFormat }}</div>
          </div>

        </div>
        <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-start" style="max-width: 9rem;">
          <label class="form-label" for="quantity1">Quantity</label>
          <input class="form-control" type="number" id="quantity1" min="1" :value="item.qty">
          <button class="btn btn-link px-0 text-danger" type="button" @click="() => handleRemove(item)"><i class="ci-close-circle me-2"></i><span class="fs-sm">Remove</span></button>
        </div>
      </div>
    </div>

      <!-- Navigation (mobile)-->
      <div class="row ">
        <div class="col-lg-12">
          <div class="d-flex  pt-sm-4 mt-sm-3">
            <div class="w-50 pe-3">
              <a class="d-none d-sm-inline btn btn-secondary d-block w-100" href="/search">
                <i class="ci-arrow-left mt-sm-0 me-1"></i>
                <span class="d-none d-sm-inline">Continue Shopping</span>
              </a>
            </div>
          </div>
        </div>
      </div>
  </section>
</template>

<style lang="scss" scoped>

</style>