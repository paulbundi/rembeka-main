<script>
import InputFilter from '../../../../views/generals/InputFilter';

export default {
  name: 'UserFilter',
  components: {
    InputFilter,
  },
  methods: {
    filterByAccountType(value) {
      this.$emit('account-type', value);
    }
  }
};
</script>
<template>
  <div class="card">
      <div class="card-body">
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
          <div>
            <a v-if="canUserAccess('users.create')" class="btn bg-primary mt-3 text-white" href="/corporates/create">
              <i class="bi bi-person-plus-fill"></i>
                Corporate Account
            </a>
          </div>
        </div>
      </div>
    </div>
</template>

<style>

</style>