<script>
import { mapActions } from 'vuex';
export default {
  name: 'WalletAuditFilter',
  methods: {
    ...mapActions('WalletAudits', ['setProperty', 'fetchAll']),
    handleAccountChange(userID) {
      this.setProperty({ property: 'userWallet', value: userID });
      this.fetchAll();
    },
    handleUserFilter(initiatorId) {
      this.setProperty({ property: 'Initiator', value: initiatorId });
      this.fetchAll();
    },
    handleClearFilter() {
      this.setProperty({ property: 'userWallet', value: null });
      this.setProperty({ property: 'Initiator', value: null });
      this.fetchAll();

    },
  }
};
</script>
<template>

  <div class="row">
    <div class="col-3">
      <label for="Account">Account</label>
        <remote-selector
          module="Users"
          label="name"
          :maltiple="false"
          input-class="form-control"
          @change="(e) => handleAccountChange(e)"
        />
    </div>
    <div class="col-3"><label for="Inquiries">Initiator</label>
      <remote-selector
        module="Users"
        label="name"
        input-class="form-control"
        :maltiple="false"
        @change="(e) => handleUserFilter(e)"
      />
    </div>
    <div class="col-3">
      <button class="btn btn-sm btn-primary" @click="handleClearFilter">Clear</button>
    </div>
  </div>
  
</template>
<style>

</style>