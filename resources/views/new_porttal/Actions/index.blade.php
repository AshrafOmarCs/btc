@extends('layout2')
@section('content')
@section('title', 'Ticketing System')

<div class="modal fade" id="addNewTicket" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <form id="ticketForm" method="POST" action="{{ route('Requires_action/post')}}">
            @csrf
            <input type="hidden" name="ticket_id" id="ticket_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollableLabel">Add new Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="m-0">
                                        <label class="form-label">Subject <font color="red">*</font></label>
                                        <input type="text" class="form-control" name="subject" id="subject" value="" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="m-0">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" id="description" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="m-0">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="">Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Closed">Closed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="m-0">
                                        <label class="form-label">Priority</label>
                                        <select name="priority" class="form-control" id="priority">
                                            <option value="">Select Priority</option>
                                            <option value="Low">Low</option>
                                            <option value="Medium">Medium</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="m-0">
                                        <label class="form-label">Assign To</label><br>
                                        <select class="select-multiple js-states form-control" style="width: 100%" name="assign_ids[]" id="assign_ids" title="Select Product Category"
                                            multiple="multiple">
                                            @foreach ($employees as $emp)
                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>

    </div>
</div>
<!--End Modal addNewTicket 3 -->
@php
$array = [
    0=>'Sr.no',
    1=>'Requester',
    2=>'Subject',
    3=>'Status',
    4=>'Priority',
    5=>'Assignee',
    6=>'Create at',
];
$module = "Ticket";
@endphp
@include('new_porttal.partials.delete_modal')
@include('new_porttal.partials.export_excel')
<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Accept Settlement(s) </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>

        </div>
    </div>
</div>
 <!-- Row start -->
 <div class="row">
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-blue">
                <i class="bi bi-ticket"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-blue total_count">15 </h3>
                <p>Total No.of Tickets</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-red">
                <i class="bi bi-ticket-detailed"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-red new_count" style="font-size: 19px;">10 </h3>
                <p>New Tickets</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-green">
                <i class="bi bi-ticket-detailed-fill"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-green closed_count"> 5 </h3>
                <p>Closed Tickets</p>
            </div>
        </div>
    </div>
    {{-- <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-yellow">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-yellow" id="wrongWarehouse_lbl"> </h3>
                <p>{{__('drivers.WrongWarehouse')}}</p>
            </div>
        </div>
    </div> --}}
</div>
<!-- Row end -->


<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ticketing Management</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">The updates about the Support Tickets</div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-primary" onclick="editTicket(0)" data-bs-toggle="modal" type="button" data-bs-target="#addNewTicket"></i>Add New Ticket</button>
                                <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="text-center" id="loader" style="display:none;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <!-- Row start -->
                    <div class="row">
                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="custom-tabs-container">
                                        <ul class="nav nav-tabs" id="customTab2" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab"
                                                    aria-controls="oneA" aria-selected="true">Total <span class="badge shade-blue total_count"></span></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="tab-twoA" data-bs-toggle="tab" href="#twoA" role="tab"
                                                    aria-controls="twoA" aria-selected="false">New<span
                                                        class="badge shade-red new_count"></span></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="tab-threeA" data-bs-toggle="tab" href="#threeA" role="tab"
                                                    aria-controls="threeA" aria-selected="false">Closed<span
                                                        class="badge shade-green closed_count"></span></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="customTabContent2">
                                            <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered v-middle m-0 customer_data" id="customer_data">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr. No</th>
                                                                <th>Requester Name</th>
                                                                <th>Subject</th>
                                                                <th>Status</th>
                                                                <th>Priority</th>
                                                                <th>Assignee</th>
                                                                <th>Create Date</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $i = 1;
                                                            $total = 0;
                                                            foreach ($actions as $action) {
                                                                $total++;
                                                                $assigns = array();
                                                                if($action->assign_ids != '') {
                                                                    $assign_ids = explode(',', $action->assign_ids);
                                                                    foreach ($employees as $emp) {
                                                                        if(in_array($emp->id, $assign_ids)) {
                                                                            $assigns[] = $emp->name;
                                                                        }
                                                                    }
                                                                }
                                                                if($action->priority == 'High')
                                                                    $priority = 'red';
                                                                else if($action->priority == 'Medium')
                                                                    $priority = 'yellow';
                                                                else if($action->priority == 'Low')
                                                                    $priority = 'blue';
                                                            @endphp
                                                                <tr>
                                                                    <td>
                                                                        {{$i++}}
                                                                    </td>
                                                                    <td>
                                                                        <div class="media-box">
                                                                            @if(AUTH::user()->profile_pic == '')
                                                                                <img src="/dashboard/assets/logos/user.png" class="media-avatar" alt="Bootstrap Themes" />
                                                                            @else
                                                                                <img src="/storage/images/{{AUTH::user()->profile_pic}}" class="media-avatar" alt="Bootstrap Themes" />
                                                                            @endif
                                                                            <div class="media-box-body">
                                                                                <div class="text-truncate">{{$action->name}}</div>
                                                                                <p>Role: {{ucfirst($action->role_name)}}</p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{$action->module}}</td>
                                                                    <td>
                                                                        <span class="badge shade-{{$action->status == 'Active' ? 'red' : 'green'}} min-70">{{$action->status == 'Active' ? 'Active' : 'Closed'}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge shade-{{$priority}} min-70">{{$action->priority}}</span>
                                                                    </td>
                                                                    <td>{{implode(',', $assigns)}}</td>
                                                                    <td>{{$action->created_at}}</td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                                                            aria-expanded="false">Action</button>
                                                                            <ul class="dropdown-menu">
                                                                                @if($action->ids != '')
                                                                                    @if($action->status != 'Closed')
                                                                                        <li><a onclick="accept_modal({{$action->id}})" href="#"><span style="color:green; padding-left: 10px">Accept</span></a></li>
                                                                                    @endif
                                                                                @else
                                                                                    <li>
                                                                                        <a href="Requires_action/comments/{{$action->id}}" data-bs-target="" style="padding-left: 10px">Comments</a>
                                                                                    </li>
                                                                                @endif
                                                                                <li>
                                                                                    <hr class="dropdown-divider">
                                                                                </li>

                                                                                @if(Auth::user()->user_type_id==1)
                                                                                    <li><a id={{$action->id}} class="delete" href="#"><span style="color:red; padding-left: 10px">Delete</span></a></li>
                                                                                    <li>
                                                                                        <hr class="dropdown-divider">
                                                                                    </li>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @php } @endphp
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="twoA" role="tabpanel">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered v-middle m-0 customer_data">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr. No</th>
                                                                <th>Requester Name</th>
                                                                <th>Subject</th>
                                                                <th>Status</th>
                                                                <th>Priority</th>
                                                                <th>Assignee</th>
                                                                <th>Create Date</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $i = 1;
                                                            $new_total = 0;
                                                            foreach ($actions as $action) {
                                                                if ($action->status == 'Closed') {
                                                                    continue;
                                                                }
                                                                $new_total++;
                                                                $assigns = [];
                                                                if($action->assign_ids != '') {
                                                                    $assign_ids = explode(',', $action->assign_ids);
                                                                    foreach ($employees as $emp) {
                                                                        if(in_array($emp->id, $assign_ids)) {
                                                                            $assigns[] = $emp->name;
                                                                        }
                                                                    }
                                                                }
                                                                if($action->priority == 'High')
                                                                    $priority = 'red';
                                                                else if($action->priority == 'Medium')
                                                                    $priority = 'yellow';
                                                                else if($action->priority == 'Low')
                                                                    $priority = 'blue';
                                                            @endphp
                                                                <tr>
                                                                    <td>
                                                                        {{$i++}}
                                                                    </td>
                                                                    <td>
                                                                        <div class="media-box">
                                                                            @if(AUTH::user()->profile_pic == '')
                                                                                <img src="/dashboard/assets/logos/user.png" class="media-avatar" alt="Bootstrap Themes" />
                                                                            @else
                                                                                <img src="/storage/images/{{AUTH::user()->profile_pic}}" class="media-avatar" alt="Bootstrap Themes" />
                                                                            @endif
                                                                            <div class="media-box-body">
                                                                                <div class="text-truncate">{{$action->name}}</div>
                                                                                <p>Role: {{ucfirst($action->role_name)}}</p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{$action->module}}</td>
                                                                    <td>
                                                                        <span class="badge shade-red min-70">Active</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge shade-{{$priority}} min-70">{{$action->priority}}</span>
                                                                    </td>
                                                                    <td>{{implode(',', $assigns)}}</td>
                                                                    <td>{{$action->created_at}}</td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                                                            aria-expanded="false">Action</button>
                                                                            <ul class="dropdown-menu">
                                                                                @if($action->ids != '')
                                                                                <li><a onclick="accept_modal({{$action->id}})" href="#"><span style="color:green; padding-left: 10px">Accept</span></a></li>
                                                                                @else
                                                                                    <li>
                                                                                        <a href="Requires_action/comments/{{$action->id}}" style="padding-left: 10px">Comments</a>
                                                                                    </li>
                                                                                @endif
                                                                                <li>
                                                                                    <hr class="dropdown-divider">
                                                                                </li>

                                                                                @if(Auth::user()->user_type_id==1)
                                                                                    <li><a id={{$action->id}} class="delete" href="#"><span style="color:red; padding-left: 10px">Delete</span></a></li>
                                                                                    <li>
                                                                                        <hr class="dropdown-divider">
                                                                                    </li>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @php } @endphp
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="threeA" role="tabpanel">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered v-middle m-0 customer_data">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr. No</th>
                                                                <th>Requester Name</th>
                                                                <th>Subject</th>
                                                                <th>Status</th>
                                                                <th>Priority</th>
                                                                <th>Assignee</th>
                                                                <th>Create Date</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $i = 1;
                                                            $closed_total = 0;
                                                            foreach ($actions as $action) {
                                                                if ($action->status == 'Active') {
                                                                    continue;
                                                                }
                                                                $closed_total++;
                                                                $assigns = array();
                                                                if($action->assign_ids != '') {
                                                                    $assign_ids = explode(',', $action->assign_ids);
                                                                    foreach ($employees as $emp) {
                                                                        if(in_array($emp->id, $assign_ids)) {
                                                                            $assigns[] = $emp->name;
                                                                        }
                                                                    }
                                                                }
                                                                if($action->priority == 'High')
                                                                    $priority = 'red';
                                                                else if($action->priority == 'Medium')
                                                                    $priority = 'yellow';
                                                                else if($action->priority == 'Low')
                                                                    $priority = 'blue';
                                                            @endphp
                                                                <tr>
                                                                    <td>
                                                                        {{$i++}}
                                                                    </td>
                                                                    <td>
                                                                        <div class="media-box">
                                                                            @if(AUTH::user()->profile_pic == '')
                                                                                <img src="/dashboard/assets/logos/user.png" class="media-avatar" alt="Bootstrap Themes" />
                                                                            @else
                                                                                <img src="/storage/images/{{AUTH::user()->profile_pic}}" class="media-avatar" alt="Bootstrap Themes" />
                                                                            @endif
                                                                            <div class="media-box-body">
                                                                                <div class="text-truncate">{{$action->name}}</div>
                                                                                <p>Role: {{ucfirst($action->role_name)}}</p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{$action->module}}</td>
                                                                    <td>
                                                                        <span class="badge shade-green min-70">Closed</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge shade-{{$priority}} min-70">{{$action->priority}}</span>
                                                                    </td>
                                                                    <td>{{implode(', ', $assigns)}}</td>
                                                                    <td>{{$action->created_at}}</td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                                                            aria-expanded="false">Action</button>
                                                                            <ul class="dropdown-menu">
                                                                                @if($action->ids != '')

                                                                                @else
                                                                                    <li>
                                                                                        <a href="Requires_action/comments/{{$action->id}}" style="padding-left: 10px">Comments</a>
                                                                                    </li>
                                                                                @endif
                                                                                <li>
                                                                                    <hr class="dropdown-divider">
                                                                                </li>

                                                                                @if(Auth::user()->user_type_id==1)
                                                                                    <li><a id={{$action->id}} class="delete" href="#"><span style="color:red; padding-left: 10px">Delete</span></a></li>
                                                                                    <li>
                                                                                        <hr class="dropdown-divider">
                                                                                    </li>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @php } @endphp
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->
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
        const tabs = document.querySelectorAll("#customTab2 .nav-item .nav-link");
        const loader = document.getElementById("loader");
        tabs.forEach(tab => {
            tab.addEventListener("click", function(event) {
                event.preventDefault();
                loader.style.display = "block";
                $('.customer_data').hide();
                setTimeout(() => {
                    loader.style.display = "none";
                    $('.customer_data').show();
                }, 1000);
            });
        });
        function editTicket(id) {
            if (id == 0) {
                $('#ticket_id').val(0);
                $('#subject').val('');
                $('#description').val('');
                $('#status').val('');
                $('#priority').val('');
                const myArray = [];
                $('#assign_ids').val(myArray).trigger('change');
            } else {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('Requires_action.edit') }}",
                    data: {
                        id : id
                    },
                    success: function(response) {
                        response = response.split(":::");
                        $('#ticket_id').val(id);
                        $('#subject').val(response[0]);
                        $('#description').val(response[1]);
                        $('#status').val(response[2]);
                        $('#priority').val(response[3]);
                        const myArray = response[4].split(",");
                        $('#assign_ids').val(myArray).trigger('change');
                    },
                    error: function(xhr) {
                        alert(xhr);
                    }
                });
            }
        }
        function accept_modal(id) {

            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL('/automation/get')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                    $('.show_table_data').DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                        dom: 'lBfrtip',
                        bAutoWidth: false,
                        "buttons": [
                            {
                                extend: 'excel',
                                text: 'Export to Excel',
                                exportOptions: {
                                    modifier: {
                                        search: 'applied',
                                        order: 'applied'
                                    }
                                },

                            }
                        ],
                        responsive: true,
                        processing: true,
                        "pagingType": "full_numbers",
                        "autoWidth": false,
                    });
                }
            });
        }
        $(document).ready(function () {
            $('.closed_count').html({{$closed_total}});
            $('.new_count').html({{$new_total}});
            $('.total_count').html({{$total}});
            fill_datatable();

            function fill_datatable() {
                var dataTable = $('.customer_data').DataTable({
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
                    // serverSide: true,
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    // ajax: {
                    //     url: "{{ URL('New-Portal/DriversJahiz') }}",
                    //     data: {
                    //         filter_screenId: 'Jahiz',
                    //         filter_companyId: filter_companyId,
                    //         filter_warehouseId: filter_warehouseId,
                    //         filter_fullName: filter_fullName,
                    //         filter_mobileNumber: filter_mobileNumber,
                    //         filter_iqama: filter_iqama,
                    //         filter_job_id: filter_job_id,
                    //         filter_status_id: filter_status_id,
                    //         filter_account_owner_iqama: filter_account_owner_iqama,
                    //         filter_accountNumber: filter_accountNumber,
                    //         filter_driver_type_id, filter_driver_type_id,
                    //         filter_claim_dt: filter_claim_dt,
                    //         filter_SANED_SettledDate: filter_SANED_SettledDate,
                    //         filter_jahiz_clearing_updated_at: filter_jahiz_clearing_updated_at,
                    //         filter_created_at: filter_created_at,
                    //         filter_collectionAmount: filter_collectionAmount,
                    //         filter_updated_at: filter_updated_at,
                    //         filter_Image_Identity: filter_Image_Identity,
                    //         filter_Image_Passport: filter_Image_Passport,
                    //         filter_Image_DrivingLicence: filter_Image_DrivingLicence,
                    //         filter_Image_VehiclesRegistration: filter_Image_VehiclesRegistration,
                    //         filter_Image_JobContract: filter_Image_JobContract,
                    //         filter_Image_PromissoryNote: filter_Image_PromissoryNote,
                    //     }
                    // },

                    // columns: [
                    //     {
                    //         data: 'warehouseName',
                    //         name: 'warehouse.warehouseName',
                    //         //visible:false
                    //     },
                    //     {
                    //         data: 'driver_type',
                    //         name: 'lkp_driver_type.driver_type',
                    //     },
                    //     {
                    //         //className: "dt-nowrap",
                    //         data: 'fullName',
                    //         name: 'fullName'
                    //     },
                    //     {
                    //         data: 'actualName',
                    //         name: 'actualName'
                    //     },

                    //     {
                    //         data: 'mobileNumber',
                    //         name: 'mobileNumber'
                    //     },
                    //     {
                    //         data: 'accountNumber',
                    //         name: 'accountNumber'
                    //     },

                    //     {
                    //         data: 'job_id',
                    //         name: 'job_id'
                    //     },
                    //     {
                    //         data: 'driver_status_en',
                    //         name: 'lkp_driver_status.driver_status_en',
                    //         render: function (data, type, row, meta) {
                    //             if (row.status_id == "1") {
                    //                 return '<span class="badge badge-success">' + row.driver_status_en + '</span>';
                    //             } else if (row.status_id == "2") {
                    //                 return '<span class="badge badge-warning">' + row.driver_status_en + '</span>';
                    //             } else if (row.status_id == "3") {
                    //                 return '<span class="badge badge-danger">' + row.driver_status_en + '</span>';
                    //             } else if (row.status_id == "4") {
                    //                 return '<span class="badge badge-secondary">' + row.driver_status_en + '</span>';
                    //             } else if (row.status_id == "5") {
                    //                 return '<span class="badge badge-danger">' + row.driver_status_en + '</span>';
                    //             }
                    //         }
                    //     },

                    //     {
                    //         "searchable": false,
                    //         data: 'per_priod',
                    //         name: 'per_priod'
                    //     },
                    //     {
                    //         "searchable": false,
                    //         data: 'cur_priod',
                    //         name: 'cur_priod'
                    //     },
                    //     {
                    //         "searchable": false,
                    //         data: 'SANED_amount',
                    //         name: 'SANED_amount',
                    //         render: function (data, type, row, meta) {
                    //             if (row.SANED_amount == null)
                    //                 return '';
                    //             else if (row.SANED_amount != row.Jahiz_Amount) {
                    //                 return '<span class="red_color">' + row.SANED_amount + '</span>';
                    //             } else if (row.SANED_amount == null)
                    //                 return '';
                    //             else
                    //                 return row.SANED_amount;
                    //         }
                    //     },

                    //     {
                    //         "searchable": false,
                    //         data: 'SANED_SettledDate',
                    //         name: 'SANED_SettledDate'
                    //     },
                    //     {
                    //         "searchable": false,
                    //         data: 'Jahiz_Amount',
                    //         name: 'Jahiz_Amount',
                    //         render: function (data, type, row, meta) {
                    //             if (row.Jahiz_Amount == null)
                    //                 return '';
                    //             else if (row.SANED_amount != row.Jahiz_Amount) {
                    //                 return '<span class="red_color">' + row.Jahiz_Amount + '</span>';
                    //             } else
                    //                 return row.Jahiz_Amount;


                    //         }
                    //     },
                    //     {
                    //         "searchable": false,
                    //         data: 'Last_Clear',
                    //         name: 'Last_Clear'
                    //     },
                    //     {
                    //         className: "table-success",
                    //         "searchable": false,
                    //         data: 'amount',
                    //         name: 'amount'
                    //     },
                    //     {
                    //         className: "table-danger",
                    //         "searchable": false,
                    //         data: 'Claim_After',
                    //         name: 'Claim_After'
                    //     },
                    //     {
                    //         data: 'openBalance',
                    //         name: 'openBalance'
                    //     },
                    //     {
                    //         "searchable": false,
                    //         data: 'created_at2',
                    //         name: 'created_at2'
                    //     },
                    //     {
                    //         "orderable": false,
                    //         className: "dt-nowrap",
                    //         "targets": -1,
                    //         //"data": 'id',
                    //         "render": function (data, type, row, meta) {
                    //             // <button type="button" class="btn btn-light"><i class="bi bi-list text-green"></i> </button>
                    //             let action = @json(__('drivers.Action'));
                    //             let view = @json(__('drivers.view'));
                    //             let edit = @json(__('drivers.edit'));
                    //             let reset_password = @json(__('drivers.reset_password'));
                    //             let attachment = @json(__('drivers.attachment'));
                    //             let report_driver = @json(__('drivers.report_driver'));
                    //             let statement = @json(__('drivers.statement'));
                    //             let deletee = @json(__('drivers.Delete'));
                    //             let Issuingdocuments = @json(__('drivers.Issuingdocuments'));

                    //             let html = `
                    //             <div class="btn-group">
                    //                 <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                    //                 aria-expanded="false">
                    //                 `+action+`
                    //                 </button>
                    //                 <ul class="dropdown-menu">
                    //                     <li>
                    //                         <a id=` + row.id + ` data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view dropdown-item" href="#">`+view+`</a>
                    //                     </li>
                    //                     <li>
                    //                         <hr class="dropdown-divider">
                    //                     </li>
                    //                     <li>
                    //                         <input type="hidden" id="IDs_all_` + meta.row + `" name="IDs_all_` + meta.row + `" value="` + row.id + `">` + `
                    //                         <a id=` + row.id + ` data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit dropdown-item" href="#">`+edit+`</a>
                    //                     </li>
                    //                     <li>
                    //                         <hr class="dropdown-divider">
                    //                     </li>`;
                    //                     @if(Auth::user()->user_type_id==1)
                    //                         html += `<li><a id=` + row.id + ` data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete dropdown-item" href="#"><span style="color:red">`+deletee+`</span></a></li>
                    //                         <li>
                    //                             <hr class="dropdown-divider">
                    //                         </li>
                    //                         `;
                    //                     @endif
                    //                     html += `<li><a id=` + row.id + ` data-original-title="Attachment" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue Attachment dropdown-item" href="#">`+attachment+`</a></li>
                    //                     <li>
                    //                         <hr class="dropdown-divider">
                    //                     </li>
                    //                     <li>
                    //                         <a id=` + row.id + ` data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement">`+statement+`</a>
                    //                     </li>
                    //                     <li>
                    //                         <hr class="dropdown-divider">
                    //                     </li>`;

                    //                     if(row.driver_type_id == null){
                    //                         html += `<li><a id=` + row.id+ ` data-original-title="Update Driver Type To Issuing documents"  disabled data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue documents">Issuing documents </a></li>`;
                    //                     } else {
                    //                         html += '<li><a id=' + row.id+ ' data-original-title="Issuing documents" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue documents">'+Issuingdocuments+'</a></li>';
                    //                     }

                    //                     html += `<li>
                    //                         <hr class="dropdown-divider">
                    //                     </li>`;
                    //                     @if (Auth::user()->user_type_id == 1)
                    //                     if (row.warehouseId == '201' || row.warehouseId == '220' || row.warehouseId == '221') {
                    //                         html += '<li><a id=' + row.id + ' data-original-title="Issuing documents" data-toggle="tooltip" data-placement="top" class=" btnaction btn menu-icon vd_bd-blue vd_blue DriversSettlementList">تصفية</a><li>';
                    //                     }
                    //                     @endif
                    //                     html += `<li>
                    //                         <hr class="dropdown-divider">
                    //                     </li>
                    //                 </ul>
                    //             </div>`;
                    //             return html;
                    //         }
                    //     },
                    // ]
                });

            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = "loading";
                // document.getElementById('edit_modal').style.display = 'block';
                $('#edit_modal').modal('toggle');
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
                $('#edit_modal').modal('toggle');
                document.getElementById('response').innerHTML = "loading";

                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/Drivers')}}" + "/" + id + "/edit/2",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;
                        // $('#vehicle_id').select2({
                        //     dropdownParent: $('#edit_modal')
                        // });
                    }
                });
            });

            $('.customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('New-Portal/Requires_action')}}" + "/" + id;
                $('#delete_modal').modal('toggle');
            });


        });
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
        // Export Excel button click event
        $('#exportExcelBtn').click(function() {
            var table = $('#customer_data').DataTable();
            $('#ExportExcel').modal('hide');
            var selectedColumns = [];
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
            var headerRow = selected.map(obj => {
                var label = obj['name'];
                return label ? label : '';
            });
            var exportData = [headerRow];

            // var exportData = [selectedColumns.map(columnId => $('#' + columnId).siblings('label').text())];
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
            XLSX.writeFile(wb, 'Tickets.xlsx');
        });
    </script>
@stop
@endsection

