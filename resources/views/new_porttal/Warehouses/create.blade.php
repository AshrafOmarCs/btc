
<form method="POST" action="{{ route('Warehouses.store')}}">
    @csrf
    <table class="table table-bordered">
        <tr>
            <TH>{{__('warehouses.warehouseName')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="warehouseName" required
                       autocomplete="name" autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.companyName')}} <font color="red">*</font></TH>
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
            <TH>{{__('warehouses.cityName')}} <font color="red">*</font></TH>
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
            <TH>{{__('warehouses.status')}} <font color="red">*</font></TH>
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
            <TH>{{__('warehouses.saturday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Saturday" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.sunday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Sunday" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.monday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Monday" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.tuesday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Tuesday" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.wednesday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Wednesday" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.thursday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Thursday" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.friday_price')}} <font color="red">*</font></TH>
            <td><input type="text" class="form-control"  name="Friday" required autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.latitude')}}</TH>
            <td><input type="text" class="form-control"  name="latitude" autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.longitude')}}</TH>
            <td><input type="text" class="form-control"  name="longitude" autofocus></td>
        </tr>
        <tr>
            <TH>{{__('warehouses.under_noon')}}</TH>
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
            <td><input type="text" class="form-control"  name="warehouse_unit_cost" autofocus></td>
        </tr>
    </table>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('warehouses.cancel')}}</button>
        <button class="btn btn-success" type="submit">{{__('warehouses.add')}}</button>
    </div>

</form>
