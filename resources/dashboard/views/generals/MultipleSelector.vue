<script>
import Multiselect from 'vue-multiselect';
export default {
  name: 'MultipleSelector',
  props:{
    items:{
      type: Array,
      required: true,
    },
    label: {
      type: String,
      default: 'name',
    },
    placeholder: {
      type: String,
      default: 'Select...',
    },
    value: {
      type:[Number, Object, Array],
      default: null,
    },
    multiple: {
      type: Boolean,
      default: false,
    }
  },
  data() {
    return {
      selectedItems: this.value|| [],
      selected: [],
      loading: false,
    }
  },
  components: {
    Multiselect,
  },
  watch:{
    selectedItems() {
      if (!this.multiple){
        this.selected = this.selectedItems.id;
        this.$emit('change',this.selected);
        return;
      }
      this.selected = this.selectedItems.map((item) => item.id);
      this.$emit('change',this.selected);
    },
  },
  mounted() {
    if (this.value) {
      this.selectedItems = this.value;
    }
  },
}
</script>
<template>
  <div class="m-0 p-0">
    <multiselect
      v-model="selectedItems"
      :loading="loading"
      :options="items"
      :multiple="multiple"
      :preserve-search="true"
      :internal-search="true"
      :placeholder="placeholder"
      :label="label"
      track-by="id"
      class="multiselect my-3"
    >
    </multiselect>
  </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
  .multiselect__tags-wrap span {
      color: #444 !important;
      background: #f4f7f6 !important;
  }
  .multiselect__element span:hover{
    background:#f4f7f6 !important;
    color: #444 !important;
  }
  .multiselect__option--highlight{
    background:#f4f7f6 !important;
    color: #444 !important;
  }
</style>