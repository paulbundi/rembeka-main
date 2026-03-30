<script>
import { mapState } from 'vuex';
import MediaIndex from '../../../media/components/MediaIndex.vue'
  export default {
    name: 'attachments',
    components: { MediaIndex },
    computed:{
      ...mapState({
        selected: state => state.Products.selected,
      })
    },
    methods: {
      handleCheck(value) {
        this.$emit('attach', value);
      },
      handleDetach(value) {
        this.$emit('detach', value);
      }
    },
  };
</script>
<template>
  <div class="row mt-2">
    <div class="col-5">
      <div v-for="file in selected.attachments" :key="file.id">
        <div v-if="file.media" class="card mb-3" style="max-width: 540px;">
          <div class="row g-0">
            <div class="col-md-4">
              <img :src="`${file.media.url}`" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <h5 class="card-title">{{file.media.name}}</h5>
                  <i class="bi bi-trash2 cursor-pointer" @click="() => handleDetach(file.id)"></i>
                </div>
                <p class="card-text">{{ file.media.disk }}</p>
                <p class="card-text"><small class="text-muted">{{file.media.created_at |formatDate('LL') }}</small></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-7 fixed-height">
      <media-index @attach='handleCheck' hide-upload selectable/>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.fixed-height{
  max-height: 70vh;
  overflow-y:scroll;
}
</style>