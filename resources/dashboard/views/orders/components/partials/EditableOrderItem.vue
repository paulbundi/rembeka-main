<script>
  export default {
    name: 'EditableOrderItem',
    props: {
      item: {
        type: Object,
        required: true,
      },
      index: {
        type: [Number,String],
        required: true,
      }
    },
    methods: { 
      removeOrderItem() {
        this.$emit('remove-order-item', this.index);
      },
      handleUpdateQuantity(quantity) {
        this.$emit('update-quantity', {quantity: quantity, index: this.index});
      },
      updateProviderPricing(value) {
        this.$emit('update-provider-pricing', {value: value, index: this.index});
      },
      handleAddStylist() {
       this.$emit('add-stylist-to-service');
      },
      handleRemoveStylist() {
       this.$emit('remove-assist-stylist');
      }
    }
  };
</script>
<template>
    <tr>
      <td>
        <div class="col-10 d-flex flex-row">
          <div class="d-flex flex-column">
              <button class="btn btn-sm btn-danger me-2" @click="()=>removeOrderItem()">
              <i class="bi bi-dash-circle"></i>
            </button>	
            
          </div>
          <div>
            {{ item.product.name }}
            <span v-if="item.discounted" class="badge bg-success">Discounted</span>
          </div>
        </div>
      </td>
      <td>
        <div class="w-100">
          <span v-if="item.type == 2">
            {{ item.provider.first_name }}
            {{ item.provider.last_name }}
          </span>
          <span v-else>
            {{ item.provider.displayName }}
          </span>

          <button v-if="item.type == 2" class="btn btn-sm btn-primary" @click="() =>handleAddStylist()">
            <i class="bi bi-plus-circle"></i>
          </button>
        </div>

        <div v-if="item.assistStylist" class="w-100">
          <hr/>
          <span class="">
            {{item.assistStylist.name}}
            <span class="badge bg-danger cursor-pointer" @click="()=>handleRemoveStylist()">X</span>
          </span>
        </div>
      </td>
      <td>
        <span v-if="item.type == 2">
          <date-picker
            input-class="form-control"
            :value="item.appointmentDate"
            format="yyyy-MM-dd" 			
            @selected="(e) => item.appointmentDate = e"
          />
        </span>
      </td>
      <td>
        <span v-if="item.type == 2">
          <input class="form-control" type="time" v-model="item.appointmentTime"/>
        </span>
      </td>

      <td>
        <input type="number" class="form-control w-50" :value="item.quantity" @input="(e)=>handleUpdateQuantity(e.target.value)">
      </td>
      <td>
        <div v-if="item.type == 2">
          <small>Pricing Ksh: {{ item.originalProviderCost }}</small><br/>
          <small>Discount Ksh: {{ item.providerDiscountAmount }}</small><br/>
          Discount(%)<input
          type="number" class="form-control w-50" max="100" 
          :value="item.provider_discount" 
          @input="(e) => updateProviderPricing(e.target.value)">
        </div>
      </td>
      <td>
        <span v-if="item.type == 2">
          Unit Price: {{ item.assistStylist ? item.assistStylist.newPrice : item.productPricing }}<br/>
        </span>
        <span v-else>
          Product Price: {{item.productPricing}}<br/>
          Supplier Amount: {{item.providerCost}}
        </span>
      </td>
    
      <td>
        <div v-if="item.productPricing && item.quantity">
          {{ (item.assistStylist ? item.assistStylist.newPrice : item.productPricing) * item.quantity }}
        </div>
        <div v-else>
          0
        </div>
      </td>
    </tr>
</template>
<style lang="scss" scoped>

</style>