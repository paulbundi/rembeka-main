<script>
import { mapActions, mapState } from 'vuex'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'

export default {
  name: 'ColorCreate',
  props: {
    id: {
      type: Number,
      default: null,
    }
  },
  mixins: [
    updateProperty,
  ],
  computed: {
    ...mapState({
      selected: state => state.Colors.selected,
    }),
  },
  watch: {
    id() {
      this.fetchItems();
    }
  },
  created() {
    if (this.id) {
      this.fetchItems();
    } else {
      this.resetSelected();
    }
  },
  methods: {
    ...mapActions('Colors', ['fetchOne', 'persist', 'resetSelected']),
    fetchItems() {
      if (this.id) {
        this.fetchOne({ id: this.id });
      }
    },
    saveColor() {
      if (!this.selected.display_type) {
        this.updateProperty('display_type', 'pill');
      }
      this.persist().then(() => {
        this.$toast.success('Color saved successfully');
        this.$emit('saved');
        this.resetSelected();
      }).catch(({ response }) => {
        catchValidationErrors(this, response);
      });
    },
  }
}
</script>
<template>
  <div class="card">
    <div class="card-body">
      <h4>{{ selected.id ? 'Update' : 'Create a' }} Color / Shade</h4>
      <form>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label>Name / Code</label>
              <input
                class="form-control"
                type="text"
                placeholder="e.g. BUG, C14, C15, 1B"
                :value="selected.name"
                @input="(e) => updateProperty('name', e.target.value)"
              >
              <small class="text-muted">Use the shade code customers recognize (BUG, C14, etc.)</small>
            </div>
            <div class="form-group">
              <label>Display Type</label>
              <select
                class="form-select"
                :value="selected.display_type || 'pill'"
                @change="(e) => updateProperty('display_type', e.target.value)"
              >
                <option value="pill">Pill (text code)</option>
                <option value="swatch">Swatch (color circle)</option>
              </select>
            </div>
            <div v-if="selected.display_type === 'swatch'" class="form-group">
              <label>Hex Color</label>
              <input
                class="form-control"
                type="color"
                :value="selected.hex_code || '#cccccc'"
                @input="(e) => updateProperty('hex_code', e.target.value)"
              >
            </div>
          </div>
          <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-primary" @click.prevent="saveColor">
              {{ selected.id ? 'Update' : 'Create' }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
