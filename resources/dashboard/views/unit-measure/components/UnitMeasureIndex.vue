<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import UnitMeasureCreate from './UnitMeasureCreate.vue';

export default {
  components: { UnitMeasureCreate },
  name: 'UnitMeasureIndex',
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
      items: state => state.UnitMeasures.items,
      loading: state => state.UnitMeasures.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('UnitMeasures',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      this.fetchAll();
    },
    deleteBrand(item) {
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
    <div class="col-6">
      <div class="card">
        <div v-loading="loading" class="card-body">
          <div class="card-title">
            Per Unit Measure
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in items" :key="item.id">
                  <td>{{item.id}}</td>
                  <td>{{ item.name }}</td>
                  <td>
                    <div class="dropdown show">
                      <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${item.id}`" data-bs-display="static" aria-expanded="false" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${item.id}`">
                        <a v-if="canUserAccess('brands.update')" class="dropdown-item" @click="() => handleEdit(item)">Edit</a>
                        <span v-if="canUserAccess('brands.change_status')">
                          <a v-if="item.status !== 1" class="dropdown-item" href="#" @click="() => changeBrandStatus(item)">Activate</a>
                          <a v-else class="dropdown-item" href="#" @click="() => changeBrandStatus(item)">Deactivate</a>
                        </span>
                        <a v-if="canUserAccess('age-groups.delete')" class="dropdown-item" href="#" @click="()=>deleteBrand(item)">Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination class="pull-left" module="UnitMeasures" @page-change="pageChange"/>
        </div>
      </div>
    </div>
    <div class="col-6">
      <unit-measure-create :id="editId"/>
    </div>
  </div>
</template>

<style>

</style>