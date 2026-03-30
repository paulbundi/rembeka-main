@extends('layouts.dashboard')
@section('content')
<div class="col-12">
    <h4>Edit Code</h4>
    <div class="col-10 card">
        <div class="card-body">
            <form method="post" action="{{ route('referrals.update', $code->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{$code->id}}" name="id" />

                <div class="form-group">
                    <label>{{ __('Type') }}</label>
                    <select class="form-control" name="is_ambassador">
                        <option value=""></option>
                        <option value="1" @if($code->is_ambassador) selected @endif>Brand Ambassador</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('referrals.code') }}</label>
                    <input type="text" name="code" class="form-control" value="{{ $code->code }}" required="true">
                    @error('code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>User</label>
                    <remote-selector module="Users" :multiple="false" :value="{{ $code->user?? 'null' }}"/>
                    <select-users :multiple='false' label="{{ __('referrals.referrar') }}" :user="{{$code->user ?? 'null'}}"/>
                    @error('selected')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ __('commons.description') }}</label>
                    <textarea name="description" class="form-control" required="true">{{ $code->description }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ __('referrals.acquisition_cost') }}</label>
                    <input type="number" step="any"  name="acquisition_cost" class="form-control" required="true"  value="{{ $code->acquisition_cost }}">
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label>{{ __('Ambassador`s Discount') }}</label>
                    <input type="number" step="any" min="0" max="20" name="ambassador_discount" class="form-control" required="true"  value="{{$code->ambassador_discount}}">
                    @error('ambassador_discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ __('Referred Discount First Service') }}</label>
                    <input type="number" step="any" min="0" max="20" name="referred_first_visit_discount" class="form-control" required="true"  value="{{$code->referred_first_visit_discount}}">
                    @error('referred_first_visit_discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>{{ __('Referred Discount Second Service') }}</label>
                    <input type="number" step="any" min="0" max="20" name="referred_second_visit_discount" class="form-control" required="true"  value="{{$code->referred_second_visit_discount}}">
                    @error('referred_second_visit_discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ __('Max Users') }}</label>
                    <input type="number" step="1" min="0" name="max_users" class="form-control" value="{{$code->max_users}}">
                    @error('max_users')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="checkbox" name="status" @if($code->status == 1) checked @endif/><span class="ms-2">Is Active</span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary float-end text-white">
                        Update Code
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection