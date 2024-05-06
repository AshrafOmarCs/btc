@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Jahiz
                Claim</h2></div>
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
                        <TH>Driver Type</TH>
                        <td>
                            <select name="filter_driver_type_id" id="filter_driver_type_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                @foreach($lkp_driver_type as $lkp_driver_typee)
                                    <option
                                        value="{{$lkp_driver_typee->id}}">{{$lkp_driver_typee->driver_type}}</option>
                                @endforeach
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

                        <TH>claim Date</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_claim_dt" id="filter_claim_dt" type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_claim_dt"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_claim_dt"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_claim_dt"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });
                                </script>
                            </div>
                        </td>
                        <TH>Last SettledDate</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_lastSettlementDate"
                                       id="filter_lastSettlementDate"
                                       type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_lastSettlementDate"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_lastSettlementDate"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_lastSettlementDate"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });


                                </script>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <TH>Claim Status</TH>
                        <td>
                            <select id="filter_claim_status_id" name="filter_claim_status_id" placeholder="Select ..."
                                    class="form-control">
                                <option value=""></option>
                                @foreach($lkp_claim_status as $lkp_claim_statuss)
                                    <option
                                        value="{{$lkp_claim_statuss->id}}">{{$lkp_claim_statuss->status_txt}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>Image PromissoryNote</TH>
                        <td>
                            <select name="filter_Image_PromissoryNote" id="filter_Image_PromissoryNote"
                                    class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                    </tr>

                    <tr>

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

        .green_color {
            color: green;
            font-weight: bold;
        }
    </style>
    <!---------------------------------------------------------------------------------------------------------------------->

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

    <form method="POST" action="{{ URL('/DriversJahizClaimPost')}}">
        @csrf
        <div class="table-responsive" style="width: 100%;">
            <table id="customer_data" class="table table-bordered table-striped">

                <thead>
                <tr>
                    <TH rowspan="2">Update At</TH>
                    <TH rowspan="2">City</TH>
                    <TH rowspan="2">EMP ID</TH>
                    <TH rowspan="2">Driver</TH>
                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">SANED</TH>
                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">Bander</TH>
                    <TH rowspan="2">Last Settlement Date</TH>
                    <TH rowspan="2">Claim Amount</TH>
                    <TH rowspan="2">موعد السداد</TH>
                    <TH rowspan="2">رسوم الشنطة</TH>
                    <TH rowspan="2">عمولة بندر</TH>
                    <TH rowspan="2">Reply</TH>
                    @if(session('Delete_27')==1)
                        <TH rowspan="2">Action</TH>
                    @endif


                </tr>
                <tr>
                    <TH>SAR</TH>
                    <TH>Days</TH>
                    <TH>SAR</TH>
                    <TH style="border-right: 1px solid #f4f4f4!important;">Days</TH>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <TH colspan='9'>Total</TH>
                    <TH></TH>

                    <TH colspan='4'></TH>
                    @if (session('Delete_27')==1)
                        <TH></TH>
                    @endif

                </tr>
                </tfoot>
            </table>
        </div>

    </form>

    <form method="POST" action="{{URL("/ExportClaim")}}">
        @csrf
        <input type="hidden" name="SQL" id="SQL">
        <table style="width: 100%">
            <tr>
                <td style="width: 40%">
                    <button type="submit" name="STC_Report" id="STC_Report" class="btn btn-sm btn-info">Claim
                        Excel
                    </button>

            </tr>
        </table>
    </form>

    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:1000px">
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
            <div style="width:100%;clear:both;" id="delete_response">

            </div>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('delete_modal').style.display='none'" type="button"
                        class="w3-btn w3-red">Cancel
                </button>
            </div>
        </div>
    </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <style>
        .table-cell-nolrpadding {
            padding: .0em .0em !important;
        }

        .tab-boder th {
            border: #1C1D21 solid 0.5px !important;
            padding: .0em .2em !important;
            background-color: #EBEBEB !important;
            font-weight: normal !important;
        }

        .tab-boder td {
            border: #1C1D21 solid 0.5px !important;
            padding: .0em .2em !important;
        }


    </style>
    <!---------------------------------------------------------------------------------------------------------------------->


    <script>
        $(document).ready(function () {

            fill_datatable();


            function fill_datatable(filter_warehouseId = '', filter_job_id = '', filter_driver_type_id = '', filter_driverId = '', filter_claim_dt = '', filter_lastSettlementDate = '', filter_claim_status_id = '', filter_Image_PromissoryNote = '', filter_created_at = '', filter_updated_at = '') {
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

                        $(api.column(9).footer()).html(json.amount);
                        $('#SQL').val(json.SQL);

                    },
                    ajax: {
                        url: "{{ route('DriversJahizClaim.index') }}",
                        data: {

                            filter_warehouseId: filter_warehouseId,
                            filter_job_id: filter_job_id,
                            filter_driver_type_id: filter_driver_type_id,
                            filter_driverId: filter_driverId,
                            filter_claim_dt: filter_claim_dt,
                            filter_lastSettlementDate: filter_lastSettlementDate,
                            filter_claim_status_id: filter_claim_status_id,
                            filter_Image_PromissoryNote: filter_Image_PromissoryNote,
                            filter_created_at: filter_created_at,
                            filter_updated_at: filter_updated_at,
                        }
                    },

                    columns: [

                        {
                            data: 'updated_at',
                            name: 'drivers_jahiz_claim.updated_at'
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
                            "searchable": false,
                            data: 'SANED_amount',
                            name: 'SANED_amount',
                            render: function (data, type, row, meta) {
                                if (row.SANED_amount == null)
                                    return '';
                                else if (row.SANED_amount != row.Jahiz_Amount) {
                                    return '<span class="red_color">' + row.SANED_amount + '</span>';
                                } else if (row.SANED_amount == null)
                                    return '';
                                else
                                    return row.SANED_amount;


                            }
                        },

                        {
                            "searchable": false,
                            data: 'SANED_SettledDate',
                            name: 'SANED_SettledDate'
                        },

                        {
                            "searchable": false,
                            data: 'Jahiz_Amount',
                            name: 'Jahiz_Amount',
                            render: function (data, type, row, meta) {
                                if (row.Jahiz_Amount == null)
                                    return '';
                                else if (row.SANED_amount != row.Jahiz_Amount) {
                                    return '<span class="red_color">' + row.Jahiz_Amount + '</span>';
                                } else
                                    return row.Jahiz_Amount;


                            }
                        },
                        {
                            "searchable": false,
                            data: 'Last_Clear',
                            name: 'Last_Clear'
                        },
                        {
                            className: 'green_color',
                            data: 'lastSettlementDate',
                            name: 'drivers.lastSettlementDate'
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                            render: function (data, type, row, meta) {
                                return '<b>' + row.amount + '</b>';
                            }
                        },
                        {
                            data: 'claim_dt',
                            name: 'claim_dt',
                            "render": function (data, type, row, meta) {
                                return row.claim_dt + '<br><button onclick="claim_dt(' + row.id + ')" type="button" class="btn btn-primary btn-xs DriversClaim">+</button>';
                            }
                        },

                        {
                            data: 'bag_fee',
                            name: 'bag_fee',
                            "render": function (data, type, row, meta) {
                                return row.bag_fee + '<br><button onclick="bag_fee(' + row.id + ')" type="button" class="btn btn-primary btn-xs DriversClaim">+</button>';
                            }
                        },
                        {
                            data: 'Bander_Commission',
                            name: 'Bander_Commission',
                            "render": function (data, type, row, meta) {
                                return row.Bander_Commission + '<br><button onclick="Bander_Commission(' + row.id + ')" type="button" class="btn btn-primary btn-xs DriversClaim">+</button>';
                            }
                        },
                        {
                            "sortable": false,
                            data: 'drivers_jahiz_claim_reply',
                            name: 'drivers_jahiz_claim_reply',
                            render: function (data, type, row, meta) {
                                var all = '';
                                if (row.drivers_jahiz_claim_reply) {
                                    var str = row.drivers_jahiz_claim_reply;
                                    all += '<table  style="width:auto" class="tab-boder">';
                                    var res = str.split(";;");
                                    all += '<tr>';

                                    for (var i = 0; i < res.length; i++) {
                                        var one = res[i].split("__");
                                        if (one[3] == '') {
                                            all += '<td>' + one[0] + '</td>';
                                            all += '<td>' + one[2] + '</td>';
                                            all += '<th>' + one[1] + '</th>';
                                        } else {
                                            if (one[0] != '') {
                                                all += '<td style="background-color: #00FF80">' + one[3] + '</td>';
                                                all += '<td rowspan="2">' + one[2] + '</td>';
                                                all += '<th rowspan="2">' + one[1] + '</th>';
                                                all += '</tr><tr><td>' + one[0] + '</td>';
                                            } else {
                                                all += '<td style="background-color: #00FF80">' + one[3] + '</td>';
                                                all += '<td >' + one[2] + '</td>';
                                                all += '<th >' + one[1] + '</th>';

                                            }
                                        }

                                        all += '</tr>';
                                    }
                                    all += '</table>';


                                } else
                                    all = '';
                                return all + '<button onclick="Claim_Replay(' + row.id + ')" type="button" class="btn btn-primary btn-xs DriversClaim">اضافة رد</button>' +
                                    '&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="Claim_Status(' + row.id + ')" type="button" class="btn btn-primary btn-xs DriversClaim">اضافة حالة</button>';
                            }


                        },
                            @if(session('Delete_27')==1)
                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            "render": function (data, type, row, meta) {
                                return '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>'
                            }

                        },
                        @endif
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
                    url: "{{URL('/DriversJahizClaim')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });


            $('#filter').click(function () {
                if ($('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driver_type_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_claim_dt').val() != '' || $('#filter_lastSettlementDate').val() != '' || $('#filter_claim_status_id').val() != '' || $('#filter_Image_PromissoryNote').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driver_type_id').val(), $('#filter_driverId').val(), $('#filter_claim_dt').val(), $('#filter_lastSettlementDate').val(), $('#filter_claim_status_id').val(), $('#filter_Image_PromissoryNote').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_response').innerHTML = loader;
                document.getElementById('delete_modal').style.display = 'block';
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/DriversClaimDelete')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('delete_response').innerHTML = data;


                    }
                });

                // document.getElementById('delete_form').action = "{{URL('/DriversClaimDelete')}}" + "/" + id;
                // document.getElementById('delete_modal').style.display = 'block';
                //document.getElementById('response').innerHTML=data;


            });
            $('#reset').click(function () {
                $('#filter_warehouseId').val('');
                $('#filter_job_id').val('');
                $('#filter_driver_type_id').val('');
                $('#filter_driverId').val('');
                $('#filter_driverId_input').val('');
                $('#filter_claim_dt').val('');
                $('#filter_lastSettlementDate').val('');
                $('#filter_claim_status_id').val('');
                $('#filter_Image_PromissoryNote').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');


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
            myWindow1 = window.open("{{URL("/DriverJahizWindow")}}", "",
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

        function Claim_Replay(id) {

            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversClaimReply')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;


                }
            });
        }

        function Claim_Status(id) {

            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversClaimStatus')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;


                }
            });
        }

        function bag_fee(id) {

            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversClaimBag')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;


                }
            });
        }

        function Bander_Commission(id) {

            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversClaimCommission')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;


                }
            });
        }

        function claim_dt(id) {

            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversClaimDate')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;
                    var g = document.createElement('script');
                    var s = document.getElementsByTagName('script')[0];

                    g.text = "$('#claim_dt').datepicker({" +
                        "format: 'yyyy-mm-dd'," +
                        "autoclose: true," +
                        "autoHide: true," +
                        "zIndex: 9999," +
                        "});"
                    s.parentNode.insertBefore(g, s);


                }
            });
        }
    </script>
    <script>
        function validateForm() {


            var postData = $("#contact_form").serializeArray();
            //alert(postData);
            //return false;
            var formURL = $("#contact_form").attr("action");
            document.getElementById('response').innerHTML = loader;
            $.ajax({
                url: formURL,
                type: "POST",
                cache: false,
                data: postData,
                success: function (data) {
                    document.getElementById('response').innerHTML = data;

                    var g = document.createElement('script');
                    var s = document.getElementsByTagName('script')[0];

                    g.text = "$('#claim_dt').datepicker({" +
                        "format: 'yyyy-mm-dd'," +
                        "autoclose: true," +
                        "autoHide: true," +
                        "zIndex: 9999," +
                        "});"
                    s.parentNode.insertBefore(g, s);
                },
                error: function (jqXHR, status, error) {
                    document.getElementById('response').innerHTML = "<br><br><br>" + error + "<br><br><br>";
                    alert(status + ": " + error);
                }
            });


            return false;
        }

    </script>
    <script>
        function validateDelete() {


            var postData = $("#delete_form").serializeArray();
            //alert(postData);
            //return false;
            var formURL = $("#delete_form").attr("action");
            document.getElementById('delete_response').innerHTML = loader;
            $.ajax({
                url: formURL,
                type: "DELETE",
                cache: false,
                data: postData,
                success: function (data) {
                    document.getElementById('delete_response').innerHTML = data;


                },
                error: function (jqXHR, status, error) {
                    document.getElementById('delete_response').innerHTML = "<br><br><br>" + error + "<br><br><br>";
                    alert(status + ": " + error);
                }
            });


            return false;
        }

    </script>

@endsection




