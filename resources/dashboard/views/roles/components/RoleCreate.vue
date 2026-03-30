<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors';

export default {
name: 'RoleCreate',
props: {
	id: {
		type: Number,
		required: false,
	}
},
mixins: [
  updateProperty,
],
data() {
	return {
		selectedItems: [],
		schoolUserExcepts: ['app', 'contact_us','plans', 'providers', 'schools', 'top_up'],
	}
},
computed: {
  ...mapState({
		selected: state => state.Roles.selected,
		permissions: state => state.Roles.permissions,
    selectedPermissions: state => state.Roles.selectedPermissions,
		user: state => state.authUser,
  }),
	exemptPermissions() {
		return !this.user.organization_id ? [] : this.schoolUserExcepts;
	}
},
created() {
	this.fetchItems();
},
methods: {
  ...mapActions('Roles', ['fetchOne', 'setProperty', 'persist', 'resetSelected', 'fetchPermissions']),

		fetchItems() {
      this.fetchPermissions().then(response => {
        this.setProperty({ property: 'permissions', value: response});
      });

			if(this.id) {
				this.fetchOne({id: this.id});
			}
		},
    isSelected(key,index) {
			if(this.selected.permissions && this.selected.permissions[key] && this.selected.permissions[key][index]){
				return true;
			}
			return false;
		},
		updatePermission(key, index) {
			if(this.selected.permissions[key]){
					let addPermission = true;
					Object.keys(this.selected.permissions[key]).forEach((item) => {
							if(item == index){
									let permissions =  this.selected.permissions[key];
									delete(permissions[index]);
									this.setProperty({
										property: 'selected',
										subProperty: 'permissions',
										value: { 
											...this.selected.permissions, 
											[key]: {...permissions},
										}
									});
								addPermission = false;
							}
					});

					if( addPermission){
						this.setProperty({
							property: 'selected',
							subProperty: 'permissions',
							value: { 
								...this.selected.permissions, 
								[key]: {...this.selected.permissions[key], [index]: true},
							}
						});
					}
				return;
			}
			if(!this.selected.permissions[key]){
				this.setProperty({
					property: 'selected',
					subProperty: 'permissions',
					value: { ...this.selected.permissions, [key]: {[index]: true} },
				});
				return;
			}
		},
		createRole() {
			
      this.persist().then(() => {
				this.$toast.success('Role added successfully');
				setTimeout(() => {
					window.location= '/roles';
				},200);
      }).catch(({response}) => {
				catchValidationErrors(this, response);
      });
    },
	}
};
</script>
<template>
  <div class="card">
		<div class="card-body">
			<h4>Add Role</h4>

			<form>
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label>Title</label>
							<input class="form-control" type="text" :value="selected.title" @input="(e) => updateProperty('title', e.target.value)">
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control" @input="(e) => updateProperty('description', e.target.value)">{{selected.description}}</textarea>
						</div>

						<hr/>

						<div v-if="permissions" class="my-4"> 
							<div v-for="(modules , key) in permissions" :key="key">
								<div v-if="!exemptPermissions.includes(key)" class="shadow-md border p-2 m-1">
									<h4 class="fs-20">{{$t.t(`permissions.${key}`)}}</h4>
									<div class="d-flex">
										<div class="my-2 me-4" v-for="(permission, index) in modules" :key="index">
											<input type="checkbox" :checked="isSelected(key,index)" @change="() => updatePermission(key,index)"/>
												{{$t.t(`permissions.${index}`)}}
										</div>
									</div>
								</div>
							</div>

  </div>
					</div>
					
			<div class="col-12 d-flex justify-content-end">
				<button class="btn btn-primary" @click.prevent="createRole">{{selected.id ? 'Update Role':'Create'}}</button>
			</div>
			</div>
			</form>
		</div>
  </div>
</template>
<style>

</style>