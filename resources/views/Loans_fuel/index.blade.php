@extends('AdminLTE')
@section('content')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        td{
            text-align: center
        }
        hr{
            margin: 4px ;
        }
    </style> 

    <!-- Modal -->
    <div class="modal fade modal-xl" id="customModalFuel" tabindex="-1" aria-labelledby="customModalFuel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalFuel">Add custom fuel request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <table class="table m-0 search_table" style="width:10px!important;">
                    <tr>
                          
                        <TH>Companies</TH>
                        <td>
                            <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                    class="form-control" style="width:200px;" required>
                                <option value=""></option>
                                @foreach($lkp_company as $lkpcompany)
                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>WarehouseName</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>


                            </select>
                        </td>
                         
                    </tr>
                    <tr>
                      
                        <TH></TH>
                        <td> </td>
                        <TH></TH>
                        <td> <button class="btn btn-primary" style="float: right;margin-top: 8px;">Search</button> </td>
                         
                    </tr>
                    
        
                </table>

                <table style="    margin: 0 auto;">
                    <tr style="font-size: 9px; background-color: #ffe1b1; color: #4b4949;">
                        <th>Comapny</th>
                        <th>Warehouse</th>
                        <th>DA Name</th>
                        <th>DA AMP</th>
                        <th>Last Transaaction date</th>
                        <th>Pending Transaaction date</th>
                        <th>Custom Days</th>
                        <th>Actions</th> 
                    </tr>
                    <tr style="font-size: 8px; background-color: #99999938;">
                        <td>I-mile</td>
                        <td>RUH Station </td>
                        <td>Ashraf m</td>
                        <td>D2105464</td>
                        <td>Last transactoion was 12 days ago at 20-10-2022 with an amount of 100 SAR </td>
                        <td>Pending Transaaction date</td>
                        <th>
                            <span style="30 Per Day">30 Per Day</span>
                            <h3>120 SAR</h3>
                            <input type="number" name="" id="" value="1"><span style="float: right;"> Day/s</span>
                        </th>
                        <td>Actions</td> 
                    </tr>
                    <tr style="font-size: 8px;     background-color: #9999990a;">
                        <td>I-mile</td>
                        <td>RUH Station </td>
                        <td>Ali m</td>
                        <td>D2105464</td>
                        <td>Last transactoion was 12 days ago at 20-10-2022 with an amount of 100 SAR </td>
                        <td>Pending Transaaction date</td>
                        <th>
                            
                            <!-- <input type="checkbox" name="" id=""><span>Sun</span><hr>
                            <input type="checkbox" name="" id=""><span>Mon</span><hr>
                            <input type="checkbox" name="" id=""><span>Tu</span><hr>
                            <input type="checkbox" name="" id=""><span>Wen</span><hr>
                            <input type="checkbox" name="" id=""><span>Th</span><hr>
                            <input type="checkbox" name="" id=""><span>Fr</span><hr>
                            <input type="checkbox" name="" id=""><span>Sat</span> -->
                            <span style="30 Per Day">30 Per Day</span>
                            <h3>120 SAR</h3>
                            <input type="number" name="" id="" value="1"><span style="float: right;"> Day/s</span>
                            
                        </th>
                        <td>Actions</td> 
                    </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Confirm</button>
            </div>
            </div>
        </div>
    </div>
    <!-- end of Modal  -->
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Loans Fuel </h2></div>
    </div>
    <div style="float:right;">
        <h2><a href="#" class="btn btn-sm btn-info "  data-toggle="modal" data-target="#customModalFuel"><i class="fa fa-plus" ></i> Add Arrgent Feul Request</a>
        </h2>
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
                        <TH>Company name</TH>
                        <td>
                            <select name="filter_companyId2" id="filter_companyId2" onchange="WarehouseName2()" class="form-control" style="width:200px;" required>
                                    <option value="0" disabled selected>Select Company</option> 
                                    @foreach($lkp_company as $lkpcompany)
                                        <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                    @endforeach
                            </select>
                        </td> 

                        <TH>Warehouse</TH> 
                        <td>
                            <select id="filter_warehouseId2" name="filter_warehouseId2" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>  
                            </select>
                        </td>
                    </tr>
                    <tr>
                    
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


    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->

    <!-- select all boxes -->
    

    <form method="POST" action="{{ URL('/CreditNotesPost')}}">
        @csrf
        <div class="table-responsive" style="width: 100%;">
            <table id="customer_data" class="table table-bordered table-striped">
               
                <thead>
                <tr> 
                <TH  style="text-align: center;"><input type="checkbox" name="" id="checkAll"></TH>
                <TH  style="text-align: center;">Company</TH>
                <TH  style="text-align: center;">Warehouse</TH>
                <TH  style="text-align: center;">DA Name</TH>
                <TH  style="text-align: center;">DA AMP</TH>
                 
                <TH  style="text-align: center;">DA STCPAY ID </TH>
                <TH  style="text-align: center;">DA STCPAY No </TH>
                <TH  style="text-align: center;">Weekly Fuel Amount </TH>
                <TH  style="text-align: center;">Last Transaction Details </TH>
                <TH  style="text-align: center;"> Fuel Details</TH> 
                <TH  style="text-align: center;">Action</TH>
                </tr>
                </thead>
                <tbody>

                 
                <form action="{{url('/Send-fuel-requests')}}" method="post" id="formId">
                    @forelse($DriversList as $item)
                   
                        <tr>
                            <td><input type="checkbox" name=""  id=""></td>
                            <td>{{$item['companyName']}}</td>
                            <td>{{$item['warehouse']}}</td>
                            <td>{{$item['driverName']}}</td>
                            <td>{{$item['AMP_ID']}}</td>
                            <td>{{$item['stcpayIqama']}}</td>
                            <td>{{$item['stcpayAccount']}}</td>
                            <td>{{$item['Amount_due']}}</td>
                            @if($item['lastTransactionDate'] != '')
                                <td>Last transaction was before <span style="color:red">{{$item['lastTransactionInDays']}}</span> Days ago at {{$item['lastTransactionDate']}}</td>
                            @else 
                            <td><a class="btn btn-dark" disabled>No History exsist</a></td>
                            @endif
                            <td> {!! $item['requestButton'] !!} </td>
                            <td> {!! $item['btns2'] !!} </td>
                        </tr>
                    @empty
                    <tr>
                        <td  colspan="10"><img src="{{asset('images/box.png')}}" alt="" style="max-width: 70px;  margin: 52px;"><br><span>No DA Feul request available at the moment</span></td>
                    </tr>
                    @endforelse
                    </form>
                </tbody>
                <tfoot>
                <tr>
                     
                    <TH colspan='7'>Total</TH>
                    <TH colspan='5' style="text-align:left;margin-left:15px;">{{$summary['total']}}</TH>
                    
                </tr>
                </tfoot>
            </table>
        </div>
        
        @if(Auth::user()->user_type_id==1)
        <center>
            <a onClick='submitDetailsForm()'  class="btn btn-sm btn-info" >Send All Fuel requests </a>
        </center>
        @endif
    </form>

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
                        <button class="w3-btn w3-indigo"> Delete</button>
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

        $("#checkAll").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
        function submitDetailsForm() {
            $("#formId").submit();
        }
        function confirmAllDilag(){
            Swal.fire({
                title: 'Do you want to Send All (20) Fuel reqest ?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire('Saved!', '', 'success')
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        }
        function confirmDilag(arg){
             alert(arg);
             var data  = {!! json_encode($DriversList) !!};
             console.log(data);
             data = data[arg];
             
            //  alert(data)
            Swal.fire({
                title: '<span style="color: #337ab7; font-size: 17px;">Send fuel request for DA :</span> <span style="color: #f39c12; font-size: 17px;">'+data.driverName+', '+data.AMP_ID+', '+data.Amount_due+' SAR ? </span>',
                showDenyButton: true,
                showCancelButton: true,
                showDenyButton:false,
                confirmButtonText: 'Send',
                denyButtonText: `Cancel`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#staticBackdrop').modal('toggle');
                    // $('#myModal').modal('show');
                    // $('#myModal').modal('hide');
                        // http post request to route Fuel-Loans/store
                        let url = '{{url('Fuel-Loans/store')}}';
                        var postData = {
                            driverId:data.driver_id,
                            journal_date:data.journal_date,
                            Amount_due:data.Amount_due,
                            _token: "{{ csrf_token() }}",
                        };
                        $.ajax({
                            url: url,
                            type: "POST",
                            cache: false,
                            data: postData,
                            success: function (data) {
                                // console.log(data.status);
                                if(data.status == true){
                                    $('#staticBackdrop').modal('hide'); 
                                    window.location.replace('/Fuel-Loans');
                                    // return redirect()->with('success','has done')
                                }else{
                                    $('#staticBackdrop').modal('hide'); 
                                    window.location.replace('/Fuel-Loans');
                                    alert('حدث خطأ , Error occured Please try again');
                                    // window.location.replace('/import_excel/General-invoices');
                                }
                            },
                            error: function (jqXHR, status, error) {
                            
                                alert(status + ": " + error + ", Http Error, Contact with support@btclogistic.com");
                            }
                        }); 
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        }
        $(document).ready(function () {

            fill_datatable();


            function fill_datatable(filter_companyId = '', filter_warehouseId = '', filter_job_id = '', filter_driverId = '', filter_journal_date = '', filter_amount = '', filter_invoice_number = '', filter_note = '', filter_created_at = '', filter_updated_at = '', filter_post = '') {
                 


            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/CreditNotes')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        // document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.edit', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/CreditNotes')}}" + "/" + id + "/edit",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;
                        var g = document.createElement('script');
                        var s = document.getElementsByTagName('script')[0];
//g.text = "alert(\"hi\");"
                        g.text = "$('#journal_date').datepicker({" +
                            "format: 'dd/mm/yyyy'," +
                            "autoclose: true," +
                            "autoHide: true," +
                            "zIndex: 9999," +
                            "});"
                        s.parentNode.insertBefore(g, s);

                    }
                });
            });
            $('#customer_data tbody').on('click', '.print', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                myWindow1 = window.open("{{URL("CreditNotesPrint")}}" + "/" + id, "mywin",
                    "height=900,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
                myWindow1.focus();
            });


            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/CreditNotes')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';


            });


            $('#filter').click(function () {

                if ($('#filter_companyId').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_journal_date').val() != '' || $('#filter_amount').val() != '' || $('#filter_invoice_number').val() != '' || $('#filter_note').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '' || $('#filter_post').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driverId').val(), $('#filter_journal_date').val(), $('#filter_amount').val(), $('#filter_invoice_number').val(), $('#filter_note').val(), $('#filter_created_at').val(), $('#filter_updated_at').val(), $('#filter_post').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {
                $('#filter_companyId').val('');
                $('#filter_warehouseId').val('');
                $('#filter_job_id').val('');
                $('#filter_driverId').val('');
                $('#filter_driverId_input').val('');
                $('#filter_journal_date').val('');
                $('#filter_amount').val('');
                $('#filter_invoice_number').val('');
                $('#filter_note').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');
                $('#filter_post').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });

        function driver_window() {
            myWindow1 = window.open("{{URL("/DriverWindow")}}", "",
                "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
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

        function add() {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/CreditNotes/create")}}",
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;
                    var g = document.createElement('script');
                    var s = document.getElementsByTagName('script')[0];
//g.text = "alert(\"hi\");"
                    g.text = "$('#journal_date').datepicker({" +
                        "format: 'dd/mm/yyyy'," +
                        "autoclose: true," +
                        "autoHide: true," +
                        "zIndex: 9999," +
                        "});"
                    s.parentNode.insertBefore(g, s);

                }
            });
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
              
            }
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
        function WarehouseName2() {
            var filter_companyId = document.getElementById('filter_companyId2').value;
            // alert(filter_companyId);
            if (filter_companyId == "")
                $('#filter_warehouseId2').empty();
            else {
                $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_warehouseId2').empty();
                    $('#filter_warehouseId2').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId2').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }}
    </script>

@endsection




