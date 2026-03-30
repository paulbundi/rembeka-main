<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';

export default {
  name: 'AgeGroupIndex',
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      items: state => state.AgeGroups.items,
      loading: state => state.AgeGroups.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('AgeGroups',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      
      this.fetchAll();
    },
    deleteGroup(item) {
      this.$confirm().then(() => {
        this.destroy(item.id).then(() => {
         			this.$toast.success('Group deleted Successfully');
        });
      })
    },
    changeGroupStatus(item) {
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
    }
  }
};
</script>
<template>
  <div>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="card-title">
          <a class="btn btn-sm btn-primary" href="/age-groups/create"> Add Group</a>
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Show On Menu</th>
                <th>Menu name</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id">
                <td>{{item.id}}</td>
               
                <td>{{ item.name }}</td>
                <td>{{ item.description }}</td>
                <td>
                  <span v-if="item.status == 1" class="badge bg-success">Active</span>
                  <span v-else class="badge bg-danger">InActive</span>
                </td>
                <td>
                  <span v-if="item.show_on_menu == 1" class="badge bg-success">Shows On Menu</span>
                </td>
                <td>{{ item.menu_name }}</td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${item.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${item.id}`">
                      <a v-if="canUserAccess('users.update')" class="dropdown-item" :href="`/age-groups/${item.id}`">view</a>
                      <a v-if="canUserAccess('users.update')" class="dropdown-item" :href="`/age-groups/${item.id}/edit`">Edit</a>
                      <span v-if="canUserAccess('users.change_status')">
                        <a v-if="item.status !== 1" class="dropdown-item" href="#" @click="() => changeGroupStatus(item)">Activate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changeGroupStatus(item)">Deactivate</a>
                      </span>
                      <a v-if="canUserAccess('age-groups.delete')" class="dropdown-item" href="#" @click="()=>deleteGroup(item)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="AgeGroups" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>