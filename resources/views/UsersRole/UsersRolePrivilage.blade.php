<style>

    input[type="checkbox"], input[type="radio"] {
        margin: 0px 0px 0px 0px !important;
        line-height: normal;
    }

    .show_table th {
        padding: 4px 4px !important;
        line-height: 1.42857143;
        vertical-align: middle !important;
        border-top: 1px solid #ddd;
        background-color: #FF9DCE;
    }

    .show_table td {
        padding: 2px 4px !important;
        line-height: 1.42857143;
        vertical-align: middle !important;
        border-top: 1px solid #ddd;
    }
</style>
<center>
    <table style=" width:100%;margin-top: 5px;margin-left: 20px;">
        <tr>
            <td style="width:100%;font-size: 14px;font-weight: bold;text-align: center">{{$users_role->role_name}}</td>
        </tr>
    </table>

    @include('pages.messages2')
    <form id="contact_form" method="POST" onsubmit="return validateForm()" action="{{ URL('/UsersRolePrivilageSave')}}">
        @csrf
        <div class="table-responsive" style="width: 100%;">
            <div style="height: 500px;overflow-y: auto;">
                <table class="table table-striped show_table" style="width:95%;">
                    <input name="role_id" type="hidden" value="{{$users_role->id}}">
                    <input name="role_name" type="hidden" value="{{$users_role->role_name}}">
                    <thead>
                    <tr>
                        <TH>GroupName</TH>
                        <TH>MenuName</TH>
                        <TH>Read</TH>
                        <TH>Create</TH>
                        <TH>Update</TH>
                        <TH>Delete</TH>
                        <TH>Post</TH>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($UsersMenu as $User_Menu)
                        <tr>
                            <td>{{$User_Menu->group_name}} </td>
                            <td> {{$User_Menu->menu_name}}  </td>
                            <td>

                                <input class="icheckbox_flat-green" name="Read_{{$User_Menu->id}}"
                                       id="Read_{{$User_Menu->id}}" type="checkbox"
                                       value="1" @if ($User_Menu->read=='1'){{"  checked " }}@endif>


                            </td>
                            <td>
                                <input class="icheckbox_flat-green" name="Create_{{$User_Menu->id}}"
                                       id="Create_{{$User_Menu->id}}" type="checkbox"
                                       value="1" @if ($User_Menu->create=='1'){{"  checked " }}@endif>

                            </td>
                            <td>
                                <input class="icheckbox_flat-green" name="Update_{{$User_Menu->id}}"
                                       id="Update_{{$User_Menu->id}}" type="checkbox"
                                       value="1" @if ($User_Menu->update=='1'){{"  checked " }}@endif>

                            </td>
                            <td>

                                <input class="icheckbox_flat-green" name="Delete_{{$User_Menu->id}}"
                                       id="Delete_{{$User_Menu->id}}" type="checkbox"
                                       value="1" @if ($User_Menu->delete=='1'){{"  checked " }}@endif>

                            </td>
                            <td>

                                <input class="icheckbox_flat-green" name="Post_{{$User_Menu->id}}"
                                       id="Post_{{$User_Menu->id}}" type="checkbox"
                                       value="1" @if ($User_Menu->post=='1'){{"  checked " }}@endif>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w3-row">
            <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Save Privilages</button>
        </div>
    </form>
</center>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>







