
  <table class="table table-bordered">
   <tr><TH>{{__('warehouses.warehouseName')}}</TH> <td>{{$Warehouses->warehouseName}}</td></tr>
   <tr><TH>{{__('warehouses.companyName')}} </TH><td>{{$Warehouses->companyName}}</td></tr>
   <tr><TH>{{__('warehouses.cityName')}} </TH><td>{{$Warehouses->name_en}}</td></tr>
   <tr><TH>{{__('warehouses.status')}}</TH> <td>{{$Warehouses->active_status}}</td></tr>
   <tr><TH>{{__('warehouses.created_at')}} </TH><td>{{$Warehouses->created_at}}</td></tr>
   <tr><TH>{{__('warehouses.updated_at')}}</TH> <td>{{$Warehouses->updated_at}}</td></tr>
   <tr><TH>{{__('warehouses.saturday_price')}}</TH><td>{{$Warehouses->Saturday + 0}}</td></tr>
   <tr><TH>{{__('warehouses.sunday_price')}} </TH>  <td>{{$Warehouses->Sunday + 0}}</td></tr>
   <tr><TH>{{__('warehouses.monday_price')}} </TH><td>{{$Warehouses->Monday + 0}}</td></tr>
   <tr><TH>{{__('warehouses.tuesday_price')}} </TH><td>{{$Warehouses->Tuesday + 0}}</td></tr>
   <tr><TH>{{__('warehouses.wednesday_price')}} </TH> <td>{{$Warehouses->Wednesday + 0}}</td></tr>
   <tr><TH>{{__('warehouses.thursday_price')}} </TH><td>{{$Warehouses->Thursday + 0}}</td></tr>
   <tr><TH>{{__('warehouses.friday_price')}}</TH> <td>{{$Warehouses->Friday + 0}}</td></tr>
   <tr><TH>{{__('warehouses.under_noon')}} </TH><td>{{$Warehouses->yes_no}}</td></tr>
   <tr><TH>{{__('warehouses.unit_cost')}} </TH><td>{{$Warehouses->warehouse_unit_cost}}</td></tr>

  </table>
<div class="modal-footer">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('companies.cancel')}}</button>
</div>

