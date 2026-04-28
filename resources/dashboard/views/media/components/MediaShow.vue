<script>
import { mapActions, mapState } from 'vuex';
import catchValidationErrors from '../../../utils/catchValidationErrors';
export default {
  name: 'MediaShow',
  props: {
    id: {
      type: [Number, String],
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
    mediaData() {
      // Fallback if selected is empty
      return this.selected || {};
    },
    isImage() {
      return this.mediaData.mime_type && this.mediaData.mime_type.startsWith('image/');
    },
    isVideo() {
      return this.mediaData.mime_type && this.mediaData.mime_type.startsWith('video/');
    },
    isAudio() {
      return this.mediaData.mime_type && this.mediaData.mime_type.startsWith('audio/');
    }
  },

  created() {
    console.log('MediaShow created with id:', this.id);
    this.fetchItems();
  },
  methods: {
    ...mapActions('Media', ['fetchOne', 'setProperty', 'attachRelations','removeItemRelations']),
    fetchItems() {
      console.log('Fetching media item with id:', this.id);
      this.setProperty({
        property: 'relations',
        value: ['user']
      });
      this.fetchOne({ id: this.id }).then((response) => {
        console.log('Media data fetched:', response);
      }).catch((error) => {
        console.error('Error fetching media:', error);
      });
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
          <a v-if="canUserAccess('media.edit')" class="btn btn-sm btn-primary float-end" :href="`/medias/${this.id}/edit`">Edit</a>
        </div>
        <table class="table table-striped">
            <tr>
              <td>File Name</td>
              <td>{{mediaData.name || 'N/A'}}</td>
            </tr>
            <tr>
              <td>File Type</td>
              <td>{{mediaData.mime_type || 'N/A'}}</td>
            </tr>
            <tr>
              <td>File Size</td>
              <td>{{mediaData.size ? (mediaData.size + ' bytes') : 'N/A'}}</td>
            </tr>
            <tr>
              <td>URL</td>
              <td><a v-if="mediaData.url" :href="mediaData.url" target="_blank">{{mediaData.url}}</a><span v-else>N/A</span></td>
            </tr>
            <tr>
              <td>Uploaded By</td>
              <td>{{(mediaData.user && mediaData.user.name) ? mediaData.user.name : 'N/A'}}</td>
            </tr>
            <tr>
              <td>Created At</td>
              <td>{{mediaData.created_at || 'N/A'}}</td>
            </tr>
        </table>
      </div>
    </div>
    <div class="col-12" v-if="mediaData.url">
      <div class="card">
        <div class="card-body">
          <b>Preview</b>
          <div class="mt-3">
            <img v-if="isImage" :src="mediaData.url" class="img-fluid" style="max-height: 400px;" />
            <video v-else-if="isVideo" :src="mediaData.url" controls class="img-fluid" style="max-height: 400px;"></video>
            <audio v-else-if="isAudio" :src="mediaData.url" controls></audio>
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
        <p><strong>Disk:</strong> {{mediaData.disk || 'N/A'}}</p>
        <p><strong>Path:</strong> {{mediaData.path || 'N/A'}}</p>
        <p v-if="mediaData.alt_text"><strong>Alt Text:</strong> {{mediaData.alt_text}}</p>
        <p v-if="mediaData.description"><strong>Description:</strong> {{mediaData.description}}</p>
      </div>
    </div>
  </div>
</div>
</template>
<style>

</style>