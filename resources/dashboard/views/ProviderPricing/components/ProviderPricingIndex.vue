<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ProviderPricingFilter from './ProviderPricingFilter.vue';

export default {
  name: 'ProviderPricingIndex',
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
    }
  },
  components: {
    ProviderPricingFilter,
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
      items: state => state.ProviderPricings.items,
      loading: state => state.ProviderPricings.loadingItems,
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
    ...mapActions('ProviderPricings',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['product.discount', 'category', 'provider'],
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
      <provider-pricing-filter :config="config"/>
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Product</th>
                <th>Provider</th>
                <th>Category</th>
                <th>Labour Cost</th>
                <th>Commission(%)</th>
                <th>Provider Cost</th>
                <th>Service Pricing</th>
                <th>PlatForm Pricing</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="item in items">
              <tr v-if="item.product" :key="item.id">
                <td>
                  <span v-if="item.service_pricing > 100 && item.status == 1">
                    <input type="checkbox" 
                      :checked="selectedIds == item.id" 
                      :value="item.id"
                      @change="()=> handleCheckBox(item)" 
                    />
                  </span>
                  <span v-else>
                    <span v-if="item.status != 1" class="badge bg-danger">Disabled</span>
                    <span v-else class="badge bg-danger">Fix Pricing</span>
                  </span>
                </td>
                <td>
                  {{item.product.name}}<br/>
                  <small>sku: {{ item.product.sku }} </small> <br/>

                  <template v-if="item.product.discount">
                    <span class="badge bg-success">{{ parseInt(item.product.discount.discount_amount) }}%</span>
                  </template>   
                </td>
                <td>
                  <span v-if="item.provider">
                    {{ item.provider.first_name }}
                    {{ item.provider.last_name }}
                  </span>
                </td>
                <td>
                  <span v-if="item.category">
                    {{item.category.name}}
                  </span>
                </td>
                <td>{{item.cost_of_labour}}</td>
                <td>
                  <span v-if="item.product.constant_commission">
                    <span  data-toggle="tooltip" data-placement="top" title="Global Commission">
                      <i class="bi bi-shield-fill-exclamation text-warning"></i>
                    </span>
                   {{ item.product.commission }}
                  </span>
                  <span v-else>
                    {{ item.commission }}
                  </span>
                </td>
                <td>{{item.provider_cost}}</td>
                <td>
                  {{item.service_pricing}}
                </td>
                <td>
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
                      <a v-if="canUserAccess('provider-pricing.update')" class="dropdown-item" :href="`/service-pricings/${item.id}/edit`">Edit</a>
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
        <pagination class="pull-left" module="ProviderPricings" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>