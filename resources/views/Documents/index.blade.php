@extends('AdminLTE')
@section('content')
<style>
    th, td{
        text-align: center;
        width: 33%;
    }
</style>
<div class="card" >
   
  <div class="card-body">
    <h5 class="card-title">Documents</h5>
    <p class="card-text">By using this module, you can download documents/tutorials.</p> 
  </div>
</div>

<hr>
<div class="table-responsive" style="width: 100%;">
    <h6>Documents</h6>
    <table id="customer_data" class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>  
                <th>Sr. No.</th>
                <th>Name</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody id="tbl_body">
            @php $count = 0; @endphp
            @foreach($contracts as $contract)
                <tr>
                    <td>{{ ++$count }}</td>
                    <td>{{ $contract->name }}</td>
                    <td><a target="_blank" title="Download" href="/storage/images/{{ $contract->file_name }}"><i class="fa fa-download fa-lg"></i></a></td>
                </tr>
            @endforeach
    
        </tbody>
    </table> 
</div>
<hr>
<div class="table-responsive" style="width: 100%;">
    <h6>Tutorials</h6>
    <table id="customer_data" class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>  
                <th>Sr. No.</th>
                <th>Name</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody id="tbl_body">
            @php $count = 0; @endphp
            @foreach($tutorials as $tutorial)
                <tr>
                    <td>{{ ++$count }}</td>
                    <td>{{ $tutorial->name }}</td>
                    <td><a target="_blank" title="Download" href="/storage/images/{{$tutorial->file_name}}"><i class="fa fa-download fa-lg"></i></a></td>
                </tr>
            @endforeach
    
        </tbody>
    </table> 
</div>



@endsection