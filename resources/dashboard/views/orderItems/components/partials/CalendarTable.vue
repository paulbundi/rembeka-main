<script>
  export default {
    name: 'CalendarTable',
    props: {
      selectedEvent: {
        type: Object,
        required: true,
      }
    }
  };
</script>
<template>
 <table>
    <tr>
      <td>Order No.:</td><td> <span class="badge bg-success">{{ selectedEvent.extendedProps.orderItem.order.order_no }}</span></td>
    </tr>
      <tr>
      <td>Cuatomer</td><td>{{ selectedEvent.extendedProps.orderItem.order.customer.name }}</td>
    </tr>
      <tr>
      <td>Product/Style</td>
        <td>
        Product:<strong>{{ selectedEvent.extendedProps.orderItem.product.name }}</strong> <br/>
        Qnty: <strong>{{ selectedEvent.extendedProps.orderItem.product.name }}</strong>
        </td>
    </tr>
      <tr>
      <td>Date</td><td>{{ selectedEvent.extendedProps.orderItem.appointment_date}} @
      {{selectedEvent.extendedProps.orderItem.appointment_time}}</td>
    </tr>
      <tr>
      <td></td><td></td>
    </tr>
  </table>
</template>

<style lang="scss" scoped>

</style>