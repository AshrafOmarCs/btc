@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Contracts And Quotation</h2>
        </div>
        <div style="float:right;">
            <h2>
                <a href="javascript:add('Contract');" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New Contract</a>
                <a href="javascript:add('Quotation');" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New Quotation</a>
            </h2>
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
    <!--<div class="col-md-3" style="width:100%;clear:both;">-->
    <!--    <div id="card_box" class="box box-primary collapsed-box">-->
    <!--        <div class="box-header with-border">-->
    <!--            <h3 class="box-title">-->
    <!--                <button class="button_search" onclick="card_change()"><i class="fa fa-search"></i></button>-->
    <!--            </h3>-->

    <!--            <div class="box-tools pull-right">-->
    <!--                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box"-->
    <!--                                                                                         class="fa fa-plus"></i>-->
    <!--                </button>-->
    <!--            </div>-->
                <!-- /.box-tools -->
    <!--        </div>-->
            <!-- /.box-header -->
    <!--        <div id="box-body" class="box-body table-responsive">-->
                <!--<table class="table m-0 search_table" style="width:10px!important;">-->
                <!--    <tr>-->
                <!--        <TH>CompanyName</TH>-->
                <!--        <td><input type="text" class="form-control" style="width:180px;" name="filter_companyName"-->
                <!--                   id="filter_companyName"></td>-->

                <!--        <TH>calculation_method</TH>-->
                <!--        <td>-->
                <!--            <select id="filter_calculation_method_id" name="filter_calculation_method_id"-->
                <!--                    class="form-control"-->
                <!--                    style="width:180px;">-->
                <!--                <option value=""></option>-->

                <!--                
                <!--            </select>-->
                <!--        </td>-->
                <!--        <TH>period_start</TH>-->
                <!--        <td><input type="text" class="form-control" name="filter_period_start" id="filter_period_start">-->
                <!--        </td>-->
                <!--    </tr>-->
                <!--</table>-->

    <!--            <div class="card-footer" align="center">-->
    <!--                <button type="button" name="filter" class="btn btn-sm btn-info" id="filter">Filter</button>-->

    <!--                <button type="button" name="reset" class="btn btn-sm btn-default" id="reset">Reset</button>-->
    <!--            </div>-->
    <!--        </div>-->
            <!-- /.box-body -->
    <!--    </div>-->
        <!-- /.box -->
    <!--</div>-->
    <!-- /.col -->


    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->


    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped">
            <thead>
                <th>Sr. No</th>
                <TH>companyName</TH>
                <TH>companyEmail</TH>
                <TH>Type</TH>
                <TH>Approve</TH>
                <TH>Procedure</TH>
                <TH>Action</TH>
            </thead>
            <tbody>
                @php $no = 0; @endphp
                @foreach($contracts as $contract)
                    @php $reject_check = "false"; @endphp 
                <tr>
                    <td>{{++$no}}</td>
                    <td>{{$contract->companyName}}</td>
                    <td>{{$contract->companyEmail}}</td>
                    <td>{{ucfirst($contract->type)}}</td>
                    <td>
                        @foreach($approval_users as $user)
                            &nbsp;{{$user->name}}&nbsp;
                            @php 
                                $status = "-1"; 
                                $company_check = "false";
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
                                <span class="label label-success" align="center">Approved <i class="fa fa-check"></i></span>
                            @elseif($status == 0)
                                @php $reject_check = "true"; @endphp
                                @php $company_check = "true"; @endphp
                                <span class="label label-danger" align="center">Rejected <i class="fa fa-times"></i></span>
                            @else
                                @php $company_check = "true"; @endphp
                                @if($user->emp_id == Auth::user()->id)
                                    <span style="cursor: pointer" onclick="approve_record({{$contract->id}}, {{$user->emp_id}}, 1)" class="label label-success" align="center">Approve</span>
                                    &nbsp;<span style="cursor: pointer" onclick="reject_record({{$contract->id}}, {{$user->emp_id}}, 0)" class="label label-danger" align="center">Reject</span>
                                @else
                                    <span class="label label-warning" align="center">Pending</span>
                                @endif
                            @endif
                             </br>
                        @endforeach
                    </td>
                    <td>
                        @if($contract->status === 0)
                            <span class="label label-danger" style="cursor: pointer" onclick="edit_record({{$contract->id}}, '{{$contract->type}}')" align="center">Rejected by Company</span>
                        @elseif($contract->status === 1)
                            <span style="cursor: pointer" onclick="show_contract({{$contract->id}}, '{{$contract->type}}')" class="label label-success" align="center">Approved by Company</span>
                        @elseif($company_check == 'false')
                            <span class="label label-warning" align="center">Awaiting Company Approval</span>
                        @elseif($reject_check == 'true')
                            <span style="cursor: pointer" onclick="edit_record({{$contract->id}}, '{{$contract->type}}')" class="label label-danger" align="center">Rejected by Management</span>
                        @else
                            <span class="label label-warning" align="center">Awaiting Management Approval</span>
                        @endif
                    </td>
                    <td>
                        <a onclick="edit_record({{$contract->id}}, '{{$contract->type}}')" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow"> <i class="fa fa-pencil"></i> </a>
                        &nbsp;<a onclick="delete_record({{$contract->id}})" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom">
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
    
    <div id="reject_modal" class="w3-modal">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('reject_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>
            <header class="w3-container w3-text-indigo w3-margin-top-64">
                <h1>Reason</h1>
            </header>
            <form class="w3-container" action="" method="POST" id="reject_form">
                @csrf
                <input type="hidden" name="emp_id" id="emp_id" value="">
                <input type="hidden" name="cont_quot_id" id="cont_quot_id" value="">
                <div class="w3-section">
                    <div class="w3">
                        <textarea name="reject_reason" rows="5" cols="95"></textarea>
                    </div>
                    <div class="w3-center">
                        <button type="submit" class="w3-btn w3-indigo"> Submit</button>
                    </div>
                </div>
            </form>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('reject_modal').style.display='none'" type="button"
                        class="w3-btn w3-red">Cancel
                </button>
            </div>
        </div>
    </div>
    
    <div id="verify_modal" class="w3-modal">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('verify_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>
            <div style="width:100%;clear:both;" id="response_verify">

            </div>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('verify_modal').style.display='none'" type="button"
                        class="w3-btn w3-red">Cancel
                </button>
            </div>
        </div>
    </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->

    
    <script>
        $(document).ready(function () {
            $('#customer_data').DataTable({
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
                responsive: true,
                processing: true,
                "pagingType": "full_numbers",
                "autoWidth": false,
    	    });

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
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
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'POST',
                url: "{{URL("/ContractsQuotation/create")}}",
                data: {
                    type: type,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                	var editor1 = new RichTextEditor("#div_editor1");
                }
            });
        }
        function edit_record(id, type) {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
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
                	var editor1 = new RichTextEditor("#div_editor1");
                }
            });
        }
        function delete_record(id)
        {
            document.getElementById('delete_form').action = "{{URL('/ContractsQuotation/delete')}}" + "/" + id;
            document.getElementById('delete_modal').style.display = 'block';
        }
        
        function reject_record(cont_quot_id, emp_id, status) {
            $('#cont_quot_id').val(cont_quot_id);
            $('#emp_id').val(emp_id);
            document.getElementById('reject_form').action = "{{URL('/ContractsQuotation/reject_quotation')}}";
            document.getElementById('reject_modal').style.display = 'block';
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
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
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
                	var editor1 = new RichTextEditor("#div_editor1");
    				editor1.setReadOnly(true);
                }
            });
        }
        function add_row(index, id) {
            if($('#name_'+index).val() == '')
                alert('Please enter item name');
            else if($('#description_'+index).val() == '')
                alert('Please enter description');
            else if($('#price_'+index).val() == '')
                alert('Please enter price');
            else {
                index += 1;
                var html = '<tr><td><input type="text" id="name_'+index+'" class="styled-input" placeholder="Add Item" name="name[]" style="width: 100%"></td><td><textarea name="description[]" id="description_'+index+'" class="styled-input" placeholder="Add Description" style="width: 100%"></textarea></td><td><input type="number" id="price_'+index+'" class="styled-input" placeholder="Add Price" name="price[]" style="width: 100%"></td></tr>';
                $('.items_table').append(html);
                $('#btn').html('<button type="button" class="btn btn-primary" onclick="add_row('+index+', '+id+')">Add Row</button>');
            }
        }
        function open_verify_modal(id) {
            document.getElementById('response_verify').innerHTML = loader;
            document.getElementById('verify_modal').style.display = 'block';
            $.ajax({
                type: 'POST',
                url: "{{URL("/ContractsQuotation/verification")}}",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('response_verify').innerHTML = data;
                }
            });
        }

    </script>

@endsection
