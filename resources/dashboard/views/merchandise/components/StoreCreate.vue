<script>
import { mapActions, mapState } from 'vuex';
import updateProperty from '../../../mixins/updateProperty';
import catchValidationErrors from '../../../utils/catchValidationErrors'

  export default {
    name: 'StoreCreate',
    mixins: [
      updateProperty,
    ],
    computed: {
      ...mapState({
        selected: state => state.Franchises.selected,
        user: state => state.authUser,
      }),
    },
    methods: {
      ...mapActions('Franchises',['persist', 'setProperty']),
      handleCreate() {
        console.log("we here");
        this.persist().then(() => {
          this.$emit('created');
        }).catch(({response}) => {
          catchValidationErrors(this, response);
        });
      }
    }
  };
</script>
<template>
  <div>
      <div class="form-group mb-2">
        <label for="">Franchise Name</label>
        <input type="text" class="form-control" :vlaue="selected.name" @input="(e) => updateProperty('name', e.target.value)"/>
      </div>
      <div class="form-group mb-2">
        <label for="">Franchise Location</label>
        <input type="text" class="form-control" :vlaue="selected.location" @input="(e) => updateProperty('location', e.target.value)"/>
      </div>
      <div class="form-group mb-2">
        <label for="">Running Commision(Rembeka Commission)</label>
        <input type="number" step="any" min="30" max="100" class="form-control" :vlaue="selected.commission" @input="(e) => updateProperty('commission', e.target.value)"/>
      </div>
      <div class="form-group mb-2">
        <label for="">Franchise Manager</label>
        <remote-selector 
          module="Users"
          :multiple='false'
          @change="(e)=>updateProperty('user_id', e)"
          label="name"
        />
      </div>
      <div class="form-group mb-2">
        <button class="btn btn-sm btn-primary float-end" @click="handleCreate">Save</button>
      </div>
  </div>
</template>
<style lang="sass" scoped>

</style>