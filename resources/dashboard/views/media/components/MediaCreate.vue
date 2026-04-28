<script>
import { mapActions, mapState } from 'vuex';
import updateProperty from '../../../mixins/updateProperty';
import catchValidationErrors from '../../../utils/catchValidationErrors';

export default {
  name: 'MediaCreate',
  props: {
    id: {
      type: [Number, String],
      default: null,
    }
  },
  mixins: [
    updateProperty,
  ],
  computed: {
    ...mapState({
      selected: state => state.Media.selected,
      loading: state => state.Media.loadingItem,
      user: state => state.authUser,
    }),
    mediaData() {
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
    },
    isEditing() {
      return !!this.id;
    }
  },
  created() {
    if (this.isEditing) {
      this.fetchItems();
    } else {
      this.resetSelected();
    }
  },
  methods: {
    ...mapActions('Media', ['fetchOne', 'persist', 'setProperty', 'resetSelected']),

    fetchItems() {
      this.setProperty({
        property: 'relations',
        value: ['user'],
      });
      this.fetchOne({ id: this.id });
    },

    saveMedia() {
      if (!this.mediaData.name || this.mediaData.name.trim() === '') {
        this.$toast.error('File name is required');
        return;
      }

      this.persist().then(() => {
        this.$toast.success(this.isEditing ? 'Media updated successfully' : 'Media created successfully');
        setTimeout(() => {
          window.location = '/medias';
        }, 500);
      }).catch(({ response }) => {
        catchValidationErrors(this, response);
      });
    },

    handleImageError(event) {
      event.target.style.display = 'none';
    },
  }
};
</script>

<template>
  <div class="row">
    <div class="col-8">
      <div class="card">
        <div class="card-body">
          <h4>{{ isEditing ? 'Edit Media' : 'Create Media' }}</h4>
          <div v-loading="loading">
            <form @submit.prevent="saveMedia">
              <div class="row">
                <div class="col-12">
                  <!-- File Preview -->
                  <div v-if="mediaData.url" class="mb-3 text-center">
                    <img 
                      v-if="isImage" 
                      :src="mediaData.url" 
                      class="img-fluid rounded" 
                      style="max-height: 300px;"
                      @error="handleImageError"
                    />
                    <video 
                      v-else-if="isVideo" 
                      :src="mediaData.url" 
                      controls 
                      class="img-fluid" 
                      style="max-height: 300px;"
                    />
                    <audio 
                      v-else-if="isAudio" 
                      :src="mediaData.url" 
                      controls
                    />
                    <div v-else class="text-muted p-4 bg-light rounded">
                      <i class="fas fa-file fa-3x"></i>
                      <p class="mt-2">File preview not available</p>
                    </div>
                  </div>

                  <!-- Name Field -->
                  <div class="form-group mb-3">
                    <label>File Name <span class="text-danger">*</span></label>
                    <input 
                      class="form-control" 
                      type="text" 
                      :value="mediaData.name" 
                      @input="(e) => updateProperty('name', e.target.value)"
                      placeholder="Enter file name"
                      required
                    >
                  </div>

                  <!-- Read-only Metadata -->
                  <div v-if="isEditing" class="card bg-light mb-3">
                    <div class="card-body">
                      <h6 class="card-title">File Metadata</h6>
                      <div class="row">
                        <div class="col-6">
                          <p class="mb-1"><strong>Type:</strong> {{ mediaData.mime_type || 'N/A' }}</p>
                          <p class="mb-1"><strong>Size:</strong> {{ mediaData.size ? (mediaData.size + ' bytes') : 'N/A' }}</p>
                          <p class="mb-1"><strong>Extension:</strong> {{ mediaData.extension || 'N/A' }}</p>
                        </div>
                        <div class="col-6">
                          <p class="mb-1"><strong>Disk:</strong> {{ mediaData.disk || 'N/A' }}</p>
                          <p class="mb-1"><strong>Path:</strong> {{ mediaData.path || 'N/A' }}</p>
                          <p class="mb-1"><strong>Uploaded By:</strong> {{ (mediaData.user && mediaData.user.name) ? mediaData.user.name : 'N/A' }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <a href="/medias" class="btn btn-secondary me-2">Cancel</a>
                  <button type="submit" class="btn btn-primary" :disabled="loading">
                    {{ isEditing ? 'Update' : 'Create' }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar with URL and actions -->
    <div v-if="isEditing && mediaData.url" class="col-4">
      <div class="card">
        <div class="card-body">
          <h5>File URL</h5>
          <div class="input-group mb-3">
            <input 
              type="text" 
              class="form-control form-control-sm" 
              :value="mediaData.url" 
              readonly
            >
            <button 
              class="btn btn-outline-secondary btn-sm" 
              type="button"
              @click="() => { navigator.clipboard.writeText(mediaData.url); $toast.success('URL copied!'); }"
            >
              Copy
            </button>
          </div>
          <a :href="mediaData.url" target="_blank" class="btn btn-sm btn-outline-primary w-100">
            Open File
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
</style>

