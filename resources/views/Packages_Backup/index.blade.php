@extends('AdminLTE')
@section('content')
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">
                Packages_Backup</h2>
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
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                @foreach($warehouse as $warehousee)
                                    <option value="{{$warehousee->id}}">{{$warehousee->warehouseName}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>EMP ID</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"></td>
                    </tr>
                    <tr>
                        <TH>Driver</TH>
                        <td style="white-space: nowrap;">
                            <input name="filter_driverId" id="filter_driverId" type="hidden" value="">
                            <table style="padding: 0px 0px; !important;">
                                <tr>
                                    <td>
                                        <input class="form-control" name="filter_driverId_input"
                                               id="filter_driverId_input" style="width:180px" type="text" value=""
                                               data-readonly>
                                    </td>
                                    <td>
                                        <button onclick="driver_window();" type="button" class="btn btn-primary btn-sm">
                                            Select
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <TH>total_out_for_deliver</TH>
                        <td><input type="text" class="form-control" style="width:180px"
                                   name="filter_total_out_for_deliver" id="filter_total_out_for_deliver" value=""></td>
                        <TH>total_no_touchpoint</TH>
                        <td><input type="text" class="form-control" style="width:180px"
                                   name="filter_total_no_touchpoint" id="filter_total_no_touchpoint" value=""></td>
                    </tr>
                    <tr>
                        <TH>no_of_deliverd</TH>
                        <td><input type="text" class="form-control" name="filter_no_of_deliverd"
                                   id="filter_no_of_deliverd" value=""></td>
                        <TH>no_of_touch_point</TH>
                        <td><input type="text" class="form-control" name="filter_no_of_touch_point"
                                   id="filter_no_of_touch_point" value=""></td>
                        <TH>attendence</TH>
                        <td>
                            <select name="filter_attendence" id="filter_attendence" class="form-control">
                                <option value=""></option>
                                <option value="0">Absent</option>
                                <option value="1">Attend</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>pakage_date</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_pakage_date" id="filter_pakage_date"
                                       type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_pakage_date"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_pakage_date"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_pakage_date"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });
                                </script>
                            </div>
                        </td>
                        <TH>Complete</TH>
                        <td>
                            <select id="filter_packageStatusId" name="filter_packageStatusId" class="form-control">
                                <option value=""></option>
                                @foreach($lkp_package_status as $lkp_package_statuss)
                                    <option
                                        value="{{$lkp_package_statuss->id}}">{{$lkp_package_statuss->status}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>Approve</TH>
                        <td>
                            <select id="filter_approveStatusId" name="filter_approveStatusId" class="form-control">
                                <option value=""></option>
                                @foreach($lkp_packageapprovestatus as $lkp_packageapprovestatuss)
                                    <option
                                        value="{{$lkp_packageapprovestatuss->id}}">{{$lkp_packageapprovestatuss->approvestatus}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Created_At</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
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
                                <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
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
                        <TH>Period</TH>
                        <td>
                            <select name="filter_period_id" id="filter_period_id"
                                    class="form-control" style="width:200px;" required>
                                <option value=""></option>
                                @foreach($lkp_journal_period as $lkp_journal_periodd)
                                    <option
                                        value="{{$lkp_journal_periodd->id}}"> {{$lkp_journal_periodd->period_from_dt}}
                                        - {{$lkp_journal_periodd->period_to_dt}}</option>
                                @endforeach
                            </select>
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
    <?php //echo Hash::make('password');?>
    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped">
            <thead>
            <TH>Period</TH>
            <TH>Whouse</TH>
            <TH>Driver</TH>
            <TH>EMP ID</TH>
            <TH>Date</TH>
            <TH>total OFD</TH>
            <TH>total No TP</TH>
            <TH>No of D</TH>
            <TH>No of TP</TH>
            <TH>Attend</TH>
            <TH>Excel Total OFD</TH>
            <TH>Excel No of D</TH>
            <TH>Excel No of TP</TH>
            <TH>Complete</TH>
            <TH>Approve</TH>
            <TH>Update UserType</TH>
            <TH>Update By</TH>
            </thead>
            <tbody></tbody>
            <tfoot>
            <tr>
                <TH colspan='5'>Total</TH>
                <TH></TH>
                <TH></TH>
                <TH></TH>
                <TH></TH>
                <TH></TH>
                <TH></TH>
                <TH></TH>
                <TH colspan='5'></TH>
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

            function fill_datatable(filter_companyId = '', filter_period_id = '', filter_warehouseId = '', filter_job_id = '', filter_driverId = '', filter_total_out_for_deliver = '', filter_total_no_touchpoint = '', filter_no_of_deliverd = '', filter_no_of_touch_point = '', filter_attendence = '', filter_pakage_date = '', filter_packageStatusId = '', filter_approveStatusId = '', filter_created_at = '', filter_updated_at = '') {
                var dataTable = $('#customer_data').DataTable({
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
                    serverSide: true,
                    "order": [[4, "desc"]],
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function (settings) {
                        $('[data-toggle="tooltip"]').tooltip();
                        var api = this.api()
                        var json = api.ajax.json();
                        $(api.column(5).footer()).html(json.total_out_for_deliver);
                        $(api.column(6).footer()).html(json.total_no_touchpoint);
                        $(api.column(7).footer()).html(json.no_of_deliverd);
                        $(api.column(8).footer()).html(json.no_of_touch_point);
                        $(api.column(9).footer()).html(json.attendence);
                        $(api.column(10).footer()).html(json.Total_OFD);
                        $(api.column(11).footer()).html(json.No_of_D);
                        $(api.column(12).footer()).html(json.No_of_TP);
                    },
                    ajax: {
                        url: "{{ route('Packages_Backup.index') }}",
                        data: {
                            filter_companyId: filter_companyId,
                            filter_warehouseId: filter_warehouseId,
                            filter_job_id: filter_job_id,
                            filter_driverId: filter_driverId,
                            filter_total_out_for_deliver: filter_total_out_for_deliver,
                            filter_total_no_touchpoint: filter_total_no_touchpoint,
                            filter_no_of_deliverd: filter_no_of_deliverd,
                            filter_no_of_touch_point: filter_no_of_touch_point,
                            filter_attendence: filter_attendence,
                            filter_pakage_date: filter_pakage_date,
                            filter_packageStatusId: filter_packageStatusId,
                            filter_approveStatusId: filter_approveStatusId,
                            filter_created_at: filter_created_at,
                            filter_updated_at: filter_updated_at,
                            filter_period_id, filter_period_id,
                        }
                    },
                    columns: [
                        {
                            data: 'period',
                            name: 'lkp_journal_period.period_from_dt',
                            //visible:false
                        },
                        {
                            data: 'warehouseName',
                            name: 'warehouse.warehouseName',
                            //visible:false
                        },
                        {
                            data: 'fullName',
                            name: 'drivers.fullName',
                            render: function (data, type, row, meta) {
                                return '<a href="javascript:driver(' + row.driverId + ')">' + data + '</a>';
                            }
                        },
                        {
                            data: 'job_id',
                            name: 'drivers.job_id'
                        },
                        {
                            data: 'pakage_date',
                            name: 'pakage_date'
                        },
                        {
                            data: 'total_out_for_deliver',
                            name: 'total_out_for_deliver'
                        },
                        {
                            data: 'total_no_touchpoint',
                            name: 'total_no_touchpoint'
                        },
                        {
                            data: 'no_of_deliverd',
                            name: 'no_of_deliverd'
                        },
                        {
                            data: 'no_of_touch_point',
                            name: 'no_of_touch_point'
                        },
                        {
                            data: 'attendence',
                            render: function (data, type, row, meta) {
                                if (data == "1") {
                                    return '<span class="label label-success">Attend</span>';
                                } else if (data == "0") {
                                    return '<span class="label label-danger">Absent</span>';
                                }
                            }
                        },
                        {
                            data: 'Total_OFD',
                            name: 'Total_OFD',
                            className: "table-cell-load"
                        },
                        {
                            data: 'No_of_D',
                            name: 'No_of_D',
                            className: "table-cell-load"
                        },
                        {
                            data: 'No_of_TP',
                            name: 'No_of_TP',
                            className: "table-cell-load"
                        },
                        {
                            data: 'status',
                            name: 'lkp_package_status.status',
                            render: function (data, type, row, meta) {
                                if (row.packageStatusId == "1") {
                                    return '<span class="label label-warning">' + row.status + '</span>';
                                } else if (row.packageStatusId == "2") {
                                    return '<span class="label label-success">' + row.status + '</span>';
                                } else if (row.packageStatusId == "3") {
                                    return '<span class="label label-danger">' + row.status + '</span>';
                                } else if (row.packageStatusId == "4") {
                                    return '<span class="label label-primary">' + row.status + '</span>';
                                } else if (row.packageStatusId == "5") {
                                    return '<span class="label label-default">' + row.status + '</span>';
                                } else if (row.packageStatusId == "6") {
                                    return '<span class="label label-info">' + row.status + '</span>';
                                } else if (row.packageStatusId == "7") {
                                    return '<span class="badge">' + row.status + '</span>';
                                }
                            }
                        },
                        {
                            data: 'approvestatus',
                            name: 'lkp_packageapprovestatus.approvestatus',
                            render: function (data, type, row, meta) {
                                if (row.approveStatusId == "1") {
                                    return '<span class="label label-warning">' + row.approvestatus + '</span>';
                                } else if (row.approveStatusId == "2") {
                                    return '<span class="label label-success">' + row.approvestatus + '</span>';
                                }
                            }
                        },
                        {
                            data: 'user_type',
                            name: 'lkp_updated_usertype.user_type'
                        },
                        {
                            data: 'name',
                            name: 'users.name',
                            render: function (data, type, row, meta) {
                                if (row.updated_usertypeid == "4") {
                                    return '';
                                } else {
                                    return row.name;
                                }
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
                    url: "{{URL('/Packages_Backup')}}" + "/" + id,
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
                    url: "{{URL('/Packages_Backup')}}" + "/" + id + "/edit",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        $('#response').html(data);
                        var g = document.createElement('script');
                        var s = document.getElementsByTagName('script')[0];
//g.text = "alert(\"hi\");"
                        g.text = "$('#pakage_date').datepicker({" +
                            "format: 'dd/mm/yyyy'," +
                            "autoclose: true," +
                            "autoHide: true," +
                            "zIndex: 9999," +
                            "});"
                        s.parentNode.insertBefore(g, s);
                    }
                });
            });
            $('#customer_data tbody').on('click', '.privilage', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                alert(id);
            });
            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/Packages_Backup')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';
                //document.getElementById('response').innerHTML=data;
            });
            $('#filter').click(function () {
                if ($('#filter_companyId').val() != '' || $('#filter_period_id').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_total_out_for_deliver').val() != '' || $('#filter_total_no_touchpoint').val() != '' || $('#filter_no_of_deliverd').val() != '' || $('#filter_no_of_touch_point').val() != '' || $('#filter_attendence').val() != '' || $('#filter_pakage_date').val() != '' || $('#filter_packageStatusId').val() != '' || $('#filter_approveStatusId').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_companyId').val(), $('#filter_period_id').val(), $('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driverId').val(), $('#filter_total_out_for_deliver').val(), $('#filter_total_no_touchpoint').val(), $('#filter_no_of_deliverd').val(), $('#filter_no_of_touch_point').val(), $('#filter_attendence').val(), $('#filter_pakage_date').val(), $('#filter_packageStatusId').val(), $('#filter_approveStatusId').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
                } else {
                    alert('Select filter option');
                }
            });
            $('#reset').click(function () {
                $('#filter_companyId').val('');
                $('#filter_period_id').val('');
                $('#filter_warehouseId').val('');
                $('#filter_job_id').val('');
                $('#filter_driverId').val('');
                $('#filter_driverId_input').val('');
                $('#filter_total_out_for_deliver').val('');
                $('#filter_total_no_touchpoint').val('');
                $('#filter_no_of_deliverd').val('');
                $('#filter_no_of_touch_point').val('');
                $('#filter_attendence').val('');
                $('#filter_pakage_date').val('');
                $('#filter_packageStatusId').val('');
                $('#filter_approveStatusId').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');
                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });
        });

        function add() {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/Packages_Backup/create")}}",
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                    var g = document.createElement('script');
                    var s = document.getElementsByTagName('script')[0];
//g.text = "alert(\"hi\");"
                    g.text = "$('#pakage_date').datepicker({" +
                        "format: 'dd/mm/yyyy'," +
                        "autoclose: true," +
                        "autoHide: true," +
                        "zIndex: 9999," +
                        "});"
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
            $('#filter_vehichleId').val('');
            $('#filter_vehichleId_input').val('');
            myWindow1 = window.open("{{URL("/DriverWindow")}}", "",
                "height=650,width=900,scrollbars=yes,top=1,left=1,status,resizable");
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
@endsection
