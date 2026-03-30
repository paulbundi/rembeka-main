<script>
import LeftSideFilter from './LeftSideFilter.vue'
import ItemList from './ItemList.vue'
  export default {
    name: 'ProductFind',
    components: { LeftSideFilter, ItemList },
    data() {
      return {
          results: [],
          loadingData: null,
          searchParams: {
            searchStr: '',
            locations: [],
            types:[],
            menuId: null,
            category: null,
          }
      }
    },
    created() {
      
      if(this.searchQuery) {
        this.searchParams.searchStr = this.searchQuery;
      }
      this.$bus.$on('main-search', (query) => {
        this.searchParams.searchStr = query;
        this.handleSearch();
      });

      if(this.menu && this.menu != 'null') {
        this.searchParams = {
          ...this.searchParams,
          menuId: this.menu,
        };
      }

      if(this.category && this.category != 'null') {
        this.searchParams = {
          ...this.searchParams,
          category: this.category,
        };
      }

      this.handleSearch();
    },
    methods: {
      handleSearch(payload = null) {
        this.loadingData = true;
        if(payload) {
          this.searchParams = {...payload};
        }
        this.$axios.get('/products-search', {params:{...this.searchParams }}).then(({data}) => {
          this.results = data.products.data;
          window.scroll({ top: 0, left: 0, behavior: 'smooth'});
        }).finally(() => {
          this.loadingData = false;
        });

      },
      handleClearFilters() {
        this.searchParams = {
            searchStr: '',
            locations: [],
            types:[],
            menuId: null,
          };
          this.handleSearch();
      }
    },
  };
</script>
<template>
  <div class="row position-relative" id="product-list-show">
    <div class="d-none d-sm-block col-sm-3 position-sticky card">
      <left-side-filter @search="handleSearch" :filters='searchParams'/>
    </div>
    
    <div class="col-12 col-sm-8">
      <img src="/img/51zzz-77zML.jpg"/><br/>
      <h4 class="text-danger mt-2">Congratulations!!! Congratulations!!!!</h4>
      <h5 class="mt-2">Please claim your price by contacting us via WhatsApp.</h5>
    </div>

    <div class="d-sm-none offcanvas offcanvas-collapse bg-white w-100 rounded-3 shadow-lg py-1" id="shop-sidebar">
      <div class="offcanvas-header align-items-center shadow-sm">
        <button class="btn-close ms-auto" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="mobile-filter">
        <left-side-filter @search="handleSearch" :filters='searchParams'/>
      </div>
    </div>

  </div>
</template>
<style lang="scss" scoped>

.mobile-filter{
  height: 90vh;
  overflow-y: scroll;
}
</style>