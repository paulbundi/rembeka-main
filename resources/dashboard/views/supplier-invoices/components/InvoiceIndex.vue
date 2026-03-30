<script>
  import { mapActions, mapState } from 'vuex';
  import pageChange from '../../../mixins/pageChange';
  export default {
    name: "InvoiceIndex",
    props: {
      supplierId: {
        type: Number,
        default: null,
      }
    },
    mixins: [
      pageChange,
    ],
    computed: {
      ...mapState({
        items: state => state.SupplierInvoices.items,
        loading: state => state.SupplierInvoices.loadingItems,
        selected: state => state.SupplierInvoices.selected,
      }),
    },
    created() {
      this.fetchItems();
    },
    methods: {
      ...mapActions('SupplierInvoices', ['fetchAll', 'setProperty', 'setSelected']),
      fetchItems() {
        this.setProperty({ property: 'relations', value: ['user']})
         if(this.supplierId) {
          this.setProperty({ property: 'supplierId', value: this.supplierId });
         }
        this.fetchAll();
      },
      showSelected(item) {
        this.setSelected(item);
      }
    }
  };
</script>
<template>
  <div class="card">
    <div v-loading="loading" class="card-body row">
      <div class="col-7">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Invoice No:</th>
                <th>Date</th>
                <th>Received By</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="invoice in items" :key="invoice.id">
                <td>{{invoice.id}}</td>
                <td>
                  <b>{{invoice.invoice_no}}</b>
                </td>
                <td>
                  {{invoice.created_at| formatDate('LLL')}}
                </td>
                <td>
                  <b>{{invoice.user.name}}</b>
                </td>
                <td>
                  <i class="bi bi-eye-fill cusrsor-pointer"  @click="()=>showSelected(invoice)"></i>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="SupplierInvoices" @page-change="pageChange"/>
      </div>

      <div class="col-5">
        <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Product</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in selected.items" :key="item.id">
                <td>{{item.id}}</td>
                <td>
                  <b>{{item.product}}</b>
                </td>
                <td>
                  {{item.size}}
                </td>
                <td>
                  {{item.new_supply}}
                </td>
                <td>
                @ {{item.listed_price}}
                </td>
              </tr>
            </tbody>
          </table>
      </div>
    </div>
  </div>
</template>


<style lang="scss" scoped>

</style>