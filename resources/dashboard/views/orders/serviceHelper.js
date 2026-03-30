export default {
  methods: {
    selectService() {
      let orderLoad = {
        product: this.providerPricingSelected.product,
        provider: this.providerPricingSelected.provider,
        quantity: 1,
        type: 2,
        originalProviderCost: this.providerPricingSelected.provider_cost,
        originalProductPrice: this.providerPricingSelected.amount,
        productPricing: this.providerPricingSelected.amount,
        providerCost: this.providerPricingSelected.provider_cost,
        appointmentDate: null,
        appointmentTime: false,
      };
  
      if(this.providerPricingSelected.product.discount) {
        orderLoad = {...orderLoad,
          discounted: true,
          productPricing: this.providerPricingSelected.product.discount.payable,
        };
      }
  
      this.order.orderItems.push(orderLoad);
      this.orderServiceItemModal.hide();
      this.totalPayable();
    },
    addService() {
      this.orderServiceItemModal = new bootstrap.Modal(document.getElementById('selecteServiceModal'));
      this.orderServiceItemModal.show();
    },
    serviceItemChecked(item) {
      this.providerPricingSelected = item;
    },
  }
};