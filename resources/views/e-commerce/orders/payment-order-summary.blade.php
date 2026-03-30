<div class="bg-white rounded-3 shadow-lg p-4 ms-lg-auto">
  <div class="py-2 px-xl-2">
    <div class="widget mb-3">
      <h2 class="widget-title text-center">Order summary</h2>

      <div class="d-flex align-items-center py-2 border-bottom" :key="index">

        <div class="ps-2">
          <h6 class="widget-product-title">
              Order Number:: {{ $response['order']->order_no }}
          </h6>
        </div>
      </div>

    </div>
    <ul class="list-unstyled fs-sm pb-2 border-bottom">
      <li class="d-flex justify-content-between align-items-center"><span class="me-2">Subtotal:</span><span class="text-end">{{ $response['order']->amount }}</span></li>
    </ul>
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="">Total Amount:</h5>
      <h5 class=""> Ksh {{ $response['order']->amount }} </h5>
    </div>
<!-- 
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="">Deposit:</h5>
      <h5 class=""></h5>
    </div> -->
    
  </div>
</div>