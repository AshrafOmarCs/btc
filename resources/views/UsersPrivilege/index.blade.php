<style>

    .show_table th{
        padding: 0.0rem 0.3rem !important;
        border:solid 1px !important;
        margin:0!important;
        width:10px;
    }
    .show_table td{
        white-space: nowrap;
        padding: 0.0rem 0.3rem !important;
        border:solid 1px !important;
        vertical-align: middle !important;
    }
</style>

<center>
    <table style=" width:100%;margin-top: 5px;margin-left: 20px;">
        <tr>
            <td style="width:100%;font-size: 14px;font-weight: bold;text-align: center">{{$user->name}}</td>
        </tr>
    </table>


    @include('pages.messages2')
    <form id="contact_form" method="POST" onsubmit="return validateForm()" action="{{ action('UsersPrivilegeController@store') }}">
        @csrf
        <?php $privilage_type_id = "";?>
        <div class="table-responsive" style="width: 100%;">
        <div  style="height: 500px;overflow-y: auto;">
            <table class="table table-striped show_table" style="width:95%">
                <input name="user_id" type="hidden" value="{{$user->id}}">
                <thead>
                <tr>
                    <TH>CompanyName</TH>
                    <TH>CityName</TH>
                    <TH>WarehouseName</TH>
                    @if ($user->user_type_id==3)
                        <TH>Select</TH>
                    @endif
                    @if ($user->user_type_id==2)
                        <TH>readonly</TH>
                        <TH>full</TH>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($UsersMenu as $User_Menu)
                    <tr>
                        <td>{{$User_Menu->companyName}} </td>
                        <td> {{$User_Menu->name_en}}  </td>
                        <td> {{$User_Menu->warehouseName}}</td>
                        @if ($user->user_type_id==3)
                            <td>
                                <input type="radio" name="warehouseId" value="{{$User_Menu->id}}" class="flat-red"
                                       @if (! is_null($User_Menu->privilage_type_id)){{"  checked " }}:{{""}} @endif required>
                                <?php if (!is_null($User_Menu->privilage_type_id)) $privilage_type_id = $User_Menu->privilage_type_id; ?>
                            </td>
                        @endif
                        @if ($user->user_type_id==2)
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" name="Read_{{$User_Menu->id}}"
                                           id="Read_{{$User_Menu->id}}" type="checkbox"
                                           value="1" @if ($User_Menu->privilage_type_id=='0'){{"  checked " }}@endif>
                                    <label for="Read_{{$User_Menu->id}}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" name="Full_{{$User_Menu->id}}"
                                           id="Full_{{$User_Menu->id}}" type="checkbox"
                                           value="1" @if ($User_Menu->privilage_type_id=='1'){{"  checked " }}@endif>
                                    <label for="Read_{{$User_Menu->id}}" class="custom-control-label"></label>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        </div>
        @if ($user->user_type_id==3)
            <table>
                <tr>
                    <td><b>Privilage_type&nbsp;</td>
                    <td><b>
                            <select id="privilage_type_id" name="privilage_type_id" class="form-control"
                                    style="width:200px" required>

                                @foreach($lkp_privilege_type as $lkp_privilege_typee)
                                    <option value="{{$lkp_privilege_typee->id}}"
                                            @if ($privilage_type_id==$lkp_privilege_typee->id){{"  selected " }}:{{""}} @endif>{{$lkp_privilege_typee->privilege_type}}</option>
                                @endforeach
                            </select></td>
                </tr>
            </table>
        @endif

        <div class="w3-row">
            <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Save Privilages</button>
        </div>
    </form>
    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button
            onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
            type="button" class="w3-btn w3-red">Cancel
        </button>
    </div>





