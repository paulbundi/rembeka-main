<script>
  export default {
    name:'ProviderLocation',
    props: {
      providerLocation:{
        type: [Object,Array],
        default: null,
      },
      selectedLocation: {
        type: Number,
        default: null,
      }
    }
  }
</script>
<template>
  <div class="card card-body table-responsive single-item-table">
    <div class="col-12">
      <b>Provider Locations(Shops)</b>
      <a v-if="canUserAccess('provider.locations')" class="btn btn-sm btn-primary float-end" :href="`/schools/${this.id}/edit`">Edit</a>
    </div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Location</th>
          <th>Shop name</th>
          <th>Craeted At</th>
        </tr>
      </thead>
      <template  v-for="location in providerLocation">
        <tr :key="location.id" :class="{ 'selected-location' :location.id == selectedLocation}">
          <td>{{ location.id }}</td>
          <td>{{ location.name }}</td>
          <td>{{ location.created_at | formatDate('LL') }}</td>
        </tr>
      </template>
    </table>
  </div>
</template>
<style lang="scss" scoped>
.selected-location{
  background: silver;
}
</style>