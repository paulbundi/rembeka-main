<script>
import { mapActions, mapState } from 'vuex';
import catchValidationErrors from '../../../utils/catchValidationErrors';
export default {
  name: 'ProductsShow',
  props: {
    id: {
      type: Number,
      required: true,
    }
  },
  data() {
    return{
      selectedRole: null,
    };
  },
  computed: {
    ...mapState({
      selected: state => state.Services.selected,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('Services', ['fetchOne', 'setProperty', 'attachRelations','removeItemRelations']),
    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['user','attachmnets.media']
      });
      this.fetchOne({ id: this.id });
    },
  }
};
</script>
<template>
<div class="row">
  <div class="col-8">
    <div class="col-12">
      <div class="card card-body table-responsive single-item-table">
        <div class="col-12">
          <b>User Details</b>
          <a v-if="canUserAccess('users.edit')" class="btn btn-sm btn-primary float-end" :href="`/schools/${this.id}/edit`">Edit</a>
        </div>
        <table class="table table-striped">
            <tr>
              <td>Name</td>
              <td> {{selected.name }}</td>
            </tr>
              <tr>
              <td>Email</td>
              <td>{{selected.email }}</td>
            </tr>
              <tr>
              <td>Phone</td>
              <td>{{selected.phone }}</td>
            </tr>
              <tr>
              <td>Status</td>
              <td>
                <span v-if="selected.status == 1" class="badge bg-success">Active</span>
                <span v-else class="badge bg-danger">InActive</span>
              </td>
            </tr>
        </table>
      </div>
    </div>
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive  single-item-table">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Descriptions</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="role in selected.roles" :key="role.id">
                  <td>{{role.title}}</td>
                  <td>{{role.description}}</td>
                  <td>
                    <div class="dropdown show">
                      <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${role.id}`" data-bs-display="static" aria-expanded="false" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${role.id}`">
                        <li> <a v-if="canUserAccess('roles.view')" class="dropdown-item" :href="`/roles/${role.id}`">View</a></li>
                        <li><a v-if="canUserAccess('roles.update')" class="dropdown-item" :href="`/roles/${role.id}/edit`">Edit Role</a></li>
                        <li><a href="#" v-if="canUserAccess('users.remove-role')" class="dropdown-item" @click="() => handleDetachRole(role)">Remove</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div v-if="canUserAccess('users.remove-role')" class="col-4 card">
    <div class="card-body">
      <label>Add Role</label>
      <remote-selector 
        module="Roles"
        :multiple='false'
        @change="handleAddRole"
        label="title"
      />
      <div class="form-group float-end">
        <button class="btn btn-sm btn-success" @click="addRole">Add Role</button>
      </div>
    </div>
  </div>
</div>
</template>
<style>

</style>