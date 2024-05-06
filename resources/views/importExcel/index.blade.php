@extends('AdminLTE')
@section('content')


<div class="container" style="width:90%">
    <h1>Import Excel file to journal </h1>
    <form action="{{url('import-excel/store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input class="btn btn-success" style="width: 80%; margin: 0 auto; margin-bottom: 24px; margin-top: 24px;" type="file" name="csv" id="" accept=".csv ">
        <small style="font-size: 14px; color: #ff000087;"> * Allowded Extensions is : CSV </small>
        <input class="btn btn-primary" style="    float: right;" type="submit" value="Import">
    </form>

</div>

 

@endsection