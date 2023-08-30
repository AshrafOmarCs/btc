
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
 
<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">
{{$company->companyName}}  -  {{$company->warehouseName}}   -   {{$company->fullName}}
</h2>
</div>
<center><div><b><font color="red">
{{$from}}  -  {{$to}}
</font></b></div></center>  

<table class="table m-0 show_table" style="width:10px!important;">
<tr>
<TH>Date</TH>
<TH>DayName</TH>
<TH>Journal_Type</TH>
@if ($company->calculation_method_id==2)
<TH>No_Of_Deliverd</TH>
 @endif
@if ($company->calculation_method_id==1)
<TH>No_Of_TP</TH>
@endif
<TH>Unit_Cost</TH>
<TH>Credit</TH>
<TH>Debit</TH>
<TH>Brought_Down</TH>
</tr>

<?php $carried_down= 0;$no_of_touch_point=0;?>


@foreach($qq as $q) 
<?php $carried_down+=$q->Carried_Down;
        $no_of_touch_point+=$q->no_of_touch_point
?>
<tr>
<td>{{$q->date}}</td>
<td>{{$q->dayname}}</td>
<td>{{$q->journal_type}}</td>
@if ($company->calculation_method_id==2)
<td>{{$q->no_of_deliverd}}</td>
 @endif
@if ($company->calculation_method_id==1)
<td>{{$q->no_of_touch_point}}</td>
@endif
<td><?php if (isset($q->unit_cost)) echo floatval($q->unit_cost);else echo ""; ?></td>
<td><?php if (isset($q->credit)) echo floatval($q->credit);else echo ""; ?></td>
<td><?php if (isset($q->debit)) echo floatval($q->debit);else echo ""; ?></td>
<td>{{$carried_down +0}}</td>
</tr>
@endforeach
<tr>
<th colspan=3>Month Balance</th>
    <th>{{$no_of_touch_point+0}}</th>
    <th colspan=3></th>
    <th>{{$carried_down+0}}</th>
</tr>
<tr>
<th colspan=7>Carried Down</th>
<th>{{$Carried_Down->carried_down+0}}</th>
</tr>
<tr>
<th colspan=7>Brought Down</th>
<th>{{$Carried_Down->carried_down+$carried_down+0}}</th>
</tr>
</table>
           <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Close</button>
           </div>

