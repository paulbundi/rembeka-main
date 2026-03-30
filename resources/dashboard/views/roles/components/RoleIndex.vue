<script>
import {mapState, mapActions} from 'vuex';
import InputFilter from '../../generals/InputFilter.vue';

export default {
  components: { InputFilter },
  name: 'RoleIndex',
  computed: {
    ...mapState({
      roles: state => state.Roles.items,
      loading: state => state.Roles.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('Roles',['fetchAll', 'setPaginate', 'setProperty','destroy']),
    fetchItems() {
      if(!this.user.organization_id) {
        this.setProperty({
          property: 'relations',
          value: ['organization'],
        });
      }else{
        this.setProperty({
          property: 'filterSchoolRoles',
          value: ['school'],
        });
      }
      this.setProperty({
        property: 'relationCounts',
        value: ['users']
      });
      this.fetchAll();
    },
    handleDelete(role) {
      this.$confirm()
      .then(() => {
          this.destroy(role.id).then(() => {
            this.$toast.success('Role Deleted successfully');
          });
        });
    }
  }
};
</script>
<template>
  <div>
    <div v-if="canUserAccess('roles.create')" class="card">
      <div class="card-body">
        <a class="btn btn-primary float-end" href="/roles/create">Create Role</a>
      </div>
    </div>
    
    <div class="card">
      <div class="card-body">
        <div v-loading="loading" class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Descriptions</th>
                <th>Users</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="role in roles" :key="role.id">
                <td>{{role.title}}</td>
                <td>{{role.description}}</td>
                <td>{{role.users_count}}</td>
                <td>
                  <a class="btn btn-sm btn-primary" :href="`/roles/${role.id}`">view</a>
                  <a v-if="canUserAccess('roles.update')"  class="btn btn-sm btn-info" :href="`/roles/${role.id}/edit`">Edit</a>
                  <button v-if="canUserAccess('roles.delete')"  class="btn btn-sm btn-danger" @click="() => handleDelete(role)">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<style>

</style>