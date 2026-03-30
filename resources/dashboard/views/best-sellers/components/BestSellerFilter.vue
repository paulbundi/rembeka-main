<script>
import InputFilter from '../../../views/generals/InputFilter';
import BestSellerCreate from './BestSellerCreate.vue';

export default {
  name: 'BestSellerFilter',
  components: {
    InputFilter,
    BestSellerCreate,
  },
  methods: {
    handleSave() {
      this.$emit('add-product');
    },
  }
};
</script>
<template>
<div class="card">
  <div class="card-body">
    <div class="d-flex flex-row justify-content-between">
      <div class="d-flex">
      </div>
      <div v-if="canUserAccess('products.create')">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bestsellerProduct">
          <i class="bi bi-plus-circle-fill"></i>
          Add products
        </button>
      </div>
    </div>
  </div>

          <!-- Modal -->
<div class="modal fade" id="bestsellerProduct" tabindex="-1" aria-labelledby="bestsellerProductLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bestsellerProductLabel">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <best-seller-create actions/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" @click="handleSave">Save changes</button>
      </div>
    </div>
  </div>
</div>
  
</div>
</template>

<style>

</style>