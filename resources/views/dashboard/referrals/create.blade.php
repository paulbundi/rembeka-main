@extends('layouts.dashboard')
@section('content')
<div class="col-12">
    <h4>Generate a referral code</h4>
    <div class="col-10 card">
        <div class="card-body">
            <form method="post" action="{{ route('referrals.store') }}">
                @csrf
                <div class="form-group">
                    <label>{{ __('Type') }}</label>
                    <select class="form-control" name="is_ambassador">
                        <option value=""></option>
                        <option value="1">Brand Ambassador</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('referrals.code') }}</label>
                    <input type="text" name="code" class="form-control" value="{{ $code }}" required="true">
                    @error('code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Customer Account</label>
                    <remote-selector module="Users" :multiple="false"/>
                    @error('selected')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ __('commons.description') }}</label>
                    <textarea name="description" class="form-control" required="true">{{old('description')}}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ __('referrals.acquisition_cost') }}</label>
                    <input type="number" step="any" min="0" name="acquisition_cost" class="form-control"  value="{{old('acquisition_cost')}}">
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('Ambassador`s Discount') }}</label>
                    <input type="number" step="any" min="0" max="20" name="ambassador_discount" class="form-control" required="true"  value="{{old('ambassador_discount')}}">
                    @error('ambassador_discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ __('Referred Discount First Service') }}</label>
                    <input type="number" step="any" min="0" max="20" name="referred_first_visit_discount" class="form-control" required="true"  value="{{old('referred_first_visit_discount')}}">
                    @error('referred_first_visit_discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>{{ __('Referred Discount Second Service') }}</label>
                    <input type="number" step="any" min="0" max="20" name="referred_second_visit_discount" class="form-control" required="true"  value="{{old('referred_second_visit_discount')}}">
                    @error('referred_second_visit_discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ __('Max Users') }}</label>
                    <input type="number" step="1" min="0" name="max_users" class="form-control"  value="{{old('max_users')}}">
                    @error('max_users')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <input type="checkbox" name="status" value="1"><span class="ms-2">Is Active</span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary float-end text-white">Generate Code</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection