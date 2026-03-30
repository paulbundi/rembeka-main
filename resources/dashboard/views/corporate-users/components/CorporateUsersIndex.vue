
<script>
import { mapActions, mapState } from 'vuex';
import pageChange from '../../../mixins/pageChange';
import updateProperty from '../../../mixins/updateProperty';
import catchValidationErrors from '../../../utils/catchValidationErrors';
  export default {
    name: 'CorporateUsersIndex',
      mixins: [
        pageChange,
        updateProperty
      ],
      computed: {
      ...mapState({
        corporate: state => state.Corporates.selected,
        users: state => state.CorporateUsers.items,
        selected: state => state.CorporateUsers.selected,
        user: state => state.authUser,
      }),
    },
    created() {
      this.setPaginate(true);
      this.fetItems();
    },

    methods: {
      ...mapActions('CorporateUsers', ['persist', 'fetchAll', 'setPaginate', 'setProperty', 'destroy',]),
      fetItems() {
        this.setProperty({ property: 'relations', value: ['user']});
        this.fetchAll();
      },
      addUserToCorporate() {
        if(this.selected.user_id == null) {
          this.$toast.error('Please select a user to add to a corporate');
        }
        this.updateProperty('corporate_id', this.corporate.id);

        this.persist().then(() => {
          this.$toast.success('User added to the corporate');
          this.fetchAll();
        }).catch(({response}) => {
          catchValidationErrors(this, response)
        })
      },
      removeUserFromCorporate(corporateUser) {
        this.$confirm().then(() => {
          this.destroy(corporateUser.id).then(() => {
            this.$toast.success('Success');
            this.fetchAll();
          })
        })
      },
    }
  };
</script>
<template>
      <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-6">
              <h4>Corporate Users</h4>
            </div>
            <div class="col-6 d-flex flex-row">
              <div class="flex-grow-1">
                <remote-selector module="Users" @change="(value)=>updateProperty('user_id', value)" :multiple="false" />
              </div>
                <button type="button" class="btn btn-sm btn-primary" @click="() => addUserToCorporate()">Link</button>
            </div>
          </div>
          <div class="table-responsive  single-item-table">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="corporateUser in users" :key="corporateUser.id">
                  <td>{{corporateUser.user.first_name}} {{corporateUser.user.last_name}}</td>
                  <td>{{corporateUser.user.phone}}</td>
                  <td>{{corporateUser.user.email}}</td>
                  <td>
                    <div class="dropdown show">
                      <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${corporateUser.id}`" data-bs-display="static" aria-expanded="false" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${corporateUser.id}`">
                        <li> <a v-if="canUserAccess('roles.view')" class="dropdown-item" :href="`/users/${corporateUser.id}`">View</a></li>
                        <li><a v-if="canUserAccess('roles.update')" class="dropdown-item" :href="`/users/${corporateUser.id}/edit`">Edit</a></li>
                        <li><a href="#" v-if="canUserAccess('users.remove-role')" class="dropdown-item" @click="() => removeUserFromCorporate(corporateUser)">Remove From Corporate</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination class="pull-left" module="Users" @page-change="pageChange"/>
          </div>
        </div>
      </div>
    </div>
</template>

<style lang="scss" scoped>

</style>