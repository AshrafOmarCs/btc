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

 <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">CreditNotes</h2>
</div>
    


<table class="table m-0 show_table" style="width:95%!important;" >
<tr><TH>Driver </TH><td>  {{$CreditNotes->fullName}}</td></tr>
   
<tr><TH>CreditNotes Date </TH> <td>{{$CreditNotes->dt}}</td></tr>
 <tr><TH>Amount </TH> <td>{{$CreditNotes->amount +0}}</td></tr>
 <tr><TH>Note</TH>  
 <td>{{$CreditNotes->note}}</td></tr</tr>
 
<tr><TH>Update By </TH>  
<td>{{$CreditNotes->name}}</td>
 </tr>
 <tr><TH>Created At</TH>
 <td>{{$CreditNotes->created_at}}</td>
 <tr><TH>Updated At</TH>
 <td>{{$CreditNotes->updated_at}}</td>
</tr>
  </table>

  <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Close</button>
           </div>

