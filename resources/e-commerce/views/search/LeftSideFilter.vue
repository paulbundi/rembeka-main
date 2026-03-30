<script>
import noUiSlider from 'nouislider';
import Cookie from '../../mixins/Cookie';
import PriceRangeFilter from './PriceRangeFilter.vue';

  export default {
    name: "LeftSideFilter",
    props: {
      filters:{
        type: Object,
        required: true,
      }
    },
    components: { PriceRangeFilter },
    mixins:[Cookie],
    data() {
      return {
        activeTab: null,
        locations: [],
        searchLocation: [],
        menus: [],
        searchLocations: null,
        ageGroups:[],
        searchParams: {
          locations: [],
          types: [],
          menuId: null,
          rating: null,
          age_group: [],
        },
      };
    },
    watch: {
        searchLocations() {
            if (this.searchLocations.length < 1) {
                this.searchLocation = this.locations;
                return;
            }
            let filtered = this.locations.filter((item) => {
                return item.name.search(new RegExp(this.searchLocations, "i")) > 0;
            });
            if (filtered) {
                this.searchLocation = filtered;
            }
        },
        searchParams: {
            handler: function () {
                this.makeSearch();
            },
            deep: true
        },
        filters: {
            handler: function (value) {
              // this.searchParams = value;
            },
            deep: true
        }
    },
    computed: {
      appointmentTypes() {
        let types = [
          { name: "Home Visit", id: 2, },
          { name: "Salon Visit", id: 1 },
        ];
        return types;
      },
      productMenus() {
        let pMenu = [];
          pMenu = this.menus.filter((item) => item.type == 1);
        return pMenu;
      },
      serviceMenus() {
        let sMenu = [];
          sMenu = this.menus.filter((item) => item.type == 2);
        return sMenu;
      }
    },
    created() {
      this.activeTab = this.getCookie('activeMenuItem') || 'services';
      this.fetchLocationAndMenus();
    },
    methods: {
      updateTab(tab) {
        this.activeTab = tab;
        this.setCookie('activeMenuItem',tab, 365);
      },
      makeSearch() {
        this.$emit("search", this.searchParams);
      },
      fetchLocationAndMenus() {
        this.$axios.get("/get-menus").then(({ data }) => {
          this.menus = data.data.menus;
          this.ageGroups = data.data.age_groups;
        });
      },
      filterByMenu(menuId) {
        this.searchParams.menuId = menuId;
      },
      ratingFilter(value) {
        this.searchParams.rating = value;
      },
    },
    
};
</script>
<template>
  <div class="w-100 sticky-left-bar">
      <div class="card-body py-grid-gutter px-lg-grid-gutter">
        
        <!-- Categories-->
        <div class="widget widget-categories mb-2 border-bottom">
          <ul class="nav nav-tabs nav-justified mb-1" role="tablist">
            <li class="nav-item"><a class="nav-link fw-medium" :class="{ 'active': activeTab == 'services'}" @click="()=>updateTab('services')" href="#categories" data-bs-toggle="tab" role="tab">Services</a></li>
            <li class="nav-item">
              <a class="nav-link fw-medium" :class="{'show active': activeTab == 'products'}" href="#products" @click="()=>updateTab('products')" data-bs-toggle="tab" role="tab">Products</a>
            </li>
          </ul>
          <div class="offcanvas-body px-0 pt-3 pb-0" data-simplebar>
            <div class="tab-content">
              <div class="sidebar-nav tab-pane fade" :class="{'show active': activeTab == 'services'}" id="categories" role="tabpanel">
                <div class="accordion mt-n1" id="shop-categories">
                  <div v-for="menu in serviceMenus" :key="menu.id" class="accordion-item">
                    <h1 class="accordion-header mb-0 h-3">
                      <a class="accordion-button collapsed py-1" :href="`#menu${menu.id}`" role="button" data-bs-toggle="collapse" aria-expanded="false" :aria-controls="menu.name">
                        {{ menu.name }}
                      </a>
                    </h1>

                    <div class="collapse" :id="`menu${menu.id}`" data-bs-parent="#shop-categories">
                      <div class="accordion-body">
                        <div class="widget widget-links">
                          <ul class="widget-list">
                            <li class="widget-list-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#" 
                              @click="() => filterByMenu(menu.id)"><span>View all</span><span class="fs-xs text-muted ms-3">1,842</span></a></li>
                            <li v-for="levelOne in menu.children" class="widget-list-item">
                              <a class="widget-list-link d-flex justify-content-between align-items-center" href="#"
                                @click="() => filterByMenu(levelOne.id)"
                              >
                                <span>{{ levelOne.name }}</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="sidebar-nav tab-pane fade" :class="{'show active': activeTab == 'products'}" id="products" role="tabpanel">
                <div class="accordion mt-n1" id="shop-products">
                  <div v-for="pmenu in productMenus" :key="`product${pmenu.id}`" class="accordion-item">
                    <h1 class="accordion-header mb-0 h-3">
                      <a class="accordion-button collapsed py-1" :href="`#pmenu${pmenu.id}`" role="button" data-bs-toggle="collapse" aria-expanded="false" :aria-controls="pmenu.name">
                        {{ pmenu.name }}
                      </a>
                    </h1>

                    <div class="collapse" :id="`pmenu${pmenu.id}`" data-bs-parent="#shop-products">
                      <div class="accordion-body">
                        <div class="widget widget-links">
                          <ul class="widget-list">
                            <li class="widget-list-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#" 
                              @click="() => filterByMenu(pmenu.id)"><span>View all</span><span class="fs-xs text-muted ms-3">1,842</span></a></li>
                            <li v-for="level_one in pmenu.children" class="widget-list-item">
                              <a class="widget-list-link d-flex justify-content-between align-items-center" href="#"
                                @click="() => filterByMenu(level_one.id)"
                              >
                                <span>{{ level_one.name }}</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      <!-- Filter by Service Type-->
        <div class="widget widget-filter mb-2 border-bottom">
          <h3 class="widget-title mb-0">Appointment Type</h3>
          <ul class="widget-list widget-filter-list list-unstyled pt-1" style="max-height: 11rem;" data-simplebar data-simplebar-auto-hide="false">
            <li v-for="type in appointmentTypes" :key="type.id" class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" v-model="searchParams.types"  id="adidas" :value="type.id">
                <label class="form-check-label widget-filter-item-text" for="adidas">{{ type.name }}</label>
              </div>
            </li>
          </ul>
        </div>

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
        <!-- <div class="widget widget-filter mb-1 border-bottom">
          <h3 class="widget-title">Location</h3>
          <div class="input-group input-group-sm mb-2">
            <input v-model="searchLocations" class="widget-filter-search form-control rounded-end pe-5" type="text" placeholder="Search">
            <i class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
          </div>
          <ul class="widget-list widget-filter-list list-unstyled pt-1" style="max-height: 11rem;" data-simplebar data-simplebar-auto-hide="false">
            <li v-for="location in searchLocation" :key="location.id" class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
              <div class="form-check">
                <input class="form-check-input" 
                  type="checkbox"
                  v-model="searchParams.locations" 
                  id="adidas"
                  :value="location.id"
                  :checked="searchParams.locations.includes(location.id)"
                >
                <label class="form-check-label widget-filter-item-text" for="adidas">{{ location.name }}</label>
              </div>
            </li>
          </ul>
        </div> -->
        <!-- Price range-->
        <div class="widget mb-4 pb-4 border-bottom">
        </div>

        <!-- Filter by Age Group-->
        <div class="widget widget-filter mb-2 border-bottom">
          <h3 class="widget-title mb-0">Age Group</h3>
          <ul class="widget-list widget-filter-list list-unstyled pt-1" style="max-height: 11rem;" data-simplebar data-simplebar-auto-hide="false">
            <li v-for="group in ageGroups" :key="group.id" class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" v-model="searchParams.age_group"  id="adidas" :value="group.id">
                <label class="form-check-label widget-filter-item-text" for="adidas">{{ group.name }}</label>
              </div>
            </li>
          </ul>
        </div>
      </div>
  </div>
</template>
<style lang="scss" scoped>
.sticky-left-bar{
  position:sticky;
  top: 0px;
}
</style>