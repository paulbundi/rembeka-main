<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector.vue'

export default {
  name: 'ProviderInquiryCreate',
  components: {
    RemoteSelector,
  },
  props: {
    id: {
      type: Number,
      default: null,
    },
    isModal: {
      type: Boolean,
      default: false,
    }
  },
  mixins: [
    updateProperty,
  ],
  data() {
    return {
    };
  },
  computed: {
    ...mapState({
      selected: state => state.ProviderInquiries.selected,
      user: state => state.authUser,
      loading: state => state.ProviderInquiries.loadingItem,
    }),
  },
  created() {
    if (this.id) {
      this.fetchItems();
    }
  },
  methods: {
    ...mapActions('ProviderInquiries', ['fetchOne', 'persist', 'setProperty']),
    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: [],
      });
      this.fetchOne({ id: this.id });
    },
    createInquiry() {
      if (this.selected.user_id == null) {
        this.updateProperty('user_id', this.user.id);
      }
      this.persist().then(({ data }) => {
        this.$toast.success('Inquiry Created Successfully');
        setTimeout(() => {
          if (!this.isModal) {
            window.location = '/providers-inquiries';
          }
        }, 500);
      })
      .catch(({ response }) => {
        catchValidationErrors(this, response);
      });
    },
  }
}
</script>
<template>
  <div class="card">
    <div class="card-body">
      <h4>{{ selected.id ? 'Update' : 'Create a' }} provider inquiry</h4>
      <form>
        <div class="row">
          <div class="col-6">
            <div class="row">
              <div class="col-6 form-group">
                <label for="first-name">First Name</label>
                <input type="text" class="form-control" :value="selected.first_name" @input="(e) => updateProperty('first_name', e.target.value)">
              </div>
              <div class="col-6 form-group">
                <label for="last-name">Last Name</label>
                <input type="text" class="form-control" :value="selected.last_name" @input="(e) => updateProperty('last_name', e.target.value)">
              </div>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" :value="selected.email" class="form-control" @input="(e) => updateProperty('email', e.target.value)">
            </div>

            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="tel" class="form-control" :value="selected.phone" @input="(e) => updateProperty('phone', e.target.value)">
            </div>

            <div class="form-group">
              <label for="address">Address / Location</label>
              <input type="text" class="form-control" :value="selected.address" @input="(e) => updateProperty('address', e.target.value)">
            </div>
          </div>

          <div class="col-6">
            <div class="form-group">
              <label>Professional Qualifications</label>
              <textarea class="form-control" rows="4" @input="(e) => updateProperty('professional_qualifications', e.target.value)">{{ selected.professional_qualifications }}</textarea>
            </div>

            <div class="form-group">
              <label>Work Experience</label>
              <textarea class="form-control" rows="4" @input="(e) => updateProperty('works_experience', e.target.value)">{{ selected.works_experience }}</textarea>
            </div>

            <div class="form-group">
              <label>Services</label>
              <remote-selector
                module="Menus"
                :value="selected.services || []"
                :multiple="true"
                label="name"
                @change="(value) => updateProperty('services', value)"
              />
              <small class="text-muted">Select the services this provider-offer applicant is interested in.</small>
            </div>

            <div class="form-group">
              <label>Status</label>
              <select class="form-control" :value="selected.status" @input="(e) => updateProperty('status', e.target.value)">
                <option value="">Select Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
          </div>

          <div class="col-12 d-flex justify-content-end">
            <div v-if="loading">
              <button v-loading="loading" class="btn btn-sm text-white float-end"></button>
            </div>
            <button v-else class="btn btn-primary" @click.prevent="createInquiry">{{ selected.id ? 'Update' : 'Create' }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<style>

</style>
