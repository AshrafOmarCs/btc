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

 <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Settlements</h2>
</div>
    


<table class="table m-0 show_table" style="width:95%!important;" >
<tr><TH>Driver </TH><td>  {{$Settlements->fullName}}</td></tr>
   
<tr><TH>Journal Date </TH> <td>{{$Settlements->journal_date}}</td></tr>
 <tr><TH>Credit </TH> <td>{{$Settlements->credit +0}}</td></tr>
 <tr><TH>Debit </TH> <td>{{$Settlements->debit +0}}</td></tr>
 <tr><TH>Note</TH>  
 <td>{{$Settlements->note}}</td></tr</tr>
 
<tr><TH>Update By </TH>  
<td>{{$Settlements->name}}</td>
 </tr>
 <tr><TH>Created At</TH>
 <td>{{$Settlements->created_at}}</td>
 <tr><TH>Updated At</TH>
 <td>{{$Settlements->updated_at}}</td>
</tr>
  </table>

  <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Close</button>
           </div>

