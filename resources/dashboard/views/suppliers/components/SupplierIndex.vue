<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import SupplierFilter from './SupplierFilter.vue';

export default {
  name: 'ProviderIndex',
  components: {
    SupplierFilter,
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      suppliers: state => state.Suppliers.items,
      loading: state => state.Suppliers.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Suppliers',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      // this.setProperty({
      //   property: 'relations',
      //   value: ['profile.attachments.media'],
      // });
      this.setProperty({ property: 'sorts', value: ['-id']});
      this.setProperty({ property: 'relations', value: ['user']});
      this.fetchAll();
    },
    deleteprovider(user) {
      this.$confirm().then(() => {
        this.destroy(user.id).then(() => {
         			this.$toast.success('Supplier deleted successfully');
        });
      })
    },
    changeproviderStatus(user) {
      let newUser = {...user, status: user.status !== 1 ? 1: null}
      if(newUser.status == null) {
        newUser = {...newUser, published: 0 }
      }
      this.setSelected(newUser);
      this.$confirm().then(() => {
        this.persist().then(() => {
          this.fetchItems();
         	this.$toast.success('Success');
        }).catch(({response}) => {
          catchValidationErrors(this, response);
        });
      });
    },
    handleProviderPublication(user) {
    let newUser = {...user, published: user.published !== 1 ? 1: 0}
      this.setSelected(newUser);
      this.$confirm().then(() => {
        this.persist().then(() => {
          this.fetchItems();
         	this.$toast.success('Success');
        }).catch(({response}) => {
          catchValidationErrors(this, response);
        });
      });
    }
  }
};
</script>
<template>
  <div>
    <supplier-filter />
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Wallet</th>
                <th>Rating</th>
                <th>Type</th>
                <th>Short Description</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="supplier in suppliers" :key="supplier.id">
                <td>{{supplier.id}}</td>
                <td>
                  <b>{{supplier.displayName}}</b><br/>
                  <small>{{supplier.phone}}</small><br/>
                  <small>{{supplier.email}}</small><br/>
                  <div v-if="!supplier.user_id">
                    <span class="badge bg-danger">No Wallet !</span>
                  </div>
                </td>
                <td>
                    <b v-if="supplier.user">{{ supplier.user.wallet |numberFormat }}</b>
                    <b v-else>-</b>
                </td>
                <td>
                  <star-rating :rating="supplier.rating" :star-size=20 read-only :show-rating='false'/>
                </td>
                <td>
                  <span v-if="supplier.type == 1" class="badge bg-success">Individual</span>
                  <span v-else class="badge bg-warning">Company</span>
                </td>
                <td>{{supplier.description}}</td>
                <td>
                  <span v-if="supplier.status == 1" class="badge bg-success">Active</span>
                  <span v-else class="badge bg-danger">InActive</span>
                </td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${supplier.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${supplier.id}`">
                      <a v-if="canUserAccess('suppliers.update')" class="dropdown-item" :href="`/suppliers/${supplier.id}`">view</a>
                      <a v-if="canUserAccess('suppliers.update')" class="dropdown-item" :href="`/suppliers/${supplier.id}/edit`">Edit</a>
                      <a v-if="canUserAccess('suppliers.income') && supplier.user_id " class="dropdown-item" :href="`/supplier-income/${supplier.id}`">Earnings</a>
                       <span v-if="canUserAccess('suppliers.change_status')">
                        <a v-if="supplier.status !== 1" class="dropdown-item" href="#" @click="() => changeproviderStatus(supplier)">Activate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changeproviderStatus(supplier)">Deactivate</a>
                      </span>
                      <a v-if="canUserAccess('suppliers.delete')" class="dropdown-item" href="#" @click="()=>deleteprovider(supplier)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Suppliers" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>