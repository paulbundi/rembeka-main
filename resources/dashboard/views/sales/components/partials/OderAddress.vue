<script>
  export default {
  name: 'OrderAddress',
  props: {
    address:{
      type: Object,
      required: true,
    }
  }
};
</script>
<template>
  <div class="card card-body h-100 pb-0 mb-0 bg-primary text-white">
    <h4 class="fw-bolder text-white">Order Address</h4>
    <b>{{ address.name }}</b>
    <b>{{ address.lat }} {{ address.long }}</b>
    <p>
      <small>Appartment:</small> {{ address.appartment }}<br/>
      <small>Floor:</small> {{ address.floor }}<br/>
      <small>Room No:</small> {{ address.room }}
    </p>
  </div>
</template>



<style scoped>

</style>