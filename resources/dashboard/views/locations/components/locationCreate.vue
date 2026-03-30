<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import MultipleSelector from '../../generals/MultipleSelector.vue'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'LocationCreate',
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
    selected: state => state.Locations.selected,
    locations: state => state.Locations.items,
		user: state => state.authUser,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('Locations', ['fetchAll','fetchOne','persist', 'setProperty', 'attachRelations']),
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
		},
		handlecheck(field, value) {
			// console.log(field, value, 'dsdsd');
		}
	}
}
</script>
<template>
	<div class="card-body">
			<div class="form-group">
				<label>Name</label>
				<input type="text" class="form-control" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
			</div>
			
			<div class="form-group">
				<label>Parent Location</label>
						<multiple-selector 
							name="Locations" 
							label="name"
							:items="locations"
							:value='selected.parent_id'
							@change="handleChange" 
							placeholder="Select parent locations"
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