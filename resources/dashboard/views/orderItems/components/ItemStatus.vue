<script>
  export default {
    name:'ItemStatus',
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
            response = ['bg-warning', 'service awaiting'];
            break;
          case 4:
            response = ['bg-info', 'partial delivery'];
            break;
          case 5:
            response = ['bg-secondary', 'Full filled'];
            break;
          case 6:
            response = ['bg-primary', 'partial Rating'];
            break;
          case 7:
            response = ['bg-success', 'Completed'];
            break;
          case 8:
            response = ['bg-danger', 'Cancelled'];
            break;
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