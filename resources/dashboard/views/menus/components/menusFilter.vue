<script>
import InputFilter from '../../../views/generals/InputFilter';

export default {
  name: 'OrderFilter',
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
              <div class="w-100 me-3">
                <label>Filter Company</label>
                
              </div>
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
          <div v-if="canUserAccess('users.create')">
            <a class="btn bg-primary mt-3 text-white" href="/users/create">Add User</a>
          </div>
        </div>
      </div>
    </div>
</template>

<style>

</style>