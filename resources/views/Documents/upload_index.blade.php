@extends('AdminLTE')
@section('title','Upload Documents')
@section('content') 
<style>
    .btn-info {
        background-color: #155261;
        border-color: #444;
    }
    .btn-info:hover {
        background-color: #1a6173;
        border-color: #444;
    }
</style>

<link rel="stylesheet" href="{{asset('dropAndDrag/style.css')}}">

        <div style="width: 88%; margin: 0 auto;">
            <h5 class="certrilize" style="margin-top: 14px; ">- Upload the Contract file(pdf, word)</h5>
            <p class="certrilize">  Drop file Bellow or click on the squire to choose file and continue </p>
            <form action="{{url('storeDocuments')}}" method="post"  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        Type: 
                        <select name="type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="contract">Document</option>
                            <option value="tutorial">Tutorial</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        Name: <input type="text" name="name" class="form-control" placeholder="Enter Nane" required><br>
                    </div>
                </div>
                <div class="drop-zone">
                    <span class="drop-zone__prompt">Drop file here or click to upload</span>
                    <input type="file" accept=".pdf,.DOCX" name="file" class="drop-zone__input" style="display:none" required>
                </div>  
                <!--<a href="{{url('Import_DA_Dailyload/step/Check-warehouse')}}">Next</a>-->
                <input type="submit" value="Confirm" class="btn btn-info" style="float: right; margin-top: 32px; margin-right: 53px;">
            </form>
        <hr style="margin-top: 85px;">
        </div>

    <!-- JS SCRIPTS ON CODITIONS -->
    <script src="{{asset('dropAndDrag/script.js')}}"></script> 
    <!-- partial -->
    <!--<script  src="{{asset('dropAndDrag/script.js')}}"></script>-->
@endsection