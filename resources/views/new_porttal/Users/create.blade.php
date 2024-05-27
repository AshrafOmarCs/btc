

<form method="POST" action="{{ action('UsersController@store') }}">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="type_id" value="{{$type_id}}">
        <table class="table">
            <tr>
                <TH>Name <font color="red">*</font></TH>
                <td>
                    <input id="name" type="text" class="form-control" name="name" value="" required
                        autocomplete="name" autofocus>
                </td>
                <TH>IdentityNo <font color="red">*</font></TH>
                <td>
                    <input id="IdentityNo" type="text" class="form-control" name="IdentityNo" value="" required>
                </td>
            </tr>
            <tr>
                <TH>Phone <font color="red">*</font></TH>
                <td>
                    <input id="Phone" type="text" class="form-control" name="phone" value="" required>
                </td>
                <TH>User Type <font color="red">*</font></TH>
                <td>
                    <select id="user_type_id" name="user_type_id" placeholder="Select ..." class="form-control" required>
                        <option value=""></option>
                        @foreach($lkp_user_type as $lkp_user_typ)
                            <option value="{{$lkp_user_typ->id}}">{{$lkp_user_typ->user_type}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <TH>Status <font color="red">*</font></TH>
                <td>
                    <select id="active_id" name="active_id" placeholder="Select ..." class="form-control" required>
                        <option value=""></option>
                        @foreach($lkp_active as $lkp_activ)
                            <option value="{{$lkp_activ->id}}">{{$lkp_activ->active_status}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            @if($type_id==1)
            <tr>
                <TH>Role Name</TH>
                <td>
                    <select id="role_id" name="role_id" placeholder="Select ..." class="form-control" >
                        <option value=""></option>
                        @foreach($users_role as $users_rolee)
                            <option value="{{$users_rolee->id}}">{{$users_rolee->role_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            @endif
            <tr>
                <TH>Email <font color="red">*</font></TH>
                <td>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="" required autocomplete="email">
                </td>
                <TH>Bank Name <font color="red">*</font></TH>
                <td>
                    <select name="bank_id" id="bank_id" class="form-control">
                        <option value=""></option>
                        @foreach($lkp_bank as $lkp_bankk)
                            <option value="{{$lkp_bankk->id}}">{{$lkp_bankk->bank_name_en}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <TH>Account Number <font color="red">*</font></TH>
                <td><input type="text" class="form-control" name="account_Number" id="account_Number"></td>
                <TH>Password <font color="red">*</font></TH>
                <td>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">
                </td>
            </tr>
            <tr>
                <TH>Confirm Password <font color="red">*</font></TH>
                <td>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                        autocomplete="new-password">
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Add</button>
    </div>
</form>

