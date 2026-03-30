<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import InquiriesFilter from './InquiriesFilter.vue';

export default {
  name: 'InquiriesIndex',
  props: {
    isSelectable:{
      type: Boolean,
      default: false,
    },
  },
  components: {
    InquiriesFilter,
  },
  data() {
    return {
      selectedIds: null,
    };
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      inquiries: state => state.Inquiries.items,
      loading: state => state.Inquiries.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Inquiries',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['channel', 'user', 'product', 'assigned'],
      });
      this.setProperty({property: 'sorts', value:['-id']});
      this.fetchAll();
    },
    handleRangeFilter(value) {
      this.setProperty({property: 'rangeFilter', value:value});
      this.fetchItems();
    },
    handleCheckBox(inquiry) {
      this.selectedIds = inquiry.id;
      this.$emit('selected', inquiry);
    },
  }
};
</script>
<template>
  <div>
    <inquiries-filter @range-filter="handleRangeFilter"/>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Product</th>
                <th>Channel</th>
                <th>Descriptions</th>
                <th>Callback Date</th>
                <th>Status</th>
                <th>Assigned</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="inquiry in inquiries" :key="inquiry.id">
                <td>
                  <input type="checkbox" 
                    :checked="selectedIds == inquiry.id" 
                    :value="inquiry.id"
                    @change="()=> handleCheckBox(inquiry)" 
                  />
                  {{inquiry.first_name}}
                  {{inquiry.last_name}} <br/>
                  <small> social: {{ inquiry.social_name}}</small>
                </td>
                <td>
                  {{inquiry.phone}} <br/>
                  {{inquiry.email}}
                </td>
                <td>
                  <span v-if="inquiry.product">{{ inquiry.product.name }}</span>
                </td>
                <td>
                  <span v-if="inquiry.channel">
                    {{inquiry.channel.name}}
                  </span>
                </td>
                <td>{{inquiry.description}}</td>
                <td>
                  {{inquiry.callback_date | formatDate('LL')}}<br/>
                  <div v-if="inquiry.callback_date && !inquiry.status">
                    <span v-html="$options.filters.fromNow(inquiry.callback_date)"></span>
                  </div>
                </td>

                <td>
                  <span v-if="inquiry.status == 1" class="badge bg-success">Converted</span>
                  <span v-else-if="inquiry.status == 2" class="badge bg-wargning">Dropped</span>
                  <span v-else class="badge bg-primary">Pending</span>
                </td>
                <td>
                  <span v-if="inquiry.assigned">{{ inquiry.assigned.name }}</span>
                </td>
                <td>
                  {{inquiry.created_at | formatDate('LLLL')}} <br/>
                  <small class="badge bg-success"> by: {{ inquiry.user.name }}</small>
                </td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${inquiry.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${inquiry.id}`">
                      <a v-if="canUserAccess('inquiries.update')" class="dropdown-item" :href="`/inquiries/${inquiry.id}`">view</a>
                      <a v-if="canUserAccess('inquiries.update')" class="dropdown-item" :href="`/inquiries/${inquiry.id}/edit`">Edit</a>
                      <a v-if="canUserAccess('inquiries.delete')" class="dropdown-item" href="#" @click="()=>deleteUser(inquiry)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Inquiries" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>