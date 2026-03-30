@extends('layouts.dashboard')
@section('content')
<div class="row">
    <div class="card col-6">
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
            <div class="col-6">
                <h4>Import Products/ Services</h4>
                <form method="POST" action="{{ route('products.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Select Default Provider</label>
                        <remote-selector module="Providers" :multiple="false"/>
                    </div>

                    <div class="form-group">
                        <label>Import File</label>
                        <input type="file" class="form-control" name="file" accept=".xls,.xlsx">
                    </div>
                    @error('file')
                        <div class="alert alert-danger">
                        {{$message}}
                        </div>
                    @endError
                    <div class="form-group">
                        <button class="btn btn-primary float-end">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-6 card">
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
            <div class="col-12">
                <h4 class="text-primary">Update Catalogue</h4>
                <form method="POST" action="{{ route('products.import-update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Import File</label>
                        <input type="file" class="form-control" name="file" accept=".xls,.xlsx">
                    </div>
                    @error('file')
                        <div class="alert alert-danger">
                        {{$message}}
                        </div>
                    @endError
                    <div class="form-group">
                        <button class="btn btn-success float-end">Update Product Catalogue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

