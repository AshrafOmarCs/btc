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


<center>
    <div style="margin-top: 2px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;"><font color="blue">Jahiz
                - {{$Driver->warehouseName}} - {{$Driver->job_id}}</font></h2>
    </div>
    <div style="margin-top: 2px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">{{$Driver->fullName}}</h2>
    </div>
    <div style="margin-top: 2px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">
            نوع المندوب :
            <?php
            if ($Driver->driver_type_id == 2) echo "شهري";
            elseif ($Driver->driver_type_id == 3) echo "عمولة";
            ?>
        </h2>
    </div>
</center>
@include('pages.messages2')
<center>
    <form id="contact_form" method="POST" onsubmit="return validateForm()" action="{{ URL('/DriversClaimCommissionSave')}}"
          autocomplete="off">
        @csrf
        <input type="hidden" name="drivers_jahiz_claim_id" value="{{$Driver->drivers_jahiz_claim_id}}">

        <table class="show_table" style="width:auto!important;">


            <tr>

                <td><input type="text" class="form-control" name="Bander_Commission"
                           value="{{$drivers_jahiz_claim->Bander_Commission}}" required></td>
                <TH>عمولة بندر</TH>
            </tr>

        </table>

        <div class="w3-row">
            <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Save</button>
        </div>
    </form>
</center>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>



