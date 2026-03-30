<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import PartnerFilter from './PartnerFilter.vue';

export default {
  components: { PartnerFilter },
  name: 'PartnersIndex',
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      partners: state => state.Partners.items,
      loading: state => state.Partners.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Partners',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['logo'],
      });
      this.fetchAll();
    },
    deletePartner(partner) {
      this.$confirm().then(() => {
        this.destroy(partner.id).then(() => {
         			this.$toast.success('Partner deleted Successfully');
        });
      })
    },
    changePartnerStatus(partner) {
      let newPartner = {...partner, status: partner.status !== 1 ? 1: null}
      if(newPartner.status == null) {
        newPartner = {...newPartner, published: 0 }
      }
      this.setSelected(newPartner);
      this.$confirm().then(() => {
        this.persist().then(() => {
          this.fetchItems();
         	this.$toast.success('Success');
        }).catch(({response}) => {
          catchValidationErrors(this, response);
        });
      });
    },

  }
};
</script>
<template>
  <div>
    <partner-filter />
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="partner in partners" :key="partner.id">
                <td>{{partner.id}}</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div v-if="partner.logo">
                      <img class="rounded-circle" :src="`${partner.logo.url}`" width="80" height="80" />
                    </div>
                    <div>
                      <b class="ms-1">{{partner.name}}</b> <br/>
                    </div>
                  </div>
                </td>
                <td>{{partner.description}}</td>
                <td>
                  <span v-if="partner.status == 1" class="badge bg-success">Active</span>
                  <span v-else class="badge bg-warning">In Active</span>
                </td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${partner.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${partner.id}`">
                
                      <a v-if="canUserAccess('partners.update')" class="dropdown-item" :href="`/partners/${partner.id}/edit`">Edit</a>
                       <span v-if="canUserAccess('partners.change_status')">
                        <a v-if="partner.status == 1" class="dropdown-item" href="#" @click="() => changePartnerStatus(partner)">Deactivate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changePartnerStatus(partner)">Activate</a>
                      </span>
                      <a v-if="canUserAccess('partners.delete')" class="dropdown-item" href="#" @click="()=>deletePartner(partner)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Providers" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>