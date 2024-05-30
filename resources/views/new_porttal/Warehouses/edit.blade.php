
<form method="POST" action="{{ route('Warehouses.update',$Warehouses->id)}}">
    {{method_field("PATCH")}}
    @csrf
    <table class="table table-bordered">
        <tr>
            <TH>{{__('warehouses.warehouseName')}} <font color="red">*</font></TH>
            <td>
                <input type="text" class="form-control"  name="warehouseName"
                       value="{{$Warehouses->warehouseName}}" required autocomplete="name" autofocus>
            </td>
        <tr>
            <TH>{{__('warehouses.companyName')}} <font color="red">*</font></TH>
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
            <TH>{{__('warehouses.cityName')}} <font color="red">*</font></TH>
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
            <TH>{{__('warehouses.status')}} <font color="red">*</font></TH>
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
            <TH>{{__('warehouses.saturday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Saturday"
                       value="{{$Warehouses->Saturday  + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.sunday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Sunday"
                       value="{{$Warehouses->Sunday  + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.monday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Monday"
                       value="{{$Warehouses->Monday  + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.tuesday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Tuesday"
                       value="{{$Warehouses->Tuesday  + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.wednesday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Wednesday"
                       value="{{$Warehouses->Wednesday + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.thursday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Thursday"
                       value="{{$Warehouses->Thursday + 0}}" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.friday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Friday"
                       value="{{$Warehouses->Friday + 0}}" required autofocus></td>
        </tr>

        <tr>
            <TH>{{__('warehouses.latitude')}}</TH>
            <td><input type="text" class="form-control"  name="latitude"
                       value="{{$Warehouses->latitude }}" autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.longitude')}}</TH>
            <td><input type="text" class="form-control"  name="longitude"
                       value="{{$Warehouses->longitude}}" autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.under_noon')}}</TH>
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
            <TH>{{__('warehouses.unit_cost')}}</TH>
            <td><input type="text" class="form-control"  name="warehouse_unit_cost"
                       value="{{$Warehouses->warehouse_unit_cost}}" autofocus></td>
        </tr>
    </table>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('warehouses.cancel')}}</button>
        <button class="btn btn-success" type="submit">{{__('warehouses.update')}}</button>
    </div>
</form>

