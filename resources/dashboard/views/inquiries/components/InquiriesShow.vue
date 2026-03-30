<script>
import { mapActions, mapState } from 'vuex';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import CreateActivity from '../../Inquiry-activities/components/CreateActivity.vue';
import InquiryActivityIndex from '../../Inquiry-activities/components/InquiryActivityIndex.vue';
import InquiriesCreate from './InquiriesCreate.vue';

export default {
  name: 'InquiriesShow',
  components: { CreateActivity, InquiryActivityIndex, InquiriesCreate},
  props: {
    id: {
      type: Number,
      required: true,
    }
  },
  computed: {
    ...mapState({
      selected: state => state.Inquiries.selected,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('Inquiries', { fetchOne:'fetchOne', setInquiryProperty:'setProperty'}),
    fetchItems() {
      this.setInquiryProperty({
        property: 'relations',
        value: ['channel', 'user', 'product', 'assigned'],
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
  <div class="col-6">
    <div class="col-12">
      <div class="card card-body table-responsive single-item-table">
        <div class="col-12">
          <h4>Inquiry Details
            <button class="btn btn-primary btn-sm" @click="handleEditInquiry">
              <i class="bi bi-pencil"></i>
              Edit
            </button>
          </h4>
          <a v-if="canUserAccess('users.edit')" class="btn btn-sm btn-primary float-end" :href="`/schools/${this.id}/edit`">Edit</a>
        </div>
        <table class="table table-striped">
            <tr>
              <td>Customer Details</td>
              <td> 
                Names: {{selected.first_name }} {{selected.last_name }} <br/>
                Contact: {{selected.email }} {{selected.phone }} <br/>
                Channel: <small v-if="selected.channel" class="text-primary">{{selected.channel.name}}</small>
              </td>
            </tr>
              <tr>
              <td>Product Interested</td>
              <td>
                <span v-if="selected.product">
                  {{selected.product.name }}
                </span>
              </td>
            </tr>
            <tr>
              <td>Description</td>
              <td>{{selected.description}}</td>
            </tr>
            <tr>
              <td>Callback Date</td>
              <td>{{selected.callback_date |formatDate('LLL')}}</td>
            </tr>
             <tr>
              <td>User</td>
              <td>
                <small v-if="selected.user"> Created By: {{ selected.user.name }}</small><br/>
                <small v-if="selected.user"> Assigned: {{ selected.assigned.name }}</small>
              </td>
            </tr>
        </table>
      </div>
    </div>
    <div class="col-12 card ">
      <create-activity/>
    </div>
  </div>
  <div class="col-6 activity-container card">
      <inquiry-activity-index :id="id"/>
  </div>

  <!-- Modal -->
<div class="modal fade" id="inquiryEditModal" tabindex="-1" aria-labelledby="inquiryEditModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inquiryEditModasl">Edit Inquiry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <inquiries-create is-modal />
      </div>
    </div>
  </div>
</div>
</div>
</template>
<style scoped>
.activity-container{
  max-height: 80vH;
  overflow-y: scroll;
}
</style>