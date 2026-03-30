<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'DriverCreate',
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
		selectedProfileImage: null,
	};
},
computed: {
  ...mapState({
    selected: state => state.Drivers.selected,
		users: state => state.Users.items,
		user: state => state.authUser,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
	methods: {
  	...mapActions('Drivers', ['fetchOne','persist', 'setProperty', 'attachRelations']),
		fetchItems() {
			this.fetchOne({id: this.id});
		},
		createDriverAccount() {
			if(!this.selected.id) {
				this.updateProperty('status', 1);
			}
			
			this.persist().then(({data}) => {
				this.$toast.success('Successfully added a new service provider');
				setTimeout(() => {
					window.location= '/drivers';
				},500);
			})
			.catch(({response}) => {
				catchValidationErrors(this, response);
			});
		},

		handleExistingAccount(userId) {
			this.updateProperty('user_id', userId);
				let selectedUser =  this.users.filter(item => item.id == userId)[0];
				if(selectedUser){
					this.updateProperty('first_name', selectedUser.first_name);
					this.updateProperty('last_name', selectedUser.last_name);
					this.updateProperty('email', selectedUser.email);
					this.updateProperty('phone', selectedUser.phone);
				}
		}
	}
};
</script>
<template>
  <div class="card">
		<div class="card-body">
			<h4>{{ selected.id ? 'Update': 'Create a' }} Rider</h4>
			<form>
				<div class="row">
					<div class="col-6">
						<div class="row no-gutter">
							<div class="col-12 mb-2">

								<b class="text-warning">Existing User Account</b>
								<remote-selector
									module="Users"
									label="name"
									:multiple="false"
									@change="(id) => handleExistingAccount(id)"
								/>
							</div>

							<div class="col-6">
								<label>First Name</label>
								<input class="form-control" type="text" :value="selected.first_name"
								@input="(e) => updateProperty('first_name', e.target.value)">
							</div>
							<div class="col-6">
								<label>Last Name</label>
								<input class="form-control" type="text" :value="selected.last_name"
								@input="(e) => updateProperty('last_name', e.target.value)">
							</div>
						
						</div>

						<div class="form-group">
							<label>email</label>
							<input class="form-control" :value="selected.email" type="email" @input="(e) => updateProperty('email', e.target.value)">
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input class="form-control" :value="selected.phone" type="tel" @input="(e) => updateProperty('phone', e.target.value)">
						</div>

						<div class="form-group">
							<label>National Id</label>
							<input class="form-control" :value="selected.national_id" type="text" @input="(e) => updateProperty('national_id', e.target.value)">
						</div>

					</div>

					<div class="col-6">

						<div class="form-group">
							<label>Driving Licence</label>
							<input class="form-control" :value="selected.dl_no" type="text" @input="(e) => updateProperty('dl_no', e.target.value)">
						</div>

						<div class="form-group">
							<label>DL Expiry Date</label>
							<date-picker
									input-class="form-control"
									:value="selected.dl_expiry_date"
              		format="yyyy-MM-dd" 			
									@selected="(e) => updateProperty('dl_expiry_date', e)"
								/>
						</div>

						<div class="form-group">
							<label>Driver Description</label>
							<textarea class="form-control" @input="(e) => updateProperty('description', e.target.value)">{{selected.description}}</textarea>
						</div>

						<div class="form-group">
							<label>Address</label>
							<textarea class="form-control" @input="(e) => updateProperty('address', e.target.value)">{{selected.address}}</textarea>
						</div>
					</div>
					<div class="col-6 offset-2 d-flex justify-content-end">
						<button class="btn btn-primary" type="button" @click.prevent="createDriverAccount">{{ selected.id ? 'Update': 'Create' }}</button>
					</div>
				</div>
			</form>
		</div>

  </div>
</template>
<style>

</style>