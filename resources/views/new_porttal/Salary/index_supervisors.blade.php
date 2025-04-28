@extends('layout2')
@section('content')
@section('title', 'Salary')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                                            <label for="country" class="form-label">Warehouse </label>
                                            <select name="filter_warehouseId" id="filter_warehouseId" class="form-control" multiple style="width:200px;">
                                            </select><br>
                                            <small style="display: none; color: red" id="multiple_tag">To select multiple items, Ctrl-click each item.</small>
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
                        <table id="table" style="width: 100%">
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
                                    Total Select (<span style="color: red" id="total">0</span>)
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
<!--End Modal ExportExcel 3 -->
@php
$module = "Supervisor";
@endphp
@include('new_porttal.partials.delete_modal')

<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.driver')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response1">
            </span>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
            </div>
        </div>
    </div>
</div>
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
                    <div class="card-title" style="font-size: 16px;">From this page you can update drivers essential data. </div>
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
                    <div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999;">
                            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
                                <lottie-player
                                    src="https://assets9.lottiefiles.com/packages/lf20_usmfx6bp.json"
                                    background="transparent"
                                    speed="1"
                                    style="width: 200px; height: 200px;"
                                    loop
                                    autoplay>
                                </lottie-player>
                                <p style="margin-top:20px; font-size:18px; font-weight:bold; color:#555;">Fetching your data...</p>
                            </div>
                        </div>
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle" rowspan="2">Whouse</th>
                                    <th style="vertical-align: middle" rowspan="2">Driver</th>
                                    <th style="vertical-align: middle" rowspan="2">ID</th>
                                    <th style="vertical-align: middle" rowspan="2">Did</th>
                                    <th style="vertical-align: middle" rowspan="2">Days</th>
                                    <th style="vertical-align: middle" rowspan="2">P. Balance</th>
                                    <th style="vertical-align: middle" rowspan="2">Loan</th>
                                    <th style="vertical-align: middle" rowspan="2">CreditNote</th>
                                    <th colspan="2" style="text-align: center;">Settlement</th>
                                    <th style="vertical-align: middle" rowspan="2">Credit</th>
                                    <th style="vertical-align: middle" rowspan="2">Debit</th>
                                    <th style="vertical-align: middle" rowspan="2">Net Salary</th>
                                    <th colspan="2" style="text-align: center;">Personal Info</th>
                                    <th colspan="2" style="text-align: center;">STC Info</th>
                                </tr>
                                <tr>
                                    <th>Credit</th>
                                    <th>Debit</th>

                                    <th>Mobile</th>
                                    <th>Iqama</th>
                                    <th>Account Number</th>
                                    <th>Account Owner Iqama</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <th style="background-color: white" colspan=16></th>
                                <th style="background-color: white"><input type="button" class="btn btn-primary" value="Submit" disabled id="submit_btn" onclick="sendDriverData('{{AUTH::user()->name}}', '{{AUTH::user()->IdentityNo}}', '{{AUTH::user()->phone}}')"></th>
                            </tfoot>
                        </table>
                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validateAndSubmit(driverId , type, input) {
            let value = input.value;
            var pattern = "";
            if (type == 1)
                pattern = /^5\d{8}$/;
            else if (type == 2 || type == 4)
                pattern = /^\d{10}$/;
            else if (type == 3)
                pattern = /^966\d{9}$/;


            if (type == 1) {
                if (pattern.test(value)) {
                    input.classList.remove("red");
                    update_array(driverId, type, value);
                } else {
                    if (value == '') {
                        $('#submit_btn').prop('disabled', false);
                        update_array(driverId, type, -1);
                    } else {
                        input.classList.add("red");
                        $('#submit_btn').prop('disabled', true);
                        input.focus();
                        alert('The number must be a 9-digit number starting with 5');
                    }
                }
            } else if (type == 3) {
                if (pattern.test(value)) {
                    input.classList.remove("red");
                    update_array(driverId, type, value);
                } else {
                    if (value == '') {
                        $('#submit_btn').prop('disabled', false);
                        update_array(driverId, type, -1);
                    } else {
                        input.classList.add("red");
                        $('#submit_btn').prop('disabled', true);
                        input.focus();
                        alert('The number must be a 12-digit number starting with 966');
                    }
                }
            } else if (type == 2 || type == 4) {
                if (pattern.test(value)) {
                    input.classList.remove("red");
                    update_array(driverId, type, value);
                } else {
                    if (value == '') {
                        $('#submit_btn').prop('disabled', false);
                        update_array(driverId, type, -1);
                    } else {
                        input.classList.add("red");
                        $('#submit_btn').prop('disabled', true);
                        input.focus();
                        alert('The Iqama number must be a 10-digit number');
                    }
                }
            }
        }
        var driver_object = [];
        function update_array(driverId , type, input_value) {
            $('#submit_btn').prop('disabled', false);
            let driver = driver_object.find(d => d.driverId === driverId);

            if (!driver) {
                // If driver object does not exist, create a new one
                driver = { driverId: driverId };
                driver_object.push(driver);
            }

            // Update the driver object based on the type
            switch (type) {
                case 1:
                    driver.mobileNumber = input_value;
                    break;
                case 2:
                    driver.iqama = input_value;
                    break;
                case 3:
                    driver.accountNumber = input_value;
                    break;
                case 4:
                    driver.account_owner_iqama = input_value;
                    break;
            }
        }
        function sendDriverData(name, iqama, phone) {
            if (driver_object.length > 0) {
                Swal.fire({
                    html: `<span style="direction: rtl; display: block; text-align: center;">
                    إقرار تعهد  <br>
                    اتعهد انا: ${name} حامل هوية/إقامة رقم: ${iqama} ورقم جوال: ${phone}
                    ان المعلومات المدخلة صحيحة وتم التحقق منها بشكل مباشر من قبل المناديب <br>
                    واتحمل كامل المسؤولية حالة حدوث أي خطأ ترتب عليه تحويل مالي نتيجة ادخال/تحديث بيانات المناديب
                   </span>`,
                   icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'تأكيد',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#submit_btn').prop('disabled', true);
                        $('#pre_loader_build').show();
                        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        let company = $('#filter_companyId option:selected').text();
                        let period = $('#filter_Period').val();
                        $.ajax({
                            url: "{{URL("New-Portal/BulkDriversUpdate")}}",
                            method: 'POST',
                            data: JSON.stringify({
                                drivers: driver_object,
                                period: period,
                                company: company
                            }),
                            contentType: 'application/json',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
                            },
                            success: function(response) {
                                $('#pre_loader_build').hide();
                                Swal.fire({
                                    title: 'Data updated successfully',
                                    icon: 'success',
                                    confirmButtonText: 'Okay',
                                })
                                driver_object = [];
                                // location.reload();
                            },
                            error: function(xhr, status, error) {
                                if (xhr.status === 422) {
                                    var errors = xhr.responseJSON.errors;
                                    var errorMessages = '';
                                    $.each(errors, function(key, value) {
                                        errorMessages += value[0] + '\n';
                                    });
                                    alert(errorMessages);
                                } else {
                                    alert('An unexpected error occurred.');
                                }
                            }
                        });
                    } else {
                        // Code to execute if user clicks 'Cancel'
                        console.log('User canceled');
                    }
                });
            } else {
                alert("Please update atleast one record!");
            }
        }
    $(document).ready(function() {
	    $('#customer_data').DataTable({
	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: 'lBfrtip',
            bAutoWidth: false,
            aoColumnDefs: [
              {
                //  bSortable: false,
                //  aTargets: [ -1, -4, -9 ]
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

        $('#filter').click(function () {

            if ($('#filter_companyId').val() != '' && $('#filter_Period').val() != '') {
                // $('#submit_btn').hide();
                $('#submit_btn').prop('disabled', true);
                driver_object = [];
                $('#pre_loader_build').show();
                // $('#customer_data').DataTable().destroy();
                $.ajax({
                    url:"{{ URL('New-Portal/Salaries') }}",
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
                        $('#pre_loader_build').hide();
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

    });

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
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
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
            myWindow1 = window.open("{{URL('/SalaryShow')}}" + "/" + id + "/" + Period, "",
                "height=1000,width=650,scrollbars=yes,top=1,left=1,status,resizable");
        }

    </script>
@stop
@endsection
