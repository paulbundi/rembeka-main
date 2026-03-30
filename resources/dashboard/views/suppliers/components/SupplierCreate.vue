<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'SupplierCreate',
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
    selected: state => state.Suppliers.selected,
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
  	...mapActions('Suppliers', ['fetchOne','persist', 'setProperty', 'attachRelations']),
		fetchItems() {
			this.fetchOne({id: this.id});
		},
		saveSupplier() {
			if(!this.selected.id) {
				this.updateProperty('status', 1);
			}
			
			this.persist().then(({data}) => {
				this.$toast.success('Successfully added a new service provider');
				setTimeout(() => {
					window.location= '/suppliers';
				},500);
			})
			.catch(({response}) => {
				catchValidationErrors(this, response);
			});
		},
		handleCheck(attachment) {
			this.updateProperty('profile_image', attachment.id);
			this.selectedProfileImage = attachment;
			this.$refs.dismissProfile.click();
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
			<h4>{{ selected.id ? 'Update': 'Create a' }} Supplier</h4>
			<form>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label>Supplier Type</label>
							<select class="form-control" @change="(e) => updateProperty('type', e.target.value)">
								<option value=""></option>
								<option value="1" :selected="selected.type == 1">Individual</option>
								<option value="2" :selected="selected.type == 2">Company</option>
							</select>
						</div>

						<div v-if="selected.type == 2" class="form-group">
							<label>Name</label>
							<input class="form-control" type="text" :value="selected.name"
							 @input="(e) => updateProperty('name', e.target.value)">
						</div>

					<div v-if="selected.type == 1" class="row no-gutter">

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

						<div v-if="selected.type == 1" class="form-group">
							<label>National Id</label>
							<input class="form-control" :value="selected.national_id" type="text" @input="(e) => updateProperty('national_id', e.target.value)">
						</div>
					
					</div>
					<div class="col-6">

						<div class="form-group">
							<label>Kra Pin</label>
							<input class="form-control" :value="selected.kra_pin" type="text" @input="(e) => updateProperty('kra_pin', e.target.value)">
						</div>

						<div class="form-group">
							<label>Supplier Description</label>
							<textarea class="form-control" @input="(e) => updateProperty('description', e.target.value)">{{selected.description}}</textarea>
						</div>

						<div class="form-group">
							<label>Address</label>
							<textarea class="form-control" @input="(e) => updateProperty('address', e.target.value)">{{selected.address}}</textarea>
						</div>
					</div>
					<div class="col-6 offset-2 d-flex justify-content-end">
						<button class="btn btn-primary" type="button" @click.prevent="saveSupplier">{{ selected.id ? 'Update': 'Create' }}</button>
					</div>
				</div>
			</form>
		</div>


		<!-- Modal -->
		<div class="modal fade" id="providerProfile" ref="providerProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ref="dismissProfile"></button>
					</div>
					<div class="modal-body">
						<media-index @attach='handleCheck' hide-upload selectable single-item/>
					</div>
				</div>
			</div>
		</div>

  </div>
</template>
<style>

</style>