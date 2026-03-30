<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ProviderInquiriesFilter from './ProviderInquiriesFilter.vue';

export default {
  name: 'ProviderInquiryIndex',
  components: {
    ProviderInquiriesFilter,
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      providers: state => state.ProviderInquiries.items,
      loading: state => state.ProviderInquiries.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('ProviderInquiries',['fetchAll','setProperty','setPaginate', 'delete', 'persist']),
    fetchItems() {
      this.setProperty({ property: 'sorts', value: ['-id']});
      this.fetchAll();
    },
    deleteApplication(user) {
      this.$confirm().then(() => {
        this.destroy(user.id).then(() => {
         			this.$toast.success('Provider deleted Successfully');
        });
      })
    },
    changeUserStatus(user) {
      let newUser = {...user, status: user.status !== 1 ? 1: null}
      this.setSelected(newUser);
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
    <provider-inquiries-filter/>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Details</th>
                <th>Services</th>
                <th>Qualifications</th>
                <th>Experience</th>
                <th>Inquiry Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="provider in providers" :key="provider.id">
                <td>{{provider.id}}</td>
                <td>
                    <b class="ms-1">{{provider.first_name}} {{provider.last_name}}</b> <br/>
                  {{provider.email}} <br/>
                  {{provider.phone}}<br/>
                  {{provider.address}}<br/>
                </td>
                <td>{{provider.serviceOffered}}</td>
                <td>{{provider.professional_qualifications}}</td>
                <td>{{provider.works_experience}}</td>
                <td>{{provider.created_at | formatDate('LLL')}}</td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${provider.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${provider.id}`">
                      <a v-if="canUserAccess('providers.update')" class="dropdown-item">view</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="ProviderInquiries" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>