<script>import { stringify } from "postcss";

export default {
  name: 'GlobalModal',
  props: {
    showFooter:{
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      default:''
    }
  },
  data() {

  },
  mounted() {
    /* eslint-disable-next-line */
    this.modal = new bootstrap.Modal(this.$refs.modal, { backdrop: 'static' });
    this.modal.show();
  },
  methods: {
    handleEvent(payload) {
    },
    handleCancel() {
      this.modal.hide();
    },
  },
};
</script>

<template>
  <div
    ref="modal"
    class="modal fade"
    data-backdrop="static"
    data-keyboard="false"
    tabindex="-1"
    aria-hidden="true"
    id="dialogModal"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="border:none;padding-bottom:0;">
          <h5 class="modal-title">
            {{ title }}
          </h5>
        </div>
        <div class="modal-body">
          <slot></slot>
        </div>
        <div v-if="showFooter" class="modal-footer" style="border:none;padding-top:0;">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
            cancel
          </button>
          <button type="button" class="btn btn-outline-primary">
            save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
