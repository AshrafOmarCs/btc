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
    <div class="modal-body">
        <table class="table m-0 show_table">
        <input type="hidden" name="id" value="{{$id}}">
            <tr><TH>Password <font color="red">*</font></TH>
                <td>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" style="width:200px" name="password" required autocomplete="new-password">
                </td>
                <TH>Confirm Password <font color="red">*</font></TH>
                <td>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Reset Password</button>
    </div>
</form>

