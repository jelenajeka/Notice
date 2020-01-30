@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                         <div class="form-inline">
                            <i class="fas fa-search icon-search" aria-hidden="true"></i>
                            <input id="search_notice" class="form-control search-input" type="text" placeholder="Search" aria-label="Search" onkeyup="searchNotice()">
                        </div>
                    </div>
                </div>
            </div>
            <div class="type-section">
                <div class="row">
                    <div class="col-md-2">
                        <a class="btn-action align-self-center buttonlink addtype" onclick="viewNotices()">
                            <div class="info text-center icon-type buttonlink">
                                <i class="fas fa-book fa-2x"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-8">
                        <ul class="list-inline typelist">
                            @foreach($types as $t)
                               <li class="list-inline-item" value="{{$t->id}}">
                                <h6><a id="" onclick="noticesGroup('{{$t->id}}','{{ $t->type_name }}')"> {{ $t['type_name'] }} </a></h6>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <a class="btn-action align-self-center buttonlink addtype" href="/types">
                            <div class="info text-center icon-type">
                                <i class="fas fa-cog fa-2x"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- notices -->
            <div class="notices-section">
                <div class="row">
                    <div class="col-md-12">
                        @include('table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/home.js"></script>
@endsection
