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

<form method="POST" action="{{ route('Warehouses.store')}}">
    @csrf
    <table class="table m-0 show_table" style="width:10px!important;">
        <tr>
            <TH>WarehouseName <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="warehouseName" required
                       autocomplete="name" autofocus></td>
        </tr>
        <tr>
            <TH>CompanyName <font color="red">*</font></TH>
            <td>
                <select name="companyId" placeholder="Select ..." class="form-control" required>
                    <option value=""></option>
                    @foreach($lkp_company as $lkpcompany)
                        <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <TH>CityName <font color="red">*</font></TH>
            <td>
                <select name="cityId" placeholder="Select ..." class="form-control" required>
                    <option value=""></option>

                    @foreach($lkp_city as $lkpcity)
                        <option value="{{$lkpcity->id}}">{{$lkpcity->name_en}}</option>
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
        <tr>
            <TH>Saturday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Saturday" required autofocus></td>
        </tr>
        <tr>
            <TH>Sunday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Sunday" required autofocus></td>
        </tr>
        <tr>
            <TH>Monday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Monday" required autofocus></td>
        </tr>
        <tr>
            <TH>Tuesday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Tuesday" required autofocus></td>
        </tr>
        <tr>
            <TH>Wednesday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Wednesday" required autofocus></td>
        </tr>
        <tr>
            <TH>Thursday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Thursday" required autofocus></td>
        </tr>
        <tr>
            <TH>Friday Price <font color="red">*</font></TH>
            <td><input type="text" class="form-control" style="width:250px;" name="Friday" required autofocus></td>
        </tr>
        <tr>
            <TH>Latitude</TH>
            <td><input type="text" class="form-control" style="width:250px;" name="latitude" autofocus></td>
        </tr>
        <tr>
            <TH>Longitude</TH>
            <td><input type="text" class="form-control" style="width:250px;" name="longitude" autofocus></td>
        </tr>
        <tr>
            <TH>Under Noon</TH>
            <td>
                <select name="under_noon_id" id="under_noon_id" class="form-control">
                    <option value=""></option>
                    @foreach($lkp_yes_no as $lkp_yes_noo)
                        <option value="{{$lkp_yes_noo->id}}">{{$lkp_yes_noo->yes_no}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <TH>Unit Cost</TH>
            <td><input type="text" class="form-control" style="width:250px;" name="warehouse_unit_cost" autofocus></td>
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

