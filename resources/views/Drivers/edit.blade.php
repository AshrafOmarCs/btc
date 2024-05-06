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

<table style=" width:100%;margin-top: 5px;margin-left: 20px;">
    <tr>
        <td style="width:100%;font-size: 14px;font-weight: bold;">Drivers</td>
    </tr>
</table>

@include('pages.messages2')
@php 
 


@endphp
<form id="contact_form" method="POST" onsubmit="return validateForm()"
      action="{{ route('Drivers.update',$Drivers->id)}}">
    {{method_field("PATCH")}}
    @csrf
    <input type="hidden" name="type_id" value="{{$type_id}}">
    <div class="table-responsive" style="width:100%;padding:0px 10px">
        <table>

            <tr>
                <td style="vertical-align: top !important;">
                    <table class="table m-0 show_table" style="width:10px!important;">
                        <tr>
                            <TH>WarehouseName <font color="red">*</font></TH>
                            <td>
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
                            </td>
                        </tr>
                        @if(Auth::user()->user_type_id==1)
                            <tr>
                                <TH>ops_name</TH>
                                <td><b><font color="red">{{$Drivers->ops_name}}</font></b></td>
                            </tr>
                        @endif
                        <tr>
                            <TH>fullName <font color="red">*</font></TH>
                            <td>
                                @if(Auth::user()->user_type_id==1||session('Session_DriversCarrefour')=='yes')
                                    <input type="text" class="form-control" style="width:200px;" name="fullName"
                                           value="{{$Drivers->fullName}}" required>
                                @else
                                    <b><font color="red">{{$Drivers->fullName}}</font></b>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <TH>fullName_ar</TH>
                            <td><input type="text" class="form-control" name="fullName_ar"
                                       value="{{$Drivers->fullName_ar}}"></td>
                        </tr>
                        <tr>
                            <TH>Mobile</TH>
                            <td><input type="text" class="form-control" name="mobileNumber"
                                       value="{{$Drivers->mobileNumber}}"></td>
                        </tr>
                        <tr>
                            <TH>Mobile_Someone_Else</TH>
                            <td><input type="text" class="form-control" name="mobileNumber_someone_else"
                                       value="{{$Drivers->mobileNumber_someone_else}}"></td>
                        </tr>
                        <tr>
                            <TH>Nationality</TH>
                            <td>
                                <select name="nationality_id" placeholder="Select ..." class="form-control">
                                    <option value=""></option>

                                    @foreach($lkp_country as $lkp_countryy)
                                        <option value="{{$lkp_countryy->id}}"
                                                @if ($Drivers->nationality_id==$lkp_countryy->id){{"  selected " }}:{{""}} @endif>{{$lkp_countryy->country_en}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>Iqama</TH>
                            <td><input type="text" class="form-control" name="iqama" value="{{$Drivers->iqama}}"></td>
                        </tr>
                        <tr>
                            <TH>IqamaExpireyDate</TH>
                            <td><?php  $from = 0;$to = 90;$name = "iqamaExpireyDate"; $Date = explode("-", $Drivers->iqamaExpireyDate);include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                        <tr>
                            <TH>Email ID</TH>
                            <td><input type="text" class="form-control" name="email_id" value="{{$Drivers->email_id}}"
                                ></td>
                        </tr>
                        <tr>
                            <TH>Job ID <font color="red">*</font></TH>
                            <td>
                                @if(Auth::user()->user_type_id==1)
                                    <input type="text" class="form-control" name="job_id" value="{{$Drivers->job_id}}"
                                           required>
                                @else
                                    <b><font color="red">{{$Drivers->job_id}}</font></b>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <TH>DateOfbirth</TH>
                            <td><?php  $from = 99;$to = -12;$name = "dob"; $Date = explode("-", $Drivers->dob);include(app_path() . '/includes/Date.php');?></td>
                        </tr>

                    </table>
                </td>
                <td style="vertical-align: top !important;">
                    <table class="table m-0 show_table">

                        <tr>
                            <TH>Status <font color="red">*</font></TH>
                            <td>
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
                            </td>
                        </tr>
                        <tr id="Termination_Reason" <?php if ($Drivers->status_id <> "3") echo 'style="display:none;"';?> >
                            <TH>Termination_Reason</TH>
                            <td>
                                <select name="termination_reason_id" id="termination_reason_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($lkp_termination_reasons as $lkp_termination_reasonss)
                                        <option value="{{$lkp_termination_reasonss->id}}"
                                                @if ($Drivers->termination_reason_id==$lkp_termination_reasonss->id){{"  selected " }}:{{""}} @endif>{{$lkp_termination_reasonss->reason_en}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>Interview_Date</TH>
                            <td><?php  $from = 0;$to = 90;$name = "interview_date";  $Date = explode("-", $Drivers->interview_date);include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                        <tr>
                            <TH>Start_Date</TH>
                            <td><?php  $from = 0;$to = 90;$name = "start_date";  $Date = explode("-", $Drivers->start_date);include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                        </tr>
                        <tr>
                            <TH>Driving licenseExpireyDate</TH>
                            <td><?php  $from = 0;$to = 90;$name = "licenseExpireyDate";  $Date = explode("-", $Drivers->licenseExpireyDate);include(app_path() . '/includes/Date.php');?></td>
                        </tr>

                        <tr>
                            <TH>PassportNo</TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="passportNo"
                                       value="{{$Drivers->passportNo}}"></td>
                        </tr>
                        <tr>
                            <TH>passportExpireyDate</TH>
                            <td><?php  $from = 0;$to = 90;$name = "passportExpireyDate"; $Date = explode("-", $Drivers->passportExpireyDate);include(app_path() . '/includes/Date.php');?></td>
                        </tr>


                        <tr>
                            <TH>STC AccountNumber <font color="red">*</font></TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="accountNumber"
                                       id="accountNumber"
                                       value="{{$Drivers->accountNumber}}"></td>
                        </tr>

                        <tr>
                            <TH>STC Account Owner Iqama <font color="red">*</font></TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="account_owner_iqama"
                                       id="account_owner_iqama"
                                       value="{{$Drivers->account_owner_iqama}}"></td>
                        </tr>

                        <tr>
                            <TH>Driver Type <font color="red">*</font></TH>
                            <td>
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
                                    <!-- <b><font color="red">{{$Drivers->driver_type}}</font></b> -->
                                    <select name="driver_type_id" id="driver_type_id" class="form-control">
                                        <option value=""></option>
                                        @foreach($lkp_driver_type as $lkp_driver_typee)
                                            <option
                                                value="{{$lkp_driver_typee->id}}"
                                                @if ($Drivers->driver_type_id==$lkp_driver_typee->id){{"  selected " }}:{{""}} @endif>{{$lkp_driver_typee->driver_type}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <TH>Under Bander Sopnsorship</TH>
                            <td>
                                <select name="under_sopnsorship_id" id="under_sopnsorship_id" class="form-control"
                                        style="width:200px;">
                                    <option value=""></option>
                                    @foreach($lkp_yes_no as $lkp_yes_noo)
                                        <option value="{{$lkp_yes_noo->id}}"
                                                @if ($Drivers->under_sopnsorship_id==$lkp_yes_noo->id){{"  selected " }}:{{""}} @endif>{{$lkp_yes_noo->yes_no}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>Ajeer</TH>
                            <td>
                                <select name="ajeer_id" id="ajeer_id" class="form-control" style="width:200px;">
                                    <option value=""></option>
                                    @foreach($lkp_yes_no as $lkp_yes_noo)
                                        <option value="{{$lkp_yes_noo->id}}"
                                                @if ($Drivers->ajeer_id==$lkp_yes_noo->id){{"  selected " }}:{{""}} @endif>{{$lkp_yes_noo->yes_no}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>Bander Car</TH>
                            <td>
                                <select name="bander_car_id" id="bander_car_id" class="form-control" style="width:200px;">
                                    <option value=""></option>
                                    @foreach($lkp_yes_no as $lkp_yes_noo)
                                        <option value="{{$lkp_yes_noo->id}}"
                                                @if ($Drivers->bander_car_id==$lkp_yes_noo->id){{"  selected " }}:{{""}} @endif>{{$lkp_yes_noo->yes_no}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <TH>Fuel Per days</TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="fuel_per_day"
                                       id="fuel_per_day"
                                       value="{{$Drivers->fuel_per_day}}"></td>
                        </tr>
                        <tr>
                            <TH>Basic Salary</TH>
                            <td><input type="text" class="form-control" placeholder="Basic Salary" style="width:200px;" name="basic_salary"
                                       id="basic_salary"
                                       value="{{$Drivers->basic_salary}}"></td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" id="submitForm" type="submit">Update</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>

