<script>
import { mapActions, mapState } from 'vuex';
import pageChange from '../../../../mixins/pageChange';
import Pagination from '../../../generals/Pagination.vue';
export default {
  name: 'ProviderProduct',
  props: {
    providerId: {
      type: Number,
      required: true,
    },
    providerLocation: {
      type: Number,
      default: null,
    },
  },
  
  components: { Pagination },
  mixins: [pageChange],

  computed: {
    ...mapState({
      items: state => state.ProviderPricings.items,
      selected: state => state.ProviderPricings.selected,
      loadingItems: state => state.ProviderPricings.loadingItems,
    }),
  },
  watch: {
    providerLocation(){
      this.fetchProviderLocationProducts();
    }
  },
  created() {
    this.fetchProviderLocationProducts();
  },
  methods: {
    ...mapActions('ProviderPricings', ['fetchOne','fetchAll', 'setProperty', 'persist','setSelected']),
    fetchProviderLocationProducts() {
      this.setProperty({
        propery: 'providerId',
        value: this.providerId,
      }),
      this.setProperty({
        property: 'relations',
        value:['product', 'location','category']
      })
      this.setProperty({
        propery: 'locationId',
        value: this.providerId,
      });
      this.fetchAll();
    },
    changeproviderStatus(product) {
      let newProduct = {...product, status: product.status !== 1 ? 1: 0}
      this.setSelected(newProduct);
      this.$confirm().then(() => {
        this.persist().then(() => {
         	this.$toast.success('Success');
          this.fetchItems();
        }).catch(({response}) => {
          catchValidationErrors(this, response);
        });
      })
    }
  }
};
</script>

<template>
  <div>
    <div class="card">
      <div v-loading="loadingItems" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Product</th>
                <th>category</th>
                <th>amount</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id">
                <td>{{item.id}}</td>
              
                <td>
                  <span v-if="item.product">
                    {{item.product.name}}
                  </span>
                </td>
                <td>
                   <span v-if="item.product">
                    {{item.category.name}}
                  </span>
                </td>
                <td>{{item.amount}}</td>
                <td>
                  <span v-if="item.status == 1" class="badge bg-success">Active</span>
                  <span v-else class="badge bg-danger">InActive</span>
                </td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${item.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${item.id}`">
                      <a v-if="canUserAccess('providers.update')" class="dropdown-item" :href="`/providers/${item.id}`">view</a>
                      <a v-if="canUserAccess('providers.update')" class="dropdown-item" :href="`/providers/${item.id}/edit`">Edit</a>
                      <span v-if="canUserAccess('providers.update')">
                        <a v-if="item.status !== 1" class="dropdown-item" href="#" @click="() => changeproviderStatus(item)">Activate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changeproviderStatus(item)">Deactivate</a>
                      </span>
                      <a v-if="canUserAccess('providers.delete')" class="dropdown-item" href="#" @click="()=>deleteprovider(item)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="ProviderPricings" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>

</style>