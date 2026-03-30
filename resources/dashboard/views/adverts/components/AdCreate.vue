<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'

export default {
name: 'BrandCreate',
props: {
	id: {
		type: Number,
		default: null,
	}
},
mixins: [
  updateProperty,
],
data() {
	return {
		roleId: null,
		selectedBannerImage: null,

	};
},
computed: {
  ...mapState({
    selected: state => state.Adverts.selected,
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
  ...mapActions('Adverts', ['fetchOne','persist', 'setProperty', 'attachRelations']),
	fetchItems() {
		this.fetchOne({id: this.id});
	},
  handleSaveAd() {
    this.persist().then(({data}) => {
			this.$toast.success('Success');
			window.location = '/ads'
    })
		.catch(({response}) => {
      catchValidationErrors(this, response);
    });

  },
	handleCheck(attachment) {
		this.updateProperty('banner_image', attachment.id);
		this.selectedBannerImage = attachment;
		this.$refs.dismissModal.click();
	},
}
}
</script>
<template>
  <div class="card">
		<div class="card-body">
			<h4>{{ selected.id ? 'Update': 'Create a' }} Ad</h4>
			<form>
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label>Name</label>
							<input class="form-control" type="text" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
						</div>
						
						<div class="form-group">
							<label>Call To Action URL</label>
							<input class="form-control" type="text" :value="selected.call_to_action_url" @input="(e) => updateProperty('call_to_action_url', e.target.value)">
						</div>

						<div class="form-group">
							<label>Call To Action Message</label>
							<input class="form-control" type="text" :value="selected.call_to_action" @input="(e) => updateProperty('call_to_action', e.target.value)">
						</div>
						<div class="form-group">
							<label>Advert Type</label>
							<select class="form-control" @change="(e)=>updateProperty('type', e.target.value)">
								<option value="1" :selected="selected.type == 1">Launch Screen Modal</option>
								<option value="2" :selected="selected.type ==2">Scavenger Hunt</option>
							</select>
						</div>
						<div class="form-group">
							<label>Associated Product</label>
							<remote-selector 
								module="Merchandise"
								:multiple='false'
								@change="(e)=>updateProperty('product_id', e)"
								label="name"
							/>
						</div>
						<div class="form-group">
							<div v-if="selected.banner_image">
								<div class="d-flex">
                  <img class="rounded" :src="`${selectedBannerImage.url}`" width="80" height="80" />
									<div>
										<button class="btn" type="button" @click.prevent="() => updateProperty('banner_image', null)">
											<i class="bi bi-trash"></i>
										</button>
									</div>
								</div>
							</div>
							<button v-else type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ads-image">
								Select Advert Banner
							</button>
						</div>
					</div>
					<div class="col-8 offset-2 d-flex justify-content-end">
						<button class="btn btn-primary" @click.prevent="handleSaveAd">{{ selected.id ? 'Update': 'Create' }}</button>
					</div>
				</div>
			</form>
		</div>


		<!-- Modal -->
		<div class="modal fade" id="ads-image" ref="ads-image" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ref="dismissModal"></button>
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