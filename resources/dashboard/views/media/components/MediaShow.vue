<script>
import { mapActions, mapState } from 'vuex';
import catchValidationErrors from '../../../utils/catchValidationErrors';
export default {
  name: 'MediaShow',
  props: {
    id: {
      type: Number,
      required: true,
    }
  },
  data() {
    return{
      selectedRole: null,
    };
  },
  computed: {
    ...mapState({
      selected: state => state.Media.selected,
      user: state => state.authUser,
    }),
    isImage() {
      return this.selected.mime_type && this.selected.mime_type.startsWith('image/');
    },
    isVideo() {
      return this.selected.mime_type && this.selected.mime_type.startsWith('video/');
    },
    isAudio() {
      return this.selected.mime_type && this.selected.mime_type.startsWith('audio/');
    }
  },

  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions('Media', ['fetchOne', 'setProperty', 'attachRelations','removeItemRelations']),
    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['user', 'shop']
      });
      this.fetchOne({ id: this.id });
    },
  }
};
</script>
<template>
<div class="row">
  <div class="col-8">
    <div class="col-12">
      <div class="card card-body table-responsive single-item-table">
        <div class="col-12">
          <b>Media Details</b>
          <a v-if="canUserAccess('media.edit')" class="btn btn-sm btn-primary float-end" :href="`/media/${this.id}/edit`">Edit</a>
        </div>
        <table class="table table-striped">
            <tr>
              <td>File Name</td>
              <td>{{selected.name}}</td>
            </tr>
            <tr>
              <td>File Type</td>
              <td>{{selected.mime_type}}</td>
            </tr>
            <tr>
              <td>File Size</td>
              <td>{{selected.size}} bytes</td>
            </tr>
            <tr>
              <td>URL</td>
              <td><a :href="selected.url" target="_blank">{{selected.url}}</a></td>
            </tr>
            <tr>
              <td>Uploaded By</td>
              <td>{{selected.user ? selected.user.name : 'N/A'}}</td>
            </tr>
            <tr>
              <td>Created At</td>
              <td>{{selected.created_at}}</td>
            </tr>
        </table>
      </div>
    </div>
    <div class="col-12" v-if="selected.url">
      <div class="card">
        <div class="card-body">
          <b>Preview</b>
          <div class="mt-3">
            <img v-if="isImage" :src="selected.url" class="img-fluid" style="max-height: 400px;" />
            <video v-else-if="isVideo" :src="selected.url" controls class="img-fluid" style="max-height: 400px;"></video>
            <audio v-else-if="isAudio" :src="selected.url" controls></audio>
            <div v-else class="text-muted">
              <i class="fas fa-file"></i> File preview not available
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-4">
    <div class="card">
      <div class="card-body">
        <h5>File Information</h5>
        <p><strong>Disk:</strong> {{selected.disk}}</p>
        <p><strong>Path:</strong> {{selected.path}}</p>
        <p v-if="selected.alt_text"><strong>Alt Text:</strong> {{selected.alt_text}}</p>
        <p v-if="selected.description"><strong>Description:</strong> {{selected.description}}</p>
      </div>
    </div>
  </div>
</div>
</template>
<style>

</style>