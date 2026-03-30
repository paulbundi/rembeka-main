<script>
import { mapActions, mapState } from 'vuex';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ProviderLocation from './providers-details/ProviderLocation.vue';
import ProviderProduct from './providers-details/ProviderProduct.vue';
export default {
  components: { ProviderLocation, ProviderProduct},
  name: 'ProviderShow',
  props: {
    id: {
      type: Number,
      required: true,
    }
  },
  data() {
    return{
      selectedLocation: null,
    };
  },
  computed: {
    ...mapState({
      selected: state => state.Suppliers.selected,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('Suppliers', ['fetchOne', 'setProperty', 'attachRelations','removeItemRelations']),
    ...mapActions('Roles', {setRoleProperty: 'setProperty'}),
    fetchItems() {
      this.fetchOne({ id: this.id });
    },
  }
};
</script>
<template>
<div>
<div class="row">
    <div class="col-5">
      <div class="card card-body table-responsive single-item-table">
        <div class="col-12">
          <b>Supplier Details</b>
          <a v-if="canUserAccess('users.edit')" class="btn btn-sm btn-primary float-end" :href="`/schools/${this.id}/edit`">Edit</a>
        </div>
        <table class="table table-striped">
            <tr>
              <td>Name</td>
              <td>{{ selected.displayName }}</td>
            </tr>
              <tr>
              <td>Email</td>
              <td>{{ selected.email }}</td>
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
</div>
<div class="row">

<div class="col-12">
  Invoices.
  <supplier-invoice-index :supplier-id="id"/>
</div>

</div>
</div>
</template>
<style>

</style>