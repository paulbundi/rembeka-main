<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'
import RemoteSelector from '../../generals/RemoteSelector'

export default {
name: 'InquiriesCreate',
props: {
	id: {
		type: Number,
		default: null,
	},
	isModal: {
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
	};
},
computed: {
  ...mapState({
    selected: state => state.Inquiries.selected,
		user: state => state.authUser,
		loading: state => state.Inquiries.loadingItem,
  }),
},
created() {
	if (this.id) {
		this.fetchItems();
	}
},
methods: {
  ...mapActions('Inquiries', ['fetchOne','persist', 'setProperty']),
	fetchItems() {
		 this.setProperty({
        property: 'relations',
        value: ['channel', 'product'],
      });
		this.fetchOne({id: this.id});
	},
  createInquiry() {
		if(this.selected.user_id == null) {
			this.updateProperty('user_id', this.user.id);
		}
    this.persist().then(({data}) => {
			this.$toast.success('Inquiry Created Successfully');
			setTimeout(() => {
				if(!this.isModal){
					window.location= '/inquiries';
				}
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
			<h4>{{ selected.id ? 'Update': 'Create a' }} inquiry</h4>
			<form>
				<div class="row">
					<div class="col-6">
						<div class="row">
							<div class="col-6 form-group">
								<label for="f-name">First Name</label>
								<input type="text" class="form-control" :value="selected.first_name" @input="(e) => updateProperty('first_name', e.target.value)">
							</div>
							<div class="col-6 form-group">
								<label for="last-name">Last Name</label>
								<input type="text" class="form-control" :value="selected.last_name" @input="(e) => updateProperty('last_name', e.target.value)">
							</div>
							<div class="form-group">
								<label for="social-name">Social Username</label>
								<input type="text" :value="selected.social_name" class="form-control" @input="(e) => updateProperty('social_name', e.target.value)">
							</div>
						</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" :value="selected.email" class="form-control" @input="(e) => updateProperty('email', e.target.value)">
							</div>
							<div class="form-group">
								<label for="email">Phone</label>
								<input type="tel" class="form-control" :value="selected.phone" @input="(e) => updateProperty('phone', e.target.value)">
							</div>

							<div class="form-group">
								<label for="email">Callback Date</label>
								<date-picker
									input-class="form-control"
									:value="selected.callback_date"
              		format="yyyy-MM-dd" 			
									@selected="(e) => updateProperty('callback_date', e)"
								/>
							</div>

							<div class="form-group">
								<label for="email">Assigned User</label>
								<remote-selector
									module="Users"
									:value="selected.user?selected.user: user"
									:multiple="false"
									label="name"
									@change="(value) => updateProperty('assigned_id', value)"
								/>
							</div>

						</div>

						<div class="col-6">
							<div class="form-group">
								<label>Channel</label>
								<remote-selector 
									module="Channels"
									:value="selected.channel"
									:multiple="false"
									label="name"
									@change="(value) => updateProperty('channel_id', value)"
								/>
							</div>

							<div class="form-group">
								<label>Service/Product</label>
								<remote-selector 
									module="ProductsServices"
									:value="selected.product"
									:multiple="false"
									label="name"
									@change="(value) => updateProperty('product_id', value)"
								/>
							</div>

						<div class="form-group">
							<label>Description</label><br/>
							<small class="text-info">Add link to request product</small>
							<textarea class="form-control" rows="6" @input="(e)=>updateProperty('description',e.target.value)">{{ selected.description }}</textarea>
						</div>
						</div>

					<div class="col-12 d-flex justify-content-end">
						<div v-if="loading">
							<button v-loading="loading" class="btn btn-sm  text-white float-end"></button>
						</div>
						<button v-else  class="btn btn-primary" @click.prevent="createInquiry">{{ selected.id ? 'Update': 'Create' }}</button>
					</div>
				</div>
			</form>
		</div>
  </div>
</template>
<style>

</style>