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
        <td style="width:100%;font-size: 14px;font-weight: bold;">UsersRole</td>
    </tr>
</table>
@include('pages.messages2')
<form id="contact_form" method="POST" onsubmit="return validateForm()" action="{{ route('UsersRole.update',$UsersRole->id)}}">
    {{method_field("PATCH")}}
    @csrf
    <table class="table m-0 show_table" style="width:10px!important;">
        <tr>
            <TH>Role Name <font color="red">*</font></TH>
            <td>
                <input id="name" type="text" class="form-control" style="width:250px;" name="role_name"
                       value="{{$UsersRole->role_name}}" required autocomplete="name" autofocus>
            </td>
        </tr>

        <tr>
            <TH>Status <font color="red">*</font></TH>
            <td>
                <select id="active_id" name="active_id" placeholder="Select ..." class="form-control" required>

                    @foreach($lkp_active as $lkp_activ)
                        <option value="{{$lkp_activ->id}}"
                                @if ($UsersRole->active_id==$lkp_activ->id){{"  selected " }}:{{""}} @endif>{{$lkp_activ->active_status}}</option>
                    @endforeach
                </select>
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

