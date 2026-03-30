<script>
import { mapActions, mapState } from 'vuex';
import InputFilter from '../../../views/generals/InputFilter';

  export default {
    name: 'WishlistIndex',
    components: {InputFilter},
    computed: {
      ...mapState({
        items: state => state.WishLists.items,
      }),
    },
    created() {
      this.fetchItems();
    },
    methods: {
      ...mapActions('WishLists', ['fetchAll','setProperty',]),
      fetchItems() {
        this.setProperty({ property: 'relations', value: ['user', 'product.attachments.media',]});
        this.setProperty({ property: 'sorts' ,value: ['-id']});
        this.fetchAll();
      }
    }
  };
</script>

<template>
  <div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5>Wishlist</h5>
            <input-filter 
              module="WishLists"
              label="Customer"
              class="me-3"
            />
            <div class="table-responsive  single-item-table">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Listed Price</th>
                    <th>Customer</th>
                    <th>Added At</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in items" :key="item.id">
                    <td>
                      <div class="d-flex flex-row align-items-center">
                        <div class="me-2">
                          <div v-if="item.product.attachments  && item.product.attachments.length > 0">
                            <img class="rounded-circle" :src="`${item.product.attachments[0].media.url}`" width="50" height="50" />
                          </div>
                        </div>
                        <div>
                          {{item.product.name}}
                        </div>
                      </div>
                        
                    </td>
                    <td>{{item.product.final_price}}</td>
                    <td>{{item.user.name}}</td>
                    <td>{{item.created_at | formatDate('LLL') }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<style lang="scss" scoped>

</style>