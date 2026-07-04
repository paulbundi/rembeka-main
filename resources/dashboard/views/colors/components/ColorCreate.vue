<script>
import { mapState, mapActions } from 'vuex'
import RemoteSelector from '../../generals/RemoteSelector.vue'
import updateProperty from '../../../mixins/updateProperty'
import catchValidationErrors from '../../../utils/catchValidationErrors'

  export default {
    name: 'ColorCreate',
    components: { RemoteSelector },
    computed: {
      ...mapState({
        selected: state => state.Colors.selected,
        user: state => state.authUser,
      }),
    },
    mixins: [
      updateProperty,
    ],
    methods: {
      ...mapActions('Colors', ['persist', 'setProperty']),
      saveColor() {
        this.persist().then(({data}) => {
          this.$toast.success('Color saved successfully');
        })
        .catch(({response}) => {
          catchValidationErrors(this, response);
        });
      },
    }
  };
</script>
<template>
<div class="row">
  <div class="col-6">
    <div class="form-group">
      <label>Color Name</label>
      <input class="form-control" type="text" :value="selected.name" @input="(e) => updateProperty('name', e.target.value)">
    </div>

    <div class="form-group">
      <label>Slug</label>
      <input class="form-control" type="text" :value="selected.slug" @input="(e) => updateProperty('slug', e.target.value)">
    </div>

    <div class="form-group">
      <label>Hex Code</label>
      <input class="form-control" type="text" :value="selected.hex_code" @input="(e) => updateProperty('hex_code', e.target.value)" placeholder="#FF0000">
    </div>

    <div class="form-group">
      <button class="btn btn-primary" @click.prevent="saveColor">{{ selected.id ? 'Update': 'Create' }}</button>
    </div>

  </div>
</div>
</template>
<style lang="scss" scoped>

</style>