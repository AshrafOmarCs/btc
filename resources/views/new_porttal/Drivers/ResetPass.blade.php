 <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">{{$Driver->fullName}} (<span style="color: #B7A758">{{$Driver->job_id}}</span>)</h2>
</div>


<form method="POST" action="{{ URL('/SaveResetPass')}}">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.password')}} <font color="red">*</font></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.confirm_password')}} <font color="red">*</font></label>
                            <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('users.cancel')}}</button>
        <button class="btn btn-success" type="submit">{{__('users.ResetPassword')}}</button>
    </div>
</form>

