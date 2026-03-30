<script>
  export default {
    name: 'NoResults',
    methods:{
      handleClearFilter() {
        this.$emit('clearFilters');
      }
    }
  };
</script>

<template>
  <div class="w-100 mt-4">
    <div class="empty-message d-flex flex-column justify-content-center align-items-center mt-4">
      <i class="bi bi-binoculars-fill"></i>
      <h3 class="my-1">No results available.</h3> 
      <span class="my-1">We did not find a match for the filters you selected.</span>
      <button class="btn btn-primary text-white" @click="handleClearFilter">Clear Filter</button>
    </div>
  </div>
</template>

<style lang="scss" scoped>

</style>