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
      selected: state => state.Providers.selected,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('Providers', ['fetchOne', 'setProperty', 'attachRelations','removeItemRelations']),
    ...mapActions('Roles', {setRoleProperty: 'setProperty'}),
    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['profile.attachments.media','locations'],
      })
      this.fetchOne({ id: this.id }).then(()=> {
         if(!this.selectedLocation && this.selected.locations.length > 0) {
          this.selectedLocation = this.selected.locations[0].id;
        }
      });
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
          <b>Provider Details</b>
          <a v-if="canUserAccess('users.edit')" class="btn btn-sm btn-primary float-end" :href="`/schools/${this.id}/edit`">Edit</a>
        </div>
        <table class="table table-striped">
            <tr>
              <td>Name</td>
              <td>{{ selected.name }}</td>
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
             <tr>
              <td>Profile</td>
              <td>
                <div v-if="selected.profile && selected.profile.attachments">
                  <img class="rounded" :src="`${selected.profile.attachments[0].media.url}`" width="80" height="80" />
                </div>
              </td>
            </tr>

        </table>
      </div>
    </div>
    <div class="col-7">
        <provider-location :provider-location="selected.locations" :selected-location="selectedLocation" />
    </div>
</div>
<div class="row">

  <div class="col-12 card card-body">
    <label>Select Shop</label>
    <select v-model="selectedLocation" class="form-control">
        <option v-for="location in selected.locations"
          :key="location.id"
          :value="location.id"
        >
          {{location.name}}
        </option>
    </select>
  </div>

  <div class="col-12">
    <provider-product :provider-id="id" :provider-location="selectedLocation" />
  </div>

</div>
</div>
</template>
<style>

</style>