<script>
import { mapState, mapActions } from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ProviderInquiriesFilter from './ProviderInquiriesFilter.vue';

export default {
  name: 'ProviderInquiryIndex',
  components: {
    ProviderInquiriesFilter,
  },
  data() {
    return {
    };
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      inquiries: state => state.ProviderInquiries.items,
      loading: state => state.ProviderInquiries.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('ProviderInquiries', ['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate', 'setFormTypeEdit']),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: [],
      });
      this.setProperty({ property: 'sorts', value: ['-id'] });
      this.fetchAll();
    },
    deleteInquiry(inquiry) {
      this.$confirm().then(() => {
        this.destroy(inquiry.id).then(() => {
          this.$toast.success('Provider inquiry deleted Successfully');
        });
      });
    },
    changeInquiryStatus(inquiry) {
      let newInquiry = { ...inquiry, status: inquiry.status !== 1 ? 1 : 0 };
      this.setFormTypeEdit();
      this.setSelected(newInquiry);
      this.$confirm().then(() => {
        this.persist().then(() => {
          this.fetchItems();
          this.$toast.success('Success');
        }).catch(({ response }) => {
          catchValidationErrors(this, response);
        });
      });
    },
  }
};
</script>
<template>
  <div>
    <provider-inquiries-filter />
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Details</th>
                <th>Professional Qualifications</th>
                <th>Work Experience</th>
                <th>Services</th>
                <th>Status</th>
                <th>Inquiry Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="inquiry in inquiries" :key="inquiry.id">
                <td>{{ inquiry.id }}</td>
                <td>
                  <b class="ms-1">{{ inquiry.first_name }} {{ inquiry.last_name }}</b> <br/>
                  {{ inquiry.email }} <br/>
                  {{ inquiry.phone }}<br/>
                  {{ inquiry.address }}<br/>
                </td>
                <td>{{ inquiry.professional_qualifications }}</td>
                <td>{{ inquiry.works_experience }}</td>
                <td>{{ inquiry.serviceOffered }}</td>
                <td>
                  <span v-if="inquiry.status == 1" class="badge bg-success">Active</span>
                  <span v-else-if="inquiry.status == 0" class="badge bg-warning">Inactive</span>
                  <span v-else class="badge bg-primary">Pending</span>
                </td>
                <td>{{ inquiry.created_at | formatDate('LLL') }}</td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown" :id="`dropdownAction${inquiry.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
</a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${inquiry.id}`">
                      <a v-if="canUserAccess('providers-inquiries.view')" class="dropdown-item" :href="`/providers-inquiries/${inquiry.id}`">View</a>
                      <a v-if="canUserAccess('providers-inquiries.update')" class="dropdown-item" :href="`/providers-inquiries/${inquiry.id}/edit`">Edit</a>
                      <span v-if="canUserAccess('providers-inquiries.update')">
                        <a v-if="inquiry.status !== 1" class="dropdown-item" href="#" @click="() => changeInquiryStatus(inquiry)">Activate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changeInquiryStatus(inquiry)">Deactivate</a>
                      </span>
                      <a v-if="canUserAccess('providers-inquiries.delete')" class="dropdown-item" href="#" @click="deleteInquiry(inquiry)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="ProviderInquiries" @page-change="pageChange" />
      </div>
    </div>
  </div>
</template>

<style>

</style>
