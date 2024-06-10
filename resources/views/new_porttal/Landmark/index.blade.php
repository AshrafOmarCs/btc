@extends('layout2')
@section('content')
@section('title', 'Landmark')

<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Upload the dailyload Excel sheet</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">Drop file Bellow or click on the squire to choose file and continue</div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{url('Import_DA_Dailyload/validate')}}" method="post"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                PD Amount Per Day:
                                <input type="number" name="pd" class="form-control" required min="0"  step="0.01" id="PDInput" placeholder="PD Price per day ">
                            </div>
                            <div class="col-md-3">
                                Permanent: <input type="number" name="permanent" class="form-control" required min="0" step="0.01"  id="permanentInput" placeholder="Permanent Price per day"><br>
                            </div>
                        </div>
                        <div class="drop-zone">
                            <span class="drop-zone__prompt">{{__('documents.drop_file')}}</span>
                            <input type="file" name="myFile" class="dropify" required>
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

