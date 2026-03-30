<template>
  <div>
 <div class="card">
      <div v-loading="loading" class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>Name</th>
                <th>Descriptions</th>
                <th>Parent Menu</th>
                <th>Status</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(menu, index) in menus" :key="index">
                <td>{{ menu.name }} </td>
                <td>{{ menu.description}}</td>
                <td>
                  <span v-if="menu.status == 1" class="badge bg-success"> Active </span>
                  <span v-else class="badge bg-danger"> Active </span>
                </td>
                <td>{{ menu.created_at | formatDate('LLLL') }} </td>
              </tr>
              </tbody>
          </table>
        </div>
        <pagination class="pull-left" module="Menus" @page-change="pageChange"/>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    
  }
</script>

<style lang="scss" scoped>

</style>