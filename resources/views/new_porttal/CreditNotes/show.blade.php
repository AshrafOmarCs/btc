
<div class="modal-body">
    <table>
        <tr>
            <TH>Driver</TH>
            <td>  {{$CreditNotes->fullName}}</td>
        </tr>

        <tr>
            <TH>Journal Date</TH>
            <td>{{$CreditNotes->journal_date}}</td>
        </tr>
        <tr>
            <TH>Amount</TH>
            <td>{{$CreditNotes->amount +0}}</td>
        </tr>
        <tr>
            <TH>Invoice Number</TH>
            <td>{{$CreditNotes->invoice_number}}</td>
        </tr>
        <tr>
            <TH>Note</TH>
            <td>{{$CreditNotes->note}}</td>
        </tr>
        <tr>
            <TH>Create By</TH>
            <td>{{$CreditNotes->name_created}}</td>
        </tr>
        <tr>
            <TH>Update By</TH>
            <td>{{$CreditNotes->name_updated}}</td>
        </tr>
        <tr>
            <TH>Created At</TH>
            <td>{{$CreditNotes->created_at}}</td>
        <tr>
            <TH>Updated At</TH>
            <td>{{$CreditNotes->updated_at}}</td>
        </tr>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
</div>
