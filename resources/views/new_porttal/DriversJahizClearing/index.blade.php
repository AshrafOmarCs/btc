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
                                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control">
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
                                            <label for="country" class="form-label">{{__('drivers.BanderAmount')}} </label>
                                            <select name="filter_Jahiz_Amount_Sign" id="filter_Jahiz_Amount_Sign" class="form-control">
                                                <option value=""></option>
                                                <option value="1">+</option>
                                                <option value="2">-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.Month')}} </label>
                                            <select name="filter_jahiz_period_id" id="filter_jahiz_period_id" class="form-control" >
                                                <option value=""></option>
                                                @foreach($lkp_jahiz_period as $lkp_jahiz_periods)
                                                    <option
                                                        value="{{$lkp_jahiz_periods->id}}">{{$lkp_jahiz_periods->ym}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.Week1')}} </label>
                                            <input type='checkbox' name='filter_week1' id='filter_week1' value="40" class="icheckbox_flat-green">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.Week2')}} </label>
                                            <input type='checkbox' name='filter_week2' id='filter_week2' value="40" class="icheckbox_flat-green">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.Week3')}} </label>
                                            <input type='checkbox' name='filter_week3' id='filter_week3' value="35" class="icheckbox_flat-green">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.Week4')}} </label>
                                            <input type='checkbox' name='filter_week4' id='filter_week4' value="35" class="icheckbox_flat-green">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('drivers.AllMonth')}} </label>
                                            <input type='checkbox' name='filter_weekAll' id='filter_weekAll' value="150" class="icheckbox_flat-green">
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
                                        <label for="country" class="form-label">{{__('drivers.Created_At')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_created_at" name="filter_created_at">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.Updated_At')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_updated_at" name="filter_updated_at">
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
                <div class="card-title">{{__('drivers.BanderClearing')}}</div>
            </div>
            <!-- Card start -->
            <form method="POST" action="{{ URL('/DriversJahizClearingPost')}}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 16px;">{{__('drivers.driver_module')}} </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-btn-group">
                                    <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
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
                                        <TH rowspan="2">Update At</TH>
                                        <TH rowspan="2">City</TH>
                                        <TH rowspan="2">EMP ID</TH>
                                        <TH rowspan="2">Driver</TH>
                                        <TH rowspan="2">Paid</TH>
                                        <TH rowspan="2">Driver Type</TH>
                                        <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">Bander Amount
                                        </TH>
                                        <TH colspan="7" style="text-align: center!important;border-bottom: 0px!important;width: 90px">Week
                                        </TH>
                                        <TH rowspan="2">Bander Commission</TH>
                                        @if (Auth::user()->user_type_id == 1)
                                        <TH colspan="3" style="text-align: center!important;border-bottom: 0px!important;">استلام</TH>
                                        @else
                                            <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">استلام</TH>
                                        @endif
                                        <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">تسليم</TH>
                                    </tr>
                                    <tr>
                                        <TH>+</TH>
                                        <TH>-</TH>
                                        <TH style="text-align: center;padding: .3em .3em !important;">Month</TH>
                                        <TH style="text-align: center;padding: .3em .3em !important;">1</TH>
                                        <TH style="text-align: center;padding: .3em .3em !important;">2</TH>
                                        <TH style="text-align: center;padding: .3em .3em !important;">3</TH>
                                        <TH style="text-align: center;padding: .3em .3em !important;">4</TH>
                                        <TH style="text-align: center;padding: .3em .3em !important;">All</TH>
                                        <TH style="text-align: center;padding: .3em .3em !important;">By Days</TH>
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
                                        <TH colspan='6'>Total</TH>
                                        <TH></TH>
                                        <TH></TH>
                                        <TH></TH>

                                        <TH style="padding: .3em .3em !important;vertical-align: middle;!important;"></TH>
                                        <TH style="padding: .3em .3em !important;vertical-align: middle;!important;"></TH>
                                        <TH style="padding: .3em .3em !important;vertical-align: middle;!important;"></TH>
                                        <TH style="padding: .3em .3em !important;vertical-align: middle;!important;"></TH>
                                        <TH style="padding: .3em .3em !important;vertical-align: middle;!important;"></TH>
                                        <TH style="padding: .3em .3em !important;vertical-align: middle;!important;"></TH>
                                        <TH></TH>
                                        <TH></TH>
                                        <TH></TH>
                                        <TH></TH>
                                        <TH></TH>
                                        @if (Auth::user()->user_type_id == 1)
                                        <TH></TH>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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
        $(document).ready(function () {
            $('#filter_updated_at').val('');
            $('#filter_created_at').val('');

            // Clear the input when the cancel button is clicked
            $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_updated_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            fill_datatable();
            function fill_datatable(filter_warehouseId = '', filter_job_id = '', filter_driver_type_id = '', filter_driverId = '', filter_Jahiz_Amount_Sign = '', filter_jahiz_period_id = '', filter_week1 = '', filter_week2 = '', filter_week3 = '', filter_week4 = '', filter_weekAll = '', filter_clearing_type_id = '', filter_bank = '', filter_cash = '',filter_ATM = '', filter_paid_id = '', filter_created_at = '', filter_updated_at = '') {
                var dataTable = $('#customer_data').DataTable({
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "order": [[0, "desc"]],
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function () {
                        var api = this.api()
                        var json = api.ajax.json();

                        $(api.column(6).footer()).html(json.Jahiz_Amount_plus);
                        $(api.column(7).footer()).html(json.Jahiz_Amount_minus);
                        $(api.column(9).footer()).html(json.week1);
                        $(api.column(10).footer()).html(json.week2);
                        $(api.column(11).footer()).html(json.week3);
                        $(api.column(12).footer()).html(json.week4);
                        $(api.column(13).footer()).html(json.weekAll);
                        $(api.column(14).footer()).html(json.amount_by_days);
                        $(api.column(15).footer()).html(json.Bander_Commission);
                        $(api.column(16).footer()).html(json.bank_plus);
                        $(api.column(17).footer()).html(json.cash_plus);
                        @if (Auth::user()->user_type_id == 1)
                        $(api.column(18).footer()).html(json.ATM_plus);
                        $(api.column(19).footer()).html(json.bank_minus);
                        $(api.column(20).footer()).html(json.cash_minus);
                        @else
                        $(api.column(18).footer()).html(json.bank_minus);
                        $(api.column(19).footer()).html(json.cash_minus);
                        @endif


                    },
                    ajax: {
                        url: "{{ route('DriversJahizClearing.index') }}",
                        data: {

                            filter_warehouseId: filter_warehouseId,
                            filter_job_id: filter_job_id,
                            filter_driver_type_id: filter_driver_type_id,
                            filter_driverId: filter_driverId,
                            filter_Jahiz_Amount_Sign: filter_Jahiz_Amount_Sign,
                            filter_jahiz_period_id: filter_jahiz_period_id,
                            filter_week1: filter_week1,
                            filter_week2: filter_week2,
                            filter_week3: filter_week3,
                            filter_week4: filter_week4,
                            filter_weekAll: filter_weekAll,
                            filter_clearing_type_id: filter_clearing_type_id,
                            filter_bank: filter_bank,
                            filter_cash: filter_cash,
                            filter_ATM: filter_ATM,
                            filter_paid_id: filter_paid_id,
                            filter_created_at: filter_created_at,
                            filter_updated_at: filter_updated_at,
                        }
                    },

                    columns: [

                        {
                            data: 'updated_at',
                            name: 'drivers_jahiz_clearing.updated_at'
                        },
                        {
                            data: 'warehouseName',
                            name: 'warehouse.warehouseName',
                            //visible:false
                        },
                        {
                            data: 'job_id',
                            name: 'drivers.job_id'
                        },
                        {
                            data: 'fullName',
                            name: 'drivers.fullName',
                            render: function (data, type, row, meta) {
                                return '<a href="javascript:driver(' + row.driverId + ')">' + data + '</a>';
                            }
                        },

                        {
                            data: 'paid_id',
                            //"orderable": false,
                            "className": "text-center",
                            "render": function (data, type, row, meta) {
                                if (!row.paid_id) {
                                    return '<span class="label label-warning">No</span>';
                                } else return '<span class="label label-success">Yes</span>';
                            }
                        },


                        {
                            data: 'driver_type',
                            name: 'lkp_driver_type.driver_type'
                        },
                        {
                            "searchable": false,
                            className: "table-success",

                            data: 'Jahiz_Amount_plus',
                            name: 'Jahiz_Amount_plus'
                        },
                        {
                            "searchable": false,
                            className: "table-danger",
                            data: 'Jahiz_Amount_minus',
                            name: 'Jahiz_Amount_minus'

                        },

                        {

                            "sortable": false,
                            className: "table-cell-nolrpadding",
                            render: function (data, type, row, meta) {
                                if (row.jahiz_montly) {
                                    var str = row.jahiz_montly;
                                    var all = '<table  style="width:100%">';
                                    var res = str.split(";");
                                    all += '<tr>';

                                    for (var i = 0; i < res.length; i++) {
                                        var one = res[i].split("_");
                                        all += '<td class="tab-boder"><b>' + one[0] + '</b></td>';

                                        all += '</tr>';
                                    }
                                    all += '</table>';
                                    return all;

                                } else
                                    return '';

                            }
                        },
                        {

                            "sortable": false,
                            className: "table-cell-nolrpadding",
                            render: function (data, type, row, meta) {
                                if (row.jahiz_montly) {
                                    var str = row.jahiz_montly;
                                    var all = '<table  style="width:100%">';
                                    var res = str.split(";");
                                    all += '<tr>';

                                    for (var i = 0; i < res.length; i++) {
                                        var one = res[i].split("_");

                                        all += '<td class="tab-boder">&nbsp;' + one[1] + '</td>';

                                        all += '</tr>';
                                    }
                                    all += '</table>';
                                    return all;

                                } else
                                    return '';

                            }
                        },
                        {

                            "sortable": false,
                            className: "table-cell-nolrpadding",
                            render: function (data, type, row, meta) {
                                if (row.jahiz_montly) {
                                    var str = row.jahiz_montly;
                                    var all = '<table  style="width:100%">';
                                    var res = str.split(";");
                                    all += '<tr>';

                                    for (var i = 0; i < res.length; i++) {
                                        var one = res[i].split("_");

                                        all += '<td class="tab-boder">&nbsp;' + one[2] + '</td>';

                                        all += '</tr>';
                                    }
                                    all += '</table>';
                                    return all;

                                } else
                                    return '';

                            }
                        },
                        {

                            "sortable": false,
                            className: "table-cell-nolrpadding",
                            render: function (data, type, row, meta) {
                                if (row.jahiz_montly) {
                                    var str = row.jahiz_montly;
                                    var all = '<table  style="width:100%">';
                                    var res = str.split(";");
                                    all += '<tr>';

                                    for (var i = 0; i < res.length; i++) {
                                        var one = res[i].split("_");

                                        all += '<td class="tab-boder">&nbsp;' + one[3] + '</td>';

                                        all += '</tr>';
                                    }
                                    all += '</table>';
                                    return all;

                                } else
                                    return '';

                            }
                        },
                        {

                            "sortable": false,
                            className: "table-cell-nolrpadding",
                            render: function (data, type, row, meta) {
                                if (row.jahiz_montly) {
                                    var str = row.jahiz_montly;
                                    var all = '<table  style="width:100%">';
                                    var res = str.split(";");
                                    all += '<tr>';

                                    for (var i = 0; i < res.length; i++) {
                                        var one = res[i].split("_");

                                        all += '<td class="tab-boder">&nbsp;' + one[4] + '</td>';

                                        all += '</tr>';
                                    }
                                    all += '</table>';
                                    return all;

                                } else
                                    return '';

                            }
                        },
                        {

                            "sortable": false,
                            className: "table-cell-nolrpadding",
                            render: function (data, type, row, meta) {
                                if (row.jahiz_montly) {
                                    var str = row.jahiz_montly;
                                    var all = '<table  style="width:100%">';
                                    var res = str.split(";");
                                    all += '<tr>';

                                    for (var i = 0; i < res.length; i++) {
                                        var one = res[i].split("_");

                                        all += '<td class="tab-boder" >&nbsp;' + one[5] + '</td>';

                                        all += '</tr>';
                                    }
                                    all += '</table>';
                                    return all;

                                } else
                                    return '';

                            }
                        },
                        {

                            "sortable": false,
                            className: "table-cell-nolrpadding",
                            render: function (data, type, row, meta) {
                                if (row.jahiz_montly) {
                                    var str = row.jahiz_montly;
                                    var all = '<table  style="width:100%">';
                                    var res = str.split(";");
                                    all += '<tr>';

                                    for (var i = 0; i < res.length; i++) {
                                        var one = res[i].split("_");

                                        all += '<td class="tab-boder">&nbsp;' + one[6] + '</td>';

                                        all += '</tr>';
                                    }
                                    all += '</table>';
                                    return all;

                                } else
                                    return '';

                            }
                        },
                        {
                            data: 'Bander_Commission',
                            name: 'drivers_jahiz_clearing.Bander_Commission'
                        },
                        {
                            "searchable": false,
                            className: "table-success",
                            data: 'bank_plus',
                            name: 'bank_plus',

                        },
                        {
                            "searchable": false,
                            className: "table-success",
                            data: 'cash_plus',
                            name: 'cash_plus',

                        },
                            @if (Auth::user()->user_type_id == 1)
                        {
                            "searchable": false,
                            className: "table-success",
                            data: 'ATM_plus',
                            name: 'ATM_plus',

                        },
                            @endif

                        {
                            "searchable": false,
                            className: "table-danger",
                            data: 'bank_minus',
                            name: 'bank_minus',

                        },
                        {
                            "searchable": false,
                            className: "table-danger",
                            data: 'cash_minus',
                            name: 'cash_minus',

                        },


                    ]
                });


            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                // document.getElementById('response').innerHTML = loader;
                // document.getElementById('edit_modal').style.display = 'block';
                $('#edit_modal').modal('toggle');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/DriversJahizClearing')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });


            $('#filter').click(function () {
                if ($('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driver_type_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_Jahiz_Amount_Sign').val() != '' || $('#filter_jahiz_period_id').val() != '' || $('#filter_week1').prop("checked") || $('#filter_week2').prop("checked") || $('#filter_week3').prop("checked") || $('#filter_week4').prop("checked") || $('#filter_weekAll').prop("checked") || $('#filter_clearing_type_id').val() != '' || $('#filter_bank').prop("checked") || $('#filter_cash').prop("checked") ||$('#filter_ATM').prop("checked") || $('#filter_paid_id').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                    // card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driver_type_id').val(), $('#filter_driverId').val(), $('#filter_Jahiz_Amount_Sign').val(), $('#filter_jahiz_period_id').val(), $('#filter_week1:checked').val(), $('#filter_week2:checked').val(), $('#filter_week3:checked').val(), $('#filter_week4:checked').val(), $('#filter_weekAll:checked').val(), $('#filter_clearing_type_id').val(), $('#filter_bank:checked').val(), $('#filter_cash:checked').val(),$('#filter_ATM:checked').val(), $('#filter_paid_id').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
                    let html = '';
                    if ($('#filter_job_id').val() > 0)
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_job_id').val()+'</button>';
                    if ($('#filter_warehouseId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_warehouseId option:selected').text()+'</button>';
                    if ($('#filter_driver_type_id').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_driver_type_id option:selected').text()+'</button>';
                    if ($('#filter_driverId').val() != '')
                        html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_driverId').val()+'</button>';
                    if ($('#filter_Jahiz_Amount_Sign').val() != '')
                        html += '<button type="button" class="btn btn-outline-warning btn-rounded">'+$('#filter_Jahiz_Amount_Sign option:selected').text()+'</button>';
                    if ($('#filter_jahiz_period_id').val() != '')
                        html += '<button type="button" class="btn btn-outline-info btn-rounded">'+$('#filter_jahiz_period_id option:selected').text()+'</button>';
                    if ($('#filter_week1').checked)
                        html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_week1:checked').val()+'</button>';
                    if ($('#filter_week2').checked)
                        html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_week2:checked').val()+'</button>';
                    if ($('#filter_week3').checked)
                        html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_week3:checked').val()+'</button>';
                    if ($('#filter_week4').checked)
                        html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_week4:checked').val()+'</button>';
                    if ($('#filter_weekAll').checked)
                        html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_weekAll:checked').val()+'</button>';

                    if ($('#filter_bank').checked)
                        html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_bank:checked').val()+'</button>';
                    if ($('#filter_cash').checked)
                        html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_cash:checked').val()+'</button>';
                    if ($('#filter_ATM').checked)
                        html += '<button type="button" class="btn btn-outline-light btn-rounded">'+$('#filter_ATM:checked').val()+'</button>';
                    if ($('#filter_clearing_type_id').val() != '')
                        html += '<button type="button" class="btn btn-outline-dark btn-rounded">'+$('#filter_clearing_type_id option:selected').text()+'</button>';
                    if ($('#filter_created_at').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">Created at: '+$('#filter_created_at').val()+'</button>';
                    if ($('#filter_updated_at').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">Updated at: '+$('#filter_updated_at').val()+'</button>';
                    if(html != '') {
                        $('#edit_btn').show();
                        $('#selectedCriteria').html(html);
                    } else {
                        $('#edit_btn').hide();
                    }

                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {
                $('#filter_warehouseId').val('');
                $('#filter_job_id').val('');
                $('#filter_driver_type_id').val('');
                $('#filter_driverId').val('');
                $('#filter_driverId_input').val('');
                $('#filter_Jahiz_Amount_Sign').val('');
                $('#filter_jahiz_period_id').val('');
                $('#filter_week1').prop("checked", false);
                $('#filter_week2').prop("checked", false);
                $('#filter_week3').prop("checked", false);
                $('#filter_week4').prop("checked", false);
                $('#filter_weekAll').prop("checked", false);
                $('#filter_clearing_type_id').val('');
                $('#filter_bank').prop("checked", false);
                $('#filter_cash').prop("checked", false);
                $('#filter_ATM').prop("checked", false);
                $('#filter_paid_id').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });


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

        //Date picker


        function driver(id) {
            // document.getElementById('response').innerHTML = loader;
            $('#edit_modal').modal('toggle');
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
@stop
@endsection
