<script>
  export default {
    name:'OrderStatus',
    props: {
      status: {
        type: Number,
        require: true,
      }
    },
    computed: {
      getStatus() {
        let response = null;
        switch(this.status){
          case 1:
            response = ['bg-danger', 'pending payment'];
            break;
          case 2:
            response = ['bg-danger', 'payment failed'];
            break;
          case 3:
            response = ['bg-warning', 'Canceled'];
            break;
          case 4:
            response = ['bg-info', 'Order Confirmed'];
            break;
          case 5:
            response = ['bg-secondary', 'Pending Service'];
            break;
          case 6:
            response = ['bg-primary', 'Partial Delivery'];
            break;
          case 7:
            response = ['bg-success', 'FullFilled'];
            break;
          case 8:
            response = ['bg-danger', 'Partial Rating'];
            break;
          case 9:
            response = ['bg-danger', 'Completed'];
            break;
            
          default:
            return ['bg-success', 'undefined'];
            break;
        }

        return response;
      }
    }
  }
</script>
<template>
  <div>
    <span :class="`badge ${getStatus[0]}`">{{getStatus[1]}}</span>
  </div>
</template>

<style lang="scss" scoped>

</style>