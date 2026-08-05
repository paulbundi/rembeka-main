<script>
import { mapActions, mapState } from 'vuex';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ProviderInquiryCreate from './ProviderInquiryCreate.vue';

export default {
  name: 'ProviderInquiryShow',
  components: { ProviderInquiryCreate },
  props: {
    id: {
      type: Number,
      required: true,
    }
  },
  computed: {
    ...mapState({
      selected: state => state.ProviderInquiries.selected,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('ProviderInquiries', { fetchOne: 'fetchOne', setInquiryProperty: 'setProperty' }),
    fetchItems() {
      this.setInquiryProperty({
        property: 'relations',
        value: [],
      });
      this.fetchOne({ id: this.id });
    },
    handleEditInquiry() {
      new bootstrap.Modal(document.getElementById('inquiryEditModal')).show();
    }
  }
};
</script>
<template>
  <div class="row">
    <div class="col-12">
      <div class="card card-body table-responsive single-item-table">
        <div class="col-12">
          <h4>Provider Inquiry Details
            <button class="btn btn-primary btn-sm" @click="handleEditInquiry">
              <i class="bi bi-pencil"></i>
              Edit
            </button>
          </h4>
        </div>
        <table class="table table-striped">
          <tr>
            <td>Name</td>
            <td> {{ selected.first_name }} {{ selected.last_name }} </td>
          </tr>
          <tr>
            <td>Contact</td>
            <td>
              {{ selected.email }} <br/>
              {{ selected.phone }}
            </td>
          </tr>
          <tr>
            <td>Address</td>
            <td>{{ selected.address }}</td>
          </tr>
          <tr>
            <td>Professional Qualifications</td>
            <td>{{ selected.professional_qualifications }}</td>
          </tr>
          <tr>
            <td>Work Experience</td>
            <td>{{ selected.works_experience }}</td>
          </tr>
          <tr>
            <td>Services</td>
            <td>{{ selected.serviceOffered }}</td>
          </tr>
          <tr>
            <td>Status</td>
            <td>
              <span v-if="selected.status == 1" class="badge bg-success">Active</span>
              <span v-else-if="selected.status == 0" class="badge bg-warning">Inactive</span>
              <span v-else class="badge bg-primary">Pending</span>
            </td>
          </tr>
          <tr>
            <td>Created At</td>
            <td>{{ selected.created_at | formatDate('LLLL') }}</td>
          </tr>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="inquiryEditModal" tabindex="-1" aria-labelledby="inquiryEditModal" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="inquiryEditModasl">Edit Provider Inquiry</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <provider-inquiry-create :id="id" is-modal />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.single-item-table {
  max-height: 80vH;
  overflow-y: scroll;
}
</style>
