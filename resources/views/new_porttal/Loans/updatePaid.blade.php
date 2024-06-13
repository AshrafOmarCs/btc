@include('pages.messages')
<div style="font-size: 14px; text-align: center"><b>{{$loan->fullName}}</b></div>

<form method="POST" action="{{ URL('/LoanPaidSave')}}"  enctype="multipart/form-data"  >
{{method_field("PUT")}}
@csrf
<div class="modal-body">
    <input name="loan_id" type="hidden" value="{{$id}}">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
    <button class="btn btn-primary" type="submit">{{__('drivers.Submit')}}</button>
</div>
</form>
