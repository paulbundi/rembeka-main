              <!-- Order summary + payment-->
              <div class="col-xl-5 offset-xl-1 mb-2">
                <div class="bg-light rounded-3 py-5 px-4 px-xxl-5">
                  <h2 class="h5 pb-3">Your order</h2>
                  <div class="d-flex align-items-center pb-2 border-bottom"><a class="d-block flex-shrink-0" href=""><img src="img/grocery/cart/th01.jpg" width="64" alt="Product"></a>
                    <div class="ps-2">
                      <h6 class="widget-product-title"><a href="">Frozen Oven-ready Poultry</a></h6>
                      <div class="widget-product-meta"><span class="text-accent me-2">$15.<small>00</small></span><span class="text-muted">x 1</span></div>
                    </div>
                  </div>
                  <div class="d-flex align-items-center py-2 border-bottom"><a class="d-block flex-shrink-0" href=""><img src="img/grocery/cart/th02.jpg" width="64" alt="Product"></a>
                    <div class="ps-2">
                      <h6 class="widget-product-title"><a href="">TNut Chocolate Paste (750g)</a></h6>
                      <div class="widget-product-meta"><span class="text-accent me-2">$6.<small>50</small></span><span class="text-muted">x 1</span></div>
                    </div>
                  </div>
                  <div class="d-flex align-items-center py-2 border-bottom"><a class="d-block flex-shrink-0" href=""><img src="img/grocery/cart/th03.jpg" width="64" alt="Product"></a>
                    <div class="ps-2">
                      <h6 class="widget-product-title"><a href="">Mozzarella Mini Cheese</a></h6>
                      <div class="widget-product-meta"><span class="text-accent me-2">$3.<small>50</small></span><span class="text-muted">x 1</span></div>
                    </div>
                  </div>
                  <ul class="list-unstyled fs-sm pt-4 pb-2 border-bottom">
                    <li class="d-flex justify-content-between align-items-center"><span class="me-2">Subtotal:</span><span class="text-end fw-medium">$25.<small>00</small></span></li>
                    <li class="d-flex justify-content-between align-items-center"><span class="me-2">Delivery:</span><span class="text-end fw-medium">$7.<small>00</small></span></li>
                  </ul>
                  <h3 class="fw-normal text-center my-4 py-2">$32.<small>00</small></h3>
                  <div class="accordion accordio-flush shadow-sm rounded-3 mb-4" id="payment-methods">
                    <div class="accordion-item border-bottom">
                      <div class="accordion-header py-3 px-3">
                        <div class="form-check d-table" data-bs-toggle="collapse" data-bs-target="#credit-card">
                          <input class="form-check-input" type="radio" name="license" id="payment-card" checked>
                          <label class="form-check-label fw-medium text-dark" for="payment-card">Credit card<i class="ci-card text-muted fs-lg align-middle mt-n1 ms-2"></i></label>
                        </div>
                      </div>
                      <div class="collapse show" id="credit-card" data-bs-parent="#payment-methods">
                        <div class="accordion-body py-2">
                          <input class="form-control bg-image-none mb-3" type="text" placeholder="Card number">
                          <div class="row">
                            <div class="col-6 mb-3">
                              <input class="form-control bg-image-none" type="text" placeholder="MM/YY">
                            </div>
                            <div class="col-6 mb-3">
                              <input class="form-control bg-image-none" type="text" placeholder="CVC">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item border-bottom">
                      <div class="accordion-header py-3 px-3">
                        <div class="form-check d-table" data-bs-toggle="collapse" data-bs-target="#paypal">
                          <input class="form-check-input" type="radio" name="license" id="payment-paypal">
                          <label class="form-check-label fw-medium text-dark" for="payment-paypal">PayPal<i class="ci-paypal text-muted fs-base align-middle mt-n1 ms-2"></i></label>
                        </div>
                      </div>
                      <div class="collapse" id="paypal" data-bs-parent="#payment-methods">
                        <div class="accordion-body pt-2"><a class="btn btn-primary btn-sm" href="#">Proceed with PayPal</a></div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <div class="accordion-header py-3 px-3">
                        <div class="form-check d-table" data-bs-toggle="collapse" data-bs-target="#cash">
                          <input class="form-check-input" type="radio" name="license" id="payment-cash">
                          <label class="form-check-label fw-medium text-dark" for="payment-cash">Cash on delivery<i class="ci-wallet text-muted fs-lg align-middle mt-n1 ms-2"></i></label>
                        </div>
                      </div>
                      <div class="collapse" id="cash" data-bs-parent="#payment-methods">
                        <div class="accordion-body pt-2">
                          <p class="fs-sm mb-0">I will pay with cash to the courier on delivery.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="pt-2">
                    <button class="btn btn-primary d-block w-100" type="submit">Place Order</button>
                  </div>
                </div>
              </div>