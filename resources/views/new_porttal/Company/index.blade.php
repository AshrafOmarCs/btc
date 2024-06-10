@extends('layout2')
@section('content')
@section('title', __('companies.companies'))
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
                                            <label for="country" class="form-label">{{__('companies.companyName')}}</label>
                                            <input type="text" class="form-control" name="filter_companyName" id="filter_companyName">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('companies.calculation_method')}}</label>
                                            <select id="filter_calculation_method_id" name="filter_calculation_method_id" class="form-control">
                                                <option value=""></option>

                                                @foreach($lkp_calculation_method as $lkp_calculation_methodd)
                                                    <option value="{{$lkp_calculation_methodd->id}}">{{$lkp_calculation_methodd->calculation_method}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('companies.period_start')}}</label>
                                            <input type="text" class="form-control" name="filter_period_start" id="filter_period_start">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('companies.period_end')}}</label>
                                            <input type="text" class="form-control" name="filter_period_end" id="filter_period_end">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('companies.companyFullName_en')}}</label>
                                            <input type="text" class="form-control" name="filter_companyFullName_en" id="filter_companyFullName_en" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('companies.companyFullName_ar')}}</label>
                                            <input type="text" class="form-control" name="filter_companyFullName_ar" id="filter_companyFullName_ar" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('companies.TaxNumber')}}</label>
                                            <input type="text" class="form-control" name="filter_TaxNumber" id="filter_TaxNumber" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('companies.CreditNote_Letter')}}</label>
                                            <input type="text" class="form-control" name="filter_CreditNote_Letter" id="filter_CreditNote_Letter" value="">
                                        </div>
                                    </div>



                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('companies.Created_At')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_created_at" name="filter_created_at">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('companies.Updated_At')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_updated_at" name="filter_updated_at">
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
<div class="modal fade" id="ExportExcel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.ExportDriverExcel')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Row start -->
                <div class="row">
                    <div class="col-xl-12 col-sm-12 col-12">
                        <p>{{__('drivers.criteria_msg')}}. </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table id="table">
                            <tr>
                                <td>
                                   <input type="checkbox" name="" id="select_all" onclick="check_uncheck()"> Select all
                                </td>
                                <td>

                                </td>
                                <td class="secondList">
                                    <input type="checkbox" name="" id="select_all_second" onclick="check_uncheckSecond()"> Unselect all
                                </td>
                            </tr>
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
                            @endphp
                            <tr>
                                <td>
                                    <ul class="list-group">
                                        @foreach($array as $k=>$option)
                                            <li class="list-group-item select_options"  id="option{{$k}}" onclick="selectOption('{{$k}}', '{{$option}}')" style="cursor: pointer;">{{$option}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td style="text-align: center;">
                                    <img style="width: 37px; margin-top: 4px; cursor: pointer;" id="forwardBtn" src="{{asset('assets/2735071.png')}}" onclick="pushSelected()" alt="">
                                    <br>
                                    <img style="width: 37px; margin-top: 53px; cursor: pointer;" id="reverseBtn" src="{{asset('assets/2985161.png')}}" onclick="popSelected()" alt="">
                                </td>
                                <td>
                                    <ul class="list-group secondList" class="secondList" id="secondListContent">
                                        @foreach($array as $k=>$option)
                                            <li class="list-group-item unselect_options"  id="unselect_option{{$k}}" onclick="unselectOption('{{$k}}')" style="cursor: pointer;"> &nbsp </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td style="text-align: right;">
                                    Total Select (<span style="color: red" id="totalSelected">0</span>)
                                </td>
                            </tr>
                            {{-- End-Footer --}}
                        </table>
                    </div>
                </div>
                <!-- Row end -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" style="background-color: red; border: 0;">{{__('drivers.Reset')}}</button>
                <button type="button" class="btn btn-success" style="background-color: #2661ba; border: 0;" id="exportExcelBtn">{{__('drivers.Download')}}</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('companies.company')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>

        </div>
    </div>
</div>
<div class="modal fade" id="delete_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('companies.company')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="w3-container" action="" method="POST" id="delete_form">
                {{method_field('DELETE')}}
                @csrf
                <div class="modal-body">
                    <p>{{__('companies.delete_msg')}} <span id="delete_name"></span> ?</p>
                </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('companies.cancel')}}</button>
                      <button class="btn btn-danger" type="submit">{{__('companies.delete')}}</button>
                  </div>
              </form>
        </div>
    </div>
</div>
<!--End Modal ExportExcel 3 -->

 <!-- Row start -->
 <div class="row">
    <div class="col-12" style="display: none" id="edit_btn">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <div class="custom-btn-group" id="selectedCriteria">
                            <button type="button" class="btn btn-outline-primary btn-rounded">iMile</button>
                            <button type="button" class="btn btn-outline-secondary btn-rounded">Riyadh Munesia </button>
                            <button type="button" class="btn btn-outline-warning btn-rounded">(2024-02-01 - 2024-02-31)</button>
                            <button type="button" class="btn btn-outline-success btn-rounded">Paid</button>
                            <button type="button" class="btn btn-outline-danger btn-rounded">Danger</button>

                            <button type="button" class="btn btn-outline-info btn-rounded">Active</button>
                            <button type="button" class="btn btn-outline-light btn-rounded">Created by Ashraf</button>
                        </div>
                    </div>
                    <div class="col-2">
                        <!-- Card start -->

                                <div class="custom-btn-group">
                                    <button type="button" style="margin: 0 auto;"  class="btn btn-outline-light btn-rounded" data-bs-toggle="modal" data-bs-target="#FillterButton">Edit</button>
                                </div>

                        <!-- Card end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->


<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('companies.company')}}</div>
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
                                <button type="button" class="btn btn-info" class="btn btn-info" type="button" onclick="add()"></i>{{__('companies.add_new_company')}}</button>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered">
                            <thead>
                                <tr>
                                    <TH>{{__('companies.companyName')}}</TH>
                                    <TH>{{__('companies.calculation_method')}}</TH>
                                    <TH>{{__('companies.period_start')}}</TH>
                                    <TH>{{__('companies.period_end')}}</TH>
                                    <TH>{{__('companies.companyFullName_en')}}</TH>
                                    <TH>{{__('companies.companyFullName_ar')}}</TH>
                                    <TH>{{__('companies.TaxNumber')}}</TH>
                                    <TH>{{__('companies.CreditNote_Letter')}}</TH>
                                    <TH>{{__('companies.updated_by')}}</TH>
                                    <TH>{{__('companies.updated_at')}}</TH>
                                    <TH>{{__('companies.status')}}</TH>
                                    <TH>{{__('companies.action')}}</TH>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
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

    function fill_datatable(filter_companyName = '', filter_calculation_method_id = '', filter_period_start = '', filter_period_end = '', filter_companyFullName_en = '', filter_companyFullName_ar = '', filter_TaxNumber = '', filter_CreditNote_Letter = '', filter_created_at = '', filter_updated_at = '') {
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
                url: "{{ route('Company.index') }}",
                data: {
                    filter_companyName: filter_companyName,
                    filter_calculation_method_id: filter_calculation_method_id,
                    filter_period_start: filter_period_start,
                    filter_period_end: filter_period_end,
                    filter_companyFullName_en: filter_companyFullName_en,
                    filter_companyFullName_ar: filter_companyFullName_ar,
                    filter_TaxNumber: filter_TaxNumber,
                    filter_CreditNote_Letter: filter_CreditNote_Letter,
                    filter_created_at: filter_created_at,
                    filter_updated_at: filter_updated_at,
                }
            },

            columns: [
                {
                    data: 'companyName',
                    name: 'companyName'
                },
                {
                    data: 'calculation_method',
                    name: 'lkp_calculation_method.calculation_method'
                },
                {
                    data: 'period_start',
                    name: 'period_start'
                },
                {
                    data: 'period_end',
                    name: 'period_end'
                },

                {
                    data: 'companyFullName_en',
                    name: 'companyFullName_en'
                },
                {
                    data: 'companyFullName_ar',
                    name: 'companyFullName_ar'
                },
                {
                    data: 'TaxNumber',
                    name: 'TaxNumber'
                },
                {
                    data: 'CreditNote_Letter',
                    name: 'CreditNote_Letter',
                },
                {
                    data: 'updated_users',
                    name: 'updated_users.name'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    name: 'status',
                    "render": function (data, type, row, meta) {
                        if(row.status == 'active')
                            return '<span class="badge badge-success">Active</span>';
                        else
                            return '<span class="badge badge-danger">Inactive</span>';
                    }
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
                        let html = `
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
                            return html;
                        // return '<a id=' + row.id + ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>' +
                        //     '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>' +
                        //     '&nbsp;<a id=' + row.id + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>';

                    }
                    //onclick=\"document.getElementById('row_id').value='"+data+"'\"
                },


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
            url: "{{URL('/Company')}}" + "/" + id,
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
            url: "{{URL('/Company')}}" + "/" + id + "/edit",
            contentType: "html",
            dataType: 'html',
            success: function (data) {

                document.getElementById('response').innerHTML = data;

            }
        });

    });

    $('#customer_data tbody').on('click', '.delete', function (e) {
        e.preventDefault();
        var id = $(this).attr('id');
        document.getElementById('delete_form').action = "{{URL('/Company')}}" + "/" + id;
        $('#delete_modal').modal('toggle');
    });

    $('#filter').click(function () {
        if ($('#filter_companyName').val() != '' || $('#filter_calculation_method_id').val() != '' || $('#filter_period_start').val() != '' || $('#filter_period_end').val() != '' || $('#filter_companyFullName_en').val() != '' || $('#filter_companyFullName_ar').val() != '' || $('#filter_TaxNumber').val() != '' || $('#filter_CreditNote_Letter').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
            $('#customer_data').DataTable().destroy();
            fill_datatable($('#filter_companyName').val(), $('#filter_calculation_method_id').val(), $('#filter_period_start').val(), $('#filter_period_end').val(), $('#filter_companyFullName_en').val(), $('#filter_companyFullName_ar').val(), $('#filter_TaxNumber').val(), $('#filter_CreditNote_Letter').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
            let html = '';
            if ($('#filter_companyName').val() != '')
                html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_companyName').val()+'</button>';
            if ($('#filter_calculation_method_id').val() != '')
                html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_calculation_method_id option:selected').text()+'</button>';
            if ($('#filter_period_start').val() != '')
                html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_period_start').val()+'</button>';
            if ($('#filter_period_end').val() != '')
                html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_period_end').val()+'</button>';
            if ($('#filter_companyFullName_en').val() != '')
                html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#filter_companyFullName_en').val()+'</button>';
            if ($('#filter_companyFullName_ar').val() != '')
                html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_companyFullName_ar').val()+'</button>';
            if ($('#filter_TaxNumber').val() != '')
                html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_TaxNumber').val()+'</button>';
            if ($('#filter_CreditNote_Letter').val() != '')
                html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_CreditNote_Letter').val()+'</button>';

            if ($('#filter_created_at').val() != '')
                html += '<button type="button" class="btn btn-outline-secondary btn-rounded">Created at: '+$('#filter_created_at').val()+'</button>';
            if ($('#filter_updated_at').val() != '')
                html += '<button type="button" class="btn btn-outline-success btn-rounded">Updated at: '+$('#filter_updated_at').val()+'</button>';

            if(html != '') {
                $('#edit_btn').show();
                $('#selectedCriteria').html(html);
            } else {
                $('#edit_btn').hide();
            }
        } else {
            alert('Select filter option');
        }
    });

    $('#reset').click(function () {

        $('#filter_companyName').val('');
        $('#filter_calculation_method_id').val('');
        $('#filter_period_start').val('');
        $('#filter_period_end').val('');
        $('#filter_period_end_input').val('');
        $('#filter_companyFullName_en').val('');
        $('#filter_companyFullName_ar').val('');
        $('#filter_TaxNumber').val('');
        $('#filter_CreditNote_Letter').val('');
        $('#filter_created_at').val('');
        $('#filter_updated_at').val('');


        $('#customer_data').DataTable().destroy();
        fill_datatable();
    });


    });


    function add() {
    // document.getElementById('response').innerHTML = loader;
    $('#edit_modal').modal('toggle');
    $.ajax({
        type: 'GET',
        url: "{{URL("/Company/create")}}",
        contentType: "html",
        dataType: 'html',
        success: function (data) {

            document.getElementById('response').innerHTML = data;
            var g = document.createElement('script');
            var s = document.getElementsByTagName('script')[0];
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

    </script>
@stop
@endsection
