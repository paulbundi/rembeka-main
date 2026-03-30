<script>
import {mapState, mapActions} from 'vuex';
import updateProperty from '../../../mixins/updateProperty';
import RemoteSelector from '../../generals/RemoteSelector.vue';

  export default {
  components: { RemoteSelector },
    name: 'OrderItemEdit',
    mixins:[
      updateProperty,
    ],
    computed: {
      ...mapState({
        selected: state => state.OrderItems.selected,
        loading: state => state.OrderItems.loading,
        user: state => state.authUser,
      }),
  },
    methods: {
      ...mapActions('OrderItems', ['setSelected', 'setProperty', 'persist']),
      handleProviderChange(provider) {
        this.updateProperty('provider_id', provider);
      },
      handleSave(){
        this.persist().then(() => {
			    this.$toast.success('Order updated successfully');
          this.$emit('updated');
        }).catch((error) => {
          // console.log(error);
        })
      }
    },
  }
</script>
<template>
  <div>
    <div v-if="selected.provider" class="form-group">
      <label for="provider">{{ selected.type == 2 ? 'Service Provider': 'Product Supplier' }}</label>
      <remote-selector :value="selected.provider" module="Providers" :multiple="false" @change="handleProviderChange" />
    </div>

    <template v-if="selected.type == 2">
      <div class="form-group"> 
        <label for="">Date</label>
        <input class="form-control" :value="selected.appointment_date" type="date" @input="(e) => updateProperty('appointment_date', e.target.value)">
      </div>
      <div class="form-group">
        <label for="">Time</label>
        <input class="form-control" :value="selected.appointment_time" type="time" @input="(e) => updateProperty('appointment_time', e.target.value)">
      </div>
    </template>
    <!-- <div class="form-group">
      <label for="">Number of People(Quantity)</label>
      <input class="form-control" :value="selected.quantity" @change="(e)=>updateProperty('quantity', e.target.value)">
    </div> -->

    <div class="form-group">
      <button class="btn btn-sm btn-primary float-end" @click="handleSave">Save</button>
    </div>
  </div>
</template>
<style lang="scss" scoped>

</style>