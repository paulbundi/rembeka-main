<script>
import { mapActions, mapState } from 'vuex'
import RemoteSelector from '../../generals/RemoteSelector'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import updateProperty from '../../../mixins/updateProperty';


export default {
name: 'BestSellersCreate',
props: {
	id: {
		type: Number,
		default: null,
	},
	actions: {
		type: Boolean,
		default: false,
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
		activeTab: 'product',
	};
},
computed: {
  ...mapState({
    selected: state => state.BestSellers.selected,
		user: state => state.authUser,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('BestSellers', ['fetchOne','persist', 'setProperty', 'attachRelations','detachRelations']),
	fetchItems() {
		this.setProperty({
			property: 'relations',
			value:['attachments.media', 'provider', 'providerPricing', 'category', 'menu']
		})
		if(this.id) {
			this.fetchOne({id: this.id});
			return;
		}
		if(this.selected.id) {
			this.fetchOne({id: this.id});
		}
	},
	handleAttach(selectedImages) {
		let payload = {
			id: this.selected.id,
			relation: 'attachments',
			data: selectedImages,
		};
		this.attachRelations(payload).then(({response}) => {
        this.$toast.success('success');
				this.fetchItems();
			}).catch(({response}) => {
			catchValidationErrors(this, response);
		})
	},
	handleDetach(attachmentId) {
		let payload = {
				id: this.selected.id,
				relation: 'attachments',
				data: [attachmentId],
			};
			this.detachRelations(payload).then(({response}) => {
					this.$toast.success('success');
					this.fetchItems();
				}).catch(({response}) => {
				catchValidationErrors(this, response);
			})
	},
	handleRefresh(product) {
		this.fetchOne({id: product.id});
	}
	}
};
</script>
<template>
  <div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-12">

					<div class="form-group">
						<label>Product</label>
						<remote-selector 
							module="Products"
							label="name"
							@change="(value) =>  updateProperty('provider_pricing_id', value)" 
							:multiple='false'
						/>
					</div>

					<div v-if="!actions" class="form-group">
						<button class="btn btn-sm btn-success" @click="handleAddProducts"> Add Product </button>
					</div>

				</div>
			</div>
		</div>
  </div>
</template>
<style>

</style>