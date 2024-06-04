
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
    <form id="contact_form" method="POST" onsubmit="return validateForm()" action="{{ URL('/DriversClaimReplySave')}}"
          autocomplete="off">
        @csrf
        <input type="hidden" name="drivers_jahiz_claim_id" value="{{$Driver->drivers_jahiz_claim_id}}">

        <table class="show_table" style="width:auto!important;" dir="rtl">


            <tr>
                <TH>اضافة رد</TH>
                <td><textarea name="reply_txt" class="form-control" rows=5 style="width: 600px" required></textarea></td>
            </tr>

        </table>

        <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-success" type="submit">Update</button>
        </div>
    </form>
@else
    <table style="width:90%" dir="rtl">
        <tr>
            <td>ردك:</td>
            <td><b>{{$reply_txt}}</b></td>
        </tr>
    </table>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
    </div>
@endif
</center>
