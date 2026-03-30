<script>
import { mapActions, mapState } from 'vuex'
import RemoteSelector from '../../generals/RemoteSelector'
import CreateTab from './product-tabs/createTab.vue';
import Attachments from './product-tabs/attachments.vue';
import catchValidationErrors from '../../../utils/catchValidationErrors'
import ProductPricing from './product-tabs/ProductPricing.vue';

export default {
name: 'ProductsCreate',
props: {
	id: {
		type: Number,
		default: null,
	}
},
components: {
    RemoteSelector,
    CreateTab,
    Attachments,
    ProductPricing
},

data() {
	return {
		roleId: null,
		activeTab: 'product',
	};
},
computed: {
  ...mapState({
    selected: state => state.Products.selected,
		user: state => state.authUser,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('Products', ['fetchOne','persist', 'setProperty', 'attachRelations','detachRelations']),
	fetchItems() {
		this.setProperty({
			property: 'relations',
			value:['attachments.media', 'provider', 'providerPricing', 'category', 'menu', 'ageGroups', 'brand']
		});

		if(this.id) {
			this.fetchOne({id: this.id});
			return;
		}
		if(this.selected.id) {
			this.fetchOne({id: this.id});
		}
	},
	handleAttach(selectedImages) {
		const payload = {
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
	},
	}
};
</script>
<template>
  <div class="card">
		<div class="card-body">
			<h4 class="text-primary text-bold">Product Details</h4>
			<form>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
  				<li class="nav-item" role="presentation">
						<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"
							@click="() => activeTab = 'product'"
						>
							{{ selected.id ? 'Update': 'Create a' }} Product
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" :class="{'disabled':  !selected.id }" id="attachments-tab" data-bs-toggle="tab" data-bs-target="#attachments-tab" type="button" role="tab" aria-controls="images" 
							aria-selected="true" :aria-disabled="{'true':  !selected.id }"
							@click="()=> activeTab = 'attachment'"
						>
							Product Images
						</button>
					</li>
					<li class="nav-item" :class="{'disabled': selected.id}" role="presentation">
						<button class="nav-link" :class="{'disabled':  !selected.id }" id="provider-tab" data-bs-toggle="tab" data-bs-target="#provider-tab" type="button" role="tab" aria-controls="providers" 
							aria-selected="true" :aria-disabled="{'true':  !selected.id }"	@click="() => activeTab = 'provider'">
								Supplier Product Pricing
						</button>
					</li>
				</ul>
				
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show" :class="{'active': activeTab == 'product'}" id="home-tab" role="tabpanel" aria-labelledby="home-tab">
						<create-tab @refresh="handleRefresh"/>
					</div>

					<div class="tab-pane" :class="{'fade show active': activeTab == 'attachment'}" id="attachments-tab" role="tabpanel" aria-labelledby="images">
						<keep-alive>
							<attachments @attach="handleAttach" @detach="handleDetach" />
						</keep-alive>
					</div>
					
					<div class="tab-pane" :class="{'fade show active': activeTab == 'provider'}" id="provider-tab" role="tabpanel" aria-labelledby="contact-tab">
						<product-pricing/>
					</div>
				</div>
			</form>
		</div>
  </div>
</template>
<style>

</style>