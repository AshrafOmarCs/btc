
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

<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Users</h2>
</div>


<table class="table m-0 show_table" style="width:10px!important;">
 <tr><TH>Name</TH> <td>{{$Users->name}}</td></tr>
 <tr><TH>IdentityNo </TH><td>{{$Users->IdentityNo}}</td></tr>
 <tr><TH>Phone </TH><td>{{$Users->phone}}</td></tr>
 <tr><TH>User Type </TH><td>{{$Users->user_type_name}}</td></tr>
 <tr><TH>Status</TH> <td>{{$Users->active_status}}</td></tr>
 <tr><TH>Email </TH><td>{{$Users->email}}</td></tr>
 <tr><TH>Bank Name </TH><td>{{$Users->bank_name_en}}</td></tr>
 <tr><TH>Account Number </TH><td>{{$Users->account_Number}}</td></tr>

</table>
           <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Close</button>
           </div>

