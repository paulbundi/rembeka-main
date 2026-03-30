<script>
import { mapActions, mapState } from 'vuex';
import updateProperty from '../../../mixins/updateProperty';

  export default {
    name: 'CorporateMembersCreate',
    mixins: [
      updateProperty,
    ],
    data() {
      return {
        loading: false,
      }
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
    ...mapActions('CorporateUsers', {addToCorporate: 'persist', setCorporateUserProperty: 'setProperty' }),

    saveUser() {
      this.updateProperty('account_type', 1);
      this.loading = true;
      this.persist().then(({data}) => {
        this.setCorporateUserProperty({
          property: 'selected',
          subProperty: 'corporate_id',
          value: this.user.id,
        });
        this.setCorporateUserProperty({
          property: 'selected',
          subProperty: 'user_id',
          value: data.id,
        });

        this.addToCorporate().then(() => {
          this.$toast.success('Successfully');
          setTimeout(() => {
            window.location= '/members';
          },500);
        });
      })
        .catch(({response}) => {
          catchValidationErrors(this, response);
      }).finally( () =>{
        this.loading = false;
      });
    },
  }
};
</script>
<template>
  <div>
    <div class="card">
		<div class="card-body">
			<h4>{{ selected.id ? 'Update': 'Create a' }} Member</h4>
			<form>
				<div class="row">
					<div class="col-6 offset-2">
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label>First Name</label>
									<input class="form-control" type="text" :value="selected.first_name"
									@input="(e) => updateProperty('first_name', e.target.value)">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Last Name</label>
									<input class="form-control" type="text" :value="selected.last_name"
									@input="(e) => updateProperty('last_name', e.target.value)">
								</div>
							</div>
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
						<div v-if="loading">
							<button v-loading="loading" type="button" class="btn btn-sm  text-white float-end"></button>
						</div>
						<button v-else  class="btn btn-primary" @click.prevent="saveUser">{{ selected.id ? 'Update': 'Create' }}</button>
					</div>
				</div>
			</form>
		</div>
  </div>
  </div>
</template>
<style lang="scss" scoped>

</style>