@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">
                Warehouses</h2></div>
        <div style="float:right;">
            <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New
                    Warehouses</a></h2>
        </div>
    </div>
    <div class="card card-default" style="width:100%;clear:both;"></div>
    <style>
        .loader {
            position: relative;
            text-align: center;
            margin: 15px auto 35px auto;
            z-index: 9999;
            display: block;
            width: 80px;
            height: 80px;
            border: 10px solid rgba(0, 0, 0, .3);
            border-radius: 50%;
            border-top-color: #000;
            animation: spin 1s ease-in-out infinite;
            -webkit-animation: spin 1s ease-in-out infinite;
        }

    </style>
    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->
    <!-- SELECT2 EXAMPLE -->
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary ">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <button class="button_search"><i class="fa fa-search"></i></button>
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
                            <select name="filter_companyId" id="filter_companyId" onchange="CityName()"
                                    class="form-control" required>

                                @foreach($lkp_company as $lkpcompany)
                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>Under Noon</TH>
                        <td>
                            <select name="filter_under_noon_id" id="filter_under_noon_id"
                                    class="form-control" style="width: 200px">
                                <option value=""></option>
                                @foreach($lkp_yes_no as $lkp_yes_noo)
                                    <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>CityName</TH>
                        <td>
                            <select onchange="Warehouse()" name="filter_cityId" id="filter_cityId"
                                    class="form-control">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Warehouse</TH>
                        <td>
                            <select name="filter_warehouseId" id="filter_warehouseId" class="form-control">
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <TH>PacKages Date</TH>
                        <td>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" style="width:200px" class="form-control pull-right"
                                       name="pakage_date" id="pakage_date" placeholder="dd/mm/yyyy"
                                       value="<?php echo date('d/m/Y');?>" required>
                            </div>

                        </td>
                    </tr>

                </table>

                <div class="card-footer" align="center">
                    <button type="button" name="filter" class="btn btn-sm btn-info" id="filter">Dialy Load</button>


                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <?php //echo date("Y-m-d H:i:s"); ?>

    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped">
            <thead>
            <tr>
                <TH>Warehouse</TH>
                <TH>Company</TH>
                <TH>City</TH>
                <TH>T PK</TH>
                <TH>N PK</TH>
                <TH>T TP</TH>
                <TH>N TP</TH>
                <TH>T DA</TH>
                <TH>A DA</TH>
                <TH>A..DA</TH>
                <TH>Created_at</TH>
                <TH>Min</TH>
                <TH>Max</TH>
                <TH>Avg</TH>
                <TH>Med</TH>
                <TH>Action</TH>
            </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
            <tr>
                <TH colspan='3'>Total</TH>
                <td id='totaldriver'></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <TH></TH>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <TH></TH>
            </tr>
            </tfoot>

        </table>
    </div>

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

            function fill_datatable(pakage_date = '', filter_companyId = '', filter_cityId = '', filter_warehouseId = '', filter_under_noon_id = '') {
                var dataTable = $('#customer_data').DataTable({
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "order": [[3, "desc"]],
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "drawCallback": function (settings) {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    "fnDrawCallback": function () {
                        var api = this.api()
                        var json = api.ajax.json();
                        $(api.column(3).footer()).html(json.total_out_for_deliver);
                        $(api.column(4).footer()).html(json.no_of_deliverd);
                        $(api.column(5).footer()).html(json.total_no_touchpoint);
                        $(api.column(6).footer()).html(json.no_of_touch_point);
                        $(api.column(7).footer()).html(json.total_drivers);
                        $(api.column(8).footer()).html(json.attendence);
                        $(api.column(9).footer()).html(json.attendwithnowork);
                        $(api.column(11).footer()).html(json.min_load);
                        $(api.column(12).footer()).html(json.max_load);
                        $(api.column(13).footer()).html(json.avg_load);
                        $(api.column(14).footer()).html(json.median_val);
                    },

                    ajax: {
                        url: "{{ route('Warehouses.index') }}",
                        data: {
                            pakage_date: pakage_date,
                            filter_companyId: filter_companyId,
                            filter_cityId: filter_cityId,
                            filter_warehouseId: filter_warehouseId,
                            filter_under_noon_id: filter_under_noon_id,
                        }
                    },

                    columns: [
                        {
                            data: 'warehouseName',
                            name: 'warehouseName',
                            //visible:false
                        },
                        {
                            data: 'companyName',
                            name: 'lkp_company.companyName'
                        },
                        {
                            data: 'name_en',
                            name: 'lkp_city.name_en'
                        },
                        {
                            data: 'total_out_for_deliver',
                            name: 'packages.total_out_for_deliver',
                            className: "table-cell-package"
                        },
                        {
                            data: 'no_of_deliverd',
                            name: 'packages.no_of_deliverd',
                            className: "table-cell-package"
                        },
                        {
                            data: 'total_no_touchpoint',
                            name: 'packages.total_no_touchpoint',
                            className: "table-cell-touchpoint"
                        },
                        {
                            data: 'no_of_touch_point',
                            name: 'packages.no_of_touch_point',
                            className: "table-cell-touchpoint"
                        },
                        {
                            data: 'total_drivers',
                            name: 'total.total_drivers',
                            className: "table-cell-total_drivers"
                        },
                        {
                            data: 'attendence',
                            name: 'packages.attendence',
                            className: "table-cell-total_drivers"
                        },
                        {
                            data: 'attendwithnowork',
                            name: 'packages.attendwithnowork',
                            className: "table-cell-total_drivers"
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'min_load',
                            name: 'packages.min_load',
                            className: "table-cell-load"
                        },
                        {
                            data: 'max_load',
                            name: 'packages.max_load',
                            className: "table-cell-load"
                        },
                        {
                            data: 'avg_load',
                            name: 'packages.avg_load',
                            className: "table-cell-load"
                        },
                        {
                            data: 'median_val',
                            name: 'median_load.median_val',
                            className: "table-cell-load"
                        },
                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            data: 'id',
                            "render": function (data, type, row, meta) {
                                var a = '<input id="name_' + row.id + '" type="hidden" value="' + row.warehouseName + '">' +
                                    '<a id=' + row.id + ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>' +
                                    '&nbsp;<button id=' + row.id + ' type="button" class="btn btn-primary btn-xs driver">Drivers</button>';
                                if (row.latitude && row.longitude)
                                    a += '<a href="javascript:map(' + row.id + ');"><img src="{{asset("/AdminLTE/img/map.png")}}" width="30px" height="30px" alt="" border="0"></a>';
                                return a;

                            }
                            //onclick=\"document.getElementById('row_id').value='"+data+"'\"
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
                    url: "{{URL('/Warehouses')}}" + "/" + id,
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
                    url: "{{URL('/Warehouses')}}" + "/" + id + "/edit",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.driver', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/WarehouseDrivers')}}" + "/" + id + "/" + document.getElementById('name_' + id).value + "?dt=" + document.getElementById('pakage_date').value,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;
                        var g = document.createElement('script');
                        var s = document.getElementsByTagName('script')[0];
//g.text = "alert(\"hi\");"
                        g.text = "$(function () {" +
                            "$('input[type=\"checkbox\"].flat-red, input[type=\"radio\"].flat-red').iCheck({" +
                            "checkboxClass: 'icheckbox_flat-green'," +
                            " radioClass   : 'iradio_flat-green'" +
                            "});" +
                            "$('input[type=\"checkbox\"].complete-checkbox, input[type=\"radio\"].complete-checkbox').iCheck({" +
                            "checkboxClass: 'icheckbox_flat-blue'," +
                            " radioClass   : 'iradio_flat-blue'" +
                            "});" +
                            "$('input[type=\"checkbox\"].approve-checkbox, input[type=\"radio\"].approve-checkbox').iCheck({" +
                            "checkboxClass: 'icheckbox_flat-red'," +
                            " radioClass   : 'iradio_flat-red'" +
                            "});" +
                            "$('#select-all').on('ifChecked ifUnchecked', function (event) {" +
                            "selectall();" +
                            "});" +
                            "$('#approve-all').on('ifChecked ifUnchecked', function (event) {" +
                            "approveall();" +
                            "});" +
                            "$('.flat-red').on('ifChecked ifUnchecked', function (event) {" +
                            "var str = $(this).attr('name');" +
                            "complete(str);" +
                            "});" +
                            "$('.complete-checkbox').on('ifChecked ifUnchecked', function (event) {" +
                            "var str = $(this).attr('name');" +
                            "approve(str);" +
                            "});" +
                            "});";

                        s.parentNode.insertBefore(g, s);

                    }
                });

            });

            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/Warehouses')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';


            });

            $('#filter').click(function () {
                if ($('#pakage_date').val() != '' & $('#filter_companyId').val() != '') {
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#pakage_date').val(), $('#filter_companyId').val(), $('#filter_cityId').val(), $('#filter_warehouseId').val(), $('#filter_under_noon_id').val());
                } else {
                    alert('Select Company and pakage_date');
                }
            });


        });

        function add() {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';

            $.ajax({
                type: 'GET',
                url: "{{URL("/Warehouses/create")}}",
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }

        $(function () {
            $('#pakage_date').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                autoHide: true,
                zIndex: 9999,
            });
        });

        function selectall() {
            $('.flat-red').each(function () {
                var str = $(this).attr('name');
                str = str.substring(11, str.length);
                //alert(str);
                $('#packageStatusId_' + str).prop("disabled", true).iCheck('update');
                if (document.getElementById('select-all').checked) {
                    if (document.getElementById('attendence_' + str).checked) {
                        $('#packageStatusId_' + str).prop("disabled", false).iCheck('update');
                        $('#packageStatusId_' + str).iCheck('check')

                    }
                } else {
                    $('#packageStatusId_' + str).iCheck('uncheck');
                    if (document.getElementById('attendence_' + str).checked)
                        $('#packageStatusId_' + str).prop("disabled", false).iCheck('update');
                }
            });

        }

        function approveall() {
            $('.complete-checkbox').each(function () {
                var str = $(this).attr('name');
                //str=str.substring(1, str.length);
                if (str != 'select-all') {
                    str = str.substring(16, str.length);
                    //alert(str);
                    $('#approveStatusId_' + str).prop("disabled", true).iCheck('update');
                    if (document.getElementById('approve-all').checked) {
                        if (document.getElementById('packageStatusId_' + str).checked) {
                            $('#approveStatusId_' + str).prop("disabled", false).iCheck('update');
                            $('#approveStatusId_' + str).iCheck('check')

                        }
                    } else {
                        $('#approveStatusId_' + str).iCheck('uncheck');
                        if (document.getElementById('packageStatusId_' + str).checked)
                            $('#approveStatusId_' + str).prop("disabled", false).iCheck('update');
                    }
                }
            });

        }

        function complete(str) {
            str = str.substring(11, str.length);
            $('#packageStatusId_' + str).iCheck('uncheck');
            if (document.getElementById('attendence_' + str).checked)
                $('#packageStatusId_' + str).prop("disabled", false).iCheck('update');
            else
                $('#packageStatusId_' + str).prop("disabled", true).iCheck('update');

        }

        function approve(str) {
            str = str.substring(16, str.length);

            $('#approveStatusId_' + str).iCheck('uncheck');
            if (document.getElementById('packageStatusId_' + str).checked)
                $('#approveStatusId_' + str).prop("disabled", false).iCheck('update');
            else
                $('#approveStatusId_' + str).prop("disabled", true).iCheck('update');

        }

        function CityName() {
            var filter_companyId = document.getElementById('filter_companyId').value;
            if (filter_companyId == "") {
                $('#filter_cityId').empty();
                $('#filter_warehouseId').empty();
            } else {
                $.getJSON("{{URL("/getCityName")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_cityId').empty();
                    $('#filter_warehouseId').empty();
                    $('#filter_cityId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_cityId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
        }

        function Warehouse() {
            var filter_cityId = document.getElementById('filter_cityId').value;
            if (filter_cityId == "")
                $('#filter_warehouseId').empty();
            else {
                $.getJSON("{{URL("/getWarehouse")}}" + "/" + filter_cityId, function (json) {
                    $('#filter_warehouseId').empty();
                    $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
        }

        CityName();

        function map(id) {
            myWindow1 = window.open("{{URL("MapWindow")}}" + "/" + id, "",
                "height=700,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
        }
    </script>
@endsection




