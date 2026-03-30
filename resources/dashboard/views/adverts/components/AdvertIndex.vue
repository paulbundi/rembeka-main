<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import AdCreate from './AdCreate.vue';

export default {
  components: { AdCreate },
  name: 'BrandIndex',
  mixins: [
    pageChange,
  ],
  data() {
    return {
      editId: null,
    };
  },
  computed: {
    ...mapState({
      items: state => state.Adverts.items,
      loading: state => state.Adverts.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Adverts',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),
    fetchItems() {
      this.setProperty({ property: 'relations', value: ['attachments.media', 'product']}),
      this.fetchAll();
    },
    deleteAd(item) {
      this.$confirm().then(() => {
        this.destroy(item.id).then(() => {
         	this.$toast.success('Deleted Successfully');
        });
      })
    },
    handleEdit(item){
      this.editId = item.id;
    },
    changeBrandStatus(item) {
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
  <div class="row">
    <div class="col-7">
      <div class="card">
        <div v-loading="loading" class="card-body">
          <div class="card-title">
            Adverts
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Banner</th>
                  <th>Name</th>
                  <th>Call To Action</th>
                  <th>Type</th>
                  <th>Product</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in items" :key="item.id">
                  <td>
                    <div v-if="item.attachments && item.attachments.length > 0">
                      <img class="rounded" :src="`${item.attachments[0].media.url}`" width="80" height="80" />
                    </div>
                  </td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.call_to_action }}</td>
                  <td>
                    <span v-if="item.type == 1" class="badge bg-success">Modal PoP</span>
                    <span v-else class="badge bg-danger">scavenger</span>
                  </td> 

                  <td>
                    <span v-if="item.product">
                      {{ item.product.name }}
                    </span>
                  </td>

                  <td>
                    <span v-if="item.status == 1" class="badge bg-success">Active</span>
                    <span v-else class="badge bg-danger">InActive</span>
                  </td>
                  <td>
                    <div class="dropdown show">
                      <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${item.id}`" data-bs-display="static" aria-expanded="false" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${item.id}`">
                        <a v-if="canUserAccess('adverts.update')" class="dropdown-item" @click="() => handleEdit(item)">Edit</a>
                        <span v-if="canUserAccess('adverts.change_status')">
                          <a v-if="item.status !== 1" class="dropdown-item" href="#" @click="() => changeBrandStatus(item)">Activate</a>
                          <a v-else class="dropdown-item" href="#" @click="() => changeBrandStatus(item)">Deactivate</a>
                        </span>
                        <a v-if="canUserAccess('age-groups.delete')" class="dropdown-item" href="#" @click="()=>deleteAd(item)">Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination class="pull-left" module="Brands" @page-change="pageChange"/>
        </div>
      </div>
    </div>
    <div class="col-5">
      <ad-create :id="editId"/>
    </div>
  </div>
</template>

<style>

</style>