@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Out-source Payments Transaction </h2>
        </div>
        <div style="float:right;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Add New Payment
            </button>
            <!-- <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New Payment</a> -->
            </h2>
        </div>
    </div>
    <div class="card card-default" style="width:100%;clear:both;"></div>

    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->


    <script>
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
    </script>
    <!-- SELECT2 EXAMPLE -->
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <button class="button_search" onclick="card_change()"><i class="fa fa-search"></i></button>
                </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box"
                                                                                             class="fa fa-plus"></i>
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
                                @foreach($lkp_company as $lkpcompany)
                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                @endforeach
                            </select>
                        </td>

                        <TH>Warehous eName</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>


                            </select>
                        </td>
                        <TH>EMP ID</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"></td>
                    </tr>
                    <tr>
                         
                        <TH>Amount</TH>
                        <td><input type="text" class="form-control" style="width:180px;" name="filter_amount"
                                   id="filter_amount" value=""></td>
                        <TH>status</TH>
                        <td>
                            <select id="filter_status_id" name="filter_status_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                 
                                    <option
                                        value="#">####</option>
                                
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Request Date</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" name="filter_journal_date"
                                       id="filter_journal_date">
                                <script>
                                    $(function () {
                                        $('input[name="filter_journal_date"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_journal_date"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_journal_date"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });
                                </script>
                            </div>

                        </td>
                        <TH>Note</TH>
                        <td><input type="text" class="form-control" name="filter_note" id="filter_note" value=""></td>
                        <TH>Updated By</TH>
                         
                    </tr>
                    <tr>
                        <TH>Update UserType</TH>
                        <td>
                            <select id="filter_updated_usertypeid" name="filter_updated_usertypeid"
                                    class="form-control">
                                <option value=""></option>
                                
                            </select>
                        </td>
                        <TH>Created_At</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_created_at" id="filter_created_at" type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_created_at"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_created_at"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_created_at"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });
                                </script>
                            </div>
                        </td>
                        <TH>Updated_At</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" id="filter_updated_at" name="filter_updated_at" type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_updated_at"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_updated_at"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_updated_at"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });
                                </script>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="card-footer" align="center">
                    <button type="button" name="filter" class="btn btn-sm btn-info" id="filter">Filter</button>

                    <button type="button" name="reset" class="btn btn-sm btn-default" id="reset">Reset</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->


    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <style>
        .red_color {
            color: red;
            font-weight: bold;
        }

        table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting,
        table.dataTable thead > tr > td.sorting_asc,
        table.dataTable thead > tr > td.sorting_desc,
        table.dataTable thead > tr > td.sorting {
            padding-right: 15px !important;
        }

        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding-left: 4px !important;

        }


    </style>
    <!---------------------------------------------------------------------------------------------------------------------->

    <?php //echo Hash::make('password');?>
    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped">
            <thead>
            <TH>#</TH>
            <TH>AMP ID</TH>
            <TH>Driver name</TH>
            <TH>Company</TH>
            <TH>Warehouse</TH>
            <TH>Amount</TH>
            <TH>Status</TH>
            <TH>Request Date</TH>
            <TH>Payment Date</TH>
            <TH>Driver's IQAMA</TH>
            <TH>STCPAY's IQAMA</TH>
            <TH>STCPAY No</TH>
            <TH>Created by</TH>
            <TH>Updated by</TH>
            <TH>Action</TH>
            
            </thead>
            <tbody>
                @foreach($data as $k=>$item)
                <tr style="text-align: center;">
                    <td><input type="checkbox" name="{{$k}}" id=""></td>

                    <td>
                        @if($item->AMP_ID == null || $item->AMP_ID == '')
                            <span style="color:red;">NULL</span>

                        @else
                            {{$item->AMP_ID}}

                        @endif
                    </td>
                    <td>@php echo $item->fullName; @endphp</td>
                    <td>{{$item->warehouse->company->companyName}}</td>
                    <td>{{$item->warehouse->warehouseName}}</td>
                    <td>{{$item->amount}}</td>
                    <td>
                        @if($item->status == 'approvedBySupervisor')
                            <button class='btn btn-warning ' style="font-size: 75%;"> Approved by supervisor</button>
                        @else
                        <button class='btn btn-success ' style="font-size: 75%;"> Paid</button>
                        @endif
                    </td>
                    <td>
                        @php 
                        $date= new DateTime($item->created_at) ;  
                        echo $date->format('Y-m-d');
                        @endphp
                    </td>
                    <td>
                        @if($item->payment_date != '' || $item->payment_date != null)
                            {{$item->payment_date}}
                        @else
                            <span style="color:blue">Not paid yet</span>
                        @endif
                    </td>
                    <td> {{$item->driver_identity}} </td>
                    
                    <td>
                        @if($item->stcpay_identity == null || $item->stcpay_identity == '' )
                            <span style="color:red">NULL</span>
                        @else
                        {{$item->stcpay_identity}}
                        @endif  
                    </td>
                    <td>
                        @if($item->stcpay_number == null || $item->stcpay_number == '' )
                        <span style="color:red">NULL</span>
                        @else
                            {{$item->stcpay_number}}
                        @endif
                    </td>
                    <td>
                        
                    @if($item->created_by == null)
                        <span style="color:red">NULL</span>
                    @else
                    {{$item->created_user->name}}
                    @endif
                        
                    </td>

                    <td>
                        @if($item->updated_by == null || $item->updated_user == '' )
                        <span style="color:red">NULL</span>
                        @else
                            {{$item->updated_user->name}}
                        @endif
                    </td>

                    <td>
                    @if($item->payment_date != '' || $item->payment_date != null)
                        <button class="btn btn-dark">Edit if NOT Paid</button>
                    @else
                        {{'Paid'}}
                    @endif
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                @if(Auth::user()->user_type_id==1)
                    <TH colspan='9'>Total</TH>
                @else
                    <TH colspan='6'>Total</TH>
                @endif
                <TH></TH>
                @if(Auth::user()->user_type_id==1)
                    <TH colspan='7'></TH>
                @else
                    <TH colspan='5'></TH>
                @endif
            </tr>
            </tfoot>
        </table>
    </div>
    @if(Auth::user()->user_type_id==1 && session('Post_15')==1)
    <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportLoanSTC")}}">
        @csrf
        <input type="hidden" name="SQL" id="SQL">
        <input type="hidden" name="companyName" id="companyName">
        <input type="hidden" name="PeriodName" id="PeriodName">
        <table style="width: 100%">
            <tr>
                <td style="width: 40%">
                    <button type="submit" name="STC_Report" id="STC_Report" class="btn btn-sm btn-info">STC pay
                        Excel
                    </button>

            </tr>
        </table>
    </form>
    @endif
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Out-source payment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="#" method="post">
                @csrf
                <div class="form-group col-6">
                    <label for="fullName">Full name <span style="color:red;">*</span></label>
                    <input type="text" required class="form-control" name="fullName" id="fullName" aria-describedby="nameHelp" placeholder="Reciver Full name">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>

                <div class="form-group">
                    <label for="job_id">AMP ID <span style="color:grey">(optional)</span></label>
                    <input type="text" class="form-control" id="job_id" name="amp_id" placeholder="AMP ID">
                </div>

                <div class="form-group">
                    <label for="ampunt">Amount <span style="color:red">*</span></label>
                    <input type="number" required class="form-control" id="ampunt" name="amount" placeholder="0.00">
                </div>
                
                <div class="form-group" >
                    <label for="company_id">Company  <span style="color:red">*</span></label>
                    <select class="form-control" required id="company_id" name="company_id">

                        <option value="0" selected disabled>Choose Company </option>
                        @foreach($lkp_company as $company)
                        <option value="{{$company->id}}">{{$company->companyName}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="warehouse_id">Warehouse <span style="color:red">*</span></label>
                    <select class="form-control" id="warehouse_id" required>
                        <option>1</option>
                        
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="job_id">Driver Identity <span style="color:red">*</span></label>
                    <input type="password" class="form-control" id="job_id" required placeholder="Password">
                </div>
                
                <div class="form-group">
                    <label for="job_id">STCPAY Identity <span style="color:red">*</span></label>
                    <input type="password" class="form-control" id="job_id" required placeholder="Password">
                </div>
                
                <div class="form-group">
                    <label for="job_id">STCPAY Number <span style="color:red">*</span></label>
                    <input type="password" class="form-control" id="job_id" required placeholder="Password">
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
    </div>
    <!-- end modal  -->
    <div id="delete_modal" class="w3-modal">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('delete_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>
            <header class="w3-container w3-text-indigo w3-margin-top-64">
                <h1>Delete</h1>
            </header>
            <form class="w3-container" action="" method="POST" id="delete_form">
                {{method_field('DELETE')}}
                @csrf
                <div class="w3-section">
                    <p>Are you sure, you want to delete <span id="delete_name"></span> ?</p>
                    <div class="w3-center">
                        <button type="submit" class="w3-btn w3-indigo"> Delete</button>
                    </div>
                </div>
            </form>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('delete_modal').style.display='none'" type="button"
                        class="w3-btn w3-red">Cancel
                </button>
            </div>
        </div>
    </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->


    <script>
        $(document).ready(function () {
           
            $( "#company_id" ).change(function() {
                var company_id = $("select#company_id option").filter(":selected").val();
                 
                // comsole.log(company_id);
            // alert(company_id);
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/getWarehouseName')}}" + "/" + company_id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        console.log(data);
                        // document.getElementById('response').innerHTML = data;
                        $('#warehouse_id').empty();
                        $('#warehouse_id').append($('<option>').text("Select ....").attr('value', ''));
                        $.each(json, function (i, obj) {
                            $('#warehouse_id').append($('<option>').text(obj.name).attr('value', obj.id));
                        });
                    }
                });



                
            });



            fill_datatable();


           
            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/Loans')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.edit', function (e) {

                var id = $(this).attr('id');
                myWindow1 = window.open("{{URL('/Loans')}}" + "/" + id + "/edit", "",
                    "height=650,width=600,scrollbars=yes,top=1,left=1,status,resizable");


            });
            $('#customer_data tbody').on('click', '.updatePaid', function (e) {

                var id = $(this).attr('id');
                myWindow1 = window.open("{{URL('/LoanPaid')}}" + "/" + id, "",
                    "height=650,width=600,scrollbars=yes,top=1,left=1,status,resizable");

            });

            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/Loans')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';
            });

            $('#filter').click(function () {
                if ($('#filter_companyId').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_journal_date').val() != '' || $('#filter_amount').val() != '' || $('#filter_status_id').val() != '' || $('#filter_note').val() != '' || $('#filter_updatedby_id').val() != '' || $('#filter_updated_usertypeid').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driverId').val(), $('#filter_journal_date').val(), $('#filter_amount').val(), $('#filter_status_id').val(), $('#filter_note').val(), $('#filter_updatedby_id').val(), $('#filter_updated_usertypeid').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {

                $('#filter_companyId').val('');
                $('#filter_warehouseId').val('');
                $('#filter_job_id').val('');
                $('#filter_driverId').val('');
                $('#filter_driverId_input').val('');
                $('#filter_journal_date').val('');
                $('#filter_amount').val('');
                $('#filter_status_id').val('');
                $('#filter_note').val('');
                $('#filter_updatedby_id').val('');
                $('#filter_updated_usertypeid').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });


        function add() {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            document.getElementById('response').innerHTML = '';
            $.ajax({
                type: 'GET',
                url: "{{URL("/out-source-payment/create")}}",
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    
                    // document.getElementById('response').innerHTML = "<h1>H1</h1>";
                    // var g = document.createElement('script');
                    // var s = document.getElementsByTagName('script')[0];
                    //  g.text = "$('#journal_date').datepicker({" +
                    //     "format: 'dd/mm/yyyy'," +
                    //     "autoclose: true," +
                    //     "autoHide: true," +
                    //     "zIndex: 9999," +
                    //     "});"
                    s.parentNode.insertBefore(g, s);
                }
            });
        }

        function status() {
            var status_id = document.getElementById('status_id').value;
            if (status_id == "3")
                document.getElementById("Termination_Reason").style.display = '';
            else
                document.getElementById("Termination_Reason").style.display = 'none';
        }

        function driver_window() {
            myWindow1 = window.open("{{URL("/DriverWindow")}}", "",
                "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
        }

        function driver(id) {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/Drivers")}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;

                }
            });
        }

        function WarehouseName() {

            var filter_companyId = document.getElementById('filter_companyId').value;
            if (filter_companyId == "")
                $('#filter_warehouseId').empty();
            else {
                $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_warehouseId').empty();
                    $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
        }
    </script>
    <script>
        function validateForm() {

            //alert($('#SQL').val());
            //return false;

            if ($('#filter_status_id').val() != '5') {
                alert('يجب اختيار ال Approved by Supervisor');
                return false;
            }

            if ($('#SQL').val().indexOf("loan.status_id=5") == -1) {
                alert('يجب الضغط علي  Filter');
                return false;
            }

            return true;

        }


    </script>
@endsection




