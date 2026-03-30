<script>
import InputFilter from '../../../views/generals/InputFilter';

export default {
  name: 'ProviderFilter',
  components: {
    InputFilter,
  },
};
</script>
<template>
  <div class="card">
      <div class="card-body">
        <h6>Filter</h6>
        <div class="d-flex flex-row justify-content-between">
          <div class="d-flex">
              <input-filter 
                module="Providers"
                label="Names"
                class="me-3"
              />
          </div>
          <div>
            <a class="btn bg-primary mt-3 text-white" href="/partners/create">Add Partner</a>
          </div>
        </div>
      </div>
    </div>
</template>

<style>

</style>