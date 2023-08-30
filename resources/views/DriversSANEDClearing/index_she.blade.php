@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">SANED
                Clearing</h2></div>
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
    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->
    <!-- SELECT2 EXAMPLE -->
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <button class="button_search" onclick="card_change()"><i class="fa fa-search"></i></button>
                </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box"
                                                                                             class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive">
                <table class="table m-0 search_table" style="width:10px!important;">
                    <tr>


                        <TH>City</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                    style="width:180px;">

                                <option value=""></option>
                                @foreach($warehouse as $warehousee)
                                    <option value="{{$warehousee->id}}"> {{$warehousee->warehouseName}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>EMP ID</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"
                                   style="width:180px;"></td>
                        <TH>Driver Type</TH>
                        <td>
                            <select name="filter_driver_type_id" id="filter_driver_type_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                @foreach($lkp_driver_type as $lkp_driver_typee)
                                    <option
                                        value="{{$lkp_driver_typee->id}}">{{$lkp_driver_typee->driver_type}}</option>
                                @endforeach
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <TH>Driver</TH>
                        <td style="white-space: nowrap;">
                            <input name="filter_driverId" id="filter_driverId" type="hidden" value="">
                            <table style="padding: 0px 0px; !important;">
                                <tr>
                                    <td>
                                        <input class="form-control" name="filter_driverId_input"
                                               id="filter_driverId_input" style="width:200px" type="text" value=""
                                               data-readonly>
                                    </td>
                                    <td>
                                        <button onclick="driver_window();" type="button" class="btn btn-primary btn-xs">
                                            Select
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <TH>Clearing Type</TH>
                        <td>
                            <select name="filter_clearing_type_id" id="filter_clearing_type_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                @foreach($lkp_clearing_type as $lkp_clearing_typee)
                                    <option
                                        value="{{$lkp_clearing_typee->id}}">{{$lkp_clearing_typee->clearing_type}}</option>
                                @endforeach
                            </select>
                        </td>

                    </tr>

                    <tr>

                        <TH>Bank</TH>
                        <td>
                            <input type='checkbox' name='filter_bank' id='filter_bank' value="1"
                                   class="icheckbox_flat-green">
                        </td>
                        <TH>Cash</TH>
                        <td>
                            <input type='checkbox' name='filter_cash' id='filter_cash' value="1"
                                   class="icheckbox_flat-green">
                        </td>
                        @if (Auth::user()->user_type_id == 1)
                            <TH>ATM</TH>
                            <td>
                                <input type='checkbox' name='filter_ATM' id='filter_ATM' value="1"
                                       class="icheckbox_flat-green">
                            </td>
                        @else <input type="hidden" name='filter_ATM' id='filter_ATM' value="">
                        @endif
                    </tr>
                    <tr>
                        <TH>Paid</TH>
                        <td>
                            <select name="filter_paid_id" id="filter_paid_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>SANED SettledDate</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_SettledDate" id="filter_SettledDate"
                                       type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_SettledDate"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_SettledDate"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_SettledDate"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });


                                </script>
                            </div>
                        </td>
                        <TH>Equal</TH>
                        <td>
                            <select name="filter_Equal" id="filter_Equal" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="card-footer" align="center">
                    <button type="button" name="filter" id="filter" class="btn btn-sm btn-info">Filter</button>

                    <button type="button" name="reset" id="reset" class="btn btn-sm btn-default">Reset</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->



    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <!-- select all boxes -->


    <!---------------------------------------------------------------------------------------------------------------------->
    <style>
        .table-cell-nolrpadding {
            padding: .3em .0em !important;
        }

        .tab-boder {
            border-top: #1C1D21 solid 0.5px !important;
            border-bottom: #1C1D21 solid 0.5px !important;
            border-left: #1C1D21 solid 0.5px !important;
        }

        .red_color {
            color: red;
            font-weight: bold;
        }
    </style>
    <!---------------------------------------------------------------------------------------------------------------------->

    <form method="POST" action="{{ URL('/DriversSANEDClearingPostShe')}}">
        @csrf
        <div class="table-responsive" style="width: 100%;">
            <div class="row form-group" id="pre_loader_build" style="display: none;">
                <div class="col-md-12  text-center">
                    <img src="https://btcdmins.com/storage/images/preloader.gif" loading="lazy"> 
                </div>
            </div>
            <table id="customer_data" class="table table-bordered table-striped">

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
                    <TH rowspan="2">Bander Date</TH>
                    <TH rowspan="2">Driver Type</TH>
                    <TH rowspan="2">Iqama</TH>
                    <TH rowspan="2">Account Number</TH>
                    <TH rowspan="2">No Of Dispatch</TH>
                    <TH rowspan="2">Bander Commission</TH>
                    @if (Auth::user()->user_type_id == 1)
                        <TH colspan="3" style="text-align: center!important;border-bottom: 0px!important;">استلام</TH>
                    @else
                        <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">استلام</TH>
                    @endif
                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">تسليم</TH>


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
                    <TH id="dispatch_total"></TH>
                    <TH id="bander_com_total"></TH>
                    <TH id="bank_total1"></TH>
                    <TH id="cash_total1"></TH>
                    <TH id="atm_total"></TH>
                    <TH id="bank_total2"></TH>
                    @if (Auth::user()->user_type_id == 1)
                        <TH id="cash_total2"></TH>
                    @endif
                </tr>
                </tfoot>

            </table>
        </div>
        @if(Auth::user()->user_type_id==1 && session('Post_29')==1)

            <table style="width: 100%">
                <tr>
                    <td style="text-align: center">
                        <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">تم الدفع</button>
                    </td>
                </tr>
            </table>
        @endif
    </form>
    @if(Auth::user()->email == "shehroze511@gmail.com" || Auth::user()->email == "abdulrahman@btclogistic.com" || Auth::user()->email == "rayah@btclogistic.com" || Auth::user()->email == "s.nimir@btclogistic.com")
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
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
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
    <div id="password_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:350px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('password_modal').style.display='none'"
                    class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                    title="Close Modal">&times;
                </span>
            </div>
            <form class="w3-container" action="{{URL("/GoToReadySaned")}}" method="POST">
                @csrf
                <input type="hidden" name="ready_statuss" id="ready_statuss">

                <div class="row">
                    <div class="col-lg-12">
                        <b>Please Enter Your Password</b> 
                        <input type="password" class="form-control" style="width:200px;" name="password" id="password" required
                                   value="" >
                   </div>
                </div>
                <div class="w3-section">
                    <div class="w3-center">
                        <button type="submit" class="w3-btn w3-indigo">Submit</button>
                    </div>
                </div>
            </form>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('password_modal').style.display='none'" type="button"
                        class="w3-btn w3-red">Cancel
                </button>
            </div>
        </div>
    </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->


    <script>
        function go_to_ready(){
            var array = [];
            var checkboxes = document.querySelectorAll('.check-status:checked');
            if(checkboxes.length > 0) {
                for (var i = 0; i < checkboxes.length; i++) {
                   array.push(checkboxes[i].value)
                }
                $('#ready_statuss').val(array);
                document.getElementById('password_modal').style.display = 'block';
            } else {
                alert('Please select atleast one checkbox');
            }
        }
        $(document).ready(function () {

	    $('#customer_data').DataTable({
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
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
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
                    card_change();
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
                $('.flat-red').iCheck('check');
            } else
                $('.flat-red').iCheck('uncheck');
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

        //Date picker
        $(function () {
            $('#pakage_date').datepicker({
                autoclose: true,
                autoHide: true,
                zIndex: 9999,
            });
        });

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
@endsection




