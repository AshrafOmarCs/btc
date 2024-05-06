<!-- <link href="http://localhost/mashaueer_noon/resources/layout/styles/layout.css " rel="stylesheet" type="text/css" media="all">
-->
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <title>Admin - Almashwar</title>
    <!-- <meta charset="utf-8"> -->
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-6">
        <META HTTP-EQUIV="Content-language" CONTENT="ar">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">

            <!-- <link href="http://localhost/mashaueer_noon/resources/ " rel="stylesheet" type="text/css" media="all"> -->
            <!-- Tell the browser to be responsive to screen width -->
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
            <link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
            <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
            <link rel="stylesheet" href="{{asset("/AdminLTE/css/_all-skins.min.css")}}">
            <link rel="stylesheet" href="{{asset("/AdminLTE/css/dataTables.bootstrap.min.css")}}">
            <!--<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">-->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
            <link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
            <link rel="stylesheet"
                  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
            <link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
            <link rel="stylesheet" href="{{asset("/AdminLTE/css/customize.css")}}">
            </head>

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
    @include('pages.messages')
<center>
<div style="font-size: 14px;"><b>
                {{$loan->fullName}}
              </b></div>

<form method="POST" action="{{ URL('/LoanPaidSave')}}"  enctype="multipart/form-data"  >
{{method_field("PUT")}}
                       @csrf

<br>
<table class="table m-0 show_table" style="width:10px!important;" >
<input name="loan_id" type="hidden" value="{{$id}}">
<!--<tr><TH>Paid Doc <font color="red">*</font></TH>
<td  style="white-space: nowrap;">
<input type="file" name="paid_image"  required>
</td>
 </tr>-->
  </table>
           <div class="w3-row">
                 <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Paid</button>
              </div>
</form>
           <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Cancel</button>
           </div>
