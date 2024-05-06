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
        style="width:100%;font-size: 14px;font-weight: bold;">Warehouses</h2>
</div>

<form method="POST" action="{{ route('Warehouses.update',$Warehouses->id)}}">
    {{method_field("PATCH")}}
    @csrf
    <table class="table m-0 show_table" style="width:10px!important;">
        <tr>
            <TH>WarehouseName <font color="red">*</font></TH>
            <td>
                <input type="text" class="form-control" style="width:250px;" name="warehouseName"
                       value="{{$Warehouses->warehouseName}}" required autocomplete="name" autofocus>
            </td>
        <tr>
            <TH>CompanyName <font color="red">*</font></TH>
            <td>
                <select name="companyId" placeholder="Select ..." class="form-control" required>

                    @foreach($lkp_company as $lkpcompany)
                        <option value="{{$lkpcompany->id}}"
                                @if ($Warehouses->companyId==$lkpcompany->id){{"  selected " }}:{{""}} @endif>{{$lkpcompany->companyName}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <TH>CityName <font color="red">*</font></TH>
            <td>
                <select name="cityId" placeholder="Select ..." class="form-control" required>

                    @foreach($lkp_city as $lkpcity)
                        <option value="{{$lkpcity->id}}"
                                @if ($Warehouses->cityId==$lkpcity->id){{"  selected " }}:{{""}} @endif>{{$lkpcity->name_en}}</option>
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
                                @if ($Warehouses->active_id==$lkp_activ->id){{"  selected " }}:{{""}} @endif>{{$lkp_activ->active_status}}</option>
                    @endforeach
                </select>
            </td>
        </tr>

        <tr>
            <TH>Saturday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Saturday"
                       value="{{$Warehouses->Saturday  + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>Sunday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Sunday"
                       value="{{$Warehouses->Sunday  + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>Monday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Monday"
                       value="{{$Warehouses->Monday  + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>Tuesday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Tuesday"
                       value="{{$Warehouses->Tuesday  + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>Wednesday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Wednesday"
                       value="{{$Warehouses->Wednesday + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>Thursday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Thursday"
                       value="{{$Warehouses->Thursday + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>Friday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Friday"
                       value="{{$Warehouses->Friday + 0}}" required autofocus></td>
        </tr>

        <tr>
            <TH>Latitude</TH>
            <td><input type="text" class="form-control" style="width:250px;" name="latitude"
                       value="{{$Warehouses->latitude }}" autofocus></td>
        </tr>
        <tr>
            <TH>Longitude</TH>
            <td><input type="text" class="form-control" style="width:250px;" name="longitude"
                       value="{{$Warehouses->longitude}}" autofocus></td>
        </tr>
        <tr>
            <TH>Under Noon</TH>
            <td>
                <select name="under_noon_id" id="under_noon_id" class="form-control"
                        style="width:200px;">
                    <option value=""></option>
                    @foreach($lkp_yes_no as $lkp_yes_noo)
                        <option value="{{$lkp_yes_noo->id}}"
                                @if ($Warehouses->under_noon_id==$lkp_yes_noo->id){{"  selected " }}:{{""}} @endif>{{$lkp_yes_noo->yes_no}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <TH>Unit Cost</TH>
            <td><input type="text" class="form-control" style="width:250px;" name="warehouse_unit_cost"
                       value="{{$Warehouses->warehouse_unit_cost}}" autofocus></td>
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

