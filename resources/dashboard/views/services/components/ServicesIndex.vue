<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ServicesFilter from './ServicesFilter.vue';

export default {
  name: 'ServicesIndex',
  components: {ServicesFilter},
  props: {
    showActions:{
      type: Boolean,
      default:true,
    },
    selectable: {
      type: Boolean,
      default:false,
    }
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      services: state => state.Services.items,
      loading: state => state.Services.loadingItems,
      user: state => state.authUser,
    }),
  },
  data() {
    return {
      filter: null,
      selectedIds: null,
    }
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Services',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),
    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['attachments.media', 'menu', ],
      });
      this.fetchAll();
    },
    handleSortBy(value) {
      if(value == this.filter) {
         if(this.filter.startsWith('-')) {
            this.filter = value;
         } else {
            this.filter = `-${value}`;
         }
      }else {
        this.filter = value;
      }
      this.setProperty({property: 'sorts', value:[this.filter]});
      this.fetchAll();
    },
    deleteProduct(product) {
      this.$confirm().then(() => {
        this.destroy(product.id).then(() => {
         	this.$toast.success('Product deleted Successfully');
        });
      })
    },
    changeProductStatus(product) {
      let newProduct = {...product, status: product.status !== 1 ? 1: null}
      this.setSelected(newProduct);
      this.$confirm().then(() => {
        this.persist().then(() => {
         	this.$toast.success('Success');
          this.fetchItems();
        }).catch(({response}) => {
          catchValidationErrors(this, response);
        });
      })
    },
    handleCheckBox(item) {
      this.selectedIds = item.id;
      this.$emit('selected', item);
    },
  }
};
</script>
<template>
  <div>
    <div class="card">
      <services-filter />
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>
                  <div class="d-flex">
                    #id
                    <i class="bi bi-filter-square ms-1 cursor-pointer" @click="() => handleSortBy('id')"></i>
                  </div>
                </th>
                <th>Name</th>
                <th>Menu/ Cat</th>
                <th>Keywords</th>
                <th>SEO</th>
                <th>Cost of labour</th>
                <th>Provider Cost</th>
                <th>Comm(%)</th>
                <th>Platform Fee</th>
                <th>Listing Price</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in services" :key="product.id">
                <td>
                  <input v-if="selectable"
                    type="checkbox" 
                    :checked="selectedIds == product.id" 
                    :value="product.id"
                    @change="()=> handleCheckBox(product)" 
                  />
                  {{product.id}}
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="me-2">
                      <div v-if="product.attachments  && product.attachments.length > 0">
                        <img class="rounded-circle" :src="`${product.attachments[0].media.url}`" width="80" height="80" />
                      </div>
                    </div>
                      <div class="d-flex flex-column">
                        <a v-if="canUserAccess('services.update')" :href="`/services/${product.id}`"> {{ product.name }} </a>
                        <span v-else>{{ product.name }}</span>
                        <small>sku:{{ product.sku }} </small>
                        <p class="text-secondary">{{product.description}}</p>
                        <div class="ms-1">
                          <small v-if="product.status != 1" class="badge bg-danger">In Active</small>
                          <small v-else class="badge bg-success">Active</small>
                          <small v-if="product.is_published != 1" class="badge bg-danger">UnPublished</small>
                        </div>
                      </div>
                  </div>
                </td>

                <td>
                  <span v-if="product.menu">
                    Menu: <span class="badge bg-primary">{{ product.menu.name }}</span>
                  </span>
                  <span v-if="product.category">
                   Cat: <span class="badge bg-success">{{ product.category.name }}</span>
                  </span>
                </td>
                <td>{{ product.keywords }}</td>
                <td>
                  <p><span class="badge bg-info">Title:</span> {{ product.seo_title}}</p>
                  <p><span class="badge bg-info">Description:</span> {{ product.seo_description}}</p>
                </td>
                <td>{{product.cost_of_labour}}</td>
                <td>{{product.provider_cost}}</td>
                <td>
                  <span v-if="product.constant_commission" data-toggle="tooltip" data-placement="top" title="Global Commission">
                    <i class="bi bi-shield-fill-exclamation text-warning"></i>
                  </span>
                  {{product.commission}}
                </td>
                <td>{{product.platform_fee}}</td>
                <td>{{product.product_price}}</td>
                <td>
                  <div v-if="showActions" class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${product.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${product.id}`">
                      <a v-if="canUserAccess('services.update')" class="dropdown-item" :href="`/services/${product.id}`">view</a>
                      <a v-if="canUserAccess('services.update')" class="dropdown-item" :href="`/services/${product.id}/edit`">Edit</a>
                      <span v-if="canUserAccess('services.change_status')">
                        <a v-if="product.status !== 1" class="dropdown-item" href="#" @click="() => changeProductStatus(product)">Activate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changeProductStatus(product)">Deactivate</a>
                      </span>
                      <a v-if="canUserAccess('services.delete')" class="dropdown-item" href="#" @click="()=>deleteProduct(product)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Services" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>