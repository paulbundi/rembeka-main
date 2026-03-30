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
    selected: state => state.Channels.selected,
    channel: state => state.Channels.items,
		user: state => state.authUser,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('Channels', ['fetchAll','fetchOne','persist', 'setProperty', 'resetSelected']),
    handleSave() {
      this.persist().then(() => {
        this.fetchAll();
        this.$toast.success('Success');
				this.resetSelected();
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
				<label>Name</label>
				<input type="text" class="form-control" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
			</div>
			
			<div class="form-group">
				<label>Description</label>
				<input type="text" class="form-control" :value="selected.description" @input="(e) => updateProperty('description', e.target.value)">
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