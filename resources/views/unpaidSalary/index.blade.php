@extends('AdminLTE')
@section('content')
    <style>
        tbody.td{
            text-align: center;
        }
        .Font-Green {
            color: green;
            font-weight: bold;
        }

        .Font-Red {
            color: red;
            font-weight: bold;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;">
        
        
        </div>
        @if(session()->has('message'))
        <br>
        
            <div class="alert alert-warning" style="margin-top: 14px;">
                {{ session()->get('message') }} <a href="{{url('Unpaid-Salary')}}">click here </a>.
            </div>
        @endif

        <div id="destroy_div" class="alert alert-success" style="margin-top: 14px;display:none;">
           
        </div>
    </div>

    <div class="card card-default" style="width:100%;clear:both;"></div>

    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->

    <!-- SELECT2 EXAMPLE -->
 
        @csrf
       
        <center>
            <div id="salary_range"></div>
            <input name="companyId" id="companyId" type="hidden" value="">
            <input name="Period" id="Period" type="hidden" value="">
        </center>
        <table style="width:100%">
            
        </table>

        <div class="table-responsive" style="width: 100%;">
         
            @csrf
            <table id="customer_data" class="table table-striped table-bordered"  >
                <thead> 
                <tr>
                    <TH><input type="checkbox" id="checkAll"></TH>
                    <TH>Company Name</TH>
                    <TH>Period </TH>
                    <TH>Driver Names</TH>
                    <TH>Drivers IDs</TH>
                    <TH>AMP ID</TH>
                    <TH>CO</TH>
                    <TH>Amount details</TH>
                    <TH>Total Amount</TH>
                    <TH >STCPAY Account</TH>
                    <TH>STCPAY Account Number</TH>
                    <TH>Action</TH>
                </tr>
                </thead>
                <tbody>
                    
                    

                        @foreach($Exported_records as $k=>$Exported_record)
                            <tr>
                                <TD style="text-align: center;"><input type="checkbox" name="Exported_record" value="{{$Exported_record->id}}" id="item{{$Exported_record->id}}" ></TD>
                                <TD>{{$Exported_record->companyName}} | {{$Exported_record->id}} </TD>
                                <TD>{{$Exported_record->PeriodName}}</TD>
                                <TD>{{$Exported_record->DriverNames}}</TD>
                                <TD>{{$Exported_record->drivers_IDs}}</TD>
                                <TD>{{$Exported_record->job_ids}}</TD>
                                <TD>{{$Exported_record->CO}}</TD>
                                <TD>{{$Exported_record->bank_paid}}</TD>
                                <TD>{{$Exported_record->edit_salary}}</TD>
                                <TD >{{$Exported_record->account_owner_iqama}}</TD>
                                <TD >{{$Exported_record->accountNumber}}</TD>
                                <TD>
                                    <button  onclick="migrate('{{$Exported_record->id}}')" class="btn btn-sm btn-info" id="migrate">Migrate to Journal</button>
                                    <!-- <button  class="btn btn-sm btn-info" >Test Function</button> -->
                                    
                                </TD>
                            </tr>
                            
                        @endforeach
                        
                        
                         
                   
                </tbody>
                
                <tfoot>
                <tr>
                    <TH colspan='1'>
                       <input disabled type="checkbox">
                    </TH>

                    <TH colspan='1'><button  value="Migrate/Move to journal"  id="migrate2" style="float:right; " class="btn btn-sm btn-warning">Migrate Selected to Journal</button></TH>
                     <TH colspan='2'>Total</TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                    <TH style="text-align: left;">{{$extra['total']}}</TH>
                    <TH></TH>
                    <TH></TH>
                    <TH></TH>
                  
                    
                </tr>
                
                </tfoot>
                
            </table>
            
            
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
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->

    <script>
        var favorite = [];
        $(document).ready(function() {
            
            $("#migrate2").click(function(){
                
                $.each($("input[name='Exported_record']:checked"), function(){
                    favorite.push($(this).val());
                });

                if(favorite.length > 0){
                    $.ajax({
                        type: 'post',
                        url: "{{URL('/destroy-unpaidTransactions')}}",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data:{"_token": "{{ csrf_token() }}",favorite}, 
                        success: function (data) {
                        // $('#filter_warehouseId').empty();
                        if(data['status'] == true){
                            location.reload();
                        }else{
                            location.reload();
                        }
                        
                        // document.getElementById('filter_warehouseId').innerHTML = data;
                        }
                    });
                }else{
                    alert('No records have been selected ');
                }
                
                
                // alert("My favourite sports are: " + favorite.join(", "));
            });

        });
        function uncheckItems(args){
                // alert('args '+favorite);
                let elementName = '#item'+args;
                // alert(elementName);
                if($(elementName).is(":checked")){
                    $(elementName).prop("checked", false);
                }else{
                    $(elementName).prop("checked", true);
                }
                // console.log(favorite);
            }
    </script>
    <script>
       
        function migrate(index) {
        if (confirm("This action is undoable, Are you sure about unlock/migrate this record to Journal Tab ? ")) {
            $.ajax({
                type: 'GET',
                url: "{{URL("/destroy-unpaidTransaction/")}}" + "/" + index,
                success: function (data) {
                    
                    if(data['status'] == true){
                        location.reload();
                    }else{

                    }
                }
            });
        } 
            
            
        }

        $(document).ready(function () {
            $( "#other" ).click(function() {
                $( "#target" ).submit();
            });
            $('#customer_data').DataTable();
                var btnStatus = false;
                $("#checkAll").click(function(){
                    $('input:checkbox').not(this).prop('checked', this.checked);
                    // $('#migrate').prop('disabled', btnStatus);
                    if(btnStatus == true){
                        btnStatus = false
                    }else{
                        btnStatus = true
                    }
                    
                });

        });

       
        function selectall() {

            if (document.getElementById('select-all').checked) {

                $('.aprove-checkbox').iCheck('check');

            } else
                $('.aprove-checkbox').iCheck('uncheck');
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
                    $('#filter_cityId').empty();
                    $('#filter_warehouseId').empty();
                    $('#filter_cityId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_cityId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }
        }

        function Warehouse() {
            var filter_cityId = document.getElementById('filter_cityId').value;
            if (filter_cityId == "")
                $('#filter_warehouseId').empty();
            else {
                $.getJSON("{{URL("/getWarehouse")}}" + "/" + filter_cityId, function (json) {
                    $('#filter_warehouseId').empty();
                    $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
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
        function validateForm() {


            /*if ($('#filter_warehouseId').val() == '') {
                alert('يجب اختيار ال CITY');
                return false;
            }
            //if ($('#filter_clearing_type_id').val() != '2') {
            //    alert('يجب اختيار ال Clearing Type = تسليم');
            //   return false;
            //}
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

            if ($('#SQL').val().indexOf("drivers.id as driverId,companyName,name_en as") == -1) {
                alert('يجب الضغط علي  Filter');
                return false;
            }

             */
            if ($('#filter_companyId').val() == '') {
                alert('يجب اختيار ال company');
                return false;
            }
            if ($('#filter_Period').val() == '') {
                alert('يجب اختيار ال Period');
                return false;
            }
            if ($('#filter_paid_id').val() != '2') {
                alert('يجب اختيار ال Paid = لا');
                return false;
            }
            if ($('#SQL').val().indexOf("TRIM(ROUND(paid_salary,2))+0 =0") == -1) {
                alert('يجب الضغط علي  Filter');
                return false;
            }
            //alert($('#company_Id').val());
            $('#company_Id').val($('#filter_companyId').val());
            $('#companyName').val($("#filter_companyId option:selected").text());
            $('#PeriodName').val($("#filter_Period option:selected").text());
            //alert($('#companyName').val());
            //return false;
            return true;

        }


    </script>
@endsection




