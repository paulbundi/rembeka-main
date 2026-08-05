<script>
import InputFilter from '../../../views/generals/InputFilter';

export default {
  name: 'ProviderInquiriesFilter',
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
                module="ProviderInquiries"
                label="Names"
                class="me-3"
              />
             <input-filter
                module="ProviderInquiries"
                label="Email"
                store-property="emailFilter"
                class="me-3"
              />
              <input-filter
                module="ProviderInquiries"
                label="Phone"
                store-property="phoneFilter"
              />
          </div>
          <div v-if="canUserAccess('providers-inquiries.create')" class="float-end">
            <a class="btn bg-primary mt-3 text-white" href="/providers-inquiries/create">
              <i class="bi bi-plus-circle-fill"></i>
              Create Inquiry
            </a>
          </div>
        </div>
      </div>
    </div>
</template>

<style>

</style>