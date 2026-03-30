<script>
import { mapActions, mapState } from 'vuex';
import itemDetails from '../../user-orders/components/itemDetails.vue';

  export default {
  components: { itemDetails },
    name: 'UserOrderItems',
    props: {
      id: {
        type: Number,
        required: true,
      }
    },
    computed: {
    ...mapState({
      items: state => state.CustomerOrders.items,
      user: state => state.authUser,
    }),
  },
  created() {
    this.fetchItems();
  },
    methods: {
      ...mapActions('CustomerOrders', ['fetchAll', 'setProperty']),

      fetchItems() {
        this.setProperty({property: 'relations', value:['items.provider','location', 'items.product', 'items.category', 'channel', 'admin',
            'items.supplier', 'store']}),
        this.setProperty({property: 'customerId', value: this.id});
        this.fetchAll();
      }
    }
  };
</script>

<template>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive single-item-table">
            <table class="table table-striped table-analytics">
              <thead>
                <tr>
                  <th>Order No.</th>
                  <th>notes</th>
                  <th>Status</th>
                  <th>Amount</th>
                  <th>Deposit</th>
                  <th>Balance</th>
                </tr>
              </thead>
              <tbody>
                <template v-for="order in items">
                  <tr>
                    <td>
                      {{order.order_no}} <br/>
                      <small>{{order.created_at | formatDate('LLL')}}</small><br/>
                      <small class="badge bg-success" v-if="order.channel">
                        {{ order.channel.name }}
                      </small><br/>
                    </td>
                    <td>{{order.notes}}</td>
                    <td>
                      <order-status :status="order.status" />
                      <div v-if="[1,10].includes(order.status)" class="">
                        <select class="form-control" name="status" @change="(e) => handleOrderChange(e.target.value)">
                          <option></option>
                          <option value="1" v-if="order.paid > 0">Confirm</option>
                          <option value="2">Cancel</option>
                        </select>
                      </div>
                    </td>
                    <td>
                        {{order.amount}}
                    </td>
                    <td>{{order.paid}}</td>
                    <td>{{order.balance}}</td>
                  </tr>

                  <tr class="border-bottom mt-2">
                    <td colspan="7">
                      <table class="table table-success table-striped table-analytics">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Provider / Supplier</th>
                            <th>Product / Service </th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Provider Payment</th>
                          </tr>
                        </thead>
                        <item-details v-for="item in order.items" :item="item" :key="item.id" />
                      </table>
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
      </div>
    </div>
  </div>
</template>


<style lang="scss" scoped>

</style>