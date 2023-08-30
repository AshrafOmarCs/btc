@extends('AdminLTE')
@section('content')  
    <style>
    .btn-success {
        background-color: #00a65a;
        border-color: #008d4c;
        width: 203px;
        height: 30px;
        margin-left: 18px;
    }
    
    #customer_data td{
        text-align:center;
    }
    #front_side,#rear_side,#right_side,#left_side,#intiror_side{
        border-radius: 11px;
        margin-top: 10px;
    }
    .table-image {
      td, th {
        vertical-align: middle;
      }
      .container {
          padding: 2rem 0rem;
        }
        
        h4 {
          margin: 2rem 0rem 1rem;
        }

    }
    </style>
    <link rel="stylesheet" href="{{asset('dropAndDrag/src/style.css')}}">
   
    <!-- ViewDAModal -->
    <div class="modal fade" id="ViewDAModal" tabindex="-1" role="dialog" aria-labelledby="ViewDAModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div id="response"></div>
        </div>
      </div>
    </div>
    
    
    
    <!-- View Vehicle Modal  -->
    <div class="modal fade" id="ViewVehicleModal" tabindex="-1" role="dialog" aria-labelledby="ViewVehicleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ViewVehicleModalLabel">Vehicle Details </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    

    <!-- View Vehicle's Images Modal  -->
    <div class="modal fade" id="ViewVehicleImageModal" tabindex="-1" role="dialog" aria-labelledby="ViewVehicleImageModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ViewVehicleImageModalLabel">Vehicle #(أ ب ت 6594) </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            View <span style="color:red" id=""></span> Image 
            <img src="#" id="mainImage" style="width: 100%;" alt="image">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="BackVehicleCheckup()">Back </button>
          </div>
        </div>
      </div>
    </div>
    
    
    
    <!-- Da Identity Approval Vehicle Modal  -->
    <div class="modal fade" id="DAIdentityApproveModal" tabindex="-1" role="dialog" aria-labelledby="DAIdentityApproveModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="DAIdentityApproveModalLabel">Driver Identity Approveal  </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table style="width: 95%;  margin: 0 auto;">
                <tr>
                    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Status:</span> <button  disabled id="status_text">Loading status</button> <input type="hidden" name="request_id" id="request_id"></td> 
                </tr>
                <tr>
                    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Project:</span > <span id="project_name">Loading...</span> </td>
                    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">HUB/Warehouse :</span> <span id="hub_name">Loading...</span></td> 
                </tr> 
                <tr>
                    <td><img style="width: 200px;" id="identity_file" src="{{asset('images/iqama.png')}}"></td>
                    <td><img style="width: 200px;" id="driving_licence" src="{{asset('images/driving-license.png')}}"></td>
                </tr> 
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="approveIdentity()" id="approveBtn">Approve</button>
          </div>
        </div>
      </div>
    </div> 
    
    
    
    
    <!-- create delegation Modal  -->
    <div class="modal fade" id="delegationModal" tabindex="-1" role="dialog" aria-labelledby="delegationModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="delegationModalLabel">Issue Delegation Doc  </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table style="width: 95%;  margin: 0 auto;">
                <tr>
                    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Driver :</span> <span id="job_id">Loading</span> </td> 
                    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Vehicle Plate  :</span>  <span id="plate_no">Loading</span> . </td>  
                </tr>
                    <!--<tr>-->
                    <!--    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Check-up Images Status :</span> Approved by <span>Mustafa Nimir</span>  <input type="hidden" name="request_id" id="request_id"></td> -->
                    <!--    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Check-up Accessories Status :</span> Approved by <span>Mustafa Nimir</span>  <input type="hidden" name="request_id" id="request_id"></td>  -->
                    <!--</tr>-->
                <tr>
                    
                </tr>
                <tr>
                    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Starting date:</span >   </td>
                    <td>  <input type="date"> </td> 
                </tr>
                
                <tr>
                    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Ending date:</span >   </td>
                    <td>  <input type="date"> </td> 
                </tr>
                <tr>
                    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Allowed Geographical Area :</span > <input type="text" placeholder="الرياض,جدة,,,الخ">  </td>
                </tr>
                 <tr> 
                    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Current Otometer Read</span> : <span style="color:red">106,002</span> K/M </td> 
                 </tr>
                 <tr> 
                     
                    <td><span style="font-size: 13px; font-family: monospace; font-weight: bold;">Otometer Read</span> : <span style="color:red">106,202</span> K/M Approved by Ashraf (<span style="cursor: pointer;color: blue; font-size: 15px; font-weight: bold;">Edit</span>)</td> 
                 </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="approveIdentity()" id="approveBtn">proceed</button>
          </div>
        </div>
      </div>
    </div> 
    
    
    
    
    
    
    <style>
        #checkUpTable td{
            text-align: center;
        }
        #priv_intiror_side,#priv_left_side,#priv_right_side,#priv_rear_side,#priv_front_side,#front_side{
            width: 141px;
            margin-top: 13px; 
        }
    </style>
    
    
      <!-- Vehicle accessories check-up Modal  -->
        <div class="modal fade" id="vehicleAccessoryCheckUpModal" tabindex="-1" role="dialog" aria-labelledby="vehicleAccessoryCheckUpModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="vehicleAccessoryCheckUpModalLabel">Vehicle Check-up #2155422  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
               
              <div class="modal-body">
                 <table style="width: 95%;  margin: 0 auto;" id="checkUpTable" class="table table-image">
                    <tr>
                        <td>
                            Accessory description
                        </td> 
                         <td>
                            Current Status
                        </td> 
                        <td>
                            Proposed Status
                        </td>   
                        <td>
                            Rejection count
                        </td>
                        <td>
                            Approval Status
                        </td>
                        
                        <td>
                            Select to reject
                        </td>
                    </tr>
                    <tbody id="accessoriesTable">
                        
                    </tbody>
                    <div >
                        
                    </div>
                    
                    </table> 
              </div>
               
              <div class="modal-footer">
                  <div class="form-group" style="text-align: left;">
                    <label for="exampleFormControlTextarea1" >Rejection reason (<span style="color:grey">Optional</span>)</label>
                    <textarea class="form-control" id="rejection_reason"  rows="3"></textarea>
                  </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
                <input type="hidden" name="checkUp_id" id="checkUp_id">
                <button type="button" class="btn btn-primary"  id="approveAccessoryBtn" onclick="vaidateAccessory()">Proceed</button>
              </div>
            </div>
          </div>
        </div>
        
    
    
    
     <!-- Vehicle check-up Modal  -->
    <div class="modal fade" id="vehicleCheckUpModal" tabindex="-1" role="dialog" aria-labelledby="vehicleCheckUpModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="vehicleCheckUpModalLabel">Vehicle Check-up #2155422  </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           
          <div class="modal-body">
             
            <table style="width: 95%;  margin: 0 auto;" id="checkUpTable" class="table table-image">
                <tr>
                    <td>
                        Desc
                    </td> 
                     <td>
                        Prive Image
                    </td> 
                    <td>
                        new image
                    </td> 
                    <td>
                        Supervisor approve
                    </td>
                    <td>
                        Skip
                    </td>
                </tr>
                
                <tr id="checkUpImages">
                    <td>
                        Front-side
                    </td> 
                     <td>
                        <img id="priv_front_side" onclick="openViewVehicleModal(this.src)" src="{{asset('images/585d0331234507.564a1d239ac5e.gif')}}" alt="priv front-side">
                    </td> 
                     <td>
                        <img id="front_side" onclick="openViewVehicleModal(this.src)" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="front-side">
                    </td>`
                    <td style="text-align: center;">
                        <img style="width: 63px;" src="{{asset('images/loading.svg')}}">
                        <br>
                        <small>Not Yet</small>
                    </td>
                    <td>
                        <input type="checkbox"  value="front">
                    </td>
                    
                </tr>
                
                <tr>
                    <td>
                        Rear-side
                    </td> 
                     <td>
                        <img id="priv_rear_side" onclick="openViewVehicleModal(this.src)" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="priv Rear-side">
                    </td> 
                     <td>
                        <img id="rear_side" onclick="openViewVehicleModal(this.src)" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="Rear-side">
                    </td> 
                    <td style="text-align: center;">
                        <img style="width: 63px;" src="{{asset('images/loading.svg')}}">
                        <br>
                        <small>Not Yet</small>
                    </td>
                    <td>
                        <input type="checkbox" value="rear">
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Right-side
                    </td> 
                     <td>
                        <img id="priv_right_side" onclick="openViewVehicleModal(this.src)" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="priv Right-side">
                    </td> 
                     <td>
                        <img id="right_side" onclick="openViewVehicleModal(this.src)" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="Right-side">
                    </td> 
                    <td style="text-align: center;">
                        <img style="width: 63px;" src="{{asset('images/loading.svg')}}">
                        <br>
                        <small>Not Yet</small>
                    </td>
                    <td>
                        <input type="checkbox" value="right">
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Left-side
                    </td> 
                     <td>
                        <img id="priv_left_side" onclick="openViewVehicleModal(this.src)" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="priv Front-side">
                    </td> 
                     <td>
                        <img id="left_side" onclick="openViewVehicleModal(this.src)" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="Front-side">
                    </td> 
                    <td style="text-align: center;">
                        <img style="width: 63px;" src="{{asset('images/loading.svg')}}">
                        <br>
                        <small>Not Yet</small>
                    </td>
                    <td>
                        <input type="checkbox" value="left">
                    </td>
                </tr>
                <tr>
                    <td>
                        Intiror-side
                    </td> 
                     <td>
                        <img onclick="openViewVehicleModal(this.src)" id="priv_intiror_side" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="priv Intiror-side">
                    </td> 
                     <td>
                        <img onclick="openViewVehicleModal(this.src)" id="intiror_side" src='{{asset('images/585d0331234507.564a1d239ac5e.gif')}}' alt="Intiror-side">
                    </td> 
                    <td style="text-align: center;">
                        <img style="width: 63px;" src="{{asset('images/loading.svg')}}">
                        <br>
                        <small>Not Yet</small>
                    </td>
                   <td>
                        <input type="checkbox" value="interior">
                    </td>
                </tr>
                
                <tr>
                    <td style="margin-top: 14px;"> 
                        Otometer Read <span style="color:red">*</span>
                    </td> 
                    <td  style="margin-top: 14px;">
                        <input type="number" min="0" id="otometer_read" placeholder="Please Enter Otometer Read" >
                    </td>  
                    <td style="text-align: center;">
                        Rejection reason <span style="color:red">*</span><br>
                        <small>If applicable</small>
                    </td>
                    <td>
                        <textarea id="checkupRejectionReason"></textarea>
                    </td>
                    <td>
                        <!--<button>Reject(3)</button>-->
                    </td>
                    
                </tr>
                
                
                
            </table>
          </div>
           
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="checkUpImageHandler()" id="approveBtn">Approve</button>
          </div>
        </div>
      </div>
    </div>
    
    
    
    <style>
        th{
            /* background-color: #d4c8b8; */
        }
        td{
            /* box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; */
            border: 1px solid white;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Vehicles Requests</h2>
        </div>
        @if(Auth::user()->user_type_id==1||session('Session_DriversCarrefour')=='yes')
            <div style="float:right;">
                {{-- <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Bulk Upload</a>
                </h2> --}}
            </div>
        @endif
    </div>
    <!-- end of header -->
    <div class="card card-default" style="width:100%;clear:both;"></div>

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
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box" class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive">
                <table class="table m-0 search_table" style="width:10px!important;">
                    <tr>
                        <TH>Company Name</TH>
                        <td>
                            <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                    class="form-control" style="width:200px;" required>
                                <option value=""></option>
                                
                            </select>
                        </td> 
                        <TH>Warehouse Name</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                    style="width:180px;"> 
                                <option value=""></option> 
                            </select>
                        </td>
                        <TH>full Name</TH>
                        <td><input type="text" class="form-control" style="width:180px;" id="filter_fullName"
                                   name="filter_fullName"></td>
                    </tr>
                    <tr> 
                        <TH>Mobile</TH>
                        <td><input type="text" class="form-control" name="filter_mobileNumber" id="filter_mobileNumber">
                        </td>
                        <TH>Iqama</TH>
                        <td><input type="text" class="form-control" name="filter_iqama" id="filter_iqama"></td>

                        <TH>Email ID</TH>
                        <td><input type="text" class="form-control" name="filter_email_id" id="filter_email_id"></td>

                    </tr>

                    <tr>
                        <TH>Job ID</TH>
                        <td><input type="text" class="form-control" name="filter_job_id" id="filter_job_id"></td>

                        <TH>Status</TH>
                        <td>
                            <select name="filter_status_id" id="filter_status_id" onchange="status()"
                                    class="form-control">
                                <option value=""></option>

                               
                            </select>
                        </td>
                        <TH>Account_Owner_Iqama</TH>
                        <td><input type="text" class="form-control" name="filter_account_owner_iqama"
                                   id="filter_account_owner_iqama">
                        </td>

                    </tr>


                    <tr>

                        <TH>accountNumber</TH>
                        <td><input type="text" class="form-control" name="filter_accountNumber"
                                   id="filter_accountNumber"></td>
                        <TH>Driver Type</TH>
                        <td>
                            <select name="filter_driver_type_id" id="filter_driver_type_id" class="form-control">
                                <option value=""></option>
                                
                            </select>
                        </td>

                        <TH>Bander Car</TH>
                        <td>
                            <select name="filter_bander_car_id" id="filter_bander_car_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Image Identity</TH>
                        <td>
                            <select name="filter_Image_Identity" id="filter_Image_Identity" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Image Passport</TH>
                        <td>
                            <select name="filter_Image_Passport" id="filter_Image_Passport" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Image DrivingLicence</TH>
                        <td>
                            <select name="filter_Image_DrivingLicence" id="filter_Image_DrivingLicence"
                                    class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <TH>Image VehiclesRegistration</TH>
                        <td>
                            <select name="filter_Image_VehiclesRegistration" id="filter_Image_VehiclesRegistration"
                                    class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Image JobContract</TH>
                        <td>
                            <select name="filter_Image_JobContract" id="filter_Image_JobContract" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                        <TH>Image PromissoryNote</TH>
                        <td>
                            <select name="filter_Image_PromissoryNote" id="filter_Image_PromissoryNote"
                                    class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Created_At</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_created_at" id="filter_created_at" type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_created_at"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_created_at"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_created_at"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });

                                </script>
                            </div>
                        </td>
                        <TH>Updated_At</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" id="filter_updated_at" name="filter_updated_at" type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_updated_at"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_updated_at"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_updated_at"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });

                                </script>
                            </div>
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


    <div class="table-responsive" style="width: 100%;">

        <table id="customer_data" class="table table-bordered table-striped table-responsive">
            <thead>
                <TH>#</TH>
                <TH >City</TH>
                <TH >Plate</TH>                
                <th scope="col">Vehicle </th> 
                <th scope="col">Opreater Company </th> 
                <th scope="col">DA </th> 
                <th scope="col">DA Approval </th> 
                <th scope="col">Request type </th>  
                <th scope="col">Request Date </th>  
                <th scope="col">Status</th> 
                <th scope="col">Progress percentage </th> 
                <th scope="col">Vehicle check </th>
                <th>Identity Approvel</th>
                <th scope="col">Operations</th>  
            </thead>
            <tbody>
                   
                @foreach($payload as $k=>$item)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$item->city_name}}</td>
                        <td>{{$item->plate}}</td>
                        <td>
                            {{$item->color}}, {{$item->vehicle_manufacturer_name}}, {{$item->vName}}, {{$item->manufacturer_date}}    <span> <button data-toggle="modal" data-target="#ViewVehicleModal"> <a href="#"><i class="fa fa-eye"></i></a></button></span>
                        </td>
                        <td> {{$item->opreatoers}}</td> 
                        <td>{{$item->fullName}},  <span style="color:red">{{$item->job_id}}</span> <span> <button > <a href="javascript:driver('{{$item->driver_id}}')"><i class="fa fa-eye"></i></a></button></span></td>
                        <td style="text-align: center;">
                            @if($item->driver_data == 'pending')
                                <button disabled>Waiting DA Confrime Data</button>
                            @endif
                            
                            @if($item->driver_data == 'applied')
                                <button>Approve DA</button>
                            @endif
                            
                            
                            @if($item->driver_data == 'approved')
                                <img style="width: 38px; margin: 0 auto;" src="https://btcdmins.com/images/check.png" alt="driver approved check">
                            @endif
                            
                            
                            
                        </td>
                        <td>
                            <span class="badge badge-warning"> 
                                {{$item->name_en}}
                            </span>
                        </td>
                        <td> {{ \Carbon\Carbon::parse($item->request_issue_date)->format('j F, Y') }} </td>
                        <td>
                            
                            <br>
                            @if($item->urlityAbpprovalStatus == 'Rejected') 
                            {{$item->status}}
                            <span class="badge badge-warning"> 
                                Request is  & Accessories has been Rejected by Supervisor
                            </span>
                            @else
                                <span class="badge badge-info"> 
                                    {{$item->status}} 
                                </span> 
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-success"> 
                                20%
                            </span>
                            
                        </td>
                        <td> 
                            <button onclick="PreviewAccessoriesCheckUp('{{$item->vehicle_check_id}}')" style="margin: 5px;">Preview Accessories</button>
                            <button onclick="PreviewCheckUp('{{$item->vehicle_check_id}}')">Preview Check-up</button><br> 
                        </td>
                        <td>
                            @if($item->supporvisor_identity_approve == 0)
                                <button onclick="setRequestIdAndOpenModal('{{$item->requests_id}}','{{$item->driver_id}}','{{$item->supporvisor_identity_approve}}')">Approve</button>  
                            @endif
                            
                            @if($item->supporvisor_identity_approve != 0)
                                <img style="width: 38px; margin: 0 auto;" src="https://btcdmins.com/images/check.png" alt="driver approved check">   <br>
                                <small>Approved By : <span style="color:grey">Ashraf Omar<span></small><br>
                                <button onclick="setRequestIdAndOpenModal('{{$item->requests_id}}','{{$item->driver_id}}','{{$item->supporvisor_identity_approve}}')">View</button>
                                
                               
                                
                            @endif
                        </td>
                        <td>
                             <button onclick="setRequestIdAndCreate('{{$item->requests_id}}','{{$item->driver_id}}','{{$item->supporvisor_identity_approve}}','{{$k}}')">Issue Deleation</button>  
                        </td> 

                    </tr>
                @endforeach
            </tbody>
            <thead class="thead-dark">
                <tr>
                    <th scope="col" style="border-left: 1px solid #08c !important;">#</th> 
                    <TH >City</TH>
                    <TH >Plate</TH>
                    <th scope="col">Vehicle </th> 
                    <th scope="col">Opreater Company </th> 
                    <th scope="col">DA </th>  
                    <th scope="col">DA Approval </th>
                    <th scope="col">Request type </th>  
                    <th scope="col">Request Date </th>  
                    <th scope="col">Status</th>  
                    <th scope="col">Progress percentage </th>
                    <th scope="col">Vehicle check </th>
                    <th>Identity Approvel</th>
                    <th scope="col">Operations</th>  
                </tr>
        </thead>
        </table>
    </div>
 
    <script src="{{asset('dropAndDrag/src/script.js')}}"></script> 
    
    <script>
        function driver(id) {
            document.getElementById('response').innerHTML = loader;
            $('#ViewDAModal').modal('toggle')
             
            $.ajax({
                type: 'GET',
                url: "{{URL("/Drivers")}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data; 
                }
            });
            
            // ViewDAModal on click #edit_modalCancelBtn
        } 
        
        // request_id
        // open modal and set request_id function
        function setRequestIdAndOpenModal(args,driver_id,supporvisor_identity_approve){
            $('#approveBtn').prop('disabled', true);
            $('#driving_licence').width('200px');
            $('#identity_file').width('200px');
            $('#driving_licence').attr("src", '{{asset('images/driving-license.png')}}'); 
            $('#identity_file').attr("src", '{{asset('images/iqama.png')}}');
            
            $('#request_id').val(args)
            // Fill modal Data 
            
            // Post Request to get Driver data 
            
            $.ajax({
                type: 'GET',
                url: "{{URL("/Drivers/approval-review")}}" + "/" + driver_id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    let payload = JSON.parse(data);
                    console.log(payload.payload.companyName)
                    console.log(payload.payload)
                    if(payload.status == true){
                        
                        $('#project_name').text(payload.payload.companyName)
                        $('#hub_name').text(payload.payload.warehouseName)
                        $('#driver_fullName').text(payload.payload.fullName)
                        if(payload.payload.iqama == null){
                            $('#driver_identity_no').text("NULL")
                            $('#driver_identity_no').css("color:red");
                        }else{
                            $('#driver_identity_no').text(payload.payload.iqama)
                        }
                        
    
                        if(payload.payload['licenseProof'] == null){
                            $('#driving_licence').attr("src", '{{asset('images/driving-license.png')}}');
                            $('#driving_licence').width('200px'); 
                        }else{
                            $('#driving_licence').width('300px');
                            $('#driving_licence').attr("src", '/'+payload.payload['licenseProof']);
                        }
                        if(payload.payload['identityProof'] == null){ 
                            // width: 200px;
                            $('#identity_file').attr("src", '{{asset('images/iqama.png')}}');
                            $('#identity_file').width('200px');
                        }else{
                            $('#identity_file').width('300px');
                            $('#identity_file').attr("src", '/'+payload.payload['identityProof']);
                        }
                        
                        
                        if(payload.payload['licenseProof'] == null || payload.payload['identityProof'] == null){
                            $('#status_text').text('Waiting Approval')
                            $('#approveBtn').prop('disabled', true);
                            // $(':input[type="submit"]').prop('disabled', false);
                        }else{
                             console.log('supporvisor_identity_approve')
                            console.log(supporvisor_identity_approve)
                            if(supporvisor_identity_approve == 1){ 
                                $('#status_text').text('Approved At 28-02-2023')
                                $('#approveBtn').prop('disabled', true);
                            }else{
                                $('#status_text').text('Waiting Approval ')
                                $('#approveBtn').prop('disabled', false);
                            }
                            
                        }
                        
                        
                    }
                }
            }); 
            // End of fill modal Data 
            $('#DAIdentityApproveModal').modal('toggle')
            
        }
        function approveIdentity(){
            let request_id = $('#request_id').val();
            alert(request_id); 
        }
         
        function PreviewCheckUp(args){
            $('#checkUp_id').val(args);
            $.ajax({
                type: 'GET',
                url: "{{URL("Vehicles/Check-up")}}" + "/" + args,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    let payload = JSON.parse(data);
                    
                    if(payload.status){
                        let payloadData = payload.data; 
                        $('#accessoriesTable').html(payloadData.accssorieTable)
                        console.log()
                        let checkUp = payloadData.checkUp;
                        let privCheckUp = payloadData.privCheckUp; 
                        
                        if(checkUp.front_image_approve == "false"){
                            // front.png
                            $('#priv_front_side').width('200px');
                            $('#priv_front_side').attr("src",  "{{asset('images/front.png')}}"); 
                            
                            
                        }
                        if(checkUp.rear_image_approve == "false"){
                            // front.png
                            $('#priv_rear_side').width('200px');
                            $('#priv_rear_side').attr("src",  "{{asset('images/rear.png')}}"); 
                        }
                        // priv_right_side priv_left_side  priv_intiror_side
                        if(checkUp.right_image_approve == "false"){
                            // front.png
                            $('#priv_right_side').width('200px');
                            $('#priv_right_side').attr("src",  "{{asset('images/right.png')}}"); 
                        }
                        if(checkUp.left_image_approve == "false"){
                            // front.png
                            $('#priv_left_side').width('200px');
                            $('#priv_left_side').attr("src",  "{{asset('images/left.png')}}"); 
                        }
                        if(checkUp.interior_image_approve == "false"){
                            // front.png
                            $('#priv_intiror_side').width('200px');
                            $('#priv_intiror_side').attr("src",  "{{asset('images/interior.png')}}"); 
                        } 
                        
                        
                        $('#front_side').width('300px');
                        $('#front_side').attr("src",  '{{url('')}}'+'/'+checkUp.front_image); 
                        $('#rear_side').width('300px');
                        $('#rear_side').attr("src",  '{{url('')}}'+'/'+checkUp.rear_image);
                        
                        $('#left_side').width('300px');
                        $('#left_side').attr("src",  '{{url('')}}'+'/'+checkUp.left_image);
                        
                        $('#right_side').width('300px');
                        $('#right_side').attr("src",  '{{url('')}}'+'/'+checkUp.right_image);
                        
                        $('#intiror_side').width('300px');
                        $('#intiror_side').attr("src",  '{{url('')}}'+'/'+checkUp.drivingWheel_image);
                        
                        
                        // rear_side,right_side,left_side,intiror_side
                        $('#vehicleCheckUpModal').modal('toggle') 
                        
                        //#priv_intiror_side,#priv_left_side,#priv_right_side,#priv_rear_side,#priv_front_side,#front_side
                        // console.log(checkUp)
                    }
                     
                }
            }); 
            console.log(args)
        }
        function openViewVehicleModal(args){
            console.log('openViewVehicleModal');
            console.log(args) 
            $('#mainImage').attr("src",  args); 
            
            $('#vehicleCheckUpModal').modal('hide') 
            $('#ViewVehicleImageModal').modal('toggle') 
            // ViewVehicleModal
        }
        function BackVehicleCheckup(){
            $('#vehicleCheckUpModal').modal('toggle') 
            $('#ViewVehicleImageModal').modal('hide')
            
        }
        const change = src => {
            document.getElementById('main').src = src
        }
        function PreviewAccessoriesCheckUp(args){
            console.log(args)
             $.ajax({
                type: 'GET',
                url: "{{URL("Vehicles/Check-up")}}" + "/" + args,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    let payload = JSON.parse(data);
                    
                    if(payload.status){
                        let payloadData = payload.data; 
                        // 
                        $('#checkUp_id').val(args)
                        $('#accessoriesTable').html(payloadData.accssorieTable)
                        $('#vehicleAccessoryCheckUpModal').modal('toggle')
                    }
                     
                }
            }); 
           
            
        }
        function vaidateAccessory(){
            let checkUp_id = $('#checkUp_id').val(); 
            let checkedAccessories = selectedCheckbox(); 
            // check if reject check box is selected
            if(checkedAccessories.length>0){
                // send Rejction 
                let payload = {
                    "check_id":checkUp_id,
                    "items":checkedAccessories,
                    "rejction_reason":$('#rejection_reason').val(),
                    "action":"reject"
                } 
                $.ajax({
                    type: 'POST',
                    url: "{{URL("Vehicles/CheckUp-Accessories-Handler")}}",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data:{"_token": "{{ csrf_token() }}",payload}, 
                    success: function (data) {
                        location.reload();
                        alert('Done'); 
                    }
                }); 
            }else{
                // send Approval
                let payload = {
                    "check_id":checkUp_id,
                    "items":[],
                    "rejction_reason":null,
                    "action":"approve"
                } 
                $.ajax({
                    type: 'POST',
                    url: "{{URL("Vehicles/CheckUp-Accessories-Handler")}}",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data:{"_token": "{{ csrf_token() }}",payload}, 
                    success: function (data) {
                        location.reload();
                        alert('Done'); 
                        // document.getElementById('response').innerHTML = data; 
                    }
                });
            }
                
            
            $('#approveAccessoryBtn').prop('disabled', false);
        }
        function selectedCheckbox(){
            var array = []
            var checkboxes = document.querySelectorAll('#accessoriesTable input[type=checkbox]:checked')
            
            for (var i = 0; i < checkboxes.length; i++) {
              // console.log(checkboxes[i].value);
              array.push(checkboxes[i].value)
            }
            return array;
        }
        function checkUpImageHandler(){
            let otometer_read = $('#otometer_read').val();
            if(otometer_read == '' || otometer_read == null){
                alert('Otometer read can not be empty');
                return false;
            }
            alert($('#otometer_read').val());
            let checkUp_id = $('#checkUp_id').val(); 
            
            var array = []
            var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
            
            for (var i = 0; i < checkboxes.length; i++) {
                array.push(checkboxes[i].value)
            }
             

            let skippedCheckUpImages = array; 
            
            // check if reject check box is selected
            if(skippedCheckUpImages.length>0){
                let checkupRejectionReason = $('#checkupRejectionReason').val();
                if(checkupRejectionReason == null || checkupRejectionReason == ''){
                    alert('Reject Reason Can not be empty');
                    return 0;
                }
                // rejected by supervisor
                // send http
                //  URL : Vehicles/CheckUpImageHandler
                let payload = {
                    "check_id":checkUp_id,
                    "items":skippedCheckUpImages,
                    "rejction_reason":$('#checkupRejectionReason').val(),
                    "Otometer_Read":$('#otometer_read').val(),
                    "action":"reject"
                } 
                $.ajax({
                    type: 'POST',
                    url: "{{URL("Vehicles/CheckUpImageHandler")}}",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data:{"_token": "{{ csrf_token() }}",payload}, 
                    success: function (data) {
                        location.reload();
                        // alert('Done');
                        
                        // document.getElementById('response').innerHTML = data; 
                    }
                }); 
                console.log(skippedCheckUpImages);
            }else{
                let payload = {
                    "check_id":checkUp_id,
                    "items":[],
                    "rejction_reason":null,
                    "Otometer_Read":$('#otometer_read').val(),
                    "action":"approve"
                } 
                $.ajax({
                    type: 'POST',
                    url: "{{URL("Vehicles/CheckUpImageHandler")}}",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data:{"_token": "{{ csrf_token() }}",payload}, 
                    success: function (data) {
                        console.log(data);
                        // alert('Done'); 
                        location.reload();
                        // document.getElementById('response').innerHTML = data; 
                    }
                });
            }
            alert('as');
        }
        function setRequestIdAndCreate(args,driver_id,supporvisor_identity_approve,index){
            
            var arrayFromPHP = <?php echo json_encode($payload); ?>;
            arrayFromPHP = arrayFromPHP[index];
            // job_id,project_details
            $("#job_id").empty();
            $('#job_id').text(arrayFromPHP['job_id'])
            
            $("#project_details").empty();
            $('#plate_no').text(arrayFromPHP['plate'])
            // http request 
            console.log(arrayFromPHP);
            $('#delegationModal').modal('toggle')
        }
    </script> 
    <!-- 
    $('#left_image').attr("src", payload[index].images['left_image']);
    $("#front_image_reviedBy").empty();
    $('#front_image_reviedBy').text(payload[index].images['ApprovedBy'])
    $('#selectedVehicle').val(selectedVehicle)
    -->
@endsection