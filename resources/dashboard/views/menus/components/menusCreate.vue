<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import MultipleSelector from '../../generals/MultipleSelector.vue'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'OrderCreate',
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
    selected: state => state.Menus.selected,
    menus: state => state.Menus.items,
		user: state => state.authUser,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('Menus', ['fetchAll','fetchOne','persist', 'setProperty', 'attachRelations']),
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
				<label>Menu Type</label>
				<select class="form-control" @change="(e) => updateProperty('type', e.target.value)">
					<option value=""></option>
					<option value="1">Product Menu</option>
					<option value="2">Service Menu</option>
				</select>
			</div>
			<div class="form-group">
				<label>Title</label>
				<input type="text" class="form-control" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
			</div>
			<div class="form-group">
				<label>Meneu Icon(bootsrap icons)</label>
				<input type="text" class="form-control" :value="selected.icon" @input="(e) => updateProperty('icon', e.target.value)">
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
							:items="menus"
							:value='selected.parent_id'
							@change="handleChange" 
							placeholder="Select parent menu"
						/>
			</div>

			<div class="form-group">
				<input type="checkbox"
					value="1"
					:checked="selected.status == 1"
					@input="(e) => updateProperty('status', e.target.value)"
				>
				<label>Is Active</label>
			</div>
			<div class="form-group">
				<button class="btn btn-sm bg-primary text-white" @click="handleSave">{{ selected.id ? 'Update':'Save' }}</button>
			</div>

	</div>
</template>
<style>

</style>