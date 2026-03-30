<script>
  export default {
    name: 'MainSearchBar',
    props: {
      useBus: {
        type: Boolean,
        default: false,
      }
    },
    data(){
      return {
         results: [],
         query: '',
      }
    },
    methods: {
      handleInput(value) {
        if(value.length < 2) {
          return;
        }

        if(this.useBus) {
          this.$bus.$emit('main-search', value);
          return;
        }

        this.query = value;
        this.$axios.get(`/filter/${value}`).then(({ data }) => {
          this.results = data.data.data;
        }).catch((err) => {
          console.log('error', err);
        });
    },
    handleSearch() {
      if(this.useBus) {
        return ;
      }
      window.location.href=`/search?search=${encodeURI(this.query)}`;

    },
    },
  };
</script>
<template>
  <div class="w-100">
    <div class="input-group">
      <div class="input-group mb-3">
        <input type="text"
          v-model="query"
          @input="(e) => handleInput(e.target.value)"
          @keyup.enter="handleSearch"
          class="form-control" 
          placeholder="search products" 
          aria-label="search products"
          aria-describedby="basic-addon2">
        <span class="input-group-text cursor-pointer" id="basic-addon2" @click="handleSearch">
          <i class="bi bi-search text-danger"></i>
        </span>
      </div>
    </div>
    <div class="position-relative">
      <div v-if="(query.length > 1 && results.length > 0) && useBus == false" class="results position-absolute">
          <div class="results-container row">
            <div v-for="result in results" :key="result.id" class=" col-12 col-sm-4 mt-1" v-if="result.product">
              <div class="border my-2">
                <a :href="`/browse-by-categories/${result.category_id}`" class="d-flex flex-row">
                  <div class="col-6 col-sm-5">
                    <img 
                      v-if="result.product.attachments && result.product.attachments.length > 0 && result.product.attachments[0].media" 
                      class="search-product-image"  
                      :src="`${result.product.attachments[0].media.url}`" 
                      :alt="result.product.name"
                      width="150px"
                    >
                    <img v-else
                      class="search-product-image" 
                      src="/img/default.png" 
                      :alt="result.product.name"
                    >
                  </div>
                  <div class="col-6 col-sm-7 ps-1">
                    <a class="card-img-top d-block overflow-hidden" :href="`/product/${result.product.slug}/${result.product.id}`">
                      <h3 class="product-title fs-sm  mb-0"><a :href="`/product/${result.product.slug}/${result.product.id}`">{{ result.product.name }}</a></h3>
                    </a>
                    <a class="product-meta d-block fs-sm pb-1" href="#">{{result.style}}</a>
                    <rating :rating="5" :size="15" />
                    <div class="d-flex justify-content-between my-2">
                      <div class="product-price">
                        <template v-if="result.product && result.product.discount">
                          <span class="text-danger fw-bold">Ksh {{ result.product.discount.payable | numberFormat }}</span>
                          <del class="fs-sm text-muted">{{ result.product.discount.product_price | numberFormat }}</del>
                        </template>
                        <span v-else class="text-danger fw-bold">Ksh {{result.amount| numberFormat }}</span>
                      </div>
                    </div>

                    <small class="text-dark">{{result.product.name}}</small> <br/>
                    <a class="mb-2 btn btn-sm btn-primary" type="button" :href="`/product/${result.product.slug}/${result.product.id}`"><i class="ci-cart fs-sm me-1"></i>Add to Cart</a>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <button class="btn btn-sm btn-primary float-end text-white fw-bold my-1" @click="handleSearch">Show More</button>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.results{
  width: 100%;
  box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);
  background: #fdf7f9;
  padding: 0 4px;
}
.results-container{
  max-height:70vh !important;
  overflow-y:scroll;
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}

.results-container::-webkit-scrollbar {
  display: none;
}
</style>