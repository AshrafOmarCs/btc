<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{asset("/AdminLTE/css/bootstrap.min.css")}}">

<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset("/AdminLTE/font-awesome/font-awesome.min.css")}}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{asset("/AdminLTE/css/ionicons.min.css")}}">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset("/AdminLTE/plugins/iCheck/all.css")}}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{asset("/AdminLTE/bootstrap-daterangepicker/daterangepicker.css")}}">
<!-- Theme style -->

<link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
<!-- AdminLTE Skins. Choose a skin from the css/skins
folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{asset("/AdminLTE/css/_all-skins.min.css")}}">
<link rel="stylesheet" href="{{asset("/AdminLTE/css/dataTables.bootstrap.min.css")}}">
<!--<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
<link rel="stylesheet" href="{{asset("/AdminLTE/css/customize.css")}}">


<body style="margin:10PX;padding:0">
<!-- Content Header (Page header) -->
<div style="width:100%;margin: 0px; ">
    <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Drivers</h2>
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
            <table id="search_table" class="table m-0 search_table" style="width:10px!important;">
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
                    <TH>fullName_ar</TH>
                    <td><input type="text" class="form-control" style="width:180px;" name="filter_fullName_ar"
                               id="filter_fullName_ar"></td>
                    <TH>Mobile</TH>
                    <td><input type="text" class="form-control" name="filter_mobileNumber" id="filter_mobileNumber">
                    </td>
                    <TH>Nationality</TH>
                    <td>
                        <select name="filter_nationality_id" id="filter_nationality_id" placeholder="Select ..."
                                class="form-control">
                            <option value=""></option>
                            @foreach($lkp_country as $lkp_countryy)
                                <option value="{{$lkp_countryy->id}}">{{$lkp_countryy->country_en}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <TH>Iqama</TH>
                    <td><input type="text" class="form-control" name="filter_iqama" id="filter_iqama"></td>
                    <TH>IqamaExpireyDate</TH>
                    <td>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control" name="filter_iqamaExpireyDate" id="filter_iqamaExpireyDate"
                                   type="text">
                            <script>
                                $(function () {
                                    $('input[name="filter_iqamaExpireyDate"]').daterangepicker({
                                        autoUpdateInput: false,
                                        opens: 'left',
                                        locale: {
                                            cancelLabel: 'Cancel'
                                        }
                                    });
                                    $('input[name="filter_iqamaExpireyDate"]').on('apply.daterangepicker', function (ev, picker) {
                                        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                    });
                                    $('input[name="filter_iqamaExpireyDate"]').on('cancel.daterangepicker', function (ev, picker) {
                                        $(this).val('');
                                    });
                                });
                            </script>
                        </div>

                    </td>
                    <TH>Email ID</TH>
                    <td><input type="text" class="form-control" name="filter_email_id" id="filter_email_id"></td>
                </tr>
                <tr>
                    <TH>Job ID</TH>
                    <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"></td>
                    <TH>DateOfbirth</TH>
                    <td>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control" name="filter_dob" id="filter_dob" type="text">
                            <script>
                                $(function () {
                                    $('input[name="filter_dob"]').daterangepicker({
                                        autoUpdateInput: false,
                                        opens: 'left',
                                        locale: {
                                            cancelLabel: 'Cancel'
                                        }
                                    });
                                    $('input[name="filter_dob"]').on('apply.daterangepicker', function (ev, picker) {
                                        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                    });
                                    $('input[name="filter_dob"]').on('cancel.daterangepicker', function (ev, picker) {
                                        $(this).val('');
                                    });
                                });
                            </script>
                        </div>

                    </td>
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
                </tr>
                <tr>
                    <TH>Account_Owner_Iqama</TH>
                    <td><input type="text" class="form-control" name="filter_account_owner_iqama"
                               id="filter_account_owner_iqama">
                    </td>
                    <TH>Interview_Date</TH>
                    <td>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control" name="filter_interview_date" id="filter_interview_date"
                                   type="text">
                            <script>
                                $(function () {
                                    $('input[name="filter_interview_date"]').daterangepicker({
                                        autoUpdateInput: false,
                                        opens: 'left',
                                        locale: {
                                            cancelLabel: 'Cancel'
                                        }
                                    });
                                    $('input[name="filter_interview_date"]').on('apply.daterangepicker', function (ev, picker) {
                                        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                    });
                                    $('input[name="filter_interview_date"]').on('cancel.daterangepicker', function (ev, picker) {
                                        $(this).val('');
                                    });
                                });
                            </script>
                        </div>

                    </td>
                    <TH>Start_Date</TH>
                    <td>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control" name="filter_start_date" id="filter_start_date" type="text">
                            <script>
                                $(function () {
                                    $('input[name="filter_start_date"]').daterangepicker({
                                        autoUpdateInput: false,
                                        opens: 'left',
                                        locale: {
                                            cancelLabel: 'Cancel'
                                        }
                                    });
                                    $('input[name="filter_start_date"]').on('apply.daterangepicker', function (ev, picker) {
                                        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                    });
                                    $('input[name="filter_start_date"]').on('cancel.daterangepicker', function (ev, picker) {
                                        $(this).val('');
                                    });
                                });
                            </script>
                        </div>

                    </td>
                </tr>
                <tr>
                    <TH>licenseExpireyDate</TH>
                    <td>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control" name="filter_licenseExpireyDate"
                                   id="filter_licenseExpireyDate" type="text">
                            <script>
                                $(function () {
                                    $('input[name="filter_licenseExpireyDate"]').daterangepicker({
                                        autoUpdateInput: false,
                                        opens: 'left',
                                        locale: {
                                            cancelLabel: 'Cancel'
                                        }
                                    });
                                    $('input[name="filter_licenseExpireyDate"]').on('apply.daterangepicker', function (ev, picker) {
                                        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                    });
                                    $('input[name="filter_licenseExpireyDate"]').on('cancel.daterangepicker', function (ev, picker) {
                                        $(this).val('');
                                    });
                                });
                            </script>
                        </div>

                    </td>

                    <TH>PassportNo</TH>
                    <td><input type="text" class="form-control" name="filter_passportNo" id="filter_passportNo">
                    </td>
                    <TH>passportExpireyDate</TH>
                    <td>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control" name="filter_passportExpireyDate"
                                   id="filter_passportExpireyDate" type="text">
                            <script>
                                $(function () {
                                    $('input[name="filter_passportExpireyDate"]').daterangepicker({
                                        autoUpdateInput: false,
                                        opens: 'left',
                                        locale: {
                                            cancelLabel: 'Cancel'
                                        }
                                    });
                                    $('input[name="filter_passportExpireyDate"]').on('apply.daterangepicker', function (ev, picker) {
                                        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                    });
                                    $('input[name="filter_passportExpireyDate"]').on('cancel.daterangepicker', function (ev, picker) {
                                        $(this).val('');
                                    });
                                });
                            </script>
                        </div>

                    </td>
                </tr>
                <tr>
                    <TH>Bank Name</TH>
                    <td>
                        <select name="filter_bank_id" id="filter_bank_id" class="form-control">
                            <option value=""></option>
                            @foreach($lkp_bank as $lkp_bankk)
                                <option value="{{$lkp_bankk->id}}">{{$lkp_bankk->bank_name_en}}</option>
                            @endforeach
                        </select>
                    </td>
                    <TH>accountNumber</TH>
                    <td><input type="text" class="form-control" name="filter_accountNumber"
                               id="filter_accountNumber"></td>

                    <TH>Under Sopnsorship</TH>
                    <td>
                        <select name="filter_under_sopnsorship_id" id="filter_under_sopnsorship_id"
                                class="form-control">
                            <option value=""></option>
                            @foreach($lkp_yes_no as $lkp_yes_noo)
                                <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
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
                    <TH>Ajeer</TH>
                    <td>
                        <select name="filter_ajeer_id" id="filter_ajeer_id" class="form-control">
                            <option value=""></option>
                            @foreach($lkp_yes_no as $lkp_yes_noo)
                                <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
                            @endforeach
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


<div class="table-responsive" style="width: 100%;">
    <table id="customer_data" class="w3-table-all w3-card-4">
        <thead>
        <TH>Company</TH>
        <TH>WarehouseName</TH>
        <TH>FullName</TH>
        <TH>Mobile</TH>
        <TH>Iqama</TH>
        <TH>Job ID</TH>
        <TH>Status</TH>
        <TH>Perivious Balance</TH>
        <TH>Current Balance</TH>
        <TH>Action</TH>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<!---------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------->
<div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:750px">
        <div class="w3-center"><br>
            <span onclick="document.getElementById('edit_modal').style.display='none'"
                  class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright" title="Close Modal">&times;</span>
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
                  class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright" title="Close Modal">&times;</span>
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

        function fill_datatable(filter_screenId = '',filter_companyId = '',filter_warehouseId = '', filter_fullName = '', filter_fullName_ar = '', filter_mobileNumber = '', filter_nationality_id = '', filter_iqama = '', filter_iqamaExpireyDate = '', filter_email_id = '', filter_job_id = '', filter_dob = '', filter_status_id = '', filter_termination_reason_id = '', filter_interview_date = '', filter_start_date = '', filter_licenseExpireyDate = '', filter_passportNo = '', filter_passportExpireyDate = '', filter_bank_id = '', filter_accountNumber = '', filter_created_at = '', filter_updated_at = '') {
            var dataTable = $('#customer_data').DataTable({
                //searching: false,
                responsive: true,
                processing: true,
                serverSide: true,
                "pagingType": "full_numbers",
                "autoWidth": false,
                "drawCallback": function (settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                },
                ajax: {

                    url: "{{ route('Drivers.index') }}",
                    data: {
                        filter_screenId: 'Drivers',
                        filter_companyId: filter_companyId,
                        filter_warehouseId: filter_warehouseId,
                        filter_fullName: filter_fullName,
                        filter_fullName_ar: filter_fullName_ar,
                        filter_mobileNumber: filter_mobileNumber,
                        filter_nationality_id: filter_nationality_id,
                        filter_iqama: filter_iqama,
                        filter_iqamaExpireyDate: filter_iqamaExpireyDate,
                        filter_email_id: filter_email_id,
                        filter_job_id: filter_job_id,
                        filter_dob: filter_dob,
                        filter_status_id: filter_status_id,
                        filter_termination_reason_id: filter_termination_reason_id,
                        filter_interview_date: filter_interview_date
                        , filter_start_date: filter_start_date,
                        filter_licenseExpireyDate: filter_licenseExpireyDate,
                        filter_passportNo: filter_passportNo,
                        filter_passportExpireyDate: filter_passportExpireyDate,
                        filter_bank_id: filter_bank_id,
                        filter_accountNumber: filter_accountNumber,
                        filter_created_at: filter_created_at,
                        filter_updated_at: filter_updated_at,
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
                        data: 'driver_status_en',
                        data: 'lkp_driver_status.driver_status_en',
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
                    {
                        data: 'per_priod',
                        name: 'balance.per_priod'
                    },
                    {
                        data: 'cur_priod',
                        name: 'balance.cur_priod'
                    },
                    {
                        "orderable": false,
                        "targets": -1,
                        data: 'id',
                        "render": function (data, type, row, meta) {
                            return '<button onclick="select(' + row.id + ',\'' + row.fullName + '\',' + row.per_priod + ',' + row.cur_priod + ',\'' + row.per_range + '\',\'' + row.cur_range + '\');" type="button" class="btn btn-primary btn-xs">Select</button>'

                        }
                        //onclick=\"document.getElementById('row_id').value='"+data+"'\"
                    }

                ]
            });


        }


        $('#filter').click(function () {

            if ($('#filter_companyId').val() != '' ||$('#filter_warehouseId').val() != '' || $('#filter_fullName').val() != '' || $('#filter_fullName_ar').val() != '' || $('#filter_mobileNumber').val() != '' || $('#filter_nationality_id').val() != '' || $('#filter_iqama').val() != '' || $('#filter_iqamaExpireyDate').val() != '' || $('#filter_email_id').val() != '' || $('#filter_job_id').val() != '' || $('#filter_dob').val() != '' || $('#filter_status_id').val() != '' || $('#filter_termination_reason_id').val() != '' || $('#filter_interview_date').val() != '' || $('#filter_start_date').val() != '' || $('#filter_licenseExpireyDate').val() != '' || $('#filter_passportNo').val() != '' || $('#filter_passportExpireyDate').val() != '' || $('#filter_bank_id').val() != '' || $('#filter_accountNumber').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                card_change();
                $('#customer_data').DataTable().destroy();
                fill_datatable('Drivers',$('#filter_companyId').val(),$('#filter_warehouseId').val(), $('#filter_fullName').val(), $('#filter_fullName_ar').val(), $('#filter_mobileNumber').val(), $('#filter_nationality_id').val(), $('#filter_iqama').val(), $('#filter_iqamaExpireyDate').val(), $('#filter_email_id').val(), $('#filter_job_id').val(), $('#filter_dob').val(), $('#filter_status_id').val(), $('#filter_termination_reason_id').val(), $('#filter_interview_date').val(), $('#filter_start_date').val(), $('#filter_licenseExpireyDate').val(), $('#filter_passportNo').val(), $('#filter_passportExpireyDate').val(), $('#filter_bank_id').val(), $('#filter_accountNumber').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
            } else {
                alert('Select filter option');
            }
        });

        $('#reset').click(function () {
            $('#filter_companyId').val('');
            $('#filter_warehouseId').val('');
            $('#filter_fullName').val('');
            $('#filter_fullName_ar').val('');
            $('#filter_mobileNumber').val('');
            $('#filter_nationality_id').val('');
            $('#filter_iqama').val('');
            $('#filter_iqamaExpireyDate').val('');
            $('#filter_email_id').val('');
            $('#filter_job_id').val('');
            $('#filter_dob').val('');
            $('#filter_status_id').val('');
            $('#filter_termination_reason_id').val('');
            $('#filter_interview_date').val('');
            $('#filter_start_date').val('');
            $('#filter_licenseExpireyDate').val('');
            $('#filter_passportNo').val('');
            $('#filter_passportExpireyDate').val('');
            $('#filter_bank_id').val('');
            $('#filter_accountNumber').val('');
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

    function select(id, name, per_priod, cur_priod, per_range, cur_range) {
        //alert(opener.document.getElementById('driverId_text').innerHTML);
        if (opener.document.getElementById('driverId')) {
            opener.document.getElementById('driverId_input').value = name;
            opener.document.getElementById('driverId').value = id;
        }
        if (opener.document.getElementById('filter_driverId')) {
            opener.document.getElementById('filter_driverId_input').value = name;
            opener.document.getElementById('filter_driverId').value = id;
        }

        if (opener.document.getElementById('balance')) {

            if (per_priod == null) per_priod = 0;
            if (cur_priod == null) cur_priod = 0;
            opener.document.getElementById('balance').innerHTML = "<table>" +
                "<tr><TH>Perivious Balance:</TH><td><font color=red>" + per_priod + "</font>  (" + per_range + ")<td></tr>" +
                "<tr><TH style='text-align: right;'>Current Balance:</TH><td><font color=red>" + cur_priod + "</font>  (" + cur_range + ")<td></tr>" +
                "</table>";


        }
        close();
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
</script>

<!-- ./wrapper -->

<!-- jQuery 3 -->

<script src="{{asset("/AdminLTE/js/jquery.min.js")}}"></script>

<script src="{{asset("/AdminLTE/js/select2.full.min.js")}}"></script>
<!-- Bootstrap 3.3.7 -->

<script src="{{asset("/AdminLTE/js/bootstrap.min.js")}}"></script>
<!-- date-range-picker -->
<script src="{{asset("/AdminLTE/moment/min/moment.min.js")}}"></script>
<script src="{{asset("/AdminLTE/bootstrap-daterangepicker/daterangepicker.js")}}"></script>

<script src="{{asset("/AdminLTE/js/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/AdminLTE/js/dataTables.bootstrap.min.js")}}"></script>
<!-- FastClick -->
<script src="{{asset("/AdminLTE/js/fastclick.js")}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset("/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("/AdminLTE/js/adminlte.min.js")}}"></script>








