@extends('layouts.dashboard')
@section('content')
<div class="col-12 row">
    <div class="col-12 col-sm-6 card">
        <div class="card-body">
            <div class="card-heading m-0 p-0">
                <b>{{ $referralcode->user->name}}</b>
            </div>
            <div class="body text-left">
                <div class="mb-3 mt-3 team-language">
                    <p> Description: {{ $referralcode->description }}</p>
                    <p> Code: {{ $referralcode->code }}</p>
                    <span>Link: {{route('register').'?code='.$referralcode->code}}</span>
                </div>
                <div class="align-items-center">
                    <h6 class="mb-0  me-2">members</h6>
                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Names</th>
                                <th>Phone</th>
                                <th>Orders Placed</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php($count = 1)
                        
                        @foreach($referralcode->users as $member)
                            <tr>
                                <td scope="row">{{$count ++}}</td>
                                <td>
                                    <div class="media-object">
                                        {{ $member->name }}
                                    </div>
                                </td>
                                <td>
                                    {{ $member->phone }}
                                </td>
                                <td>
                                    {{ $member->orders_count}}
                                </td>
                                <td>
                                    {{ $member->created_at }}
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
</div>
@endsection