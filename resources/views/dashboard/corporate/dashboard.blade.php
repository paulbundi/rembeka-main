@extends('layouts.dashboard')
@section('content')
<div class="row">
    <div class="col-8">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title text-success">Orders</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign align-middle"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $orders }}</h1>
                    </div>
                </div>
            </div>

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
                        <h1 class="mt-1 mb-3">Ksh {{number_format(auth()->user()->wallet,2)}}</h1>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <wallet-audit-index :id="{{ auth()->id() }}" corporate-view/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="text-primary fw-bolder">Mpesa To Up</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign align-middle"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        </div>
                    </div>
                </div>
                <ul>
                    <li>Using your MPesa-enabled phone, select <b>"Pay Bill"</b> from the M-Pesa menu</li>
                    <li>Enter Rembeka online Business Number <b>4087941</b></li>
                    <li>Enter your <b>Rembeka online Account Number.</b> Your account number is <b>{{auth()->user()->account_no}}</b></li>
                    <li>Enter the Amount you want to load</li>
                    <li>Confirm that all the details are correct and press Ok</li>
                    <li>Refresh page and see payment reflect.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

