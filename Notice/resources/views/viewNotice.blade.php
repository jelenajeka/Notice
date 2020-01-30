@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-11">
                        <h4 class="align-self-center">Notice </h4>
                        <h4 class="align-self-center">
                            {{$notice['noticetype']->type_name}} - {{$notice->title}}
                        </h4>
                    </div>
                    <div class="col-md-1">
                        <a class="btn-action align-self-center buttonlink" href="/notices/{{$notice['id']}}/edit" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fas fa-edit fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div id="text_for_transform" class="px-4">{!! $notice_formatted !!}</span></div>
                </div>
            </div>
            <div class="card-footer">
                <ul class="list-unstyled">
                    <label class="form-group">Edited by: </label>
                    @foreach($editer as $e)
                    <li class="badge small editedlist">
                        {{$e['editedby']->name}}
                    </li>
                    @endforeach
                </ul>
                <label class="form-group">Created by: </label>
                <p class="badge small editedlist"> {{ $notice['noticeby']->name }} </p>
            </div>
        </div>
    </div>
</div>
@endsection
