<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import SupplierPricingFilter from './SupplierPricingFilter.vue';

export default {
  name: 'SupplierPricingIndex',
  props: {
    isSelectable:{
      type: Boolean,
      default: false,
    },
    addPricing: {
      type: Boolean,
      default: true,
    },
    productId: {
      type: Number,
      default: null,
    },
    checkOutOfStock: {
      type: Boolean,
      default: false,
    }
  },
  components: {
    SupplierPricingFilter,
  },
  data() {
    return {
      selectedIds: null,
      config: {
        addPricing: this.addPricing,
      },
    };
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      items: state => state.SupplierPricings.items,
      loading: state => state.SupplierPricings.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
  this.setPaginate(true);
    if(this.productId) {
      this.setProperty({
        property: 'productId',
        value: this.productId,
      });
    }
  this.fetchItems();
  },
  methods: {
    ...mapActions('SupplierPricings',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['product.discount', 'category', 'supplier', 'unit'],
      });
      this.setProperty({property: 'sorts', value:['-id']});
      this.fetchAll();
    },
    handleSchoolFilter(value) {
      this.fetchAll();
    },
    deleteUser(user) {
      this.$confirm().then(() => {
        this.destroy(user.id).then(() => {
         			this.$toast.success('User deleted Successfully');
        });
      })
    },

    changeProductItemStatus(item) {
      let newItem = {...item, status: item.status !== 1 ? 1: null}
      this.setSelected(newItem);
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
      <supplier-pricing-filter :config="config"/>
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Product</th>
                <th>Supplier</th>
                <th>Details</th>
                <th>Supp.Amount</th>
                <th>Mark Up(%)</th>
                <th>Amounts</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="item in items">
              <tr v-if="item.product" :key="item.id">
                <td>
                  <span v-if="checkOutOfStock && (!item.instock || item.in_stock < 1)">
                    <span class="badge bg-warning">Out of stock</span>
                  </span>

                  <span v-else-if="parseFloat(item.amount) > parseFloat(item.supplier_price) && item.status == 1">
                    <input type="checkbox" :checked="selectedIds == item.id" :value="item.id" @change="()=> handleCheckBox(item)"/>
                  </span>

                  <span v-else>
                    <span v-if="item.status != 1" class="badge bg-danger">Disabled</span>
                    <span v-else class="badge bg-danger">Fix Pricing</span>
                  </span>

                   <span v-if="item.category">
                    <br/> Category: {{item.category.name}}
                  </span>
                </td>
                <td>
                  {{ item.product.name }}<br/>
                  <small>sku: {{ item.product.sku }} </small> <br/>

                  <template v-if="item.product.discount">
                    <span class="badge bg-success">{{ parseInt(item.product.discount.discount_amount) }}%</span>
                  </template>   
                </td>
                <td>
                  <span v-if="item.supplier">
                    {{ item.supplier.displayName }}
                  </span>
                </td>
                <td>
                  Unit: {{item.unit.name}} <br/>
                  Size: {{item.size}} <br/>
                  Available Stock: {{item.instock}} <br/>
                  ReOrder level: {{item.re_order_level}} <br/>
                  Others: {{item.config}} <br/>
                </td>
                <td>{{ item.supplier_price }}</td>
                <td>{{item.mark_up_percentage}}</td>
                <td>
                  {{item.listing_amount}} <br/>
                  {{item.amount}} <br/>

                  <template v-if="item.product.discount">
                    <span class="badge bg-success">{{ item.product.discount.payable }}</span>
                  </template>   
                </td>
                <td>
                  <span v-if="item.status == 1" class="badge bg-success"> Active</span>
                  <span v-else class="badge bg-danger"> Inactive</span>
                </td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${item.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${item.id}`">
                      <a v-if="canUserAccess('provider-pricing.update')" class="dropdown-item" :href="`/product-pricings/${item.id}/edit`">Edit</a>
                      <span v-if="canUserAccess('provider-pricing.change_status')">
                        <a v-if="item.status !== 1" class="dropdown-item" href="#" @click="() => changeProductItemStatus(item)">Activate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changeProductItemStatus(item)">Deactivate</a>
                      </span>
                      <a v-if="canUserAccess('provider-pricing.delete')" class="dropdown-item" href="#" @click="()=>deleteUser(item)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
              </template>
            </tbody>  
          </table>
        </div>
        <pagination class="pull-left" module="SupplierPricings" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>