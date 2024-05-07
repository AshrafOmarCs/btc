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
											<table id="customer_data" class="table custom-table">
												<thead>
                                                    <TH>{{__('drivers.Company')}}</TH>
                                                    <TH style="display:none;">{{__('drivers.City')}}</TH>
                                                    <TH>{{__('drivers.Warehouse')}}</TH>
                                                    <TH>{{__('drivers.Type')}}</TH>
                                                    <TH>{{__('drivers.fullName')}}</TH>
                                                    <TH>{{__('drivers.Mobile')}}</TH>
                                                    <TH>{{__('drivers.Iqama')}}</TH>

                                                    <TH>{{__('drivers.JobId')}}</TH>
                                                    <TH>{{__('drivers.Status')}}</TH>
                                                    @if(Auth::user()->user_type_id==1)
                                                        <TH>{{__('drivers.OnHold')}}</TH>
                                                        <TH>{{__('drivers.BanderCar')}}</TH>
                                                        <TH>{{__('drivers.PBalance')}}</TH>
                                                        <TH>{{__('drivers.CBalance')}}</TH>
                                                        <TH>{{__('drivers.Updated_At')}}</TH>
                                                    @endif
                                                    <TH>Action</TH>


                                                    <TH style="display:none;">{{__('drivers.AccountNumber')}}</TH>
                                                    <TH style="display:none;">{{__('drivers.Account_Owner_Iqama')}}</TH>


                                                </thead>
                                                <tbody>
                                                        {{-- <tr>
                                                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                                                            <td><img src="" class="flag-img-lg" alt="Best Admin Dashboards">
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
                                                        </tr> --}}
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
        $(document).ready(function () {
            fill_datatable();

            function fill_datatable(filter_screenId = '', filter_companyId = '', filter_warehouseId = '', filter_driver_type_id = '', filter_fullName = '', filter_mobileNumber = '', filter_iqama = '', filter_email_id = '', filter_job_id = '', filter_status_id = '', filter_account_owner_iqama = '', filter_accountNumber = '', filter_created_at = '', filter_updated_at = '', filter_bander_car_id = '', filter_Image_Identity = '', filter_Image_Passport = '', filter_Image_DrivingLicence = '', filter_Image_VehiclesRegistration = '', filter_Image_JobContract = '', filter_Image_PromissoryNote = '', filter_vehicleId = '') {
                var dataTable = $('#customer_data').DataTable({
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
                    serverSide: true,
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function () {
                        $('[data-toggle="tooltip"]').tooltip();
                        $(function () {
                            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                                checkboxClass: 'icheckbox_flat-red',
                                radioClass: 'iradio_flat-red'
                            });


                            $('#select-all').on('ifChecked ifUnchecked', function (event) {
                                if (document.getElementById('select-all').checked) {

                                    $('.flat-red').iCheck('check')
                                } else
                                    $('.flat-red').iCheck('uncheck');
                            });
                        });
                    },
                    ajax: {
                        url: "{{ route('Drivers.index') }}",
                        data: {
                            filter_screenId: 'Drivers',
                            filter_vehicleId: filter_vehicleId,
                            filter_companyId: filter_companyId,
                            filter_warehouseId: filter_warehouseId,
                            filter_fullName: filter_fullName,
                            filter_mobileNumber: filter_mobileNumber,
                            filter_iqama: filter_iqama,
                            filter_email_id: filter_email_id,
                            filter_job_id: filter_job_id,
                            filter_status_id: filter_status_id,
                            filter_account_owner_iqama: filter_account_owner_iqama,
                            filter_accountNumber: filter_accountNumber,
                            filter_driver_type_id, filter_driver_type_id,
                            filter_created_at: filter_created_at,
                            filter_updated_at: filter_updated_at,
                            filter_bander_car_id: filter_bander_car_id,
                            filter_Image_Identity: filter_Image_Identity,
                            filter_Image_Passport: filter_Image_Passport,
                            filter_Image_DrivingLicence: filter_Image_DrivingLicence,
                            filter_Image_VehiclesRegistration: filter_Image_VehiclesRegistration,
                            filter_Image_JobContract: filter_Image_JobContract,
                            filter_Image_PromissoryNote: filter_Image_PromissoryNote,
                        }
                    },

                    columns: [
                        {
                            data: 'companyName',
                            name: 'lkp_company.companyName',
                            //visible:false
                        },
                        {
                            visible: false,
                            data: 'name_en',
                            name: 'lkp_city.name_en',
                        },
                        {
                            data: 'warehouseName',
                            name: 'warehouse.warehouseName',
                            //visible:false
                        },
                        {
                            data: 'driver_type',
                            name: 'lkp_driver_type.driver_type',
                        },
                        // {
                            // data: 'vehicle',
                            // name: 'vehicle',
                        // },
                        {
                            //className: "dt-nowrap",
                            data: 'fullName',
                            name: 'fullName'
                        },

                        {
                            data: 'mobileNumber',
                            name: 'mobileNumber'
                        },
                        {
                            data: 'iqama',
                            name: 'iqama'
                        },

                        {
                            data: 'job_id',
                            name: 'job_id'
                        },
                        {
                            //data: 'driver_status_en',
                            name: 'lkp_driver_status.driver_status_en',
                            render: function (data, type, row, meta) {
                                if (row.status_id == "1") {
                                    return '<span class="label label-success">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "2") {
                                    return '<span class="label label-warning">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "3") {
                                    return '<span class="label label-danger">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "4") {
                                    return '<span class="label label-default">' + row.driver_status_en + '</span>';
                                } else if (row.status_id == "5") {
                                    return '<span class="label label-danger">' + row.driver_status_en + '</span>';
                                }
                            }
                        },
                            @if(Auth::user()->user_type_id==1)
                        {
                            "orderable": false,
                            "className": "text-center",
                            "render": function (data, type, row, meta) {
                                var i = '';
                                i = '<input class="flat-red" name="ID_' + meta.row + '" type="checkbox" value="' + row.id + '"';
                                if (row.status_id == "5")
                                    i = i + ' checked ';
                                i = i + '>';
                                if (row.status_id == "5")
                                    i = i + '&nbsp;' + row.onhold_date;
                                return i;


                            }
                        },
                        {
                            //data: 'driver_status_en',
                            name: 'bander_car.yes_no',
                            render: function (data, type, row, meta) {
                                if (row.bander_car == "Yes") {
                                    return '<span class="label label-success">' + row.bander_car + '</span>';

                                } else if (row.bander_car == "No") {
                                    return '<span class="label label-danger">' + row.bander_car + '</span>';
                                }
                                else return '';
                            }
                        },
                        {
                            data: 'per_priod',
                            name: 'balance.per_priod'
                        },
                        {
                            data: 'cur_priod',
                            name: 'balance.cur_priod'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                            @endif
                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            //"data": 'id',
                            "render": function (data, type, row, meta) {
                                return '<input type="hidden" id="IDs_all_' + meta.row + '" name="IDs_all_' + meta.row + '" value="' + row.id + '">' +
                                    '<a id=' + row.id + ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>' +
                                    @if(Auth::user()->user_type_id==1)
                                        '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>' +
                                    @endif
                                        '&nbsp;<a id=' + row.id + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement"> <i class="fa fa-bars"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="Attachment" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue Attachment"> <i class="fa fa-paperclip"></i> </a>' +
                                    @if(Auth::user()->user_type_id==1)
                                        '&nbsp;<a id=' + row.id + ' data-original-title="Clearance" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-black vd_black Clearance"> C </a>' +
                                    @endif
                                        '&nbsp;<button id=' + row.id + ' type="button" class="btn btn-primary btn-xs resetpass">Reset Pass</button>'


                            }
                        },
                        {
                            visible: false,
                            data: 'accountNumber',
                            name: 'accountNumber',
                        },
                        {
                            visible: false,
                            data: 'account_owner_iqama',
                            name: 'account_owner_iqama',
                        },


                    ]
                });


            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/Drivers')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.edit', function (e) {
                //e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/Drivers')}}" + "/" + id + "/edit/1",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;
                        $('#vehicle_id').select2({
                            dropdownParent: $('#edit_modal')
                        });
                    }
                });
            });
            $('#customer_data tbody').on('click', '.privilage', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                alert(id);
            });

            $('#customer_data tbody').on('click', '.resetpass', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/ResetPass')}}" + "/" + id,
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

            $('#customer_data tbody').on('click', '.Attachment', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                myWindow1 = window.open("{{URL("Attachment")}}" + "/" + id, "mywin",
                    "height=900,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
                myWindow1.focus();

            });

            $('#customer_data tbody').on('click', '.Clearance', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                myWindow1 = window.open("{{URL("ClearancePrint")}}" + "/" + id + "/0", "mywin",
                    "height=900,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
                myWindow1.focus();
            });

            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/Drivers')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';
                //document.getElementById('response').innerHTML=data;


            });

            $('#filter').click(function () {

                if ($('#filter_vehicleId').val() != '' || $('#filter_companyId').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_driver_type_id').val() != '' || $('#filter_fullName').val() != '' || $('#filter_mobileNumber').val() != '' || $('#filter_iqama').val() != '' || $('#filter_email_id').val() != '' || $('#filter_job_id').val() != '' || $('#filter_status_id').val() != '' || $('#filter_account_owner_iqama').val() != '' || $('#filter_accountNumber').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '' || $('#filter_bander_car_id').val() != ''|| $('#filter_Image_Identity').val() != '' || $('#filter_Image_Passport').val() != '' || $('#filter_Image_DrivingLicence').val() != '' || $('#filter_Image_VehiclesRegistration').val() != '' || $('#filter_Image_JobContract').val() != '' || $('#filter_Image_PromissoryNote').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable('Drivers', $('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_driver_type_id').val(), $('#filter_fullName').val(), $('#filter_mobileNumber').val(), $('#filter_iqama').val(), $('#filter_email_id').val(), $('#filter_job_id').val(), $('#filter_status_id').val(), $('#filter_account_owner_iqama').val(), $('#filter_accountNumber').val(), $('#filter_created_at').val(), $('#filter_updated_at').val(), $('#filter_bander_car_id').val(), $('#filter_Image_Identity').val(), $('#filter_Image_Passport').val(), $('#filter_Image_DrivingLicence').val(), $('#filter_Image_VehiclesRegistration').val(), $('#filter_Image_JobContract').val(), $('#filter_Image_PromissoryNote').val(), $('#filter_vehicleId').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {
                $('#filter_vehicleId').val('').trigger('change');
                $('#filter_companyId').val('');
                $('#filter_warehouseId').val('');
                $('#filter_fullName').val('');
                $('#filter_mobileNumber').val('');
                $('#filter_iqama').val('');
                $('#filter_email_id').val('');
                $('#filter_job_id').val('');
                $('#filter_status_id').val('');
                $('#filter_account_owner_iqama').val('');
                $('#filter_accountNumber').val('');
                $('#filter_driver_type_id').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');
                $('#filter_bander_car_id').val('');
                $('#filter_Image_Identity').val('');
                $('#filter_Image_Passport').val('');
                $('#filter_Image_DrivingLicence').val('');
                $('#filter_Image_VehiclesRegistration').val('');
                $('#filter_Image_JobContract').val('');
                $('#filter_Image_PromissoryNote').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });


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
