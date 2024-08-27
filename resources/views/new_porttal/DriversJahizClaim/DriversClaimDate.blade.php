
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
    <form id="contact_form" method="POST" onsubmit="return validateForm()" action="{{ URL('/DriversClaimDateSave')}}"
          autocomplete="off">
        @csrf
        <input type="hidden" name="drivers_jahiz_claim_id" value="{{$Driver->drivers_jahiz_claim_id}}">
        <div class="modal-body">
            <table>
                <tr>
                    <td>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" class="form-control pull-right" name="claim_dt"
                                placeholder="yyyy-mm-dd" id="claim_dt" value="{{$drivers_jahiz_claim->claim_dt}}" required>
                        </div>
                    </td>
                    <TH>موعد السداد</TH>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-success" type="submit">Update</button>
        </div>
    </form>
</center>
