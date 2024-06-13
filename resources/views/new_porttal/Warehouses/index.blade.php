@extends('layout2')
@section('content')
@section('title', __('warehouses.warehouses'))
<style>
    .disabled {
        opacity: 0.5;
        pointer-events: none;
    }
    .list-group-item+.list-group-item.active {
        border-top: 1px solid white;
        background-color: #0866e9;
    }
    .list-group-item.active{
        background-color: #0866e9;
    }
    #table{
        width: 90%; margin: 0 auto; margin-top: 44px;
    }
    .list-group .list-group-item {

    }
</style>



<div class="modal fade" id="FillterButton" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> {{__('drivers.Filter')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Card start -->
                        <div class="card">
                            <div class="card-body">
                                <!-- Row start -->
                                <div class="row">
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('warehouses.companyName')}}</label>
                                            <select name="filter_companyId" id="filter_companyId" onchange="CityName()"
                                                    class="form-control" required>
                                                @foreach($lkp_company as $lkpcompany)
                                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('warehouses.under_noon')}}</label>
                                            <select name="filter_under_noon_id" id="filter_under_noon_id"
                                                    class="form-control">
                                                <option value=""></option>
                                                @foreach($lkp_yes_no as $lkp_yes_noo)
                                                    <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('warehouses.cityName')}}</label>
                                            <select onchange="Warehouse()" name="filter_cityId" id="filter_cityId"
                                                    class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('warehouses.warehouse')}}</label>
                                            <select name="filter_warehouseId" id="filter_warehouseId" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('warehouses.packages_date')}}</label>
                                            <input type="date" class="form-control"
                                            name="pakage_date" id="pakage_date" value="<?php echo date('Y-m-d');?>" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row end -->

                            </div>
                        </div>
                        <!-- Card end -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                <button type="button" class="btn btn-success"
                    data-bs-dismiss="modal" id="filter">{{__('drivers.Search')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal addNewUser3 -->
<div class="modal fade" id="addNewUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollableLabel"><span id="bck_btn" onclick="go_back()" style="cursor: pointer; display: none; color: #B7A758"><img src="{{URL("dashboard/assets/logos/backward.png")}}" style="width: 7%"> {{__('drivers.Back')}}</span> {{__('drivers.add_driver')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="statment">
                    <h5>{{__('drivers.driver_add_method')}}: </h5>
                     <div class="row">
                        <div class="col-6" style="text-align: center;" onclick="handleContent('Form')">
                            <img  style="width: 74px; margin-top: 20px;cursor: pointer;" src="{{asset('design/assets/sign-form.png')}}" alt="fill form to create New driver" >
                        </div>
                        <div class="col-6" style="text-align: center;" onclick="handleContent('Bulk')">
                            <img  style="width: 74px; margin-top: 20px;cursor: pointer;" src="{{asset('design/assets/file.png')}}" alt="fill form to create New driver" >
                        </div>
                     </div>
                </div>
                <form id="driverForm">
                    @csrf
                    <div id="create_da_from" style="display: none">
                        <h5>{{__('drivers.select_method')}}: </h5>
                        <h6>{{__('drivers.FormData')}}</h6>
                    </div>
                </form>
                <div id="create_da_bulk" style="display: none">
                    {{-- <span onclick="go_back()" style="cursor: pointer; display: flex"><img src="https://static.thenounproject.com/png/1808051-200.png" style="width: 3%"> <h5>{{__('drivers.Back')}}</h5></span> --}}
                    <div class="row">
                        <div class="col-lg-6 mt-3">
                            <small>
                                {{__('drivers.download_description')}}.
                            </small>
                            <br />
                            <a href="{{ url('/storage/docsFormat/Drivers.csv') }}" class="btn btn-sm btn-info " style="padding: 10px"><i class="fa fa-download"></i>{{__('drivers.clickHere')}}</a>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <form method="POST" action="{{ route('Drivers/upload')}}">
                                @csrf
                                <input type="file" name="drivers_file" id="drivers_file" required><br>
                                <button type="submit" class="btn btn-success mt-4">{{__('drivers.Submit')}}</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="selectBulkOrOne" style="display: none">
                    <div class="row">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                {{-- <button type="button" class="btn btn-success" onclick="showSelectBulkOrOne('statment')">Understood</button> --}}
            </div>

        </div>
    </div>
</div>
<!--End Modal addNewUser 3 -->

<!-- Modal ExportExcel 3 -->
@php
$array = [
    0=>'Name',
    1=>'Phone',
    2=>'Email',
    3=>'IdentityNo',
    4=>'User Type',
    5=>'Role Name',
    6=>'Status',
    7=>'Created_at',
];
$module = "Warehouse";
@endphp
@include('new_porttal.partials.export_excel')
@include('new_porttal.partials.delete_modal')


<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('warehouses.warehouse')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>

        </div>
    </div>
</div>
<!--End Modal ExportExcel 3 -->

 <!-- Row start -->
 <div class="row">
    @include('new_porttal.partials.edit_btn')
</div>
<!-- Row end -->


<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('warehouses.warehouses')}}</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;"></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                {{-- <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button> --}}
                                <button type="button" class="btn btn-info" class="btn btn-info" type="button" onclick="add()"></i>{{__('warehouses.add_warehouse')}}</button>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered">
                            <thead>
                                <tr>
                                    <TH>{{__('warehouses.warehouse')}}</TH>
                                    <TH>{{__('warehouses.company')}}</TH>
                                    <TH>{{__('warehouses.city')}}</TH>
                                    <TH>T PK</TH>
                                    <TH>N PK</TH>
                                    <TH>T TP</TH>
                                    <TH>N TP</TH>
                                    <TH>T DA</TH>
                                    <TH>A DA</TH>
                                    <TH>A..DA</TH>
                                    <TH>{{__('warehouses.created_at')}}</TH>
                                    <TH>{{__('warehouses.min')}}</TH>
                                    <TH>{{__('warehouses.max')}}</TH>
                                    <TH>{{__('warehouses.avg')}}</TH>
                                    <TH>{{__('warehouses.med')}}</TH>
                                    <TH>{{__('warehouses.action')}}</TH>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <TH colspan='3'>{{__('warehouses.total')}}</TH>
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
                </div>
            </div>
            <!-- Card end -->
        </div>
        <!-- Card end -->

    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#filter_created_at').val('');
            $('#filter_updated_at').val('');
            // Clear the input when the cancel button is clicked
            $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_updated_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
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
                            className: "table-info"
                        },
                        {
                            data: 'no_of_deliverd',
                            name: 'packages.no_of_deliverd',
                            className: "table-info"
                        },
                        {
                            data: 'total_no_touchpoint',
                            name: 'packages.total_no_touchpoint',
                            className: "table-danger"
                        },
                        {
                            data: 'no_of_touch_point',
                            name: 'packages.no_of_touch_point',
                            className: "table-danger"
                        },
                        {
                            data: 'total_drivers',
                            name: 'total.total_drivers',
                            className: "table-active"
                        },
                        {
                            data: 'attendence',
                            name: 'packages.attendence',
                            className: "table-active"
                        },
                        {
                            data: 'attendwithnowork',
                            name: 'packages.attendwithnowork',
                            className: "table-active"
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'min_load',
                            name: 'packages.min_load',
                            className: "table-success"
                        },
                        {
                            data: 'max_load',
                            name: 'packages.max_load',
                            className: "table-success"
                        },
                        {
                            data: 'avg_load',
                            name: 'packages.avg_load',
                            className: "table-success"
                        },
                        {
                            data: 'median_val',
                            name: 'median_load.median_val',
                            className: "table-success"
                        },
                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            data: 'id',
                            "render": function (data, type, row, meta) {
                                let action = @json(__('drivers.Action'));
                                let view = @json(__('drivers.view'));
                                let edit = @json(__('drivers.edit'));
                                let deletee = @json(__('drivers.Delete'));
                                let reset_password = @json(__('drivers.reset_password'));

                                let html = `<input id="name_` + row.id + `" type="hidden" value="` + row.warehouseName + `">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    `+action+`
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a id=` + row.id + ` data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view dropdown-item" href="#">`+view+`</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a id=` + row.id + ` data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit dropdown-item" href="#">`+edit+`</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a id=` + row.id + ` data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow driver dropdown-item" href="#">Drivers</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        `;
                                        @if(Auth::user()->user_type_id==1)
                                            html += `<li><a id=` + row.id + ` data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete dropdown-item" href="#"><span style="color:red">`+deletee+`</span></a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            `;
                                        @endif
                                        html += `
                                    </ul>
                                </div>`;
                                if (row.latitude && row.longitude)
                                    html += '<a href="javascript:map(' + row.id + ');"><img src="{{asset("/AdminLTE/img/map.png")}}" width="30px" height="30px" alt="" border="0"></a>';
                                return html;

                            }
                            //onclick=\"document.getElementById('row_id').value='"+data+"'\"
                        }

                    ]
                });


            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                // document.getElementById('response').innerHTML = loader;
                $('#edit_modal').modal('toggle');
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
                // document.getElementById('response').innerHTML = loader;
                $('#edit_modal').modal('toggle');
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
                // document.getElementById('response').innerHTML = loader;
                $('#edit_modal').modal('toggle');
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
                $('#delete_modal').modal('toggle');

            });

            $('#filter').click(function () {
                if ($('#pakage_date').val() != '' & $('#filter_companyId').val() != '') {
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#pakage_date').val(), $('#filter_companyId').val(), $('#filter_cityId').val(), $('#filter_warehouseId').val(), $('#filter_under_noon_id').val());
                    let html = '';
                    if ($('#filter_companyId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_companyId option:selected').text()+'</button>';
                    if ($('#filter_cityId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_cityId option:selected').text()+'</button>';
                    if ($('#filter_warehouseId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_warehouseId option:selected').text()+'</button>';
                    if ($('#filter_under_noon_id').val() > 0)
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_under_noon_id option:selected').text()+'</button>';


                    if ($('#pakage_date').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">Updated at: '+$('#pakage_date').val()+'</button>';

                    if(html != '') {
                        $('#edit_btn').show();
                        $('#selectedCriteria').html(html);
                    } else {
                        $('#edit_btn').hide();
                    }

                } else {
                    alert('Select Company and pakage_date');
                }
            });


        });

        function add() {
            // document.getElementById('response').innerHTML = loader;
            $('#edit_modal').modal('toggle');

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

        // $(function () {
        //     $('#pakage_date').datepicker({
        //         format: 'dd/mm/yyyy',
        //         autoclose: true,
        //         autoHide: true,
        //         zIndex: 9999,
        //     });
        // });

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
@stop
@endsection
