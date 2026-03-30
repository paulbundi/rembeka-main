<template>
  <tbody>
      <tr>
        <td>{{ item.id }}</td>
        <td>
          <span v-if="item.type == 2 && item.provider">
            {{  item.provider.first_name }} 
            {{  item.provider.last_name }}
          </span>
          <span v-if="item.type == 1 && item.supplier">
            {{  item.supplier.displayName }} 
          </span>
        </td>
        <td>
          {{ item.product.name }}<br/>
          <small>{{ item.category.name }}</small> <br/>
          <span v-if="item.discounted" class="badge bg-success">Discounted<br/></span>
          <span v-if="item.type == 1" class="badge bg-dark">
              Product
          </span>
            <span v-else class="badge bg-warning">
              Service
          </span>
        </td>
  
        <td>{{ item.appointment_date }}</td>
        <td>{{ item.appointment_time }}</td>
        <td>{{ item.quantity }}</td>
        <td>
          {{ item.amount }}<br/>
          <span v-if="item.discounted" class="badge bg-success">
            - {{ item.discount_amount }}
          </span>
        </td>
        <td>
          {{ item.provider_amount }}<br/>
          <span v-if="item.provider_paid" class="badge bg-success">
            Provider Paid
          </span>
          <span v-else class="badge bg-primary">
            Pending
          </span>
        </td>

      </tr>
      <tr v-if="item.beneficiary">
        <td colspan="11">
          <div class="d-flex">
            <b class="me-3">Beneficiaries</b>
            <div>
              <button v-for="user in  item.beneficiary"  v-if="user" class="btn btn-sm btn-outline-dark me-1">
                {{user.first_name}} 
                {{user.last_name}} 
              </button>
            </div>
          </div>
        </td>
      </tr>
  </tbody>
</template>

<script>
  export default {
    props: {
      item: Object,
      required: true,
    },
    name: 'ItemDetails',
  }
</script>

<style lang="scss" scoped>

</style>