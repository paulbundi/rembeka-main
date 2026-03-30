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

              <input-filter 
                module="Users"
                label="Return Times"
                store-property="returnTimes"
                ignore-length
                class="mx-2"
              />

              <div class="col-3 form-group ms-2 mt-0">
                <label>Account Type</label>
                <select class="form-control" @change="(e)=>filterByAccountType(e.target.value)">
                  <option value="">All</option>
								<option value="1">Customer</option>
								<option value="2">Provider</option>
								<option value="5">Supplier</option>
								<option value="6">Rider</option>
								<option value="3">Admin</option>
                </select>
              </div>
          </div>
          <div>
            <a v-if="canUserAccess('users.create')" class="btn bg-primary mt-3 text-white" href="/users/create">
              <i class="bi bi-person-plus-fill"></i>
              Add User
            </a>
          </div>
        </div>
      </div>
    </div>
</template>

<style>

</style>