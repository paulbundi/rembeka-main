<script>
import ServiceItem from '../search/ServiceItem.vue';
  export default {
  components: { ServiceItem },
    name: 'StylistServiceList',
    props: {
      stylist: {
        type: Object,
        required: true,
      }
    },
    data() {
      return {
        loading: false,
        serviceList: [],
      };
    },
    created() {
      this.fetchItems();
    },
    methods: {
      fetchItems() {
        this.loading = true;
        this.$axios.get(`/stylist-catalogue/${this.stylist.id}`).then(({data}) => {
          this.serviceList = data.data.data;
        }).finally(() => {
          this.loading = false;
        });
      }
    }
  };
</script>
<template>
  <div class="row mx-n2">
    <div v-for="service in serviceList" class="col-md-4 col-sm-6 px-2 mb-4" :key="`item-${service.id}`">
      <service-item :service="service.product" :stylist="stylist"/>
    </div>
  </div>
</template>
<style lang="scss" scoped>

</style>