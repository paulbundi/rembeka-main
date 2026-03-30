<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ExpensesFilter from './ExpensesFilter.vue';

export default {
  components: { ExpensesFilter },
  name: 'ExpensesIndex',
  props: {
    isSelectable:{
      type: Boolean,
      default: false,
    },
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
      expenses: state => state.Expenses.items,
      loading: state => state.Expenses.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Expenses',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['expenseType', 'user',],
      });
      this.setProperty({property: 'sorts', value:['-id']});
      this.fetchAll();
    },
    handleFilter(value, property) {
      this.setProperty({property: property, value:value});
      this.fetchItems();
    },
    handleCheckBox(inquiry) {
      this.selectedIds = inquiry.id;
      this.$emit('selected', inquiry);
    },
    handleDelete(expense) {
      this.$confirm().then(() => {
        this.destroy(expense.id).then(() => {
          this.$toast.success('Item revomed successfully')
        })
      });
    }
  }
};
</script>
<template>
  <div>
    <expenses-filter 
      @expenseType="(e) => handleFilter(e, 'expenseType')"
      @userFilter="(e) => handleFilter(e, 'userFilter')"
    />
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Description</th>
                <th>quantity</th>
                <th>Amount</th>
                <th>Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="expense in expenses" :key="expense.id">
                <td>
                  <span class="badge badge-sm bg-success">
                    {{expense.expense_type.name}}
                  </span><br/>
                  <small>Expense Date: {{expense.expense_date | formatDate('LLL')}}</small><br/>
                  <small> Entry Date :{{expense.created_at | formatDate('LLL')}}</small><br/>
                  <small v-if="expense.user" class="badge bg-dark">
                    {{expense.user.name}}
                  </small>
                </td>
                <td>
                  {{ expense.description }}
                </td>
                <td>
                  {{expense.quantity}}
                </td>
                <td>
                  {{expense.amount }}
                </td>
                <td>{{expense.total }}</td>
                <td>
                  <template v-if="canUserAccess('expenses.delete')">
                    <button @click="() => handleDelete(expense)" class="btn btn-sm"> <i class="bi bi-trash2-fill"></i></button>
                  </template>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Expenses" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>