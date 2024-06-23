

<form method="POST" action="{{ action('UsersController@store') }}">
    @csrf
    <input type="hidden" name="type_id" value="{{$type_id}}">
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.name')}} <font color="red">*</font></label>
                            <input id="name" type="text" class="form-control" name="name" value="" required
                            autocomplete="name" autofocus>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.identityNo')}} <font color="red">*</font></label>
                            <input id="IdentityNo" type="text" class="form-control" name="IdentityNo" value="" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.phone')}} <font color="red">*</font></label>
                            <input id="Phone" type="text" class="form-control" name="phone" value="" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.user_type')}} <font color="red">*</font></label>
                            <select id="user_type_id" name="user_type_id" placeholder="Select ..." class="form-control" required>
                                <option value=""></option>
                                @foreach($lkp_user_type as $lkp_user_typ)
                                    <option value="{{$lkp_user_typ->id}}">{{$lkp_user_typ->user_type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.status')}} <font color="red">*</font></label>
                            <select id="active_id" name="active_id" placeholder="Select ..." class="form-control" required>
                                <option value=""></option>
                                @foreach($lkp_active as $lkp_activ)
                                    <option value="{{$lkp_activ->id}}">{{$lkp_activ->active_status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            @if($type_id==1)
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.role_name')}} <font color="red">*</font></label>
                            <select id="role_id" name="role_id" placeholder="Select ..." class="form-control" >
                                <option value=""></option>
                                @foreach($users_role as $users_rolee)
                                    <option value="{{$users_rolee->id}}">{{$users_rolee->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.email')}}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="" required autocomplete="email">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.bank_name')}}</label>
                            <select name="bank_id" id="bank_id" class="form-control">
                                <option value=""></option>
                                @foreach($lkp_bank as $lkp_bankk)
                                    <option value="{{$lkp_bankk->id}}">{{$lkp_bankk->bank_name_en}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.account_number')}}</label>
                            <input type="text" class="form-control" name="account_Number" id="account_Number">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.password')}}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('users.confirm_password')}}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                            autocomplete="new-password">
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Add</button>
    </div>
</form>

