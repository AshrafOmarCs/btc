@extends('AdminLTE')
@section('content')
<style>
    th, td{
        text-align: left;
    }
</style>
<div class="card" >
   
  <div class="card-body">
    <h5 class="card-title">Vehicles/Drivers Attendance</h5>
    <p class="card-text">By this module you can Add/Update attendance of vehicles. Also you can see the attendance status of vehicles for past days. </p> 
  </div>
</div>
<form action="{{url('DriversAttendance/update')}}" method="post">
    @csrf
    
   <div class="card card-default" style="width:100%;clear:both;"></div>

        <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->
    <!-- SELECT2 EXAMPLE -->
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary collapsed-box">
            <div class="box-header with-border">
                

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box" class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header --> 
<div id="box-body" class="box-body table-responsive">
    
    <table style="width: 60%;">
        <tr> 
            <th>CompanyName</th>
            <th>WarehouseName</th>
            <th>Date</th>
        </tr>
        <tr> 
            <td>
                <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                    class="form-control" style="width:200px;">
                    <option value=""></option>
                    @foreach($lkp_company as $lkpcompany)
                        <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                        style="width:180px;">
    
                    <option value=""></option>
    
                </select>
            </td>
            <td>
                <input type="date" value="{{ date("Y-m-d") }}" id="filter_date" name="filter_date" class="form-control" style="width:180px;">
            </td>
        </tr>
    </table>
    
    <div class="card-footer" style="margin-top: 10px" align="center">
        <button type="button" name="filter" id="filter" class="btn btn-sm btn-info" onclick="confirmSearch()">Filter</button>
    </div>
</div>
</div>
</div>

<hr>
    <div class="table-responsive" style="width: 100%;">
    <div style="width:100%;clear:both;" id="response">

    </div>
        
    <table id="customer_data" class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>  
                <th>Company</th>
                <th>Warehouse</th>
                <th>Job Id</th>
                <th>Vehicle</th>
                <th>Driver Name </th>
                <th>City</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody id="tbl_body">
            
        </tbody>
    </table> 
    <span id="btn" style="display: none;"><input type="submit" class="btn btn-primary" value="Submit" style="float: right;" /></span>
</form>
</div>
<hr>
<script>
    function set_date(date) {
        $("#date").val(date);
    }
    function confirmSearch(check = ''){ 
        if ($('#filter_date').val() == ''){ 
            alert('Date Can not Be Empty');
        } else{
            let user = {{Auth::user()->user_type_id}};
            let currentDate = new Date().toJSON().slice(0, 10);
            var filter_companyId = filter_warehouseId = filter_date = '';
            // if(check == '') {
                filter_companyId = $('#filter_companyId').val();
                filter_warehouseId = $('#filter_warehouseId').val();
                filter_date = $('#filter_date').val();
            // }

            $("#response").show();
            $("#customer_data").hide();
            document.getElementById('response').innerHTML = loader;
            let url = '{{url('DriversAttendance/Search')}}';
            var postData = {
                filter_companyId: filter_companyId,
                filter_warehouseId: filter_warehouseId,
                filter_date: filter_date,
                _token: "{{ csrf_token() }}",
            }; 
            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                data: postData,
                success: function (data) { 
                    $('#customer_data').DataTable().clear();
                    // if (data.length > 0) {
                        $('#customer_data').DataTable().rows.add($(data)).draw();
                        if(user == 1) {
                            $('#btn').show();
                        } else if (currentDate == filter_date) {
                            $('#btn').show();
                        } else {
                            $('#btn').hide();
                        }
    
                        // for(var i = 0; i < data.length; i++){ 
                        //     var row = data[i]; 
                            // $('#customer_data').DataTable().row.add([
                            //   row.companyName, row.warehouseName, row.job_id, row.plate, row.fullName, row.name_en, 
                            //   '<label class="radio-inline" style="padding-left: 0px !important"><input type="radio" name="optradio" onclick=update("'+row.job_id+'")>Option 1</label><label class="radio-inline"><input type="radio" name="optradio">Option 2</label><label class="radio-inline"><input type="radio" name="optradio">Option 3</label>'
                            // ]).draw();
                            // var table_rows = '';
                            // $('#customer_data').DataTable().rows.add($(table_rows)).draw();
                        // }
                    // } else {
                    //     $('#customer_data').DataTable().row.add([
                    //         'No record found!', '', '', '', '', '', ''
                    //     ]).draw();
                    // }
                    $("#response").hide();
                    $("#customer_data").show();
                },
                error: function (jqXHR, status, error) {
                    alert(status + ": " + error);
                }
            }); 
        }
    }
    $(document).ready(function() {
        let currentDate = new Date().toJSON().slice(0, 10);
        $('#filter_date').prop('max', currentDate);

	    $('#customer_data').DataTable({
	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: 'lBfrtip',
            "buttons": [
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    exportOptions: {

                        modifier: {
                            search: 'applied',
                            order: 'applied'
                        }
                    }
                }
            ],
            //searching: false,
            responsive: true,
            processing: true,
            "bPaginate": false,
            "pagingType": "full_numbers",
            "autoWidth": false,
	    });
	});

function WarehouseName() {

        var filter_companyId = document.getElementById('filter_companyId').value;

        $('#filter_warehouseId').empty();

        $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
            $('#filter_warehouseId').empty();
            $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ""));
            $.each(json, function (i, obj) {
                $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
            });
        });

    } 
</script>



@endsection