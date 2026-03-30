<script>
import { mapActions, mapState } from 'vuex'
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import ItemStatus from './ItemStatus.vue'
import OrderItemEdit from './OrderItemEdit.vue';
import CalendarReservation from './partials/CalendarReservation.vue';
import CalendarTable from './partials/CalendarTable.vue';

export default {
  name: 'CalendarIndex',
  components: {
    FullCalendar,
    ItemStatus,
    OrderItemEdit,
    CalendarTable,
    CalendarReservation,
  },
  data(){
    return {
      selectedEvent: null,
      modal: null,
      calendarOptions: {
        plugins: [ dayGridPlugin, interactionPlugin ],
        eventClick: this.handleEventClick,
        initialView: 'dayGridMonth',
        weekends: true, // initial value
        events: [
          { title: 'event 1', date: '2022-04-01' },
          { title: 'event 2', date: '2022-04-02' }
        ],
      },
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
    };
  },
  computed: {
    ...mapState({
      items: state => state.OrderItems.items,
      bookings: state => state.Bookings.items,
      user: state => state.authUser,
    }),
    calendarItems() {
        let entries = this.items.map((orderItem) => {
          return {
            title: `${orderItem.order.order_no}-${orderItem.provider.name}` ,
            // 'appointment_date', 'appointment_time',
            date: orderItem.appointment_date ? orderItem.appointment_date : '',
            isTask: true,
            extendedProps: {orderItem}};
      });
      let slots = this.bookings.map((booking) => {
        return {
          title: `${booking.provider_pricing.product.name}-${booking.provider.name}` ,
          date: booking.slot_time,
          isTask: false,
          extendedProps: {booking}};
    });

      return [...entries, ...slots];
    }
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  mounted() {
    this.modal = new bootstrap.Modal(this.$refs.modal, { backdrop: 'static' });

  },
  methods: {
    ...mapActions('OrderItems', ['fetchAll', 'setProperty', 'setPaginate']),
    ...mapActions('Bookings', {fetchBookings: 'fetchAll', setBookingProperty:'setProperty', setSelectedBooking: 'setSelected',
    persistBooking:'persist'
    }),
    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['provider', 'order.customer', 'product'],
      });
      this.setBookingProperty({
        property: 'relations',
        value: ['provider', 'providerPricing.product'],
      });
      
      this.setProperty({property: 'sorts', value: ['-id']});
      this.setBookingProperty({property: 'sorts', value: ['-id']});
      this.fetchBookings().then(() => {
        this.fetchAll().then(() => {
          this.calendarOptions = {...this.calendarOptions, events:[...this.calendarItems]}
        });
      });
    },
    handleEventClick(event) {
      this.selectedEvent = event.event._def;
      this.modal.show();
    },
    filterByStylist(stylists) {

      if(stylists.length < 1) {
        this.setProperty({ property: 'providerFilter', value: null});
      }else {
        this.setProperty({ property: 'providerFilter', value: stylists});

      }
      this.fetchItems();
    },
    handleConfirmReserversation(selectedEvent) {
      let booking = {...selectedEvent.extendedProps.booking, confirmation_status: 1, user_id: this.user.id };
      this.setSelectedBooking(booking);
      this.persistBooking().then(() => {
        this.$toast.success('Confirmed');
        this.modal.hide();
        this.fetchItems();
      });
    },
  },
  };
</script>
<template>
<div class="row">
    <div class="col-12 col-sm-3">
      <div class="form-group">
        <label for="stylists">Stylist</label>
        <remote-selector
          module="Providers" 
          @change="filterByStylist"
        />

      </div>
    </div>

    <div class="col-12 col-sm-9" v-if="calendarItems">
      <div class="card">
        <div class="body" style="max-height: 90vH; overflow-y:scroll;">
          <full-calendar
            ref="fullCalendar"
            defaultView="dayGridMonth"
            :header="headerToolbar"
            :options="calendarOptions"
          >
             <template #eventContent="{ timeText, event }">
                  <b>{{ event.title }}</b>
              </template>
          </full-calendar>
        </div>
        </div>
    </div>

<!-- Modal for task details -->
  <div class="modal fade" id="showEvent" ref="modal" tabindex="-1" role="dialog" style="margin-top: 20vh;">
    <div class="modal-dialog" role="document">
        <div class="modal-content" v-if="selectedEvent && selectedEvent.title != null">
            <div class="modal-header">
                <div>
                  <h4 class="title" id="largeModalLabel">{{ selectedEvent.title }}</h4>
                </div>
                <div class="ms-auto">
                  <div class="d-flex">
                    <button class="btn btn-sm border me-1" data-bs-dismiss="modal">
                       <i class="bi bi-x"></i>
                    </button>
                  </div>
                </div>
            </div>
            <div class="modal-body"><!-- initialize modal form-->

              <template v-if="selectedEvent.extendedProps.isTask">
                <calendar-table :selected-event="selectedEvent" />
              </template>

              <template v-else>
                <calendar-reservation :selected-event="selectedEvent" />
              </template>
             
            </div><!-- end modal body -->

            <div class="modal-footer">
                <button type="reset" class="btn btn-primary btn-sm pull-right" data-bs-dismiss="modal"> Close</button>

                <button 
                  v-if="selectedEvent.extendedProps.booking && selectedEvent.extendedProps.booking.confirmation_status != 1" 
                  class="btn btn-success btn-sm pull-right" @click="()=>handleConfirmReserversation(selectedEvent)"
                >
                  Confirm
                </button>
            </div>
        </div>
    </div>
  </div>
</div>
</template>
<style lang="scss" scoped>

</style>