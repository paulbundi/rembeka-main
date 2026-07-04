<script>
import { mapState, mapActions } from 'vuex'

  export default {
    name: 'ColorIndex',
    computed: {
      ...mapState({
        items: state => state.Colors.items,
        selected: state => state.Colors.selected,
      }),
    },
    created() {
      this.fetchAll();
    },
    methods: {
      ...mapActions('Colors', ['fetchAll', 'fetchOne', 'delete']),
      handleEdit(color) {
        this.fetchOne({ id: color.id });
      },
      handleDelete(color) {
        if (confirm('Are you sure?')) {
          this.delete({ id: color.id }).then(() => {
            this.fetchAll();
          });
        }
      },
    }
  };
</script>
<template>
  <div>
    <div class="card">
      <div class="card-body">
        <h4>Colors</h4>
        <a href="/dashboard/colors/create" class="btn btn-primary btn-sm mb-3">Add New Color</a>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Hex Code</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="color in items" :key="color.id">
              <td>{{ color.name }}</td>
              <td>
                <span v-if="color.hex_code" :style="`background-color: ${color.hex_code}; padding: 5px 10px; border-radius: 3px;`"></span>
                {{ color.hex_code || '-' }}
              </td>
              <td>
                <a :href="`/dashboard/colors/${color.id}/edit`" class="btn btn-sm btn-info">Edit</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>

</style>