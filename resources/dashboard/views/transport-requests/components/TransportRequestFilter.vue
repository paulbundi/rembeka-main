<script>
import InputFilter from '../../../views/generals/InputFilter';

export default {
  name: 'SaleFilter',
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
                module="Users"
                label="Names"
                class="me-3"
              />
             <input-filter 
                module="Users"
                label="Email"
                store-property="emailFilter"
                class="me-3"
              />
              <input-filter 
                module="Users"
                label="Phone"
                store-property="phoneFilter"
              />
          </div>
        </div>
      </div>
    </div>
</template>

<style>

</style>