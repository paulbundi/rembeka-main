@extends('layouts.dashboard')
@section('content')
<div class="col-12 card mt-2">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table m-b-0">
            <thead>
              <tr>
                <th>Account</th>
                <th>Description</th>
                <th>Transaction Type</th>
                <th>Amount</th>
                <th>Running Balance</th>
                <th>User(Actioning)</th>
                <th>Created At</th>
              </tr>
              </thead>
                  <tbody>
                  @foreach($audits as $audit)
                    <tr>
                        <td>{{$audit->auditable->name}} </td>
                        <td>{{ $audit->description }}</td>
                        <td>
                            @if($audit->effect_type == 2)
                                <span class="badge bg-info">Credit</span>
                            @else
                                <span class="badge bg-success">Debit</span>
                            @endif
                        </td>
                        <td>{{ $audit->amount }}</td>
                        <td>{{ $audit->previous_balance }}</td>
                        <td>
                            @if($audit->user)
                                <span class="badge bg-success">{{ $audit->user->name }}</span>
                            @endif
                        </td>
                        <td>{{ $audit->created_at }}</td>
                    </tr>
                  @endforeach
                  </tbody>
          </table>
          <div class="mt-2">
            {{ $audits->links() }}
          </div>
        </div>
      </div>
    </div>
@endsection

