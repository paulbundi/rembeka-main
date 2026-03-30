<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'UnitMeasureCreate',
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
    selected: state => state.UnitMeasures.selected,
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
  ...mapActions('UnitMeasures', ['fetchOne','persist', 'setProperty', 'attachRelations']),
	fetchItems() {
		this.fetchOne({id: this.id});
	},
  saveUnitOfMeasure() {
    this.persist().then(({data}) => {
			this.$toast.success('Success');
			window.location = '/unit-measures'
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
			<h4>{{ selected.id ? 'Update': 'Create a' }} Unit Measure</h4>
			<form>
				<div class="row">
					<div class="col-8 offset-2">
						<div class="form-group">
							<label>Name</label>
							<input class="form-control" type="text" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
						</div>

					</div>
					<div class="col-8 offset-2 d-flex justify-content-end">
						<button class="btn btn-primary" @click.prevent="saveUnitOfMeasure">{{ selected.id ? 'Update': 'Create' }}</button>
					</div>
				</div>
			</form>
		</div>
  </div>
</template>
<style>

</style>