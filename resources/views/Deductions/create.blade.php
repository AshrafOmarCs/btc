<style>
  .show_table th{
   padding-left: 20px !important;
   white-space: nowrap;
   border:none !important;
  margin:0!important;
  }
  .show_table td{
   padding: 0.0rem 0.0rem !important;
   border:none !important;
   vertical-align: middle !important;
  }
  </style>

 
  <?php
  
  if (date('d')<21)
  {$from =date('Y-m-d', strtotime(date('Y-m-21').' -1 MONTH'));$to=date('Y-m-20');}
  elseif (date('d') >=21)
  {$from=date('Y-m-21');$to=date('Y-m-d', strtotime(date('Y-m-20').' +1 MONTH'));} 
 

  $drivers=\DB::select("select count(*) as CO FROM
  (
    select journal.driverId from drivers
    left join journal on journal.driverId=drivers.id and journal_type_id=5 and 
    (journal_date BETWEEN '".$from."' AND '".$to."')
    where under_sopnsorship_id=1
  )aa
  where driverId is null")[0];
 
?>  
<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Deductions From:{{$from}}   To:{{$to}}</h2>
</div>
<form method="POST" action="{{ route('Deductions.store')}}"    >   
                       @csrf

<table class="table m-0 show_table" style="width:10px!important;" >
<tr><TH>Driver</TH>  
<td  style="white-space: nowrap;">{{$drivers->CO}}</td>
 </tr>
 <tr><TH>Journal Date <font color="red">*</font></TH>  
 <td>
 <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" style="width:200px"; class="form-control pull-right" name="journal_date" placeholder="dd/mm/yyyy" id="journal_date" value="" required>
                </div>
 </td>
 </tr>
</table>
           <div class="w3-row">
                 <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Add Deductions To Journal</button>
              </div>
</form>
           <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Cancel</button>
           </div>
