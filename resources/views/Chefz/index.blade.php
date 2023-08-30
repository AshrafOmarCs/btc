@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Chefz
                Clearing</h2></div>
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


                        <TH>City</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                    style="width:180px;">

                                <option value=""></option>
                                @foreach($warehouse as $warehousee)
                                    <option value="{{$warehousee->id}}"> {{$warehousee->warehouseName}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>EMP ID</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"
                                   style="width:180px;"></td>

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
                        <TH>Settle Period</TH>
                        <td>
                            <select name="filter_chefz_period_id" id="filter_chefz_period_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                @foreach($lkp_chefz_period as $lkp_chefz_periodd)
                                    <option
                                        value="{{$lkp_chefz_periodd->id}}">{{$lkp_chefz_periodd->Invoice_From_Date}}  {{$lkp_chefz_periodd->Invoice_To_Date}}</option>
                                @endforeach
                            </select>
                        </td>

                    </tr>


                    <tr>
                        <TH>Paid</TH>
                        <td>
                            <select name="filter_paid_id" id="filter_paid_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Chefz Date</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_SettledDate" id="filter_SettledDate"
                                       type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_SettledDate"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_SettledDate"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_SettledDate"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });


                                </script>
                            </div>
                        </td>

                    </tr>
                </table>
                <div class="card-footer" align="center">
                    <button type="button" name="filter" id="filter" class="btn btn-sm btn-info">Filter</button>

                    <button type="button" name="reset" id="reset" class="btn btn-sm btn-default">Reset</button>
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


    <!---------------------------------------------------------------------------------------------------------------------->
    <style>
        .table-cell-nolrpadding {
            padding: .3em .0em !important;
        }

        .tab-boder {
            border-top: #1C1D21 solid 0.5px !important;
            border-bottom: #1C1D21 solid 0.5px !important;
            border-left: #1C1D21 solid 0.5px !important;
        }

        .red_color {
            color: red;
            font-weight: bold;
        }
    </style>
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

    @if(Auth::user()->user_type_id==1 && session('Post_35')==1)
        <table style="width:100%">
            <tr>
                <td align=right>
                    <input class="flat-red" type="checkbox" name="select-all" id="select-all"/>&nbsp;&nbsp;Select All
                </td>
            </tr>
        </table>
    @endif

    <form method="POST" action="{{ URL('/DriversChefzClearingPost')}}">
        @csrf
        <div class="table-responsive" style="width: 100%;">
            <table id="customer_data" class="table table-bordered table-striped">

                <thead>
                <tr>
                    <TH>Chefz Date</TH>
                    <TH>City</TH>
                    <TH>EMP ID</TH>
                    <TH>Driver</TH>
                    <TH>Iqama</TH>
                    <TH>STC Account</TH>
                    <TH>Paid</TH>
                    <TH>isPaid NO</TH>
                    <TH>Delivery Fees</TH>
                    <TH>Delivery With VAT</TH>
                    <TH>Bouns</TH>
                    <TH>Deduction</TH>
                    <TH>Compensation</TH>
                    <TH>NO Dispatch</TH>
                    <TH>Bander Commission</TH>
                    <TH>Salary</TH>
                </tr>

                </thead>

                <tfoot>
                <tr>
                    <TH colspan='7'>Total</TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>

                </tr>
                </tfoot>

            </table>
        </div>
        @if(Auth::user()->user_type_id==1 && session('Post_35')==1)

            <table style="width: 100%">
                <tr>
                    <td style="text-align: center">
                        <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">تم الدفع</button>
                    </td>
                </tr>
            </table>
        @endif
    </form>

    <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportChefzSTC")}}">
        @csrf
        <input type="hidden" name="SQL" id="SQL">
        <table style="width: 100%">
            <tr>
                <td style="width: 40%">
                    <button type="submit" name="STC_Report" id="STC_Report" class="btn btn-sm btn-info">STC pay
                        Excel
                    </button>

            </tr>
        </table>
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


            function fill_datatable(filter_warehouseId = '', filter_job_id = '', filter_driverId = '', filter_chefz_period_id = '', filter_paid_id = '', filter_SettledDate = '') {
                var dataTable = $('#customer_data').DataTable({
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "order": [[0, "desc"]],
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function () {
                        var api = this.api()
                        var json = api.ajax.json();
                        $(api.column(13).footer()).html(json.numberOfDispatch);
                        $(api.column(14).footer()).html(json.Bander_Commission);
                        $(api.column(15).footer()).html(json.Salary);
                        $('#SQL').val(json.SQL);

                        $(function () {
                            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                                checkboxClass: 'icheckbox_flat-blue',
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
                        url: "{{ route('DriversChefzClearing.index') }}",
                        data: {

                            filter_warehouseId: filter_warehouseId,
                            filter_job_id: filter_job_id,
                            filter_driverId: filter_driverId,
                            filter_chefz_period_id: filter_chefz_period_id,
                            filter_paid_id: filter_paid_id,
                            filter_SettledDate: filter_SettledDate,

                        }
                    },

                    columns: [
                        {
                            data: 'Invoice_To_Date',
                            name: 'lkp_chefz_period.Invoice_To_Date'
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
                        {
                            data: 'account_owner_iqama',
                            name: 'drivers.account_owner_iqama'
                        },
                        {
                            data: 'accountNumber',
                            name: 'drivers.accountNumber'
                        },
                        {
                            data: 'paid_id',
                            //"orderable": false,
                            "className": "text-center",
                            "render": function (data, type, row, meta) {
                                if (!row.paid_id) {
                                    @if(Auth::user()->user_type_id==1 && session('Post_35')==1)
                                        return '<input class="flat-red" name="ID_' + meta.row + '" type="checkbox" value="' + row.id + '">';
                                    @else
                                        return '<span class="label label-warning">No</span>';
                                    @endif
                                } else return '<span class="label label-success">Yes</span>';
                            }
                        },
                        {
                            data: 'Order_Total_isPaid_NO',
                            name: 'Order_Total_isPaid_NO'
                        },
                        {
                            data: 'Total_Delivery_Fees',
                            name: 'Total_Delivery_Fees'
                        },
                        {
                            data: 'Total_Delivery_Fees_VAT',
                            name: 'Total_Delivery_Fees_VAT'
                        },
                        {
                            data: 'Bouns',
                            name: 'Bouns'
                        },
                        {
                            data: 'Deduction',
                            name: 'Deduction'
                        },
                        {
                            data: 'Compensation',
                            name: 'Compensation'
                        },
                        {
                            data: 'numberOfDispatch',
                            name: 'numberOfDispatch'
                        },
                        {
                            data: 'Bander_Commission',
                            name: 'Bander_Commission'
                        },
                        {
                            data: 'Salary',
                            name: 'Salary',
                            render: function (data, type, row, meta) {
                                return '<b>' + row.Salary + '</b>';
                            }
                        },

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
                    url: "{{URL('/DriversChefzClearing')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });


            $('#filter').click(function () {
                if ($('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_chefz_period_id').val() != '' || $('#filter_paid_id').val() != '' || $('#filter_SettledDate').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driverId').val(), $('#filter_chefz_period_id').val(), $('#filter_paid_id').val(), $('#filter_SettledDate').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {
                $('#filter_warehouseId').val('');
                $('#filter_job_id').val('');
                $('#filter_driverId').val('');
                $('#filter_driverId_input').val('');
                $('#filter_chefz_period_id').val('');
                $('#filter_paid_id').val('');
                $('#filter_SettledDate').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });


        function status() {
            var status_id = document.getElementById('status_id').value;
            if (status_id == "3")
                document.getElementById("Termination_Reason").style.display = '';
            else
                document.getElementById("Termination_Reason").style.display = 'none';
        }

        function driver_window() {
            $('#filter_driverId').val('');
            $('#filter_driverId_input').val('');
            myWindow1 = window.open("{{URL("/DriverWindow")}}", "",
                "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
        }

        //Date picker
        $(function () {
            $('#pakage_date').datepicker({
                autoclose: true,
                autoHide: true,
                zIndex: 9999,
            });
        });

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


           // if ($('#filter_warehouseId').val() == '') {
           //     alert('يجب اختيار ال CITY');
           //     return false;
           // }
            //if ($('#filter_chefz_period_id').val() != '2') {
            //    alert('يجب اختيار ال Clearing Type = تسليم');
            //   return false;
            //}
            if ($('#filter_paid_id').val() != '2') {
                alert('يجب اختيار ال Paid = لا');
                return false;
            }
            if ($('#filter_SettledDate').val() == '') {
                alert('يجب اختيار ال Chefz SettledDate');
                return false;
            }

            if ($('#SQL').val().indexOf("chefz_settlement.paid_id is  null") == -1) {
                alert('يجب الضغط علي  Filter');
                return false;
            }

            return true;

        }


    </script>
@endsection




