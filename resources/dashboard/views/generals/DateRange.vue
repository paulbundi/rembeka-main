<script>
var dayjs = require('dayjs')

export default {
  name:"DateRange",
  props: {

  },
  data() {
    return {
      dateRange: {
        startDate: null,
        endDate: null
      },
      opens: 'center',
      timePicker: false,
      timePicker24Hour: false,
      showWeekNumbers: true,
      showDropdowns: true,
      autoApply: false,
      singleDatePicker: false,
    };
  },
  methods: {
    updateValues(value) {
      let selectedPeriod = value;
      let startDate = this.$options.filters.formatDate(selectedPeriod.startDate);
      let endDate = this.$options.filters.formatDate(dayjs(selectedPeriod.endDate).add(1,'day'));

      selectedPeriod = {
         startDate: startDate,
        endDate: endDate
      }
      this.$emit('changed', selectedPeriod);
    },
    clearRange() {
       this.dateRange =  {
        startDate: null,
        endDate: null,
      };
      this.$emit('changed', null);
    },
  }
};
</script>
<template>
  <div class="w-100">
    <date-range-picker
      ref="picker"
      :opens="opens"
      :locale-data="{ firstDay: 1, format: 'dd-mm-yyyy HH:mm:ss' }"
      :singleDatePicker="singleDatePicker"
      :timePicker="timePicker"
      :timePicker24Hour="timePicker24Hour"
      :showWeekNumbers="showWeekNumbers"
      :showDropdowns="showDropdowns"
      :autoApply="autoApply"
      v-model="dateRange"
      @update="updateValues"
      format="yyyy-MM-dd" 
    />
    <button v-if="dateRange.endDate" type="submit" class="btn btn-sm btn-primary" @click="clearRange">clear</button>
  </div>
</template>
<style scoped>
.vue-daterange-picker{
  width: 100%;
}
</style>