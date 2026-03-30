<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import updateProperty from '../../../mixins/updateProperty';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import MenusFilter from './menusFilter.vue';
import { VueNestable, VueNestableHandle } from 'vue-nestable';
import MenusCreate from './menusCreate.vue';

export default {
  name: 'MenuIndex',
  components: {
    MenusFilter,
    VueNestable,
    VueNestableHandle,
    MenusCreate
  },
  mixins:[
    pageChange,
    updateProperty,
  ],
  
  computed: {
    ...mapState({
      menus: state => state.Menus.items,
      selected: state => state.Menus.selected,
      loading: state => state.Menus.loadingItems,
      user: state => state.authUser,
    }),
  },
  watch:{
    menus() {

      this.nestableItems = [...this.menus];

    }
  },
  data() {
    return {
       nestableItems: [],
       activeMenu: 2,
    };
  },
  created() {
    this.setPaginate(true);

    if(!this.activeMenu){
      this.setProperty({property: 'menuType', value: this.activeMenu});
    }
    
    this.fetchItems();
  },
  methods: {
    ...mapActions('Menus',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      this.setProperty({property: 'relations',value: ['children.children.children.children']});
      this.setProperty({property: 'filterMenuBy', value: 'parentOnly'});
      
      this.fetchAll();

    },
    handleEdit(item) {
      this.setSelected(item);
    },
    generateQrCode(item) {
      window.location='/generate-qr-code/' + item.id;
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
    },
    handleMenuFilter( value) {
      if(value){
        this.setProperty({property: 'menuType', value: value});
        this.activeMenu = value;
      }else {
        this.setProperty({property: 'menuType', value: null});
        this.activeMenu = null;
      }
      this.fetchAll();
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
          <div class="form-group">
            <label>Filter</label>
            <select class="form-control" name="type" @change="(e) => handleMenuFilter(e.target.value)" v-model="activeMenu">
              <option value=""></option>
              <option value="2">Service Menus</option>
              <option value="1">Products Menu</option>
            </select>
          </div>

          <hr/>
          <vue-nestable v-model="nestableItems" @change="handleMenuOrderChange">
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
                  <i class="bi bi-qr-code me-2 cursor-pointer" @click="()=>generateQrCode(item)"></i>
                  <i class="bi bi-pencil me-2 cursor-pointer" @click="()=>handleEdit(item)"></i>
                  <i class="bi bi-trash cursor-pointer"  @click="()=>handleDelete(item)"></i>
                </div>
              </div>
            </vue-nestable-handle>
          </vue-nestable>
        </div>
      </div>
      
      <div class="col-4 offset-sm-1 card">
          <menus-create />
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