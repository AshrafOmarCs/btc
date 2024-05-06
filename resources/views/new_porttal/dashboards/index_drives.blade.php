@extends('layout2')
@section('content')
<!-- Data Tables -->
<link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bs5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bs5-custom.css')}}" />


<!-- Modal ExportExcel 3 -->
<div class="modal fade" id="FillterButton" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> Fillter</h5>
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
                                        <!-- Form Field Start -->
                                        <div class="mb-3"> 
                                            <label for="country" class="form-label">Company </label> 
                                            <select class="form-control" onchange="WarehouseName()" name="filter_companyId" id="filter_companyId">
                                                <option></option>
                                                @foreach ($lkp_company as $item)
                                                    <option value="{{$item->id}}">{{$item->companyName}}</option>
                                                @endforeach 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Warehouse</label>
                                            <select class="form-control" id="filter_warehouseId" name="filter_warehouseId" >
                                                <option></option> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Status</label>
                                            <select class="form-control" id="country">
                                                <option></option>
                                                @foreach($lkp_driver_status as $status)
                                                    <option>{{$status->driver_status_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="FullName" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="filter_fullName" name="filter_fullName" placeholder="FullName">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="Mobile" class="form-label">Mobile</label>
                                            <input type="text" class="form-control" name="filter_mobileNumber" id="filter_mobileNumber" placeholder="Mobile">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="iqama" class="form-label">Identity or Iqama</label>
                                            <input type="text" class="form-control" name="filter_iqama" id="filter_iqama" placeholder="Identity or Iqama">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="iqama" class="form-label">Driver Job ID</label>
                                            <input type="text" class="form-control" name="filter_job_id" id="filter_job_id" placeholder="Driver Job ID">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Driver Type</label>
                                            <select class="form-control"  name="filter_driver_type_id" id="filter_driver_type_id">
                                                <option></option>
                                                @foreach($lkp_driver_status as $status)
                                                    <option>{{$status->driver_status_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
 
                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="accountNumber" class="form-label">STCPAY Number  </label>
                                            <input type="text" class="form-control" name="filter_accountNumber" id="filter_accountNumber"
                                                placeholder="9665*****">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="enterPassword" class="form-label">STCPAY Owner ID </label>
                                            <input type="text" class="form-control" name="filter_account_owner_iqama" id="filter_account_owner_iqama"
                                                placeholder="STCPAY Owner ID">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <label for="enterPassword" class="form-label">Created at</label>
                                            <input type="text" class="form-control" name="filter_created_at" id="filter_created_at"
                                                placeholder="STCPAY Owner ID">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start -->
                                        <div class="m-0">
                                            <div class="form-label">Updated at </div>
                                            <div class="input-group">
												<span class="input-group-text">
													<i class="bi bi-calendar4"></i>
												</span>
												<input type="date" class="form-control datepicker-range" id="filter_updated_at" name="filter_updated_at">
											</div>
                                        </div>
                                    </div>
{{-- 
                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start --> 
                                        <label for="Created_by" class="form-label">Created by</label>
                                        <select class="form-control" id="Created_by">
                                            <option>Select account</option>
                                            <option>Ashraf</option>
                                            <option>Samir</option>
                                            <option>Canada</option>
                                            <option>Gremany</option>
                                            <option>India</option>
                                            <option>Japan</option>
                                            <option>England</option>
                                            <option>Brazil</option>
                                        </select> 
                                    </div> --}}

                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <!-- Form Field Start --> 
                                        <label for="Updated_by" class="form-label">Updated by</label>
                                        <select class="form-control" id="Updated_by">
                                            <option>Select account</option>
                                            <option>Ashraf</option>
                                            <option>Samir</option>
                                            <option>Canada</option>
                                            <option>Gremany</option>
                                            <option>India</option>
                                            <option>Japan</option>
                                            <option>England</option>
                                            <option>Brazil</option>
                                        </select> 
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
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" 
                    data-bs-dismiss="modal" >Search</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal addNewDriver3 -->
<div class="modal fade" id="addNewDriver" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollableLabel">Add New Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="statment"> 
                    <h5>Please select a method from bellow options: </h5>
                     <div class="row">
                        <div class="col-6" style="text-align: center;" onclick="handleContent('Form')"> 
                            <img  style="width: 74px; margin-top: 20px;cursor: pointer;" src="{{asset('design/assets/sign-form.png')}}" alt="fill form to create New driver" >
                        </div>
                        <div class="col-6" style="text-align: center;" onclick="handleContent('Bulk')">
                            <img  style="width: 74px; margin-top: 20px;cursor: pointer;" src="{{asset('design/assets/file.png')}}" alt="fill form to create New driver" >
                        </div>
                     </div>
                </div>

                <div id="create_da_from" style="display: none"> 
                    <h5>Please select a method from bellow options: </h5>
                      <h6>Form Data</h6>
                </div>
                <div id="create_da_bulk" style="display: none"> 
                    <h5>Please select a method from bellow options: </h5>
                      <h6>create_da_bulk</h6>
                </div>

                <div id="selectBulkOrOne" style="display: none"> 
                    <h5>You can add new drivers to system by two way, The first by filling a form, second is by downloading an excel file the upload it .......</h5>
                    <div class="form-check">
                        <input class="form-check-input"  type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">I have read the above statmet and im responsable ....</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="showSelectBulkOrOne('statment')">Understood</button>
            </div>
            
        </div>
    </div>
</div>
<!--End Modal addNewDriver 3 -->

<!-- Modal ExportExcel 3 -->
<div class="modal fade" id="ExportExcel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Export Excel File </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Row start -->
                        <div class="row">
                            <div class="col-xl-12 col-sm-12 col-12">
                                
                                    <h6>Custom filter: </h6>
                                    <hr style="margin: 8px 0;">
                            </div>
                        </div>
						<div class="row">
                            <div class="col-xl-12 col-sm-6 col-6">
								<div class="card">
									<div class="card-body">
                                        <div >
											{{-- <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"> --}}
											<h6>Driver:</h6>
                                            <hr style="margin: 8px 0;">
										</div>
                                        <div class="form-check">
											<input class="form-check-input" type="checkbox" checked value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Select All</label>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Company</label>
										</div>
                                        <div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Warehouse</label>
										</div>
                                        <div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">City</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Driver name</label>
										</div>
                                        <div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Driver's job ID</label>
										</div>
                                        <div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Driver's Identity/Iqama</label>
										</div>
                                        <div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Driver's Contact number</label>
										</div>
                                        
                                        {{-- <div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">STCPAY Owner Identity/Iqama</label>
										</div> --}}
									</div>
								</div>
							</div> 
							<div class="col-xl-12 col-sm-6 col-6">
								<div class="card">
									<div class="card-body">
                                        
                                        <div >
											{{-- <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"> --}}
											<h6>Finance:</h6>
                                            <hr style="margin: 8px 0;">
										</div> 
                                        <div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">STCPAY Owner Identity/Iqama</label>
										</div>
                                        <div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">STCPAY Number</label>
										</div> 
                                        <div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Total number of <strong>Days</strong></label>
										</div> 
                                        <div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Total number of <strong>TP</strong></label>
										</div> 
									</div>
								</div>
							</div>  
						</div>
						<!-- Row end -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" 
                    data-bs-dismiss="modal" >Export</button>
            </div>
        </div>
    </div>
</div>
 
<!--End Modal ExportExcel 3 -->

 <!-- Row start -->
 <div class="row">
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-green">
                <i class="bi bi-handbag"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-green">{{ number_format($analatics['active'], 0, '.', ',')}} </h3>
                <p>Active</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-red">
                <i class="bi bi-pie-chart"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-red" style="font-size: 19px;">{{ number_format($analatics['Onhold'], 0, '.', ',')}} </h3>
                <p>On hold & Vacation</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-blue">
                <i class="bi bi-emoji-smile"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-blue"> {{ number_format($analatics['Terminated'], 0, '.', ',')}} </h3>
                <p>Terminated & Resigned</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="stats-tile">
            <div class="sale-icon shade-yellow">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="sale-details">
                <h3 class="text-yellow"> {{ number_format($analatics['wrongWarehouse'], 0, '.', ',')}} </h3>
                <p>Wrong Warehouse</p>
            </div>
        </div>
    </div> 
</div>
<!-- Row end -->


<div class="row">
    <div class="col-sm-12 col-12"> 
        <!-- Card start -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Drivers</div>
            </div>
            								<!-- Card start -->
								<div class="card">
									<div class="card-header">
                                        <div class="card-title" style="font-size: 16px;">This interface enables you to browse, edit, and add Drivers as well as exporting their data </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="custom-btn-group"> 
                                                    <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>Fillter</button> 
                                                    <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" data-bs-target="#ExportExcel"></i>Export Excel</button> 
                                                    <button type="button" class="btn btn-info" class="btn btn-info" data-bs-toggle="modal" type="button" data-bs-target="#addNewDriver" onclick="addNewDriver()"></i>Add new driver</button> 
                                                </div>
                                            </div>
                                        </div>
										
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="highlightRowColumn" class="table custom-table">
												<thead>
                                                    <tr>
                                                        <th><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"> </th>
                                                        <th>Project</th>
                                                        <th>Warehouse</th>
                                                        <th>Driver Name</th>
                                                        <th>Driver ID</th>
                                                        <th>Driver's Docs</th>
                                                        <th>Status</th>
                                                        <th>STCPAY Number</th>
                                                        <th>STCPAY Identity</th>
                                                        <th>P-Balance</th>
                                                        <th>C-Balance</th>
                                                        <th>Last Update</th> 
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for($i=0;$i<=15;$i++)
                                                        <tr>
                                                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                                                            <td><img src="data:image/jpeg;base64,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" class="flag-img-lg" alt="Best Admin Dashboards">
                                                                I-Mile/Jeddah</td> 
                                                            <td>Riyadh Station</td>
                                                            <td><a href="">BTC Ahmed ali </a></td>
                                                            <td>D210669855</td>
                                                            <td>
                                                                <ul>
                                                                    <li>  Identity/Iqama: <a href="#"><i style="color: green" class="bi bi-check2-square"></i></a></li>
                                                                    <li> Promissory Note: <a href="#"><i style="color: green" class="bi bi-check2-square"></i></a></li>
                                                                    <li> Contract: <a href="#"><i style="color: green" class="bi bi-check2-square"></i></a></li>
                                                                </ul>
                                                            </td>
                                                            <td><span style="color: green">Active</span></td>
                                                            <td>966539529559 </td>
                                                            <td>2143345649</td>
                                                            <td>P-61</td>
                                                            <td>C-61</td>
                                                            <td>2011/04/25</td>
                                                            <td>
                                                                <button type="button" class="btn btn-light"><i class="bi bi-list text-green"></i> </button>
                        
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                                                      aria-expanded="false">
                                                                      Options
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                    
                                                                      <li><a class="dropdown-item" href="#">Edit</a></li>
                                                                      <li>
                                                                        <hr class="dropdown-divider">
                                                                      </li>
                                                                      <li><a class="dropdown-item" href="#">Reset-password</a></li>
                                                                      <li>
                                                                        <hr class="dropdown-divider">
                                                                      </li>
                                                                      <li><a class="dropdown-item" href="#">Attachment</a></li>
                                                                      <li>
                                                                        <hr class="dropdown-divider">
                                                                      </li>  

                                                                      <li><a class="dropdown-item" href="#">Report Driver</a></li>
                                                                      <li>
                                                                        <hr class="dropdown-divider">
                                                                      </li>  


                                                                      <li><a class="dropdown-item" href="#"><span style="color:red">Delete</span></a></li>
                                                                 
                                                                    </ul>
                                                                  </div> 
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
											</table>
										</div>
									</div>
								</div>
								<!-- Card end -->
        </div>
        <!-- Card end -->
  
    </div>
</div>
<script>
    function addNewDriver(){
        $('#create_da_bulk').hide();
            $('#create_da_from').hide(); 
            $('#statment').show(); 
    }
    function showSelectBulkOrOne(args){
        var link = document.getElementById('statment');
         
            
        link.style.display = 'none'; //or
        var link = document.getElementById('selectBulkOrOne');
        link.style.display = 'block'; //or
        // link.style.visibility = 'hidden';
    }
    function handleContent(args){
        if(args == 'Form'){
            $('#create_da_bulk').hide();
            $('#statment').hide();
            $('#create_da_from').show(); 
        }else{
            $('#create_da_bulk').show();
            $('#statment').hide();
            $('#create_da_from').hide(); 
        }
        console.log(args);
    }
    function WarehouseName() {

        var filter_companyId = document.getElementById('filter_companyId').value;

        $('#filter_warehouseId').empty();

        $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
            $('#filter_warehouseId').empty();
            $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
            $.each(json, function (i, obj) {
                $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
            });
        }); 
    }
</script>
 

@section('javascript') 
    <!-- Data Tables -->
    <script src="{{asset('assets/vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>

    <!-- Custom Data tables -->
    <script src="{{asset('assets/vendor/datatables/custom/custom-datatables.js')}}"></script>

    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script> 
    
@stop
@endsection