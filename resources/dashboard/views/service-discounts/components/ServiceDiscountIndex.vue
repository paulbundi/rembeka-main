<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import DiscountedFilter from './DiscountedFilter.vue';

export default {
  name: 'ServiceDiscountIndex',
  components: {
    DiscountedFilter
},
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      items: state => state.ServiceDiscounts.items,
      loading: state => state.ServiceDiscounts.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('ServiceDiscounts',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      
      this.setProperty({
        property: 'relations',
        value: ['product', 'product.menu', 'product.attachments.media'],
      });
      this.fetchAll();
    },
    deleteProduct(product) {
      this.$confirm().then(() => {
        this.destroy(product.id).then(() => {
         			this.$toast.success('Product deleted Successfully');
        });
      })
    },
  }
};
</script>
<template>
  <div>
    <div class="card">
      <discounted-filter />
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
             <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Menu</th>
                <th>Cost of labour</th>
                <th>Provider Cost</th>
                <th>Commission(%)</th>
                <th>Listing Price</th>
                <th>Actions</th>

              </tr>
            </thead>
            <tbody>
              <tr v-for="discount in items" :key="discount.id">
                <td>
                  <div class="d-flex align-items-center">
                    <div class="me-2">
                      <div v-if="discount.product.attachments  && discount.product.attachments.length > 0">
                        <img class="rounded-circle" :src="`${discount.product.attachments[0].media.url}`" width="80" height="80" />
                      </div>
                    </div>
                    <div>
                        {{ discount.product.name }}<br/>
                        <small>sku:{{ discount.product.sku }} </small>
                      </div>
                  </div>
                </td>

                <td>
                  <span v-if="discount.product.menu">
                    {{ discount.product.menu.name }}
                  </span>
                </td>
                <td>{{ discount.product.cost_of_labour}}</td>
                <td>{{ discount.product.provider_cost}}</td>
                <td>
                  <span class="">Original Commision <span class="badge bg-info">{{ discount.product.commission}}</span></span><br/>
                 <span class="text-primary">Discount %:<span class="badge bg-success">{{ discount.discount_amount }}</span></span>
                </td>
                <td>
                  {{ discount.product.product_price}}<br/>
                  <span class="text-primary">Discounted Price:  <span class="badge bg-success">{{ discount.payable}}</span></span>
                </td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${discount.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${discount.id}`">
                      <a v-if="canUserAccess('products.update')" class="dropdown-item" :href="`/service-discounts/${discount.id}/edit`">Edit</a>
                      <a v-if="canUserAccess('products.delete')" class="dropdown-item" href="#" @click="()=>deleteProduct(discount)">Delete</a>
                    </div>
                  </div>

                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="ServiceDiscounts" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>