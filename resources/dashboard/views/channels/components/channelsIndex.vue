<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import updateProperty from '../../../mixins/updateProperty';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import { VueNestable, VueNestableHandle } from 'vue-nestable';
import ChannelsCreate from './channelsCreate.vue';

export default {
  name: 'ChannelsIndex',
  components: {
    VueNestable,
    VueNestableHandle,
    ChannelsCreate,
  },
  mixins:[
    pageChange,
    updateProperty,
  ],
  
  computed: {
    ...mapState({
      channels: state => state.Channels.items,
      selected: state => state.Channels.selected,
      loading: state => state.Channels.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Channels',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),
    fetchItems() {
      this.fetchAll();
    },
    handleEdit(item) {
      this.setSelected(item);
    },
    handleDelete(item) {
      this.$confirm().then(() => {
        this.destroy(item.id).then(() => {
         	this.$toast.success('Channel deleted Successfully');
        });
      })
    },
    changeProductItemStatus(item) {
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
    },
    deleteChannel(user) {
      this.$confirm().then(() => {
        this.destroy(user.id).then(() => {
         			this.$toast.success('User deleted Successfully');
        });
      })
    },
  }
};
</script>
<template>
  <div>
    <h4>Channels</h4>
    <div class="row">
      <div class="col-6 card">
        <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Channel</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in channels" :key="item.id">
                <td>{{ item.id }}</td>
                <td>
                  {{ item.name }}
                </td>
                <td>
                  <span v-if="item.status == 1" class="badge bg-success"> Active</span>
                  <span v-else class="badge bg-danger">Inactive</span>
                </td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${item.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${item.id}`">
                      <a v-if="canUserAccess('channels.update')" class="dropdown-item" @click="() => handleEdit(item)">Edit</a>
                      <span v-if="canUserAccess('channels.update')">
                        <a v-if="item.status !== 1" class="dropdown-item" href="#" @click="() => changeProductItemStatus(item)">Activate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changeProductItemStatus(item)">Deactivate</a>
                      </span>
                      <a v-if="canUserAccess('channels.delete')" class="dropdown-item" href="#" @click="()=>deleteChannel(item)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        </div>
      </div>
      <div class="col-4 offset-sm-1 card">
          <channels-create />
      </div>
    </div>
   
  </div>
</template>

<style lang="scss">
.nestable-item {
  border: 1px dotted #000;
  margin: 3px;
  padding: 5px;
}
</style>