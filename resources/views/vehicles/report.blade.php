@extends('AdminLTE')
@section('content')  
<link rel="stylesheet" href="{{asset('dropAndDrag/src/style.css')}}">


    <style>
        th{
            /* background-color: #d4c8b8; */
        }
        td{
            /* box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; */
            border: 1px solid white;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;">
            <h2 style="width:100%;font-size: 14px;font-weight: bold;">Vehicles Report</h2>
            <p>By this module, you can see the report/history of vehicles for a specific date range.</p>
        </div>
    </div>
    <!-- end of header -->
    <div class="card card-default" style="width:100%;clear:both;"></div>

        <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->
    <!-- SELECT2 EXAMPLE -->
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <button class="button_search" onclick="card_change()"><i class="fa fa-search"></i></button>
                </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box" class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive">
                <table class="table m-0 search_table" style="width:10px!important;">
                    <tr>
                        <TH>Company Name</TH>
                        <td>
                            <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                    class="form-control" style="width:180px;" required>
                                <option value=""></option>
                                @foreach($lkp_company as $company)
                                    <option value="{{ $company->id }}">{{ $company->companyName }}</option>
                                @endforeach
                                
                            </select>
                        </td> 
                        <TH>Warehouse Name</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                    style="width:180px;"> 
                                <option value=""></option> 
                            </select>
                        </td>
                        <TH>Date</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_date" id="filter_date" type="text" style="width:180px;">
                                <script>
                                    $(function () {
                                        $('input[name="filter_date"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        
                                        $('input[name="filter_date"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('YYYY-MM-DD') + '/' + picker.endDate.format('YYYY-MM-DD'));
                                        });
                                        $('input[name="filter_date"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });

                                </script>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <TH>Report Type</TH>
                        <td>
                            <select id="filter_type" name="filter_type" class="form-control"
                                    style="width:180px;" onchange="type_change()" > 
                                <option value="0">Summary</option>
                                <option value="1">Specific Vehicle</option>
                            </select>
                        </td>
                        <TH class="type">Vehicles</TH>
                        <td class="type">
                            <select id="filter_vehicleId" name="filter_vehicleId" class="form-control"
                                    style="width:180px;"> 
                                    <option value="">Select Vehicle</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->plate }}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH class="type">Status</TH>
                        <td class="type">
                            <select id="filter_status" name="filter_status" class="form-control"
                                    style="width:208px;">
                                <option value="">Select Status</option> 
                                <option value="availabe">Available</option>
                                <option value="damaged">Damaged</option>
                                <option value="delegeted">Delegeted</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </td>
                        
                    </tr>
                </table>
                <div class="card-footer" align="center">
                    <button type="button" name="filter" id="filter" class="btn btn-sm btn-info" onclick="confirmSearch()">Filter</button>

                    <button type="button" name="reset" id="reset" class="btn btn-sm btn-default" onclick="reset_records()">Reset</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->


    <div class="table-responsive" style="width: 100%;">
        <div style="width:100%;clear:both;" id="response">
    
        </div>
        <table id="customer_data" class="table table-bordered table-striped table-responsive">
            <thead id="header">
                <TH>Sr. No</TH>
                <TH >Company</TH>
                <TH >Warehouse</TH>
                <TH >Date</TH>
                <TH >Vehicle</TH>
            </thead>
            <tbody>
               
                
            </tbody>
            <tfoot id="report_foot"></tfoot>
        </table>
    </div>
<div id="info_modal" class="w3-modal" style="padding-top: 10px !important;">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:850px">
        <div class="w3-center"><br>
            <span onclick="document.getElementById('info_modal').style.display='none'"
                class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                title="Close Modal">&times;
            </span>
        </div>
        <div style="width:100%;clear:both;" id="response">
            <div class="row">
                <div class="col-lg-6">
                    <h4>Abbrevations Information</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table id="customer_data" class="table table-bordered table-striped table-responsive">
                        <thead id="header">
                            <TH>Abbrevation</TH>
                            <TH >Stands for</TH>
                        </thead>
                        <tbody>
                            <tr>
                               <td>N/A</td>
                               <td>Not Applicable</td>
                           </tr>
                           <tr>
                               <td>A</td>
                               <td>Absent</td>
                           </tr>
                           <tr>
                               <td>P</td>
                               <td>Present</td>
                           </tr>
                           <tr>
                               <td>AWE</td>
                               <td>Absent With Excuse</td>
                           </tr>
                           <tr>
                               <td>M</td>
                               <td>Maintenance</td>
                           </tr>
                           <tr>
                               <td>D</td>
                               <td>Damaged</td>
                           </tr>
                           <tr>
                               <td>MA</td>
                               <td>Missed Attendance</td>
                           </tr>
                           <tr>
                               <td>Stop</td>
                               <td>Available</td>
                           </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button
                    onclick="document.getElementById('response').innerHTML='';document.getElementById('info_modal').style.display='none'"
                    type="button" class="w3-btn w3-red">Cancel
                </button>
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready( function () {
            $('.type').hide();
            $('#customer_data').DataTable({
    	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                // dom: 'lBfrtip',
                // "buttons": [
                //     {
                //         extend: 'excel',
                //         text: 'Export to Excel',
                //         exportOptions: {
                //             modifier: {
                //                 search: 'applied',
                //                 order: 'applied'
                //             }
                //         }
                //     }
                // ],
                //searching: false,
                responsive: true,
                processing: true,
                "pagingType": "full_numbers",
                // "autoWidth": false,
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
        function type_change() {
            let types = $("#filter_type").val();
            if(types == 0)
                $('.type').hide();
            else
                $('.type').show();
        }
        function card_change() {
            if (document.getElementById('card_box').className == "box box-primary") {
                document.getElementById('card_box').className = "box box-primary collapsed-box";
                document.getElementById('i_box').className = "fa fa-plus";
                document.getElementById('box-body').style.display = 'none';
            } else {
                document.getElementById('card_box').className = "box box-primary";
                document.getElementById('i_box').className = "fa fa-minus";
                document.getElementById('box-body').style.display = '';
            }
        }
        
        
        function confirmSearch(){ 
            if($('#filter_date').val() == ''){ 
                alert('Date Can not Be Empty');
            }else{
                var filter_companyId = filter_warehouseId = filter_date = filter_vehicleId = filter_type = filter_status = '';
                filter_companyId = $('#filter_companyId').val();
                filter_warehouseId = $('#filter_warehouseId').val();
                filter_date = $('#filter_date').val();
                filter_type = $('#filter_type').val();
                filter_vehicleId = $('#filter_vehicleId').val();
                filter_status = $('#filter_status').val();
                
                $("#response").show();
                $("#customer_data").hide();
                document.getElementById('response').innerHTML = loader;
                let url = '{{url('Vehicles/ReportSearch')}}';
                var postData = {
                    filter_companyId: filter_companyId,
                    filter_warehouseId: filter_warehouseId,
                    filter_date: filter_date,
                    filter_type: filter_type,
                    filter_vehicleId: filter_vehicleId,
                    filter_status: filter_status,
                    _token: "{{ csrf_token() }}",
                }; 
                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    data: postData,
                    success: function (data) { 
                        data = data.split(":::")                        
                        $("#header").html(data[0]);
                        $('#customer_data').DataTable().clear();
                        $('#customer_data').DataTable().rows.add($(data[1])).draw();

                        $('#customer_data').DataTable().column(0).header().innerHTML = 'Vehicle';
                        $("#report_foot").html(data[2]);

                        $("#response").hide();
                        $("#customer_data").show();
                    },
                    error: function (jqXHR, status, error) {
                        alert(status + ": " + error);
                    }
                }); 
            }
        }
        
        function reset_records() {
            $('#filter_companyId').val('');
            $('#filter_warehouseId').val('');
            $('#filter_date').val('');
            $('#filter_type').val('0');
            $('.type').hide();
            $('#filter_vehicleId').val('');
            $('#filter_status').val('availabe');
        }
        function show_info() {
            document.getElementById('info_modal').style.display = 'block';
        }
    </script>
@endsection