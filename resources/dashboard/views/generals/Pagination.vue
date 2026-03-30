<script>
export default {
  props: {
    module: {
      type: String,
    },
    pagination: {
      type: Object,
    },
    paginationItems: {
      type: Array,
    },
    moduleObjectName: {
      type: String,
      default: 'pagination',
    },
  },
  computed: {
    storeModule() {
      return this.module
        .split('/')
        .reduce((a, b) => {
          return a[b];
        }, this.$store.state);
    },
    page: {
      get() {
        return this.pagination ? this.pagination.page : this.storeModule[this.moduleObjectName].page;
      },
      set(newValue) {
        if (this.pagination) {
          this.pagination.page = newValue;
        } else {
          this.$store.dispatch(`${this.module}/setProperty`, {
            property: 'pagination',
            subProperty: 'page',
            value: newValue,
          });
        }
      },
    },
    perPage() {
      return this.pagination ? this.pagination.perPage : this.storeModule[this.moduleObjectName].perPage;
    },
    total() {
      return this.pagination ? this.pagination.total : this.storeModule[this.moduleObjectName].total;
    },
    items() {
      return this.paginationItems || this.storeModule.items;
    },
    currentPage() {
      return this.pagination ? this.pagination.perPage : this.storeModule[this.moduleObjectName].page;
    },
    range() {
      let maxPages = 10;
      if (this.total === 0) {
        return [1];
      }
      
      let totalPages = Math.ceil(this.total / this.perPage);
      let rangeItems = [];

      if (totalPages <= maxPages) {
        for (let i = 1; i <= totalPages; i++) {
          rangeItems.push(i);
        }
      } else {
        let midPoint = Math.ceil(maxPages / 2);
        let lowerBound = this.currentPage - midPoint + 1;
        let upperBound = this.currentPage + midPoint - 1;

        console.log(lowerBound, upperBound, this.currentPage);
        if (lowerBound <= 1) {
          lowerBound = 1;
          upperBound = maxPages;
        }

        if (upperBound >= totalPages) {
          upperBound = totalPages;
          lowerBound = totalPages - maxPages + 1;
        }
        if (lowerBound > 1) {
          rangeItems.push(1);
          if (lowerBound > 2) {
            rangeItems.push('...');
          }
        }

        for (let i = lowerBound; i <= upperBound; i++) {
          rangeItems.push(i);
        }

        if (upperBound < totalPages) {
          if (upperBound < totalPages - 1) {
            rangeItems.push('...');
          }
          rangeItems.push(totalPages);
        }
      }
      return rangeItems;
    }
  },
  methods: {
    pageChange(newPage) {

      if(newPage === this.page){
        return;
      }
      this.$emit('page-change', newPage);
    },
    previousPage(){
      if(this.page == 1){
        return;
      }
    this.pageChange(this.page - 1);
    },
    nextPage(){
      let last = this.range[ this.range.length - 1];
      if(this.page === last){
        return;
      }
      this.pageChange(this.page + 1);
    }
  },
}
</script>

<template>
  <div class="mt-1" v-if="range !== undefined">
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item"><a @click="previousPage" class="page-link" href="#">Previous</a></li>
        <li class="page-item" v-for=" (item, index) in range" :key="index"><a @click="() => pageChange(item)" class="page-link" href="#">{{item}}</a></li>
        <li class="page-item"><a  @click="nextPage" class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
    <div class="clearfix"></div>
  </div>
</template>
