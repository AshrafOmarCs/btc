@extends('layout2')
@section('content')
@section('title', __('properties.properties'))

<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('properties.properties')}} </h5>
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
@php
$module = "BTC Properties";
@endphp
@include('new_porttal.partials.delete_modal')


<div class="modal fade" id="FillterButton" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> {{__('properties.Filter')}}</h5>
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
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('properties.referenceId')}}</label>
                                            <input type="text" class="form-control" name="filter_referenceId" id="filter_referenceId">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('properties.device_type')}}</label>
                                            <select id="filter_deviceType" name="filter_deviceType"class="form-control">
                                                <option value="">Select type</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('properties.delivery_approve')}}</label>
                                            <select class="form-control" name="filter_deliveryApprove" id="filter_deliveryApprove">
                                                <option value="">Select status</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('properties.created_by')}}</label>
                                            <select id="filter_createdBy" name="filter_createdBy" class="form-control">
                                                <option value="">Select employee</option>
                                                @foreach($employees as $emp)
                                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('properties.employee')}}</label>
                                            <select class="form-control" name="filter_emp" id="filter_emp">
                                                <option value="">Select employee</option>
                                                @foreach($assign_employees as $assign_employee)
                                                    <option value="{{$assign_employee->id}}">{{$assign_employee->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('properties.department')}}</label>
                                            <select id="filter_branch" name="filter_branch" class="form-control" >
                                                <option value="">Select branch</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->branches}}">{{$branch->branches}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('properties.status')}}</label>
                                            <select id="filter_status" name="filter_status" class="form-control">
                                                <option value="">Select status</option>
                                                <option value="1">Available</option>
                                                <option value="2">Delegated</option>
                                                <option value="3">Damaged</option>
                                            </select>
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
<div class="row">
    @include('new_porttal.partials.edit_btn')
</div>
<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('documents.documents')}}</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">{{__('documents.docx_description')}}</div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                <a href="javascript:add('cat');" class="btn btn-sm btn-info "><i class="bi bi-plus-square-fill"></i> {{__('properties.add_new_category')}}</a>
                                <a href="javascript:add('pro');" class="btn btn-sm btn-info "><i class="bi bi-plus-square-fill"></i> {{__('properties.add_new_device')}}</a>
                                <a href="javascript:add('assign');" class="btn btn-sm btn-info "><i class="bi bi-plus-square-fill"></i> {{__('properties.property_issuance')}}</a>
                                {{-- <button type="button" class="btn btn-success" class="btn btn-info" type="button" onclick="export_excel()"></i>{{__('drivers.ExportExcel')}}</button> --}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="show" id="option-2" value="emp_property" onclick="show_hide('emp_property')" checked>
                        <label class="form-check-label" for="option-2">{{__('properties.employee_property')}}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="show" id="option-1" value="devices" onclick="show_hide('devices')">
                        <label class="form-check-label" for="option-1">{{__('properties.devices')}}</label>
                    </div>

                    <div class="mt-3 table-responsive emp_property">
                        <table id="" class="customer_data table table-bordered table-striped">
                            <thead>
                                <th style="">{{__('properties.sr_no')}}</th>
                                <th style="">{{__('properties.employee')}}</th>
                                <th style="">{{__('properties.branch')}}</th>
                                <th style="">{{__('properties.referenceId')}}</th>
                                <th style="">{{__('properties.devices')}}</th>
                                <th style="">{{__('properties.created_by')}}</th>
                                <th style="">{{__('properties.created_at')}}</th>
                                <th style="">{{__('properties.procedure')}}</th>
                                <th style="">{{__('properties.action')}}</th>
                            </thead>
                            <tbody>
                                @php $no = 0; @endphp
                                @foreach($devices as $device)
                                <tr>
                                    <td>{{++$no}}</td>
                                    <td class="text-center">
                                        {{$device->user_name}}<br><br>
                                        <a id="{{$device->user_id}}" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="bi bi-eye-fill"></i> </a>
                                    </td>
                                    <td>{{$device->branches}}</td>
                                    <td>#{{strtoupper($device->reference_no)}}</td>
                                    <td>{!! $device->device_names !!}</td>
                                    <td>{{$device->assigned_by}}</td>
                                    <td>{{$device->assign_at}}</td>
                                    <td style="text-align: center">
                                        @if($device->delivery_timestamp != '')
                                            <span class="badge badge-success">Assignment Done</span>
                                        @elseif($device->admin_approval_by > 0)
                                            Awaiting <span style="color: #FF9800;">{{$device->user_name}}</span> Signature
                                        @else
                                            Awaiting <span style="color: #FF9800;">{{$device->assign_by}}</span> Approvel
                                        @endif
                                    </td>
                                    <td>
                                        {!! $device->action !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <th style="">{{__('properties.sr_no')}}</th>
                                <th style="">{{__('properties.employee')}}</th>
                                <th style="">{{__('properties.branch')}}</th>
                                <th style="">{{__('properties.referenceId')}}</th>
                                <th style="">{{__('properties.devices')}}</th>
                                <th style="">{{__('properties.created_by')}}</th>
                                <th style="">{{__('properties.created_at')}}</th>
                                <th style="">{{__('properties.procedure')}}</th>
                                <th style="">{{__('properties.action')}}</th>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-3 table-responsive devices" style="display: none">
                        <table id="customer_data" class="table table-bordered table-striped">
                            <thead>
                                <th style="">{{__('properties.sr_no')}}</th>
                                <th style="">{{__('properties.device')}}</th>
                                <th style="">{{__('properties.branch')}}</th>
                                <th style="">{{__('properties.total')}}</th>
                                <th style="">{{__('properties.available')}}</th>
                            </thead>
                            <tbody>
                                @php $no = 0; @endphp
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>@php echo $category->branches; @endphp</td>
                                    <td>
                                        {{$category->total}}
                                        @if($category->total > 0)
                                            <a id="{{$category->id}}" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green total_devices"> <i class="bi bi-eye-fill"></i> </a>
                                        @endif
                                    </td>
                                    <td>
                                        {{$category->available}}
                                        @if($category->available > 0)
                                            <a id="{{$category->id}}" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green available_devices"> <i class="bi bi-eye-fill"></i> </a>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <th style="">{{__('properties.sr_no')}}</th>
                                <th style="">{{__('properties.device')}}</th>
                                <th style="">{{__('properties.branch')}}</th>
                                <th style="">{{__('properties.total')}}</th>
                                <th style="">{{__('properties.available')}}</th>
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


@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        function devices_confirmation(reference_no) {
            // document.getElementById('response').innerHTML = loader;

            // document.getElementById('edit_modal').style.display = 'block';
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'POST',
                url: "{{URL("/PropertyIssuance/device_confirmation")}}",
                data: {
                    reference_no: reference_no,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }
        function get_devices(user_id) {
            // document.getElementById('response').innerHTML = loader;
            // document.getElementById('edit_modal').style.display = 'block';
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'POST',
                url: "{{URL("/PropertyIssuance/get_back_devices")}}",
                data: {
                    user_id: user_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }
        $(document).ready(function () {
            $('.customer_data').DataTable({
    	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'lBfrtip',
                autoWidth: false,
                "buttons": [
                    {
                        extend: 'excel',
                        text: '{{__('properties.export_excel')}}',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                order: 'applied'
                            }
                        }
                    },
                    {
                        extend: 'pdf', // Add PDF export button
                        text: '{{__('properties.export_pdf')}}',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                order: 'applied'
                            }
                        }
                    }
                ],
                // responsive: true,
                processing: true,
                "pagingType": "full_numbers",
    	    });
            $('.customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                // document.getElementById('response').innerHTML = loader;
                // document.getElementById('edit_modal').style.display = 'block';
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
            $('#customer_data').DataTable({
    	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'lBfrtip',
                autoWidth: false,
                "buttons": [
                    {
                        extend: 'excel',
                        text: '{{__('properties.export_excel')}}',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                order: 'applied'
                            }
                        }
                    },
                    {
                        extend: 'pdf', // Add PDF export button
                        text: '{{__('properties.export_pdf')}}',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                order: 'applied'
                            }
                        }
                    }
                ],
                // responsive: true,
                processing: true,
                "pagingType": "full_numbers",
    	    });
            $('#customer_data tbody').on('click', '.total_devices', function (e) {
                e.preventDefault();
                // document.getElementById('response').innerHTML = loader;
                // document.getElementById('edit_modal').style.display = 'block';
                $('#edit_modal').modal('toggle');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "https://btcdmins.com/total_devices" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.available_devices', function (e) {
                e.preventDefault();
                // document.getElementById('response').innerHTML = loader;
                // document.getElementById('edit_modal').style.display = 'block';
                $('#edit_modal').modal('toggle');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "https://btcdmins.com/available_devices" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });


            $('#reset').click(function () {

                $('#filter_companyName').val('');

            });


        });
            $('#filter').click(function () {
                if ($('#filter_referenceId').val() != '' || $('#filter_deviceType').val() != '' || $('#filter_deliveryApprove').val() != '' || $('#filter_createdBy').val() != '' || $('#filter_emp').val() != '' || $('#filter_branch').val() != '' || $('#filter_status').val() != '') {
                    // card_change();
                    $('#pre_loader_build').show();
                    $.ajax({
                        type: 'POST',
                        url: "{{URL("/PropertyIssuance/filter_devices")}}",
                        data: {
                            filter_referenceId: $('#filter_referenceId').val(),
                            filter_deviceType: $('#filter_deviceType').val(),
                            filter_deliveryApprove: $('#filter_deliveryApprove').val(),
                            filter_createdBy: $('#filter_createdBy').val(),
                            filter_emp: $('#filter_emp').val(),
                            filter_branch: $('#filter_branch').val(),
                            filter_status: $('#filter_status').val(),
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            data = data.split(":::");

                            // Clear and destroy #customer_data DataTable
                            var customerDataTable = $('#customer_data').DataTable();
                            customerDataTable.clear().destroy();

                            // Clear and destroy .customer_data DataTable
                            var customerDataClassTable = $('.customer_data').DataTable();
                            customerDataClassTable.clear().destroy();

                            // Reinitialize DataTables and add new data
                            $('#customer_data').DataTable().rows.add($(data[0])).draw();
                            $('.customer_data').DataTable().rows.add($(data[1])).draw();
                            $('#pre_loader_build').hide();

                            let html = '';
                            if ($('#filter_deviceType').val() > 0)
                                html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_deviceType option:selected').text()+'</button>';
                            if ($('#filter_deliveryApprove').val() > 0)
                                html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_deliveryApprove option:selected').text()+'</button>';
                            if ($('#filter_referenceId').val() != '')
                                html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_referenceId').val()+'</button>';
                            if ($('#filter_createdBy').val() != '')
                                html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_createdBy option:selected').val()+'</button>';
                            if ($('#filter_emp').val() != '')
                                html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#filter_emp option:selected').val()+'</button>';
                            if ($('#filter_branch').val() != '')
                                html += '<button type="button" class="btn btn-outline-info btn-rounded">'+$('#filter_branch option:selected').val()+'</button>';
                            if ($('#filter_status').val() > 0)
                                html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_status option:selected').text()+'</button>';

                            if(html != '') {
                                $('#edit_btn').show();
                                $('#selectedCriteria').html(html);
                            } else {
                                $('#edit_btn').hide();
                            }
                            $('#active_lbl').html(data.active);
                            $('#onhold_lbl').html(data.Onhold);
                            $('#terminated_lbl').html(data.Terminated);
                            $('#wrongWarehouse_lbl').html(data.wrongWarehouse);
                        }
                    });

                } else {
                    alert('Select filter option');
                }
            });


        function add(type) {
            // document.getElementById('response').innerHTML = loader;
            // document.getElementById('edit_modal').style.display = 'block';
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'POST',
                url: "{{URL("/PropertyIssuance/create")}}",
                data: {
                    type: type,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }
        function edit_record(id, type, name = '') {
            if(type == 'cat') {
                $('#button-addon2').html('Update');
                $('#cat_id').val(id);
                $('#name').val(name);
            } else {
                // document.getElementById('response').innerHTML = loader;
                // document.getElementById('edit_modal').style.display = 'block';
                $('#edit_modal').modal('toggle');
                $.ajax({
                    type: 'POST',
                    url: "{{URL("/PropertyIssuance/getRecord")}}",
                    data: {
                        id: id,
                        type: type,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;
                    }
                });
            }
        }
        function delete_record(id, type = '')
        {
            if(type == 'pro')
                document.getElementById('delete_form').action = "{{URL('/PropertyIssuance/delete')}}" + "/" + id;
            else
                document.getElementById('delete_form').action = "{{URL('/PropertyIssuance/cat_delete')}}" + "/" + id;
            // document.getElementById('delete_modal').style.display = 'block';
            $('#delete_modal').modal('toggle');
        }


        function show_hide(type) {
            if (type == 'devices') {
                $('.devices').show();
                $('.emp_property').hide();
            } else if (type == 'emp_property') {
                $('.devices').hide();
                $('.emp_property').show();
            }
        }
        function add_new_branch(branch) {
            $('#new_branch').hide();
            $("#new_branches").prop('required',false);
            if(branch == 'other') {
                $('#new_branch').show();
                $("#new_branches").prop('required',true);
            }
        }
        function disableEnterKey(event) {
            if (event.keyCode === 13 && event.target.tagName !== 'TEXTAREA') {
                event.preventDefault(); // Prevent Enter key behavior for other form fields
            }
        }
    </script>
@stop
@endsection
