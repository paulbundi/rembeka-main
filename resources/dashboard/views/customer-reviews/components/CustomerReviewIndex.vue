<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';

  export default {
    name: 'CustomerReviewIndex',
    mixins: [
      pageChange,
    ],
    computed: {
      ...mapState({
        items: state => state.CustomerReviews.items,
        loading: state => state.CustomerReviews.loadingItems,
        user: state => state.authUser,
      }),
    },
    created() {
      this.setPaginate(true);
      this.fetchItems();
    },
    methods: {
      ...mapActions('CustomerReviews',[
        'fetchAll', 'setProperty', 'persist', 'destroy',
        'setSelected', 'resetSelected', 'setPaginate',
      ]),
      fetchItems() {
        this.setProperty({ property: 'relations', value: ['user','product', 'provider']})
        this.fetchAll();
      },
      changeReviewStatus(review) {
        let newReview = {...review, is_visible: review.is_visible !== 0 ? 0: 1}
        this.setSelected(newReview);
        this.$confirm().then(() => {
          this.persist().then(() => {
            this.$toast.success('Success');
            this.fetchItems();
          }).catch(({response}) => {
            catchValidationErrors(this, response);
          });
        })
      },
    }
  };
</script>
<template>
  <div>
    <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Product</th>
                <th>Provider</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id">
                <td>{{item.id}}</td>
                <td>
                  {{item.user.name }}<br/>
                  <span v-if="item.user.return_times" class="badge bg-success"> x {{item.user.return_times}}</span>
                  <span v-if="item.user.wishlist_count" class="badge bg-primary"> <i class="bi bi-heart"></i> {{item.user.wishlist_count}}</span>
                </td>
                <td>
                  <star-rating :rating="item.rating" :star-size=16 read-only :show-rating='false'/>
                </td>
                <td>
                  {{ item.comment }}
                </td>
                <td>
                 <span v-if="item.product">{{ item.product.name }}</span> 

                </td>
                <td>
                  -
                </td>
                <td>
                  <span v-if="item.is_visible != 0" class="badge bg-success">Active</span>
                  <span v-else class="badge bg-danger">InActive</span>
                </td>
               
               
                 <td>{{ item.created_at | formatDate('LLL') }}</td>
                <td>
                  <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${item.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${item.id}`">
                      <span v-if="canUserAccess('customer-review.delete')">
                        <a v-if="item.is_visible == 0" class="dropdown-item" href="#" @click="() => changeReviewStatus(item)">Activate</a>
                        <a v-else class="dropdown-item" href="#" @click="() => changeReviewStatus(item)">Deactivate</a>
                      </span>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Users" @page-change="pageChange"/>
      </div>
  </div>
</template>


<style lang="scss" scoped>

</style>