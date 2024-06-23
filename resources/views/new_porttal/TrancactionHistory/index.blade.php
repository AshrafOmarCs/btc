@extends('layout2')
@section('content')
@section('title', 'Transaction-History')
<style>

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
                                            <label for="country" class="form-label">AMP ID </label>
                                            <input  class="form-control" type="text" id="amp_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">STCPAY Identity </label>
                                            <input  class="form-control" type="number" id="account_number">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">STCPAY Number </label>
                                            <input  class="form-control" type="number" id="id_no">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Trancation date </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-calendar4"></i>
                                                </span>
                                                <input type="text" class="form-control datepicker-range" id="selected_date" name="selected_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Trancation type </label>
                                            <select class="form-control" id="trancation_type">
                                                <option value="all" selected>ALL</option>
                                                <option value="salaries">Salaries</option>
                                                <option value="loans">Loans</option>
                                                <option value="jahiz">Jahiz Payments</option>
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
$module = "Transaction";
@endphp
@include('new_porttal.partials.export_excel')
@include('new_porttal.partials.delete_modal')

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
                <div class="card-title">Transaction History</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">From this page you can pull all trancation related to provided AMP ID or STCPAY Account Deatils. </div>
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
                                <th>STCPAY Identity</th>
                                <th>STCPAY Number</th>
                                <th>Company</th>
                                <th>HUB </th>
                                <th>Driver AMP </th>
                                <th>Driver Name</th>
                                <th>Trancation Date</th>
                                <th>Driver's dues</th>
                                <th>Transaction Count</th>
                                <th>Transaction Total</th>
                                <th>Trancation Type </th>

                            </thead>
                            <tbody id="tbl_body">


                            </tbody>
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
        $(document).ready(function() {

            $('#selected_date').val('');
            $('#selected_date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
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
                //searching: false,
                responsive: true,
                processing: true,
                "pagingType": "full_numbers",
                "autoWidth": false,
            });
        });
        function confirmSearch(){
            if($('#amp_id').val() == '' && $('#account_number').val() == '' && $('#id_no').val() == ''){

                alert('STCPAY Number Can not all Be Empty');
            }else{
                $("#response").show();
                $("#customer_data").hide();
                // document.getElementById('response').innerHTML = loader;
                let url = '{{url('Transaction-History/Search')}}';
                let amp_id = $('#amp_id').val();
                var postData = {
                    trancation_type:$('#trancation_type').val(),
                    amp_id:$('#amp_id').val(),
                    account_number:$('#account_number').val(),
                    id_no:$('#id_no').val(),
                    selected_date:$('#selected_date').val(),
                    transaction_date:$('#trancation_type').find(":selected").val(),
                    _token: "{{ csrf_token() }}",
                };
                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    data: postData,
                    success: function (data) {
                        $('#customer_data').DataTable().clear();
                        if (data.length > 0) {
                            for(var i = 0; i < data.length; i++){
                                var row = data[i];
                                $('#customer_data').DataTable().row.add([
                                  row.account_owner_iqama, row.accountNumber, row.companyName, row.warehouseName, row.AMP_ID, row.fullName, row.create_at, row.bank_paid, row.CO, row.bank_sum, row.type
                                ]).draw();
                            }
                        } else {
                            $('#customer_data').DataTable().rows.add($(data)).draw();
                        }
                        $("#response").hide();
                        $("#customer_data").show();

                        let html = "";
                        if ($('#amp_id').val() != '')
                            html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#amp_id').val()+'</button>';
                        if ($('#account_number').val() != '')
                            html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#account_number').val()+'</button>';
                        if ($('#id_no').val() != '')
                            html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#id_no').val()+'</button>';
                        if ($('#selected_date').val() != '')
                            html += '<button type="button" class="btn btn-outline-dark btn-rounded">'+$('#selected_date').val()+'</button>';

                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#trancation_type option:selected').text()+'</button>';


                        if(html != '') {
                            $('#edit_btn').show();
                            $('#selectedCriteria').html(html);
                        } else {
                            $('#edit_btn').hide();
                        }
                    },

                    error: function (jqXHR, status, error) {
                        alert(status + ": " + error);
                    }
                });
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
            XLSX.writeFile(wb, 'Transaction History.xlsx');
        });

    </script>
@stop
@endsection
