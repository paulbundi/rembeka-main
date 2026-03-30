<script>
import {mapState, mapActions} from 'vuex';
import InputFilter from '../../generals/InputFilter.vue';
import RemoteSelector from '../../generals/RemoteSelector.vue';

export default {
  name: 'RoleShow',
  components: {
    InputFilter,
    RemoteSelector,
  },
  props: {
    id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      userId: null,
    }
  },
  computed: {
    ...mapState({
      selected: state => state.Roles.selected,
      loading: state => state.Roles.loadingItems,
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('Roles',['fetchOne', 'destroy', 'setProperty','attachRelations', 'detachRelations']),
    ...mapActions('Users',{ setUserProperty: 'setProperty'}),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['users']
      })
      this.fetchOne({id: this.id});
      this.setUserProperty({
        property: 'hideAccessToWeb',
        value: false,
      });
    },
    removeUserFromRole(user) {
      	let payload = {
				id: this.selected.id,
				relation: 'users',
				data: [user.id],
			};
      this.$confirm().then(() => {
        this.detachRelations(payload).then(({response}) => {
            this.$toast.success('success');
            this.fetchItems();
          }).catch(({response}) => {
          catchValidationErrors(this, response);
        });
      });
    },
    addUsertoRole() {
      if (!this.userId || this.userId.length == 0) {
        this.$toast.error('Please select a user to add');
        return;
      }
      let payload = {
        id: this.id,
        relationName: 'users',
        data: this.userId,
      };

      this.attachRelations(payload).then(() => {
        this.$toast.success('User added to the role succcessfully');
        this.fetchItems();
      }).catch(({response}) => {
        catchValidationErrors(this, response);
      });
    }
  }
};
</script>
<template>
  <div>
    <div class="card">
      <div class="card-body">
        Title: <b>{{ selected.title }}</b><br/>
        <span v-if="selected.school">
          School: {{selected.school.name}}
        </span>
        <p class="mt-2">Description: {{ selected.description }}</p>
      </div>
    </div>
    <div class="row">
      <div class="col-8">
        <div class="card">
          <div class="card-body">
            <h4>Role Users</h4>
            <div v-loading="loading" class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Descriptions</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in selected.users" :key="user.id">
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>
                      <button class="btn btn-sm btn-danger" @click="() => removeUserFromRole(user)">Revome</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-4 card">
        <div class="card-body">
          <label>Add role user</label>
          <remote-selector 
            module='Users' 
            @change="(value) => userId = value"
          />
          <div class="form-group float-end">
            <button class="btn btn-sm btn-success" @click="addUsertoRole">add</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>

</style>