
<style>

  .show_table th{
   padding-left: 20px !important;
   white-space: nowrap;
   border:none !important;
  margin:0!important;
  width:10px;
  }
  .show_table td{
   padding: 0.0rem 0.0rem !important;
   border:none !important;
   vertical-align: middle !important;
  }
  </style>

<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Warehouses</h2>
</div>


<table class="table m-0 show_table" style="width:100%!important;">
 <tr><TH>WarehouseName</TH> <td>{{$Warehouses->warehouseName}}</td></tr>
 <tr><TH>CompanyName </TH><td>{{$Warehouses->companyName}}</td></tr>
 <tr><TH>CityName </TH><td>{{$Warehouses->name_en}}</td></tr>
 <tr><TH>Status</TH> <td>{{$Warehouses->active_status}}</td></tr>
 <tr><TH>Created_at </TH><td>{{$Warehouses->created_at}}</td></tr>
 <tr><TH>Updated_at</TH> <td>{{$Warehouses->updated_at}}</td></tr>
 <tr><TH>Saturday Price</TH><td>{{$Warehouses->Saturday + 0}}</td></tr>
 <tr><TH>Sunday Price</TH>  <td>{{$Warehouses->Sunday + 0}}</td></tr>
 <tr><TH>Monday Price</TH><td>{{$Warehouses->Monday + 0}}</td></tr>
 <tr><TH>Tuesday Price</TH><td>{{$Warehouses->Tuesday + 0}}</td></tr>
 <tr><TH>Wednesday Price</TH> <td>{{$Warehouses->Wednesday + 0}}</td></tr>
 <tr><TH>Thursday Price</TH><td>{{$Warehouses->Thursday + 0}}</td></tr>
 <tr><TH>Friday Price</TH> <td>{{$Warehouses->Friday + 0}}</td></tr>
 <tr><TH>Under Noon </TH><td>{{$Warehouses->yes_no}}</td></tr>
 <tr><TH>Unit Cost </TH><td>{{$Warehouses->warehouse_unit_cost}}</td></tr>

</table>
           <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Close</button>
           </div>

