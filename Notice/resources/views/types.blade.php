@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Types</h1>
            </div>
        </div>
        <div class="card-body">
            <table id="table_types" class="table table-hover tablenotices">
                <thead class="thead-white">
                    <tr>
                        <th scope="col">
                            <h3 class="title-not">Types:</h3>
                        </th>
                        <th colspan="2">
                            <a class="btn-action align-self-center buttonlink addtype" href="/types/view/create" data-toggle="tooltip" data-placement="top" title="New type">
                                <div class="info text-center icon-type">
                                    <i class="fas fa-plus fa-2x"></i>
                                </div>
                            </a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($types as $t)
                     <tr scope="row">
                        <td>
                            <a class="btn-action align-self-center" href="/types/{{$t['id']}}">
                                <h6 class="text-muted">{{$t['type_name']}}</h6>
                            </a>
                        </td>
                        <td width="30">
                            <div class="d-flex justify-content-around">
                                <a class="btn-action align-self-center buttonlink" href="/types/{{$t['id']}}" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit fa-lg"></i>
                                </a>
                            </div>
                        </td>
                        <td width="30">
                            <div class="d-flex justify-content-around">
                                <a class="btn-action align-self-center buttonlink del" onclick="deleteType('{{$t['id']}}')" href="#" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fas fa-trash fa-lg"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="/js/home.js"></script>
@endsection
