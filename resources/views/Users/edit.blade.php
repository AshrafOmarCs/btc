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


<table style=" width:100%;margin-top: 5px;margin-left: 20px;">
    <tr>
        <td style="width:100%;font-size: 14px;font-weight: bold;">Users</td>
    </tr>
</table>
@include('pages.messages2')
<form id="contact_form" method="POST" onsubmit="return validateForm()" action="{{ route('Users.update',$Users->id)}}">
    {{method_field("PATCH")}}
    @csrf
    <input type="hidden" name="type_id" value="{{$type_id}}">
    <table class="table m-0 show_table" style="width:10px!important;">
        <tr>
            <TH>Name <font color="red">*</font></TH>
            <td>
                <input id="name" type="text" class="form-control" style="width:250px;" name="name"
                       value="{{$Users->name}}" required autocomplete="name" autofocus>
            </td>
        </tr>
        <tr>
            <TH>IdentityNo <font color="red">*</font></TH>
            <td>
                <input id="IdentityNo" type="text" class="form-control" name="IdentityNo" value="{{$Users->IdentityNo}}"
                       required>
            </td>
        </tr>
        <tr>
            <TH>Phone <font color="red">*</font></TH>
            <td>
                <input id="Phone" type="text" class="form-control" name="phone" value="{{$Users->phone}}" required>
            </td>
        </tr>
        <tr>
            <TH>User Type <font color="red">*</font></TH>
            <td>
                <select id="user_type_id" name="user_type_id" placeholder="Select ..." class="form-control" required>

                    @foreach($lkp_user_type as $lkp_user_typ)
                        <option value="{{$lkp_user_typ->id}}"
                                @if ($Users->user_type_id==$lkp_user_typ->id){{"  selected " }}:{{""}} @endif>{{$lkp_user_typ->user_type}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <TH>Status <font color="red">*</font></TH>
            <td>
                <select id="active_id" name="active_id" placeholder="Select ..." class="form-control" required>

                    @foreach($lkp_active as $lkp_activ)
                        <option value="{{$lkp_activ->id}}"
                                @if ($Users->active_id==$lkp_activ->id){{"  selected " }}:{{""}} @endif>{{$lkp_activ->active_status}}</option>
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
                            <option value="{{$users_rolee->id}}"
                                    @if ($Users->role_id==$users_rolee->id){{"  selected " }}:{{""}} @endif>{{$users_rolee->role_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            @else
            <input type="hidden" name="role_id" value="{{$Users->role_id}}">
        @endif
        <tr>
            <TH>Bank Name <font color="red">*</font></TH>
            <td>
                <select name="bank_id" id="bank_id" class="form-control">
                    <option value=""></option>
                    @foreach($lkp_bank as $lkp_bankk)
                        <option value="{{$lkp_bankk->id}}"
                                @if ($Users->bank_id==$lkp_bankk->id){{"  selected " }}:{{""}} @endif>{{$lkp_bankk->bank_name_en}}</option>
                    @endforeach
                </select>
            </td>
        </tr>

        <tr>
            <TH>Account Number <font color="red">*</font></TH>
            <td><input type="text" class="form-control" name="account_Number" id="account_Number"
                       value="{{$Users->account_Number}}"></td>
        </tr>

        <tr>
            <TH>Email <font color="red">*</font></TH>
            <td>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                       value="{{$Users->email}}" required autocomplete="email">
            </td>
        </tr>
    </table>
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Update</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>

