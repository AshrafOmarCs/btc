<style>
    .show_table th {
        white-space: nowrap;
        border: none !important;
        margin: 0 !important;
    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
    }
</style>


<form method="POST" action="{{ route('Drivers.store')}}">
    @csrf
    <input type="hidden" name="type_id" value="{{$type_id}}">
    <div class="table-responsive" style="width:100%;padding:0px 10px">
        <table>
            <tr>
                <td style="vertical-align: top !important;">
                    <table class="table m-0 show_table" style="width:10px!important;">
                        <tr>
                            <TH>{{__('drivers.Company')}} <font color="red">*</font></TH>
                            <td>
                                <select name="companyId" class="form-control" id="filtercompanyId" onchange="WarehouseName(1)" required>
                                    <option value="">Select company</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->companyName}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.WarehouseName')}} <font color="red">*</font></TH>
                            <td>
                                <select id="filterwarehouseId" name="warehouseId" placeholder="Select ..." class="form-control" required>
                                    <option value="">Select warehouse</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.fullName')}} <font color="red">*</font></TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="fullName" required>
                            </td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.fullName_ar')}} </TH>
                            <td><input type="text" class="form-control" name="fullName_ar"></td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.ActualName')}} </TH>
                            <td><input type="text" class="form-control" name="actualName"></td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.Mobile')}}</TH>
                            <td><input type="text" class="form-control" name="mobileNumber"></td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.Mobile_Someone_Else')}} </TH>
                            <td><input type="text" class="form-control" name="mobileNumber_someone_else"></td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.Nationality')}} </TH>
                            <td>
                                <select name="nationality_id" placeholder="Select ..." class="form-control">
                                    <option value=""></option>
                                    @foreach($lkp_country as $lkp_countryy)
                                        <option value="{{$lkp_countryy->id}}">{{$lkp_countryy->country_en}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.Iqama')}} </TH>
                            <td><input type="text" class="form-control" name="iqama"></td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.IqamaExpireyDate')}} </TH>
                            <td><?php  $from = 0;$to = 90;$name = "iqamaExpireyDate"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.EmailID')}} </TH>
                            <td><input type="text" class="form-control" name="email_id" ></td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.JobId')}} <font color="red">*</font></TH>

                            <td>
                                @if(!session('Session_DriversCarrefour')=='yes')
                                <input type="text" class="form-control" name="job_id" required>
                                @endif
                            </td>

                        </tr>

                        <tr>
                            <TH>{{__('drivers.DateOfbirth')}} </TH>
                            <td><?php  $from = 99;$to = -12;$name = "dob"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top !important;">
                    <table class="table m-0 show_table">

                        <tr>
                            <TH>{{__('drivers.Status')}} <font color="red">*</font></TH>
                            <td>
                                <select name="status_id" id="status_id" onchange="status()" class="form-control"
                                        required>

                                    @foreach($lkp_driver_status as $lkp_driver_statuss)
                                        <option
                                            value="{{$lkp_driver_statuss->id}}">{{$lkp_driver_statuss->driver_status_en}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr id="Termination_Reason" style="display:none;">
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
                        </tr>
                        <tr>
                            <TH>{{__('drivers.Interview_Date')}} </TH>
                            <td><?php  $from = 0;$to = 90;$name = "interview_date"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.Start_Date')}} </TH>
                            <td><?php  $from = 0;$to = 90;$name = "start_date"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.licenseExpireyDate')}} </TH>
                            <td><?php  $from = 0;$to = 90;$name = "licenseExpireyDate"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>

                        <tr>
                            <TH>{{__('drivers.PassportNo')}} </TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="passportNo"></td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.passportExpireyDate')}} </TH>
                            <td><?php  $from = 0;$to = 90;$name = "passportExpireyDate"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.STCAccountNumber')}} </TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="accountNumber"></td>
                        </tr>

                        <tr>
                            <TH>{{__('drivers.STCAccountOwnerIqama')}} </TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="account_owner_iqama"></td>
                        </tr>

                        <tr>
                            <TH>{{__('drivers.DriverType')}} </TH>
                            <td>
                                <select name="driver_type_id" id="driver_type_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($lkp_driver_type as $lkp_driver_typee)
                                        <option
                                            value="{{$lkp_driver_typee->id}}">{{$lkp_driver_typee->driver_type}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.UnderSopnsorship')}}</TH>
                            <td>
                                <select name="under_sopnsorship_id" id="under_sopnsorship_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($lkp_yes_no as $lkp_yes_noo)
                                        <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.Ajeer')}}</TH>
                            <td>
                                <select name="ajeer_id" id="ajeer_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($lkp_yes_no as $lkp_yes_noo)
                                        <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.BanderCar')}}</TH>
                            <td>
                                <select name="bander_car_id" id="bander_car_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($lkp_yes_no as $lkp_yes_noo)
                                        <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.PlateNumber')}}</TH>
                            <td>
                               <input type="txet" name="car_plateNumber" class="form-control" style="width:200px;">
                            </td>
                        </tr>
                        <tr>
                            <TH>{{__('drivers.Vehicle')}}</TH>
                            <td>
                                <select name="vehicle_id" id="vehicle_id_create" class="form-control" style="width:200px;">
                                    <option value="">Select Vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{$vehicle->id}}">{{$vehicle->plate}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="w3-row">
        <button type="button" class="btn btn-success" type="submit">{{__('drivers.Add')}}</button>
    </div>
</form>
