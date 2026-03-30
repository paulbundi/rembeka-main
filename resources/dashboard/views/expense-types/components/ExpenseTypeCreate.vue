<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import MultipleSelector from '../../generals/MultipleSelector.vue'

export default {
  components: { MultipleSelector },
name: 'ExpenseTypeCreate',
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
		mainCategories: [],
	};
},
computed: {
  ...mapState({
		items: state => state.ExpenseTypes.items,
    selected: state => state.ExpenseTypes.selected,
		user: state => state.authUser,
  }),
	parentItem() {
		if (this.selected && this.selected.parent_id) {
				return this.items.filter(item => item.parent_id == this.selected.id);
		}
		return [];
	}
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('ExpenseTypes', ['fetchOne','persist', 'setProperty']),
	fetchItems() {
		this.fetchOne({id: this.id});
	},
  handleSave() {
		if(this.selected.user_id == null) {
			this.updateProperty('user_id', this.user.id);
		}
    this.persist().then(({data}) => {
			this.$toast.success('Expense Type Created Successfully');
			this.$emit('refresh');
    })
		.catch(({response}) => {
      catchValidationErrors(this, response);
    });

  },
}
}
</script>
<template>
  <div class="card">
		<div class="card-body">
			<h4>{{ selected.id ? 'Update': 'Create an' }} Expense Type</h4>
			<form>

			<div class="form-group">
				<label>Category Name</label>
				<input type="text" class="form-control" :value="selected.name" @input="(e)=>updateProperty('name', e.target.value)" />
			</div>


			<div class="form-group">
				<label>Description</label>
				<textarea class="form-control" name="category" @input="(e)=>updateProperty('description', e.target.value)">{{selected.description}}</textarea>
			</div>

			<div class="form-group">
				<label>Parent Category</label>
				<multiple-selector 
					:items="items"
					:value='selected.parent_id'
					@change="(selected) => updateProperty('parent_id', selected)"
				 />
			</div>

			<div class="form-group">
				<button class="btn bg-primary text-white" type="button" @click="handleSave">{{ selected.id ? 'Update':'Save' }}</button>
			</div>

			</form>
		</div>
  </div>
</template>
<style>

</style>