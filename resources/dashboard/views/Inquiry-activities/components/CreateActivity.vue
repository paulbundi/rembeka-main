<script>
import { mapActions, mapState } from 'vuex';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import updateProperty from '../../../mixins/updateProperty'

export default {
  name: "CreateActivity",
  mixins: [
    updateProperty,
  ],
  computed: {
    ...mapState({
      activity: state => state.InquiryActivities.selected,
      selected: state => state.Inquiries.selected,
      user: state => state.authUser,
    }),
  },
  methods: {
  ...mapActions('InquiryActivities', ['fetchAll', 'setProperty', 'persist']),
  handleCreateActivity() {
    this.updateProperty('user_id', this.user.id);
    this.updateProperty('inquiry_id', this.selected.id);
    this.persist().then(() => {
      this.$toast.success('Success');
      this.fetchAll();
    }).catch(({response}) => {
      catchValidationErrors(this, response);
    })
  }
  },
};
</script>
<template>

 <div class="card-body">
      <label>New Activity</label>
      <select class="form-control" name="activity" @change="(e) =>updateProperty('activity', e.target.value)">
        <option value="1">Phone Call engagement</option>
        <option value="2">WhatsApp Engagement</option>
        <option value="3">SMS engagement</option>
        <option value="4">Social Media Engagement</option>
      </select>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea 
          name="description" 
          class="form-control" 
          placeholder="Description"
          rows="5"
          @input="(e) => updateProperty('description', e.target.value)"
        >{{activity.description}}</textarea>
      </div>

      <div class="form-group float-end">
        <button class="btn btn-sm btn-success" @click="handleCreateActivity">Save Activity</button>
      </div>
    </div>
  
</template>

<style>

</style>