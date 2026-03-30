<script>
import { mapActions, mapState } from 'vuex';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import updateProperty from '../../../mixins/updateProperty';
import UserTransferFunds from './UserTransferFunds.vue';

export default {
  components: { UserTransferFunds },
  name: 'UserShow',
  props: {
    id: {
      type: Number,
      required: true,
    }
  },
  mixins: [updateProperty],
  data() {
    return{
      selectedRole: null,
    };
  },
  computed: {
    ...mapState({
      selected: state => state.Users.selected,
      items: state => state.WishLists.items,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('Users', ['persist','fetchOne', 'setProperty', 'attachRelations','removeItemRelations']),
    ...mapActions('WishLists', { fetchAllWishes: 'fetchAll',setWishListProperty: 'setProperty'}),
    ...mapActions('Roles', {setRoleProperty: 'setProperty'}),
    ...mapActions('OrderItems',{setOrderItemProprty: 'setProperty', fetchOrderItems:'fetchAll'}),
    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['roles', 'store']
      });
      this.fetchOne({ id: this.id });
      this.setWishListProperty({property: 'userId', value: this.id});
      this.setWishListProperty({property: 'relations', value: ['product.attachments.media']});
      this.fetchAllWishes();
    },

    handleAddRole(value) {
      this.selectedRole = value;
    },

    addRole() {
      if (!this.selectedRole) {
        return;
      }
      let payload = {
        data: this.selectedRole,
        relationName: 'roles',
        id: this.id,
      }

      this.attachRelations(payload).then(() => {
			  this.$toast.success('success');
        this.fetchItems();
      }).catch(({response}) =>{
        catchValidationErrors(this, response);
      })
    },
    handleAttachStore(e) {
      this.updateProperty('store_id', e);
      this.persist().then(() => {
        this.$toast.success('Store attached');
        this.fetchItems();
      });
    },
    handleDetachRole(role) {
      let payload = {
        id: this.id,
        relationName: 'roles',
        data: role.id,
      };

      this.$confirm().then(() => {
        this.removeItemRelations(payload).then(() => {
          this.fetchItems();
          this.$toast.success('success');
        })
      });
    },
    handleRefresh() {
      document.getElementById('hackButton').click();
      this.fetchOne({ id: this.id });
    },
  }
};
</script>
<template>
<div class="row align-items-start">
  <div class="col-4 sticky-top">
    <div class="col-12">
        <div class="card card-body table-responsive single-item-table">
          <div class="col-12">
            <div class="d-flex justify-content-between">
              <b>User Details</b>
              <div class="">
                <a v-if="canUserAccess('users.update')" class="btn btn-sm btn-primary" :href="`/schools/${this.id}/edit`">Edit</a>
                <button v-if="canUserAccess('users.transfer-funds')"  type="button" class="btn btn-warning btn-sm ms-3" data-bs-toggle="modal" data-bs-target="#transferUserFunds">Transfer Funds</button>
              </div>
            </div>

          </div>
          <table class="table table-striped">
              <tr>
                <td>Name</td>
                <td> {{selected.name }}</td>
              </tr>
                <tr>
                <td>Email</td>
                <td>{{selected.email }}</td>
              </tr>
                <tr>
                <td>Phone</td>
                <td>{{selected.phone }}</td>
              </tr>
              <tr v-if="selected.account_type == 3">
                <td>Store</td>
                <td>
                  <span v-if="selected.store">
                    {{ selected.store.name }}
                  </span>
                  <span v-else>
                    <remote-selector 
                      module="Franchises"
                      :multiple='false'
                      @change="handleAttachStore"
                      label="name"
                    /> 
                  </span>
                </td>
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
    <div v-if="canUserAccess('users.remove-role')"  class="col-12">
      <div class="card">
        <div class="card-body">
          <label>Add Role</label>
          <remote-selector 
            module="Roles"
            :multiple='false'
            @change="handleAddRole"
            label="title"
          />
          <div class="col-12 form-group">
            <button class="btn btn-sm btn-success float-end" @click="addRole">Add Role</button>
          </div>
  
          <hr/>
  
          <div class="row">
            <div class="col-12">
              <h5>User Roles</h5>
              <span class="badge bg-success" v-for="role in selected.roles" :key="role.id">
                {{ role.title}}
                <span v-if="canUserAccess('users.remove-role')" class="badge bg-danger cursor-pointer" @click="() => handleDetachRole(role)">X</span>
              </span>
            </div>
          </div>
  
        </div>
      </div>
    </div>
  </div>

  <div class="col-8">
    <div class="col-12">
      <h4>Services</h4>
      <user-order-items :id="id" />
    </div>
    
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5>Wishlist</h5>
          <div class="table-responsive  single-item-table">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Listed Price</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in items" :key="item.id">
                  <td>
                    <div class="d-flex flex-row align-items-center">
                      <div class="me-2">
                        <div v-if="item.product.attachments  && item.product.attachments.length > 0">
                          <img class="rounded-circle" :src="`${item.product.attachments[0].media.url}`" width="80" height="80" />
                        </div>
                      </div>
                      <div>
                        {{item.product.name}}
                      </div>
                    </div>
                      
                  </td>
                  <td>{{item.product.final_price}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Transfer funds -->
<div class="modal fade" id="transferUserFunds" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="transferUserFundsLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="transferUserFundsLabel">Inter wallet transfer</h5>
        <button type="button" id="hackButton" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <user-transfer-funds @refreshPage="handleRefresh" />
      </div>
    </div>
  </div>
</div>

</div>
</template>
<style>

</style>