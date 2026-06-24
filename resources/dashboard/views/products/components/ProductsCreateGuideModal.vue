<script>
export default {
  name: 'ProductsCreateGuideModal',
  props: {
    show: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<template>
  <!-- Bootstrap Modal -->
  <div class="modal fade" tabindex="-1" id="productCreateGuideModal" aria-labelledby="productCreateGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productCreateGuideModalLabel">
            How to Create a Product (Checklist)
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="alert alert-info py-2">
            Use this quick guide before/while creating a product in <b>/products/create</b>.
          </div>

          <div class="row g-3">
            <div class="col-12">
              <h6 class="text-dark fw-bold">1) Make sure the Brand exists</h6>
              <ol class="mb-0 ps-3">
                <li>Open <a class="text-primary" target="_blank" rel="noreferrer" href="https://rembekaonline.com/brands">Brands</a>.</li>
                <li>If your brand doesn’t exist, create it.</li>
              </ol>
            </div>

            <div class="col-12">
              <h6 class="text-dark fw-bold">2) Make sure the Menu exists</h6>
              <ol class="mb-0 ps-3">
                <li>Open <a class="text-primary" target="_blank" rel="noreferrer" href="https://rembekaonline.com/menus">Menus</a>.</li>
                <li>If your product’s menu/category doesn’t exist, create it.</li>
              </ol>
            </div>

            <div class="col-12">
              <h6 class="text-dark fw-bold">3) Make sure the Categories (Age Groups) exist</h6>
              <ol class="mb-0 ps-3">
                <li>In the UI, select the correct <b>Age Groups</b> / categories.</li>
                <li>If they are missing, create them from <b>Categories</b> in the admin.</li>
              </ol>
            </div>

            <div class="col-12">
              <h6 class="text-dark fw-bold">4) Create the Product</h6>
              <ol class="mb-0 ps-3">
                <li>Open <a class="text-primary" target="_blank" rel="noreferrer" href="https://rembekaonline.com/products/create">Create Product</a>.</li>
                <li>Fill required fields: name, description, SKU, Brand, Menu, Age Groups, and publish settings.</li>
                <li>Save the product and confirm it shows on the e-commerce side.</li>
              </ol>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <a
            class="btn btn-primary"
            href="https://rembekaonline.com/products/create"
            target="_blank"
            rel="noreferrer"
          >Go to /products/create</a>
        </div>
      </div>
    </div>
  </div>
</template>

