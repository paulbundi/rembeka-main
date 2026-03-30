<script>
  export default {
    name: 'StylistFilter',
    data() {
      return {
        locationInput: '',
        locations: [],
        searchParams: {
          rating: null,
          locations: null,
        },
      };
    },
    watch: {
      'searchParams.locations'()  {
        this.$emit('search', this.searchParams);
      },
      locationInput() {
        this.filterLocation();
      },
    },
    created() {
      this.getLocations();
    },
    methods: {
      filterLocation() {
        this.$axios.get(`/search-location/${this.locationInput}`).then(({data}) => {
          this.locations = data.data;
        }).catch(({response}) => {});
      },
      getLocations() {
        this.$axios.get(`/unzoned-locations`).then(({data}) => {
          this.locations = data.data;
        }).catch((error) => {
          console.log(error);
        });

      }
    }
  };
</script>
<template>
  <div>
    <!-- Rating-->
    <div class="widget mb-2 border-bottom">
      <h3 class="widget-title mb-0">Rating</h3>
        <div class="cursor-pointer" @click="()=>ratingFilter(5)">
          <rating :rating="5" :size="15" :active-color="searchParams.rating == 5 ? '#ff7b55': '' "/>
        </div>
        <div class="cursor-pointer" @click="()=>ratingFilter(4)">
          <rating :rating="4" :size="15" :active-color="searchParams.rating == 4 ? '#ff7b55': '' "/>
        </div>
        <div class="cursor-pointer" @click="()=>ratingFilter(3)">
          <rating :rating="3" :size="15" :active-color="searchParams.rating == 3 ? '#ff7b55': '' "/>
        </div>
    </div>

    <!-- Filter by Location--> 
    <div class="widget widget-filter mb-1 border-bottom">
      <h3 class="widget-title">Location</h3>
      <div class="input-group input-group-sm mb-2">
        <input v-model="locationInput" class="widget-filter-search form-control rounded-end pe-5" type="text" placeholder="Search">
        <i class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
      </div>
      <ul class="widget-list widget-filter-list list-unstyled pt-1" style="max-height: 17rem;" data-simplebar data-simplebar-auto-hide="false">
        <li v-for="location in locations" :key="location.id" class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
          <div class="form-check">
            <input class="form-check-input" 
              type="radio"
              v-model="searchParams.locations" 
              id="adidas"
              :value="location.id"
              :key="location.id"
              :checked="searchParams.locations == location.id"
            >
            <label class="form-check-label widget-filter-item-text" for="adidas">{{ location.name }}</label>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
<style lang="scss" scoped>

</style>