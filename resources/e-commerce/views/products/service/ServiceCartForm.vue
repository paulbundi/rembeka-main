<script>
import DatePicker from 'vuejs-datepicker';
import OptionTimes from './OptionTimes';

  export default {
    name: 'ServiceCartForm',
    props: {
      product: {
        type: Object,
        required: true,
      },
      provider: {
        type: Object,
        default: {},
      }
    },
    data() {
      return {
        timeslots: OptionTimes(),
        disabled: {
          from: null,
          to: null,
        },
        errors: [],
        formOrder: {
          stylist: null,
          quantity: 1,
          date: null,
          time: null,
          product_id: this.product.id,
          provider_id: this.provider.id || null,
          type: 2,
        },
      };
    },
    components: {
      DatePicker,
    },
    created() {
      this.disabled.to = new Date(Date.now());
    },
    methods: {

      handleAddToCart() {
        this.$axios.post('/add-to-cart', this.formOrder).then(({data}) => {
          this.$bus.$emit('cartUpdated', data.data);
          this.$toast.success('Cart updated');
          this.animateCart();
        }).catch(({response}) => {
            if (response.status == 422) {
              this.errors = response.data.errors;
            }
        });
      },

      updateSelected(property, value) {
        this.formOrder[property] = value;
      },
    }
  };
</script>
<template>
  <div>
      <!-- if service -->
    <div v-if="product && product.type == 2" class="row">
      <div class="col-12 col-sm-6">
        <div class="form-group">
          <label for="quantity">Date</label>
            <date-picker
              format="yyyy-MM-dd" 
              :disabledDates='disabled'
              @selected="(value) => updateSelected('date',value)"
              input-class="form-control"
            />
            <span v-if="errors.date" class="text-danger">
              {{errors.date[0]}}
            </span>
        </div>
      </div>

      <div class="col-12 col-sm-6">
        <div class="form-group">
          <label for="quantity">Time</label>
          <select class="form-control" 
            name="timeslots"
            :value="formOrder.time"
            @change="(e) => updateSelected('time',e.target.value)">
              <option></option>
              <option v-for="slot in timeslots" :value="slot.value" :key="slot.id">{{ slot.name }}</option>
          </select>
          <span v-if="errors.time" class="text-danger">
              {{errors.time[0]}}
            </span>
        </div>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-12 col-sm-6">
        <div class="form-group">
          <label for="quantity" v-if="product.type == 2">Number of People</label>
          <label for="quantity" v-else>quantity</label>
          <input type="number" class="form-control" name="quantity" v-model="formOrder.quantity" min="1">
        </div>
      </div>

      <div class="col-12 col-sm-6 mt-2 d-flex flex-column">
        <button 
          class="btn btn-primary btn-shadow mt-3" 
          type="button"
          @click="handleAddToCart"
          id="add-to-cart-button"
        >
          <i class="ci-cart fs-lg me-2"></i>
          Add to Cart
        </button>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>

</style>