<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
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
    selected: state => state.Orders.selected,
		user: state => state.authUser,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('Orders', ['fetchOne','persist', 'setProperty', 'attachRelations']),
	fetchItems() {
		this.fetchOne({id: this.id});
	},
  saveUser() {

		if(!this.roleId) {
			this.$toast.error('Please select default user role');
			return;
		}
		if(this.user.organization_id) {
			this.updateProperty('organization_id', this.user.organization_id)
		}

		if(!this.selected.organization_id) {
			this.$toast.error('The school field is required');
			return;
		}

    this.persist().then(({data}) => {
			let payload = {
				id: data.id,
				relationName: 'roles',
				data: this.roleId,
			};
			this.attachRelations(payload);
			this.$toast.success('Successfully added a new service User');
			setTimeout(() => {
				window.location= '/orders';
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
			<h4>{{ selected.id ? 'Update': 'Create a' }} User</h4>
			<form>
				<div class="row">
					<div class="col-6 offset-2">
						<div v-if="!user.organization_id" class="form-group">
							<label>School</label>
							<remote-selector 
								module="Schools"
								:multiple="false" 
								@change="(e) => updateProperty('organization_id',e) "
							/>
						</div>
							<div class="form-group">
							<label>Role</label>
							<remote-selector 
								module="Roles"
								:multiple="false"
								label="title"
								@change="(e) => roleId = e"
							/>
						</div>
						<div class="form-group">
							<label>Names</label>
							<input class="form-control" type="text" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
						</div>
						<div class="form-group">
							<label>Organization</label>
							<input class="form-control" :value="selected.email" type="email" @input="(e) => updateProperty('email', e.target.value)">
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input class="form-control" :value="selected.phone" type="tel" @input="(e) => updateProperty('phone', e.target.value)">
						</div>
					</div>
					<div class="col-6 offset-2 d-flex justify-content-end">
						<button class="btn btn-primary" @click.prevent="saveUser">{{ selected.id ? 'Update': 'Create' }}</button>
					</div>
				</div>
			</form>
		</div>
  </div>
</template>
<style>

</style>