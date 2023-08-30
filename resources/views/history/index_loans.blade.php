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
    </style>
   
    <!-- statment modal -->
            <div class="modal fade" id="StatmentModal" tabindex="-1" role="dialog" aria-labelledby="StatmentModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document" >
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="HistoryModalLabel"><span id="driverData"></span>Loans Transactions History    </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div style="width:100%;clear:both;" id="response"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
    <!-- end of statment-->
    <!--Driver History Modal-->
        
        <!-- Modal -->
        <div class="modal fade" id="HistoryModal" tabindex="-1" role="dialog" aria-labelledby="HistoryModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document" style="width: 76%;">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="HistoryModalLabel"><span>Ashraf O Moh'd'S </span> Transactions History    </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
         
                 <table id="" class="display" style="width:100%">
                    <thead style="background-color: #ecf0f5;">
                        <tr>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>Journal Date</th>
                            <th>Journal Type</th>
                            <th>Transaction Amounts</th>
                            <th>stcpay ACCOUNT </th>
                            <th>Actions </th>
                            
                        </tr>
                    </thead>
                    <tbody id="history">
                        
                    </tbody>
            </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
        <!-- /Modal -->
    <!-- End of-->
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; " >
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Transactions History</h2>
        </div>

    </div>
    <div class="card card-default" style="width:100%;clear:both;"></div>

    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->

    <!-- SELECT2 EXAMPLE -->
    <form method="POST" action="">
        @csrf
        <div class="col-md-3" style="width:100%;clear:both;">
            <div id="card_box" class="box box-primary ">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <button class="button_search"><i class="fa fa-search"></i></button>
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
                            <TH>Company</TH>
                            <td>
                                <select name="filter_companyId" id="filter_companyId"
                                        class="form-control" style="width:200px;" required>
                                        <option value="0">All Companies</option>
                                        @foreach($lkp_company as $lkpcompany)
                                            <option value="{{$lkpcompany->id}}"@if(isset($inputs)) @if($lkpcompany->id == $inputs['filter_companyId'])  {{'selected'}}  @endif @endif> {{$lkpcompany->companyName}}</option>
                                        @endforeach
                                </select>
                            </td>
                            <TH>City</TH>
                            <td>
                                <select onchange="City()" name="filter_cityId" id="filter_cityId"
                                        class="form-control" style="width:200px;">
                                    <option value="0" disabled selected>select company</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>Warehouse</TH>
                            <td>
                                <select name="filter_warehouseId" id="filter_warehouseId" class="form-control">
                                </select>

                            </td>
                            <TH>Journal Date</TH>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" style="width:180px;" name="filter_journal_date"
                                           id="filter_journal_date">
                                    <script>
                                        $(function () {
                                            $('input[name="filter_journal_date"]').daterangepicker({
                                                autoUpdateInput: false,
                                                opens: 'left',
                                                locale: {
                                                    cancelLabel: 'Cancel'
                                                }
                                            });
                                            $('input[name="filter_journal_date"]').on('apply.daterangepicker', function (ev, picker) {
                                                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                                $('input[name="payment_journal_date"]').val('');
                                            });
                                            $('input[name="filter_journal_date"]').on('cancel.daterangepicker', function (ev, picker) {
                                                $(this).val('');
                                            });
                                            
                                        });
                                    </script>
                                </div>
                            </td>          
                            
                        </tr>
                        <tr>
                            <TH>Payment Date</TH>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" style="width:180px;" name="payment_journal_date"
                                           id="payment_journal_date">
                                    <script>
                                        $(function () {
                                            $('input[name="payment_journal_date"]').daterangepicker({
                                                autoUpdateInput: false,
                                                opens: 'left',
                                                locale: {
                                                    cancelLabel: 'Cancel'
                                                }
                                            });
                                            $('input[name="payment_journal_date"]').on('apply.daterangepicker', function (ev, picker) {
                                                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                                $('input[name="filter_journal_date"]').val('');
                                            });
                                            $('input[name="payment_journal_date"]').on('cancel.daterangepicker', function (ev, picker) {
                                                $(this).val('');
                                            });
                                             
                                        });
                                    </script>
                                </div>
                            </td>          
                        </tr>
                        
                    </table>

                    <div class="card-footer" align="center">
                        <button type="submit" class="btn btn-sm btn-info" id="filter">Filter</button>

                        <button type="button" name="reset" class="btn btn-sm btn-default" id="reset">Reset</button>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
            <div class="card card-default" style="width:100%;clear:both;"></div>

        <div class="card" style="background-color:white;padding:15px">
          
          <div class="card-body">
                <table id="table_id" class="display">
                    <thead style="background-color: #ecf0f5;">
                        <tr>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>City </th>
                            <th>Driver AMP</th>
                            <th>Driver Name</th>
                            <th>Payment date</th>
                            <th>Journal Date</th>
                            <th>Journal Type</th>
                            <th>Transaction Amounts</th>
                            <th>Total Transaction Ammount </th>
                            <th>Recivers Qty</th>
                            <th>Excel File</th>
                            <th>SCTPAY ACCOUNT </th>
                            <th>Actions </th>
                            
                        </tr>
                    </thead>
                    <tbody id="historyTransactionTable">
                        @foreach($transaction_histories as  $k=>$transaction_history)
                        <tr>
                           
                            <td>{{$k+1}}</td>
                            <td>{{$transaction_history->projectName}}</td>
                            <td>{{$transaction_history->cityName}}</td>
                            <td>{{$transaction_history->AMP_ID}}</td>
                            <td>{{$transaction_history->fullName}}</td>
                            <th>{{$transaction_history->fileDate}}</th>
                            <td>{{$transaction_history->journal_date}}</td>
                            <td>{{$transaction_history->journal_type}}</td>
                            <td>{{$transaction_history->bank_paid}}</td>
                            <td>{{$transaction_history->bank_sum}}</td>
                            <td>{{$transaction_history->CO}}</td>
                            <td>
                                <button class="btn btn-light">File Details</button>
                            </td>
                            <td style="text-align: center;    padding: 8px;">
                                <span style="font-weight: 600;color: #337ab7;">{{$transaction_history->accountNumber}}</span><hr style="margin: 2px 0;">
                                <span style="font-weight: 600;color: #00a65a;">{{$transaction_history->account_owner_iqama}} </span>
                            </td>
                            <td style="text-align: center;">
                                <button class="btn btn-warning" onclick="loadHistory('{{$transaction_history->driverInteralID}}')" title=" {{$transaction_history->fullName}} History Transactions" style="margin-bottom: 2px;">
                                    <!--<i class="fa fa-bars" aria-hidden="true"></i>-->
                                    <i class="fa fa-history" aria-hidden="true"></i>
                                    </button>
                                    
                                <button onclick="loadStatment('{{$transaction_history->driverInteralID}}')" id='{{$transaction_history->AMP_ID}}' data-original-title="Statement" data-toggle="modal" data-target="#StatmentModal" class="btn" title="{{$transaction_history->fullName}} Balance Statment" style="margin-bottom: 2px;">
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                    
                                    </button>
                                    
                                    <button class="btn" onclick="ShareViaWhatsapp('{{$k}}')" title="Share Record via Whatsapp" style="margin-bottom: 2px;" >
                                    <!--<i class="fa fa-bars" aria-hidden="true"></i>-->
                                       <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                    </button>
                            </td>
                            
                        </tr>
                        @endforeach
                       
                    </tbody>
            </table>
          </div>
        </div>
        
        <script>
            $(document).ready( function () {
                $('#table_id').DataTable();
                $('#filter_companyId').change(function(){
                    var companyId = $("#filter_companyId" ).val();
                    var city_id = $("#filter_cityId" ).val();
                    // cities request
                    $.ajax({
                        type: 'GET',
                        url: "{{URL('/getCities/')}}" + "/" + companyId + "/"+city_id,
                        contentType: "html",
                        dataType: 'html',
                        success: function (data) {
                        $('#filter_Period').empty();
                        console.log(data);
                        document.getElementById('filter_cityId').innerHTML = data;
                        }
                    });
                    // Warehouse request
                    
                    $.ajax({
                        type: 'post',
                        url: "{{URL('/getWarehouse')}}",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data:{"_token": "{{ csrf_token() }}",company_id: companyId}, 
                        success: function (data) {
                        $('#filter_warehouseId').empty();
                        console.log(data);
                        document.getElementById('filter_warehouseId').innerHTML = data;
                        }
                    });
                });
                
                $('#filter_cityId').change(function(){
                    var companyId = $("#filter_companyId" ).val();
                    var cityId = $("#filter_cityId" ).val();

                    // Warehouse request
                    
                    $.ajax({
                        type: 'post',
                        url: "{{URL('/getWarehouse')}}",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data:{"_token": "{{ csrf_token() }}",company_id: companyId,city_id:cityId}, 
                        success: function (data) {
                        $('#filter_warehouseId').empty();
                        console.log(data);
                        document.getElementById('filter_warehouseId').innerHTML = data;
                        }
                    });
                });
                
                
                
            } );
            
            function loadStatment(driverId){
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/statement')}}" + "/" + driverId,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        // console.log(data);
                        document.getElementById('response').innerHTML = data;

                    }
                });
            }
            function loadHistory(driverId){
                $('#HistoryModal').modal('show'); 
                 // console.log(data['driverData']);
                // console.log(data['data']);
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/LoadHistory')}}" + "/" + driverId,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        console.log(data);
                        document.getElementById("driverData").innerHTML = 'ashraf omar';
                        document.getElementById('history').innerHTML = data['data'];
                                        // document.getElementById('response').innerHTML = ;


                    }
                });
            }
            function sheet(id, Period) {
                myWindow1 = window.open("{{URL('/SalaryShow')}}" + "/" + id + "/" + Period, "",
                    "height=1000,width=650,scrollbars=yes,top=1,left=1,status,resizable");
            }
            function  ShareViaWhatsapp(index){
                console.log(index);
                window.open("https://wa.me/?text=testingMessage");
                alert('Hi this is Whatsapp');
            }
            @if(isset($inputs))
            $(document).ready( function () {
                var companyId = $("#filter_companyId" ).val();
               
                
                
                
                
                
                var city_id ="{{$inputs['filter_cityId']}}";
                                   $.ajax({
                        type: 'GET',
                        url: "{{URL('/getCities/')}}" + "/" + companyId + "/"+city_id,
                        contentType: "html",
                        dataType: 'html',
                        success: function (data) {
                        $('#filter_Period').empty();
                        console.log(data);
                        document.getElementById('filter_cityId').innerHTML = data;
                        }
                    });
                    // Warehouse request
                    
                    var companyId = $("#filter_companyId" ).val();
                    var cityId = $("#filter_cityId" ).val();

                    // Warehouse request
                    
                    $.ajax({
                        type: 'post',
                        url: "{{URL('/getWarehouse')}}",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data:{"_token": "{{ csrf_token() }}",company_id: companyId,city_id:cityId}, 
                        success: function (data) {
                        $('#filter_warehouseId').empty();
                        console.log(data);
                        document.getElementById('filter_warehouseId').innerHTML = data;
                        }
                    });
                
            });
            @endif
        </script>
        
@endsection




