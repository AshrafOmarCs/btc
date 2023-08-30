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
            <h2 style="width:100%;font-size: 14px;font-weight: bold;">Claims Deduction</h2>
            <p>By this module, you can see the claims deduction information for each driver by selecting a specific date range.</p>
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
                                    class="form-control" style="width:200px;" required>
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
                        <TH>From</TH>
                        <td>
                            <input type="date" id="filter_dateFrom" name="filter_dateFrom" class="form-control"
                                    style="width:180px;"> 
                        </td>
                        <TH>To</TH>
                        <td>
                            <input type="date" id="filter_dateTo" name="filter_dateTo" class="form-control"
                                    style="width:180px;"> 
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
                <TH >City</TH>
                <TH >Job Id</TH>
                <TH >Driver</TH>
                <TH >Phone</TH>
                <TH >Iqama</TH>
                <TH >Amount</TH>
                <TH >Action</TH>

            </thead>
            <tbody>
                
            </tbody>
            <tfoot>
                <TH colspan = '8' style="text-align: center;">Total</TH>
                <TH id="total" style="text-align: right;"></TH>
                <th></th>
            </tfoot>
        </table>
    </div>
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:850px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('edit_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>

            <div style="width:100%;clear:both;" id="response1">

            </div>
        </div>
    </div>

    <script>
        $(document).ready( function () {
            call_datatable("Claims of companies except Jahiz");
            function call_datatable(excel_title) {
                $('#customer_data').DataTable({
        	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    dom: 'lBfrtip',
                    "buttons": [
                        {
                            extend: 'excel',
                            text: 'Export to Excel',
                            title: excel_title,
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
                    "pagingType": "full_numbers",
                    "autoWidth": false,
        	    });
            }
        });
        function sheet(id, Period) {
            myWindow1 = window.open("https://btcdmins.com/SalaryShow" + "/" + id + "/" + Period, "",
                "height=1000,width=650,scrollbars=yes,top=1,left=1,status,resizable");
        }
        $('#customer_data tbody').on('click', '.statement', function (e) {
            e.preventDefault();
            document.getElementById('response1').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: "https://btcdmins.com/statement" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response1').innerHTML = data;


                }
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
            if($('#filter_dateFrom').val() == '' || $('#filter_dateTo').val() == ''){ 
                alert('Date can not Be Empty');
            }else {
                var filter_companyId = filter_warehouseId = filter_dateFrom = filter_dateTo = '';
                filter_companyId = $('#filter_companyId').val();
                filter_warehouseId = $('#filter_warehouseId').val();
                filter_dateFrom = $('#filter_dateFrom').val();
                filter_dateTo = $('#filter_dateTo').val();
                var excel_title = "Claims of companies except Jahiz from " + filter_dateFrom + " to " + filter_dateTo;

                $("#response").show();
                $("#customer_data").hide();
                document.getElementById('response').innerHTML = loader;
                let url = '{{url('ClaimsDeduction/Search')}}';
                var postData = {
                    filter_companyId: filter_companyId,
                    filter_warehouseId: filter_warehouseId,
                    filter_dateFrom: filter_dateFrom,
                    filter_dateTo: filter_dateTo,
                    
                    _token: "{{ csrf_token() }}",
                }; 
                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    data: postData,
                    success: function (data) { 
                        data = data.split(':::');
                        $('#customer_data').DataTable().clear();
                        $('#customer_data').DataTable().rows.add($(data[0])).draw();
                        $("#total").html(data[1]);
                        $("#response").hide();
                        $("#customer_data").show();
                        call_datatable(excel_title);
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
            
        }
        
    </script>
@endsection