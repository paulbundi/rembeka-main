<script>
import {mapState, mapActions} from 'vuex';
import pageChange from '../../../mixins/pageChange';
import catchValidationErrors from '../../../utils/catchValidationErrors';
import MediaFilter from './MediaFilter.vue';
import vueDropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import updateProperty from '../../../mixins/updateProperty';
import InputFilter from '../../generals/InputFilter.vue';

export default {
  name: 'MediaIndex',
  components: {
    MediaFilter,
    vueDropzone,
    InputFilter,
  },
  props:{
    hideUpload: {
      type: Boolean,
      default:false,
    },
    singleItem: {
      type: Boolean,
      default:false,
    },
    selectable:
    {
      type: Boolean,
      default: false,
    },
    label: {
      type: String,
      default: 'attach'
    }
  },
  mixins: [
    pageChange,
    updateProperty,
  ],
  data() {
    return {
      selectedIds: [],
      dropzoneOptions: {
          url: '/media-upload',
          thumbnailWidth: 150,
          maxFilesize: 0.5,
          headers: { 
            "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content
           }
      }
    };
  },
  computed: {
    ...mapState({
      items: state => state.Media.items,
      searchStr: state => state.Media.searchStr,
      loading: state => state.Media.loadingItems,
      user: state => state.authUser,
    }),
  },
  created() {
    this.setPaginate(true);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Media',['fetchAll', 'setProperty', 'persist', 'destroy', 'setSelected', 'resetSelected', 'setPaginate']),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['user'],
      });
      this.setProperty({property: 'sorts', value:['-id']});
      this.fetchAll();
    },
    handleSuccess(file, response) {
      if(response == 'success') {
        this.fetchItems();
      }
    },
    deleteMedia(media) {
      this.destroy(media.id).then(() => {
        this.$toast.success('Success');
        this.fetchItems();
      }).catch(({response}) => {
          catchValidationErrors(this, response);
        
      })
    },
    handleCheckBox(event , media) {
      if(this.singleItem) {
        this.selectedIds = media;
        return;
      }
      if(this.selectedIds.indexOf(media.id) == -1) {
        this.selectedIds.push(media.id);
      }else {
        this.selectedIds.pop(this.selectedIds.indexOf(media.id));
      }
    },
    handleAttach() {
      this.$emit('attach', this.selectedIds);
    }
  }
};
</script>
<template>
  <div>
    <div v-if="!hideUpload" class="col-12">
      <div class="card card-danger">
        <div class="card-body">
          <h4 class="card-heading">Add asset</h4>
          <vue-dropzone 
            ref="myVueDropzone"
            id="dropzone"
            :options="dropzoneOptions"
            @vdropzone-success="handleSuccess"
          />
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="d-flex">
          <div class="col-6">
            <button v-if="hideUpload" 
              class="btn btn-sm bg-success text-white" 
              type="button"
              @click="handleAttach"
            >
              {{label}}
            </button>
          </div>
          <div class="col-6">
          <div class="form-group float-end">
            <input-filter
              module="Media"
              label="Name"
              class="me-3"
            />
          </div>
          </div>
        </div>
        <div v-loading="loading" class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th v-if="!hideUpload">path</th>
                <th>User</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="media in items" :key="media.id">
                <td>
                  <input type="checkbox" 
                    :checked="singleItem ? selectedIds.id == media.id : selectedIds.indexOf(media.id) != -1" 
                    :value="media.id"
                    @change="(e)=> handleCheckBox(e,media)" 
                  />
                  {{media.id}}
                </td>
                <td>
                  <img class="rounded" :src="media.url" width="80" height="80" /><br/>
                  {{media.name}}<br/>
                  <small>{{media.created_at| formatDate('LL')}}</small>
                </td>
                <td v-if="!hideUpload">{{media.url}}</td>
                <td>
                  <span v-if="media.user">
                    {{ media.user.name }}
                  </span>
                </td>
                <td>
                <div class="dropdown show">
                    <a href="#" data-bs-toggle="dropdown"  :id="`dropdownAction${media.id}`" data-bs-display="static" aria-expanded="false" class="">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" :aria-labelledby="`dropdownAction${media.id}`">
                      <a v-if="canUserAccess('media.update')" class="dropdown-item" :href="`/users/${media.id}`">view</a>
                      <a v-if="canUserAccess('media.update')" class="dropdown-item" :href="`/users/${media.id}/edit`">Edit</a>
                      <a class="dropdown-item" href="#" @click="()=>deleteMedia(media)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Media" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<style>

</style>