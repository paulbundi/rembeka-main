<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';

export default {
  name: 'NewsLetterIndex',
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      items: state => state.NewsLetters.items,
      loading: state => state.NewsLetters.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('NewsLetters',['fetchAll', 'setProperty', 'persist', 'destroy', 'setPaginate' ]),
    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['user'],
      });
      this.fetchAll();
    },

    deleteSubscription(user) {
      this.$confirm().then(() => {
        this.destroy(user.id).then(() => {
         	this.$toast.success('Successfully');
        });
      })
    },
  }
};
</script>
<template>
  <div>
    <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Email</th>
                <th>User</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id">
                <td>{{item.id}}</td>
               
                <td>{{item.email}}</td>
                <td>
                  <span v-if="item.user">
                    {{ item.name }}
                  </span>
                  </td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${item.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${item.id}`">
                      <a v-if="canUserAccess('news-letter.view')" class="dropdown-item" href="#" @click="()=>deleteSubscription(item)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="NewsLetters" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>