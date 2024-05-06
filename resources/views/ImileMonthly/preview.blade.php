
@extends('AdminLTE')
@section('content')

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adding New driver</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{url('storeImileDriver')}}" method="post">
            @csrf
        <div class="form-group">
                <label for="ampID">AMP ID <span style='color:red'> * </span> : </label>
                <input type="text" id="APMID" class="form-control" required aria-describedby="emailHelp" name="AMP" placeholder="Enter AMP ID">
            </div>

            <div class="form-group">
                <label for="warehousename">Warehouse Name <span style='color:red'> * </span> : </label>
                <input type="text" id="warehouse" class="form-control" id="warehousename" name="warehousename" aria-describedby="warehousenameHelp">

            </div>

            <div class="form-group">
                <label for="driver">Driver Name<span style='color:red'> * </span> : </label>
                <input type="text" class="form-control" id="drivername" aria-describedby="driverHelp" name="driverName">
                <input type="hidden" name="file_id" value="{{$extra['file_id']}}">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<style>
    .panel-heading{
        padding: 25px 15px;
    }
    .summary {
        text-align: center;
        background-color: #ffc261;
    }
    .w3-table-all td, th {
        text-align: center;
    }
</style>
<div class="container" style="width:95%">


    @if(count($errors) > 0)
        <div class="alert alert-danger">
            Upload Validation Error<br><br>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Report preview </h3>
            <table style="width: 100%;background-color: #ffd187;    border-radius: 11px;direction: rtl;
    margin-top: 15px;
}" id="summary">
                <tr style="background-color: #ebbd73;text-align: center;">
                    <th>تفاصيل مسار الملف </th>
                    <th>مجموع الشحنات</th> 
                    <th></th>
                    <th>عدد المناديب في الفاتورة </th>
                </tr>
                <tr style="text-align: center;">
                    <td>{{$extra['tem']->path}}</td>
                    <td>{{$extra['grandTotal']}}</td>
                    <td>{{$extra['qty']}}</td> 
                </tr>
                <tr>
                    <td colspan="5"><button class="btn btn-success"style="float:left;margin: 10px;" id="confirmBtn" onclick="confirmInvoce()">تأكيد وتصدير الى Journal</button></td>
                </tr>
            </table>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                    <th>#</th>
                    <th>Hub Code</th>
                    <th>Emp ID</th> 
                    <th>Driver name</th> 
                    <th>Contract type</th>
                    <th>NO of Days</th>
                    <th class="table-cell-package">Total OF TP</th>
                    <th>Registration status</th>
                    <th>Net Salary</th>
                    </tr>
                    <?php $i=0?>
                    @foreach($payload as $k=>$item)
                        <tr>
                            <th>{{++$k}}</th>
                            <th>{{$item[0]}}</th>
                            <th>{{$item[1]}}</th>
                            <th width="10%" style="text-align: center;">{{$item[2]}} 
                            </th>
                            <th> {{$item[5]}}</th>
                            <th>{{$item[4]}}</th>
                            <th>{{$item[3]}}</th>
                                <th>
                                @if($item[8] == 'New DA')
                                <!-- Button trigger modal -->
                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal"  onclick="Add('{{$item[0]}}','{{$item[2]}}','{{$item[1]}}')" data-target="#exampleModal">
                                    Add
                                </button> -->
                                <span class="btn" style="background-color:#dd4b39;color:white;  border-radius: 50%;max-width: 138px;  font-size: 12px;">New DA | Auto add </span>
                                @else
                                <span class="btn" style="background-color:green;color:white;  border-radius: 50%;max-width: 116px;  font-size: 12px;">Registered </span>
                                @endif
                                </th> 
                                <th>{{$item[7]}}</th>
                        </tr>
                    @endforeach
                        <tr style="background-color: #f29a0f;">
                            <th colspan="4"> Recoreds : {{$extra['qty']}} </th> 
                            <th></th>
                            <th></th>
                            <th colspan="3" style="text-align: center;">{{$extra['grandTotal']}}</th>
                        </tr>
                </table>
            </div>
        </div>
    </div>




<!-- extra -->













    </div>
</body>
</html>
<script>
    $(function () {
        $('#pakage_date').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            autoHide: true,
            zIndex: 9999,
        });
    });
    function Add(warehousename,drivername,ampid){
        //confirmBtn
        $('#drivername').val(drivername)
        $('#warehouse').val(warehousename)
        $('#APMID').val(ampid)

        // const button = document.getElementById('confirmBtn');
        // button.disabled = true;
    }
function confirmInvoce(){
    //confirmBtn
    $('#confirmBtn').prop('disabled', true)
    // const button = document.getElementById('confirmBtn');
    // button.disabled = true;
    let url = '{{url('I-mile/Confirm-invoice')}}';
    var postData = {
        file_id:"{{$extra['file_id']}}",
        journal_date:"{{$extra['tem']->journal_date}}",
        journal_period:"{{$extra['tem']->journal_period}}",
        _token: "{{ csrf_token() }}",
    };
    
    $.ajax({
                url: url,
                type: "POST",
                cache: false,
                data: postData,
                success: function (data) {
                    // console.log(data);
                    if(data.status == true){
                        alert('Exporting to journal succeed');
                        window.location.href = "{{url('Salary')}}";
                        // window.location.replace('/import_excel/General-invoices');
                        // return redirect()->with('success','has done')
                    }else{
                        alert(data.error);
                        // window.location.replace('/import_excel/General-invoices');
                    }
                },
                error: function (jqXHR, status, error) {
                   
                    alert(status + ": " + error);
                }
            });
    }
</script>
@endsection
