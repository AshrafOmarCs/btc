@extends('layout2')
@section('content')
@section('title', __('documents.upload_documents'))

<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('documents.allowed_files')}}</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">{{__('documents.drop_file_description')}}</div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                {{-- <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                <button type="button" class="btn btn-success" class="btn btn-info" type="button" onclick="export_excel()"></i>{{__('drivers.ExportExcel')}}</button> --}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{url('storeDocuments')}}" method="post"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                Type:
                                <select name="type" class="form-control" required>
                                    <option value="">{{__('documents.drop_file')}}</option>
                                    <option value="contract">{{__('documents.document')}}</option>
                                    <option value="tutorial">{{__('documents.tutorial')}}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                {{__('documents.name')}}: <input type="text" name="name" class="form-control" placeholder="{{__('documents.enter_name')}}" required><br>
                            </div>
                        </div>
                        <div class="drop-zone">
                            <span class="drop-zone__prompt">{{__('documents.drop_file')}}</span>
                            <input type="file" accept=".pdf,.DOCX" name="file" class="dropify" required>
                        </div>
                        <input type="submit" value="{{__('documents.confirm')}}" class="btn btn-info" style="float: right; margin-top: 32px; margin-right: 53px;">
                    </form>
                <hr style="margin-top: 85px;">
                </div>
            </div>
            <!-- Card end -->
        </div>
        <!-- Card end -->

    </div>
</div>

@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    <script></script>
@stop
@endsection

