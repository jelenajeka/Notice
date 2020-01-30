@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="h1">Notice</h1>
            </div>
            <div class="card-body">
                <form id="add_form" action={{ $action_url }} method={{ $method }} enctype="multipart/form-data">
                    @csrf
                    @if($action=="put")
                      <input type="hidden" name="_method" value="PUT">
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-group">Type:</label>
                                <select class="form-control @error('type') is-invalid @enderror" name="type" data-live-search="true"> <option value="" selected disabled>Types</option>
                                @foreach($types as $t)
                                  @php
                                  $type_selected = '';
                                  if($notice->type == $t->id)
                                  {
                                    $type_selected = 'selected';
                                  }
                                  @endphp
                                <option value="{{$t->id}}" {{$type_selected}}> {{$t->type_name}} </option>
                                @endforeach
                                </select>
                                @error('type')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-group">Title:</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Title" name="title" value="{{$notice->title}}">
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="nav nav-pills nav-justified btntools">
                                        <button id="bold" onclick="event.preventDefault(); clickElement('bold')" class="btn"><i class="fas fa-bold"></i></button>
                                        <button id="italic" onclick="event.preventDefault(); clickElement('italic')" class="btn"><i class="fas fa-italic"></i></button>
                                        <button id="link" onclick="event.preventDefault(); clickElement('link')" class="btn"><i class="fas fa-link"></i></button>
                                        <button id="code" onclick="event.preventDefault(); clickElement('code')" class="btn"><i class="fas fa-code"></i></button>
                                        <button id="list" onclick="event.preventDefault(); clickElement('list')" class="btn"><i class="fas fa-list"></i></button>
                                        <button id="image" class="btn btn-secondary"><i class="fas fa-image"></i></button>
                                        <button id="attachment" class="btn btn-secondary"><i class="fas fa-paperclip"></i></button>
                                        <select id="heading" class="btn btn-secondary">
                                            <option value="" disabled selected><i class="fas fa-heading"><b>H</b></i></option>
                                            <option value="1">h1</option>
                                            <option value="2">h2</option>
                                            <option value="3">h3</option>
                                            <option value="4">h4</option>
                                            <option value="5">h5</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- save and not save image -->
                                <div id="saveandnotsave" class="container">
                                    <div class="saveandnot">
                                        <input id="upload_local" class="form-control" style="background:transparent" />
                                        <button id="image_save" class="btn">Save</button>
                                        <button id="not_save" class="btn">Cancel</button>
                                    </div>
                                </div>
                                <input id="img" value="{{$img}}" name="img" hidden />
                                <!-- save and not save file -->
                                <div id="saveandnotsavefile" class="container">
                                    <div class="saveandnot">
                                        <input id="upload_local_file" class="form-control" />
                                        <button id="file_save" class="btn">Save</button>
                                        <button id="file_not_save" class="btn">Cancel</button>
                                    </div>
                                </div>
                                <input id="attach" value="{{$attach}}" name="attach" hidden />
                                <div class="card-body">
                                    <textarea id="text" class="form-control border border-dark rounded-bottom shadow-sm pt-4 texteditor" name="text" rows="5">{{$notice->text}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5> Preview:</h5>
                                </div>
                                <div class="card-body">
                                    <div id="text_formated" class="p-3 pt-4 rounded-bottom border shadow-sm texteditor"> {!! $notice_formatted !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($editer)
                        <ul class="list-unstyled">
                            <label class="form-group">Edited by:</label>
                            @foreach($editer as $e)
                            <li class="badge small editedlist">
                                {{$e['editedby']->name}}
                            </li>
                            @endforeach
                        </ul>
                        <label class="form-group">Created by: </label> <p class="badge small editedlist"> {{ $notice['noticeby']->name }} </p>
                        @endif

                    </div>
                    <div class="card-footer">
                        <button id="btn_new_notice" type="submit" class="btn btn-large btn-block btn-primary"> Save </button>
                    </div>
                </form>

                 <!-- modal - upload image  -->
                <div class="modal" id="add_image" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Upload image</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="add_image_form" name="upload" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group d-flex justify-content-center">
                                        <input type="file" class="form-control" name="img_input" id="img_input" />
                                        <br>
                                        <br>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" id="uploadFormImg" class="btn btn-primary" disabled>upload</buton>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal - upload file -->
                <div class="modal" id="add_file" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Upload</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="add_file_form" name="upload" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group d-flex justify-content-center">
                                        <input type="file" class="form-control" name="file" id="file" />
                                        <br>
                                        <br>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" id="uploadFormFile" class="btn btn-primary" disabled>upload</buton>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/notices.js"></script>
@endsection
