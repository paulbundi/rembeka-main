<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import DriverFilter from './DriverFilter.vue';

export default {
  name: 'DriverIndex',
  components: {
    DriverFilter,
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      drivers: state => state.Drivers.items,
      loading: state => state.Drivers.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Drivers',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

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
    <driver-filter />
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Particulars</th>
                <th>Wallet</th>
                <th>Rating</th>
                <th>Driving No</th>
                <th>Short Description</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="driver in drivers" :key="driver.id">
                <td>{{driver.id}}</td>
                <td>
                  <b>{{driver.displayName}}</b><br/>
                  <small>{{driver.phone}}</small><br/>
                  <small>{{driver.email}}</small><br/>
                  <div v-if="!driver.user_id">
                    <span class="badge bg-danger">No Wallet !</span>
                  </div>
                </td>
                <td>
                    <b v-if="driver.user">{{ driver.user.wallet |numberFormat }}</b>
                    <b v-else>-</b>
                </td>
                <td>
                  <star-rating :rating="driver.rating" :star-size=20 read-only :show-rating='false'/>
                </td>
                <td>
                  {{ driver.dl_no }} <br/>
                  <small>{{ driver.dl_expiry_date }}</small>
                </td>
                <td>{{driver.description}}</td>
                <td>
                  <span v-if="driver.status == 1" class="badge bg-success">Active</span>
                  <span v-else class="badge bg-danger">InActive</span>
                </td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${driver.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${driver.id}`">
                      <a v-if="canUserAccess('drivers.update')" class="dropdown-item" :href="`/drivers/${driver.id}`">view</a>
                      <a v-if="canUserAccess('drivers.update')" class="dropdown-item" :href="`/drivers/${driver.id}/edit`">Edit</a>
                      <a v-if="canUserAccess('drivers.income') && driver.user_id " class="dropdown-item" :href="`/driver-income/${driver.id}`">Earnings</a>
                       <span v-if="canUserAccess('drivers.change_status')">
                        <a v-if="driver.status !== 1" class="dropdown-item" href="#" @click="() => changeproviderStatus(driver)">Activate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changeproviderStatus(driver)">Deactivate</a>
                      </span>
                      <a v-if="canUserAccess('drivers.delete')" class="dropdown-item" href="#" @click="()=>deleteprovider(driver)">Delete</a>
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