<script>
  export default {
    name: 'StylistRating',
    props: {
      stylist: {
        type: [Object, Array],
        required: true,
      }
    },
    data() {
      return {
        reviews: [],
        loading: false,
      };
    },
    created() {
      this.fetchItems();
    },
    methods: {
      fetchItems(){
        this.loading = true;
        this.$axios.get(`/stylist-rating/${this.stylist.id}`).then(({data}) => {
          this.reviews = data.data.data;
        }).finally(() => {
          this.loading = false;
        });
      }
    }
  };
</script>
<template>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Customer Reviews</h5>
        <div v-for="review in reviews" class="product-review pb-4 mb-4 border-bottom" :key="review.id">
          <div class="d-flex mb-3">
            <div class="d-flex align-items-center me-4 pe-2">
              <i class="bi bi-person-circle fs-4"></i>
              <div class="ps-3">
                <h6 class="fs-sm mb-0">{{review.user.first_name}}</h6><span class="fs-ms text-muted">{{review.created_at}}</span>
              </div>
            </div>
          </div>
          <p class="fs-md mb-2">{{ review.comment }}</p>
        </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>

</style>