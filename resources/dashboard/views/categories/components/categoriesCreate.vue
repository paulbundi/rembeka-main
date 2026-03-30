<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import MultipleSelector from '../../generals/MultipleSelector.vue'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'CategoriesCreate',
props: {
	id: {
		type: Number,
		default: null,
	}
},
components: { 
	RemoteSelector,
	MultipleSelector,
},
mixins: [
  updateProperty,
],
data() {
	return {
		roleId: null,
	};
},
computed: {
  ...mapState({
    selected: state => state.Categories.selected,
    categories: state => state.Categories.items,
		user: state => state.authUser,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('Categories', ['fetchAll','fetchOne','persist', 'setProperty', 'attachRelations']),
    handleSave() {
      this.persist().then(() => {
        this.fetchAll();
        this.$toast.success('Success');
      }).catch(({response}) => {
          catchValidationErrors(this, response);
      });
    },
		handleChange(value) {
			this.updateProperty('parent_id', value);
		}
	}
}
</script>
<template>
	<div class="card-body">
			<div class="form-group">
				<label>Title</label>
				<input type="text" class="form-control" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
			</div>
			
			<div class="form-group">
				<label>Description</label>
				<input type="text" class="form-control" :value="selected.description" @input="(e) => updateProperty('description', e.target.value)">
			</div>
			
			<div class="form-group">
				<label>Parent Menu</label>
						<multiple-selector 
							name="Provider" 
							label="name"
							:items="categories"
							:value='selected.parent_id'
							@change="handleChange" 
							placeholder="Select parent menu"
						/>
			</div>

			<div class="form-group">
				<label>Is Active</label>
				<input type="checkbox" :value="selected.status" @input="(e) => updateProperty('status', e.target.value)">
			</div>
			<div class="form-group">
				<button class="btn btn-sm bg-primary text-white" @click="handleSave">{{ selected.id ? 'Update':'Save' }}</button>
			</div>

	</div>
</template>
<style>

</style>