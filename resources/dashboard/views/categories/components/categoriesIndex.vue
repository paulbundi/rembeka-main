<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import updateProperty from '../../../mixins/updateProperty';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import CategoriesFilter from './categoriesFilter.vue';
import { VueNestable, VueNestableHandle } from 'vue-nestable';
import CategoriesCreate from './categoriesCreate.vue';

export default {
  name: 'CategoriesIndex',
  components: {
    CategoriesFilter,
    VueNestable,
    VueNestableHandle,
    CategoriesCreate,
  },
  mixins:[
    pageChange,
    updateProperty,
  ],
  
  computed: {
    ...mapState({
      categories: state => state.Categories.items,
      selected: state => state.Categories.selected,
      loading: state => state.Categories.loadingItems,
      user: state => state.authUser,
    }),
  },
  watch:{
    categories() {

      this.nestableItems = [...this.categories];

    }
  },
  data() {
    return {
       nestableItems: []
    };
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Categories',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      
      this.setProperty({
        property: 'relations',
        value: ['children.children.children.children'],
      });
      this.fetchAll();
    },
    handleEdit(item) {
      this.setSelected(item);
    },
    handleDelete(menu) {
      this.$confirm().then(() => {
        this.destroy(menu.id).then(() => {
         	this.$toast.success('menu deleted Successfully');
        });
      })
    },
    handleMenuOrderChange(value, option) {
        // console.log(value, option, 'data');
    }
  }
};
</script>
<template>
  <div>
    <h4>Menus</h4>
    <div class="row">
      <div class="col-6 card">
        <div class="card-body">
          <vue-nestable v-model="nestableItems" @change="handleMenuOrderChange">
            <vue-nestable-handle
              slot-scope="{ item }"
              :item="item">
              <div class="d-flex justify-content-between">
                {{ item.name }}
                <div class="actions">
                  <i class="bi bi-pencil me-2 cusrsor-pointer" @click="()=>handleEdit(item)"></i>
                  <i class="bi bi-trash cusrsor-pointer"  @click="()=>handleDelete(item)"></i>
                </div>
              </div>
            </vue-nestable-handle>
          </vue-nestable>
        </div>
      </div>
      
      <div class="col-4 offset-sm-1 card">
          <categories-create />
      </div>
    </div>
   
  </div>
</template>

<style lang="scss">
.nestable-item {
  border: 1px dotted #000;
  margin: 3px;
  padding: 5px;
}
</style>