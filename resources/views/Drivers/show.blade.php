<style>
    .show_table th {
        padding-left: 20px !important;
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
<div class="table-responsive" style="width:100%;padding:0px 0px">
    <table>
        <tr>
            <td style="vertical-align: top !important;">
                <table class="table m-0 show_table">
                    <tr>
                        <TH>WarehouseName</TH>
                        <td>{{$Drivers->warehouseName}}</td>
                    </tr>
                    <tr>
                        <TH>ops_name</TH>
                        <td><b>{{$Drivers->ops_name}}</b></td>
                    </tr>
                    <tr>
                        <TH>fullName</TH>
                        <td style="width:200px !important;">{{$Drivers->fullName}}</td>
                    </tr>
                    <tr>
                        <TH>fullName_ar</TH>
                        <td>{{$Drivers->fullName_ar}}</td>
                    </tr>
                    <tr>
                        <TH>Mobile</TH>
                        <td>{{$Drivers->mobileNumber}}</td>
                    </tr>
                    <tr>
                        <TH>Mobile_Someone_Else</TH>
                        <td>{{$Drivers->mobileNumber_someone_else}}</td>
                    </tr>
                    <tr>
                        <TH>Nationality</TH>
                        <td>{{$Drivers->country_en}}</td>
                    </tr>
                    <tr>
                        <TH>Iqama</TH>
                        <td>{{$Drivers->iqama}}</td>
                    </tr>
                    <tr>
                        <TH>IqamaExpireyDate</TH>
                        <td>{{$Drivers->iqamaExpireyDate}}</td>
                    </tr>
                    <tr>
                        <TH>Email ID</TH>
                        <td>{{$Drivers->email_id}}</td>
                    </tr>
                    <tr>
                        <TH>Job ID</TH>
                        <td>{{$Drivers->job_id}}</td>
                    </tr>
                    <tr>
                        <TH>DateOfbirth</TH>
                        <td>{{$Drivers->dob}}</td>
                    </tr>
                    <tr>
                        <TH>Status</TH>
                        <td>
                            <?php
                            if ($Drivers->status_id == "1")
                                echo '<span class="label label-success">' . $Drivers->driver_status_en . '</span>';
                            elseif ($Drivers->status_id == "2")
                                echo '<span class="label label-warning">' . $Drivers->driver_status_en . '</span>';
                            elseif ($Drivers->status_id == "3")
                                echo '<span class="label label-danger">' . $Drivers->driver_status_en . '</span>';
                            elseif ($Drivers->status_id == "4")
                                echo '<span class="label label-default">' . $Drivers->driver_status_en . '</span>';
                            ?>
                        </td>
                    </tr>
                    <tr id="Termination_Reason" <?php if ($Drivers->status_id <> "3") echo 'style="display:none;"';?> >
                        <TH>Termination_Reason</TH>
                        <td>{{$Drivers->reason_en}}</td>
                    </tr>
                    <tr>
                        <TH>Interview_Date</TH>
                        <td>{{$Drivers->interview_date}}</td>
                    </tr>

                </table>
            </td>
            <td style="vertical-align: top !important;">
                <table class="table m-0 show_table">

                    <tr>
                        <TH>Start_Date</TH>
                        <td>{{$Drivers->start_date}}</td>
                    </tr>
                    <tr>
                        <TH>licenseExpireyDate</TH>
                        <td>{{$Drivers->licenseExpireyDate}}</td>
                    </tr>
                    <tr>
                        <TH>PassportNo</TH>
                        <td>{{$Drivers->passportNo}}</td>
                    </tr>
                    <tr>
                        <TH>passportExpireyDate</TH>
                        <td>{{$Drivers->passportExpireyDate}}</td>
                    </tr>

                    <tr>
                        <TH>STC AccountNumber</TH>
                        <td>{{$Drivers->accountNumber}}</td>
                    </tr>

                    <tr>
                        <TH>STC Account Owner Iqama</TH>
                        <td>{{$Drivers->account_owner_iqama}}</td>
                    </tr>

                    <tr>
                        <TH>Driver Type</TH>
                        <td>{{$Drivers->driver_type}}</td>
                    </tr>
                    <tr>
                        <TH>Under Sopnsorship</TH>
                        <td>{{$Drivers->sopnsorship}}</td>
                    </tr>
                    <tr>
                        <TH>Ajeer</TH>
                        <td>{{$Drivers->ajeer}}</td>
                    </tr>
                    <tr>
                        <TH>Bander Car</TH>
                        <td>{{$Drivers->bander_car}}</td>
                    </tr>
                    <tr>
                        <TH>Create By</TH>
                        <td>{{$Drivers->name_created}}</td>
                    </tr>
                    <tr>
                        <TH>Update By</TH>
                        <td>{{$Drivers->name_updated}}</td>
                    </tr>
                    <tr>
                        <TH>Create At</TH>
                        <td>{{$Drivers->created_at}}</td>
                    </tr>
                    <tr>
                        <TH>Update At</TH>
                        <td>{{$Drivers->updated_at}}</td>
                    </tr>


                </table>
            </td>
            @if($Drivers->companyId==6)
                <td style="vertical-align: top !important;">
                    <table class="table m-0 show_table">

                        <tr>
                            <TH style="color: green">collectionAmount</TH>
                            <td>{{$Drivers->collectionAmount}}</td>
                        </tr>
                        <tr>
                            <TH style="color: green">numberOfDispatch</TH>
                            <td>{{$Drivers->numberOfDispatch}}</td>
                        </tr>
                        <tr>
                            <TH style="color: green">lastSettlementDate</TH>
                            <td>{{$Drivers->lastSettlementDate}}</td>
                        </tr>


                    </table>
                </td>
            @endif

        </tr>
    </table>
</div>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>

