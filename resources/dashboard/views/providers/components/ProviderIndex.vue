<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ProviderFilter from './ProviderFilter.vue';

export default {
  name: 'ProviderIndex',
  components: {
    ProviderFilter,
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      providers: state => state.Providers.items,
      loading: state => state.Providers.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Providers',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),
    fetchItems() {
      this.setProperty({property: 'sorts', value: ['-id']})
      this.setProperty({
        property: 'relations',
        value: ['organization', 'profile.attachments.media', 'user'],
      });
      this.fetchAll();
    },
    deleteprovider(user) {
      this.$confirm().then(() => {
        this.destroy(user.id).then(() => {
         			this.$toast.success('Provider deleted Successfully');
        });
      })
    },
    changeproviderStatus(user) {
      let newUser = {...user, status: user.status !== 1 ? 1: null}
      if(newUser.status == null) {
        newUser = {...newUser, published: 0 }
      }
      this.setSelected(newUser);
      this.$confirm().then(() => {
        this.persist().then(() => {
          this.fetchItems();
         	this.$toast.success('Success');
        }).catch(({response}) => {
          catchValidationErrors(this, response);
        });
      });
    },
    handleProviderPublication(user) {
    let newUser = {...user, published: user.published !== 1 ? 1: 0}
      this.setSelected(newUser);
      this.$confirm().then(() => {
        this.persist().then(() => {
          this.fetchItems();
         	this.$toast.success('Success');
        }).catch(({response}) => {
          catchValidationErrors(this, response);
        });
      });
    }
  }
};
</script>
<template>
  <div>
    <provider-filter />
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Wallet</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Rating</th>
                <th>Short Description</th>
                <th>Published</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="provider in providers" :key="provider.id">
                <td>{{provider.id}}</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div v-if="provider.profile && provider.profile.attachments && provider.profile.attachments.length > 0 && provider.profile.attachments[0].media">
                      <img class="rounded-circle" :src="`${provider.profile.attachments[0].media.url}`" width="80" height="80" />
                    </div>
                    <div>
                      <b class="ms-1">{{provider.first_name}} {{provider.last_name}}</b> <br/>
                      <star-rating :rating="provider.rating" :star-size=16 read-only :show-rating='false'/>
                      <a :href="`/stylists/${provider.slug}/profile`" target="_bla">View profile</a>
                    </div>
                  </div>
                </td>
                <td>
                  <span v-if="provider.user">
                    {{ provider.user.wallet }}
                  </span>
                </td>
                <td>{{provider.email}}</td>
                <td>{{provider.phone}}</td>
                <td>{{provider.rating}}</td>
                <td>{{provider.short_description}}</td>
                <td>
                  <span v-if="provider.published == 1" class="badge bg-success">Published</span>
                  <span v-else class="badge bg-danger">Un published</span>
                </td>
                <td>
                  <span v-if="provider.status == 1" class="badge bg-success">Active</span>
                  <span v-else class="badge bg-danger">InActive</span>
                </td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${provider.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${provider.id}`">
                      <a v-if="canUserAccess('providers.update')" class="dropdown-item" :href="`/providers/${provider.id}`">Profile</a>
                      <a v-if="canUserAccess('providers.update')" class="dropdown-item" :href="`/providers/${provider.id}`">view</a>
                      <a v-if="canUserAccess('providers.update')" class="dropdown-item" :href="`/providers/${provider.id}/edit`">Edit</a>
                      <a v-if="canUserAccess('providers.income')" class="dropdown-item" :href="`/stylist-income/${provider.id}`">Earnings</a>
                      <span v-if="canUserAccess('providers.publish')">
                        <a v-if="provider.published !== 1" class="dropdown-item" href="#" @click="() => handleProviderPublication(provider)">Publish</a>
                        <a v-else class="dropdown-item" href="#" @click="() => handleProviderPublication(provider)">Un Publish</a>
                      </span>
                       <span v-if="canUserAccess('providers.change_status')">
                        <a v-if="provider.status !== 1" class="dropdown-item" href="#" @click="() => changeproviderStatus(provider)">Activate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changeproviderStatus(provider)">Deactivate</a>
                      </span>
                      <a v-if="canUserAccess('providers.delete')" class="dropdown-item" href="#" @click="()=>deleteprovider(provider)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Providers" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>