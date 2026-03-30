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
		this.updateProperty('account_type', 4);
    this.persist().then(({data}) => {
			this.$toast.success('Successfully added a new service User');
			setTimeout(() => {
				window.location= '/corporates';
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
			<h4>{{ selected.id ? 'Update': 'Create a' }} Corporate Account</h4>
			<form>
				<div class="row">
					<div class="col-6 offset-2">
						<div class="form-group">
							<label>Organisation Names</label>
							<input class="form-control" :value="selected.organization_name" type="text" @input="(e) => updateProperty('organization_name', e.target.value)">
						</div>
							<div class="form-group">
							<label>Address</label>
							<textarea class="form-control" @input="(e) => updateProperty('address', e.target.value)">{{ selected.address }}</textarea>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input class="form-control" :value="selected.email" type="email" @input="(e) => updateProperty('email', e.target.value)">
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input class="form-control" :value="selected.phone" type="tel" @input="(e) => updateProperty('phone', e.target.value)">
						</div>
					</div>
					<div class="col-6 offset-2 d-flex justify-content-end">
						<button class="btn btn-primary" @click.prevent="saveUser">{{ selected.id ? 'Update': 'Create' }}</button>
					</div>
				</div>
			</form>
		</div>
  </div>
</template>
<style>

</style>