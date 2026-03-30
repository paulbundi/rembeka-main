<script>
  export default {
    name: 'ProductTable',
    props: {
      product:{
        type:[Object, Array],
        required: true,
      },
    }
  };
</script>
<template>
  <div class="col-12">
    <div class="table-responsive single-item-table">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Menu</th>
                <th>Category</th>
                <th>Description</th>
                <th>SEO</th>
                <th>Cost of labour</th>
                <th>Provider Cost</th>
                <th>Commission(%)</th>
                <th>Platform Fee</th>
                <th>Listing Price</th>
              </tr>
            </thead>
            <tbody>
              <tr >
                <td>
                  {{product.id}}
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="me-2">
                      <div v-if="product.attachments  && product.attachments.length > 0">
                        <img class="rounded-circle" :src="`${product.attachments[0].media.url}`" width="80" height="80" />
                      </div>
                    </div>
                    <div>
                      <div class="d-flex">
                        <a v-if="canUserAccess('products.update')" :href="`/products/${product.id}`"> {{ product.name }} </a>
                        <span v-else>{{ product.name }}</span>
                        <div class="ms-1">
                          <small v-if="product.status != 1" class="badge bg-danger">In Active</small>
                          <small v-else class="badge bg-success">Active</small>
                        </div>
                      </div>
                      <small>sku:{{ product.sku }} </small><br/>

                      <div>
                        <span v-if="product.type== 1" class="badge bg-success">Product</span>
                        <span v-else class="badge bg-info">Service</span>
                      </div>
                      
                    </div>
                  </div>
                </td>

                <td>
                  <span v-if="product.menu">
                    {{ product.menu.name }}
                  </span>
                </td>

                <td>
                  <span v-if="product.category">
                    {{ product.category.name }}
                  </span>
                </td>

                <td>{{product.description}}</td>
                <td>
                  <p><span class="badge bg-info">Title:</span> {{ product.seo_title}}</p>
                  <p><span class="badge bg-info">Description:</span> {{ product.seo_description}}</p>
                </td>
                <td>{{product.cost_of_labour}}</td>
                <td>{{product.provider_cost}}</td>
                <td>{{product.commission}}</td>
                <td>{{product.platform_fee}}</td>
                <td>{{product.product_price}}</td>
                <td>
                </td>
              </tr>
            </tbody>
          </table>
    </div>
  </div>
</template>
<style lang="scss" scoped>

</style>