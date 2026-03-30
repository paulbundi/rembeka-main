<script>
import InputFilter from '../../../views/generals/InputFilter';

export default {
  name: 'StkFilter',
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
              <div class="w-100 me-3">
               <input-filter 
                module="Stk"
                label="Order No."
                store-property="orderNo"
                class="me-3"
              />                
              </div>
              <input-filter 
                module="Stk"
                label="names"
                class="me-3"
              />
              <input-filter 
                module="Stk"
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