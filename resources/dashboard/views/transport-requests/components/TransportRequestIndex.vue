<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import TransportRequestFilter from './TransportRequestFilter.vue';

export default {
  name: 'TransportRequestIndex',
  components: {
    TransportRequestFilter,
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      requests: state => state.TransportRequests.items,
      loading: state => state.TransportRequests.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('TransportRequests',[
      'fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate',
      'transportRequestApprove', 'transportRequestDenny',
    ]),

    fetchItems() {
      this.setProperty({ property: 'sorts', value: ['-id']});
      this.setProperty({property: 'relations', value: ['provider', 'order', 'user']});
      this.fetchAll();
    },
    handleApproveRequest(request) {
      this.$confirm().then(() => {
        this.transportRequestApprove(request.id).then(() => {
         	this.$toast.success('success');
          this.fetchItems();
        });
      })
    },
    handleDennyRequest(request) {
      this.$confirm().then(() => {
        this.transportRequestDenny(request.id).then(() => {
         	this.$toast.success('success');
          this.fetchItems();
        });
      })
    },
  }
};
</script>
<template>
  <div>
    <transport-request-filter/>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Order No</th>
                <th>Amount</th>
                <th>Requested At</th>
                <th>Status</th>
                <th>Actioned By</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="request in requests" :key="request.id">
                <td>{{request.id}}</td>
               
                <td>{{request.provider.name}}</td>
                <td>
                  <span v-if="request.order">{{request.order.order_no}}</span>
                  <span v-else class="badge bg-warning">Order Deleted</span>
                </td>
                <td>{{request.amount}}</td>
                <td>{{request.created_at | formatDate('LLL')}}</td>
                <td>
                  <span v-if="request.status == 1" class="badge bg-info">Pending</span>
                  <span v-if="request.status == 2" class="badge bg-success">Issued</span>
                  <span v-if="request.status == 3"  class="badge bg-danger">Cancel</span>
                </td>
                <td>
                  <span v-if="request.user">
                    {{request.user.name}}
                  </span>
                </td>
 
                <td>
                  <div v-if="request.status == 1" class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${request.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div  class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${request.id}`">
                      <button v-if="canUserAccess('transport-requests.update')" class="dropdown-item" @click="() =>handleApproveRequest(request)">Approve</button>
                      <button v-if="canUserAccess('transport-requests.update')" class="dropdown-item" @click="() =>handleDennyRequest(request)">Deny</button>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="TransportRequests" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>