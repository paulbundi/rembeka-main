<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import UserFilter from './filters/UserFilter.vue';

export default {
  name: 'UserIndex',
  components: {
    UserFilter,
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      users: state => state.Users.items,
      loading: state => state.Users.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Users',[
      'fetchAll', 'setProperty', 'persist', 'destroy',
      'setSelected', 'resetSelected', 'setPaginate',
      'resetPasswordLink',
    ]),

    fetchItems() {
      
      this.setProperty({property: 'relations', value: ['organization']});
      this.setProperty({ property: 'sorts', value: ['-id']});
      this.setProperty({property: 'relationCounts', value: ['wishlist']});
      this.setProperty({property: 'hideCorporateAccount', value: true});
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
    changeUserStatus(user) {
      let newUser = {...user, status: user.status !== 1 ? 1: null}
      this.setSelected(newUser);
      this.$confirm().then(() => {
        this.persist().then(() => {
         	this.$toast.success('Success');
          this.fetchItems();
        }).catch(({response}) => {
          catchValidationErrors(this, response);
        });
      })
    },
    handleRestPasswordRequest(user) {
      this.resetPasswordLink(user.id).then(() => {
        this.$toast.success('Reset link sent successfully');
      }).catch((error) => {
        this.$toast.error('An error occured');

      }).finally(() => {});
    },
    handleAccountTypeFilter(value) {
      this.setProperty({ property: 'filterByAccount',value: value});
      this.fetchAll();
    }
  }
};
</script>
<template>
  <div>
    <user-filter @account-type="handleAccountTypeFilter"/>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Wallet Amount</th>
                <th>Status</th>
                <th>Account Type</th>
                <th>Roles</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users" :key="user.id">
                <td>{{user.id}}</td>
               
                <td>
                  {{user.first_name}} {{ user.last_name }}
                  <span v-if="user.gender_id == 1" class="badge bg-primary">M</span>
                  <span v-if="user.gender_id == 2" class="badge bg-primary">F</span>
                  <br/>
                  {{user.email}} <br/>
                  <star-rating :rating="user.rating" :star-size=16 read-only :show-rating='false'/>
                  <span v-if="user.return_times" class="badge bg-success"> x {{user.return_times}}</span>
                  <span  v-if="user.return_times > 5"> <i class="bi bi-bookmark-heart-fill text-warning"></i></span>
                  <span v-if="user.wishlist_count" class="badge bg-primary"> <i class="bi bi-heart"></i> {{user.wishlist_count}}</span>
                </td>
                <td>
                  {{user.phone}}<br/>
                  <span v-if="user.sms_blocked" class="badge bg-warning">SMS Blocked</span>
                </td>
                <td>{{user.wallet}}</td>
                <td>
                  <span v-if="user.status == 1" class="badge bg-success">Active</span>
                  <span v-else class="badge bg-danger">InActive</span>
                </td>
                <td>
                  <span v-if="user.account_type == 1"> User</span>
                  <span v-if="user.account_type == 2"> Provider</span>
                  <span v-if="user.account_type == 3"> Admin</span>
                  <span v-if="user.account_type == 5"> Supplier</span>
                  <span v-if="user.account_type == 6"> Rider</span>
                </td>
               
                <td>
                  <label v-for="role in user.roles" :key="role.id" class="badge bg-success text-white me-1">
                    {{ role.title }}
                  </label>
                </td>
                 <td>{{ user.created_at | formatDate('LLL') }}</td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${user.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${user.id}`">
                      <a v-if="canUserAccess('users.update')" class="dropdown-item" :href="`/users/${user.id}`">view</a>
                      <a v-if="canUserAccess('users.update')" class="dropdown-item" :href="`/users/${user.id}/edit`">Edit</a>
                      <button v-if="canUserAccess('users.send-reset-password-link')" class="dropdown-item" @click="() => handleRestPasswordRequest(user)">Password Reset Link</button>
                      <span v-if="canUserAccess('users.change_status')">
                        <a v-if="user.status !== 1" class="dropdown-item" href="#" @click="() => changeUserStatus(user)">Activate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changeUserStatus(user)">Deactivate</a>
                      </span>
                      <a v-if="canUserAccess('users.impersonate')" class="dropdown-item" :href="`/users/${user.id}/impersonate`">Impersonate</a>
                      <a v-if="users.delete" class="dropdown-item" href="#" @click="()=>deleteUser(user)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Users" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>