
<script>
import { mapActions, mapState } from 'vuex';
import pageChange from '../../../mixins/pageChange';
import updateProperty from '../../../mixins/updateProperty';
import catchValidationErrors from '../../../utils/catchValidationErrors';
  export default {
    name: 'CorporateMembersIndex',
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
      this.fetchItems();
    },

    methods: {
      ...mapActions('CorporateUsers', ['persist', 'fetchAll', 'setPaginate', 'setProperty', 'destroy',]),
      fetchItems() {
        this.setProperty({ property: 'corporateId', value: this.user.id});
        this.setProperty({ property: 'relations', value: ['user']});
        this.setProperty({ property: 'sorts', value: ['-created_at']});
        this.fetchAll();
      },
      addUserToCorporate() {
        this.updateProperty('corporate_id', this.corporate.id);
        this.persist().then(() => {
          this.$toast.success('User added to the corporate');
          this.fetchAll();
        }).catch(({response}) => {
          catchValidationErrors(this, response)
        })
      },
      removeUserFromCorporate(corporateUser) {
        this.$confirm({
           title: 'Remove beneficiary!',
          message: 'I want to remove this member from my corporate beneficiary list'
        }).then(() => {
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
            <div class="col-12">
              <a class="btn btn-sm btn-primary float-end" href="/corporate-members/create">
                <i class="bi bi-plus-circle"></i>
                Add Members
              </a>
              <h4>Members</h4>
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
                        <li><a href="#" class="dropdown-item" @click="() => removeUserFromCorporate(corporateUser)">Remove Member</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination class="pull-left" module="CorporateUsers" @page-change="pageChange"/>
          </div>
        </div>
      </div>
    </div>
</template>

<style lang="scss" scoped>

</style>