<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'ProviderEdit',
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
		profile: state => state.ProviderProfiles.selected,
		user: state => state.authUser,
  }),
	assignedLocations() {
		if(this.selected.locations.length < 2){
			return this.selected.locations[0];
		}
		return this.selected.locations;
	}
},
created() {
	if (this.id) {
		this.fetchItems();
	}
	this.setMenuProperty({
		property: 'parentOnly',
		value: true,
	});
},
	methods: {
  	...mapActions('Providers', ['fetchOne','persist', 'setProperty', 'attachRelations', 'setSelected', 'detachRelations']),
  	...mapActions('ProviderPricings', ['destroy']),
		...mapActions('ProviderProfiles',{setProfileProperty: 'setProperty', saveProfile: 'persist', setSelectedProfile: 'setSelected', detachProfile: 'detachRelations'}),
		...mapActions('Menus', {setMenuProperty: 'setProperty'}),
		fetchItems() {
			this.setProperty({
					property: 'relations',
					value: ['profile.attachments.media', 'productPricings.product', 'locations']
			});
			this.fetchOne({id: this.id}).then(() => {
				this.setSelectedProfile(this.selected.profile);
			});
		},
		updateProfileProperty(key, value) {
			let profile = this.profile;
			profile[key] = value;
			this.setSelectedProfile(profile);
		},
		saveProvider() {
			this.persist().then(({data}) => {
				this.saveProfile();
				this.$toast.success('Successfully added a new service provider');
				setTimeout(() => {
					window.location= `/providers/${this.id}/edit`;
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
			console.log(element, 'test data');
		},
		detachAttachment() {
			this.updateProperty('profile_image', null);
			this.selectedProfileImage = null;
		},
		removeProfilePicture(attachmentId) {
			let payload = {
					id: this.profile.id,
					relation: 'attachments',
					data: [attachmentId],
				};
			this.detachProfile(payload).then(() => {
				this.fetchItems();
				this.$toast.success('Profile picture removed successfully');
			});
		},
		handleRemoveService(providerPricing) {
       this.$confirm().then(() => {
				let productPricing = this.selected.product_pricings;

        this.destroy(providerPricing.id).then(() => {
					let servicesOffered = productPricing.filter((item) => item.id !== providerPricing.id);
					let selectedItem = {
						...this.selected,
						product_pricings: servicesOffered
					};

					this.setSelected(selectedItem);

         	this.$toast.success('Service removed');
        });
      })
		},
		handleRemoveLocation(location) {
       this.$confirm().then(() => {
				let locations = this.selected.locations;
				let payload = {
					id: this.selected.id,
					relation: 'locations',
					data: [location.id],
				};
			this.detachRelations(payload).then(({response}) => {
					let assignedLocations = locations.filter((item) => item.id !== location.id);
					let selectedItem = {
						...this.selected,
						locations: assignedLocations
					};

					this.setSelected(selectedItem);

         	this.$toast.success('Service removed');
        });
      })
		}
	}
};
</script>
<template>
  <div class="card">
		<div v-if="selected.profile" class="card-body">
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
								@change="(e) => updateProperty('loca',e)"
								label="name"
							/>
						</div>

							<span v-for="location in selected.locations"
								class="badge badge-sm bg-success text-white me-1"
							>
									{{ location.name }}
								<span class="cursor-pointer" @click="() => handleRemoveLocation(location)">
									<i class="bi bi-x-lg"></i>
								</span>
							</span>
						<div class="form-group">
							<label>Address</label>
							<textarea class="form-control" @input="(e) => updateProperty('address', e.target.value)">{{ selected.address }}</textarea>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="Assign By">Assign By</label>
							<select class="form-control" @change="(e) =>updateProperty('assign_service_by', e.target.value)">
								<option vlaue="2">Individual Service</option>
								<option value="1">Product Menu(Catalog Main menu)</option>
							</select>
						</div>
						<div class="form-group">

							<div v-if="selected.assign_service_by == 1">
								<label>Main Menu</label>
								<remote-selector 
									module="Menus"
									:multiple='true'
									@change="(services) => updateProperty('provider_styles', services)"
									label="name"
								/>
							</div>

							<div v-else>
								<label>Services</label>
								<remote-selector 
									module="Services"
									:multiple='true'
									@change="(services) => updateProperty('provider_styles', services)"
									label="name"
								/>
							</div>

							<span v-for="providerPricing in selected.product_pricings"  v-if="providerPricing.product" class="badge badge-sm bg-success text-white me-1">
								{{providerPricing.product.name}} 
								<span class="cursor-pointer" @click="() => handleRemoveService(providerPricing)">
									<i class="bi bi-x-lg"></i>
								</span>
							</span>
						</div>

						<div class="form-group">
							<label>Short Description</label><br/>
							 Template ( Hi, I`m :name, I am a hair stylist & braider. ) :NB; don`t change :name
							<textarea name="short_description"
								class="form-control"
							 	@input="(e) => updateProperty('short_description', e.target.value)"
							>{{selected.short_description}}</textarea>
						</div>

						<div class="form-group">
							<label>Work Experince</label>
							<textarea name="works_experience"
								class="form-control"
							 	@input="(e) => updateProfileProperty('works_experience', e.target.value)"
							>{{profile.works_experience}}</textarea>
						</div>

						<div class="form-group">
							<label>Professional Qualifications</label>
							<textarea name="professional_qualifications"
								class="form-control"
							 @input="(e) => updateProfileProperty('professional_qualifications', e.target.value)"
							>{{profile.professional_qualifications}}</textarea>
						</div>
						<div class="form-group d-flex">
							<div v-if="selected.profile && selected.profile.attachments && selected.profile.attachments.length > 0  && selected.profile.attachments[0].media ">
                  <img class="rounded" :src="`${selected.profile.attachments[0].media.url}`" width="80" height="80" />
							</div>
							<div>

							<div v-if="selectedProfileImage">
								<div class="d-flex">
                  <img class="rounded" :src="`${selectedProfileImage.url}`" width="80" height="80" />
									<div>
										<button class="btn" type="button" @click.prevent="() => detachAttachment()">
											<i class="bi bi-trash"></i>
										</button>
									</div>
								</div>
							</div>
							<div v-else class="ms-2">
								<button type="button" class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#providerProfile">
									select Profile Picture
								</button>
								<div v-if="selected.profile && selected.profile.attachments && selected.profile.attachments.length > 0  && selected.profile.attachments[0].media">
									<button class="btn btn-sm btn-danger" type="button" @click.prevent="() => removeProfilePicture(selected.profile.attachments[0].id)">
										Remove Picture
									</button>
								</div>
							</div>
							</div>
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