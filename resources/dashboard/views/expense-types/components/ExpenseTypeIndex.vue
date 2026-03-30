<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import ExpensesTypeFilter from './ExpensesTypeFilter.vue';
import ExpenseTypeCreate from './ExpenseTypeCreate.vue';
import { VueNestable, VueNestableHandle } from 'vue-nestable';


export default {
  name: 'ExpensesIndex',
  props: {
    isSelectable:{
      type: Boolean,
      default: false,
    },
  },
  components: { ExpensesTypeFilter, ExpenseTypeCreate,VueNestable,VueNestableHandle, },
  data() {
    return {
      selectedIds: null,
      nestableItems: [],
    };
  },
  mixins: [
    pageChange,
  ],
  computed: {
    ...mapState({
      expenseTypes: state => state.ExpenseTypes.items,
      loading: state => state.ExpenseTypes.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  watch: {
    expenseTypes() {
      this.nestableItems = [...this.expenseTypes];
    }
  },
  methods: {
    ...mapActions('ExpenseTypes',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['children.children.children.children'],
      });
      this.setProperty({property: 'sorts', value:['-id']});
      this.fetchAll();
    },
    handleRangeFilter(value) {
      this.setProperty({property: 'rangeFilter', value:value});
      this.fetchItems();
    },
    handleCheckBox(inquiry) {
      this.selectedIds = inquiry.id;
      this.$emit('selected', inquiry);
    },
    handleMenuOrderChange(value, option) {
      // console.log(value, option, 'data');
    },

    handleEdit(item) {
      this.setSelected(item);
    },
    handleDelete(menu) {
      this.$confirm().then(() => {
        this.destroy(menu.id).then(() => {
         	this.$toast.success('menu deleted Successfully');
           this.fetchAll();
        });
      })
    },
    handleRefresh() {
      this.fetchAll();
    }
  }
};
</script>
<template>
  <div>
    <div class="row">
      <div class="col-8">
        <div class="card">
          <expenses-type-filter @range-filter="handleRangeFilter"/>
          <div v-loading="loading" class="card-body">
            <vue-nestable :value="nestableItems" @change="handleMenuOrderChange">
              <vue-nestable-handle
                slot-scope="{ item }"
                :item="item">
                <div class="d-flex justify-content-between">
                  <div class="d-flex align-items-center">
                    <div v-html="item.icon" class="me-2"></div>
                    {{ item.name }}
                    <span v-if="item.status == 1" class="badge bg-success text-success rounded-circle">.</span>
                    <span v-else class="badge bg-danger text-danger rounded-circle"> . </span>
                  </div>
                  <div class="actions">
                    <i class="bi bi-pencil me-2 cusrsor-pointer" @click="()=>handleEdit(item)"></i>
                    <i class="bi bi-trash cusrsor-pointer"  @click="()=>handleDelete(item)"></i>
                  </div>
                </div>
              </vue-nestable-handle @refresh="() =>handleRefresh()">
            </vue-nestable>
          </div>
        </div>
      </div>

      <div class="col-4" v-if="canUserAccess('expenses.create')">
        <expense-type-create />
      </div>
    </div>
  </div>
</template>

<style>

</style>