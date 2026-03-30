<script>
import MeetOurStylist from '../../stylists/MeetOurStylist.vue';
import BookOnWhatsApp from '../BookOnWhatsApp.vue';
import AddToCartForm from './ServiceCartForm.vue';
  export default {
    name: 'ServiceDetails',
    props: {
      product: {
        type: [Object, Array],
        required: true,
      },
      providerSelected: {
        type: Object,
        default: {},
      },
    },
    components: {
      MeetOurStylist,
      AddToCartForm,
      BookOnWhatsApp,
    },
    data() {
      return {
        provider: {},
        currentUrl: null,
        buttonToShow: null,
      };
    },
    mounted() {
      if(this.providerSelected){
        this.provider = this.providerSelected;
      }
      this.currentUrl = encodeURI(window.location.href);      
    },
    methods: {
      animateCart() {
        let cartItem = document.createElement('span'); 
        cartItem.setAttribute("class", "cart-item");
        let button = document.getElementById('add-to-cart-button');
        button.appendChild(cartItem);
        button.classList.add('sendtocart');
        setTimeout(function(){
          button.classList.remove('sendtocart');
          cartItem.remove();
        },1000);
      },
      handleSelectedProvider(provider) {
        this.provider = provider;
        document.getElementById('close-modal').click();
      }
    }
  };
</script>
<template>
  <div>
    <div class="d-flex justify-content-between">
      <div class="d-flex flex-column mb-2">
        <h1 class="h5">
          {{ product.name }}
          <small v-if="product.discount" class="badge bg-danger">
            {{parseInt(product.discount.discount_amount)}}% off
          </small>
        </h1>
        <span v-if="product.category">{{ product.category.name }}</span>
        <small>{{product.description}}</small>
      </div>
      <div>
        <a :href="`/wishlist/add/${product.slug}`" class="btn btn-icon btn-sm btn-secondary mb-1" type="submit" data-bs-toggle="tooltip" title="Add to Wishlist">
          <i class="ci-heart fs-lg"></i>
        </a>
      </div>
    </div>

    <template v-if="product.discount">
      <span class="h5 text-danger fw-bold">Ksh {{ product.discount.payable | numberFormat }}</span>
      <del class="fs-sm text-muted ms-2">{{ product.discount.product_price | numberFormat }}</del>
    </template>

    <span v-else class="text-danger fw-bold">Ksh {{product.final_price }}</span>

    <p>
      <b>Product Used: </b> <br/>{{product.product_used}}<br/>
      <small><b>NB: Cost above not inclusive of products.</b></small>
    </p>

    <h6 v-if="provider" class="text-primary">
      Booking with:
      <b>{{ provider.first_name }} {{ provider.last_name }}</b>
    </h6>

    <div v-if="product.type == 2 && provider.id == null">
      <book-on-whats-app :url="currentUrl"/>
    </div>

    <div v-if="product.type == 1 || provider.id != null">
      <add-to-cart-form :product="product" :provider="provider"/>
    </div>

    <p>
      <b>Duration of styling: </b><br/>{{product.duration_of_style}}
    </p>

    <p>
      <b>Durability: </b> <br/> {{product.durability}}
    </p> 
  
    <!-- stylist modal here-->
    <div class="modal fade" id="exampleModalToggle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalToggleLabel">Select Stylist</h5>
            <button type="button" class="btn-close" id="close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- modmeet-our-stylist 
              :productPricing="productPricing" 
              @selectedProvider='handleSelectedProvider'
            --->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<style lang="scss" scoped>

</style>