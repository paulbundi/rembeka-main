<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'CouponCreate',
props: {
	id: {
		type: Number,
		default: null,
	}
},
components: { 
	RemoteSelector,
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
    selected: state => state.AgeGroups.selected,
		user: state => state.authUser,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('AgeGroups', ['fetchOne','persist', 'setProperty', 'attachRelations']),
	fetchItems() {
		this.fetchOne({id: this.id});
	},
  saveGroup() {
    this.persist().then(({data}) => {
			this.$toast.success('Successfully added a new service User');
			setTimeout(() => {
				window.location= '/age-groups';
			},500);
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
			<h4>{{ selected.id ? 'Update': 'Create a' }} Age Group</h4>
			<form>
				<div class="row">
					<div class="col-6 offset-2">
						<div class="form-group">
							<label>Age Group</label>
							<input class="form-control" type="text" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control" type="desciption" @input="(e) => updateProperty('description', e.target.value)">{{ selected.desciption }}</textarea>
						</div>

						<div class="form-group">
							<input type="checkbox" 
								name="show_on_menu"
								value="1"
								:checked="selected.show_on_menu == 1"
								@input="(e) => updateProperty('show_on_menu', e.target.value)"
							>
							<label>Show on the menu.</label>
						</div>

						<div class="form-group">
							<label>Menu Name</label>
							<input class="form-control" type="text" :value="selected.menu_name" @input="(e) => updateProperty('menu_name', e.target.value)">
						</div>

					</div>
					<div class="col-6 offset-2 d-flex justify-content-end">
						<button class="btn btn-primary" @click.prevent="saveGroup">{{ selected.id ? 'Update': 'Create' }}</button>
					</div>
				</div>
			</form>
		</div>
  </div>
</template>
<style>

</style>