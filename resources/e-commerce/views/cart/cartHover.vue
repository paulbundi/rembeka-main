<script>
  export default {
    name: 'CartHover',
    props: {
      footerCart: {
        type: Boolean,
        default: false,
      }
    },
    created() {
        this.$bus.$on('cartUpdated', (data) => {
            this.cart ={ ...data};
            this.animateCart();
        })
        if(window.store.cart) {
            this.$bus.$emit('cartUpdated', window.store.cart);
        }
    },
    data() {
        return {
            cart: {
              coupon:null,
              items:{},
              paymentCost: 0,
              quantity: null,
              subTotal: null,
              taxes: [],
              total: null,
              transportFee: null,
            },
        };
    },
    methods: {
      handleRemoveItem(item) {
        window.location.href = `/remove-from-cart/${item.id}`; 
      },
      animateCart() {
        let cart = null;
        if(this.footerCart) {
          cart = document.getElementById('footerCart');
        }else {
          cart = document.getElementById('headercart');
        }

        if(cart) {
          cart.classList.add('shake');
          setTimeout(function(){
            cart.classList.remove('shake');
          },500);
        }
      }
    }
  };
</script>
<template>
<div>
  <a v-if="footerCart" class="d-table-cell handheld-toolbar-item"  href="/checkout/cart" id="footerCart">
    <span class="handheld-toolbar-icon">
      <i class="ci-cart"></i><span class="badge bg-primary rounded-pill ms-1">{{ Object.keys(cart.items).length }}</span>
    </span>
    <span class="handheld-toolbar-label">Ksh {{cart.total}}</span>
  </a>

  <div v-else class="navbar-tool dropdown ms-3">
    <a class="navbar-tool-icon-box bg-secondary dropdown-toggle shopping-cart" href="/checkout/cart" id="headercart">
      <span class="navbar-tool-label">{{ Object.keys(cart.items).length }}</span>
      <i class="navbar-tool-icon ci-cart"></i>
    </a>
    <a class="navbar-tool-text"  href="/checkout/cart"><small>My Cart</small>Ksh {{cart.total}}</a>
      <!-- Cart dropdown-->
      <div v-if="cart.items && Object.keys(cart.items).length > 0" class="dropdown-menu dropdown-menu-end">
        <div class="widget widget-cart px-3 pt-2 pb-3" style="width: 20rem;">
            <div style="height: 15rem;" data-simplebar data-simplebar-auto-hide="false">

            <div v-for="(item, index) in cart.items" class="widget-cart-item pb-2 border-bottom" :key="index">
                <button class="btn-close text-danger" type="button" aria-label="Remove" @click="()=>handleRemoveItem(item)"><span aria-hidden="true">&times;</span></button>
                <div class="d-flex align-items-center">
                  <a v-if="item.product.attachments && item.product.attachments.length > 0 && item.product.attachments[0].media" class="d-block flex-shrink-0">
                    <img :src="`${item.product.attachments[0].media.url}`" width="64" alt="Product">
                  </a>

                  <a v-else class="d-block flex-shrink-0" href="#">
                    <img src="/img/default.png" width="64" alt="Product">
                  </a>

                  <div class="ps-2">
                      <h6 class="widget-product-title"><a :href="`/product/${item.product.slug}/${item.providerId}`">{{item.product.name}}</a></h6>
                      <div class="widget-product-meta">
                        <span class="text-accent me-2">{{item.total}}</span>
                        <span class="text-muted">x {{item.qty}}</span>
                      </div>
                  </div>
                </div>
            </div>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
            <div class="fs-sm me-2 py-2"><span class="text-muted">Total:</span><span class="text-accent fs-base ms-1">{{ cart.total}}</span></div>
            <a class="btn btn-outline-secondary btn-sm" href="/checkout/cart">Expand cart<i class="ci-arrow-right ms-1 me-n1"></i></a>
            </div><a class="btn btn-primary btn-sm d-block w-100" href="/checkout/cart"><i class="ci-card me-2 fs-base align-middle"></i>Checkout</a>
        </div>
      </div>
  </div>

</div>
</template>

<style lang="scss" scoped>

</style>