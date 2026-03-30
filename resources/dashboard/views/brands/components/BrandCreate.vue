<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'BrandCreate',
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
    selected: state => state.Brands.selected,
		user: state => state.authUser,
  }),
},
watch: {
		id() {
			this.fetchItems();
		}
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('Brands', ['fetchOne','persist', 'setProperty', 'attachRelations']),
	fetchItems() {
		this.fetchOne({id: this.id});
	},
  saveBrand() {
    this.persist().then(({data}) => {
			this.$toast.success('Success');
			window.location = '/brands'
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
			<h4>{{ selected.id ? 'Update': 'Create a' }} Brand</h4>
			<form>
				<div class="row">
					<div class="col-8 offset-2">
						<div class="form-group">
							<label>Name</label>
							<input class="form-control" type="text" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control" type="desciption" @input="(e) => updateProperty('description', e.target.value)" >{{ selected.description }}</textarea>
						</div>

					</div>
					<div class="col-8 offset-2 d-flex justify-content-end">
						<button class="btn btn-primary" @click.prevent="saveBrand">{{ selected.id ? 'Update': 'Create' }}</button>
					</div>
				</div>
			</form>
		</div>
  </div>
</template>
<style>

</style>