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

<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
        style="width:100%;font-size: 14px;font-weight: bold;">Drivers</h2>
</div>


<form method="POST" action="{{ route('Drivers.store')}}">
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
                                <select name="warehouseId" placeholder="Select ..." class="form-control" required>

                                    <?php
                                    if(count($warehouse)>1)
                                    echo"<option></option>";
                                    ?>

                                    @foreach($warehouse as $warehousee)
                                        <option value="{{$warehousee->id}}">{{$warehousee->warehouseName}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <TH>fullName <font color="red">*</font></TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="fullName" required>
                            </td>
                        </tr>
                        <tr>
                            <TH>fullName_ar </TH>
                            <td><input type="text" class="form-control" name="fullName_ar"></td>
                        </tr>
                        <tr>
                            <TH>Mobile</TH>
                            <td><input type="text" class="form-control" name="mobileNumber"></td>
                        </tr>
                        <tr>
                            <TH>Mobile_Someone_Else </TH>
                            <td><input type="text" class="form-control" name="mobileNumber_someone_else"></td>
                        </tr>
                        <tr>
                            <TH>Nationality </TH>
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
                            <TH>Iqama </TH>
                            <td><input type="text" class="form-control" name="iqama"></td>
                        </tr>
                        <tr>
                            <TH>IqamaExpireyDate </TH>
                            <td><?php  $from = 0;$to = 90;$name = "iqamaExpireyDate"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                        <tr>
                            <TH>Email ID </TH>
                            <td><input type="text" class="form-control" name="email_id" ></td>
                        </tr>
                        <tr>
                            <TH>Job ID <font color="red">*</font></TH>

                            <td>
                                @if(!session('Session_DriversCarrefour')=='yes')
                                <input type="text" class="form-control" name="job_id" required>
                                @endif
                            </td>

                        </tr>

                        <tr>
                            <TH>DateOfbirth </TH>
                            <td><?php  $from = 99;$to = -12;$name = "dob"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top !important;">
                    <table class="table m-0 show_table">

                        <tr>
                            <TH>Status <font color="red">*</font></TH>
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
                            <TH>Termination_Reason</TH>
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
                            <TH>Interview_Date </TH>
                            <td><?php  $from = 0;$to = 90;$name = "interview_date"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                        <tr>
                            <TH>Start_Date </TH>
                            <td><?php  $from = 0;$to = 90;$name = "start_date"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>
                        </tr>
                        <tr>
                            <TH>licenseExpireyDate </TH>
                            <td><?php  $from = 0;$to = 90;$name = "licenseExpireyDate"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>

                        <tr>
                            <TH>PassportNo </TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="passportNo"></td>
                        </tr>
                        <tr>
                            <TH>passportExpireyDate </TH>
                            <td><?php  $from = 0;$to = 90;$name = "passportExpireyDate"; $Date = array('', '', '');include(app_path() . '/includes/Date.php');?></td>
                        </tr>


                        <tr>
                            <TH>STC AccountNumber </TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="accountNumber"></td>
                        </tr>

                        <tr>
                            <TH>STC Account Owner Iqama </TH>
                            <td><input type="text" class="form-control" style="width:200px;" name="account_owner_iqama"></td>
                        </tr>

                        <tr>
                            <TH>Driver Type </TH>
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
                            <TH>Under Sopnsorship</TH>
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
                            <TH>Ajeer</TH>
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
                            <TH>Bander Car</TH>
                            <td>
                                <select name="bander_car_id" id="bander_car_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($lkp_yes_no as $lkp_yes_noo)
                                        <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
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
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Add</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>

