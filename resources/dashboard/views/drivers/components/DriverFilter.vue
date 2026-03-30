<script>
import InputFilter from '../../../views/generals/InputFilter';

export default {
  name: 'ProviderFilter',
  components: {
    InputFilter,
  },
  methods: {
    handleSchoolFilter(value) {
      this.$emit('filterSchool', value);
    }
  }
};
</script>
<template>
  <div class="card">
      <div class="card-body">
        <h6>Filter</h6>
        <div class="d-flex flex-row justify-content-between">
          <div class="d-flex">
              <input-filter 
                module="Suppliers"
                label="Names"
                class="me-3"
              />
             <input-filter 
                module="Suppliers"
                label="Email"
                store-property="emailFilter"
                class="me-3"
              />
              <input-filter 
                module="Suppliers"
                label="Phone"
                store-property="phoneFilter"
              />
          </div>
          <div>
            <a class="btn bg-primary mt-3 text-white" href="/drivers/create">Add Create</a>
          </div>
        </div>
      </div>
    </div>
</template>

<style>

</style>