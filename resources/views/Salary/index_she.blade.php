@extends('AdminLTE')
@section('content')
    <style>
        .Font-Green {
            color: green;
            font-weight: bold;
        }

        .Font-Red {
            color: red;
            font-weight: bold;
        }
        .circle {
            width: 21px;
            height: 20px;
            border-radius: 50%;
            background-color: red;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Salary</h2>
        </div>
        
        
        
    </div>
    
    <!--Approval Modal -->
    <!-- Modal -->
        <div class="modal fade" id="ApprovalModal" tabindex="-1" role="dialog" aria-labelledby="ApprovalModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">E-Signtures</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
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
                
                <!--<button type="button" class="btn btn-primary">Export StcPay File</button>-->
                
                 <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportSalarySTCShe")}}">
                    @csrf
                    <input type="hidden" name="SQL" id="SQL_stc" value="">
                    <input type="hidden" name="company_Id" id="company_Id">
                    <input type="hidden" name="companyName" id="companyName">
                    <input type="hidden" name="PeriodName" id="PeriodName">
                    <input type="hidden" name="from_to" id="from_to">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 40%">
                                <button type="submit" name="STC_Report" id="STC_Report" disabled class="btn btn-sm btn-info">STC pay
                                    Excel
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </td>
                        </tr>
 
                    </table>
                </form>
        
        
              </div>
            </div>
          </div>
        </div>
    <!-- End of Approval Modal -->
    
    
    @if(session()->has('message'))
    <br>
    
        <div class="alert alert-warning" style="margin-top: 14px;">
            {{ session()->get('message') }} <a href="{{url('Unpaid-Salary')}}">Click Here </a>.
        </div>
    @endif
    <div class="card card-default" style="width:100%;clear:both;"></div>

    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->

    <!-- SELECT2 EXAMPLE -->
    <form method="POST" action="{{ route('Salary.store')}}">
        @csrf
        <div class="col-md-3" style="width:100%;clear:both;">
            <div id="card_box" class="box box-primary ">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <button class="button_search"><i class="fa fa-search"></i></button>
                    </h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box" class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div id="box-body" class="box-body table-responsive">

                    <table class="table m-0 search_table" style="width:10px!important;">

                        <tr>
                            <TH>CompanyName</TH>
                            <td>
                                <select name="filter_companyId" id="filter_companyId" onchange="CityName()"
                                        class="form-control" style="width:200px;" required>
                                    <option value=""></option>
                                    @foreach($lkp_company as $lkpcompany)
                                        <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <TH>Period</TH>
                            <td>
                                <select name="filter_Period" id="filter_Period" class="form-control"
                                        style="width:200px;">
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <TH>CityName</TH>
                            <td>
                                <select onchange="Warehouse()" name="filter_cityId" id="filter_cityId"
                                        class="form-control">
                                </select>
                            </td>
                            <TH>Paid</TH>
                            <td>
                                <select name="filter_paid_id" id="filter_paid_id" class="form-control"
                                        style="width:180px;">
                                    <option value=""></option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>Warehouse</TH>
                            <td>
                                <select name="filter_warehouseId" id="filter_warehouseId" class="form-control" multiple>
                                </select><br>
                                <small style="display: none; color: red" id="multiple_tag">To select multiple items, Ctrl-click each item.</small>

                            </td>
                            <TH>E-Signtures</TH>
                            <td>
                                <a href="#"  id="ApprovalModalBtn" class="btn btn-info btn-md" style=" background-color: #1c6577; border-color: #00acd6; width: 180px;" data-toggle="modal" data-target="#ApprovalModal">Approval List</a>
                            </td>
                            
                             
                        </tr>
                    </table>

                    <div class="card-footer" align="center">
                        <button type="button" name="filter" class="btn btn-sm btn-info" id="filter">Filter</button>

                        <button type="button" name="reset" class="btn btn-sm btn-default" id="reset">Reset</button>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <center>
            <div id="salary_range"></div>
        </center>
        
        <input type="hidden" name="companyId" id="companyId" value="">
        <input type="hidden" name="Period" id="Period" value="">

        <div class="table-responsive" style="width: 100%;">
            
            <div class="row form-group" id="pre_loader_build" style="display: none;">
                <div class="col-md-12  text-center">
                    <img src="https://btcdmins.com/storage/images/preloader.gif" loading="lazy"> 
                </div>
            </div>

            
            <table id="customer_data" class="table table-bordered table-striped">
                <thead>
                <tr>

                    <!--<TH style="display:none;">City</TH>-->
                    <TH>Whouse</TH>
                    <TH>Driver</TH>
                    <TH>ID</TH>
                    <TH>Did</TH>
                    <!--<TH>Final Pack</TH>-->
                    <!--<TH>Match</TH>-->
                    <!--<TH>GAP</TH>-->
                    <TH>Days</TH>
                    <TH>Carried Down</TH>
                    <TH>Day Loaded</TH>
                    <TH>Credit</TH>
                    <TH>Debit</TH>
                    <TH><input class="" onclick="selectall_status()" type="checkbox" name="select-all-status" id="select-all-status"/> Status</TH>
                    <TH>Attempt</TH>
                    <TH>Loan</TH>
                    <TH>CN</TH>
                    <!--<TH>IND</TH>-->
                    <TH>Expected Salary</TH>
                    <TH><input class="flat-red" onclick="selectall()" type="checkbox" name="select-all" id="select-all"/> Paid Salary</TH>
                    <!--<TH>T</TH>-->
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
                    <!--<TH id="final_pack_total"></TH>-->
                    <!--<TH id="match_total"></TH>-->
                    <!--<TH id="gap_total"></TH>-->
                    <TH id="days_total"></TH>
                    <TH id="c_down_total"></TH>
                    <TH id="day_load_total" class="Font-Green"></TH>
                    <TH id="credit_total" class="Font-Green"></TH>
                    <TH id="debit_total" class="Font-Red"></TH>
                    <TH><button id="status_button" style="display: none" type="button" class="btn btn-primary btn-small" onclick="go_to_ready()" title="Revert status to Ready">Rev.Status</button></TH>
                    <TH></TH>
                    <TH id="loan_total"></TH>
                    <TH id="cn_total"></TH>
                    <!--<TH id="ind_total"></TH>-->
                    <TH id="exp_salary_total"></TH>
                    <TH id="paid_salary_total"></TH>
                    <!--<TH id="t_total"></TH>-->
                    <TH id="brought_total"></TH>
                    <TH></TH>
                    <TH style="display:none;"></TH>
                    <TH style="display:none;"></TH>
                    <TH style="display:none;"></TH>
                    <TH style="display:none;"></TH>
                </tr>
                </tfoot>
            </table>
        </div>
        <center>
            <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">Post To Journal</button>
        </center>
    </form>
   <div>
        <form method="POST" onsubmit="return validateForm()" action="{{URL("/ExportSalarySTC")}}">
            @csrf
            <input type="hidden" name="SQL" id="SQL" value="">
            <input type="hidden" name="company_Id" id="company_Id">
            <input type="hidden" name="companyName" id="companyName">
            <input type="hidden" name="PeriodName" id="PeriodName">
            <table style="width: 100%">
                <tr>
                    <td style="width: 40%">
                        <!--<button type="submit" name="STC_Report" id="STC_Report" disabled class="btn btn-sm btn-info">STC pay-->
                        <!--    Excel-->
                        <!--</button>-->
                </tr>
                <tr>
                <button value="Migrate/Move to journal "  id="migrate" style="float:right; " class="btn btn-sm btn-warning">Migrate Selected to Journal</button>
                </tr>
            </table>
        </form>
     </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('edit_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>

            <div style="width:100%;clear:both;padding: 0.0rem 1.0rem !important;" id="response">
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
            <form class="w3-container" action="{{URL("/GoToReady")}}" method="POST">
                @csrf
                <input type="hidden" name="ready_statuss" id="ready_statuss">
                <input type="hidden" name="from_to" id="from_to_ready">
                
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
    function revert_status(id, name, job_id, amount)
    {
        document.getElementById('response').innerHTML = loader;
        document.getElementById('edit_modal').style.display = 'block';
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
            document.getElementById('password_modal').style.display = 'block';
            
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
            //alert("{{URL('/SalaryShow')}}" + "/" + id + "/" + document.getElementById('Period').value);
            e.preventDefault();
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
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
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
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
    <script>
    
//     $("#stc_form").submit(function(event) {
// 		event.preventDefault();
// 		if ($('#filter_companyId').val() == '') {
//             alert('يجب اختيار ال company');
//             return false;
//         }
//         if ($('#filter_Period').val() == '') {
//             alert('يجب اختيار ال Period');
//             return false;
//         }
//         if ($('#filter_paid_id').val() != '2') {
//             alert('يجب اختيار ال Paid = لا');
//             return false;
//         }
//         if ($('#SQL_stc').val().indexOf("TRIM(ROUND(paid_salary,2))+0 =0") == -1) {
//             alert('يجب الضغط علي  Filter');
//             return false;
//         }
// 		$.ajax({
//             type: 'POST',
//             url: "{{URL("/ExportSalarySTC")}}",
//             data: {
//                 SQL: $('#SQL_stc').val(),
//                 company_Id: $('#filter_companyId').val(),
//                 companyName: $("#filter_companyId option:selected").text(),
//                 PeriodName: $("#filter_Period option:selected").text(),
//                 from_to: $('#from_to').val()
//             },
//             success: function (data) {
//                 location.reload();
//             }
//         });
//     });
    
            
            
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


    </script>
@endsection




