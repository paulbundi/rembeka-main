<script>
import noUiSlider from 'nouislider';

  export default {
    name: 'PriceRangeFilter',
    data() {
      return {
        minRange: null,
        maxRange: null,
        slider: {
          startMin: 25,
          startMax: 75,
          min: 0,
          max: 100,
          start: 40,
          step: 1
        }
      };
    },
    ready() {
        noUiSlider.create(this.$refs.slider, {
            start: [this.slider.startMin, this.slider.startMax],
            step: this.slider.step,
            range: {
                "min": this.slider.min,
                "max": this.slider.max
            }
        });
        this.$refs.slider.noUiSlider.on("update", (values, handle) => {
            this[handle ? "maxRange" : "minRange"] = parseInt(values[handle]);
        });
    },
    methods: {
      updateSlider() {
        this.$refs.slider.noUiSlider.set([this.minRange, this.maxRange]);
      },
    }
  };
</script>
<template>
  <div>
    <h3 class="widget-title">Price</h3>
    <div class="range-slider" data-start-min="250" data-start-max="680" data-min="0" data-max="1000" data-step="1">
      <div class="range-slider-ui" ref="slider"></div>
      <div class="d-flex pb-1">
        <div class="w-50 pe-2 me-2">
          <div class="input-group input-group-sm"><span class="input-group-text">Ksh</span>
            <input class="form-control range-slider-value-min" type="text">
          </div>
        </div>
        <div class="w-50 ps-2">
          <div class="input-group input-group-sm"><span class="input-group-text">Ksh</span>
            <input class="form-control range-slider-value-max" type="text">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>

</style>