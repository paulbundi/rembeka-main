<script>
import InputFilter from '../../../views/generals/InputFilter';

export default {
  name: 'DiscountedFilter',
  components: {
    InputFilter,
  },
};
</script>
<template>
<div class="card">
    <div class="card-body">
      <div class="d-flex flex-row justify-content-between">
        <div class="d-flex">
          <input-filter 
            module="ProductDiscounts"
            label="Product/ Service"
            class="me-3"
          />
        </div>
        <div v-if="canUserAccess('products.create')">
          <a href="/product-discounts/create" class="btn btn-primary">
            <i class="fa fa-plus-circle"></i>
            Add products
          </a>
        </div>
      </div>
    </div>

</div>
</template>

<style>

</style>