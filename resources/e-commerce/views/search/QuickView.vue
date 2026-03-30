<script>
  export default {
    name: 'QuickView',
    props:{
     product: {
        type: [Object],
        default:null,
      }
    },
    data() {
      return {
        active: 0,
      }
    }
  };
</script>
<template>
  <div>
    <div v-if="product" class="row">
      <!-- Product gallery-->
      <div class="col-lg-7 pe-lg-0">
        <div class="product-gallery">
          <div class="product-gallery-preview order-sm-2">

            <div v-for="(attachment, index) in product.product.attachments" class="product-gallery-preview-item" :class="{'active': active == index}" :id="`image${index}`">
              <img :src="`${attachment.media.url}`" alt="Product image">
            </div>

          </div>

          <div class="product-gallery-thumblist order-sm-1">
            <a  v-for="(attachment, index) in product.product.attachments" 
              class="product-gallery-thumblist-item" 
              :class="{'active': active == index}"
              :href="`#image${index}`"
              @click="active = index"
            >
              <img :src="`${attachment.media.url}`" alt="Product">
            </a>
          </div>

        </div>
      </div>
      <!-- Product details-->
      <div class="col-lg-5 pt-4 pt-lg-0 image-zoom-pane">
        <add-to-cart-view :product-pricing="product" />
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>

</style>