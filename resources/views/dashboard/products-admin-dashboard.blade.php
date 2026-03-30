@extends('layouts.dashboard')
@section('content')
<div class="row">
     <div class="col-sm-4">
          <div class="card">
               <div class="card-body">
                    <div class="row">
                         <div class="col mt-0">
                              <h5 class="card-title fw-bolder">Orders</h5>
                         </div>

                         <div class="col-auto">
                              <div class="stat text-primary">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck align-middle"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                              </div>
                         </div>
                    </div>
                    @php
                         $sumAmount = 0;
                         $totalOrders = 0;

                         foreach($orderSum as $orderSumAmount){
                              $sumAmount += $orderSumAmount->total;
                         }

                         foreach($orders as $orderCount){
                              $totalOrders += $orderCount->orders;
                         }
                    @endphp


                    <h1 class="mt-1 mb-3">Ksh {{number_format($sumAmount)}}</h1>
                    <h5>Total Orders: {{$totalOrders}}</h5>

                    <div class="mb-0">
                         @foreach($orderSum as $ordersDistribution)
                              @if($ordersDistribution->store_id == null)
                                   <div class="d-flex justify-content-around">
                                        <b>Homecall:</b><b> {{ number_format($ordersDistribution->total, 2)}}</b>
                                   </div>
                              @else
                              <div class="d-flex justify-content-around">
                                   <b>Franchise:</b><b>{{number_format($ordersDistribution->total, 2)}}</b>
                              </div>
                              @endif
                         @endforeach
                    </div>
               </div>
          </div>

          <div class="card">
               <div class="card-body">
                    <div class="row">
                         <div class="col mt-0">
                              <h5 class="card-title fw-bolder">Collections</h5>
                         </div>

                         <div class="col-auto">
                              <div class="stat text-primary">
                                   <i class="bi bi-piggy-bank fs-3"></i>
                              </div>
                         </div>
                    </div>
                    <h1 class="mt-1 mb-3">Ksh {{number_format($collectionSum)}}</h1>
                    <div class="mb-0">
                         <span class="text-success"> {{ number_format($sumOfFullfieldOrders, 2) }} - </span>
                         <span class="text-muted">FulFilled Order Amount</span>
                         <hr/>
                         <span class="text-primary"> {{ $fullfieldOrders }} - </span>
                         <span class="text-muted">fulfilled Orders</span>
                    </div>
               </div>
          </div>

          <div class="card">
               <div class="card-body">
                    <div class="row">
                         <div class="col mt-0">
                              <h4 class="card-title fw-bolder"> {{ $inquries }} Inquries</h4>
                         </div>

                         <div class="col-auto">
                              <div class="stat text-primary">
                              <i class="bi bi-book-half"></i>
                              </div>
                         </div>
                    </div>

                    <h1 class="mt-1 mb-3">
                    @php
                         $sum = 0;
                         $convertedAmount = 0;
                         $inquiryByChannels->each(function($item) use(&$sum){
                              $sum +=$item->total;
                         })
                    @endphp
                    Ksh {{ number_format($sum) }}
               </h1>
                    <div class="mb-0">
                         @foreach($inquiryByChannels as $byChannel)
                              <span class="text-success"> {{ number_format($byChannel->total, 2) }} - </span>
                              <span class="text-muted">{{ $byChannel->channel->name }}</span>
                              <hr class="my-1"/>
                         @endforeach
                    </div>
               </div>
          </div>


          <div class="card">
               <div class="card-body">
                    <div class="row">
                         <div class="col mt-0">
                              <h5 class="card-title fw-bolder">Platform Accounts</h5>
                         </div>

                         <div class="col-auto">
                              <i class="bi bi-people"></i>
                         </div>
                    </div>
                    <div class="mb-0 border-top pt-2">
                         <span class="text-dark fw-bolder"> {{ $users }} - </span>
                         <span>Product Customers</span>
                         <hr/>
                         <span class="text-dark fw-bolder"> {{ $suppliers }} - </span>
                         <span>Suppliers</span>
                         <hr/>
                         <span class="text-dark fw-bolder"> {{  number_format($supplierWallet) }} - </span>
                         <span>Suppliers Wallet</span>
                         <hr/>
                    </div>
               
               </div>
          </div>


          <div class="card">
               <div class="card-body">
                    <div class="row">
                         <div class="col mt-0">
                              <h5 class="card-title fw-bolder">Merchandise</h5>
                         </div>

                         <div class="col-auto">
                              <div class="stat text-primary">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart align-middle"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                              </div>
                         </div>
                    </div>
                    <div class="mb-0">
                         <span class="text-primary">Products:</span> <b class="text-danger">{{ $products}}</b><br/>
                    </div>
               </div>
          </div>

          
     </div>
     <div class="col-sm-4">


          <div class="card">
               <div class="card-body">
                    <div class="row">
                         <div class="col mt-0">
                              <h4 class="card-title fw-bolder">Top Twenty By Volume</h4>
                         </div>

                         <div class="col-auto">
                              <div class="stat text-primary">
                              <i class="bi bi-book-half"></i>
                              </div>
                         </div>
                    </div>
                    <div class="mb-0">
                         @foreach($topTwentyByVolume as $item)
                              <span class="text-success"> {{ $item->qty }} - </span>
                              <span class="text-muted">{{ $item->product->name }}</span>
                              <hr class="my-1"/>
                         @endforeach
                    </div>
               </div>
          </div>

          <div class="card">
               <div class="card-body">
                    <div class="row">
                         <div class="col mt-0">
                              <h4 class="card-title fw-bolder">Top Ten By Value</h4>
                         </div>

                         <div class="col-auto">
                              <div class="stat text-primary">
                              <i class="bi bi-book-half"></i>
                              </div>
                         </div>
                    </div>
                    <div class="mb-0">
                         @foreach($topTenByValue as $item)
                              <span class="text-success"> {{ number_format($item->amount) }} - </span>
                              <span class="text-muted">{{ $item->product->name }}</span>
                              <hr class="my-1"/>
                         @endforeach
                    </div>
               </div>
          </div>

          
     </div>

     <div class="col-sm-4">
          <div class="card">
               <div class="card-body">
                    <div class="row">
                         <div class="col mt-0">
                              <h5 class="card-title fw-bolder">Order By Channel</h5>
                         </div>

                         <div class="col-auto">
                              <div class="stat text-primary">
                                   <i class="bi bi-funnel fs-3"></i>
                              </div>
                         </div>
                    </div>
                    <div class="mb-0">
                         <table class="table table-striped table-analytics">
                              <thead>
                                   <th>Channel</th>
                                   <th>HomeCall <small>({{$orders }})</small></th>
                                   <th>Franchise <small>({{$orders }})</small></th>
                              </thead>
                              <tbody>
                                   @foreach($orderByChannel as $channel)
                                        <tr>
                                             <td><small>{{$channel->name }}</small></td>
                                             <td colspan="2">
                                                  <div class="row">
                                                       @foreach($channel->orders as $order)
                                                            @if($order->store_id == null)
                                                                 <div class="col-6 py-0 font-weight-bold"> {{ number_format($order->total)}} </div>
                                                            @else
                                                                 <div class="col-6 py-0"> {{number_format($order->total)}} </div>
                                                            @endif
                                                       @endforeach
                                                  </div>
                                             </td>
                                        </tr>
                                   @endforeach
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>
@endsection

