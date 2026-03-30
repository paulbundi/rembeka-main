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
        providerDiscountAmount: 0,
        appointmentDate: null,
        appointmentTime: false,
        provider_discount: null,
        beneficiary:[],
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
    updateProviderPricing(payload ){// value,item, index
      const value = payload.value;
      const index = payload.index;
      const item = this.order.orderItems[index];

      let providerPricing =  item.originalProductPrice;
      let providerDiscount = 0;

      if(value == '' || value == 0) {
        providerPricing =  item.originalProductPrice;
      } else {
        providerDiscount	= item.originalProviderCost * (value / 100);
        providerPricing = item.originalProductPrice - providerDiscount;
      }

      let order = this.order;
      order.orderItems[index] = {...order.orderItems[index], productPricing: providerPricing , provider_discount: value, providerDiscountAmount: providerDiscount};
      this.order = {...order};
      this.totalPayable();
    },
    handleUpdateQuantity(payload) { //value, item, index
      const value = payload.quantity;
      const index = payload.index;
      const item = this.order.orderItems[index];
      let providerDiscount = 0;

      if(item.provider_discount) {
        providerDiscount = value * (item.originalProviderCost * (item.provider_discount / 100));
      }

      const order = this.order;
      order.orderItems[index] = {...order.orderItems[index], quantity:value, providerDiscountAmount: providerDiscount };
      this.order = {...order};
      this.totalPayable();
    },
    addService() {
      this.orderServiceItemModal = new bootstrap.Modal(document.getElementById('selecteServiceModal'));
      this.orderServiceItemModal.show();
    },
    serviceItemChecked(item) {
      this.providerPricingSelected = item;
    },
    removeOrderItem(index) {
      this.order.orderItems.splice(index, 1);
      this.totalPayable();
    },
    calculateTransport() {
			if(this.selected.has_transport_cost != 1) {
				return this.totalTransport = 0;
			}

			if(this.order.orderItems.length < 1) {
			return this.totalTransport = 0;
			}

			let serviceItems = this.order.orderItems.filter(item => item.type == 2);
			if(serviceItems.length == 0) {
				return 0;
			}
			let providerIds = [];
			serviceItems.map((item) => {
				if(item.assistStylist) {
					providerIds.push(item.assistStylist.id);
				}
				providerIds.push(item.provider.id);
			});

			const unique = [...new Set(providerIds)];

			if(unique.length > 0) {
			return this.totalTransport =  unique.length * 300;
			}
			this.totalTransport =  unique.length * 300;
	},
    totalPayable() {
      let payableAmount = 0;
      let referralCodeDiscount = 0;

      if(this.order.orderItems || this.order.orderItems.length > 0) {
        this.order.orderItems.forEach((item) => {
          let amount = item.quantity *  (item.assistStylist ? item.assistStylist.newPrice :item.productPricing);
          payableAmount += amount;
          console.log(amount, this.selectedReferral);
            if (item.type == 2 && !item.discounted && this.selectedReferral && this.selectedReferral.id) {
              referralCodeDiscount +=  amount * (this.selectedReferral.referred_first_visit_discount / 100)
              console.log("we here in", referralCodeDiscount);
            }
        });
      }

      this.calculateTransport();
      payableAmount += this.totalTransport;

      if(this.deliveryAmount) {
        payableAmount += parseInt(this.deliveryAmount);
      }
      console.log("we total in", referralCodeDiscount);

      this.referralDiscountAmount = referralCodeDiscount;
      this.totalAmount = payableAmount - referralCodeDiscount;

      return this.payableAmount;
    },
  }
};