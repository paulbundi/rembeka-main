<script>
import { mapActions, mapState } from 'vuex';
import catchValidationErrors from '../../../utils/catchValidationErrors';
export default {
  name: 'GroupsShow',
  props: {
    id: {
      type: Number,
      required: true,
    }
  },
  data() {
    return{
      selectedUser: null,
    };
  },
  computed: {
    ...mapState({
      selected: state => state.Groups.selected,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('Groups', ['fetchOne', 'setProperty', 'attachRelations','detachRelations']),
    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['users']
      });
      this.fetchOne({ id: this.id });
    },
    handleAddMember(selected) {
      this.selectedUser = selected;
    },
    addMember() {
      let payload = {
        id: this.id,
        relation: 'users',
        data: [this.selectedUser],
      };
      this.attachRelations(payload).then(({response}) => {
        this.$toast.success('success');
				this.fetchItems();
			}).catch(({response}) => {
        catchValidationErrors(this, response);
      })
    },
    removeMember(user) {
      console.log('we hwrw')
      let payload = {
        id: this.id,
        relation: 'users',
        data: [user.id],
      };
      this.$confirm().then(() => {
        this.detachRelations(payload).then(({response}) => {
          this.$toast.success('success');
          this.fetchItems();
        }).catch(({response}) => {
          catchValidationErrors(this, response);
        });
      });
    }
  }
};
</script>
<template>
<div class="row">
  <div class="col-8">
    <div class="col-12">
      <div class="card card-body table-responsive single-item-table">
        <div class="col-12">
          <b>Group Details</b>
          <a v-if="canUserAccess('users.edit')" class="btn btn-sm btn-primary float-end" :href="`/schools/${this.id}/edit`">Edit</a>
        </div>
        <table class="table table-striped">
            <tr>
              <td>Name</td>
              <td> {{selected.name }}</td>
            </tr>
            <tr>
              <td>Description</td>
              <td>{{selected.description }}</td>
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
                  <th>Email</th>
                  <th>Phone Number</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in selected.users" :key="user.id">
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.phone}}</td>
                  <td>
                    <div class="dropdown show">
                      <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${user.id}`" data-bs-display="static" aria-expanded="false" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${user.id}`">
                        <li> <button v-if="canUserAccess('users.view')" class="dropdown-item" @click="() =>removeMember(user)">Remove</button></li>
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
      <label>Add Member</label>
      <remote-selector 
        module="Users"
        :multiple='false'
        @change="handleAddMember"
        label="name"
      />
      <div class="form-group float-end">
        <button class="btn btn-sm btn-success" @click="addMember">Add Member</button>
      </div>
    </div>
  </div>
</div>
</template>
<style>

</style>