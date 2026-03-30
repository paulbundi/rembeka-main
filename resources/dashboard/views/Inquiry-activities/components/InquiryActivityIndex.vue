<script>
import { mapActions, mapState } from 'vuex';
import updateProperty from '../../../mixins/updateProperty'

export default {
  name: "CreateActivity",
props: {
	id: {
		type: Number,
		default: null,
	}
},
  mixins: [
    updateProperty,
  ],
  computed: {
    ...mapState({
      items: state => state.InquiryActivities.items,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
  ...mapActions('InquiryActivities', ['fetchAll', 'setProperty', 'persist']),

  fetchItems(){

    this.setProperty({property: 'sorts', value: ['-id']})
    this.setProperty({property: 'relations', value: ['user']});
    this.setProperty({ property: 'inquiryId', value: this.id});
    this.fetchAll();
  },
  getBorder(activity) {
      if(activity == 1) {
        return "border-success";
      }
      if(activity == 2) {
        return "border-primary";
      }
      if(activity == 3) {
        return "border-warning";
      }
        return "border-info";
  },

  }
};
</script>
<template>
  <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Inquiry Activity</h4>
            <div v-for="item in items" :key="item.id">
              <div class="mt-3 border-start ps-1" :class="getBorder(item.activity)">
                <b class="text-primary">{{ item.title }}</b><br/>
                <small class="text-dark ms-1"><i class="bi bi-clock-fill"></i> {{ item.created_at | formatDate('LLL') }}</small>
                <div class="ms-2 mt-1">
                  <p class="mb-1">{{item.description}}</p>
                  <small class="text-primary">By: {{ item.user.name }}</small>
                </div>
              </div>
            </div>
        </div>
      </div>
  </div>
</template>
<style>

</style>