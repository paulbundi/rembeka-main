<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'PartnersCreate',
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
		selectedProfileImage: null,
	};
},
computed: {
  ...mapState({
    selected: state => state.Partners.selected,
		user: state => state.authUser,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('Partners', ['fetchOne','persist', 'setProperty', 'attachRelations']),
	fetchItems() {
		this.setProperty({
			property: 'relations',
			value: ['roles']
		})
		this.fetchOne({id: this.id});
	},
  savePartner() {
    this.updateProperty('user_id', this.user.id);
		//check has partner logo
    this.persist().then(({data}) => {
			if(this.roleId) {
				let payload = {
					id: data.id,
					relationName: 'roles',
					data: this.roleId,
				};
				this.attachRelations(payload);
			}
			this.$toast.success('New Partner added');
			setTimeout(() => {
				window.location= '/partners';
			},500);
    })
		.catch(({response}) => {
      catchValidationErrors(this, response);
    });
  },
	handleCheck(media) {
		this.updateProperty('media_id', media.id);
		this.selectedProfileImage = media;
		this.$refs.dismissProfile.click();
	},
	detachAttachment() {
			this.updateProperty('profile_image', null);
			this.selectedProfileImage = null;
		},
}
}
</script>
<template>
  <div class="card">
		<div class="card-body">
			<h4>{{ selected.id ? 'Update': 'Create a' }} Partner</h4>
			<form>
				<div class="col-8 offset-2">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Name</label>
								<input class="form-control" type="text" :value="selected.name"
								@input="(e) => updateProperty('name', e.target.value)">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" name="description" placeholder="Description" rows="4" @input="(e) => updateProperty('description', e.target.value)">{{selected.description}}</textarea>
							</div>
						</div>

						<div class="col-12">
							<div class="form-group d-flex">
								<div v-if="selected.media && selected.media.length > 0  ">
										<img class="rounded" :src="`${selected.media.url}`" width="80" height="80" />
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
								
								<div v-else>
									<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#providerProfile">
										Select Partner Logo
									</button>
								</div>
							</div>
						</div>
						</div>

						<div class="col-6">
							<button class="btn btn-primary" @click.prevent="savePartner">{{ selected.id ? 'Update': 'Create' }}</button>
						</div>
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