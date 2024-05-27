<div class="modal-body">
    <table class="table">
    <tr><TH>Name</TH> <td>{{$Users->name}}</td>
    <TH>IdentityNo </TH><td>{{$Users->IdentityNo}}</td></tr>
    <tr><TH>Phone </TH><td>{{$Users->phone}}</td>
    <TH>User Type </TH><td>{{$Users->user_type_name}}</td></tr>
    <tr><TH>Status</TH> <td>{{$Users->active_status}}</td>
    <TH>Email </TH><td>{{$Users->email}}</td></tr>
    <tr><TH>Bank Name </TH><td>{{$Users->bank_name_en}}</td>
    <TH>Account Number </TH><td>{{$Users->account_Number}}</td></tr>

    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
</div>

