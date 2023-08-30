@extends('AdminLTE')
@section('content')
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


<table style=" width:100%;margin-top: 5px;margin-left: 20px;">
    <tr>
        <td style="width:100%;font-size: 14px;font-weight: bold;text-align: center">{{$User->name}}</td>
    </tr>
</table>

<form  method="POST"  action="{{ URL('/ChangePasswordSave')}}"    >
                       @csrf
    <table class="table m-0 show_table" style="width:10px!important;">
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
                 <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Change Password</button>
              </div>
</form>


@endsection
