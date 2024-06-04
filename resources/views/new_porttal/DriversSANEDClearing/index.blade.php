@extends('layout2')
@section('content')
@section('title', __('drivers.BanderClearing'))

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
                                            <label for="country" class="form-label">{{__('drivers.City')}} </label>
                                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control" multiple>
                                                <option value=""></option>
                                                @foreach($warehouse as $warehousee)
                                                    <option value="{{$warehousee->id}}"> {{$warehousee->warehouseName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.EMPID')}} </label>
                                            <input type="text" class="form-control" name="filter_job_id" id="filter_job_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.DriverType')}} </label>
                                            <select name="filter_driver_type_id" id="filter_driver_type_id" class="form-control">
                                                <option value=""></option>
                                                @foreach($lkp_driver_type as $lkp_driver_typee)
                                                    <option
                                                        value="{{$lkp_driver_typee->id}}">{{$lkp_driver_typee->driver_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.driver')}} </label>
                                            <input name="filter_driverId" id="filter_driverId" type="hidden" value="">
                                            <table style="padding: 0px 0px; !important;">
                                                <tr>
                                                    <td>
                                                        <input class="form-control" name="filter_driverId_input" id="filter_driverId_input" type="text" value="" data-readonly>
                                                    </td>
                                                    <td>
                                                        <button onclick="driver_window();" type="button" class="btn btn-primary btn-xs">
                                                            {{__('drivers.Select')}}
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.ClearingType')}} </label>
                                            <select name="filter_clearing_type_id" id="filter_clearing_type_id" class="form-control">
                                                <option value=""></option>
                                                @foreach($lkp_clearing_type as $lkp_clearing_typee)
                                                    <option
                                                        value="{{$lkp_clearing_typee->id}}">{{$lkp_clearing_typee->clearing_type}}</option>
                                                @endforeach
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
                                            <label for="country" class="form-label">{{__('drivers.BANK')}} </label>
                                            <input type='checkbox' name='filter_bank' id='filter_bank' value="1" class="icheckbox_flat-green">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.Cash')}} </label>
                                            <input type='checkbox' name='filter_cash' id='filter_cash' value="1" class="icheckbox_flat-green">
                                        </div>
                                    </div>
                                    @if (Auth::user()->user_type_id == 1)
                                        <div class="col-xl-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="country" class="form-label">{{__('drivers.ATM')}} </label>
                                                <input type='checkbox' name='filter_ATM' id='filter_ATM' value="1" class="icheckbox_flat-green">
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" name='filter_ATM' id='filter_ATM' value="">
                                    @endif
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">SANED SettledDate</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_SettledDate" name="filter_SettledDate">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Equal </label>
                                            <select name="filter_Equal" id="filter_Equal" class="form-control">
                                                <option value=""></option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
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


<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.driver')}} </h5>
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
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.driver')}}</h5>
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
<div class="modal fade" id="password_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Identity Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{URL("/GoToReadySaned")}}" method="POST">
                @csrf
                <input type="hidden" name="ready_statuss" id="ready_statuss">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xl-12 col-sm-12 col-12">
                            <label for="country" class="form-label">Please Enter Your Password <font style="color: red">*</font> </label>
                            <input type="password" class="form-control" name="password" id="password" required value="" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                    <button class="btn btn-danger" type="submit">{{__('drivers.Submit')}}</button>
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

<div class="row">
    <div class="col-sm-12 col-12">
        <div id="message"></div>
        <!-- Card start -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">SANED Clearing</div>
            </div>
            <!-- Card start -->
            <form method="POST" action="{{ URL('/DriversSANEDClearingPostShe')}}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 16px;"> </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-btn-group">
                                    <button type="button" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                    <button type="button" class="btn btn-primary" type="button" onclick="apply();"></i>Apply for Settlement</button>

                                    {{-- <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="customer_data" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <TH rowspan="2">SANED Date</TH>
                                        <TH rowspan="2">City</TH>
                                        <TH rowspan="2">EMP ID</TH>
                                        <TH rowspan="2">Driver</TH>
                                        <TH rowspan="2">@if(Auth::user()->user_type_id==1 && session('Post_29')==1)<input class="flat-red" type="checkbox" name="select-all" id="select-all" onclick=check_all() />@endif Paid</TH>
                                        <TH rowspan="2">SANED Amount</TH>
                                        <TH rowspan="2">Bander Amount</TH>
                                        <TH rowspan="2">@if(Auth::user()->user_type_id==1 && session('Post_29')==1)<input class="" onclick="selectall_status()" type="checkbox" name="select-all-status" id="select-all-status"/>@endif Status</TH>
                                        <TH rowspan="2">Attempt</TH>
                                        <TH rowspan="2">Bander Date</TH>
                                        <TH rowspan="2">Driver Type</TH>
                                        <TH rowspan="2">Iqama</TH>
                                        <TH rowspan="2">Account Number</TH>
                                        <TH rowspan="2">No Of Dispatch</TH>
                                        <TH rowspan="2">Bander Commission</TH>
                                        <TH rowspan="2">Administrative Fee</TH>
                                        <TH rowspan="2">Type</TH>
                                        @if (Auth::user()->user_type_id == 1)
                                            <TH colspan="3" style="text-align: center!important;border-bottom: 0px!important;">استلام</TH>
                                        @else
                                            <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">استلام</TH>
                                        @endif
                                        <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">تسليم</TH>
                                        <TH rowspan="2">Action</TH>
                                    </tr>
                                    <tr>
                                        <TH>Bank</TH>
                                        <TH>Cash</TH>
                                        @if (Auth::user()->user_type_id == 1)
                                            <TH>ATM</TH>
                                        @endif
                                        <TH>Bank</TH>
                                        <TH>Cash</TH>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <TH colspan='5'>Total</TH>
                                        <TH id="saned_total"></TH>
                                        <TH id="bander_total"></TH>
                                        <TH><button id="status_button" style="display: none" type="button" class="btn btn-primary btn-small" onclick="go_to_ready()" title="Revert status to Ready">Rev.Status</button></TH>
                                        <TH></TH>
                                        <TH></TH>
                                        <TH></TH>
                                        <TH></TH>
                                        <TH></TH>
                                        <TH id="dispatch_total"></TH>
                                        <TH id="bander_com_total"></TH>
                                        <TH id="administrative_fee_total"></TH>
                                        <TH id=""></TH>
                                        <TH id="bank_total1"></TH>
                                        <TH id="cash_total1"></TH>
                                        @if (Auth::user()->user_type_id == 1)
                                            <TH id="atm_total"></TH>
                                        @endif
                                        <TH id="bank_total2"></TH>
                                        <TH id="cash_total2"></TH>
                                        <TH></TH>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="hidden" id="ids" value="">
                            <input type="hidden" id="jahiz_ids" value="">
                            @if(Auth::user()->user_type_id==1 && session('Post_29')==1)
                                <table style="width: 100%">
                                    <tr>
                                        <td style="text-align: center">
                                            <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">تم الدفع</button>
                                        </td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                        @if(Auth::user()->email == "a.omar@btclogistic.com" || Auth::user()->email == "m.shehroze@btclogistic.com" || Auth::user()->email == "amal.ali@btclogistic.com" || Auth::user()->email == "abdulrahman@btclogistic.com" || Auth::user()->email == "rayah@btclogistic.com" || Auth::user()->email == "s.nimir@btclogistic.com" || Auth::user()->email == "rayan.mohammed@btclogistic.com" || Auth::user()->email == "rawabi@btclogistic.com")
                            <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportSTCShe")}}">
                                @csrf
                                <input type="hidden" name="SQL" id="SQL">
                                <table style="width: 100%">
                                    <tr>
                                        <td style="width: 40%">
                                            <button type="submit" name="STC_Report" id="STC_Report" class="btn btn-sm btn-info">STC pay
                                                Excel
                                            </button>

                                    </tr>
                                </table>
                            </form>
                        @endif
                    </div>
                </div>
            </form>
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
        function apply() {
            if ($('#filter_warehouseId').val() == '') {
                alert('Please select city');
            } else if ($('#filter_clearing_type_id').val() != 1) {
                alert('Please select clearing type as استلام');
            } else if (!$('#filter_cash').prop('checked')) {
                alert('Please select the Cash checkbox');
            } else if ($('#filter_bank').prop('checked')) {
                alert('Please unselect the Bank checkbox');
            } else if ($('#filter_ATM').prop('checked')) {
                alert('Please unselect the ATM checkbox');
            } else if ($('#filter_paid_id').val() != 2) {
                alert('Please select Paid type as No');
            } else if ($('#filter_SettledDate').val() == '') {
                alert('Please select Date');
            } else if ($('#filter_Equal').val() != 1) {
                alert('Please select Equal as Yes');
            } else if ($('#cash_total1').html() == '' || $('#cash_total1').html() == 0) {
                alert('There is no record for settlement');
            } else {

                var total = $('#cash_total1').html();
                var ids = $('#ids').val();
                var jahiz_ids = $('#jahiz_ids').val();
                var date = $('#filter_SettledDate').val();
                var selectedTexts = [];
                $('#filter_warehouseId option:selected').each(function() {
                    selectedTexts.push($(this).text());
                });
                var selectedTextString = selectedTexts.join(', ');
                // document.getElementById('response').innerHTML = loader;
                // document.getElementById('edit_modal').style.display = 'block';
                $('#edit_modal').modal('toggle');
                let action = "{{URL('/apply-settlement')}}";
                data = `<form action="`+action+`" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                        <span style="display: flex">
                            <h5 style="width: 50%"><b>City:</b> `+selectedTextString+`</h5>
                            <h5 style="width: 50%"><b>Clearing Type:</b> استلام</h5>
                        </span>
                        <span style="display: flex">
                            <h5 style="width: 50%"><b>Currency Type:</b> Cash</h5>
                            <h5 style="width: 50%"><b>Paid:</b> No</h5>
                        </span>
                        <span style="display: flex">
                            <h5 style="width: 50%"><b>Date:</b> `+date+`</h5>
                            <h5 style="width: 50%"><b>Total:</b> `+total+`</h5>
                        </span>
                        <input type="hidden" name="ids" value="`+ids+`">
                        <input type="hidden" name="jahiz_ids" value="`+jahiz_ids+`">
                        <input type="hidden" name="period" value="`+date+`">
                        <input type="hidden" name="table" value="drivers_saned_settlement">
                        <input type="hidden" name="module" value="Drivers Saned Settlement">
                        <p style="color: red">The request for settlement will be sent to Finance Manager.</p>
                        <h5>Total:</h5> <input type="number" min="0" name="total" id="total" style="width: 100%;" onkeyup="validate_total()" required>
                        <h5>Proof file:</h5> <input type="file" name="prof_file" style="width: 100%;" required><br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                            <button type="submit" class="btn btn-primary" disabled id="submit_btn">Submit</button>
                        </div>
                        </form>`;
                document.getElementById('response').innerHTML = data;
            }
        }
        function validate_total() {
            var total = $('#cash_total1').html();
            var total1 = $('#total').val();

            $('#submit_btn').prop('disabled', true);
            if (total == total1) {
                $('#submit_btn').prop('disabled', false);
            }
        }
        function revert_status(id, name, job_id, amount)
        {
            // document.getElementById('response').innerHTML = loader;
            // document.getElementById('edit_modal').style.display = 'block';
            $('#edit_modal').modal('toggle');
            let action = "{{URL('/Saned-revert')}}";
            data = `<form action="`+action+`" method="POST">
                    @csrf
                    <div class="modal-body">
                        <h5>Reason</h5>
                        <input type="hidden" name="saned_id" value="`+id+`">
                        <h5 style="">Name: `+name+`</h5>
                        <h5 style="">Job id: `+job_id+`</h5>
                        <h5 style="">Amount: `+amount+`</h5>
                        <p style="color: red">The request for revert back to ready satge will be sent to Finance Manager.</p>
                        <textarea name="reason" id="reason" style="width: 100%; height: 200px" required></textarea>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="button" data-bs-dismiss="modal" class="btn btn-light">Close</button>
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
                // document.getElementById('password_modal').style.display = 'block';
                $('#password_modal').modal('toggle');
            } else {
                alert('Please select atleast one checkbox');
            }
        }
        $(document).ready(function () {
            $('#filter_SettledDate').val('');
            // Clear the input when the cancel button is clicked
            $('#filter_SettledDate').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
	    $('#customer_data').DataTable({
                order: [],
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                bAutoWidth: false,
                aoColumnDefs: [
                    {
                        bSortable: false,
                        aTargets: [ 4, 7 ]
                    }
                ],
                responsive: true,
                processing: true,
            });


            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                // document.getElementById('response').innerHTML = loader;
                // document.getElementById('edit_modal').style.display = 'block';
                $('#edit_modal').modal('toggle');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/DriversSANEDClearing')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });


            $('#filter').click(function () {
                if ($('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_clearing_type_id').val() != '' || $('#filter_bank').prop("checked") || $('#filter_cash').prop("checked") || $('#filter_ATM').prop("checked") || $('#filter_paid_id').val() != '' || $('#filter_Equal').val() != ''|| $('#filter_driver_type_id').val() != '' || $('#filter_SettledDate').val() != '') {
                    // card_change();
                    $('#pre_loader_build').show();
                    // $('#customer_data').DataTable().destroy();
                    $.ajax({
                        type: 'POST',
                        url:"{{ url('DriversSANEDClearingControllerSheindex') }}",
                        data:{
                            filter_warehouseId: $('#filter_warehouseId').val(),
                            filter_job_id: $('#filter_job_id').val(),
                            filter_driverId: $('#filter_driverId').val(),
                            filter_clearing_type_id: $('#filter_clearing_type_id').val(),
                            filter_bank: $('#filter_bank:checked').val(),
                            filter_cash: $('#filter_cash:checked').val(),
                            filter_ATM: $('#filter_ATM:checked').val(),
                            filter_paid_id: $('#filter_paid_id').val(),
                            filter_SettledDate: $('#filter_SettledDate').val(),
                            filter_Equal: $('#filter_Equal').val(),
                            filter_driver_type_id: $('#filter_driver_type_id').val(),
                            _token: "{{ csrf_token() }}"
                        }, success:function(data){
                            data = data.split(":::");
                            $('#customer_data').DataTable().clear();

                            $('#customer_data').DataTable().rows.add($(data[0])).draw();
                            $('#saned_total').html(data[1]);
                            $('#bander_total').html(data[2]);
                            $('#dispatch_total').html(data[3]);
                            $('#bander_com_total').html(data[4]);
                            $('#bank_total1').html(data[5]);
                            $('#cash_total1').html(data[6]);
                            $('#atm_total').html(data[7]);
                            $('#bank_total2').html(data[8]);
                            $('#cash_total2').html(data[9]);
                            $('#pre_loader_build').hide();
                            $('#STC_Report').attr('disabled', false);
                            $("#status_button").hide();
                            if (data[10] == 0) {
                                $('#STC_Report').attr('disabled', true);
                            }
                            if (data[11] == 1) {
                               $("#status_button").show();
                            }
                            $("#SQL").val(data[12]+" and drivers_saned_settlement.status = 'Ready'");
                            $('#administrative_fee_total').html(data[13]);
                            $('#ids').val(data[14]);
                            $('#jahiz_ids').val(data[15]);

                            let html = '';
                            if ($('#filter_job_id').val() > 0)
                                html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_job_id').val()+'</button>';
                            var selectedOptions = $('#filter_warehouseId option:selected');
                            let warehouses = '';
                            if (selectedOptions.length > 0) {
                                selectedOptions.each(function() {
                                    var selectedText = $(this).text();
                                    if (selectedText) {
                                        warehouses += selectedText;
                                    }
                                });
                                html += '<button type="button" class="btn btn-outline-secondary btn-rounded">' + warehouses + '</button> ';
                            }
                            if ($('#filter_driver_type_id').val() != '')
                                html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_driver_type_id option:selected').text()+'</button>';
                            if ($('#filter_driverId').val() != '')
                                html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_driverId').val()+'</button>';

                            if ($('#filter_bank').checked)
                                html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_bank:checked').val()+'</button>';
                            if ($('#filter_cash').checked)
                                html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_cash:checked').val()+'</button>';
                            if ($('#filter_ATM').checked)
                                html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_ATM:checked').val()+'</button>';
                            if ($('#filter_clearing_type_id').val() != '')
                                html += '<button type="button" class="btn btn-outline-dark btn-rounded">'+$('#filter_clearing_type_id option:selected').text()+'</button>';
                            if ($('#filter_SettledDate').val() != '')
                                html += '<button type="button" class="btn btn-outline-danger btn-rounded">Updated at: '+$('#filter_SettledDate').val()+'</button>';
                            if ($('#filter_Equal').val() > 0)
                                html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_Equal option:selected').text()+'</button>';
                            if ($('#filter_paid_id').val() > 0)
                                html += '<button type="button" class="btn btn-outline-dark btn-rounded">'+$('#filter_paid_id option:selected').text()+'</button>';

                            if(html != '') {
                                $('#edit_btn').show();
                                $('#selectedCriteria').html(html);
                            } else {
                                $('#edit_btn').hide();
                            }
                        }

                    });
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {
                $('#filter_warehouseId').val('');
                $('#filter_job_id').val('');
                $('#filter_driverId').val('');
                $('#filter_driverId_input').val('');
                $('#filter_clearing_type_id').val('');
                $('#filter_bank').prop("checked", false);
                $('#filter_cash').prop("checked", false);
                $('#filter_ATM').prop("checked", false);
                $('#filter_paid_id').val('');
                $('#filter_Equal').val('');
                $('#filter_driver_type_id').val('');
                $('#filter_SettledDate').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });

        function check_all() {
            if (document.getElementById('select-all').checked) {
                $('.flat-red').attr('checked', true);
            } else
                $('.flat-red').attr('checked', false);
        }
        function selectall_status() {
            if (document.getElementById('select-all-status').checked)
                $('.check-status').attr('checked', true);
            else
                $('.check-status').attr('checked', false);
        }
        function status() {
            var status_id = document.getElementById('status_id').value;
            if (status_id == "3")
                document.getElementById("Termination_Reason").style.display = '';
            else
                document.getElementById("Termination_Reason").style.display = 'none';
        }

        function driver_window() {
            $('#filter_driverId').val('');
            $('#filter_driverId_input').val('');
            myWindow1 = window.open("{{URL("/DriverJahizWindow")}}", "",
                "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
        }

        function driver(id) {
            // document.getElementById('response').innerHTML = loader;
            // document.getElementById('edit_modal').style.display = 'block';
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

        function WarehouseName() {

            var filter_companyId = document.getElementById('filter_companyId').value;
            if (filter_companyId == "")
                $('#filter_warehouseId').empty();
            else {
                $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_warehouseId').empty();
                    $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
        }


    </script>
    <script>
        function validateForm() {


            if ($('#filter_warehouseId').val() == '') {
                alert('يجب اختيار ال CITY');
                return false;
            }
            if (!$('#filter_bank').prop("checked")) {
                alert('يجب اختيار ال Bank');
                return false;
            }
            if ($('#filter_paid_id').val() != '2') {
                alert('يجب اختيار ال Paid = لا');
                return false;
            }
            if ($('#filter_SettledDate').val() == '') {
                alert('يجب اختيار ال SANED SettledDate');
                return false;
            }

            if ($('#SQL').val().indexOf("drivers_saned_settlement.drivers_jahiz_clearing_paid_id is  null") == -1) {
                alert('يجب الضغط علي  Filter');
                return false;
            }
            setTimeout(function() {
                location.reload();
            }, 5000);
            return true;

        }


    </script>
@stop
@endsection
