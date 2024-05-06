<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Almashwar</title>
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
    body {
        padding: 1.3rem 2.0rem !important;
    }
</style>
<style>
    .show_table th {
        background-color: #7CCBDC;
        white-space: nowrap;
        margin: 0 !important;
        border: solid 1px #535353 !important;
        text-align: center;
    }

    .show_table td {
        background-color: #ffffff;
        vertical-align: middle !important;
        border: solid 1px #535353 !important;
        text-align: center;
    }

    .hidden_row td {
        display: none;
        /* height: 0px; */
        background-color: #E6E6E6;
        border: solid 1px #ffffff !important;
    }

    td.master-control_open {
        background: url('{{asset("/AdminLTE/img/master_open.png")}}') no-repeat center center;
        cursor: pointer;
        background-color: #ffffff;
    }

    td.master-control_close {
        background: url('{{asset("/AdminLTE/img/master_close.png")}}') no-repeat center center;
        cursor: pointer;
        background-color: #ffffff;
    }
</style>
<table>
    <tr>
        <td style="font-size: 14px;font-weight: bold;">Packages_Backup Drivers</td>
    </tr>
</table>
<br><br>
<table class="table show_table" id="example" style="width:80%" align="center">
    <thead>
    <tr>
        <th>Warehouse</th>
        <th>Driver</th>
        <th>Job ID</th>
        <th>Days</th>
        <th>No_of_TP</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $No_of_TP = 0;
    $CO = 0
    ?>
    @foreach($master as $masterr)
        <tr>
            <td>{{$masterr->warehouseName}}</td>
            <td>{{$masterr->fullName}}</td>
            <td>{{$masterr->job_id}}</td>
            <td>{{$masterr->CO}}</td>
            <td>{{$masterr->No_of_TP}}</td>
        </tr>
        <?php
        $No_of_TP += $masterr->No_of_TP;
        $CO += $masterr->CO;
        ?>
    @endforeach
    <tr>
        <th colspan="3"><b>Total ALL</b></th>
        <th><b>{{$CO}}</b></th>
        <th><b>{{$No_of_TP}}</b></th>
    </tr>
    </tbody>
</table>
