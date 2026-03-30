<script>
import { mapActions } from 'vuex';
import InputFilter from '../../../views/generals/InputFilter';

export default {
  name: 'ProductsFilter',
  components: {
    InputFilter,
  },
  data() {
    return { 
      status: [],
      type: [],
    };
  },
  watch:{
    status:{
      handler(newValue, oldValue) {
        this.setProperty({
          property: 'filterByStatus',
          value: newValue
        });
      this.fetchAll();
      },
      deep: true
    },
    type:{
      handler(newValue, oldValue) {
        this.setProperty({
          property: 'filterByType',
          value: newValue
        });
      this.fetchAll();
      },
      deep: true
    }
  },
  methods: {
    ...mapActions('Products', ['fetchAll', 'setProperty',]),
    handleMenuFilter(menu) {
      this.setProperty({
        property: 'filterByMenu',
        value: menu.id
      });
      this.fetchAll();
    },
    handleCategoryFilter(category) {
      this.setProperty({
        property: 'filterByCategory',
        value: category.id
      });
      this.fetchAll();
    }
  }
};
</script>
<template>
  <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-10">
            <div class="row">
              <div class="col-3">
                <input-filter 
                  module="Products"
                  label="Product"
                  class="me-3"
                />
              </div>
              <div class="col-3">
                <label>Menu</label>
                <remote-selector 
                  module="Menus"
                  :multiple='false'
                  @change="handleMenuFilter"
                  label="name"
                  class="w-100"
                />
              </div>
              <div class="col-3">
                <label>Category</label>
                <remote-selector 
                  module="Categories"
                  :multiple='false'
                  @change="handleCategoryFilter"
                  label="name"
                  class="w-full"
                />
              </div>
              <div class="col-3">
                <div>
                  <label>Status</label><br/>
                  <input type="checkbox" name="type" v-model="status" class="me-1" value="1">Active
                  <input type="checkbox" name="type" v-model="status" class="me-1" value=" ">Inactive
                </div>

                <div>
                  <label>Type</label><br/>
                  <input type="checkbox" name="type" v-model="type" class="me-1" value="1">Product
                  <input type="checkbox" name="type" v-model="type" class="me-1" value="2">Service
                </div>

              </div>
            </div>
          </div>
          <div class="col-2">
            <div v-if="canUserAccess('products.create')">
              <a class="btn bg-primary text-white" href="/products/create">
                <i class="bi bi-plus-circle-fill"></i>
                Add Products
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<style>

</style>