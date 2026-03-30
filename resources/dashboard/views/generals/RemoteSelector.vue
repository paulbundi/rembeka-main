<script>
import Multiselect from 'vue-multiselect';
import {mapState, mapActions} from 'vuex';

export default {
  name: 'RemoteSelector',
  props: {
    multiple: {
      type: Boolean,
      default: true,
    },
    module: {
      type: String,
      required: true,
    },
    maximumSelectable: {
      type: Number,
      default: 50,
    },
    internalSearch: {
      type: Boolean,
      default: false,
    },
    value: {
      type: [Object, Number, Array],
      default: null,
    },
    label: {
      type: [String],
      default: 'name'
    },
    filterProperty: {
      type: String,
      default: 'searchStr',
    }
  },
  data() {
    return {
      selectedItems: [],
      members: [],
      isLoading: false,
      defaultValue: true,
    }
  },
  components: {
    Multiselect,
  },
  watch: {
    selectedItems() {
      this.members = this.selectedItems.map(item => item.id);
      this.$emit('change', this.multiple ? this.members : this.members[0]);
    }
  },
  computed: {
    storeModule() {
      return this.module
        .split('/')
        .reduce((a, b) => {
          return a[b];
        }, this.$store.state);
    },
    items() {
      this.isLoading = false;
      if(this.value && this.defaultValue && typeof this.value == 'object') {
          this.selectedItems = this.multiple ? [...this.value]: [this.value];
        return this.selectedItems;
      }
      if (this.defaultValue && this.value) {
          this.selectedItems = this.multiple ? [...this.value]: this.value;
          return this.selectedItems;
      }
      return this.storeModule.items;
    },
    storeProperty() {
      return this.filterProperty ? this.filterProperty: 'searchStr';
    }
  },
  methods: {
  asyncFind (query) {
    this.isLoading = true;
    this.$store.dispatch(`${this.module}/setProperty`, {property: this.storeProperty , value: query});
    this.$store.dispatch(`${this.module}/fetchAll`, true);
    this.defaultValue = false;
    this.isLoading = true;
  },
  handleSelected(value) {
    if (this.members.length == this.maximumSelectable) {
      // this.makeToast('error', this.$t.t('commons.maximum_allowed_reached'));
      return;
    }
    if (this.multiple) {
      return this.selectedItems.push(value);
    }
    
    this.selectedItems = [value]
  },
  handleRemoved(removed) {
    if (this.multiple) {
      let items = [...this.selectedItems];
      this.selectedItems = items.filter(item => item.id != removed.id);
      return;
    }
    this.selectedItems = [];
    this.members = null;
  }
},
}
</script>
<template>
  <span>
    <input type="hidden" name="selected" :value="members" />
    <multiselect
      :value="selectedItems"
      :options="items"
      :multiple="multiple"
      :preserve-search="true"
      :internal-search="internalSearch"
      :loading="isLoading"
      @search-change="asyncFind"
      @select="handleSelected"
      @remove="handleRemoved"
      placeholder="Search ..."
      :label="label"
      track-by="id"
      class="multiselect w-100"
    >
    </multiselect>
  </span>
</template>
<style scoped>

</style>