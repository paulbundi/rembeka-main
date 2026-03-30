<script>
import { mapActions, mapState } from 'vuex';
import pageChange from '../../../mixins/pageChange';
import CorporateUserIndex from '../../corporate-users/components/CorporateUsersIndex.vue';
import RemoteSelector from '../../generals/RemoteSelector.vue';
import PaymentForm from './PaymentForm.vue';
import TransferFund from './TransferFund.vue';
export default {
  components: { PaymentForm, RemoteSelector, CorporateUserIndex, TransferFund },
  name: 'CorporateShow',
  props: {
    id: {
      type: Number,
      required: true,
    }
  },
  mixins: [
    pageChange
  ],
  data() {
    return{
      selectedUser: null,
    };
  },
  computed: {
    ...mapState({
      selected: state => state.Corporates.selected,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();

  },
  methods: {
    ...mapActions('Corporates', ['fetchOne', 'setProperty']),
    ...mapActions('CorporateUsers',{setCorporateProperty: 'setProperty'}),

    fetchItems() {
      this.setCorporateProperty({property: 'corporateId', value: this.id})
      this.setProperty({property: 'relationCounts', value: ['orders', 'corporateUsers']});
      this.fetchOne({ id: this.id });
    },
    handleRefresh() {
      document.getElementById('hackButton').click();
      this.fetchOne({ id: this.id });
    },

  }
};
</script>
<template>
<div class="row">
  <div class="col-8">
    <div class="col-12">
      <div class="card card-body table-responsive single-item-table">
        <div class="col-12">
          <b>Corporate Details</b>
          <a v-if="canUserAccess('users.edit')" class="btn btn-sm btn-primary float-end" :href="`/schools/${this.id}/edit`">Edit</a>
        </div>
        <table class="table table-striped">
            <tr>
              <td>Name</td>
              <td> {{selected.organization_name }}</td>
            </tr>
            <tr>
              <td>Email</td>
              <td>{{selected.email }}</td>
            </tr>
              <tr>
              <td>Phone</td>
              <td>{{selected.phone }}</td>
            </tr>
            <tr>
              <td>Wallet Amount</td>
              <td>{{selected.wallet }}</td>
            </tr>
              <tr>
              <td>Status</td>
              <td>
                <span v-if="selected.status == 1" class="badge bg-success">Active</span>
                <span v-else class="badge bg-danger">InActive</span>
              </td>
            </tr>
        </table>
      </div>
    </div>
    <corporate-user-index />
  </div>
  <div class="col-4">

    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <span>Transfer Funds</b></span>
          <button v-if="canUserAccess('corporates.transfer-funds')"  type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#transferFunds">
            Transfer Funds
          </button>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <span>Wallet balance: <b> {{ selected.wallet }}</b></span>
          <button v-if="canUserAccess('corporates.load-wallet')"  type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Top up wallet
          </button>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
          Total Users: <b> {{ selected.corporate_users_count }}</b>
        </div>
    </div>

        <div class="card">
      <div class="card-body">
          Total Orders: <b> {{ selected.orders_count }}</b>
        </div>
    </div>
  </div>

<!-- Transfer funds -->
<div class="modal fade" id="transferFunds" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="transferFundsLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="transferFundsLabel">Inter wallet transfer</h5>
        <button type="button" id="hackButton" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <transfer-fund @refreshPage="handleRefresh" />
      </div>
    </div>
  </div>
</div>

<!-- wallet top-up -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Wallet Top up</h5>
        <button type="button" id="hackButton" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <payment-form @refreshPage="handleRefresh"/>
      </div>
    </div>
  </div>
</div>

</div>
</template>
<style>

</style>