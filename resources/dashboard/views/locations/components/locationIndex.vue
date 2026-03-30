<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import updateProperty from '../../../mixins/updateProperty';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import { VueNestable, VueNestableHandle } from 'vue-nestable';
import LocationCreate from './locationCreate.vue';

export default {
  name: 'LocationIndex',
  components: {
    VueNestable,
    VueNestableHandle,
    LocationCreate,
  },
  mixins:[
    pageChange,
    updateProperty,
  ],
  data() {
    return {
       nestableItems: []
    };
  },
  computed: {
    ...mapState({
      locations: state => state.Locations.items,
      selected: state => state.Locations.selected,
      loading: state => state.Locations.loadingItems,
      user: state => state.authUser,
    }),
  },
  watch:{
    locations() {
      this.nestableItems = [...this.locations];
    }
  },

  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Locations',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

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
    handleDelete(location) {
      this.$confirm().then(() => {
        this.destroy(location.id).then(() => {
         	this.$toast.success('location deleted Successfully');
        });
      })
    },
    handleLocationOrderChange(value, option) {
        // console.log(value, option, 'data');
    }
  }
};
</script>
<template>
  <div>
    <h4>Locations</h4>
    <div class="row">
      <div class="col-6 card">
        <div class="card-body">
          <vue-nestable v-model="nestableItems">
            <vue-nestable-handle
              slot-scope="{ item }"
              :item="item">
              <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                  <div v-html="item.icon" class="me-2"></div>
                  {{ item.name }}
                  {{item.status}}
                   <span v-if="item.status == 1" class="badge bg-success text-success rounded-circle">.</span>
                  <span v-else class="badge bg-danger text-danger rounded-circle"> . </span>
                </div>
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
          <location-create />
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