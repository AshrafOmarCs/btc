@extends('layout2')
@section('content')
@section('title', 'Claims Deduction')

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
                                            <label for="country" class="form-label">Company Name </label>
                                            <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                                    class="form-control" required>
                                                <option value=""></option>
                                                @foreach($lkp_company as $company)
                                                    <option value="{{ $company->id }}">{{ $company->companyName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Warehouse Name </label>
                                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Period </label>
                                            <select name="filter_period" id="filter_period"  class="form-control" required>

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
                <button type="button" id="reset" class="btn btn-dark" data-bs-dismiss="modal" onclick="reset_records()">{{__('drivers.Close')}}</button>
                <button type="button" class="btn btn-success"
                    data-bs-dismiss="modal" id="filter" onclick="confirmSearch()">{{__('drivers.Search')}}</button>
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
                                0=>'Company',
                                1=>'Warehouse',
                                2=>'City',
                                3=>'Job Id',
                                4=>'Driver',
                                5=>'Phone',
                                6=>'Iqama',
                                7=>'STC Pay',
                                8=>'Last Settelment date',
                                9=>'Amount',
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
                <div class="card-title">Claims Deduction</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">By this module, you can see the claims deduction information for each driver by selecting a specific date range. </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button>
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
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered">
                            <thead id="header">
                                <TH>Sr. No</TH>
                                <TH >Company</TH>
                                <TH >Warehouse</TH>
                                <TH >City</TH>
                                <TH >Job Id</TH>
                                <TH >Driver</TH>
                                <TH >Phone</TH>
                                <TH >Iqama</TH>
                                <TH >STC Pay</TH>
                                <TH >Last Settelment date</TH>
                                <TH >Amount</TH>
                                <TH >Action</TH>

                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <TH colspan = '10' style="text-align: center;">Total</TH>
                                <TH id="total_amount" style="text-align: right;"></TH>
                                <th></th>
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

    <script>
        $(document).ready( function () {
            $(document).ajaxStart(function() {
                $("#loader").show();
            });
            $(document).ajaxStop(function() {
                $("#loader").hide();
            });
            call_datatable("Claims of companies except Jahiz");
            function call_datatable(excel_title) {
                $('#customer_data').DataTable({
        	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    dom: 'lBfrtip',
                    "buttons": [
                        {
                            extend: 'excel',
                            text: 'Export to Excel',
                            title: excel_title,
                            exportOptions: {

                                modifier: {
                                    search: 'applied',
                                    order: 'applied'
                                }
                            },
                            action: function (e, dt, button, config) {
                                config.exportOptions = {
                                    rows: function (idx, data, node) {
                                        return data[10] > -200;
                                    }
                                };
                                $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                            },
                        }
                    ],
                    //searching: false,
                    order: [[ 10, "desc" ]],
                    responsive: true,
                    processing: true,
                    "pagingType": "full_numbers",
                    "autoWidth": false,
        	    });
            }
        });
        function sheet(id, Period) {
            myWindow1 = window.open("/SalaryShow" + "/" + id + "/" + Period, "",
                "height=1000,width=650,scrollbars=yes,top=1,left=1,status,resizable");
        }
        $('#customer_data tbody').on('click', '.statement', function (e) {
            e.preventDefault();
            // document.getElementById('response1').innerHTML = loader;
            // document.getElementById('edit_modal').style.display = 'block';
            $('#edit_modal').modal('toggle');

            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: "/statement" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response1').innerHTML = data;
                }
            });

        });
        function WarehouseName() {

            var filter_companyId = document.getElementById('filter_companyId').value;
            $('#filter_warehouseId').empty();

            $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
                $('#filter_warehouseId').empty();
                $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ""));
                $.each(json, function (i, obj) {
                    $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                });
            });


            // period puplating
            $('#filter_period').empty();
            $.getJSON("{{URL("/getPeriod")}}" + "/" + filter_companyId, function (json) {

                $.each(json, function (i, obj) {
                    $('#filter_period').append($('<option>').text(obj.name).attr('value', obj.id));
                });
                //  $('#filter_period').append(json.htmlContent);

            });
            // filter_period


        }
        function confirmSearch(){
            if($('#filter_period').val() == ''){
                alert('Date can not Be Empty');
            }else {
                var filter_companyId = filter_warehouseId = filter_dateFrom = filter_dateTo = '';
                filter_companyId = $('#filter_companyId').val();
                filter_warehouseId = $('#filter_warehouseId').val();
                filter_dateTo = $('#filter_period').val();
                filter_dateFrom = '2019-01-01';
                var excel_title = "Claims of companies except Jahiz from " + filter_dateFrom + " to " + filter_dateTo;

                $("#response").show();
                $("#customer_data").hide();
                // document.getElementById('response').innerHTML = loader;
                let url = '{{url('New-Portal/ClaimsDeduction/Search')}}';
                var postData = {
                    filter_companyId: filter_companyId,
                    filter_warehouseId: filter_warehouseId,
                    filter_dateFrom: filter_dateFrom,
                    filter_dateTo: filter_dateTo,

                    _token: "{{ csrf_token() }}",
                };
                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    data: postData,
                    success: function (data) {
                        data = data.split(':::');
                        $('#customer_data').DataTable().clear();
                        $('#customer_data').DataTable().rows.add($(data[0])).draw();
                        $("#total_amount").html(data[1]);
                        $("#response").hide();
                        $("#customer_data").show();
                        let html = "";
                        if ($('#filter_companyId').val() > 0)
                            html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_companyId option:selected').text()+'</button>';
                        if ($('#filter_warehouseId').val() > 0)
                            html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_warehouseId option:selected').text()+'</button>';
                        if ($('#filter_period').val() != '')
                            html += '<button type="button" class="btn btn-outline-dark btn-rounded">'+$('#filter_period').val()+'</button>';

                        if(html != '') {
                            $('#edit_btn').show();
                            $('#selectedCriteria').html(html);
                        } else {
                            $('#edit_btn').hide();
                        }
                        // call_datatable(excel_title);
                    },
                    error: function (jqXHR, status, error) {
                        alert(status + ": " + error);
                    }
                });
            }
        }

        function reset_records() {
            $('#filter_companyId').val('');
            $('#filter_warehouseId').html('');
            $('#filter_period').val('');
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
            $('#total').html(selected.length);
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
            $('#total').html(selected.length);
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
            selected.forEach(element => {
                // if (element['id'] == 7) {
                //     let id  = element['id'] + 2;
                //     selectedColumns.push(id);
                // } else if (element['id'] == 8) {
                //     let id  = element['id'] + 3;
                //     selectedColumns.push(id);
                // } else {
                    selectedColumns.push(element['id'] + 1);
                // }
            });
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
            XLSX.writeFile(wb, 'Claims Deduction.xlsx');
        });
    </script>
@stop
@endsection
