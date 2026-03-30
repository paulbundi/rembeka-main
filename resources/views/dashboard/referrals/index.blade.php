@extends('layouts.dashboard')
@section('content')
<div class="col-12 card">
    @if(canAccess('referrals.create'))
    <div class="col-12">
        <a href="{{ route('referrals.create') }}" class="btn btn-sm btn-success float-end text-white me-1 mt-2">
            <i class="fa fa-plus-circle"></i> 
            create
        </a>
    </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table class="table m-b-0">
                <thead>
                    <tr>
                        <th>{{ __('referrals.referrar')}}</th>
                        <th>{{ __('commons.description')}}</th>
                        <th>{{ __('commons.url')}}</th>
                        <th>{{ __('referrals.acquisition_cost')}}</th>
                        <th>{{ __('commons.status')}}</th>
                        <th>{{ __('commons.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($referralcodes as  $code)
                    <tr>
                        <td>
                            <div>
                                @if($code->user)
                                    {{ $code->user->name }}
                                @else
                                    {{ $code->referrer }}
                                @endif
                                <span class="badge bg-success"> {{ $code->users_count }} </span>
                            </div>
                            <small>{{ $code->code }}</small>
                        </td>
                        <td>{{ $code->description }}</td>
                        <td>
                            <span>{{route('register').'?code='.$code->code}}</span><br/>
                            <span>https://wa.me/{{config('services.whatsapp.rembeka_whatsapp_no')}}?text=Referred%20by%20{{ urlencode($code->code) }}</span>
                        </td>
                        <td>
                            {{ $code->acquisition_cost }}
                        </td>
                        <td>
                            @if($code->status == 1)
                                <span class="badge bg-success text-whilte">Active</span>
                            @else
                                <span class="badge bg-danger text-whilte">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                @if(canAccess('referrals.view'))
                                <a href="{{ route('referrals.show', $code->id) }}" class="btn btn-sm btn-outline-primary me-1" title="view"><i class="bi bi-eye-fill"></i></a>
                                @endif
                                @if(canAccess('referrals.update'))
                                    <a href="{{ route('referrals.edit', $code->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                @endif
                                @if(canAccess('referrals.delete'))
                                <form method="POST" action="{{ route('referrals.destroy', $code->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash-fill"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $referralcodes->links()}}
        </div>
</div>
@endsection