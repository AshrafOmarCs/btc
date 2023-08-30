<style>
    .show_table2 th {
        padding-left: 20px !important;
        white-space: nowrap;
        border: solid 0.5px !important;
        margin: 0 !important;
        background-color: #AFEB5F;
    }

    .show_table2 td {
        padding: 0.0rem 0.2rem !important;
        border: none !important;
        vertical-align: middle !important;
        border: solid 0.5px !important;
    }

    .show_table th {
        padding-left: 20px !important;
        white-space: nowrap;
        border: solid 0px !important;
        margin: 0 !important;

    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
        border: solid 0px !important;
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

    @include('pages.messages2')
    @if ($reply_txt=='-1')
        <form id="contact_form" method="POST" onsubmit="return validateForm()"
              action="{{ URL('/DriversClaimStatusSave')}}"
              autocomplete="off">
            @csrf
            <input type="hidden" name="drivers_jahiz_claim_id" value="{{$Driver->drivers_jahiz_claim_id}}">

            <table class="show_table" style="width:auto!important;" dir="rtl">
                <tr>
                    <TH>اختار الحالة</TH>
                    <td>
                        <select name="claim_status_id" placeholder="Select ..." class="form-control" required>
                            <option value=""></option>
                            @foreach($lkp_claim_status as $lkp_claim_statuss)
                                <option value="{{$lkp_claim_statuss->id}}">{{$lkp_claim_statuss->status_txt}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <TH>اضافة ملحوظة</TH>
                    <td><textarea name="reply_txt" class="form-control" rows=5 style="width: 600px"></textarea></td>
                </tr>

            </table>

            <div class="w3-row">
                <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Save</button>
            </div>
        </form>
    @else
        <table class="show_table2" style="width:80%" dir="rtl">
            <tr>
                <th>الحالة:</th>
                <td><b>{{$status_txt}}</b></td>
            </tr>
            <tr>
                <th>ملحوظة:</th>
                <td><b>{{$reply_txt}}</b></td>
            </tr>
        </table>
    @endif
</center>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>



