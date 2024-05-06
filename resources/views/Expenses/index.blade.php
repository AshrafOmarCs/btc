@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">
                Expenses </h2></div>
    </div>
    <div style="float:right;">
        <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New Expenses Type</a>
        </h2>
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
                        <TH>CompanyName</TH>
                        <td>
                            <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                    class="form-control" style="width:200px;" required>
                                    <option value="0" disabled selected>Select Company</option> 
                                    @foreach($lkp_company as $lkpcompany)
                                        <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                    @endforeach
                            </select>
                        </td> 

                        <TH>Expense For</TH>
                        <td>
                            <select name="filter_companyId" id="filter_companyId" 
                                    class="form-control" style="width:200px;" required>
                                    <option value="0" disabled selected>Select Object</option> 
                                    <option value="company" >Company</option> 
                                    <option value="driver" >Driver</option>  
                            </select>
                        </td> 
                    </tr>
                    <tr>
                    
                    
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

    <!-- select all boxes -->
    

    <form method="POST" action="{{ URL('/CreditNotesPost')}}">
        @csrf
        <div class="table-responsive" style="width: 100%;">
            <table id="customer_data" class="table table-bordered table-striped">
               
                <thead>
                    <tr> 
                <TH  style="text-align: center;">#</TH>
                <TH  style="text-align: center;">Company</TH>
                <TH  style="text-align: center;">Expense Name</TH>
                <TH  style="text-align: center;">Expense Amount </TH>
                <TH  style="text-align: center;"> Created at </TH> 
                <!-- <TH  style="text-align: center;">Action</TH> -->
    </tr>
                </thead>
                <tbody>
                    @foreach($expense_types as $k=>$expense_type)
                    <tr style="text-align: center;">
                        <TD>{{$k+1}}</TD>
                        <TD>{{$expense_type->company->companyName}}</TD>
                        <TD>{{$expense_type->name}}</TD>
                        <TD>{{$expense_type->amount}}</TD> 
                        <TD>{{$expense_type->created_at}}</TD>

                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    @if(Auth::user()->user_type_id==1)
                    <TH colspan='8'>Total</TH>
                    @else
                        <TH colspan='5'>Total</TH>
                    @endif
                </tr>
                </tfoot>
            </table>
        </div>

        {{ $expense_types->links() }}
        @if(Auth::user()->user_type_id==1)
        <center>
            <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">Post To Journal</button>
        </center>
        @endif
    </form>

    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('edit_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>

            <div style="width:100%;clear:both;" id="response">

            </div>
            <br>
            <br>
        </div>
    </div>
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

            fill_datatable();


            function fill_datatable(filter_companyId = '', filter_warehouseId = '', filter_job_id = '', filter_driverId = '', filter_journal_date = '', filter_amount = '', filter_invoice_number = '', filter_note = '', filter_created_at = '', filter_updated_at = '', filter_post = '') {
                 


            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/CreditNotes')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        // document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.edit', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/CreditNotes')}}" + "/" + id + "/edit",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;
                        var g = document.createElement('script');
                        var s = document.getElementsByTagName('script')[0];
//g.text = "alert(\"hi\");"
                        g.text = "$('#journal_date').datepicker({" +
                            "format: 'dd/mm/yyyy'," +
                            "autoclose: true," +
                            "autoHide: true," +
                            "zIndex: 9999," +
                            "});"
                        s.parentNode.insertBefore(g, s);

                    }
                });
            });
            $('#customer_data tbody').on('click', '.print', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                myWindow1 = window.open("{{URL("CreditNotesPrint")}}" + "/" + id, "mywin",
                    "height=900,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
                myWindow1.focus();
            });


            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/CreditNotes')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';


            });


            $('#filter').click(function () {

                if ($('#filter_companyId').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_journal_date').val() != '' || $('#filter_amount').val() != '' || $('#filter_invoice_number').val() != '' || $('#filter_note').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '' || $('#filter_post').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driverId').val(), $('#filter_journal_date').val(), $('#filter_amount').val(), $('#filter_invoice_number').val(), $('#filter_note').val(), $('#filter_created_at').val(), $('#filter_updated_at').val(), $('#filter_post').val());
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
                $('#filter_invoice_number').val('');
                $('#filter_note').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');
                $('#filter_post').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });

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

        function add() {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/CreditNotes/create")}}",
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;
                    var g = document.createElement('script');
                    var s = document.getElementsByTagName('script')[0];
//g.text = "alert(\"hi\");"
                    g.text = "$('#journal_date').datepicker({" +
                        "format: 'dd/mm/yyyy'," +
                        "autoclose: true," +
                        "autoHide: true," +
                        "zIndex: 9999," +
                        "});"
                    s.parentNode.insertBefore(g, s);

                }
            });
        }
        function CityName() {
            var filter_companyId = document.getElementById('filter_companyId').value;
            if (filter_companyId == "") {
                $('#filter_cityId').empty();
                $('#filter_warehouseId').empty();
                $('#filter_Period').empty();
            } else {

                $.getJSON("{{URL("/getPeriod")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_Period').empty();
                    $('#filter_warehouseId').empty();
                    //$('#filter_Period').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_Period').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
                //----------------------------------------------------------------------------------------------------------------------
              
            }
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

@endsection




