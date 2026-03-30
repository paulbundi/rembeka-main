<script>
import { mapActions, mapState } from 'vuex'
import AddOrderItems from './AddOrderItems.vue';
import OrderItemList from './OrderItemList.vue';

  export default {
  name: 'OrderItemsIndex',
  props: {
    noActions: {
      type: Boolean,
      default: false,
    },
    activeModule: {
      type: String,
      default: 'Orders',
    }
  },
  components: {OrderItemList, AddOrderItems},
    data() {
    return {
      orderItemModal: null,
    };
  },
  computed: {
    ...mapState({
      selected: state => state.OrderItems.selected,
      user: state => state.authUser,
    }),
    storeModule() {
      return this.activeModule
        .split('/')
        .reduce((a, b) => {
          return a[b];
        }, this.$store.state);
    },
    order() {
      return this.storeModule.selected;
    },
    loading() {
      return this.storeModule.loading
    },
  },
  methods: {
      ...mapActions('OrderItems', ['setSelected', 'makeProviderPayment', 'destroy']),
    handleAddOrderItem() {
      this.orderItemModal = new bootstrap.Modal(this.$refs.orderItems, { backdrop: 'static' });
      this.orderItemModal.show();
    }
  },
  };
</script>
<template>
<div class="col-12" >
  <div class="card">
    <div v-loading="loading" class="card-body">
      <button v-if="canUserAccess('orders.update') && order.customer" class="btn btn-primary" @click="handleAddOrderItem">
        <i class="bi bi-plus-circle"></i>
        Add Order Item
      </button>
      <order-item-list :no-actions="noActions" :active-module="activeModule"/>
    </div>
  </div>

<!-- add Order Item Modal -->
<div class="modal fade" ref="orderItems" id="orderItems" tabindex="-1" aria-labelledby="orderItems" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderItemsHeader">Update Order items : order No. {{order.order_no}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <add-order-items :active-module="activeModule"/>
      </div>
    </div>
  </div>
</div>

</div>
</template>
<style lang="scss" scoped>

</style>