@extends('layouts.dashboard')
@section('content')
<div class="row">
     <div class="col-xl-6 col-xxl-6 d-flex">
          <div class="w-100">
               <div class="row">
                    <div class="col-sm-6">
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
                                        <span class="text-muted">Fullfield Order Amount</span>
                                        <hr/>
                                        <span class="text-primary"> {{ $fullfieldOrders }} - </span>
                                        <span class="text-muted">fullfilled Orders</span>
                                   </div>
                              </div>
                         </div>

                         <div class="card">
                              <div class="card-body">
                                   <div class="row">
                                        <div class="col mt-0">
                                             <h5 class="fw-bolder">Wallet Amount</h5>
                                        </div>

                                        <div class="col-auto">
                                             <div class="stat text-primary">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign align-middle"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                             </div>
                                        </div>
                                   </div>
                                   <hr/>
                                   <div class="d-flex mt-1 mb-1 justify-content-between text-primary">User Wallet <h4>{{ number_format($userWallet,2)}}</h4></div>
                                   <div class="d-flex mt-1 mb-1 justify-content-between text-warning">Provider Wallet <h4>{{ number_format($providerWallet,2)}}</h4> </div>
                                   <div class="d-flex mt-1 mb-1 justify-content-between text-info">Supplier Wallet <h4>{{ number_format($supplierWallet,2)}}</h4> </div>
                                   <div class="d-flex mt-1 mb-1 justify-content-between text-success">Corporate Wallet <h4>{{ number_format($corporateWallet,2)}}</h4></div>
                                   <hr/>
                                   <h5 class="text-dark fw-bolder">Holding accounts.</h5>
                                   <span class="text-primary mb-1">B2C Balance:</span> <b class="text-danger">{{ number_format($mpesaBalances?->mpesa_b2c ?? 0 ,2)}}</b><br/>
                                   <span class="text-success">C2B Balance:</span> <b class="text-danger">{{ number_format($mpesaBalances?->mpesa_c2b ?? 0 ,2)}}</b>
                                   <div class="mb-0">
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
                                             <hr/>
                                        @endforeach
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="col-sm-6">
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
                                                  <th>HomeCall <small>({{$orders ?? 0 }})</small></th>
                                                  <th>Franchise <small>({{$orders ?? 0 }})</small></th>
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
                                        <span class="text-dark h5"> {{ $userCount }} - </span>
                                        <span>Users</span>
                                        <hr/>
                                        <span class="text-dark h5"> {{ $providers }} - </span>
                                        <span>Providers</span>
                                        <hr/>
                                        <span class="text-dark h5"> {{ $corporates }} - </span>
                                        <span>Corporates</span>
                                        <hr/>
                                        <span class="text-dark h5"> <i class="mdi mdi-arrow-bottom-right"></i> {{ $providerInquries }} - </span>
                                        <span class="text-muted">Provider Inquiries</span>
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
                                        <span class="text-success">Services:</span> <b class="text-danger">{{ $services}}</b>
                                   </div>
                              </div>
                         </div>
                         <div class="card">
                              <div class="card-body">
                                   <div class="row">
                                        <div class="col mt-0">
                                             <h5 class="card-title">News Letter Subscriptions</h5>
                                        </div>

                                        <div class="col-auto">
                                             <div class="stat text-primary">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart align-middle"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                             </div>
                                        </div>
                                   </div>
                                   <h1 class="mt-1 mb-3">{{ $newsLetterSubscriptions }}</h1>
                                   <div class="mb-0">
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <div class="col-12 col-lg-6 col-xxl-6 d-flex">
          <div class="card flex-fill">
               <div class="card-header">
                    <h5 class="card-title mb-0">Search Tearms</h5>
               </div>
               <div class="card-body">
                    <table class="table table-striped my-0 table-search-analytics">
                         <thead>
                              <tr class="border-bottom">
                                   <th>Search Keyword</th>
                                   <th>User</th>
                                   <th>Date Searched</th>
                              </tr>
                         </thead>
                         <tbody>
                              @foreach($searchTearms as $terms)
                              <tr>
                                   <td>
                                        <small>{{$terms->search_term}}</small>
                                   </td>
                                   <td>
                                        @if($terms->user)
                                             <strong>{{ $terms->user->name }}</strong>
                                             <a href="{{ route('users.show', $terms->user->id) }}">
                                                  <i class="bi bi-binoculars"></i>
                                             </a>
                                        @endif
                                   </td>
                                   <td>
                                        <small>{{ date_format($terms->created_at, 'Y-m-d') }}</small>
                                   </td>
                              </tr>
                              @endforeach
                         </tbody>
                    </table>
                    {{ $searchTearms->links() }}
               </div>
          </div>
     </div>
</div>
@endsection

