@extends('layout2')
@section('content')
@section('title', __('users.bander_users'))
<style>
    .disabled {
        opacity: 0.5;
        pointer-events: none;
    }
    .inner-table {
        border-collapse: collapse;
        width: 100%;
    }
    .inner-table th {
        padding: 5px;
        background-color: #4CAF50;
    }
    .inner-table td {
        padding: 8px;
        border-bottom: 1px solid #dddddd;
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
    .inputBtns{
        width: 89%;
        margin: 5px;
        float: right;
    }
    /* td{
        vertical-align: middle !important;
        text-align: center ;
    } */
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
                                            <label for="country" class="form-label">{{__('users.name')}}</label>
                                            <input type="text" class="form-control" id="filter_user_name" name="filter_user_name">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('users.phone')}}</label>
                                            <input type="text" class="form-control" id="filter_phone" name="filter_phone">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('users.email')}}</label>
                                            <input type="email" class="form-control" id="filter_email" name="filter_email">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('users.identityNo')}}</label>
                                            <input type="text" class="form-control" id="filter_identityNo" name="filter_identityNo">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('users.user_type')}}</label>
                                            <select class="form-control" id="filter_user_type" name="filter_user_type" >
                                                <option value=""></option>
                                                @foreach ($lkp_user_type as $user_type)
                                                    <option value="{{$user_type->id}}">{{$user_type->user_type}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('users.role_name')}}</label>
                                            <select class="form-control" id="filter_role_name" name="filter_role_name" >
                                                <option value=""></option>
                                                @foreach ($roles as $role)
                                                    <option value="{{$role->id}}">{{$role->role_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('users.status')}}</label>
                                            <select class="form-control" id="filter_status" name="filter_status" >
                                                <option value=""></option>
                                                @foreach ($lkp_active as $lkp_status)
                                                    <option value="{{$lkp_status->id}}">{{$lkp_status->active_status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('users.created_at')}}</label>
                                        <input type="date" class="form-control" id="filter_created_at" name="filter_created_at">
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('users.updated_at')}}</label>
                                        <input type="date" class="form-control" id="filter_updated_at" name="filter_updated_at">
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
                <h5 class="modal-title" id="staticBackdropLabel">{{__('users.user')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
            </div> --}}

        </div>
    </div>
</div>
<div class="modal fade" id="delete_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('users.user')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="w3-container" action="" method="POST" id="delete_form">
                {{method_field('DELETE')}}
                @csrf
                <div class="modal-body">
                    <p>{{__('drivers.Delete_msg')}} <span id="delete_name"></span> ?</p>
                </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                      <button class="btn btn-danger" type="submit">{{__('drivers.Delete')}}</button>
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
                <div class="card-title">{{__('users.users')}}</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">{{__('users.users_des')}}</div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button>
                                <button type="button" class="btn btn-info" class="btn btn-info" type="button" onclick="add()"></i>{{__('users.add_user')}}</button>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered">
                            <thead>
                                <tr>
                                    <TH>Name</TH>
                                    <TH>{{__('users.phone')}}</TH>
                                    <TH>{{__('users.email')}}</TH>
                                    <TH>{{__('users.identityNo')}}</TH>
                                    <TH>{{__('users.user_type')}}</TH>
                                    <TH>{{__('users.role_name')}}</TH>
                                    <TH>{{__('users.status')}}</TH>
                                    <TH>{{__('users.created_at')}}</TH>
                                    <TH>{{__('users.action')}}</TH>
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
<input type="hidden" id="check" value="0">


@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        $(document).ready(function () {

            fill_datatable();
            function fill_datatable(filter_user_type = '', filter_user_name = '', filter_phone = '', filter_email = '', filter_identityNo = '', filter_role_name = '', filter_status = '', filter_created_at = '', filter_updated_at = '') {
                var dataTable = $('#customer_data').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    ajax: {
                        url: "{{ URL('New-Portal/Users') }}",
                        data: {
                            filter_screenId: 'Users',
                            filter_user_name: filter_user_name,
                            filter_phone: filter_phone,
                            filter_email: filter_email,
                            filter_identityNo: filter_identityNo,
                            filter_user_type: filter_user_type,
                            filter_role_name: filter_role_name,
                            filter_status: filter_status,
                            filter_created_at: filter_created_at,
                            filter_updated_at: filter_updated_at,
                        }
                    },

                    columns: [
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'IdentityNo',
                            name: 'IdentityNo'
                        },
                        {
                            data: 'user_type',
                            name: 'lkp_user_type.user_type'
                        },
                        {
                            data: 'role_name',
                            name: 'users_role.role_name'
                        },
                        {
                            data: 'active_id',
                            render: function (data, type, row, meta) {

                                if (data == "1") {
                                    return '<span class="label label-success">' + row.active_status + '</span>';
                                } else if (data == "0") {
                                    return '<span class="label label-danger">' + row.active_status + '</span>';
                                } else if (data == "3") {
                                    return '<span class="label label-warning">' + row.active_status + '</span>';
                                } else if (data == "4") {
                                    return '<span class="label label-default">' + row.active_status + '</span>';
                                } else if (data == "2") {
                                    return '<span class="label label-primary">' + row.active_status + '</span>';
                                }
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            "render": function (data, type, row, meta) {
                                let action = @json(__('drivers.Action'));
                                let view = @json(__('drivers.view'));
                                let edit = @json(__('drivers.edit'));
                                let deletee = @json(__('drivers.Delete'));
                                let reset_password = @json(__('drivers.reset_password'));

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
                                            <input type="hidden" id="IDs_all_` + meta.row + `" name="IDs_all_` + meta.row + `" value="` + row.id + `">` + `
                                            <a id=` + row.id + ` data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit dropdown-item" href="#">`+edit+`</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a id=` + row.id + ` class="dropdown-item resetpass" href="#">`+reset_password+` </a>
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
                            }
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
                    url: "{{URL('/Users')}}" + "/" + id,
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
                    url: "{{URL('/Users')}}" + "/" + id + "/edit/1",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.privilage', function (e) {
                e.preventDefault();
                // document.getElementById('response').innerHTML = loader;
                $('#edit_modal').modal('toggle');
                var id = $(this).attr('id');
                alert(id);
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/UsersPrivilage')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });

            });

            $('#customer_data tbody').on('click', '.resetpass', function (e) {
                e.preventDefault();
                // document.getElementById('response').innerHTML = loader;
                $('#edit_modal').modal('toggle');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/UserResetPass')}}" + "/" + id,
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
                document.getElementById('delete_form').action = "{{URL('/Users')}}" + "/" + id;
                $('#delete_modal').modal('toggle');

            });
            $('#filter').click(function () {
                if ($('#filter_user_name').val() != '' || $('#filter_phone').val() != '' || $('#filter_email').val() != '' || $('#filter_identityNo').val() != '' || $('#filter_user_type').val() != '' || $('#filter_role_name').val() != '' || $('#filter_status').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_user_type').val(), $('#filter_user_name').val(), $('#filter_phone').val(), $('#filter_email').val(), $('#filter_identityNo').val(), $('#filter_role_name').val(), $('#filter_status').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
                    let html = '';
                    if ($('#filter_user_type').val() > 0)
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_user_type option:selected').text()+'</button>';
                    if ($('#filter_user_name').val() != '')
                        html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_user_name').val()+'</button>';
                    if ($('#filter_phone').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_phone').val()+'</button>';
                    if ($('#filter_email').val() != '')
                        html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_email').val()+'</button>';
                    if ($('#filter_identityNo').val() != '')
                        html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#filter_identityNo').val()+'</button>';
                    if ($('#filter_role_name').val() > 0)
                        html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_role_name option:selected').text()+'</button>';
                    if ($('#filter_status').val() > 0)
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_status option:selected').text()+'</button>';
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

                    // $.ajax({
                    //     type: 'POST',
                    //     url: "{{URL("/New-Portal/UserDetails")}}",
                    //     cache: false,
                    //     data : {
                    //         filter_user_type: $('#filter_user_type').val(),
                    //         filter_user_name: $('#filter_user_name').val(),
                    //         filter_phone: $('#filter_phone').val(),
                    //         filter_email: $('#filter_email').val(),
                    //         filter_identityNo: $('#filter_identityNo').val(),
                    //         filter_role_name: $('#filter_role_name').val(),
                    //         filter_status: $('#filter_status').val(),
                    //         filter_created_at: $('#filter_created_at').val(),
                    //         filter_updated_at: $('#filter_updated_at').val(),
                    //         _token: "{{ csrf_token() }}",
                    //     },
                    //     success: function (data) {
                    //     //     $('#active_lbl').html(data.active);
                    //     //     $('#onhold_lbl').html(data.Onhold);
                    //     //     $('#terminated_lbl').html(data.Terminated);
                    //     //     $('#wrongWarehouse_lbl').html(data.wrongWarehouse);
                    //     // }
                    // });
                } else {
                    alert('Select filter option');
                }
            });
        });

        function add() {
            // document.getElementById('response').innerHTML = loader;
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL("/Users/create/1")}}",
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;
                }
            });
        }
        function validateForm() {
            //alert($("#contact_form").serializeArray());

            //e.preventDefault();
            //document.getElementById('response').innerHTML = loader;
            //$('#edit_modal').modal('toggle');

            var postData = $("#contact_form").serializeArray();
            //alert(postData);
            var formURL = $("#contact_form").attr("action");
            // document.getElementById('response').innerHTML = loader;
            $.ajax({
                url: formURL,
                type: "POST",
                cache: false,
                data: postData,
                success: function (data) {
                    document.getElementById('response').innerHTML = data;


                },
                error: function (jqXHR, status, error) {
                    document.getElementById('response').innerHTML ="<br><br><br>"+error+"<br><br><br>";
                    alert(status + ": " + error);
                }
            });


            return false;
        }

    var selected = [];
    function export_excel() {
        // $('#backButton').hide();
        $('#exportExcelBtn').prop('disabled', true);
        // $('.secondList').hide();
        $('#select_all_second').prop('checked', false);
        // $('#select_all').prop('checked', false);
        // $('.select_options').removeClass('active');
        $('#ExportExcel').modal('toggle');
    }
    function check_uncheck() {
        selected = [];
        var all_array = @json($array);
        $('#forwardBtn').removeClass('disabled');
        $('#reverseBtn').addClass('disabled');
        if ($('#select_all').prop('checked')) {
            $(".select_options").addClass("active");
            let i = 0;
            all_array.forEach(element => {
                selected.push({ id: i, name: element });
                i++;
            });
        } else {
            $(".select_options").removeClass("active");
        }
    }
    function check_uncheckSecond() {
        selected = [];
        $('#forwardBtn').addClass('disabled');
        $('#reverseBtn').removeClass('disabled');
        var second_array = @json($array);
        if ($('#select_all_second').prop('checked')) {
            $(".unselect_options").removeClass("active");
        } else {
            let i = 0;
            second_array.forEach(element => {
                selected.push({ id: i, name: element });
                i++;
            });
            $(".unselect_options").addClass("active");
        }
    }

    function selectOption(args, name) {
        $('#forwardBtn').removeClass('disabled');
        $('#reverseBtn').addClass('disabled');

        var option_id = 'option' + args;
        var optionElement = document.getElementById(option_id);
        if (!optionElement) {
            console.error('Element not found:', option_id);
            return;
        }
        if (optionElement.classList.contains('active')) {
            optionElement.classList.remove('active');
            selected = selected.filter(item => item.name !== name);
        } else {
            optionElement.classList.add('active');
            selected.push({ id: args, name: name });
        }
    }
    function selectOptionSecond(args, name) {
        $('#forwardBtn').addClass('disabled');
        $('#reverseBtn').removeClass('disabled');

        var option_id = 'option_' + args;
        var optionElement = document.getElementById(option_id);
        if (!optionElement) {
            console.error('Element not found:', option_id);
            return;
        }
        if (optionElement.classList.contains('active')) {
            optionElement.classList.remove('active');
            selected = selected.filter(item => item.name !== name);
        } else {
            optionElement.classList.add('active');
            selected.push({ id: args, name: name });
        }
    }

    function pushSelected() {
        $('#totalSelected').html(selected.length);
        let html = '';
        selected.forEach(element => {
            let id = element['id'];

            $('#option'+id).hide();
            let name = element['name'];
            html += `<li class="list-group-item active unselect_options"  id="option_`+id+`" onclick="selectOptionSecond('`+id+`', '`+name+`')" style="cursor: pointer;">`+name+`</li>`;
        });
        if (html != '') {
            $('#exportExcelBtn').prop('disabled', false);
            $('.secondList').show();
            $('#secondListContent').html(html);
        } else {
            $('#exportExcelBtn').prop('disabled', true);
            $('.secondList').hide();
            $('#secondListContent').html('');
        }
    }
    function popSelected() {
        $('#totalSelected').html(selected.length);
        $('.select_options').removeClass('active');
        $('.select_options').show();
        $('.unselect_options').hide();

        selected.forEach(element => {
            $('#option'+element['id']).addClass('active');
            $('#option'+element['id']).hide();
            $('#option_'+element['id']).show();
        });
    }
    // Export Excel button click event
    $('#exportExcelBtn').click(function() {
        var table = $('#customer_data').DataTable();
        $('#ExportExcel').modal('hide');
        var selectedColumns = [];
        console.log(selected);
        selected.forEach(element => {
            // if (element['id'] == 7) {
            //     let id  = element['id'] + 2;
            //     selectedColumns.push(id);
            // } else if (element['id'] == 8) {
            //     let id  = element['id'] + 3;
            //     selectedColumns.push(id);
            // } else {
                selectedColumns.push(element['id']);
            // }
        });
        var rowCount = table.rows().count();
        var rowCount = table.rows().count();
            var headerRow = selected.map(column => {
                var label = $('#' + column.id).siblings('label').text();
                return label ? label : column.name;
            });

            var exportData = [headerRow];
        var rowCount = table.rows().count();
        for (var i = 0; i < rowCount; i++) {
            var rowData = [];
            selectedColumns.forEach(function(columnId) {
                var cellData = table.cell(i, columnId).data();
                if (cellData == null) {
                    rowData.push('');
                } else {
                    rowData.push(cellData); // Or provide a placeholder value
                }
            });
            exportData.push(rowData);
        }
        if (exportData[0].length === 0) {
            alert('No columns selected for export!');
            return;
        }
        var ws = XLSX.utils.aoa_to_sheet(exportData);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        XLSX.writeFile(wb, 'Drivers.xlsx');
    });

    </script>
@stop
@endsection

