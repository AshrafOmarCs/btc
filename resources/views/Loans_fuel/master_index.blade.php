@extends('AdminLTE')
@section('content')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .btn_blue{
        background-color: #337ab7;
        border-color: #ffffff0a;
        color: white;
    }

    .btn_blue:hover{
        color: white;
    }
    body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">
                Expenses </h2></div>
    </div>
    <div style="float:right;">
        <h2><button data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New Expenses Type</button>
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Expense </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                    
            <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'London')">Driver Expense</button>
                <button class="tablinks" onclick="openCity(event, 'Paris')">Company Expense</button>
                <!-- <button class="tablinks" onclick="openCity(event, 'Tokyo')">Tokyo</button> -->
            </div>

            
            <div id="London" class="tabcontent">
            <form method="POST" action="{{ route('Loans.store')}}">
                @csrf

                <table>
                    <tr>
                        <td style="vertical-align: top !important;">
                            <table class="table m-0 show_table" style="width:10px!important;">
                                <tr>
                                    <TH>Driver <font color="red">*</font></TH>
                                    <td style="white-space: nowrap;">
                                        <input name="driverId" id="driverId" type="hidden" value="">
                                        <table style="padding: 0px 0px; !important;">
                                            <tr>
                                                <td>
                                                    <input class="form-control" name="driverId_input" id="driverId_input"
                                                        style="width:230px" type="text" value="" required data-readonly>
                                                </td>
                                                <td>
                                                    <button onclick="driver_window();" type="button" class="btn btn-primary btn-sm">
                                                        Select
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <Tr>
                                    <TH colspan=2 id="balance"></TH>
                                </tr>
                                <tr>
                                    <TH>Journal Date <font color="red">*</font></TH>
                                    <td>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" name="journal_date"
                                                placeholder="dd/mm/yyyy" id="journal_date" value="{{date('d/m/Y')}}" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <TH>Amount <font color="red">*</font></TH>
                                    <td><input type="text" class="form-control" name="amount" value="" required></td>
                                </tr>
                                <tr>
                                    <TH>Note</TH>
                                    <td><textarea name="note" class="form-control" rows=5></textarea></td>
                                </tr>
                                </td>
                                </tr>
                                <tr>
                                    <TH>Status<font color="red">*</font></TH>
                                    <td>
                                        <select id="status_id" name="status_id" class="form-control" required>
                                           
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="w3-row">
                    <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Add</button>
                </div>
            </form>
            </div>

            <div id="Paris" class="tabcontent">
                <h3>Paris</h3>
                <p>Paris is the capital of France.</p> 
            </div>

            

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>

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
                        <TH>CompanyName</TH>
                        <td>
                            <select name="filter_companyId" id="filter_companyId" onchange="CityName()"
                                    class="form-control" style="width:200px;" required>
                                    <option value="0" disabled selected>All Company</option> 
                                    @foreach($lkp_company as $lkpcompany)
                                        <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                    @endforeach
                            </select>
                        </td> 

                        <TH>Expense Type</TH>
                        <td>
                            <select name="filter_expense_id" id="filter_expense_id" 
                                    class="form-control" style="width:200px;" required>
                                    <option value="all" selected>All Expenses</option> 
                                    <option value="company" >Company</option> 
                                    <option value="driver" >Driver</option>  
                            </select>
                        </td> 

                       
                    </tr>
                     <tr>
                     <TH>Period</TH>
                        <td>
                            <select name="filter_Period" id="filter_Period" class="form-control"
                                    style="width:200px;">
                            </select>

                        </td>

                        <TH>Status</TH>
                        <td>
                            <select name="filter_companyId" id="filter_companyId" 
                                    class="form-control" style="width:200px;" required>
                                    <option value="all" selected>All Transaction</option> 
                                    <option value="company" >Available To apply </option> 
                                    <option value="driver" >Approved by supervisor</option>  
                                    <option value="driver" >Paid</option> 
                                    <option value="driver" >Canceled</option>  
                            </select>
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


    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->

    <!-- select all boxes -->
    

    <form method="POST" action="{{ URL('/CreditNotesPost')}}">
        @csrf
        <div class="table-responsive" style="width: 100%;">
            <table id="customer_data" class="table table-bordered table-striped">
               
                <thead>
                    <tr> 
                <TH  style="text-align: center;">#</TH>
                <TH  style="text-align: center;">Company</TH>
                <TH  style="text-align: center;">Warehouse</TH>
                <TH  style="text-align: center;">Driver</TH>
                <TH  style="text-align: center;">STCPAY Account </TH>
                <TH  style="text-align: center;">STCPAY ID </TH>
                <TH  style="text-align: center;">Journal Date </TH>
                <!-- <TH  style="text-align: center;">Note</TH> -->
                <TH  style="text-align: center;">APM / Job ID </TH>
                <TH  style="text-align: center;">Balance</TH>
                <TH  style="text-align: center;">Last Transation </TH>
                <TH  style="text-align: center;">Available Feul Amount</TH>
                <TH  style="text-align: center;">Status</TH>
                <TH  style="text-align: center;">Paid Date </TH>
                <TH  style="text-align: center;"> Created By/At </TH> 
                <TH  style="text-align: center;">  Action </TH> 
                <!-- <TH  style="text-align: center;">Action</TH> -->
                </tr>
                </thead>
                <tbody>
                    @php
                    $total = 0; 

                    @endphp
                    @foreach($expenses as $k=>$expense)
                    @php 
                    $total = $total + $expense->debit;

                    @endphp
                    <tr style="text-align: center;">
                        <TD>{{$k+1}} </TD>
                        <TD>{{$expense->company->companyName}}</TD>
                        <TD>
                            @php  
                            $warehouse = $expense->driver['warehouse'];
                            if($warehouse['warehouseName'] != '' || $warehouse['warehouseName'] != NULL){
                                echo $warehouse['warehouseName'];
                            }else{
                                echo 'NULL';
                            }
                            @endphp
                           
                        </TD>
                        <TD>
                            @if($expense->reciver_Id != NULL)   
                                <a href="#" disabled class="btn btn-sm ">{{$expense->driver->fullName}}</a>  
                            @else
                            <a href="#" disabled class="btn btn-sm btn-danger">NULL</a>
                            @endif
                        </TD>
                        <TD>
                            @if($expense->reciver_Id != NULL)   
                                <a href="#" disabled  >{{$expense->driver->accountNumber}}</a>  
                            @else
                            <a href="#" disabled >NULL</a>
                            @endif
                       </TD>
                       <TD>
                            @if($expense->reciver_Id != NULL)   
                                <a href="#" disabled  >{{$expense->driver->account_owner_iqama}}</a>  
                            @else
                            <a href="#" disabled >NULL</a>
                            @endif
                       </TD>
                       <td>{{$expense->journal_date}}</td>
                       <TD>
                            @if($expense->reciver_Id != NULL)   
                                <a href="#" disabled  >{{$expense->driver->job_id}}</a>  
                            @else
                            <a href="#" disabled >NULL</a>
                            @endif

                       </TD>

                       <TD>
                           Balance

                       </TD>

                        <TD>
                           Last Transaction 
                             
                        </TD>
                        <TD>
                            <a class="btn btn-info" onclick="alertShow()">
                            Request A Fule Expense <br>
                            Available amount <br>
                            113 SAR 
                        </a>
                        </TD>
                        <!-- <TD></TD> -->
                        <TD>
                            @if($expense->status == 'Approved_by_supervisor')
                                
                                <a href="#" disabled class="btn btn-sm btn-success">{{$expense->status}}</a>  
                            @else
                                <a href="#" disabled class="btn btn-sm btn-warning">Paid</a>  
                            @endif    
                        </TD> 
                        <TD>
                            <!-- check if its driver or Company   -->
                            NULL

                        </TD>
                        <TD>
                            {{$expense->created_user->name}} <br>
                            {{$expense->created_at}}
                        </TD>
 
                        <TD>
                            @if($expense->status == 'Approved_by_supervisor')
                                <a id="6335" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>
                                <a id="6335" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>
                                <a id="6335" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>
                                <button type="button" class="btn btn-primary btn-xs updatePaid">Paid</button> 
                            @else
                                <a id="6335" data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>
                            @endif
                        <br>
                           
                        </TD>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    @if(Auth::user()->user_type_id==1)
                    <TH colspan='7'>Total </TH>
                    <TH colspan='8'>{{$total}}</TH>
                    @else
                        <TH colspan='5'>Total</TH>
                    @endif
                </tr>
                </tfoot>
            </table>
        </div>

        
        @if(Auth::user()->user_type_id==1)
        <center>
            <!-- <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">Post To Journal</button> -->
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
        function driver_window() {
            myWindow1 = window.open("{{URL("/DriverWindow")}}", "",
                "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
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
                $.getJSON("{{URL("/getExpenses")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_Period').empty();
                    $('#filter_warehouseId').empty();
                    //$('#filter_Period').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_Period').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });

            }
        }
    </script>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
   
<script>
function alertShow(){
    Swal.fire({
        title: 'Are you sure to confirme the feul expense ?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'confirme ',
        denyButtonText: `Don't confirme`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            Swal.fire('confirme!', '', 'success')
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })
}
</script>
@endsection




