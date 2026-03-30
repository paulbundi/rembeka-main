<script>
  export default {
    name: 'CartCreateSummaryDetails',
    data() {
      return {
        cart: window.store.cart,
        notes: null,
      }
    },
    methods: {
      handleCheckout () {
        if(this.notes == null || this.notes.length < 5) {
          window.location.href="/checkout/details";
        }
        this.$axios.post('/order-additional-info',{notes: this.notes}).then(({data}) => {

        }).catch(({response}) => {
           
        }).finally (() => {
          window.location.href="/checkout/details";
        });
      }
    }
  };
</script>
<template>
  <!-- Sidebar-->
  <aside v-if="cart && Object.keys(cart.items).length > 0" class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
    <div class="bg-white rounded-3 shadow-lg p-4">
      <div class="py-2 px-xl-2">
        <div class="text-center mb-4 pb-3 border-bottom">
          <h2 class="h6 mb-3 pb-1">Subtotal</h2>
          <h4 class="fw-normal text-accent">Ksh {{ cart.total | numberFormat }}</h4>
        </div>
        <div class="mb-3 mb-4">
          <label class="form-label mb-3" for="order-comments"><span class="badge bg-info fs-xs me-2">Note</span><span class="fw-medium">Additional comments</span></label>
          <textarea class="form-control" rows="6" id="order-comments" v-model="notes"></textarea>
        </div>
        <!-- <div class="accordion" id="order-options">
          <div class="accordion-item">
            <h3 class="accordion-header">
              <a class="accordion-button" href="#promo-code" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="promo-code">Apply promo code</a></h3>
            <div class="accordion-collapse collapse show" id="promo-code" data-bs-parent="#order-options">
              <form class="accordion-body needs-validation" method="post" novalidate>
                <div class="mb-3">
                  <input class="form-control" type="text" placeholder="Promo code" required>
                  <div class="invalid-feedback">Please provide promo code.</div>
                </div>
                <button class="btn btn-outline-primary d-block w-100" type="submit">Apply promo code</button>
              </form>
            </div>
          </div>
        </div> -->
        
        <div class="w-100">
          <button class="btn btn-primary btn-shadow d-block w-100 mt-2" @click="handleCheckout"><i class="ci-card fs-lg me-2"></i>Proceed to Checkout</button>
          <a class="d-block d-sm-none btn btn-dark btn-shadow d-block w-100 mt-4" href="/search"><i class="ci-cart fs-lg me-2"></i>Continue Shopping</a>
        </div>

      </div>
    </div>
  </aside>
</template>


<style lang="scss" scoped>

</style>