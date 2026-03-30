<template>
<tr>
  <td colspan="8">
    <button class="btn btn-sm btn-primary me-2" @click="addService">
      <i class="bi bi-plus-circle"></i>
      Add Service
    </button>
    <button class="btn btn-sm btn-success me-2" @click="addProduct">
      <i class="bi bi-plus-circle"></i>
      Add Product
    </button>
  </td>
</tr>
</template>

<script>
  export default {
    name: 'AddOrderItemsActions',
    methods: {
      addProduct() {
        this.$emit('add-product');
      },
      addService() {
        this.$emit('add-service');
      }
    }
  };
</script>

<style lang="scss" scoped>

</style>