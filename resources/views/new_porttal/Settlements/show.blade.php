<div class="modal-body">
    <table class="table m-0 show_table" style="width:95%!important;" >
        <tr><TH>Driver </TH><td>  {{$Settlements->fullName}}</td></tr>

        <tr><TH>Journal Date </TH> <td>{{$Settlements->journal_date}}</td></tr>
        <tr><TH>Credit </TH> <td>{{$Settlements->credit +0}}</td></tr>
        <tr><TH>Debit </TH> <td>{{$Settlements->debit +0}}</td></tr>
        <tr><TH>Note</TH>
        <td>{{$Settlements->note}}</td></tr</tr>

        <tr><TH>Update By </TH>
        <td>{{$Settlements->name}}</td>
        </tr>
        <tr><TH>Created At</TH>
        <td>{{$Settlements->created_at}}</td>
        <tr><TH>Updated At</TH>
        <td>{{$Settlements->updated_at}}</td>
        </tr>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
</div>
