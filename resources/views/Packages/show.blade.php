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

 <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Packages</h2>
</div>
    
<table class="table m-0 show_table" style="width:95%!important;" >
<tr><TH>Driver</TH>  
<td>{{$Packages->fullName}}</td>
 </tr>
 <tr><TH>total_out_for_deliver</TH>  
 <td>{{$Packages->total_out_for_deliver}}</td>
 </tr>
 <tr><TH>total_no_touchpoint </TH>  
 <td>{{$Packages->total_no_touchpoint}}</td>
 </tr>
 <tr><TH>no_of_deliverd</TH>  
 <td>{{$Packages->no_of_deliverd}}</td>
 </tr>
 <tr><TH>no_of_touch_point</TH>  
 <td>{{$Packages->no_of_touch_point}}</td>
 </tr>
<tr><TH>attendence </TH>   
<td>
<?php 
if ($Packages->attendence=="1")
echo '<span class="label label-success">Attend</span>';
elseif ($Packages->attendence=="0")
echo '<span class="label label-danger">Absent</span>';
?>
</td>
 </tr>  
<tr><TH>pakage_date </TH>  
<td>{{$Packages->pakage_date}}</td>
 </tr>
 <tr><TH>Complete</TH>
 <td>
 <?php 
if ($Packages->packageStatusId=="1")
echo '<span class="label label-warning">'.$Packages->status.'</span>';
elseif ($Packages->packageStatusId=="2")
echo '<span class="label label-success">'.$Packages->status.'</span>';
?>
 </td>
</tr>
<tr><TH>Approve</TH>
 <td><?php 
if ($Packages->approveStatusId=="1")
echo '<span class="label label-warning">'.$Packages->approvestatus.'</span>';
elseif ($Packages->approveStatusId=="2")
echo '<span class="label label-success">'.$Packages->approvestatus.'</span>';
?>
</td>
</tr>
  </table>
           
           <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Close</button>
           </div>
