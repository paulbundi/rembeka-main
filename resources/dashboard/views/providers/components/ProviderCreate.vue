<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'ProviderCreate',
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
    selected: state => state.Providers.selected,
		user: state => state.authUser,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
	methods: {
  	...mapActions('Providers', ['fetchOne','persist', 'setProperty', 'attachRelations']),
		fetchItems() {
			this.setProperty({
					property: 'relations',
					value: ['profile.attachments.media', 'productPricings', 'locations']
			});
			this.fetchOne({id: this.id});
		},
		saveProvider() {
			this.persist().then(({data}) => {
				this.$toast.success('Successfully added a new service provider');
				setTimeout(() => {
					window.location= '/providers';
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
		handleProviderStyles(element) {
			// console.log(element, 'test data');
		}
	}
};
</script>
<template>
  <div class="card">
		<div class="card-body">
			<h4>{{ selected.id ? 'Update': 'Create a' }} Provider</h4>
			<form>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label>First Name</label>
							<input class="form-control" type="text" :value="selected.first_name"
							 @input="(e) => updateProperty('first_name', e.target.value)">
						</div>
						<div class="form-group">
							<label>Last Name</label>
							<input class="form-control" type="text" :value="selected.last_name"
							 @input="(e) => updateProperty('last_name', e.target.value)">
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
						
						<div class="form-group">
							<label>Kra Pin</label>
							<input class="form-control" :value="selected.kra_pin" type="text" @input="(e) => updateProperty('kra_pin', e.target.value)">
						</div>

						<div class="form-group">
							<label>Select Zone/ Location</label><br/>
							<remote-selector 
								module="Locations"
								@change="(e) => updateProperty('location_id',e)"
								:value="selected.locations"
							/>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label>Address</label>
							<textarea class="form-control" @input="(e) => updateProperty('address', e.target.value)">{{selected.address}}</textarea>
						</div>

						<div class="form-group">
							<label>Services</label>
							<remote-selector 
								module="Services"
								:multiple='true'
								@change="(services) => updateProperty('provider_styles', services)"
								label="name"
							/>
						</div>

						<div class="form-group">
							<label>Short Description</label>
							Hi, 1`m :name, I am a hair stylist & braider
							<textarea name="short_description"
								class="form-control"
							 	@input="(e) => updateProperty('short_description', e.target.value)"
							>{{selected.short_description}}</textarea>
						</div>

						<div class="form-group">
							<label>Work Experince</label>
							<textarea name="works_experience"
								class="form-control"
							 	@input="(e) => updateProperty('works_experience', e.target.value)"
							>{{selected.works_experience}}</textarea>
						</div>

						<div class="form-group">
							<label>Professional Qualifications</label>
							<textarea name="professional_qualifications"
								class="form-control"
							 @input="(e) => updateProperty('professional_qualifications', e.target.value)"
							>{{selected.professional_qualifications}}</textarea>
						</div>
						<div class="form-group">
							<div v-if="selected.profile">

							</div>
							<div v-if="selected.profile_image">
								<div class="d-flex">
                  <img class="rounded" :src="`${selectedProfileImage.url}`" width="80" height="80" />
									<div>
										<button class="btn" type="button" @click.prevent="() => updateProperty('profile_image', null)">
											<i class="bi bi-trash"></i>
										</button>
									</div>
								</div>
							</div>
							<button v-else type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#providerProfile">
								Select Provider Profile Image
							</button>
						</div>
					</div>
					<div class="col-6 offset-2 d-flex justify-content-end">
						<button class="btn btn-primary" type="button" @click.prevent="saveProvider">{{ selected.id ? 'Update': 'Create' }}</button>
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