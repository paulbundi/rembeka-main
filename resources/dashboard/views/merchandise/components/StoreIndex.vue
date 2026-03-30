<script>
import {mapState, mapActions} from 'vuex';
import StoreCreate from './StoreCreate.vue';

export default {
  components: { StoreCreate },
  name: 'StoreIndex',
  computed: {
    ...mapState({
      stores: state => state.Franchises.items,
      loading: state => state.Franchises.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('Franchises',['fetchAll', 'setPaginate', 'destroy', 'setProperty']),
    fetchItems() {
      this.setProperty({ property: 'relations', value:['manager']})
      this.fetchAll();
    },
    handleDelete(store) {
      this.$confirm()
      .then(() => {
          this.destroy(store.id).then(() => {
            this.$toast.success('Store successfully');
          });
      })
    },
    handleCreated() {
    }
  }
};
</script>
<template>
  <div>
    <div v-if="canUserAccess('stores.create')" class="card">
      <div class="card-body">
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
          Add A Franchise
        </button>
      </div>
    </div>
    
    <div class="card">
      <div class="card-body">
        <div v-loading="loading" class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Rembeka Commissions</th>
                <th>Manager</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="store in stores" :key="store.id">
                <td>{{store.name}}</td>
                <td>{{store.location}}</td>
                <td>{{store.commission}}</td>
                <td>
                  <span v-if="store.manager">
                    {{ store.manager.name }}
                  </span>
                </td>
                <td>
                  <a class="btn btn-sm btn-primary" :href="`/stores/${store.id}`">view</a>
                  <a v-if="canUserAccess('stores.update')"  class="btn btn-sm btn-info" :href="`/stores/${store.id}/edit`">Edit</a>
                  <button v-if="canUserAccess('stores.delete')"  class="btn btn-sm btn-danger" @click="() => handleDelete(store)">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Franchise</h5>
        <button type="button" id="hackButton" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <store-create @created="handleCreated"/>
      </div>
    </div>
  </div>
</div>
  </div>
</template>

<style>

</style>