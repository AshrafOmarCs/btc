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

 <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Loans</h2>
</div>

<table class="table m-0 show_table" style="width:95%!important;" >
<tr><TH>Driver</TH>
<td>{{$Loans->fullName}}</td>
 </tr>
 <tr><TH>Journal Date</TH>
 <td>{{$Loans->journal_date}}</td>
 </tr>
 </tr>
 <tr><TH>Amount </TH>
 <td>{{$Loans->amount}}</td>
 </tr>
 <tr><TH>Note</TH>
 <td>{{$Loans->note}}</td>
 </tr>
 <tr><TH>Status</TH>
 <td>
   <?php
                         if($Loans->status_id=="1") echo '<span class="label label-warning">'.$Loans->loan_status.'</span>';
                    else if($Loans->status_id=="2") echo '<span class="label label-danger">'.$Loans->loan_status.'</span>';
                    else if($Loans->status_id=="3") echo '<span class="label label-primary">'.$Loans->loan_status.'</span>';
                    else if($Loans->status_id=="4") echo '<span class="label label-success">'.$Loans->loan_status.'</span>';
                    else if($Loans->status_id=="5") echo '<span class="label label-info">'.$Loans->loan_status.'</span>';
   ?>
 </td>
 </tr>
<tr><TH>Create By </TH>
<td>{{$Loans->name_created}}</td>
 </tr>
<tr><TH>Update By </TH>
<td>{{$Loans->name_updated}}</td>
 </tr>
 <tr><TH>Created At</TH>
 <td>{{$Loans->created_at}}</td>
 <tr><TH>Updated At</TH>
 <td>{{$Loans->updated_at}}</td>
</tr>
  </table>

           <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Close</button>
           </div>
