@extends('layout2')
@section('content')



    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Drivers</h2>
        </div>
        @if(Auth::user()->user_type_id==1||session('Session_DriversCarrefour')=='yes')
            <div style="float:right;">
                <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New
                        Driver</a>
                </h2>
            </div>
        @endif
    </div>
    <div class="card card-default" style="width:100%;clear:both;"></div>
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
                            </select>
                        </td>
                        <TH>fullName</TH>
                        <td><input type="text" class="form-control" style="width:180px;" id="filter_fullName"
                                   name="filter_fullName"></td>
                    </tr>
                    <tr> 
                        <TH>Mobile</TH>
                        <td><input type="text" class="form-control" name="filter_mobileNumber" id="filter_mobileNumber">
                        </td>
                        <TH>Iqama</TH>
                        <td><input type="text" class="form-control" name="filter_iqama" id="filter_iqama"></td>

                        <TH>Email ID</TH>
                        <td><input type="text" class="form-control" name="filter_email_id" id="filter_email_id"></td>

                    </tr>

                    <tr>
                        <TH>Job ID</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"></td>

                        <TH>Status</TH>
                        <td>
                            <select name="filter_status_id" id="filter_status_id" onchange="status()"
                                    class="form-control">
                                <option value=""></option>

                                @foreach($lkp_driver_status as $lkp_driver_statuss)
                                    <option
                                        value="{{$lkp_driver_statuss->id}}">{{$lkp_driver_statuss->driver_status_en}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>Account_Owner_Iqama</TH>
                        <td><input type="text" class="form-control" name="filter_account_owner_iqama"
                                   id="filter_account_owner_iqama">
                        </td>

                    </tr>


                    <tr>

                        <TH>accountNumber</TH>
                        <td><input type="text" class="form-control" name="filter_accountNumber"
                                   id="filter_accountNumber"></td>
                        <TH>Driver Type</TH>
                        <td>
                            <select name="filter_driver_type_id" id="filter_driver_type_id" class="form-control">
                                <option value=""></option>
                                @foreach($lkp_driver_type as $lkp_driver_typee)
                                    <option
                                        value="{{$lkp_driver_typee->id}}">{{$lkp_driver_typee->driver_type}}</option>
                                @endforeach
                            </select>
                        </td>

                        <TH>Bander Car</TH>
                        <td>
                            <select name="filter_bander_car_id" id="filter_bander_car_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Image Identity</TH>
                        <td>
                            <select name="filter_Image_Identity" id="filter_Image_Identity" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Image Passport</TH>
                        <td>
                            <select name="filter_Image_Passport" id="filter_Image_Passport" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Image DrivingLicence</TH>
                        <td>
                            <select name="filter_Image_DrivingLicence" id="filter_Image_DrivingLicence"
                                    class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <TH>Image VehiclesRegistration</TH>
                        <td>
                            <select name="filter_Image_VehiclesRegistration" id="filter_Image_VehiclesRegistration"
                                    class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Image JobContract</TH>
                        <td>
                            <select name="filter_Image_JobContract" id="filter_Image_JobContract" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
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
    @if(Auth::user()->user_type_id==1)
        <table style="width:100%">
            <tr>
                <td align=right>
                    <input class="flat-red" type="checkbox" name="select-all" id="select-all"/>&nbsp;&nbsp;Select All
                </td>
            </tr>
        </table>
    @endif
    <form method="POST" action="{{ URL('/DriversPost')}}">
        @csrf

        <div class="table-responsive" style="width: 100%;">

            <table id="customer_data" class="table table-bordered table-striped table-responsive">
                <thead>
                <TH>Company</TH>
                <TH style="display:none;">City</TH>
                <TH>Warehouse</TH>
                <TH>Type</TH>
                <TH>FullName</TH>
                <TH>Mobile</TH>
                <TH>Iqama</TH>

                <TH>Job ID</TH>
                <TH>Status</TH>
                @if(Auth::user()->user_type_id==1)
                    <TH>On Hold</TH>
                    <TH>Bander Car</TH>
                    <TH>P Balance</TH>
                    <TH>C Balance</TH>
                    <TH>Update at</TH>
                @endif
                <TH>Action</TH>


                <TH style="display:none;">AccountNumber</TH>
                <TH style="display:none;">Account_Owner_Iqama</TH>


                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        @if(Auth::user()->user_type_id==1)
            <center>
                <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">On Hold</button>
            </center>
        @endif
    </form>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:850px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('edit_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>

            <div style="width:100%;clear:both;" id="response">

            </div>
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

            function fill_datatable(filter_screenId = '', filter_companyId = '', filter_warehouseId = '', filter_driver_type_id = '', filter_fullName = '', filter_mobileNumber = '', filter_iqama = '', filter_email_id = '', filter_job_id = '', filter_status_id = '', filter_account_owner_iqama = '', filter_accountNumber = '', filter_created_at = '', filter_updated_at = '', filter_bander_car_id = '', filter_Image_Identity = '', filter_Image_Passport = '', filter_Image_DrivingLicence = '', filter_Image_VehiclesRegistration = '', filter_Image_JobContract = '', filter_Image_PromissoryNote = '') {
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
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function () {
                        $('[data-toggle="tooltip"]').tooltip();
                        $(function () {
                            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                                checkboxClass: 'icheckbox_flat-red',
                                radioClass: 'iradio_flat-red'
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
                        url: "{{ route('Drivers.index') }}",
                        data: {
                            filter_screenId: 'Driver',
                            filter_companyId: filter_companyId,
                            filter_warehouseId: filter_warehouseId,
                            filter_fullName: filter_fullName,
                            filter_mobileNumber: filter_mobileNumber,
                            filter_iqama: filter_iqama,
                            filter_email_id: filter_email_id,
                            filter_job_id: filter_job_id,
                            filter_status_id: filter_status_id,
                            filter_account_owner_iqama: filter_account_owner_iqama,
                            filter_accountNumber: filter_accountNumber,
                            filter_driver_type_id, filter_driver_type_id,
                            filter_created_at: filter_created_at,
                            filter_updated_at: filter_updated_at,
                            filter_bander_car_id: filter_bander_car_id,
                            filter_Image_Identity: filter_Image_Identity,
                            filter_Image_Passport: filter_Image_Passport,
                            filter_Image_DrivingLicence: filter_Image_DrivingLicence,
                            filter_Image_VehiclesRegistration: filter_Image_VehiclesRegistration,
                            filter_Image_JobContract: filter_Image_JobContract,
                            filter_Image_PromissoryNote: filter_Image_PromissoryNote,
                        }
                    },

                    columns: [
                        {
                            data: 'companyName',
                            name: 'lkp_company.companyName',
                            //visible:false
                        },
                        {
                            visible: false,
                            data: 'name_en',
                            name: 'lkp_city.name_en',
                        },
                        {
                            data: 'warehouseName',
                            name: 'warehouse.warehouseName',
                            //visible:false
                        },
                        {
                            data: 'driver_type',
                            name: 'lkp_driver_type.driver_type',
                        },
                        {
                            //className: "dt-nowrap",
                            data: 'fullName',
                            name: 'fullName'
                        },

                        {
                            data: 'mobileNumber',
                            name: 'mobileNumber'
                        },
                        {
                            data: 'iqama',
                            name: 'iqama'
                        },

                        {
                            data: 'job_id',
                            name: 'job_id'
                        },
                        {
                            //data: 'driver_status_en',
                            name: 'lkp_driver_status.driver_status_en',
                            render: function (data, type, row, meta) {
                                if (row.status_id == "1") {
                                    return '<span class="label label-success">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "2") {
                                    return '<span class="label label-warning">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "3") {
                                    return '<span class="label label-danger">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "4") {
                                    return '<span class="label label-default">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "5") {
                                    return '<span class="label label-danger">' + row.driver_status_en + '</span>';
                                }
                            }
                        },
                            @if(Auth::user()->user_type_id==1)
                        {
                            "orderable": false,
                            "className": "text-center",
                            "render": function (data, type, row, meta) {
                                var i = '';
                                i = '<input class="flat-red" name="ID_' + meta.row + '" type="checkbox" value="' + row.id + '"';
                                if (row.status_id == "5")
                                    i = i + ' checked ';
                                i = i + '>';
                                if (row.status_id == "5")
                                    i = i + '&nbsp;' + row.onhold_date;
                                return i;


                            }
                        },
                        {
                            //data: 'driver_status_en',
                            name: 'bander_car.yes_no',
                            render: function (data, type, row, meta) {
                                if (row.bander_car == "Yes") {
                                    return '<span class="label label-success">' + row.bander_car + '</span>';

                                } else if (row.bander_car == "No") {
                                    return '<span class="label label-danger">' + row.bander_car + '</span>';
                                }
                                else return '';
                            }
                        },
                        {
                            data: 'per_priod',
                            name: 'balance.per_priod'
                        },
                        {
                            data: 'cur_priod',
                            name: 'balance.cur_priod'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                            @endif
                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            //"data": 'id',
                            "render": function (data, type, row, meta) {
                                return '<input type="hidden" id="IDs_all_' + meta.row + '" name="IDs_all_' + meta.row + '" value="' + row.id + '">' +
                                    '<a id=' + row.id + ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>' +
                                    @if(Auth::user()->user_type_id==1)
                                        '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>' +
                                    @endif
                                        '&nbsp;<a id=' + row.id + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement"> <i class="fa fa-bars"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="Attachment" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue Attachment"> <i class="fa fa-paperclip"></i> </a>' +
                                    @if(Auth::user()->user_type_id==1)
                                        '&nbsp;<a id=' + row.id + ' data-original-title="Clearance" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-black vd_black Clearance"> C </a>' +
                                    @endif
                                        '&nbsp;<button id=' + row.id + ' type="button" class="btn btn-primary btn-xs resetpass">Reset Pass</button>'


                            }
//onclick=\"document.getElementById('row_id').value='"+data+"'\"
                        },


                        {
                            visible: false,
                            data: 'accountNumber',
                            name: 'accountNumber',
                        },
                        {
                            visible: false,
                            data: 'account_owner_iqama',
                            name: 'account_owner_iqama',
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
                    url: "{{URL('/Drivers')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.edit', function (e) {
                //e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/Drivers')}}" + "/" + id + "/edit/1",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.privilage', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                alert(id);
            });

            $('#customer_data tbody').on('click', '.resetpass', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/ResetPass')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;


                    }
                });

            });

            $('#customer_data tbody').on('click', '.statement', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/statement')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;


                    }
                });

            });

            $('#customer_data tbody').on('click', '.Attachment', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                myWindow1 = window.open("{{URL("Attachment")}}" + "/" + id, "mywin",
                    "height=900,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
                myWindow1.focus();

            });

            $('#customer_data tbody').on('click', '.Clearance', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                myWindow1 = window.open("{{URL("ClearancePrint")}}" + "/" + id + "/0", "mywin",
                    "height=900,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
                myWindow1.focus();
            });

            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/Drivers')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';
                //document.getElementById('response').innerHTML=data;


            });

            $('#filter').click(function () {

                if ($('#filter_companyId').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_driver_type_id').val() != '' || $('#filter_fullName').val() != '' || $('#filter_mobileNumber').val() != '' || $('#filter_iqama').val() != '' || $('#filter_email_id').val() != '' || $('#filter_job_id').val() != '' || $('#filter_status_id').val() != '' || $('#filter_account_owner_iqama').val() != '' || $('#filter_accountNumber').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '' || $('#filter_bander_car_id').val() != ''|| $('#filter_Image_Identity').val() != '' || $('#filter_Image_Passport').val() != '' || $('#filter_Image_DrivingLicence').val() != '' || $('#filter_Image_VehiclesRegistration').val() != '' || $('#filter_Image_JobContract').val() != '' || $('#filter_Image_PromissoryNote').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable('Drivers', $('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_driver_type_id').val(), $('#filter_fullName').val(), $('#filter_mobileNumber').val(), $('#filter_iqama').val(), $('#filter_email_id').val(), $('#filter_job_id').val(), $('#filter_status_id').val(), $('#filter_account_owner_iqama').val(), $('#filter_accountNumber').val(), $('#filter_created_at').val(), $('#filter_updated_at').val(), $('#filter_bander_car_id').val(), $('#filter_Image_Identity').val(), $('#filter_Image_Passport').val(), $('#filter_Image_DrivingLicence').val(), $('#filter_Image_VehiclesRegistration').val(), $('#filter_Image_JobContract').val(), $('#filter_Image_PromissoryNote').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {
                $('#filter_companyId').val('');
                $('#filter_warehouseId').val('');
                $('#filter_fullName').val('');
                $('#filter_mobileNumber').val('');
                $('#filter_iqama').val('');
                $('#filter_email_id').val('');
                $('#filter_job_id').val('');
                $('#filter_status_id').val('');
                $('#filter_account_owner_iqama').val('');
                $('#filter_accountNumber').val('');
                $('#filter_driver_type_id').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');
                $('#filter_bander_car_id').val('');
                $('#filter_Image_Identity').val('');
                $('#filter_Image_Passport').val('');
                $('#filter_Image_DrivingLicence').val('');
                $('#filter_Image_VehiclesRegistration').val('');
                $('#filter_Image_JobContract').val('');
                $('#filter_Image_PromissoryNote').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });


        function add() {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/Drivers/create/1")}}",
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;
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

        function WarehouseName() {

            var filter_companyId = document.getElementById('filter_companyId').value;

            $('#filter_warehouseId').empty();

            $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
                $('#filter_warehouseId').empty();
                $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                $.each(json, function (i, obj) {
                    $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                });
            });

        }

        function sheet(id, Period) {
            myWindow1 = window.open("{{URL('/SalaryShow')}}" + "/" + id + "/" + Period, "",
                "height=1000,width=650,scrollbars=yes,top=1,left=1,status,resizable");
        }

    </script>
    <script>
        function validateForm() {

            if ($("#accountNumber").val() != '' && ($("#accountNumber").val().length != 12 || $("#accountNumber").val().substring(0, 3) != '966')) {
                alert('خطا في رقم الحساب : يجب ان يبدا ب 966 ويحتوي علي 12 رقم');
                return false;
            }
            if ($("#account_owner_iqama").val() != '' && ($("#account_owner_iqama").val().length != 10 || ($("#account_owner_iqama").val().substring(0,1) != '1' && $("#account_owner_iqama").val().substring(0,1) != '2'))) {
                alert('خطا في هوية صاحب الحساب : يجب ان يبدا ب 1 او 2 ويحتوي علي 10 ارقام');
                return false;
            }
            //e.preventDefault();
            //document.getElementById('response').innerHTML = loader;
            //document.getElementById('edit_modal').style.display = 'block';

            var postData = $("#contact_form").serializeArray();
            //alert(postData);
            var formURL = $("#contact_form").attr("action");
            document.getElementById('response').innerHTML = loader;
            $.ajax({
                url: formURL,
                type: "PUT",
                cache: false,
                data: postData,
                success: function (data) {
                    document.getElementById('response').innerHTML = data;


                },
                error: function (jqXHR, status, error) {
                    document.getElementById('response').innerHTML = "<br><br><br>" + error + "<br><br><br>";
                    alert(status + ": " + error);
                }
            });


            return false;
        }

    </script>


@section('javascript') 
    <!-- Data Tables -->
    <script src="{{asset('assets/vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>

    <!-- Custom Data tables -->
    <script src="{{asset('assets/vendor/datatables/custom/custom-datatables.js')}}"></script>

    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script> 
    
@stop
@endsection




