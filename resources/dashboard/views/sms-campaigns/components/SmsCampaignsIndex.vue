<script>
import { mapActions, mapState } from 'vuex';
import updateProperty from '../../../mixins/updateProperty';
import RemoteSelector from '../../generals/RemoteSelector.vue';
import catchValidationErrors from '../../../utils/catchValidationErrors'

  export default {
  components: { RemoteSelector },
    name: 'SmsCampaignsIndex',
    mixins: [
      updateProperty,
    ],
    data() {
      return {
        loading: false,
      };
    },
    computed: {
    ...mapState({
      groups: state => state.Groups.items,
      selected: state => state.SmsCampaigns.selected,
      user: state => state.authUser,
    }),
    characterCount() {
        if(this.selected && this.selected.message) {
            return this.selected.message.length;
        }
        return 0;
    }
  },
  methods:{
    ...mapActions('SmsCampaigns',['persist','setProperty', 'resetSelected']),
    sendSms() {
      this.loading = true;
      this.updateProperty('sender_id', this.user.id);
      this.persist().then(() => {
        this.resetSelected();
        this.$toast.success('Sent Successfully');
      }).catch(({response}) => {
        catchValidationErrors(this, response);
      }).finally(() => {
        this.loading = false;
      });
    }
  }
  };
</script>
<template>
  <div class="row">
    <div class="col-6">
      <groups-index/>
    </div>
    <div class="col-6 card">
      <div class="card-body">
        <h4>Compose New Message</h4>
        <div class="form-group">
            <label>Campaign Type</label>
            <select class="form-control" @change="(e) =>updateProperty('type', e.target.value)">
              <option value=""></option>
              <option value="1" :selected="selected.type == 1">Individual</option>
              <option value="2" :selected="selected.type == 2">Group</option>
            </select>
        </div>

          <div v-if="selected.type == 1" class="form-group">
            <label>Customer</label>
            <remote-selector 
              module="Users"
              :multiple='false'
              @change="(value) => updateProperty('user_id', value)"
              label="name"
            />
          </div>

          <div v-if="selected.type == 2" class="form-group">
            <label>Select Group</label>
            <select @change="(e) => updateProperty('group_id', e.target.value)" class="form-control">
              <option></option>
              <option v-for="(group,i) in groups" :key="i" :value="group.id">{{ group.name }}</option>
            </select>
          </div>


        <div class="form-group">
          <label>Message</label>
          <textarea class="form-control" :value="selected.message" @input="(e) => updateProperty('message', e.target.value)" rows="5" placeholder="message body"></textarea>
          
          <small class="text-muted">Hi :first_name, {message body}</small><br/>

          {{ Math.ceil(Math.abs(characterCount/160)) }} / {{characterCount}}

        </div>

        <div class="form-group">
          <div v-if="loading">
						<button v-loading="loading" class="btn btn-sm text-white float-end"></button>
					</div>
          <button v-else type="submit" class="btn btn-sm btn-primary float-end" @click="sendSms">Send SMS</button>
        </div>

      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>

</style>