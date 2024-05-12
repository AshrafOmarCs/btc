<!-- <link href="http://localhost/mashaueer_noon/resources/layout/styles/layout.css " rel="stylesheet" type="text/css" media="all">
-->
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Bander</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/bootstrap.min.css")}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/font-awesome/font-awesome.min.css")}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/ionicons.min.css")}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/bootstrap-daterangepicker/daterangepicker.css")}}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
          href="{{asset("/AdminLTE/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")}}">
    <!-- Theme style -->
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/plugins/iCheck/all.css")}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/_all-skins.min.css")}}">
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/dataTables.bootstrap.css")}}">
    <!--<link href="https://datatables.yajrabox.com/css/datatables.bootstrap.css" rel="stylesheet">-->
    <!--<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/w3.css")}}">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/customize.css")}}">
</head>
<style>
    .show_table th {
        padding-left: 20px !important;
        white-space: nowrap;
        border: none !important;
        margin: 0 !important;
    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
    }
</style>
@include('pages.messages')
<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
        style="width:100%;font-size: 14px;font-weight: bold;">Loans</h2>
</div>

<form method="POST" action="{{ route('Loans.update',$Loans->id)}}">
    {{method_field("PATCH")}}
    @csrf

    <table>
        <tr>
            <td style="vertical-align: top !important;">
                <table class="table m-0 show_table" style="width:10px!important;">
                    <tr>
                        <TH>Driver <font color="red">*</font></TH>
                        <td style="white-space: nowrap;">
                            <input name="driverId" id="driverId" type="hidden" value="{{$Loans->driverId}}">
                            <table style="padding: 0px 0px; !important;">
                                <tr>
                                    <td>
                                        <input class="form-control" name="driverId_input"
                                               id="driverId_input" style="width:230px" type="text"
                                               value="{{$Loans->fullName}}" required data-readonly>
                                    </td>
                                    <td>
                                        <button onclick="driver_window();" type="button"
                                                class="btn btn-primary btn-sm">Select
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <Tr>
                        <TH colspan=2 id="balance">
                            <table>
                                <tr>
                                    <TH>Perivious Balance:</TH>
                                    <td><font color=red>{{$Loans->per_priod}}</font> ({{$Loans->per_range}})
                                    <td>
                                </tr>
                                <tr>
                                    <TH style='text-align: right;'>Current Balance:</TH>
                                    <td><font color=red>{{$Loans->cur_priod}}</font> ({{$Loans->cur_range}})
                                    <td>
                                </tr>
                            </table>

                        </TH>
                    </tr>
                    <tr>
                        <TH>journal Date <font color="red">*</font></TH>
                        <td>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" name="journal_date"
                                       placeholder="dd/mm/yyyy" id="journal_date" value="{{$Loans->journal_date}}"
                                       required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <TH>Amount <font color="red">*</font></TH>
                        <td><input type="text" class="form-control" name="amount" value="{{$Loans->amount}}"
                                   required></td>
                    </tr>
                    <tr>
                        <TH>Note <font color="red">*</font></TH>
                        <td><textarea name="note" class="form-control" rows=5 required>{{$Loans->note}} </textarea>
                        </td>
                    </tr>
                    </td>
                    </tr>
                    <tr>
                        <TH>Status<font color="red">*</font></TH>
                        <td>
                            <select id="status_id" name="status_id" class="form-control" required>
                                <option value=""></option>
                                @foreach($lkp_loan_status as $lkp_loan_statuss)
                                    <option value="{{$lkp_loan_statuss->id}}"
                                            @if ($Loans->status_id==$lkp_loan_statuss->id){{"  selected " }}:null @endif>{{$lkp_loan_statuss->loan_status}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Update</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button onclick="window.close()" type="button" class="w3-btn w3-red">Close</button>
</div>
<script>
    function driver_window() {
        myWindow1 = window.open("{{URL("/DriverWindow")}}", "",
            "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
    }

    $(function () {
        $('#journal_date').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            autoHide: true,
            zIndex: 9999,
        });
    });
</script>


<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="{{asset("/AdminLTE/js/jquery.min.js")}}"></script>
<script src="{{asset("/AdminLTE/js/select2.full.min.js")}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset("/AdminLTE/js/bootstrap.min.js")}}"></script>
<!-- date-range-picker -->
<script src="{{asset("/AdminLTE/moment/min/moment.min.js")}}"></script>
<script src="{{asset("/AdminLTE/bootstrap-daterangepicker/daterangepicker.js")}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset("/AdminLTE/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")}}"></script>
<script src="{{asset("/AdminLTE/js/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/AdminLTE/js/dataTables.bootstrap.min.js")}}"></script>
<!--<script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>-->
<script src="{{asset("/AdminLTE/js/dataTables.buttons.min.js")}}"></script>
<script src="{{asset("/AdminLTE/js/buttons.html5.js")}}"></script>
<script src="{{asset("/AdminLTE/js/jszip.min.js")}}"></script>
<!-- FastClick -->
<script src="{{asset("/AdminLTE/js/fastclick.js")}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset("/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("/AdminLTE/js/adminlte.min.js")}}"></script>
