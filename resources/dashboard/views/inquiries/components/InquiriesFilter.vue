<script>
import { mapActions } from 'vuex';
import InputFilter from '../../../views/generals/InputFilter';
import DateRange from '../../generals/DateRange.vue';
import RemoteSelector from '../../generals/RemoteSelector.vue';

export default {
  name: 'InquiriesFilter',
  components: {
    InputFilter,
    RemoteSelector,
    DateRange
  },

  methods: {
    ...mapActions('Inquiries', ['setProperty', 'fetchAll']),
    handleRangeChange(value) {
     this.$emit('range-filter', value);
    },
    handleChannelFilter(property, value) {
      this.setProperty({property: property, value: value});
      this.fetchAll();
    }
  }
};
</script>
<template>
  <div class="card">
      <div class="card-body">
          <div class="row">

            <div class="col-3">
              <label>Assigned User</label>
              <remote-selector
                module="Users"
                label="name"
                input-class="form-control"
                @change="(e) => handleChannelFilter('assignedUsers',e)"
              />
            </div>

            <div class="col-3">
              <label>Channel</label>
              <remote-selector
                module="Channels"
                label="name"
                input-class="form-control"
                @change="(e) => handleChannelFilter('inquiriesChannels',e)"
              />
            </div>

            <div class="col-3">
              <label>Callback Date</label>
              <date-range @changed="handleRangeChange"/>
            </div>

            <div class="col-2">
              <input-filter 
                module="Inquiries"
                label="Phone"
                class="me-3 pt-2"
              />
            </div>

            <div class="col-1">
              <div v-if="canUserAccess('inquiries.create')" class="float-end">
                <a class="btn bg-primary mt-3 text-white" href="/inquiries/create">
                  <i class="bi bi-plus-circle-fill"></i>
                  Create Enquiry
                </a>
              </div>
            </div>

          </div>
      </div>
    </div>
</template>
<style scoped>

</style>