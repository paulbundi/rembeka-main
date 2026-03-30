<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import CouponFilter from './CouponFilter.vue';

export default {
  name: 'CouponIndex',
  components: {
    CouponFilter,
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      coupons: state => state.Coupons.items,
      loading: state => state.Coupons.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Coupons',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      
      this.setProperty({
        property: 'relations',
        value: ['organization'],
      });
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
    }
  }
};
</script>
<template>
  <div>
    <coupon-filter @filterSchool="handleSchoolFilter"/>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="coupon in coupons" :key="coupon.id">
                <td>{{coupon.id}}</td>
               
                <td>{{coupon.name}}</td>
                <td>{{coupon.email}}</td>
                <td>{{coupon.phone}}</td>
                <td>
                  <span v-if="user.status == 1" class="badge bg-success">Active</span>
                  <span v-else class="badge bg-danger">InActive</span>
                </td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${user.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${user.id}`">
                      <a v-if="canUserAccess('users.update')" class="dropdown-item" :href="`/users/${user.id}`">view</a>
                      <a v-if="canUserAccess('users.update')" class="dropdown-item" :href="`/users/${user.id}/edit`">Edit</a>
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