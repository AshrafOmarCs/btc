

@include('pages.messages2')

<form id="contact_form" method="POST" onsubmit="return validateForm()"
        action="{{ route('Drivers.update',$Drivers->id)}}">
        {{method_field("PATCH")}}
        @csrf
    <div class="modal-body">
        <input type="hidden" name="type_id" value="{{$type_id}}">
        <div class="row">
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.WarehouseName')}} <font color="red">*</font></label>
                            @if(Auth::user()->user_type_id==1)
                                <select name="warehouseId" placeholder="Select ..." class="form-control" required>

                                    @foreach($warehouse as $warehousee)
                                        <option value="{{$warehousee->id}}"
                                                @if ($Drivers->warehouseId==$warehousee->id){{"  selected " }}:{{""}} @endif>{{$warehousee->warehouseName}}</option>
                                    @endforeach
                                </select>
                            @else
                                <b><font color="red">{{$Drivers->companyName}} / {{$Drivers->warehouseName}}</font></b>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->user_type_id==1)
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.ops_name')}} <font color="red">*</font></label>
                                <b><font color="red">{{$Drivers->ops_name}}</font></b>
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
                            @if(Auth::user()->user_type_id==1||session('Session_DriversCarrefour')=='yes')
                                <input type="text" class="form-control" name="fullName"
                                    value="{{$Drivers->fullName}}" required>
                            @else
                                @if(Auth::user()->id==90)
                                    <input type="text" class="form-control" name="fullName" value="{{$Drivers->fullName}}" required>
                                @else
                                    <input type="hidden" name="fullName" value="{{$Drivers->fullName}}" required>
                                    <b><font color="red">{{$Drivers->fullName}}</font></b>
                                @endif

                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.fullName_ar')}}</label>
                            <input type="text" class="form-control" name="fullName_ar"
                            value="{{$Drivers->fullName_ar}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.ActualName')}}</label>
                            <input type="text" class="form-control" name="actualName"
                                value="{{$Drivers->actualName}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.ActualName')}}</label>
                            <input type="text" class="form-control" name="actualName"
                                value="{{$Drivers->actualName}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.Mobile')}}</label>
                            <input type="text" class="form-control" name="mobileNumber"
                            @if($Drivers->mobileNumber != '' AND (Auth::user()->user_type_id == 2 OR Auth::user()->user_type_id == 3)) readonly @endif
                            value="{{$Drivers->mobileNumber}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.Mobile')}}</label>
                            <input type="text" class="form-control" name="mobileNumber"
                            @if($Drivers->mobileNumber != '' AND (Auth::user()->user_type_id == 2 OR Auth::user()->user_type_id == 3)) readonly @endif
                            value="{{$Drivers->mobileNumber}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.Mobile_Someone_Else')}}</label>
                            <input type="text" class="form-control" name="mobileNumber_someone_else"
                                        value="{{$Drivers->mobileNumber_someone_else}}">
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
                                    <option value="{{$lkp_countryy->id}}"
                                            @if ($Drivers->nationality_id==$lkp_countryy->id){{"  selected " }}:{{""}} @endif>{{$lkp_countryy->country_en}}</option>
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
                            <label class="form-label">{{__('drivers.Nationality')}}</label>
                            <select name="nationality_id" placeholder="Select ..." class="form-control">
                                <option value=""></option>

                                @foreach($lkp_country as $lkp_countryy)
                                    <option value="{{$lkp_countryy->id}}"
                                            @if ($Drivers->nationality_id==$lkp_countryy->id){{"  selected " }}:{{""}} @endif>{{$lkp_countryy->country_en}}</option>
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
                            <label class="form-label">{{__('drivers.Iqama')}}</label>
                            <input type="text" class="form-control" @if($Drivers->iqama != '' AND (Auth::user()->user_type_id == 2 OR Auth::user()->user_type_id == 3)) readonly @endif name="iqama" value="{{$Drivers->iqama}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.IqamaExpireyDate')}}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar4"></i>
                                </span>
                                <input type="date" value="{{$Drivers->iqamaExpireyDate}}" name="iqamaExpireyDate" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.EmailID')}}</label>
                            <input type="text" class="form-control" name="email_id" value="{{$Drivers->email_id}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.JobId')}}</label>
                            @if(Auth::user()->user_type_id==1)
                                <input type="text" class="form-control" name="job_id" value="{{$Drivers->job_id}}"
                                    required>
                            @else
                                <b><font color="red">{{$Drivers->job_id}}</font></b>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.DateOfbirth')}}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar4"></i>
                                </span>
                                <input type="date" value="{{$Drivers->dob}}" name="dob" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.PlateNumber')}}</label>
                            <input type="txet" name="car_plateNumber" id="car_plateNumber" value="{{$Drivers->car_plateNumber}}" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.BanderCar')}}</label>
                            <select name="bander_car_id" id="bander_car_id" class="form-control" style="width:200px;">
                                <option value=""></option>
                                @foreach($lkp_yes_no as $lkp_yes_noo)
                                    <option value="{{$lkp_yes_noo->id}}"
                                            @if ($Drivers->bander_car_id==$lkp_yes_noo->id){{"  selected " }}:{{""}} @endif>{{$lkp_yes_noo->yes_no}}</option>
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
                            <label class="form-label">{{__('drivers.Status')}}</label>
                            @if(Auth::user()->user_type_id==1 || session('Session_DriversJahiz')=='yes'||session('Session_DriversCarrefour')=='yes'||session('Session_Drivers')=='yes')
                                <select name="status_id" id="status_id" onchange="status()" class="form-control"
                                        required>

                                    @foreach($lkp_driver_status as $lkp_driver_statuss)
                                        <option value="{{$lkp_driver_statuss->id}}"
                                                @if ($Drivers->status_id==$lkp_driver_statuss->id){{"  selected " }}:{{""}} @endif>{{$lkp_driver_statuss->driver_status_en}}</option>
                                    @endforeach
                                </select>
                            @else
                                <b><font color="red">{{$Drivers->driver_status_en}}</font></b>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.Interview_Date')}}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar4"></i>
                                </span>
                                <input type="date" value="{{$Drivers->interview_date}}" name="interview_date" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.Start_Date')}}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar4"></i>
                                </span>
                                <input type="date" value="{{$Drivers->start_date}}" name="start_date" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.DrivinglicenseExpireyDate')}}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar4"></i>
                                </span>
                                <input type="date" value="{{$Drivers->licenseExpireyDate}}" name="licenseExpireyDate" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.PassportNo')}}</label>
                            <input type="text" class="form-control" name="passportNo"
                                        value="{{$Drivers->passportNo}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.passportExpireyDate')}}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar4"></i>
                                </span>
                                <input type="date" value="{{$Drivers->passportExpireyDate}}" name="passportExpireyDate" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.STCAccountNumber')}} <font color="red">*</font></label>
                            <input type="text" class="form-control" style="width:200px;" name="accountNumber"
                                        id="accountNumber" value="{{$Drivers->accountNumber}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.STCAccountOwnerIqama')}} <font color="red">*</font></label>
                            <input type="text" class="form-control" style="width:200px;" name="account_owner_iqama" id="account_owner_iqama"
                                value="{{$Drivers->account_owner_iqama}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.DriverType')}} <font color="red">*</font></label>
                            @if(Auth::user()->user_type_id==1 || session('Session_DriversJahiz')=='yes')
                                <select name="driver_type_id" id="driver_type_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($lkp_driver_type as $lkp_driver_typee)
                                        <option
                                            value="{{$lkp_driver_typee->id}}"
                                            @if ($Drivers->driver_type_id==$lkp_driver_typee->id){{"  selected " }}:{{""}} @endif>{{$lkp_driver_typee->driver_type}}</option>
                                    @endforeach
                                </select>
                            @else
                                <!--<b><font color="red">{{$Drivers->driver_type}}</font></b>-->

                                <select name="driver_type_id" id="driver_type_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($lkp_driver_type as $lkp_driver_typee)
                                        <option
                                            value="{{$lkp_driver_typee->id}}"
                                            @if ($Drivers->driver_type_id==$lkp_driver_typee->id){{"  selected " }}:{{""}} @endif>{{$lkp_driver_typee->driver_type}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.UnderSopnsorship')}} <font color="red">*</font></label>
                            <select name="under_sopnsorship_id" id="under_sopnsorship_id" class="form-control">
                                <option value=""></option>
                                @foreach($lkp_yes_no as $lkp_yes_noo)
                                    <option value="{{$lkp_yes_noo->id}}"
                                            @if ($Drivers->under_sopnsorship_id==$lkp_yes_noo->id){{"  selected " }}:{{""}} @endif>{{$lkp_yes_noo->yes_no}}</option>
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
                            <label class="form-label">{{__('drivers.Ajeer')}} <font color="red">*</font></label>
                            <select name="ajeer_id" id="ajeer_id" class="form-control">
                                <option value=""></option>
                                @foreach($lkp_yes_no as $lkp_yes_noo)
                                    <option value="{{$lkp_yes_noo->id}}"
                                            @if ($Drivers->ajeer_id==$lkp_yes_noo->id){{"  selected " }}:{{""}} @endif>{{$lkp_yes_noo->yes_no}}</option>
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
                            <label class="form-label">{{__('drivers.FuelPerdays')}} <font color="red">*</font></label>
                            <input type="text" class="form-control" name="fuel_per_day"
                                        id="fuel_per_day"
                                        value="{{$Drivers->fuel_per_day}}" placeholder="Specify Daily Fauel Amount">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.BasicSalary')}} <font color="red">*</font></label>
                            <input type="text" class="form-control" placeholder="Basic Salary" style="width:200px;" name="basic_salary"
                                        id="basic_salary"
                                        value="{{$Drivers->basic_salary}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.Vehicle')}} <font color="red">*</font></label>
                            <select name="vehicle_id" id="vehicle_id" class="form-control" style="width:200px;" onchange="show_date(this.value)">
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle->id}}"
                                            @if ($Drivers->vehicle_id==$vehicle->id){{"  selected " }}:{{""}} @endif>{{$vehicle->plate}}</option>
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
                            <label class="form-label">{{__('drivers.Vehicle')}} <font color="red">*</font></label>
                            <select name="vehicle_id" id="vehicle_id" class="form-control" style="width:200px;" onchange="show_date(this.value)">
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle->id}}"
                                            @if ($Drivers->vehicle_id==$vehicle->id){{"  selected " }}:{{""}} @endif>{{$vehicle->plate}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12" style="display: {{$Drivers->vehicle_id == '' ? 'none' : ''}}" id="expiry_tr">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('drivers.VehicleExpiryDate')}}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar4"></i>
                                </span>
                                <input type="date" class="form-control" name="vehicle_expiry_date"
                                        id="vehicle_expiry_date"
                                        value="{{$Drivers->vehicle_expiry_date}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <span id="Termination_Reason" <?php if ($Drivers->status_id <> "3") echo 'style="display:none;"';?> >
            <TH>{{__('drivers.Termination_Reason')}}</TH>
            <td>
                <select name="termination_reason_id" id="termination_reason_id" class="form-control">
                    <option value=""></option>
                    @foreach($lkp_termination_reasons as $lkp_termination_reasonss)
                        <option value="{{$lkp_termination_reasonss->id}}"
                                @if ($Drivers->termination_reason_id==$lkp_termination_reasonss->id){{"  selected " }}:{{""}} @endif>{{$lkp_termination_reasonss->reason_en}}</option>
                    @endforeach
                </select>
            </td>
        </span>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Update</button>
    </div>
</form>

