@extends('layout2')
@section('content')
@section('title', __('contractsQuotation.contracts_quotation'))

<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('contractsQuotation.contracts_quotation')}}</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;"></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <a href="javascript:add('Contract');" class="btn btn-sm btn-info "><i class="bi bi-plus-circle-fill"></i> {{__('contractsQuotation.add_new_contract')}}</a>
                                <a href="javascript:add('Quotation');" class="btn btn-sm btn-info "><i class="bi bi-plus-circle-fill"></i>{{__('contractsQuotation.add_new_quotation')}}</a>
                                {{-- <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button>
                                <button type="button" class="btn btn-info" class="btn btn-info" type="button" onclick="add()"></i>{{__('users.add_user')}}</button> --}}

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:5%">{{__('contractsQuotation.sr_no')}}</th>
                                    <TH style="width:10%">{{__('contractsQuotation.company_name_en')}}</TH>
                                    <TH style="width:10%">{{__('contractsQuotation.company_name_ar')}}</TH>
                                    <TH style="width:10%">{{__('contractsQuotation.company_email')}}</TH>
                                    <TH style="width:5%">{{__('contractsQuotation.type')}}</TH>
                                    <TH style="width:10%">{{__('contractsQuotation.signature_date')}}</TH>
                                    <TH style="width:5%">{{__('contractsQuotation.representative')}}</TH>
                                    <TH style="width:5%">{{__('contractsQuotation.start_date')}}</TH>
                                    <TH style="width:5%">{{__('contractsQuotation.end_date')}}</TH>
                                    <TH style="width:35%">{{__('contractsQuotation.approve')}}</TH>
                                    <TH style="width:5%">{{__('contractsQuotation.status')}}</TH>
                                    <TH style="width:5%">{{__('contractsQuotation.procedure')}}</TH>
                                    <TH style="width:5%">{{__('contractsQuotation.issued_by')}}</TH>
                                    <TH style="width:5%">{{__('contractsQuotation.action')}}</TH>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 0; @endphp
                                @foreach($contracts as $contract)
                                    @php $reject_check = "false"; $company_check = "false"; @endphp
                                <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{$contract->companyName}}</td>
                                    <td>{{$contract->companyName_ar}}</td>
                                    <td>{{$contract->companyEmail}}</td>
                                    <td>{{ucfirst($contract->type)}}</td>
                                    <td>@if($contract->cont_end_date != '') {{$contract->signature_date}} @else N/A @endif</td>
                                    <td>@if($contract->cont_end_date != '') {{$contract->info_person_name}} ({{$contract->info_person=='0'? 'Owner' : 'Authorized Person'}}) <br> {{$contract->info_person_phone_no}} @else N/A @endif</td>

                                    <td>@if($contract->cont_end_date != '') {{$contract->cont_start_date}} @else N/A @endif</td>
                                    <td>@if($contract->cont_end_date != '') {{$contract->cont_end_date}} @else N/A @endif</td>

                                    <td>
                                        @foreach($approval_users as $user)
                                            &nbsp;{{$user->name}}&nbsp;
                                            @php
                                                $status = "-1";
                                            @endphp
                                            @foreach($approved_users as $approved_user)
                                                @if($user->emp_id == $approved_user->emp_id AND $contract->id == $approved_user->cont_quot_id)
                                                    @php
                                                        $status = $approved_user->status;
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if($status == 1)
                                                <span class="badge badge-success" align="center">{{__('contractsQuotation.approved')}} <i class="bi bi-check2-all"></i></span>
                                            @elseif($status == 0)
                                                @php $reject_check = "true"; @endphp
                                                @php $company_check = "true"; @endphp
                                                <span class="badge badge-danger" align="center">{{__('contractsQuotation.rejected')}} <i class="bi bi-x"></i></span>
                                            @else
                                                @php $company_check = "true"; @endphp
                                                @if($user->emp_id == Auth::user()->id)
                                                    <span style="cursor: pointer" onclick="approve_record({{$contract->id}}, {{$user->emp_id}}, 1)" class="badge badge-success" align="center">{{__('contractsQuotation.approve')}}</span>
                                                    &nbsp;<span style="cursor: pointer" onclick="reject_record({{$contract->id}}, {{$user->emp_id}}, 0)" class="badge badge-danger" align="center">{{__('contractsQuotation.reject')}}</span>
                                                @else
                                                    <span class="badge badge-warning" align="center">{{__('contractsQuotation.pending')}}</span>
                                                @endif
                                            @endif
                                             </br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($contract->status === 0)
                                            <span class="badge badge-danger" align="center">{{__('contractsQuotation.rejected_by_company')}}</span>
                                        @elseif($contract->status === 1)
                                            <span class="badge badge-success" align="center">{{__('contractsQuotation.info_by_company')}}</span>
                                        @elseif($contract->status === 2)
                                            <span class="badge badge-success" align="center">{{__('contractsQuotation.contract_sent_to_Company')}}</span>
                                        @elseif($contract->status === 3)
                                            <span class="badge badge-success" align="center">{{__('contractsQuotation.rejected_by_HR')}}</span>
                                        @elseif($contract->status === 4)
                                            @php
                                            $contractEndDate = $contract->cont_end_date;
                                            $currentDate = date("Y-m-d");
                                            if (strtotime($contractEndDate) > strtotime($currentDate)) {
                                                echo '<span class="badge badge-success" align="center">'.__('contractsQuotation.valid_contract').'</span>';
                                            } else {
                                                echo '<span class="badge badge-danger" align="center">'.__('contractsQuotation.contract_expired').'</span>';
                                            }
                                            @endphp
                                        @elseif($contract->status === 5)
                                            <span class="badge badge-danger" align="center">{{__('contractsQuotation.contract_rejected_by_company')}}</span>

                                        @elseif($company_check == 'false')
                                            <span class="badge badge-success" align="center">{{__('contractsQuotation.info_sent_to_company')}}</span>
                                        @elseif($reject_check == 'true')
                                            <span class="badge badge-danger" align="center">{{__('contractsQuotation.rejected_by_management')}}</span>
                                        @else
                                            <span class="badge badge-warning" align="center">{{__('contractsQuotation.waiting_management_approval')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($contract->status === 0)
                                            <span class="badge badge-danger" style="cursor: pointer" onclick="edit_record({{$contract->id}}, '{{$contract->type}}')" align="center">{{__('contractsQuotation.click_to_modify')}}</span>
                                        @elseif($contract->status === 1)
                                            <span style="cursor: pointer" onclick="show_contract({{$contract->id}}, '{{$contract->type}}')" class="badge badge-info" align="center">{{__('contractsQuotation.click_to_verify')}}</span>
                                        @elseif($contract->status === 2)
                                            <span class="badge badge-warning" align="center">{{__('contractsQuotation.pending_company_approval')}}</span>
                                        @elseif($contract->status === 3)
                                            <span class="badge badge-warning" align="center">{{__('contractsQuotation.pending_info_recheck_by_company')}}</span>
                                        @elseif($contract->status === 4)
                                            <span class="badge badge-info" align="center"><a target="_blank" style="color: white;" href="{{url('')}}/Contract/{{base64_encode($contract->id)}}">{{__('contractsQuotation.view_contract')}}</a></span>
                                        @elseif($contract->status === 5)
                                            <span class="badge badge-danger" style="cursor: pointer" onclick="edit_record({{$contract->id}}, '{{$contract->type}}')" align="center">{{__('contractsQuotation.click_to_modify')}}</span>

                                        @elseif($company_check == 'false')
                                            <span class="badge badge-warning" align="center">{{__('contractsQuotation.pending_company_approval')}}</span>
                                        @elseif($reject_check == 'true')
                                            <span style="cursor: pointer" onclick="edit_record({{$contract->id}}, '{{$contract->type}}')" class="badge badge-danger" align="center">{{__('contractsQuotation.click_to_modify')}}</span>
                                        @else
                                            <span class="badge badge-info" style="cursor: pointer" onclick="show_contract({{$contract->id}}, '{{$contract->type}}')" align="center">{{__('contractsQuotation.view_info')}}</span>
                                        @endif
                                    </td>
                                    <td>{{$contract->user_name}} <br> {{$contract->created_at}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            {{__('contractsQuotation.action')}}
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if($contract->status == 4)
                                                    <li>
                                                        <a onclick="show_contract({{$contract->id}}, '{{$contract->type}}')" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow view dropdown-item" href="#">{{__('contractsQuotation.view')}}</a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                @else
                                                    <li>
                                                        <a onclick="edit_record({{$contract->id}}, '{{$contract->type}}')" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit dropdown-item" href="#">{{__('contractsQuotation.edit')}}</a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    @if(Auth::user()->user_type_id==1)
                                                        <li><a onclick="delete_record({{$contract->id}})" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete dropdown-item" href="#"><span style="color:red">{{__('contractsQuotation.delete')}}</span></a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                    @endif
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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
@php
$module = "Contracts & Quotation";
@endphp
@include('new_porttal.partials.delete_modal')


    <div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{__('contractsQuotation.contracts_quotation')}} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <span id="response">
                </span>

            </div>
        </div>
    </div>

    <div class="modal fade" id="reject_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{__('contractsQuotation.reason')}} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="w3-container" action="" method="POST" id="reject_form">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="emp_id" id="emp_id" value="">
                        <input type="hidden" name="cont_quot_id" id="cont_quot_id" value="">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <textarea name="reject_reason" rows="5" cols="100"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('contractsQuotation.cancel')}}</button>
                        <button class="btn btn-success" type="submit">{{__('contractsQuotation.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="verify_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{__('contractsQuotation.verification')}} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div style="overflow-y: auto;width:100%;clear:both;" id="response_verify">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('contractsQuotation.cancel')}}</button>
                    <button class="btn btn-success" type="button" onclick="close_verify_modal()">{{__('contractsQuotation.done')}}</button>
                    <button class="btn btn-primary" onclick="export_pdf()" type="button">{{__('contractsQuotation.export_PDF')}}</button>
                </div>
            </div>
        </div>
    </div>


    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->

    @section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        $(document).ready(function () {

            $('#customer_data').DataTable({
    	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'lBfrtip',
                autoWidth: false,
                "buttons": [
                    {
                        extend: 'excel',
                        text: "{{__('contractsQuotation.export_excel')}}",
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

            $('#filter').click(function () {
                if ($('#filter_companyName').val() != '' || $('#filter_calculation_method_id').val() != '' || $('#filter_period_start').val() != '' || $('#filter_period_end').val() != '' || $('#filter_companyFullName_en').val() != '' || $('#filter_companyFullName_ar').val() != '' || $('#filter_TaxNumber').val() != '' || $('#filter_CreditNote_Letter').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();

                    // fill_datatable($('#filter_companyName').val(), $('#filter_calculation_method_id').val(), $('#filter_period_start').val(), $('#filter_period_end').val(), $('#filter_companyFullName_en').val(), $('#filter_companyFullName_ar').val(), $('#filter_TaxNumber').val(), $('#filter_CreditNote_Letter').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
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

            });


        });
        function add(type) {
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'POST',
                url: "{{URL("/ContractsQuotation/create")}}",
                data: {
                    type: type,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                    $('#company_id').select2({
                        dropdownParent: $('#edit_modal')
                    });
                    $('.items').select2({
                        dropdownParent: $('#edit_modal')
                    });
                    $('.items').prop('required', false);
                }
            });
        }
        function edit_record(id, type) {
            // document.getElementById('response').innerHTML = loader;
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'POST',
                url: "{{URL("/ContractsQuotation/getRecord")}}",
                data: {
                    id: id,
                    type: type,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                    $('#company_id').select2({
                        dropdownParent: $('#edit_modal')
                    });
                    $('.items').select2({
                        dropdownParent: $('#edit_modal')
                    });
                    $('.items').prop('required', false);
                }
            });
        }
        function delete_record(id)
        {
            document.getElementById('delete_form').action = "{{URL('/ContractsQuotation/delete')}}" + "/" + id;
            $('#delete_modal').modal('toggle');
        }

        function reject_record(cont_quot_id, emp_id, status) {
            $('#cont_quot_id').val(cont_quot_id);
            $('#emp_id').val(emp_id);
            document.getElementById('reject_form').action = "{{URL('/ContractsQuotation/reject_quotation')}}";
            $('#reject_modal').modal('toggle');
        }
        function approve_record(cont_quot_id, emp_id, status)
        {
            var temp = 'Approve';
            if (status == 0)
                var temp = 'Reject';
            var result = confirm("Are you sure to "+temp+" this?");
            if (result) {
                $.ajax({
                    type: 'POST',
                    url: "{{URL("/ContractsQuotation/add_approval")}}",
                    data: {
                        status: status,
                        emp_id: emp_id,
                        cont_quot_id: cont_quot_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        location.reload();
                    }
                });
            }
        }
        function show_contract(id, type) {
            // document.getElementById('response').innerHTML = loader;
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'POST',
                url: "{{URL("/ContractsQuotation/showContract")}}",
                data: {
                    id: id,
                    type: type,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
        //         	var editor1 = new RichTextEditor("#div_editor1");
    				// editor1.setReadOnly(true);
                }
            });
        }
        function add_row(index, id, options = '') {
            let contractType = $('#contractType').val();
            let type = $('#type_'+index).val();
            let check = $('#vehicle_info_check_'+index).is(':checked');
            if($('#name_'+index).val() == '' || $('#name_ar_'+index).val() == '')
                alert('Please enter item name');
            else if($('#description_'+index).val() == '' || $('#description_ar_'+index).val() == '')
                alert('Please enter description');
            else if ((contractType == 1 && type == 1 && check == false && $('#vehicle_info_'+index).val() == '') && $('#vehicle_info_ar_'+index).val() == '')
                alert('Please provide info about vehicle');
            else if(contractType == 1 && type == 1 && $('#quantity_'+index).val() == '')
                alert('Please enter quantity');
            else if($('#price_'+index).val() == '')
                alert('Please enter price');
            else {
                index += 1;
                let types = '';
                if (id > 0)
                    types = '<input id="types_'+index+'" type="hidden" name="types[]" value="1">';
                if (contractType == 1) {
                    // <select id="item_1" class="styled-input items" name="items[]" style="width: 100%" onchange="change_item(this.value, '+index+')" required>'+options+'</select>
                    var html = '<tr id="tr_en_'+index+'"><td><input type="text" id="name_'+index+'" class="styled-input form-control" placeholder="Add Item" name="name[]" style="width: 100%;" required></td><td><textarea name="description[]" id="description_'+index+'" class="styled-input form-control" placeholder="Add Description" style="width: 100%" required></textarea></td><td class="cont_type">'+types+'<select id="type_'+index+'" class="styled-input" name="types[]" style="width: 100%" required onchange="change_type(this.value, '+index+')"><option value="1">Monthly Salary</option><option value="2">Per Shipment</option></select></td><td class="cont_type" id="vehicle_td_'+index+'"><input type="checkbox" id="vehicle_info_check_'+index+'" name="vehicle_info_check[]" onclick="vehicle_info_update(this, '+index+')"> N/A <textarea type="text" id="vehicle_info_'+index+'" class="styled-input form-control" placeholder="Vehicle Info" name="vehicle_info[]" style="width: 100%" required></textarea></td><td class="cont_type" id="quantity_td_'+index+'"><input type="number" id="quantity_'+index+'" class="styled-input form-control" name="quantity[]" style="width: 100%" required></td><td><input type="number" id="price_'+index+'" class="styled-input form-control" name="price[]" style="width: 100%" required onchange="set_pp_day('+index+')"></td><td class="cont_type" id="pp_day_'+index+'"></td><td class="cont_type" id="equation_'+index+'"></td></tr>';
                    var html_ar = '<tr id="tr_ar_'+index+'"><td><input type="text" id="name_ar_'+index+'" class="styled-input form-control" placeholder="اضف وصفا" name="name_ar[]" style="width: 100%" required></td><td><textarea name="description_ar[]" id="description_ar_'+index+'" class="styled-input form-control" placeholder="اضف وصفا" style="width: 100%" required></textarea></td><td class="cont_type"></td><td class="cont_type" id="vehicle_ar_td_'+index+'"><input type="checkbox" id="vehicle_info_check_ar_'+index+'"> N/A <textarea type="text" id="vehicle_info_ar_'+index+'" class="styled-input form-control" placeholder="معلومات المركبة" name="vehicle_info_ar[]" style="width: 100%" required></textarea></td><td class="cont_type" id="quantity_td_'+index+'"><input type="number" id="quantity_ar_'+index+'" class="styled-input form-control" style="width: 100%" readonly></td><td><input type="number" id="price_ar_'+index+'" class="styled-input form-control" style="width: 100%" readonly></td><td class="cont_type" id="pp_day_ar_'+index+'"></td><td class="cont_type" id="equation_ar_'+index+'"></td></tr>';
                } else if (contractType == 2) {
                    var html = '<tr id="tr_en_'+index+'"><td><input type="text" id="name_'+index+'" class="styled-input form-control" placeholder="Add Item" name="name[]" style="width: 100%" required></td><td><textarea name="description[]" id="description_'+index+'" class="styled-input form-control" placeholder="Add Description" style="width: 100%" required></textarea></td><td class="cont_type" style="display: none;">'+types+'<select id="type_'+index+'" class="styled-input" name="types[]" style="width: 100%"  onchange="change_type(this.value, '+index+')"><option value="1">Monthly Salary</option><option value="2">Per Shipment</option></select></td><td class="cont_type" style="display: none;" id="vehicle_td_'+index+'"><input type="checkbox" id="vehicle_info_check_'+index+'" name="vehicle_info_check[]" onclick="vehicle_info_update(this, '+index+')"> N/A <textarea type="text" id="vehicle_info_'+index+'" class="styled-input form-control" placeholder="Vehicle Info" name="vehicle_info[]" style="width: 100%"></textarea></td><td class="cont_type" style="display: none;" id="quantity_td_'+index+'"><input type="number" id="quantity_'+index+'" class="styled-input form-control" name="quantity[]" style="width: 100%"></td><td><input type="number" id="price_'+index+'" class="styled-input form-control" name="price[]" style="width: 100%" required onchange="set_pp_day('+index+')"></td><td class="cont_type" style="display: none;" id="pp_day_'+index+'"></td><td class="cont_type" style="display: none;" id="equation_'+index+'"></td></tr>';
                    var html_ar = '<tr id="tr_ar_'+index+'"><td><input type="text" id="name_ar_'+index+'" class="styled-input form-control" placeholder="اضف وصفا" name="name_ar[]" style="width: 100%" required></td><td><textarea name="description_ar[]" id="description_ar_'+index+'" class="styled-input form-control" placeholder="اضف وصفا" style="width: 100%" required></textarea></td><td class="cont_type" style="display: none;"></td><td class="cont_type" style="display: none;" id="vehicle_ar_td_'+index+'"><input type="checkbox" id="vehicle_info_check_ar_'+index+'"> N/A <textarea type="text" id="vehicle_info_ar_'+index+'" class="styled-input form-control" placeholder="معلومات المركبة" name="vehicle_info_ar[]" style="width: 100%"></textarea></td><td class="cont_type" style="display: none;" id="quantity_td_'+index+'"><input type="number" id="quantity_ar_'+index+'" class="styled-input form-control" style="width: 100%" readonly></td><td><input type="number" id="price_ar_'+index+'" class="styled-input form-control" style="width: 100%" readonly></td><td class="cont_type" style="display: none;" id="pp_day_ar_'+index+'"></td><td class="cont_type" style="display: none;" id="equation_ar_'+index+'"></td></tr>';
                }
                let add_row = "{{__('contractsQuotation.add_Row')}}";
                let del_row = "{{__('contractsQuotation.del_Row')}}";
                $('#en_body').append(html);
                $('#ar_body').append(html_ar);
                // $('.items_table').append(html);
                $('#count').val(index);
                $('#btn_del').html('<button type="button" class="btn btn-danger" onclick="delete_row('+index+', '+id+')">'+del_row+'</button>');
                $('#btn').html('<button type="button" class="btn btn-primary" onclick="add_row('+index+', '+"'"+id+"'"+', '+"`"+options+"`"+')">'+add_row+'</button>');
                $('.items').select2({
                    dropdownParent: $('#edit_modal')
                });
                $('.items').prop('required', false);
            }
            $('#item_1').val('');
            $('#item_1').trigger('change');
        }
        function change_type(type, index) {
            $('#types_'+index).val(type);
            if(type == '1') {
                $('#vehicle_td_'+index).html('<input type="checkbox" id="vehicle_info_check_'+index+'" name="vehicle_info_check[]" value="1" onclick="vehicle_info_update(this, '+index+')"> N/A<textarea id="vehicle_info_'+index+'" class="styled-input form-control" placeholder="Vehicle Info" name="vehicle_info[]" style="width: 100%" required></textarea>');
                $('#vehicle_ar_td_'+index).html('<input type="checkbox" id="vehicle_info_check_ar_'+index+'" value="1"> N/A<textarea id="vehicle_info_ar_'+index+'" class="styled-input form-control" placeholder="معلومات المركبة" name="vehicle_info_ar[]" style="width: 100%" required></textarea>');

                $('#quantity_td_'+index).html('<input type="number" id="quantity_'+index+'" class="styled-input form-control" name="quantity[]" style="width: 100%" required>');
                $('#price_'+index).val('');
                $('#pp_day_'+index).html('');
                $('#equation_'+index).html('');
            } else {
                $('#vehicle_td_'+index).html('<input type="checkbox" id="vehicle_info_check_'+index+'" name="vehicle_info_check[]" value="1" onclick="vehicle_info_update(this, '+index+')" style="display: none"><input type="hidden" name="vehicle_info[]" value="">');
                $('#vehicle_ar_td_'+index).html('<input style="display: none" type="checkbox" id="vehicle_info_check_ar_'+index+'" value="1" ><input type="hidden" name="vehicle_info_ar[]" value="">');

                $('#quantity_td_'+index).html('<input type="hidden" id="quantity_'+index+'" class="styled-input form-control" name="quantity[]" style="width: 100%;">');
                $('#price_'+index).val('');
                $('#pp_day_'+index).html('');
                $('#equation_'+index).html('');
            }
        }
        function delete_row(index, id) {
            if (index == 1)
               $('#btn_del').html('');
            else {
                $('#tr_en_'+index).remove();
                $('#tr_ar_'+index).remove();
                index -= 1;
                $('#count').val(index);
                let add_row = "{{__('contractsQuotation.add_Row')}}";
                let del_row = "{{__('contractsQuotation.del_Row')}}";
                $('#btn_del').html('<button type="button" class="btn btn-danger" onclick="delete_row('+index+', '+id+')">'+del_row+'</button>')
                $('#btn').html('<button type="button" class="btn btn-primary" onclick="add_row('+index+', '+id+')">'+add_row+'</button>');
                $('#count').val(index);
            }
        }
        function open_verify_modal(id, company = '') {
            let contractType = $('#contractType').val();
            $('#company').val(company);
            // document.getElementById('response_verify').innerHTML = loader;
            if (contractType == 1)
                var html = '<table style="overflow-x: auto; width: 100%; border-collapse: collapse;font-size: 13px;text-align: justify"><thead><th style="color: white;border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Calculation<br>(معادلة)</th><th style="color: white;border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Per Day<br>(في اليوم)</th><th style="color: white; border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Price<br>(السعر)</th><th style="color: white;border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Quantity<br>(الكمية)</th><th style="color: white;border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Vehicle<br>(المركبة)</th><th style="color: white;border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Type<br>(النوع)</th><th style="color: white;border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Description<br>(الوصف)</th><th style="color: white;border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Items<br>(الصنف)</th></thead><tbody style="color: 1A3231;">';
            else if (contractType == 2)
                var html = '<table style="overflow-x: auto; width: 100%; border-collapse: collapse;font-size: 13px;text-align: justify"><thead><th style="color: white; border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Price<br>(السعر)</th><th style="color: white;border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Type<br>(النوع)</th><th style="color: white;border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Description<br>(الوصف)</th><th style="color: white;border: 1px solid #1A3231; text-align: center; padding: 8px; background-color: #1A3231;">Items<br>(الصنف)</th></thead><tbody style="color: 1A3231;">';
            let count = $('#count').val();
            let total = 0;
            let check = true;
            for (let i = 1; i <= count; i++) {
                let name = $('#name_'+i).val();
                let name_ar = $('#name_ar_'+i).val();

                let description = $('#description_'+i).val();
                let description_ar = $('#description_ar_'+i).val();
                let type = $('#type_'+i).val();

                let vehicle_info = $('#vehicle_info_'+i).val();
                let vehicle_info_ar = $('#vehicle_info_ar_'+i).val();

                let vehicle_info_check = $('#vehicle_info_check_'+i).val();
                let quantity = $('#quantity_'+i).val();
                let price = $('#price_'+i).val();
                let vehicle = vehicle_ar = '';
                if (vehicle_info != '') {
                    vehicle = vehicle_info;
                    vehicle_ar = vehicle_info_ar;
                } else {
                    vehicle = "N/A";
                    vehicle_ar = "";
                }

                if(contractType == 1 && type == 1 && (name == '' || name_ar == '' || description == '' || description_ar == '' || quantity == '' || price == '')) {
                    $('#verify_modal').modal('hide');
                    alert('Some fields are missing. Please provide each field data.');
                    check = false;
                    break;
                } else if (contractType == 1 && type == 2 && (name == '' || name_ar == '' || description == '' || description_ar == '' || price == '')) {
                    $('#verify_modal').modal('hide');
                    alert('Some fields are missing. Please provide each field data.');
                    check = false;
                    break;
                } else if (contractType == 2 && (name == '' || name_ar == '' || description == '' || description_ar == '' || price == '')) {
                    $('#verify_modal').modal('hide');
                    alert('Some fields are missing. Please provide each field data.');
                    check = false;
                    break;
                }
                let back_color = "";
                if (i % 2 != 0)
                    back_color = "background-color: #EBEBEA;";
                if (contractType == 1) {
                    if (type == 1) {
                        html += '<tr><td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px;">'+price + ' / 26' +'</td>';
                        html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px;">'+Math.round(price/26)+'</td>';
                    } else {
                        html += '<tr><td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px;">N/A</td>';
                        html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px;">N/A</td>';
                    }
                } else if (contractType == 2) {

                }
                html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px;">'+price+'</td>';
                if (contractType == 1) {
                    if (type == 1) {
                        html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px;">'+quantity+'</td>';
                        html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px; direction: rtl">'+vehicle_ar+'</td>';
                    } else {
                        html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px;">N/A</td>';
                        html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px;">N/A</td>';
                    }
                }
                if (contractType == 1) {
                    if (type == 1)
                        html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px; direction: rtl"> شهري</td>';
                    else
                        html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px; direction: rtl">لكل شحنة</td>';
                } else if (contractType == 2) {
                        html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px; direction: rtl">لكل شحنة</td>';
                }
                html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px; direction: rtl">'+description_ar+'</td>';
                html += '<td style="'+back_color+'border: 1px solid white; text-align: justify; padding: 8px; direction: rtl">'+name_ar+'</td></tr>';
                total += parseInt(price);
            }
            html += '</tbody></table>';

            // html += '<h4 style="direction: rtl"><b>المجموع: '+total+'</b></h4>';
            // html += '<hr style="background-color: #EBEBEA;height: 3px; border-top: 0; width: 40%;float: right;margin-top: 0px;">';

            // document.getElementById('response_verify').innerHTML = html;
            if (check) {
                $.ajax({
                    type: 'POST',
                    url: "{{URL("/ContractsQuotation/verification")}}",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        $('#verify_modal').modal('toggle');
                        document.getElementById('response_verify').innerHTML = data;
                        $('#items_table').html(html);
                    }
                });
            }
        }
        function close_verify_modal() {
            $('#verify_modal').modal('toggle');
            $('#update_button').html('<button class="btn btn-success" type="submit">Update</button>');
            $('#btn').html('');
            let count = $('#count').val();
            for (let i = 1; i <= count; i++) {
                $('#name_'+i).prop('readonly', true);
                $('#name_ar_'+i).prop('readonly', true);
                $('#btn').prop('readonly', true);
                $('#description_'+i).prop('readonly', true);
                $('#description_ar_'+i).prop('readonly', true);
                $('#type_'+i).prop('disabled', true);
                $('#vehicle_info_check_'+i).prop('disabled', true);
                $('#vehicle_info_check_ar_'+i).prop('disabled', true);
                $('#vehicle_info_'+i).prop('readonly', true);
                $('#vehicle_info_ar_'+i).prop('readonly', true);
                $('#quantity_'+i).prop('readonly', true);
                $('#price_'+i).prop('readonly', true);
            }
        }
        $("#update_form").submit(function(event) {
            event.preventDefault();
            alert('dd');
            let count = $('#count').val();
            for (let i = 1; i <= count; i++)
                $('#type_'+i).prop('disabled', false);
        });

        function fun_contract_file(type) {
            if(type == 1) {
                // $('#reject_reason').prop('required', false);
                $('#contract_reject_div').hide();
            } else {
                // $('#reject_reason').prop('required', true);
                $('#contract_reject_div').show();
            }
        }
        function vehicle_info_update(the, id) {
            if(the.checked) {
                $('#vehicle_info_'+id).prop('required', false);
                $('#vehicle_info_'+id).val('');
                $('#vehicle_info_'+id).hide();

                $('#vehicle_info_ar_'+id).prop('required', false);
                $('#vehicle_info_ar_'+id).val('');
                $('#vehicle_info_ar_'+id).hide();
                $('#vehicle_info_check_ar_'+id).prop('checked', true);

            } else {
                $('#vehicle_info_'+id).prop('required', true);
                $('#vehicle_info_'+id).val('');
                $('#vehicle_info_'+id).show();

                $('#vehicle_info_ar_'+id).prop('required', true);
                $('#vehicle_info_ar_'+id).val('');
                $('#vehicle_info_ar_'+id).show();
                $('#vehicle_info_check_ar_'+id).prop('checked', false);

            }
        }
        function set_pp_day(id) {
          var price = $('#price_'+id).val();
          var type = $('#type_'+id).val();
          if(price > 0 && type == 1) {
              var pp_day = price / 26;
              pp_day = Math.round(pp_day);
              $('#pp_day_'+id).html(pp_day+ ' SAR');
              var equ = price +"/26";
              $('#equation_'+id).html(equ);
          } else {
            $('#pp_day_'+id).html('');
            $('#equation_'+id).html("");
          }
        }

        // Function to disable Enter key for other form fields
        function disableEnterKey(event) {
            if (event.keyCode === 13 && event.target.tagName !== 'TEXTAREA') {
                event.preventDefault(); // Prevent Enter key behavior for other form fields
            }
        }
        function reject_it(id, column) {
            var result = confirm("Are you really want to reject it?");
            if (result) {
                $('#'+column).remove();
                $.ajax({
                    type: 'POST',
                    url: "{{URL("/ContractsQuotation/reject_file")}}",
                    data: {
                        id: id,
                        column: column,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        $("input[name='quot_status'][value='0']").prop('checked', true);
                        // $('#reject_reason').prop('required', true);
                        $('#contract_reject_div').show();
                        document.getElementById('response_verify').innerHTML = data;
                        $('#items_table').html(html);
                    }
                });
            }
        }
        function change_body(type) {
            if(type == 'en') {
                $('#en_body').show();
                $('#ar_body').hide();
            } else {
                $('#en_body').hide();
                $('#ar_body').show();
            }
        }
        function change_contract_type(type) {
            if(type == 1) {
                $('.cont_type').show();
                $("[id^='vehicle_info_']").attr("required", "required");
                $("[id^='vehicle_info_ar_']").attr("required", "required");
                $("[id^='quantity_']").attr("required", "required");
                $("[id^='vehicle_info_check_']").removeAttr("required");

            } else if (type == 2) {
                $('.cont_type').hide();
                $("[id^='vehicle_info_']").removeAttr("required");
                $("[id^='vehicle_info_ar_']").removeAttr("required");
                $("[id^='quantity_']").removeAttr("required");
            }
        }

        function change_company(company_id) {
            if(company_id > 0) {
                $('#companyName').prop('readonly', true);
                $('#companyName_ar').prop('readonly', true);
                $('#companyEmail').prop('readonly', true);
                $('#companyName').val('');
                $('#companyName_ar').val('');
                $.ajax({
                    type: 'POST',
                    url: "{{URL("/ContractsQuotation/getCompany")}}",
                    data: {
                        company_id: company_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        $('.comp_name').show();
                        data = data.split(":::");
                        $('#companyName').val(data[0]);
                        $('#companyName_ar').val(data[1]);
                        $('#companyEmail').val(data[2]);
                    }
                });
            } else if (company_id == 'other')
            {
                $('#companyName').prop('readonly', false);
                $('#companyName_ar').prop('readonly', false);
                $('#companyEmail').prop('readonly', false);
                $('#companyName').val('');
                $('#companyName_ar').val('');
                $('#companyEmail').val('');
                $('.comp_name').show();
            } else {
                $('.comp_name').hide();
            }
        }
        function change_item(item_id, index) {
            index = $('#count').val();
            if(item_id > 0) {
                $.ajax({
                    type: 'POST',
                    url: "{{URL("/ContractsQuotation/getItem")}}",
                    data: {
                        item_id: item_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        $('.comp_name').show();
                        data = data.split(":::");
                        $('#name_'+index).val(data[0]);
                        $('#name_'+index).prop('readonly', true);
                        $('#name_ar_'+index).val(data[1]);
                        $('#name_ar_'+index).prop('readonly', true);
                        $('#description_'+index).val(data[2]);
                        $('#description_'+index).prop('readonly', true);
                        $('#description_ar_'+index).val(data[3]);
                        $('#description_ar_'+index).prop('readonly', true);
                        $('#type_'+index).val(data[4]);
                        $('#type_'+index).prop('disabled', true);
                        $('#vehicle_info_'+index).prop('readonly', true);
                        $('#vehicle_info_ar_'+index).prop('readonly', true);
                        $('#vehicle_info_check_'+index).prop('disabled', true);
                        $('#vehicle_info_check_ar_'+index).prop('disabled', true);

                        if(data[4] == 1) {
                            if(data[5] == 1) {
                                $('#vehicle_info_ar_'+index).hide();
                                $('#vehicle_info_'+index).hide();
                                $('#vehicle_info_check_ar_'+index).prop('checked', true);
                                $('#vehicle_info_check_'+index).prop('checked', true);
                            } else {
                                $('#vehicle_info_ar_'+index).show();
                                $('#vehicle_info_'+index).show();
                                $('#vehicle_info_'+index).val(data[6]);
                                $('#vehicle_info_ar_'+index).val(data[7]);
                            }
                        } else if(data[4] == 0) {
                                $('#vehicle_info_'+index).hide();
                                $('#vehicle_info_ar_'+index).hide();
                                $('#vehicle_info_check_'+index).hide();
                                $('#vehicle_info_check_ar_'+index).hide();
                        }
                        $('#price_'+index).val(data[8]);
                        $('#price_'+index).prop('readonly', true);
                        $('#pp_day_'+index).html(Math.round(data[8] / 26) + " SAR");
                        $('#equation_'+index).html(data[8] + '/ 26');
                    }
                });
            } else if (item_id == 'other')
            {
                $('#name_'+index).prop('readonly', false);
                $('#name_ar_'+index).prop('readonly', false);
                $('#description_'+index).prop('readonly', false);
                $('#description_ar_'+index).prop('readonly', false);
                $('#type_'+index).prop('disabled', false);
                $('#vehicle_info_'+index).prop('readonly', false);
                $('#vehicle_info_ar_'+index).prop('readonly', false);
                $('#vehicle_info_check_'+index).prop('disabled', false);
                $('#vehicle_info_check_ar_'+index).prop('disabled', false);

                $('#name_'+index).val('');
                $('#name_ar_'+index).val('');
                $('#description_'+index).val('');
                $('#description_ar_'+index).val('');
                $('#type_'+index).val(1);
                $('#vehicle_info_ar_'+index).val('');
                $('#vehicle_info_ar_'+index).show();
                $('#vehicle_info_'+index).val('');
                $('#vehicle_info_'+index).show();
                $('#vehicle_info_check_ar_'+index).prop('checked', false);
                $('#vehicle_info_check_ar_'+index).show();
                $('#vehicle_info_check_'+index).prop('checked', false);
                $('#vehicle_info_check_'+index).show();
                $('#price_'+index).val('');
                $('#quantity_'+index).val('');
                $('#pp_day_'+index).html('');
                $('#price_'+index).prop('readonly', false);
                $('#equation_'+index).html('');
            }
        }
        function enableDisabledFields() {
            $('.styled-input').prop('disabled', false);
        }


        function export_pdf() {
            let company = $('#company').val();

            var printableSection = document.getElementById("printableSection");
            var printWindow = window.open('', '', 'width=1000,height=1000');

            // Open a new window and write the printable content to it
            printWindow.document.open();
            printWindow.document.write('<html><head><title style="text-align: right">'+company+' Quotation</title></head><body>');
            printWindow.document.write(printableSection.innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            // Wait for the content to be fully loaded before printing
            printWindow.onload = function() {
                printWindow.print();
                // printWindow.close();
            };
        }
    </script>

@stop
@endsection
