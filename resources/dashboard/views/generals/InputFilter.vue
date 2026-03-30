<script>
import {mapActions} from 'vuex';
export default {
  name: 'InputFilter',
  props:{
    module:{
      type: String,
      required: true,
    },
    label: {
      type: String,
      required: true,
    },
    storeProperty: {
      type: String,
      default:'searchStr' ,
    },
    minCharLength: {
      type: Number,
      default: 3,
    },
    ignoreLength: {
      type: Boolean,
      default: false,
    }
  },
  computed: {
  property() {
      return this.$store.state[this.module][this.storeProperty];
    },
  },
  methods: {
    updateSearchProperty(value) {
      this.$store.dispatch(`${this.module}/setProperty`, {property: this.storeProperty , value});
      if(this.ignoreLength || this.property.length > this.minCharLength || this.property.length === 0){
        this.$store.dispatch(`${this.module}/fetchAll`, true);
      }
    }
  }, 
}
</script>
<template>
  <div>
    <label>{{ label }}</label>
    <input type="text" @input="(e) => updateSearchProperty(e.target.value)" :value="property" class="form-control">
  </div>
</template>
<style scoped>

</style>