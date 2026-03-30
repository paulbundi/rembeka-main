<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'

export default {
name: 'ExpensesCreate',
props: {
	id: {
		type: Number,
		default: null,
	},
	isModal: {
		type: Boolean,
		default: false,
	}
},

mixins: [
  updateProperty,
],
data() {
	return {
		expense:{
			expenseItems: [{
				expense_type_id: null,
				amount: null,
				quantity: null,
				description: null,
				expense_date: new Date().toISOString().slice(0, 10),
			}],
		},
	};
},
computed: {
  ...mapState({
    selected: state => state.Expenses.selected,
		user: state => state.authUser,
  }),
  totalAmount() {
       let sum = 0;
      if(this.expense.expenseItems && this.expense.expenseItems.length > 0) {
        this.expense.expenseItems.forEach((item) => {
          sum  +=  item.quantity * item.amount
        });
      }
    return sum;
  }
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('Expenses', ['fetchOne','persist', 'setProperty']),
	fetchItems() {
		 this.setProperty({
        property: 'relations',
        value: ['channel', 'product'],
      });
		this.fetchOne({id: this.id});
	},
	addExpenses() {
		this.expense.expenseItems = [...this.expense.expenseItems, {
				expense_type_id: null,
				amount: null,
				quantity: null,
				description: null,
				expense_date: new Date().toISOString().slice(0, 10),
			}
		];
	},
	removeExpenseItem(index) {
		this.expense.expenseItems.splice(index, 1);
	},
  createExpenses() {

			let invalid = this.expense.expenseItems.filter((item) => {
			if(!item.amount || !item.quantity || !item.description) {
				return true;
			}
		});
		if(invalid && invalid.length > 0) {
			this.$toast.error('All expense details are required.');
			return;
		}

		if(this.selected.user_id == null) {
			this.updateProperty('user_id', this.user.id);
		}
		this.updateProperty('expense', this.expense);
    this.persist().then(({data}) => {
			this.$toast.success('Expense Created Successfully');
			setTimeout(() => {
				if(!this.isModal){
					window.location= '/expenses';
				}
			},500);
    })
		.catch(({response}) => {
      catchValidationErrors(this, response);
    });
  },
	handleChange(value, index) {
		let updateIndex = this.expense.expenseItems[index];
		updateIndex.expense_type_id = value;
		this.expense.expenseItems[index] = updateIndex;
	}
}
}
</script>
<template>
  <div class="card">
		<div class="card-body">
			<h4>{{ selected.id ? 'Update': 'Create a' }} Expense</h4>
			<div class="row">
				<div class="col-12">
					<div class="single-item-table">
						<table class="table table-striped">
								<thead>
									<th>#</th>
									<th>Description</th>
									<th>quantity</th>
									<th>Amount</th>
									<th>Total</th>
								</thead>
								<tbody>
									<tr>
										<td colspan="7">
											<button class="btn btn-sm btn-primary me-2" @click="addExpenses">
												<i class="bi bi-plus-circle"></i>
											</button>
										</td>
									</tr>
									<tr v-for="(item, index) in expense.expenseItems" :key="index">
										<td style="min-width: 300px;">
											<div class="d-flex flex-row align-center">
													<button class="btn btn-sm btn-danger me-2" @click="()=>removeExpenseItem(index)">
														<i class="bi bi-dash-circle"></i>
													</button>

												<div class="flex-grow-1">
													<small>Expense Type</small>
													<remote-selector
														module="ExpenseTypes"
														:multiple="false"
														@change="(e) => handleChange(e, index)"
													/>
													<div class="">
														<small>Date</small>
														<input class="form-control" min="1" type="date" v-model="item.expense_date">
													</div>

												</div>

											</div>
										</td>
										<td style="width:300px">
											<textarea rows="4" class="form-control" v-model="item.description"></textarea>
										</td>

										<td >
												<input class="form-control" min="1" type="number" v-model="item.quantity">
										</td>
									
										<td>
											<input class="form-control" min="1" type="number" v-model="item.amount">
										</td>
										<td>
											<b>{{ item.quantity * item.amount }}</b>
										</td>
									</tr>

								<template v-if="expense.expenseItems && expense.expenseItems.length > 0">
									<tr>
										<td colspan="4" class="text-end" >
											<b>Total Expense Amount</b>
										</td>
										<td>
											<b>{{  totalAmount }}</b>
										</td>
									</tr>
								</template>
								</tbody>
						</table>
					</div>
				</div>
				<div class="col-12">
					<button class="btn btn-sm btn-primary float-end" @click="createExpenses">Create Expense </button>
				</div>
			</div>
		</div>
  </div>
</template>
<style scoped>
</style>