<script>
import { mapState, mapActions } from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ColorCreate from './ColorCreate.vue';

export default {
  components: { ColorCreate },
  name: 'ColorIndex',
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
      items: state => state.Colors.items,
      loading: state => state.Colors.loadingItems,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Colors', [
      'fetchAll',
      'setProperty',
      'destroy',
      'setSelected',
      'resetSelected',
      'setPaginate',
    ]),

    fetchItems() {
      this.fetchAll();
    },
    deleteColor(item) {
      this.$confirm().then(() => {
        this.destroy(item.id).then(() => {
          this.$toast.success('Deleted Successfully');
          this.fetchItems();
        });
      });
    },
    handleEdit(item) {
      this.editId = item.id;
      this.setSelected(item);
    },
    handleSaved() {
      this.editId = null;
      this.fetchItems();
    },
    handleNew() {
      this.editId = null;
      this.resetSelected();
    },
  }
};
</script>
<template>
  <div class="row">
    <div class="col-6">
      <div class="card">
        <div v-loading="loading" class="card-body">
          <div class="card-title d-flex justify-content-between align-items-center">
            <span>Colors / Shade Codes</span>
            <button type="button" class="btn btn-sm btn-outline-primary" @click="handleNew">
              New Color
            </button>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Display</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in items" :key="item.id">
                  <td>{{ item.id }}</td>
                  <td>
                    <span
                      v-if="item.display_type === 'swatch' && item.hex_code"
                      class="d-inline-block rounded-circle me-2 border"
                      :style="{ width: '18px', height: '18px', backgroundColor: item.hex_code, verticalAlign: 'middle' }"
                    ></span>
                    {{ item.name }}
                  </td>
                  <td>
                    <span class="badge bg-secondary">{{ item.display_type || 'pill' }}</span>
                  </td>
                  <td>
                    <div class="dropdown show">
                      <a href="#" data-bs-toggle="dropdown" :id="`dropdownAction${item.id}`" data-bs-display="static" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${item.id}`">
                        <a class="dropdown-item" href="#" @click.prevent="() => handleEdit(item)">Edit</a>
                        <a class="dropdown-item" href="#" @click.prevent="() => deleteColor(item)">Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination class="pull-left" module="Colors" @page-change="pageChange"/>
        </div>
      </div>
    </div>
    <div class="col-6">
      <color-create :id="editId" @saved="handleSaved"/>
    </div>
  </div>
</template>
