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


@if ($Driver->driver_type_id <> 2 && $Driver->driver_type_id <> 3)

    <table border="0" width="100%" align="center">
        <tr>
            <td style="font-family: Arial;font-size: 26px; font-weight: bold;" align="center">
                <br>
                <br>

                الرجاء تعديل نوع المندوب
                <br>
                <br>
            </td>
        </tr>
    </table>
    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button
            onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
            type="button" class="w3-btn w3-red">Cancel
        </button>
    </div>
    <?php
    exit;
    ?>
@endif
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

<form id="contact_form" method="POST" onsubmit="return validateForm()" action="{{ URL('/DriversClaimSave')}}" autocomplete="off">
    @csrf
    <input type="hidden" name="driverId" value="{{$Driver->id}}">

    <table class="show_table" style="width:auto!important;">
        <tr>
            <TH>Amount (المبلغ)<font color="red">*</font></TH>
            <td><input type="text" class="form-control" name="amount" style="width: 280px" value="<?php if (isset($drivers_jahiz_claim->amount)) echo $drivers_jahiz_claim->amount; ?>" required></td>
        </tr>

        <tr>
            <TH>Claim Date (تاريخ المطالبة)<font color="red">*</font></TH>
            <td>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="claim_dt" id="claim_dt"
                           placeholder="dd/mm/yyyy" value="<?php if (isset($drivers_jahiz_claim->claim_dt)) echo $drivers_jahiz_claim->claim_dt; ?>" required>
                </div>
            </td>
        </tr>

        <tr>
            <TH>Note (ملحوظة)</TH>
            <td><textarea name="note" class="form-control" rows=5><?php if (isset($drivers_jahiz_claim->note)) echo $drivers_jahiz_claim->note; ?></textarea></td>
        </tr>

    </table>

    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Save</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>



