<style>
  .show_table th{
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

 <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">{{$Driver->fullName}}</h2>
</div>


<form method="POST" action="{{ URL('/SaveResetPass')}}"    >
                       @csrf
    <table class="table m-0 show_table" style="width:10px!important;">
<input type="hidden" name="id" value="{{$id}}">
        <tr><TH>Password <font color="red">*</font></TH>
            <td>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" style="width:200px" name="password" required autocomplete="new-password">
            </td></tr>
        <tr><TH>Confirm Password <font color="red">*</font></TH>
            <td>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </td></tr>
    </table>

           <div class="w3-row">
                 <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Reset Password</button>
              </div>
</form>
           <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Cancel</button>
           </div>

