<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'UserCreate',
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
    selected: state => state.Users.selected,
		user: state => state.authUser,
		loading: state => state.Users.loadingItem,

  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('Users', ['fetchOne','persist', 'setProperty', 'attachRelations']),
	fetchItems() {
		this.setProperty({
			property: 'relations',
			value: ['roles']
		})
		this.fetchOne({id: this.id});
	},
  saveUser() {
		if(this.selected.account_type != 1 && !this.roleId) {
			this.$toast.error('Please select default user role');
			return;
		}
		if(this.user.organization_id) {
			this.updateProperty('organization_id', this.user.organization_id)
		}
    this.persist().then(({data}) => {
			if(this.roleId) {
				let payload = {
					id: data.id,
					relationName: 'roles',
					data: this.roleId,
				};
				this.attachRelations(payload);
			}
			this.$toast.success('Successfully added a new service User');
			setTimeout(() => {
				window.location= '/users';
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
			<h4>{{ selected.id ? 'Update': 'Create a' }} Account</h4>
			<form>
				<div class="row">
					<div class="col-6 offset-2">
					
						<div class="form-group">
							<label>Account Type</label>
							<select class="form-control" name="account_type" @change="(e) => updateProperty('account_type',e.target.value)">
								<option value=""></option>
								<option value="1" :selected="selected.account_type == 1">Customer Account</option>
								<option value="3" :selected="selected.account_type == 3"> Admin Account</option>
							</select>
						</div>

						<div v-if="!user.organization_id || selected.account_type != 1" class="form-group">
							<label>Provider</label>
							<remote-selector 
								module="Providers"
								:multiple="false"
								label="name"
								@change="(e) =>updateProperty('organization_id', e)"
							/>
						</div>
							<div class="form-group" v-if="selected.account_type != 1">
								<label>Role</label>
								<remote-selector 
									module="Roles"
									label="title"
									:multiple="true"
									:value="selected.roles"
									@change="(e) => roleId = e"
								/>
							</div>
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label>First Name</label>
									<input class="form-control" type="text" :value="selected.first_name"
									@input="(e) => updateProperty('first_name', e.target.value)">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Last Name</label>
									<input class="form-control" type="text" :value="selected.last_name"
									@input="(e) => updateProperty('last_name', e.target.value)">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label>Email</label>
							<input class="form-control" :value="selected.email" type="email" @input="(e) => updateProperty('email', e.target.value)">
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input class="form-control" :value="selected.phone" type="tel" @input="(e) => updateProperty('phone', e.target.value)">
						</div>

						<div class="form-group">
							<label>Gender</label>
							<select class="form-control" :value="selected.gender_id" @change="(e) => updateProperty('gender_id',e.target.value)">
								<option></option>
								<option value="1" :selected="selected.gender_id == 1">Male</option>
								<option value="2" :selected="selected.gender_id == 2">Female</option>
							</select>
						</div>
					</div>
					<div class="col-6 offset-2 d-flex justify-content-end">
						<div v-if="loading">
							<button v-loading="loading" type="button" class="btn btn-sm  text-white float-end"></button>
						</div>
						<button v-else  class="btn btn-primary" @click.prevent="saveUser">{{ selected.id ? 'Update': 'Create' }}</button>
					</div>
				</div>
			</form>
		</div>
  </div>
</template>
<style>

</style>