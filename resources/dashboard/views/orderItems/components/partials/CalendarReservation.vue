  <script>
    export default {
      name: 'CalendarReservation',
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
      <td>Service:</td>
      <td> {{ selectedEvent.title }} </td>
    </tr>

    <tr>
      <td>Date</td><td>{{ selectedEvent.extendedProps.booking.slot_time | formatDate('LLL')}}</td>
    </tr>

    <tr>
      <td>Status</td><td>
        <span v-if="selectedEvent.extendedProps.booking.confirmation_status == 1" class="badge bg-success">
          Confirmed
        </span>
        <span v-else class="badge bg-warning">
          Pending
        </span>
      </td>
    </tr>

    <tr>
      <td></td><td></td>
    </tr>
  </table>
</template>


<style lang="scss" scoped>

</style>