@extends('AdminLTE')

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="AttachmentModal" tabindex="-1" role="dialog" aria-labelledby="AttachmentModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form action="{{url('DriversJahiz/storeDocument')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="AttachmentModal">Issuing document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                        <div class="form-group" >
                            <label for='Driver_name1'>DA Details | المندوب</label>
                            <div id="responseDiv">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Document Type  | نوع المستند <span style="color:red !important">*</span></label>
                            <select class="form-control" onchange="setDocumentType()" name="documentType" id="documentType">
                                <option value="none">Choose Doc type</option>
                                <option value="150">Quittance | مخالصة </option>
                                <option value="75">Bond cancellation | الغاء سند</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Amount | المبلغ </label>
                            <input type="Text" disabled value="0.00 SAR" class="form-control" id="totalAmount" >
                        </div>
                        <style>
                        .inputBtns{
                                width: 89%;
                                margin: 5px;
                                float: right;
                            }
                            td{
                                text-align: center;
                            }
                        </style>
                        <div class="form-group">
                        <label for="exampleInputPassword1">Payment type | نوع السداد </label>
                            <table>
                                <tr>
                                    <th>Cash</th>
                                    <td><input type="number" class="inputBtns" id="Cash" min="0" placeholder="Cash" name="cash" onchange="checkType()"></td>
                                    <th>ATM</th>
                                    <td><input type="number" class="inputBtns"  id="ATM" min="0" placeholder="ATM" name="atm" onchange="checkType()"></td>
                                    <th>BANK</th>
                                    <td><input type="number" class="inputBtns" id="Bank" min="0" placeholder="Bank" name="bank" onchange="checkType()"></td>
                                </tr>
                            </table>




                        </div>
                        <!-- <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div> -->
                        <h2 id="total" style="display:none;text-align: center; margin-top: 44px;">
                            Paid Amount : <span style="color:red" id="sumAmount"> </span>
                            SAR
                        </h2>



                </div>
                <div class="modal-footer" style="margin-top: 32px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" disabled id="confirmBtn" onclick="disableConfirmBtn()">Confirm</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Content Header (Page header) -->
        <div style="width:100%;margin: 0px; ">
            <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Drivers</h2>
            </div>
            @if(Auth::user()->user_type_id==1 || session('Session_DriversJahiz')=='yes')
                <div style="float:right;">
                    <h2>
                            <a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New
                            Driver</a>
                            <a target="popup"
                            onclick="window.open('{{ url('/DriversJahiz/import') }}','popup','width=600,height=600'); return false;" class="btn btn-sm btn-warning "><i class="fa fa-plus"></i>
                            Import SANAD Clearing</a>

                            <a target="popup"
                            onclick="window.open('{{ url('/Syinc-drivers-sanad') }}','popup','width=600,height=600'); return false;" class="btn btn-sm btn-success "><i class="fa fa-plus"></i>
                        Syinc SANED </a>
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
                        <TH>fullName</TH>
                        <td><input type="text" class="form-control" style="width:180px;" id="filter_fullName"
                                   name="filter_fullName"></td>
                        <TH>Mobile</TH>
                        <td><input type="text" class="form-control" name="filter_mobileNumber" id="filter_mobileNumber"
                                   style="width: 180px">
                        </td>

                    </tr>

                    <tr>
                        <TH>Iqama</TH>
                        <td><input type="text" class="form-control" name="filter_iqama" id="filter_iqama"></td>

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
                        <TH>Job ID</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"></td>
                    </tr>
                    <tr>
                        <TH>accountNumber</TH>
                        <td><input type="text" class="form-control" name="filter_accountNumber"
                                   id="filter_accountNumber"></td>
                        <TH>Account_Owner_Iqama</TH>
                        <td><input type="text" class="form-control" name="filter_account_owner_iqama"
                                   id="filter_account_owner_iqama">
                        </td>

                        <TH>Claim Date</TH>
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

                        <TH>Amount</TH>
                        <td>
                            <select name="filter_collectionAmount" id="filter_collectionAmount" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">+</option>
                                <option value="2">-</option>
                            </select>
                        </td>

                        <TH>SANED Date</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_SANED_SettledDate"
                                       id="filter_SANED_SettledDate" type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_SANED_SettledDate"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_SANED_SettledDate"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_SANED_SettledDate"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });

                                </script>
                            </div>
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
                        <TH>Bander Date</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_jahiz_clearing_updated_at"
                                       id="filter_jahiz_clearing_updated_at" type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_jahiz_clearing_updated_at"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_jahiz_clearing_updated_at"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_jahiz_clearing_updated_at"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });

                                </script>
                            </div>
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

    <form method="POST" action="{{ URL('/DriversPost')}}">
        @csrf

        <div class="table-responsive" style="width: 100%;">

            <table id="customer_data" class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                    <TH rowspan="2">City</TH>
                    <TH rowspan="2">Type</TH>
                    <TH rowspan="2">FullName</TH>
                    <TH rowspan="2">Mobile</TH>
                    <TH rowspan="2">STC Pay</TH>
                    <TH rowspan="2">Job ID</TH>
                    <TH rowspan="2">Status</TH>
                    <TH rowspan="2"><?php echo date('Y-m', strtotime(date('Y-m') . " -1 month"));?></TH>
                    <TH rowspan="2"><?php echo date('Y-m');?></TH>
                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">SANED</TH>
                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">Bander</TH>
                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">مطالبة</TH>
                    <TH rowspan="2">Amount</TH>
                    <TH rowspan="2">Create</TH>
                    <TH rowspan="2">Action</TH>
                </tr>
                <tr>
                    <TH>SAR</TH>
                    <TH>Days</TH>
                    <TH>SAR</TH>
                    <TH>Days</TH>
                    <TH>SAR</TH>
                    <TH style="border-right: 1px solid #f4f4f4!important;">After</TH>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </form>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:900px">
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


    <script>
        function disableConfirmBtn(){
            // $("#confirmBtn").prop('disabled', true);
            $("#confirmBtn").click();
        }
        $(document).ready(function () {

            fill_datatable();

            function fill_datatable(filter_screenId = '', filter_companyId = '', filter_warehouseId = '', filter_driver_type_id = '', filter_fullName = '', filter_mobileNumber = '', filter_iqama = '', filter_job_id = '', filter_status_id = '', filter_account_owner_iqama = '', filter_accountNumber = '', filter_claim_dt = '', filter_SANED_SettledDate = '', filter_jahiz_clearing_updated_at = '', filter_collectionAmount = '', filter_created_at = '', filter_updated_at = '', filter_Image_Identity = '', filter_Image_Passport = '', filter_Image_DrivingLicence = '', filter_Image_VehiclesRegistration = '', filter_Image_JobContract = '', filter_Image_PromissoryNote = '') {
                var dataTable = $('#customer_data').DataTable({
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
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
                            filter_screenId: 'Jahiz',
                            filter_companyId: filter_companyId,
                            filter_warehouseId: filter_warehouseId,
                            filter_fullName: filter_fullName,
                            filter_mobileNumber: filter_mobileNumber,
                            filter_iqama: filter_iqama,
                            filter_job_id: filter_job_id,
                            filter_status_id: filter_status_id,
                            filter_account_owner_iqama: filter_account_owner_iqama,
                            filter_accountNumber: filter_accountNumber,
                            filter_driver_type_id, filter_driver_type_id,
                            filter_claim_dt: filter_claim_dt,
                            filter_SANED_SettledDate: filter_SANED_SettledDate,
                            filter_jahiz_clearing_updated_at: filter_jahiz_clearing_updated_at,
                            filter_created_at: filter_created_at,
                            filter_collectionAmount: filter_collectionAmount,
                            filter_updated_at: filter_updated_at,
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
                            data: 'accountNumber',
                            name: 'accountNumber'
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

                        {
                            "searchable": false,
                            data: 'per_priod',
                            name: 'per_priod'
                        },
                        {
                            "searchable": false,
                            data: 'cur_priod',
                            name: 'cur_priod'
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
                            className: "table-cell-load",
                            "searchable": false,
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            className: "table-cell-touchpoint",
                            "searchable": false,
                            data: 'Claim_After',
                            name: 'Claim_After'
                        },
                        {
                            data: 'openBalance',
                            name: 'openBalance'
                        },
                        {
                            "searchable": false,
                            data: 'created_at2',
                            name: 'created_at2'
                        },

                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            //"data": 'id',
                            "render": function (data, type, row, meta) {
                                a = '';
                                a += '<input type="hidden" id="IDs_all_' + meta.row + '" name="IDs_all_' + meta.row + '" value="' + row.id + '">' +
                                    '<a id=' + row.id + ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>';
                                @if(Auth::user()->user_type_id==1)
                                    a += '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>';
                                @endif
                                    a += '&nbsp;<a id=' + row.id + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement"> <i class="fa fa-bars"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="Attachment" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue Attachment"> <i class="fa fa-paperclip"></i> </a>';



                                if(row.driver_type_id == null){
                                    a += '&nbsp;<a id=' + row.id+ ' data-original-title="Update Driver Type To Issuing documents"  disabled data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue documents"> <i class="fa fa-file-text-o" aria-hidden="true"></i> </a>';
                                }else{
                                    a += '&nbsp;<a id=' + row.id+ ' data-original-title="Issuing documents" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue documents"> <i class="fa fa-file-text-o" aria-hidden="true"></i> </a>';
                                    console.log('Null');
                                    console.log('Not null');
                                }
                                @if (Auth::user()->user_type_id == 1)
                                if (row.warehouseId == '201' || row.warehouseId == '220' || row.warehouseId == '221') {
                                    a += '&nbsp;<button id=' + row.id + 'type="button" class="btn btn-primary btn-xs DriversSettlementList">تصفية</button>';
                                }
                                @else
                                    a += '&nbsp;<button id=' + row.id + ' type="button" class="btn btn-primary btn-xs DriversSettlementList">تصفية</button>';
                                @endif
                                    //a += '&nbsp;<button id=' + row.id + ' type="button" class="btn btn-primary btn-xs DriversClaim">مطالبة</button>';
                                return a;

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
                    url: "{{URL('/Drivers')}}" + "/" + id,
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
                    url: "{{URL('/Drivers')}}" + "/" + id + "/edit/2",
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
                // alert(id);
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
                    url: "{{URL('/statement_Jahiz')}}" + "/" + id,
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

                myWindow1 = window.open("{{URL("documents")}}" + "/" + id, "mywin",
                    "height=900,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
                myWindow1.focus();

            });

            // ashraf code, documents
            $('#customer_data tbody').on('click', '.documents', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                $('#totalAmount').val('0.00 SAR')
                $('#Cash').val(0.00)
                $('#ATM').val(0.00)
                $('#Bank').val(0.00)
                $('#total').hide();
                $("option:selected").prop("selected", false)
                // $("#documentType select").val("none").change();


                $.ajax({
                    type: 'GET',
                    url: "{{URL('Drivers_jahiz_doc/')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        console.log(data);
                        document.getElementById('responseDiv').innerHTML = data;
                        // document.getElementById('response').innerHTML = data;
                    }
                });
                $('#AttachmentModal').modal('show');

            });

            // ashraf code
            $('#customer_data tbody').on('click', '.DriversSettlementList', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/DriversSettlementList')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;


                    }
                });
            });
            $('#customer_data tbody').on('click', '.DriversClaim', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/DriversClaim')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;
                        var g = document.createElement('script');
                        var s = document.getElementsByTagName('script')[0];

                        g.text = "$('#claim_dt').datepicker({" +
                            "format: 'dd/mm/yyyy'," +
                            "autoclose: true," +
                            "autoHide: true," +
                            "zIndex: 9999," +
                            "});"
                        s.parentNode.insertBefore(g, s);


                    }
                });
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

                if ($('#filter_warehouseId').val() != '' || $('#filter_driver_type_id').val() != '' || $('#filter_fullName').val() != '' || $('#filter_mobileNumber').val() != '' || $('#filter_iqama').val() != '' || $('#filter_job_id').val() != '' || $('#filter_status_id').val() != '' || $('#filter_account_owner_iqama').val() != '' || $('#filter_accountNumber').val() != '' || $('#filter_claim_dt').val() != '' || $('#filter_SANED_SettledDate').val() != '' || $('#filter_jahiz_clearing_updated_at').val() != '' || $('#filter_collectionAmount').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '' || $('#filter_Image_Identity').val() != '' || $('#filter_Image_Passport').val() != '' || $('#filter_Image_DrivingLicence').val() != '' || $('#filter_Image_VehiclesRegistration').val() != '' || $('#filter_Image_JobContract').val() != '' || $('#filter_Image_PromissoryNote').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable('Jahiz', $('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_driver_type_id').val(), $('#filter_fullName').val(), $('#filter_mobileNumber').val(), $('#filter_iqama').val(), $('#filter_job_id').val(), $('#filter_status_id').val(), $('#filter_account_owner_iqama').val(), $('#filter_accountNumber').val(), $('#filter_claim_dt').val(), $('#filter_SANED_SettledDate').val(), $('#filter_jahiz_clearing_updated_at').val(), $('#filter_collectionAmount').val(), $('#filter_created_at').val(), $('#filter_updated_at').val(), $('#filter_Image_Identity').val(), $('#filter_Image_Passport').val(), $('#filter_Image_DrivingLicence').val(), $('#filter_Image_VehiclesRegistration').val(), $('#filter_Image_JobContract').val(), $('#filter_Image_PromissoryNote').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {

                $('#filter_warehouseId').val('');
                $('#filter_fullName').val('');
                $('#filter_mobileNumber').val('');
                $('#filter_iqama').val('');
                $('#filter_job_id').val('');
                $('#filter_status_id').val('');
                $('#filter_account_owner_iqama').val('');
                $('#filter_accountNumber').val('');
                $('#filter_driver_type_id').val('');
                $('#filter_claim_dt').val('');
                $('#filter_SANED_SettledDate').val('');
                $('#filter_jahiz_clearing_updated_at').val('');
                $('#filter_collectionAmount').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');
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
                url: "{{URL("/Drivers/create/2")}}",
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


        function sheet(id, Period) {
            myWindow1 = window.open("{{URL('/SalaryShow')}}" + "/" + id + "/" + Period, "",
                "height=1000,width=650,scrollbars=yes,top=1,left=1,status,resizable");
        }

        function AddDriversSettlement(id) {
            //e.preventDefault();
            // var id = $(this).attr('id');

            myWindow1 = window.open("{{URL("DriversSettlement")}}" + "/" + id + "/0", "mywin",
                "height=900,width=820,scrollbars=yes,top=1,left=1,status,resizable");
            myWindow1.focus();
        }

        function EditDriversSettlement(driverId, jahiz_clearing_id) {
            myWindow1 = window.open("{{URL("DriversSettlement")}}" + "/" + driverId + "/" + jahiz_clearing_id, "mywin",
                "height=900,width=820,scrollbars=yes,top=1,left=1,status,resizable");
            myWindow1.focus();
        }

        function DeleteDriversSettlement(driverId, jahiz_clearing_id) {
            if (confirm("هل انت متاكد من مسح هذه التصفية?") == true) {
                //e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                //document.getElementById('edit_modal').style.display = 'block';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: "{{URL('/DriversSettlementDelete')}}" + "/" + driverId + "/" + jahiz_clearing_id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;
                    },
                    error: function (jqXHR, status, error) {
                        document.getElementById('response').innerHTML = "Error: " + error;
                        alert(status + ": " + error);
                    }
                });
            } else {

            }

        }

        function DriversSettlementList(driverId) {
            //e.preventDefault();
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL('/DriversSettlementList')}}" + "/" + driverId,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;


                }
            });
        }

    </script>
    <script>
        $(document).ready(function(){

        });
        function setDocumentType(){
                var selectedOption= $('#documentType :selected').val();
            //  alert(selectedOption);
                $('#Cash').val(0.00)
                $('#ATM').val(0.00)
                $('#Bank').val(0.00)
                $('#total').hide();
                if(selectedOption == 'none'){
                $('#totalAmount').val('Select DocumentType')

                alert('يجب اختيار نوع المعاملة');
                }
                if(selectedOption == 150){
                $('#totalAmount').val('150.00 SAR')
                }
                if(selectedOption == 75){
                $('#totalAmount').val('75.00 SAR')
                }
                checkType()

        }

        function validateForm() {
//alert($("#contact_form").serializeArray());

            //e.preventDefault();
            //document.getElementById('response').innerHTML = loader;
            //document.getElementById('edit_modal').style.display = 'block';
            if (document.getElementById('accountNumber')) {
                if ($("#accountNumber").val() != '' && ($("#accountNumber").val().length != 12 || $("#accountNumber").val().substring(0, 3) != '966')) {
                    alert('خطا في رقم الحساب : يجب ان يبدا ب 966 ويحتوي علي 12 رقم');
                    return false;
                }
                if ($("#account_owner_iqama").val() != '' && ($("#account_owner_iqama").val().length != 10 || ($("#account_owner_iqama").val().substring(0, 1) != '1' && $("#account_owner_iqama").val().substring(0, 1) != '2'))) {
                    alert('خطا في هوية صاحب الحساب : يجب ان يبدا ب 1 او 2 ويحتوي علي 10 ارقام');
                    return false;
                }
            }

            var postData = $("#contact_form").serializeArray();
            //alert(postData);
            var formURL = $("#contact_form").attr("action");
            document.getElementById('response').innerHTML = loader;
            $.ajax({
                url: formURL,
                type: "POST",
                cache: false,
                data: postData,
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                },
                error: function (jqXHR, status, error) {
                    alert(status + ": " + error);
                }
            });
            return false;
        }
        function checkType() {
            var selectedOption= $('#documentType :selected').val();
            if(selectedOption == 'none'){
                $('#exampleInputAmount').val('Select DocumentType')
                    alert('يجب اختيار نوع المعاملة');
                }else{
                if($('#Cash').val() == ''){
                    cash = 0.00;
                }else{
                    cash = $('#Cash').val();
                }
                if($('#ATM').val() == ''){
                    atm = 0.00;
                }else{
                    atm = $('#ATM').val();
                }
                if($('#Bank').val() == ''){
                    bank = 0.00;
                }else{
                    bank = $('#Bank').val();
                }
                var total = parseFloat(bank)+parseFloat(atm)+parseFloat(cash);

                if( total > 0){
                    $('#total').show();
                    $('#sumAmount').text(total);

                    if(total == selectedOption){
                        $("#confirmBtn").prop('disabled', false);

                        // alert('True sn Equal');
                    }else{
                        $("#confirmBtn").prop('disabled', true);
                    }
                }else{
                    $("#confirmBtn").prop('disabled', true);
                }
            }
            // alert(total);
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




