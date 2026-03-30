@extends('layouts.dashboard')
@section('content')
<div class="row">
     <div class="col-xl-6 col-xxl-5 d-flex">
          <div class="w-100">
               <div class="row">
               <div class="col-12">
                    <div class="card">
                         <div class="card-body">
                              <b>{{ $user->name }}</b><br/>
                              <small>{{ $user->email }}</small><br/>
                              <small>{{ $user->phone }}</small>
                         </div>
                    </div>
                    </div>
                    <div class="col-sm-6">
                         <div class="card">
                              <div class="card-body">
                                   <div class="row">
                                        <div class="col mt-0">
                                             <h5 class="card-title text-primary">Earnings</h5>
                                        </div>

                                        <div class="col-auto">
                                             <div class="stat text-primary">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign align-middle"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                             </div>
                                        </div>
                                   </div>
                                   @if($completedOrders)
                                        <h1 class="mt-1 mb-3">Ksh {{number_format($earnings,2)}}</h1>
                                   @else
                                        <h1 class="mt-1 mb-3">0</h1>
                                   @endif
                                   <div class="mb-0">
                                   </div>
                              </div>
                         </div>

                         <div class="card">
                              <div class="card-body">
                                   <div class="row">
                                        <div class="col mt-0">
                                             <h5 class="card-title">Fullfilled Orders</h5>
                                        </div>

                                        <div class="col-auto">
                                             <div class="stat text-primary">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users align-middle"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                             </div>
                                        </div>
                                   </div>
                                   <h1 class="mt-1 mb-3">{{$completedOrders->count()}}</h1>
                                   <div class="mb-0">
                                   </div>
                              </div>
                         </div>

                    </div>
                    <div class="col-sm-6">
                         <div class="card">
                              <div class="card-body">
                                   <div class="row">
                                        <div class="col mt-0">
                                             <h5 class="card-title text-danger">Pending Income</h5>
                                        </div>

                                        <div class="col-auto">
                                             <div class="stat text-primary">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck align-middle"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                             </div>
                                        </div>
                                   </div>
                                   <h1 class="mt-1 mb-3">Ksh {{ number_format($pendingIncome,2)}}</h1>
                                   <div class="mb-0">
                                   </div>
                              </div>
                         </div>
                         <div class="card">
                              <div class="card-body">
                                   <div class="row">
                                        <div class="col mt-0">
                                             <h5 class="card-title">Pending Orders</h5>
                                        </div>

                                        <div class="col-auto">
                                             <div class="stat text-primary">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart align-middle"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                             </div>
                                        </div>
                                   </div>
                                   <h1 class="mt-1 mb-3">{{$pendingOrders->count()}}</h1>
                                   <div class="mb-0">
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <div class="col-xl-6 col-xxl-5 d-flex">
          <div class="w-100">
               <div class="row">
                    <div class="col-sm-6">
                         <div class="card">
                              <div class="card-body">
                                   <div class="row">
                                        <div class="col mt-0">
                                             <h5 class="card-title text-success">Wallet Balance</h5>
                                        </div>

                                        <div class="col-auto">
                                             <div class="stat text-primary">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign align-middle"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                             </div>
                                        </div>
                                   </div>
                                        <h1 class="mt-1 mb-2">Ksh {{number_format($user->wallet,2)}}</h1>
                                   <div class="mb-0">
                                        <hr/>
                                        <a href="/transaction-history/{{$user->id}}/"><i class="bi bi-eye"></i>Transaction History</a>
                                        <hr/>

                                        @if($user->wallet > 10)
                                        <form method="POST" action="{{ route('withdraw-for-provider') }}" onSubmit="handleSumbmitForm()">
                                             @csrf
                                             <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                             <input type="hidden" name="provider_id" value="{{ $user->organization_id }}" />
                                             <div class="form-group">
                                                  <label>Send to Provider Mpesa</label><br/>
                                                  <b>({{ $user->phone }})</b>
                                                  <input type="number" class="form-control mt-2" placeholder="amount" name="amount" required="true"/>
                                                  @error('amount')
                                                       <span class="text-danger">{{$message}}</span><br/>
                                                  @enderror
                                                  <button class="btn btn-success mt-2 d-flex align-items-center" id="disable-button" type="submit">
                                                       <div class="spinner-grow d-none" id="withdraw-loading" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                       </div>
                                                  Withdraw
                                                  </button>
                                                  
                                             </div>
                                        </form>
                                        @endif
                                   </div>
                              </div>
                         </div>


                    </div>
                    <div class="col-sm-6">
                         <div class="card">
                              <div class="card-body">
                                   <div class="row">
                                        <div class="col mt-0">
                                             <h5 class="card-title">Withdrawn Amount</h5>
                                        </div>

                                        <div class="col-auto">
                                             <div class="stat text-primary">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck align-middle"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                             </div>
                                        </div>
                                   </div>
                                   <h1 class="mt-1 mb-3">Ksh {{ number_format($withdrawAmount,2)}}</h1>
                                   <div class="mb-0">
                                        <a href="/transaction-history/{{$user->id}}/"><i class="bi bi-eye"></i>Transaction History</a>
                                   </div>
                              </div>
                         </div>
                      
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="row">
     <div class="col-12 col-lg-6 col-xxl-6 d-flex">
          <div class="card flex-fill">
               <div class="card-header">
                    <h4 class="mb-0 text-success">Fullfilled Orders</h4>
               </div>
               <table class="table table-borderless my-0">
                    <thead>
                         <tr class="border">
                              <th>Customer</th>
                              <th class="d-none d-xxl-table-cell">Service/Product</th>
                              <th class="d-none d-xl-table-cell text-end">Amount</th>
                              <th class="d-none d-xl-table-cell text-end">% Commission</th>
                              <th class="d-none d-xl-table-cell text-end">Earnings</th>
                         </tr>
                    </thead>
                    <tbody>
                         @foreach($completedOrders as $order)
                              @foreach($order->items as $item)
                                   <tr>
                                        <td>
                                             @if($order->customer)
                                                  <strong>{{ $order->customer->name }}</strong>
                                             @endif

                                             @if($order->location)
                                                  <div class="text-muted">
                                                       {{ $order->location->name }}
                                                  </div>
                                             @endif
                                             <br/>
                                             <span class="badge bg-success">{{ $order->order_no}}</span>

                                        </td>
                                        <td>
                                             @if($item->product)
                                                  <b>{{$item->product->name}}</b><br/>
                                             @endif
                                             <small>{{$item->appointment_date }} @ {{ $item->appointment_time }}</small>
                                             <div class="text-muted">
                                                  Qty: {{ $item->quantity }} 
                                             </div>

                                        </td>
                                       
                                        <td>
                                             Ksh {{ $item->amount }}
                                        </td>
                                        <td>
                                             <span>{{ $item->percentage_commission }} %</span>
                                        </td>
                                        <td>
                                             <small>
                                              Ksh{{ number_format($item->provider_amount,2) }}
                                             </small> <br/>

                                             @if($item->provider_paid == 1)
                                                  <span class="badge bg-success">Paid</span>
                                             @else
                                                  <span class="badge bg-info">Pending</span>
                                             @endif
                                             
                                        </td>
                                   </tr>
                              @endforeach
                         @endforeach
                    </tbody>
               </table>
          </div>
     </div>

     <div class="col-12 col-lg-6 col-xxl-6 d-flex">
          <div class="card flex-fill">
               <div class="card-header">
                    <h4 class="mb-0 text-danger">Pending Orders</h4>
               </div>
               <table class="table table-borderless my-0">
                    <thead>
                         <tr class="border">
                              <th>Customer</th>
                              <th class="d-none d-xxl-table-cell">Service/Product</th>
                              <th class="d-none d-xl-table-cell text-end">Amount</th>
                              <th class="d-none d-xl-table-cell text-end">% Commission</th>
                              <th class="d-none d-xl-table-cell text-end">Earnings</th>
                         </tr>
                    </thead>
                    <tbody>
                         @foreach($pendingOrders as $order)
                              @foreach($order->items as $item)
                                   <tr>
                                        <td>
                                             @if($order->customer)
                                                  <strong>{{ $order->customer->name }}</strong>
                                             @endif

                                             @if($order->location)
                                                  <div class="text-muted">
                                                       {{ $order->location->name }}
                                                  </div>
                                             @endif
                                             <span class="badge bg-success">{{ $order->order_no}}</span>
                                        </td>
                                        <td>
                                             @if($item->product)
                                             <small>{{$item->product->name}}</small><br/>
                                             @endif
                                             <small>{{$item->appointment_date }} @ {{ $item->appointment_time }}</small>
                                             <div class="text-muted">
                                                  Qty: {{ $item->quantity }} 
                                             </div>

                                        </td>
                                       
                                        <td >
                                             Ksh {{ $item->amount }}
                                        </td>
                                        <td>
                                             <span>{{ $item->percentage_commission }} %</span>
                                        </td>
                                        <td>
                                             <small>
                                              Ksh{{ number_format($item->provider_amount ,2) }}
                                             </small> <br/>

                                             @if($item->provider_paid == 1)
                                                  <span class="badge bg-success">Paid</span>
                                             @else
                                                  <span class="badge bg-info">Pending</span>
                                             @endif
                                        </td>
                                   </tr>
                              @endforeach
                         @endforeach
                    </tbody>
               </table>
          </div>
     </div>
</div>
@endsection

@push('scripts')
<script>
    function handleSumbmitForm() {
          document.getElementById("disable-button").disabled = 'true';
          let element = document.getElementById("withdraw-loading");
          if(element){
               element.classList.remove("d-none");
          }
     }
</script>
@endpush
