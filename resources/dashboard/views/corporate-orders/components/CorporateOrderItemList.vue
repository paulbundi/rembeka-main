<script>
import { mapActions, mapState } from 'vuex'

  export default {
  name: 'CorporateOrderItemList',
  props: {
    noActions: {
      type: Boolean,
      default: false,
    }
  },
  data() {
    return {
      paymentModal: null,
      editOrderItemModal: null,
      payingLoader: false,
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
    showBeneficiary(item) {
      this.setSelected(item);
    }
  }
};
</script>
<template>
  <div class="col-12">
    <div class="table-responsive single-item-table">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Product</th>
                <th>Date</th>
                <th>Time</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <template  v-for="item in order.items">
                <tr>
                  <td>{{ item.id }}</td>
                  <td>
                    {{ item.product.name }}<br/>
                    <small>{{ item.category.name }}</small> <br/>
                    <span v-if="item.discounted" class="badge bg-success">
                      Discounted
                    </span>
                  </td>
                  <td>{{ item.appointment_date }}</td>
                  <td>{{ item.appointment_time }}</td>
                  <td>{{ item.quantity }}</td>
                  <td>
                    {{ item.amount }}<br/>
                    <span v-if="item.discounted" class="badge bg-success">
                      - {{ item.discount_amount }}
                    </span>
                  </td>
                  <td>
                    <i class="bi bi-eye-fill fs-3 cursor-pointer" @click="() =>showBeneficiary(item)"></i>
                  </td>
                </tr>
              
              </template>
            </tbody>
          </table>
    </div>
</div>
</template>
<style lang="scss" scoped>

</style>