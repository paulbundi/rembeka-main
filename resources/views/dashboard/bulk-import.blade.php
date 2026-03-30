@extends('layouts.dashboard')
@section('content')
<div class="row">
    <div class="col-12 col-sm-6 offset-sm-3 card">
        <div class="card-header">
            <div class="card-title">
                @error('errors')
                    <div class="alert alert-danger">
                    {{$errors}}
                    </div>
                @endError
            </div>
        </div>

        <div class="card-body">
            <div class="card-title mb-4">
                <h4 class="text-dark">Update Product And Services.</h4>
            </div>
            <div class="col-12">
                <form method="POST" action="{{ route('merchandise.bulk-update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Select Excel File</label>
                        <input type="file" class="form-control" name="file" accept=".xls,.xlsx" required="true">
                    </div>
                    @error('file')
                        <div class="alert alert-danger">
                        {{$message}}
                        </div>
                    @endError
                    <div class="form-group">
                        <button class="btn btn-primary float-end" type="submit">Import Updates</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

