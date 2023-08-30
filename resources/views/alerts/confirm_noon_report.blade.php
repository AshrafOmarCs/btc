
@extends('AdminLTE')
@section('content')
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
            <h3 class="panel-title">Noon report preview </h3>
            <table style="width: 100%;background-color: #ffd187;    border-radius: 11px;direction: rtl;
    margin-top: 15px;
}" id="summary">
                <tr style="background-color: #ebbd73;text-align: center;">
                    <th>تفاصيل مسار الملف </th>
                    <th>مجموع المبالغ</th>
                    <th>مجموع الديون</th>
                    <th>عدد المناديب</th>
                    <th>عدد المناديب الجدد</th>
                </tr>
                <tr style="text-align: center;">
                    <td>{{$extra['tem']->path}}</td>
                    <td>{{$extra['grandTotal']}}</td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                </tr>
                <tr>
                    <td colspan="5"><button class="btn btn-success"style="float:left;margin: 10px;" onclick="confirmInvoce()">تأكيد وتصدير الى Journal</button></td>
                </tr>
            </table>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                    <th>Hub Code</th>
                    
                    <th>Emp ID</th>
                    <th>Driver name</th>
                    
                    <th class="table-cell-package">No of Delivered</th>
                    <th class="table-cell-package">No of CIR</th>
                    <th class="table-cell-package">Total Delivery/Pickup</th>
                    <th class="table-cell-package">No of TouchPoint</th>
                    <th class="table-cell-package">Rate Card</th>
                    <th class="table-cell-package">amount</th>
                        <!-- <th class="table-cell-package">FullName</th>
                        <th class="table-cell-package">EMP ID</th>
                        <th class="table-cell-package">No_of_D</th>
                        <th class="table-cell-package">CIR</th>
                        <th class="table-cell-package">No_of_TP</th>
                        <th class="table-cell-package">Total_OFD</th>
                        <th class="table-cell-package">Status</th> -->
                    </tr>
                    <?php $i=0?>
                    @foreach($payload as $item)
                         
                        <tr>
                            <th>{{$item[0]}}</th>
                            
                            <th width="10%" style="text-align: center;">{{$item[2]}} 
                                
                            @if($item[14] == 'notRegistered')
                                <span class="btn" style="background-color:green;color:white;  border-radius: 50%;max-width: 47px;  font-size: 12px;">New </span>
                            @endif
                            </th>
                             <th>{{$item[3]}}</th>
                             <th>{{$item[6]}}</th>
                             <th>{{$item[7]}}</th>
                             <th>{{$item[8]}}</th>
                             <th>{{$item[9]}}</th>
                             <th>{{$item[11]}}</th>
                             <th>{{$item[13]}}</th>
                        </tr>
                    @endforeach
                    <tr style="background-color: #f29a0f;">
                            <th colspan="2"> Recoreds : {{$extra['qty']}} </th>
                            
                            <th></th>
                             <th></th>
                             <th></th>
                             <th></th>
                             <th></th>
                             <th></th>
                             <th></th>
                             
                             <th colspan="2" style="text-align: center;">{{$extra['grandTotal']}}</th>
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

function confirmInvoce(){
    
    let url = '{{url('import_excel/noon/confirm')}}';
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
                        // window.location.replace('/import_excel/noon');

                        // return redirect()->with('success','has done')
                    }
                },
                error: function (jqXHR, status, error) {
                   
                    alert(status + ": " + error);
                }
            });

    
   
    }
</script>
@endsection
