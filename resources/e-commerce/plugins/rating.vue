<script>
import StarRating from 'vue-star-rating';

export default {
  name:'rating',
  props: {
    rating: {
      required: false,
    },
    size: {
      type: Number,
      default: 30,
    },
    readOnly: {
      type: Boolean,
      default: true,
    },
    maxRating: {
      type: Number,
      default: 5,
    },
    showValue:{
      type: Boolean,
      default:false,
    },
    increment: {
      default: 0.5,
    }
  },
  components: {
    StarRating
  },
  data() {
    return {
      value: null,
    }
  },
  methods: {
    setRating(value) {
      this.value = value;
      this.$emit('change', value);
    }
  }
}
</script>
<template>
  <div>
    <input type="hidden" v-model="value" name="rating" required="true">
    <star-rating 
      :read-only="readOnly" 
      @rating-selected="setRating"
      :max-rating="maxRating"
      :rating="rating"
      :increment="increment"
      :star-size="size"
      :show-rating="showValue"
    />
  </div>
</template>
<style scoped>
</style>