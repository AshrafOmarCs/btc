<style>

    .show_table th {
        padding-left: 20px !important;
        white-space: nowrap;
        border: none !important;
        margin: 0 !important;
    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
    }
</style>

<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
        style="width:100%;font-size: 14px;font-weight: bold;">Users</h2>
</div>

<form method="POST" action="{{ action('UsersController@store') }}">
    @csrf
    <input type="hidden" name="type_id" value="{{$type_id}}">
    <table class="table m-0 show_table" style="width:10px!important;">
        <tr>
            <TH>Name <font color="red">*</font></TH>
            <td>
                <input id="name" type="text" class="form-control" style="width:250px;" name="name" value="" required
                       autocomplete="name" autofocus>
            </td>
        </tr>
        <tr>
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
        </tr>
        <tr>
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
        </tr>

        <tr>
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
        </tr>

        <tr>
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
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Add</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>

