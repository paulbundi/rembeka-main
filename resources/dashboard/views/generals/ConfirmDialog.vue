<script>
export default {
  name: 'ConfirmDialog',
  data() {
    return {
      title: '',
      message: '',
      cancel: '',
      confirm: '',
      confirmPromise: null,
      rejectPromise: null,
      modal: null,
    };
  },
  created() {
    this.$bus.$on('confirm', (e) => this.handleEvent(e));
  },
  mounted() {
    /* eslint-disable-next-line */
    this.modal = new bootstrap.Modal(this.$refs.modal, { backdrop: 'static' });
  },
  methods: {
    handleEvent(payload) {
      this.title = payload.title || 'Hi there,';
      this.message = payload.message || 'Are you sure?';
      this.cancel = payload.cancel || 'Cancel';
      this.confirm = payload.confirm || 'Confirm';
      this.confirmPromise = payload.resolve;
      this.rejectPromise = payload.reject;
      this.modal.show();
    },
    handleConfirm() {
      this.confirmPromise();
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
          {{ message }}
        </div>
        <div class="modal-footer" style="border:none;padding-top:0;">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
            {{ cancel }}
          </button>
          <button type="button" class="btn btn-outline-primary" @click.prevent="handleConfirm">
            {{ confirm }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
