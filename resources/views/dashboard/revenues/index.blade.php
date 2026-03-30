@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-inline" method="post" action="{{ route('revenues.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-3">
                                <label for="start">Start Date</label>
                                <input type="date" class="form-control" name="start_at" value="{{$start_at??''}}"  required>
                            </div>
                                <div class="col-3"><label for="end">End Date</label>
                                <input type="date" class="form-control" name="end_at" value="{{$end_at??''}}" required>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-sm btn-primary mt-4" type="submit">Apply Filter</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="card shadow-lg h-100">
                <div class="card-body">
                       <h4 class="text-center text-primay font-weight-bolder">Net Revenue</h4>
                    @php
                        $home = $homeCallRevenue[0]->amount - $homeCallRevenue[0]->provider_amount;
                        $franchise = $franchiseRevenue[0]->amount - $franchiseRevenue[0]->provider_amount;
                    @endphp
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-bank fs-1 me-2"></i>
                        <b class="fs-1">
                            {{ number_format($home + $franchise) }} /=
                        </b>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card shadow-lg h-100">
                <div class="card-body ">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Service Market Place</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="bi bi-people fs-3"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{number_format($serviceRevenue[0]->amount - $serviceRevenue[0]->provider_amount)}}</h1>
                     <b>Total paid: {{ number_format($serviceRevenue[0]->amount,2) }}</b> <br/>
                     <b>Provider Earning: {{ number_format($serviceRevenue[0]->provider_amount,2)}}</b><br/>
                     <b>Discount Given: {{ number_format($serviceRevenue[0]->discount,2)}}</b>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card shadow-lg h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Product Market Place</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="bi bi-basket2 fs-3"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{number_format($productRevenue[0]->amount - $productRevenue[0]->provider_amount)}}</h1>
                     <b>Total paid: {{ number_format($productRevenue[0]->amount,2) }}</b> <br/>
                     <b>Provider Earning: {{ number_format($productRevenue[0]->provider_amount,2)}}</b><br/>
                </div>
            </div>
        </div>
    </div>

    <hr/>
    <h6>Details</h6>
    <hr/>

    <div class="row">
        <div class="col-3">
            <div class="card shadow-lg h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Homecall Revenues</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="bi bi-house fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{number_format($homeCallRevenue[0]->amount - $homeCallRevenue[0]->provider_amount)}}</h1>
                     <b>Total paid: {{ number_format($homeCallRevenue[0]->amount,2) }}</b> <br/>
                     <b>Provider Earning: {{ number_format($homeCallRevenue[0]->provider_amount,2)}}</b><br/>
                     <b>Discount Given: {{ number_format($homeCallRevenue[0]->discount,2)}}</b>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card shadow-lg h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Franchise Revenue</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="bi bi-buildings fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{number_format($franchiseRevenue[0]->amount - $franchiseRevenue[0]->provider_amount)}}</h1>
                     <b>Total paid: {{ number_format($franchiseRevenue[0]->amount,2) }}</b> <br/>
                     <b>Provider Earning: {{ number_format($franchiseRevenue[0]->provider_amount,2)}}</b><br/>
                     <b>Discount Given: {{ number_format($franchiseRevenue[0]->discount,2)}}</b>
                </div>
            </div>
        </div>
    </div>
@endsection