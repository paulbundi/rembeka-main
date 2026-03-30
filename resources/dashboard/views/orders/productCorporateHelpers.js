export default {
  methods: {
      addProduct() {
        this.orderProductItemModal = new bootstrap.Modal(document.getElementById('selecteProductModal'));
        this.orderProductItemModal.show();
      },
    selectProduct() {
      let orderLoad = {
        product: this.productPricingSelected.product,
        provider: this.productPricingSelected.supplier,
        quantity: 1,
        type: 1,
			  beneficiary:[],
        size: this.productPricingSelected.size,
        originalProductPrice: this.productPricingSelected.amount,
        originalProviderCost: this.productPricingSelected.supplier_price,
        productPricing: this.productPricingSelected.amount,
        providerCost: this.productPricingSelected.supplier_price,
        percentage_commission: this.productPricingSelected.mark_up_percentage,
        pricing_id: this.productPricingSelected.id,
      };
  
      if(this.productPricingSelected.product.discount) {
          orderLoad = {...orderLoad,
          discounted: true,
          productPricing: this.productPricingSelected.product.discount.payable,
        };
      }
  
      this.order.orderItems.push(orderLoad);
      this.orderProductItemModal.hide();
      this.totalPayable();
    },

    productItemChecked(item) {
      this.productPricingSelected = item;
    },
  }
};