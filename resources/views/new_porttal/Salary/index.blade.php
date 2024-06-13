@extends('layout2')
@section('content')
@section('title', 'Salary')

<style>
    .red {
        background-color: red;
    }
</style>
<!-- Modal ExportExcel 3 -->
<div class="modal fade" id="FillterButton" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.Filter')}} </h5>
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
                                            <label for="country" class="form-label">CompanyName </label>
                                            <select name="filter_companyId" id="filter_companyId" onchange="CityName()" class="form-control">
                                                <option value=""></option>
                                                @foreach($lkp_company as $lkpcompany)
                                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Period </label>
                                            <select name="filter_Period" id="filter_Period" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">CityName </label>
                                            <select onchange="Warehouse()" name="filter_cityId" id="filter_cityId" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Paid </label>
                                            <select name="filter_paid_id" id="filter_paid_id" class="form-control">
                                                <option value=""></option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Warehouse </label>
                                            <select name="filter_warehouseId" id="filter_warehouseId" class="form-control" multiple style="width:200px;">
                                            </select><br>
                                            <small style="display: none; color: red" id="multiple_tag">To select multiple items, Ctrl-click each item.</small>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">E-Signtures </label>
                                            <a href="#"  id="ApprovalModalBtn" class="btn btn-info btn-md" style=" background-color: #1c6577; border-color: #00acd6; width: 180px;" data-bs-toggle="modal" data-bs-target="#ApprovalModal">Approval List</a>
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
                <button type="button" id="reset" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="filter">{{__('drivers.Search')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal ExportExcel 3 -->
@php
$array = [
    0=>'STCPAY Identity',
    1=>'STCPAY Number',
    2=>'Company',
    3=>'HUB',
    4=>'Driver AMP',
    5=>'Driver Name',
    6=>'Trancation Date',
    7=>'Driver dues',
    8=>'Transaction Count',
    9=>'Transaction Total',
    10=>'Trancation Type',
];
@endphp
@include('new_porttal.partials.export_excel')

<!--End Modal ExportExcel 3 -->

<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Salary </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sheet_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Salary </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response_sheet">
            </span>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Salary</h5>
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

<div class="modal fade" id="view_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="responsee">
            </span>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">E-Signtures</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="e_signature" style="display:none;">
                    <table class="table" id="tblEntAttributes" style="width: 97%%;border: 1px solid #d3a45924;    margin-bottom: 15px; margin-top: 15px;  box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;">
                        <thead>
                            <tr style="background-color: #d3a459; text-align: center !important;">
                                <th scope="col">EMP </th>
                                <th scope="col">Department </th>
                                <th scope="col">Signature </th>
                            </tr>
                         </thead>
                         <tbody >
                         </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportSalarySTCShe")}}">
                    @csrf
                    <input type="hidden" name="SQL" id="SQL_stc" value="">
                    <input type="hidden" name="company_Id" id="company_Id">
                    <input type="hidden" name="companyName" id="companyName">
                    <input type="hidden" name="PeriodName" id="PeriodName">
                    <input type="hidden" name="from_to" id="from_to">

                    <button type="submit" name="STC_Report" id="STC_Report" disabled class="btn btn-sm btn-info">STC pay
                        Excel
                    </button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- End of Approval Modal -->

<!--End Modal ExportExcel 3 -->

 <!-- Row start -->
 <div class="row">
    @include('new_porttal.partials.edit_btn')
</div>

<div class="row">
    <div class="col-sm-12 col-12">
        <div id="message"></div>
        <!-- Card start -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Salary</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">From this page you can view drivers Salaries detail. </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                {{-- <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button> --}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div id="loader" style="display:none;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <center>
                        <div id="salary_range"></div>
                    </center>
                    <input type="hidden" name="companyId" id="companyId" value="">
                    <input type="hidden" name="Period" id="Period" value="">
                    <div class="table-responsive">
                        <form method="POST" action="{{ route('Salary.store')}}">
                            @csrf
                            <table id="customer_data" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <TH>Whouse</TH>
                                        <TH>Driver</TH>
                                        <TH>ID</TH>
                                        <TH>Did</TH>
                                        <TH>Days</TH>
                                        <TH>Carried Down</TH>
                                        <TH>Day Loaded</TH>
                                        <TH>Credit</TH>
                                        <TH>Debit</TH>
                                        <TH><input class="" onclick="selectall_status()" type="checkbox" name="select-all-status" id="select-all-status"/> Status</TH>
                                        <TH>Attempt</TH>
                                        <TH>Loan</TH>
                                        <TH>CN</TH>
                                        <TH>Expected Salary</TH>
                                        <TH><input class="flat-red" onclick="selectall()" type="checkbox" name="select-all" id="select-all"/> Paid Salary</TH>
                                        <TH>Brought Down</TH>
                                        <TH>Action</TH>
                                        <TH style="display:none;">Bank Name</TH>
                                        <TH style="display:none;">AccountNumber</TH>
                                        <TH style="display:none;">DriverId</TH>
                                        <TH style="display:none;">Account Owner Iqama</TH>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <TH colspan='3'>Total</TH>
                                        <TH id="pack_total"></TH>
                                        <TH id="days_total"></TH>
                                        <TH id="c_down_total"></TH>
                                        <TH id="day_load_total" class="Font-Green"></TH>
                                        <TH id="credit_total" class="Font-Green"></TH>
                                        <TH id="debit_total" class="Font-Red"></TH>
                                        <TH><button id="status_button" style="display: none" type="button" class="btn btn-primary btn-small" onclick="go_to_ready()" title="Revert status to Ready">Rev.Status</button></TH>
                                        <TH></TH>
                                        <TH id="loan_total"></TH>
                                        <TH id="cn_total"></TH>
                                        <TH id="exp_salary_total"></TH>
                                        <TH id="paid_salary_total"></TH>
                                        <TH id="brought_total"></TH>
                                        <TH></TH>
                                        <TH style="display:none;"></TH>
                                        <TH style="display:none;"></TH>
                                        <TH style="display:none;"></TH>
                                        <TH style="display:none;"></TH>
                                    </tr>
                                </tfoot>
                            </table>
                            <center>
                                <button type="submit" name="filter" class="btn btn-sm btn-info">Post To Journal</button>
                            </center>
                        </form>
                    </div>
                    <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportSalarySTC")}}">
                        @csrf
                        <input type="hidden" name="SQL" id="SQL" value="">
                        <input type="hidden" name="company_Id" id="company_Id">
                        <input type="hidden" name="companyName" id="companyName">
                        <input type="hidden" name="PeriodName" id="PeriodName">
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 40%">
                            </tr>
                            <tr>
                            <button value="Migrate/Move to journal "  id="migrate" style="float:right; " class="btn btn-sm btn-warning">Migrate Selected to Journal</button>
                            </tr>
                        </table>
                    </form>
                </div>
                <!-- Card end -->
            </div>
        <!-- Card end -->
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>


@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        function revert_status(id, name, job_id, amount)
        {
            $('#edit_modal').modal('toggle');
            let action = "{{URL('/Salary-revert')}}";
            let from_to = $('#from_to').val();
            data = `<form action="`+action+`" method="POST">
                    @csrf
                    <div style="margin:20px"><h4>Reason</h4>
                    <input type="hidden" name="driverId" value="`+id+`">
                    <input type="hidden" name="from_to" value="`+from_to+`">
                    <input type="hidden" name="job_id" value="`+job_id+`">
                    <h5 style="">Name: `+name+`</h5>
                    <h5 style="">Job id: `+job_id+`</h5>
                    <h5 style="">Amount: `+amount+`</h5>
                    <p style="color: red">The request for revert back to ready satge will be sent to Finance Manager.</p>
                    <textarea name="reason" id="reason" style="width: 100%; height: 200px" required></textarea>
                    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                      <button type="submit" class="w3-btn w3-green">Submit</button>
                   </div>
                    </div>
                    </form>`;
            document.getElementById('response').innerHTML = data;
        }
        function go_to_ready(){
            var array = [];
            var checkboxes = document.querySelectorAll('.check-status:checked');
            if(checkboxes.length > 0) {

                for (var i = 0; i < checkboxes.length; i++) {
                   array.push(checkboxes[i].value)
                }
                $('#ready_statuss').val(array);
                $('#from_to_ready').val($('#filter_Period').val());
                $('#password_modal').modal('toggle');
                // $.ajax({
                //     type: 'POST',
                //     url: "{{URL("/ExportSalarySTC")}}",
                //     data: {
                //         SQL: $('#SQL_stc').val(),
                //         company_Id: $('#filter_companyId').val(),
                //         companyName: $("#filter_companyId option:selected").text(),
                //         PeriodName: $("#filter_Period option:selected").text(),
                //         from_to: $('#from_to').val()
                //     },
                //     success: function (data) {
                //         location.reload();
                //     }
                // });
            } else {
                alert('Please select atleast one checkbox');
            }
        }
        $(document).ready(function() {
            $(document).ajaxStart(function() {
                $("#loader").show();
            });
            $(document).ajaxStop(function() {
                $("#loader").hide();
            });
    	    $('#customer_data').DataTable({
    	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'lBfrtip',
                bAutoWidth: false,
                aoColumnDefs: [
                  {
                     bSortable: false,
                     aTargets: [ -1, -4, -9 ]
                  }
                ],
                "buttons": [
                    {
                        extend: 'excel',
                        text: 'Export to Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 13],

                            modifier: {
                                search: 'applied',
                                order: 'applied'
                            }
                        },
                        action: function (e, dt, button, config) {
                            var exportType = $('#export-type').val();
                            if (exportType === 'all') {
                                config.exportOptions = { rows: ':visible' };
                            } else if (exportType === 'positive') {
                                config.exportOptions = {
                                    rows: function (idx, data, node) {
                                        return parseFloat(data[13]) > 0;
                                    }
                                };
                            } else if (exportType === 'negative') {
                                config.exportOptions = {
                                    rows: function (idx, data, node) {
                                        return parseFloat(data[13]) < 0;
                                    }
                                };
                            }
                            $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                        },

                    }
                ],
                //searching: false,
                responsive: true,
                processing: true,
                "pagingType": "full_numbers",
                "autoWidth": false,
    	    });

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                $('#edit_modal').modal('toggle');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/SalaryShow')}}" + "/" + id + "/" + document.getElementById('Period').value,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;
                    }
                });
            });

            $('#customer_data tbody').on('click', '.statement', function (e) {
                e.preventDefault();
                $('#edit_modal').modal('toggle');
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

            $('#filter').click(function () {

                if ($('#filter_companyId').val() != '' && $('#filter_Period').val() != '') {
                    $('#pre_loader_build').show();
                    // $('#customer_data').DataTable().destroy();
                    $.ajax({
                        url:"{{ route('Salary_she.index') }}",
                        data:{
                            filter_companyId: $('#filter_companyId').val(),
                            filter_cityId: $('#filter_cityId').val(),
                            filter_warehouseId: $('#filter_warehouseId').val(),
                            filter_Period: $('#filter_Period').val(),
                            filter_paid_id:$('#filter_paid_id').val(),
                        }, success:function(data){
                            data = data.split(":::");
                            $('#customer_data').DataTable().clear();
                            $('#customer_data').DataTable().rows.add($(data[0])).draw();
                            $('#pack_total').html(data[1]);
                            $('#final_pack_total').html(data[2]);
                            $('#match_total').html(data[3]);
                            $('#gap_total').html(data[4]);
                            $('#days_total').html(data[5]);
                            $('#c_down_total').html(data[6]);
                            $('#day_load_total').html(data[7]);
                            $('#credit_total').html(data[8]);
                            $('#debit_total').html(data[9]);
                            $('#loan_total').html(data[10]);
                            $('#cn_total').html(data[11]);
                            $('#ind_total').html(data[12]);
                            $('#exp_salary_total').html(data[13]);
                            $('#paid_salary_total').html(data[14]);
                            $('#t_total').html(data[15]);
                            $('#brought_total').html(data[16]);
                            $('#salary_range').html("<b><font color='red'>" + data[17] + "</font></b>");
                            $('#Period').val(data[18]);
                            $('#companyId').val(data[19]);
                            $('#SQL_stc').val(data[20]);
                            $('#from_to').val(data[17]);
                            // $('#from_to').val($('#filter_Period').val());
                            $('#ApprovalModalBtn').attr('disabled', false);
                            $("#ApprovalModalBtn").attr("data-target", "#ApprovalModal");
                            $("#status_button").hide();
                            if (data[21] == 0) {
                                $('#ApprovalModalBtn').attr('disabled', true);
                                $("#ApprovalModalBtn").removeAttr("data-target");
                            }
                            if (data[22] == 1) {
                               $("#status_button").show();
                            }
                            $('#pre_loader_build').hide();

                            let html = '';
                            if ($('#filter_companyId').val() != '')
                                html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_companyId option:selected').text()+'</button>';
                            if ($('#filter_cityId').val() != '')
                                html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_cityId option:selected').text()+'</button>';
                            if ($('#filter_Period').val() != '')
                                html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_Period').val()+'</button>';
                            if ($('#filter_paid_id').val() != '')
                                html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_paid_id option:selected').text()+'</button>';

                            if(html != '') {
                                $('#edit_btn').show();
                                $('#selectedCriteria').html(html);
                            } else {
                                $('#edit_btn').hide();
                            }
                        }

                    });

                    $.ajax({
                        type:'POST',
                        url:"{{ route('CheckPermisionsShe') }}",
                        data:{_token: "{{ csrf_token() }}",filter_companyId:$('#filter_companyId').val(), filter_Period:$('#filter_Period').val(), filter_paid_id:$('#filter_paid_id').val()},
                        success:function(data){
                            // btns behaiver goes here

                            var currentUser = data.data;

                            if(data.itemsCount > 0){
                                $("#e_signature").show();
                                $("#tblEntAttributes tbody").empty();
                                $("#tblEntAttributes tbody").append(data.payload);
                                if(currentUser.DidUserApproveThisInvoice == true && currentUser.IsHavePermissionToExport == true ){
                                    // able Export button
                                    // check if all emp approved invoice Or Not
                                    $("#STC_Report").prop('disabled', true);
                                    if(currentUser.Does_all_approve == true){
                                         $("#STC_Report").prop('disabled', false);
                                    }
                                }else{
                                    $("#STC_Report").prop('disabled', true);
                                }
                            } else {
                                $("#e_signature").hide();
                            }
                        },error: function(XMLHttpRequest, textStatus, errorThrown) {
                            $("#e_signature").hide();
                            $("#tblEntAttributes tbody").empty();
                        }
                    });

                } else {
                    if ($('#filter_companyId').val() == '')
                        alert('Select Company');
                    else if ($('#filter_Period').val() == '')
                        alert('Select Period');
                }
            });

            $('#reset').click(function () {
                $('#companyId').val('');
                $('#Period').val('');

                $('#filter_companyId').val('');
                $('#filter_cityId').empty();
                $('#filter_warehouseId').empty();
                $('#filter_Period').empty();
                $('#filter_paid_id').empty();
                $('#customer_data').DataTable().destroy();
                // fill_datatable();
            });
            var select = '<select style="height: 25px;margin-right: 5px;" id="export-type"><option value="all">All</option><option value="positive">Positive</option><option value="negative">Negative</option></select>';
            $('.dt-buttons').prepend(select);

        });

        function selectall() {
            if (document.getElementById('select-all').checked)
                $('.flat-red').attr('checked', true);
            else
                $('.flat-red').attr('checked', false);
        }
        function selectall_status() {
            if (document.getElementById('select-all-status').checked)
                $('.check-status').attr('checked', true);
            else
                $('.check-status').attr('checked', false);
        }

        function CityName() {
            var filter_companyId = document.getElementById('filter_companyId').value;
            if (filter_companyId == "") {
                $('#filter_cityId').empty();
                $('#filter_warehouseId').empty();
                $('#filter_Period').empty();
            } else {

                $.getJSON("{{URL("/getPeriod")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_Period').empty();
                    $('#filter_warehouseId').empty();
                    //$('#filter_Period').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_Period').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
                //----------------------------------------------------------------------------------------------------------------------
                $.getJSON("{{URL("/getCityName")}}" + "/" + filter_companyId, function (json) {
                    $('#multiple_tag').hide();
                    $('#filter_cityId').empty();
                    $('#filter_warehouseId').empty();
                    $('#filter_cityId').append($('<option>').text("Select ....").attr('value', ''));
                    $('#filter_cityId').append($('<option>').text("All").attr('value', 'All'));
                    $.each(json, function (i, obj) {
                        $('#filter_cityId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
        }

        function Warehouse() {
            var filter_cityId = document.getElementById('filter_cityId').value;
            var filter_companyId = document.getElementById('filter_companyId').value;
            if (filter_cityId == "")
                $('#filter_warehouseId').empty();
            else if (filter_cityId == "All") {
                $('#multiple_tag').show();
                $.getJSON("{{URL("/getWarehouseByCompany")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_warehouseId').empty();
                    // $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
            else {
                $('#multiple_tag').show();
                $.getJSON("{{URL("/getWarehouseByCityCompany")}}" + "/" + filter_cityId + "/" + filter_companyId, function (json) {
                    $('#filter_warehouseId').empty();
                    // $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
        }

        function driver(id) {
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL("/Drivers")}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;

                }
            });
        }

        function sheet(id, Period) {
            $('#sheet_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL("/SalaryShow")}}" + "/" + id + "/" + Period,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response_sheet').innerHTML = data;
                }
            });
            // myWindow1 = window.open("{{URL('/New-Portal/SalaryShow')}}" + "/" + id + "/" + Period, "",
            //     "height=1000,width=850,scrollbars=yes,top=1,left=1,status,resizable");
        }

        function validateForm() {
            if ($('#filter_companyId').val() == '') {
                alert('Select Company');
                return false;
            }
            if ($('#filter_Period').val() == '') {
                alert('Select Period');
                return false;
            }
            if ($('#filter_paid_id').val() != '2') {
                alert('Select Paid Typeا');
                return false;
            }
            if ($('#SQL_stc').val().indexOf("TRIM(ROUND(paid_salary,2))+0 =0") == -1) {
                alert('First you have to click on Filter button');
                return false;
            }
            $('#company_Id').val($('#filter_companyId').val());
            $('#companyName').val($("#filter_companyId option:selected").text());
            $('#PeriodName').val($("#filter_Period option:selected").text());
            setTimeout(function() {
                location.reload();
            }, 5000);
            return true;

        }
        function show_record(id, type) {
            document.getElementById('responsee').innerHTML = "Loading...";
            $('#view_modal').modal('toggle');
            let urls = '';
            if(type == 'Loan')
                urls = "/Loans" + "/" + id;
            if(type == 'Credit Note')
                urls = "/CreditNotes" + "/" + id;
            $.ajax({
                type: 'GET',
                url: urls,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('responsee').innerHTML = data;
                }
            });
        }
    </script>
@stop
@endsection
