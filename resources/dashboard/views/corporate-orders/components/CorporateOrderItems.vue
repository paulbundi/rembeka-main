<script>
import { mapActions, mapState } from 'vuex'
import CorporateOrderItemList from './CorporateOrderItemList.vue';

  export default {
  name: 'CorporateOrderItems',
  props: {
    noActions: {
      type: Boolean,
      default: false,
    }
  },
  components: { CorporateOrderItemList },
    data() {
    return {
      orderItemModal: null,
    };
  },
  computed: {
    ...mapState({
      order: state => state.Orders.selected,
      selected: state => state.OrderItems.selected,
      loading: state => state.Orders.loading,
      user: state => state.authUser,
    }),
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
<div class="col-12">
  <div class="row">
    <div class="col-8">
      <div class="card">
        <div class="card-body">
          <corporate-order-item-list :no-actions="noActions"/>
        </div>
      </div>
    </div>
    <div class="col-4 card">
      <div class="card-body">
        <h4>Beneficiaries</h4>
          <div v-if="selected && selected.id" class="col-12">
            <ul>
              <li v-for="corporateUser in  selected.beneficiary" >
                {{corporateUser.first_name}} 
                {{corporateUser.last_name}} 
              </li>
            </ul>
          </div>
          <div v-else>
            <span class="text-info">Select Order item to view beneficiaries</span>
          </div>
      </div>
    </div>
  </div>
</div>
</template>
<style lang="scss" scoped>

</style>