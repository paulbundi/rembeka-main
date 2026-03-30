<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors';

export default {
  name: 'GroupsIndex',
  mixins: [pageChange,updateProperty],
  computed: {
    ...mapState({
      groups: state => state.Groups.items,
      loading: state => state.Groups.loadingItems,
      selected: state => state.Groups.selected,
      user: state => state.authUser,
    }),
  },
  data() {
    return  {
      modal: null,
    };
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Groups',['fetchAll', 'refreshMembers', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),
    fetchItems() {
      this.setProperty({
        property: 'relationCounts',
        value: ['users']
      });
      this.setProperty({
        property: 'relations',
        value: ['user']
      });
      this.fetchAll();
    },
    createGroupModal() {
      this.modal = new bootstrap.Modal(document.getElementById('groupCreate'));
      this.modal.show();
    },
    handleSaveGroup() {
      this.updateProperty('user_id', this.user.id);
      this.persist().then(() => {
        this.fetchItems();
        this.modal.hide();
        this.$toast.success('Group added Successfully');
      }).catch(({response}) => {
			catchValidationErrors(this, response);
		});
    },
    deleteGroup(group) {
      this.$confirm().then(() => {
        this.destroy(group.id).then(() => {
         	this.$toast.success('group deleted Successfully');
        });
      })
    },
    refreshGroup(group) {
      this.refreshMembers({id: group.id}).then(() => {
        this.$toast.success('Group Members refreshing shortly');
      });
    }
  }
};
</script>
<template>
  <div>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="col-12 d-flex justify-content-end">
          <button class="btn btn-sm btn-primary" @click="createGroupModal">Create Group</button>
        </div>
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Members</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="group in groups" :key="group.id">
                  <td>{{ group.name }}<br/>
                    <small>Author: {{ group.user.name }}</small><br/>
                    <small>{{ group.created_at | formatDate('LLL') }}</small>
                  </td>
                  <td>{{group.description}}</td>
                  <td>
                    <span v-if="group.type != 1">
                      {{group.users_count}}
                    </span>
                  </td>
                  <td>
                    <div v-if="group.type != 1" class="dropdown show">
                      <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${group.id}`" data-bs-display="static" aria-expanded="false" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${group.id}`">
                        <a v-if="canUserAccess('groups.update') && group.product_id != null" class="dropdown-item"  @click="()=>refreshGroup(group)">Refresh members</a>
                        <a v-if="canUserAccess('groups.update')" class="dropdown-item" :href="`/groups/${group.id}`">view</a>
                        <a v-if="canUserAccess('groups.update')" class="dropdown-item" :href="`/groups/${group.id}/edit`">Edit</a>
                        <a v-if="canUserAccess('groups.delete')" class="dropdown-item" href="#" @click="()=>deleteGroup(group)">Delete</a>
                      </div>
                    </div>
                    <span v-else class="badge bg-success"><small>Auto</small></span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <pagination class="pull-left" module="Groups" @page-change="pageChange"/>
      </div>
      
    </div>

              <!-- Modal -->
<div class="modal fade" id="groupCreate" tabindex="-1" aria-labelledby="groupCreateLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="groupCreateLabel">Groups</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="checkbox" :checked="selected.from_sales == 1" name="from_sales" @input="(e)=>updateProperty('from_sales', e.target.checked)">
          <label>Create Group from sales</label>
        </div>

        <div class="form-group" v-if="selected.from_sales == 1">
          <div class="form-group">
            <label>Associated Product</label>
            <remote-selector 
              module="Merchandise"
              :multiple='false'
              @change="(e)=>updateProperty('product_id', e)"
              label="name"
            />
          </div>
        </div>

        <div class="form-group">
          <label>Group Name</label>
          <input type="text" class="form-control" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)"/>
        </div>

        <div class="form-group">
          <label>Description</label>
          <textarea class="form-control" :value="selected.description" @input="(e) => updateProperty('description', e.target.value)"></textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" @click="handleSaveGroup">Save changes</button>
      </div>
    </div>
  </div>
</div>
  </div>
</template>

<style>

</style>