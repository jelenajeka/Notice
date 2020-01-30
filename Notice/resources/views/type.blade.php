@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Type</h1>
            </div>
            <form action={{ $action_url }} method={{ $method }} enctype="multipart/form-data">
                @if($action=="put")
                  <input type="hidden" name="_method" value="PUT">
                @endif
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-group">Type name:</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control @error('type_name') is-invalid @enderror" name="type_name" value="{{ $type->type_name }}"/>
                            @error('type_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-large btn-block btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
