<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ProductsFilter from './BestSellerFilter.vue';
import BestSellerFilter from './BestSellerFilter.vue';

export default {
  name: 'BestSellerIndex',
  components: {
    ProductsFilter,
    BestSellerFilter,
},
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      items: state => state.BestSellers.items,
      loading: state => state.BestSellers.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('BestSellers',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      
      this.setProperty({
        property: 'relations',
        value: ['product', 'product.attachments.media'],
      });
      this.fetchAll();
    },
    handleAddProducts() {
      this.persist().then(({data}) => {
        this.$toast.success('Product added Successfully');
        this.fetchAll();
        this.$refs.hideModal.hideModal();
      }).catch(({response}) => {
        catchValidationErrors(this, response);
      });
    },
    deleteItem(product) {
      this.$confirm().then(() => {
        this.destroy(product.id).then(() => {
         			this.$toast.success('Item removed from best sellers');
        });
      })
    },

  }
  
};
</script>
<template>
  <div>
    <div class="card">
      <best-seller-filter @add-product="handleAddProducts" />
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>seo title</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="item in items">
              <tr v-if="item.product" :key="item.product.id">
                <td>{{item.product.id}}</td>
                <td>
                   <div class="d-flex align-items-center">
                    <div class="me-2">
                      <div v-if="item.product.attachments  && item.product.attachments.length > 0">
                        <img class="rounded-circle" :src="`${item.product.attachments[0].media.url}`" width="80" height="80" />
                      </div>
                    </div>
                    <div>
                      <div class="d-flex">
                        <span>{{ item.product.name }}</span>
                        <div class="ms-1">
                          <small v-if="item.product.status != 1" class="badge bg-danger">In Active</small>
                          <small v-else class="badge bg-success">Active</small>
                        </div>
                      </div>
                      <small>sku:{{ item.product.sku }} </small><br/>
                      <div>
                        <span v-if="item.product.type== 1" class="badge bg-success">Product</span>
                        <span v-else class="badge bg-info">Service</span>
                      </div>
                      
                    </div>
                  </div>
                </td>
                <td>{{item.product.description}}</td>
                <td>{{item.product.seo_title}}</td>
                <td>{{item.product.status}}</td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${item.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${item.id}`">
                      <a v-if="canUserAccess('products.delete')" class="dropdown-item" href="#" @click="()=>deleteItem(item)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
              </template>

            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="BestSellers" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>