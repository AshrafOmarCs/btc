@include('pages.messages2')

    <input type="hidden" name="type_id" value="{{$type_id}}">
    <div class="row">
        @if($type_id == 1)
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.Company')}} <font color="red">*</font></label>
                            <select name="companyId" class="form-control" id="filtercompanyId" onchange="WarehouseName(1)" required>
                                <option value="">Select company</option>
                                @foreach($companies as $company)
                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.WarehouseName')}} <font color="red">*</font></label>
                            <select id="filterwarehouseId" name="warehouseId" placeholder="Select ..." class="form-control" required>
                                <option value="">Select warehouse</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.City')}} <font color="red">*</font></label>
                            <select name="companyId" class="form-control" id="filtercompanyId" required>
                                <option value="">Select City</option>
                                @foreach($warehouse as $warehousee)
                                    <option value="{{$warehousee->id}}"> {{$warehousee->warehouseName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <label class="form-label">{{__('drivers.fullName')}} <font color="red">*</font></label>
                        <input type="text" class="form-control" name="fullName" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <label class="form-label">{{__('drivers.fullName_ar')}}</label>
                        <input type="text" class="form-control" name="fullName_ar">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <label class="form-label">{{__('drivers.ActualName')}}</label>
                        <input type="text" class="form-control" name="actualName">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <label class="form-label">{{__('drivers.Mobile')}}</label>
                        <input type="text" class="form-control" name="mobileNumber">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <label class="form-label">{{__('drivers.Mobile_Someone_Else')}}</label>
                        <input type="text" class="form-control" name="mobileNumber_someone_else">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <label class="form-label">{{__('drivers.Nationality')}}</label>
                        <select name="nationality_id" placeholder="Select ..." class="form-control">
                            <option value=""></option>
                            @foreach($lkp_country as $lkp_countryy)
                                <option value="{{$lkp_countryy->id}}">{{$lkp_countryy->country_en}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <label class="form-label">{{__('drivers.Iqama')}} <font color="red">*</font></label>
                        <input type="text" class="form-control" name="iqama">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <!-- Card start -->
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.IqamaExpireyDate')}}</div>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar4"></i>
                            </span>
                            <input type="date" name="iqamaExpireyDate" class="form-control datepicker">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card end -->
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <label class="form-label">{{__('drivers.EmailID')}} </label>
                        <input type="text" class="form-control" name="email_id">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <label class="form-label">{{__('drivers.JobId')}} <font color="red">*</font></label>
                        @if(!session('Session_DriversCarrefour')=='yes')
                            <input type="text" class="form-control" name="job_id">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <!-- Card start -->
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.DateOfbirth')}}</div>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar4"></i>
                            </span>
                            <input type="date" name="dob" class="form-control datepicker">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card end -->
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <label class="form-label">{{__('drivers.Status')}} <font color="red">*</font></label>
                        <select name="status_id" id="status_id" onchange="status()" class="form-control"
                                        required>
                            @foreach($lkp_driver_status as $lkp_driver_statuss)
                                <option
                                    value="{{$lkp_driver_statuss->id}}">{{$lkp_driver_statuss->driver_status_en}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <!-- Card start -->
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.Interview_Date')}}</div>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar4"></i>
                            </span>
                            <input type="date" name="interview_date" class="form-control datepicker">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card end -->
        </div>
        <div class="col-sm-4 col-12">
            <!-- Card start -->
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.Start_Date')}}</div>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar4"></i>
                            </span>
                            <input type="date" name="start_date" class="form-control datepicker">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card end -->
        </div>
        <div class="col-sm-4 col-12">
            <!-- Card start -->
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.DrivinglicenseExpireyDate')}}</div>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar4"></i>
                            </span>
                            <input type="date" name="licenseExpireyDate" class="form-control datepicker">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card end -->
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <label class="form-label">{{__('drivers.PassportNo')}} </label>
                            <input type="text" class="form-control" name="passportNo">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <!-- Card start -->
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.passportExpireyDate')}}</div>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar4"></i>
                            </span>
                            <input type="date" name="passportExpireyDate" class="form-control datepicker">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card end -->
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.STCAccountNumber')}} <font color="red">*</font></div>
                        <div class="input-group">
                            <input type="text" class="form-control" name="accountNumber">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.STCAccountOwnerIqama')}} <font color="red">*</font></div>
                        <div class="input-group">
                            <input type="text" class="form-control" name="account_owner_iqama">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.DriverType')}}</div>
                        <div class="input-group">
                            <select name="driver_type_id" id="driver_type_id" class="form-control">
                                <option value=""></option>
                                @foreach($lkp_driver_type as $lkp_driver_typee)
                                    <option
                                        value="{{$lkp_driver_typee->id}}">{{$lkp_driver_typee->driver_type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.UnderSopnsorship')}}</div>
                        <div class="input-group">
                            <select name="under_sopnsorship_id" id="under_sopnsorship_id" class="form-control">
                                <option value=""></option>
                                @foreach($lkp_yes_no as $lkp_yes_noo)
                                    <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.Ajeer')}}</div>
                        <div class="input-group">
                            <select name="ajeer_id" id="ajeer_id" class="form-control">
                                <option value=""></option>
                                @foreach($lkp_yes_no as $lkp_yes_noo)
                                    <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.BanderCar')}}</div>
                        <div class="input-group">
                            <select name="bander_car_id" id="bander_car_id" class="form-control">
                                <option value=""></option>
                                @foreach($lkp_yes_no as $lkp_yes_noo)
                                    <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.PlateNumber')}}</div>
                        <div class="input-group">
                            <input type="txet" name="car_plateNumber" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-0">
                        <div class="form-label">{{__('drivers.Vehicle')}}</div>
                        <div class="input-group">
                            <select name="vehicle_id" id="vehicle_id_create" class="form-control">
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle->id}}">{{$vehicle->plate}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{__('drivers.Add')}}</button>
    </div>
        <span id="Termination_Reason" style="display:none;">
            <TH>{{__('drivers.Termination_Reason')}}</TH>
            <td>
                <select name="termination_reason_id" id="termination_reason_id" class="form-control">
                    <option value=""></option>
                    @foreach($lkp_termination_reasons as $lkp_termination_reasonss)
                        <option
                            value="{{$lkp_termination_reasonss->id}}">{{$lkp_termination_reasonss->reason_en}}</option>
                    @endforeach
                </select>
            </td>
        </span>
