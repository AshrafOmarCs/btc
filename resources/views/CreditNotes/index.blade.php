@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">
                CreditNotes</h2></div>
    </div>
    <div style="float:right;">
        <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New CreditNotes</a>
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
                                <option value=""></option>
                                @foreach($lkp_company as $lkpcompany)
                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                @endforeach
                            </select>
                        </td>

                        <TH>WarehouseName</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control">
                                <option value=""></option>

                                @foreach($warehouse as $warehousee)
                                    <option value="{{$warehousee->id}}">{{$warehousee->warehouseName}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>EMP ID</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"></td>
                        <TH>Post</TH>
                        <td>
                            <select name="filter_post" id="filter_post"
                                    class="form-control" style="width:200px;">
                                <option value=""></option>
                                <option value="1"> Yes</option>
                                <option value="2"> No</option>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Driver</TH>
                        <td style="white-space: nowrap;">
                            <input name="filter_driverId" id="filter_driverId" type="hidden" value="">
                            <table style="padding: 0px 0px; !important;">
                                <tr>
                                    <td>
                                        <input class="form-control" name="filter_driverId_input"
                                               id="filter_driverId_input" style="width:200px" type="text" value=""
                                               data-readonly>
                                    </td>
                                    <td>
                                        <button onclick="driver_window();" type="button" class="btn btn-primary btn-xs">
                                            Select
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <TH>Journal Date</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" style="width:180px;" name="filter_journal_date"
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
                        <TH>Amount</TH>
                        <td><input type="text" class="form-control" style="width:180px;" name="filter_amount"
                                   id="filter_amount" value=""></td>

                    </tr>
                    <tr>
                        <TH>Invoice Number</TH>
                        <td><input type="text" class="form-control" style="width:200px;" name="filter_invoice_number"
                                   id="filter_invoice_number" value=""></td>
                        <TH>Note</TH>
                        <td><input type="text" class="form-control" style="width:200px;" name="filter_note"
                                   id="filter_note" value=""></td>


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

    <!-- select all boxes -->
    @if(Auth::user()->user_type_id==1)
    <table style="width:100%">
        <tr>
            <td align=right>
                <input class="flat-red" type="checkbox" name="select-all" id="select-all"/>&nbsp;&nbsp;Select All
            </td>
        </tr>
    </table>
    @endif

    <form method="POST" action="{{ URL('/CreditNotesPost')}}">
        @csrf
        <div class="table-responsive" style="width: 100%;">
            <table id="customer_data" class="table table-bordered table-striped">
                <thead>
                <TH>Company</TH>
                <TH>Warehouse</TH>
                <TH>EMP ID</TH>
                <TH>Driver</TH>
                @if(Auth::user()->user_type_id==1)
                <TH>previous Balance</TH>
                <TH>Current Balance</TH>
                @endif
                <TH>Journal Date</TH>
                @if(Auth::user()->user_type_id==1)
                <TH>Journal Period</TH>
                @endif
                <TH>Amount</TH>
                <TH>Note</TH>
                @if(Auth::user()->user_type_id==1)
                <TH>Create By</TH>
                @endif
                <TH>Create At</TH>
                @if(Auth::user()->user_type_id==1)
                <TH>Post</TH>
                @endif
                <TH>Action</TH>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    @if(Auth::user()->user_type_id==1)
                    <TH colspan='8'>Total</TH>
                    @else
                        <<TH colspan='5'>Total</TH>
                    @endif
                    <TH></TH>
                    @if(Auth::user()->user_type_id==1)
                        <TH colspan='5'></TH>
                    @else
                        <TH colspan='3'></TH>
                    @endif
                </tr>
                </tfoot>
            </table>
        </div>
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
                var dataTable = $('#customer_data').DataTable({
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    @if(Auth::user()->user_type_id==1)
                    "order": [[11, "desc"]],
                    @else
                    "order": [[7, "desc"]],
                    @endif
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function () {
                        $('[data-toggle="tooltip"]').tooltip();
                        var api = this.api()
                        var json = api.ajax.json();
                        @if(Auth::user()->user_type_id==1)
                        $(api.column(8).footer()).html(json.amount);
                        @else
                        $(api.column(5).footer()).html(json.amount);
                        @endif

                        $(function () {
                            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                                checkboxClass: 'icheckbox_flat-green',
                                radioClass: 'iradio_flat-green'
                            });


                            $('#select-all').on('ifChecked ifUnchecked', function (event) {
                                if (document.getElementById('select-all').checked) {

                                    $('.flat-red').iCheck('check')
                                } else
                                    $('.flat-red').iCheck('uncheck');
                            });
                        });
                    },
                    ajax: {
                        url: "{{ route('CreditNotes.index') }}",
                        data: {
                            filter_companyId: filter_companyId,
                            filter_warehouseId: filter_warehouseId,
                            filter_job_id: filter_job_id,
                            filter_driverId: filter_driverId,
                            filter_journal_date: filter_journal_date,
                            filter_amount: filter_amount,
                            filter_invoice_number: filter_invoice_number,
                            filter_note: filter_note,
                            filter_created_at: filter_created_at,
                            filter_updated_at: filter_updated_at,
                            filter_post: filter_post,
                        }
                    },

                    columns: [
                        {
                            data: 'companyName',
                            name: 'lkp_company.companyName',
                            //visible:false
                        },
                        {
                            data: 'warehouseName',
                            name: 'warehouse.warehouseName',
                            //visible:false
                        },
                        {
                            data: 'job_id',
                            name: 'drivers.job_id'
                        },
                        {
                            data: 'fullName',
                            name: 'drivers.fullName',

                            render: function (data, type, row, meta) {
                                return '<a href="javascript:driver(' + row.driverId + ')">' + data + '</a>';
                            }

                        },
                            @if(Auth::user()->user_type_id==1)
                        {
                            data: 'per_priod',
                            name: 'balance.per_priod'
                        },
                        {
                            data: 'cur_priod',
                            name: 'balance.cur_priod'
                        },
                            @endif
                        {
                            data: 'journal_date',
                            name: 'journal_date'
                        },
                            @if(Auth::user()->user_type_id==1)
                        {
                            data: 'journal_period',
                            name: 'journal_period',
                            bSearchable: false
                        },
                            @endif
                        {
                            data: 'amount',
                            name: 'amount'
                        },

                        {
                            data: 'note',
                            name: 'note'
                        },
                            @if(Auth::user()->user_type_id==1)
                        {
                            data: 'name',
                            name: 'users.name'
                        },
                            @endif
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                            @if(Auth::user()->user_type_id==1)
                        {
                            data: 'journal_id',
                            //"orderable": false,
                            "className": "text-center",
                            "render": function (data, type, row, meta) {
                                if (!row.journal_id)
                                    return '<input class="flat-red" name="ID_' + meta.row + '" type="checkbox" value="' + row.id + '">';
                                else return '<span class="label label-success">Yes</span>';
                            }
                        },
                            @endif
                        {
                            "orderable": false,
                            className: "dt-nowrap text-center",
                            "targets": -1,

                            "render": function (data, type, row, meta) {
                                var d = '';
                                @if(Auth::user()->user_type_id==1)
                                if (!row.journal_id) {
                                    d = d + '<a id=' + row.id + ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>' +
                                        '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>'
                                }
                                @endif
                                d = d + '&nbsp;<a id=' + row.id + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>';
                                @if(Auth::user()->user_type_id==1)
                                d = d + '&nbsp;<a id=' + row.id + ' data-original-title="print" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue print"> <i class="fa fa-print" aria-hidden="true"></i> </a>';
                                @endif
                                return d;
                            }
                        }
                    ]
                });


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

                        document.getElementById('response').innerHTML = data;

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




