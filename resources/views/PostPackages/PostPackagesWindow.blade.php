
<style>
  
  .show_table th{
    padding: 0.0rem 0.3rem !important;
   border:solid 1px !important;
  margin:0!important;
  width:10px;
  font-family: 'Segoe UI';
  font-size: 12px;
  white-space: nowrap;
  }
  .show_table td{
    white-space: nowrap;
   padding: 0.0rem 0.3rem !important;
   border:solid 1px !important;
   vertical-align: middle !important;
   font-family: 'Segoe UI';
   font-size: 12px;
  }
  </style>
<meta charset="utf-8">
 <center>
<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-family: 'Segoe UI';;font-size: 14px;font-weight: bold;">
{{$company->companyName}}&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;  {{$company->warehouseName}}
-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$date}}
</h2>
</div>
  
<table cellspacing="0" cellpadding="0" class="table m-0 show_table" style="width:10px!important; border-collapse: collapse;">
<tr>
<TH>Date</TH>
<TH>DayName</TH>
<TH>Driver</TH>
@if ($company->calculation_method_id==2)
<TH>No Of Deliverd</TH>
 @endif
@if ($company->calculation_method_id==1)
<TH>No Of TouchPoint</TH>
@endif
<TH>Unit Cost</TH>
@if ($company->calculation_method_id==2)
<TH>CostBy_no_of_deliverd</TH>
 @endif
@if ($company->calculation_method_id==1)
<TH>CostBy_no_of_touch_point</TH>
@endif
</tr>
<?php $cost_no_of_deliverd= 0;$cost_no_of_touch_point= 0;?>


@foreach($qq as $q) 
<?php $cost_no_of_deliverd+=$q->CostBy_no_of_deliverd;
$cost_no_of_touch_point+=$q->CostBy_no_of_touch_point;
?>
<tr>
<td>{{$q->pakage_date}}</td>
<td>{{$q->dayname}}</td>
<td>{{$q->fullName}}</td>
@if ($company->calculation_method_id==2)
<td>{{$q->no_of_deliverd}}</td>
 @endif
@if ($company->calculation_method_id==1)
<td>{{$q->no_of_touch_point}}</td>
@endif
<td>{{$q->unit_cost+0 }}</td>
@if ($company->calculation_method_id==2)
<td>{{$q->CostBy_no_of_deliverd+0 }}</td>
@endif
@if ($company->calculation_method_id==1)
<td>{{$q->CostBy_no_of_touch_point+0 }}</td>
@endif
</tr>
@endforeach

<tr>
<th colspan=5 style="text-align: left;">Total</th>
@if ($company->calculation_method_id==2)
<th style="text-align: left;">{{$cost_no_of_deliverd+0}}</th>
@endif
@if ($company->calculation_method_id==1)
<th style="text-align: left;">{{$cost_no_of_touch_point+0}}</th>
@endif
</tr>
 </table>
 </center> 

