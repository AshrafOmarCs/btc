<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BTC - @yield('title','Default Content')</title>
    <!--<link rel="icon" type="image/x-icon" href="https://cvh.uwu.mybluehost.me/AdminLTE/img/logo.jpg">-->
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
    <!--Rich text editor -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/plugins/richtexteditor/rte_theme_default.css")}}">
    <!--Rich text editor -->

    <!--Datatable -->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <style>
        .circle {
            width: 21px;
            height: 20px;
            border-radius: 50%;
            background-color: red;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    <!-- end of Datatable-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
@if(null !== request()->route('city_name'))
@yield('content')
@else
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="{{URL("/home")}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <img src="{{asset("/AdminLTE/img/logo.jpg")}}"
                 style="height: 40px;width: 40px;border-radius: 50%!important;padding: 0px!important;border: 1px solid #ccc;box-shadow: 0px 3px 5px #ccc;">
            <!-- logo for regular state and mobile devices -->
            <span style="vertical-align: middle!important;"><b>Bander</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            @if(AUTH::user()->id == '2' || AUTH::user()->id == '73')
                <span style="float: right; margin: 15px"><b>
                    @if (App::isLocale('en'))
                        <a style="color: black;" href="#" onclick="set_lang('ar')">العربية</a>
                    @elseif (App::isLocale('ar'))
                        <a style="color: black;" href="#" onclick="set_lang('en')">English</a>
                    @endif
                    </b>
                </span>
            @endif
            <!--<select style="float: right; margin: 15px" onchange="set_lang(this.value)">-->
            <!--    <option @if (App::isLocale('en')) selected @endif value="en">En</option>-->
            <!--    <option @if (App::isLocale('ar')) selected @endif value="ar">Ar</option>-->
            <!--</select>-->
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset("/AdminLTE/img/user2-160x160.jpg")}}" class="img-circle" alt="User Image">
                </div>
                @if (empty(Auth::user()))
                    <div class="pull-left info">
                        <p><a href="{{ route('login') }}" class="d-block">Login</a></p>
                    </div>
                @else
                    <div class="pull-left info">
                        <p>{{ Auth::user()->name }}</p>
                        <i class="fa fa-circle text-success"></i> {{__('nav.online')}}
                        <a href="{{ route('logout') }}"><img
                                src="{{asset("/AdminLTE/img/logout.jpg")}}" style="height:12px;width:60px"></a>

                    </div>
                @endif
            </div>
            <br>


            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="{{ request()->is('home') ? 'active' : '' }}"><a href="{{URL("/home")}}"><i
                            class="fa fa-dashboard"></i> <span>{{__('dashboard.dashboard')}}</span></a></li>
                @if(Auth::user()->id == 2 || Auth::user()->id == 73)
                <li class="{{ request()->is('Actions') ? 'active' : '' }}"><a
                        href="{{URL("/Actions")}}" style="display: flex;"><i class="fa fa-exclamation-triangle" style="margin-top: 4px;"></i>
                        <span>Required Actions</span> &nbsp;&nbsp; <span class="circle" style="background-color: </span>
                        </a></li>
                <li class="{{ request()->is('Logs') ? 'active' : '' }}"><a
                        href="{{URL("/Logs")}}"><i
                            class="fa fa-history"></i> <span>{{__('nav.system_logs')}}</span></a></li>
                @endif

                <li class="{{ request()->is('ChangePassword') ? 'active' : '' }}"><a
                        href="{{URL("/ChangePassword")}}"><i
                            class="fa fa-key"></i> <span>{{__('nav.change_password')}}</span></a></li>

                @if(Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 73 || Auth::user()->id == 18 || Auth::user()->id == 14 || Auth::user()->id == 98)
                    <li class="header">HR</li>
                    <li class="{{ request()->is('Properties/index') ? 'active' : '' }}">
                        <a href="{{URL("Properties/index")}}"><i class="fa fa-laptop"></i> <span>{{__('nav.properties')}}</span></a>
                    </li>
                    <!--<li class="treeview {{(request()->is('Properties*')) ? 'active' : '' }}">-->
                    <!--    <a href="#">-->
                    <!--        <i class="fa fa-edit"></i> <span>BTC Properties </span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>-->
                    <!--    </a>-->
                    <!--    <ul class="treeview-menu">-->
                    <!--        <li class="{{ request()->is('Properties/Property') ? 'active' : '' }}">-->
                    <!--            <a href="{{URL("Properties/Property")}}"><i class="fa fa-laptop"></i> <span>Properties</span></a>-->
                    <!--        </li>-->
                    <!--        <li class="{{ request()->is('Properties/PropertyIssuance') ? 'active' : '' }}">-->
                    <!--            <a href="{{URL("Properties/PropertyIssuance")}}"><i class="fa fa-tasks"></i> <span>Property Issuance</span></a>-->
                    <!--        </li>-->
                    <!--    </ul>-->
                    <!--</li>-->
                    <li class="{{ request()->is('ContractsQuotation') ? 'active' : '' }}">
                        <a href="{{URL("ContractsQuotation")}}"><i class="fa fa-file"></i> <span>{{__('nav.contracts_quotations')}}</span></a>
                    </li>
                    <li class="{{ request()->is('UploadDocuments') ? 'active' : '' }}"><a
                        href="{{URL("/UploadDocuments")}}"><i
                    class="fa fa-file-text-o"></i> <span>{{__('nav.upload_documents')}}</span></a></li>

                @endif
                <li class="header">{{__('nav.operations')}}</li>
                @if(Auth::user()->id == 73 || Auth::user()->id == 49 || Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 15 || Auth::user()->id == 96 || Auth::user()->id == 104 || Auth::user()->id == 98)
                    <li class="{{ request()->is('automation*') ? 'active' : '' }}"><a
                    href="{{URL("/automation")}}"><i
                        class="fa fa-money"></i> <span>{{__('nav.finance_operations')}}</span></a></li>
                    <li class="{{ request()->is('union*') ? 'active' : '' }}"><a
                    href="{{URL("/union")}}"><i
                        class="fa fa-compress"></i> <span>{{__('nav.union')}}</span></a></li>

                @endif
                @if(Auth::user()->id == 86)
                    <li class="{{ request()->is('DriversJahiz') ? 'active' : '' }}">
                        <a href="{{URL("/DriversJahiz")}}"><i class="fa fa-automobile"></i> <span>{{__('nav.drivers_jahiz')}}</span></a>
                    </li>
                @else
                    @if(session('Read_1')==1)
                        <li class="{{ request()->is('UsersRole') ? 'active' : '' }}"><a href="{{URL("/UsersRole")}}"><i
                                    class="fa fa-user"></i> <span>{{__('nav.users_role')}}</span></a></li>
                    @endif
                    @if(session('Read_2')==1)
                        <li class="{{ request()->is('Users') ? 'active' : '' }}"><a href="{{URL("/Users")}}"><i
                                    class="fa fa-user"></i> <span>{{__('nav.bander_users')}}</span></a></li>
                    @endif
                    @if(session('Read_3')==1)
                        <li class="{{ request()->is('Supervisors') ? 'active' : '' }}"><a
                                href="{{URL("/Supervisors")}}"><i
                                    class="fa fa-user"></i> <span>{{__('nav.supervisors_areaManager')}}</span></a></li>
                    @endif
                    <!--It's Muhammad start-->

                        <li class="{{ request()->is('Documents') ? 'active' : '' }}"><a
                                href="{{URL("/Documents")}}"><i
                                    class="fa fa-file-text-o"></i> <span>{{__('nav.documents')}}</span></a></li>

                    <!--It's Muhammad close-->
                    @if(session('Read_4')==1)
                        <li class="{{ request()->is('Warehouses') ? 'active' : '' }}"><a
                                href="{{URL("/Warehouses")}}"><i
                                    class="fa fa-home"></i> <span>{{__('nav.warehouses')}}</span></a></li>
                    @endif
                    @if(session('Read_4')==1)
                        <li class="{{ request()->is('Company') ? 'active' : '' }}"><a
                                href="{{URL("/Company")}}"><i
                                    class="fa fa-building"></i> <span>{{__('nav.companies')}}</span></a></li>
                    @endif
                    @if(session('Read_4')==1)
                        <li class="{{ request()->is('bank') ? 'active' : '' }}"><a
                                href="{{URL("/bank")}}"><i
                                    class="fa fa-university"></i> <span>{{__('nav.banks')}}</span></a></li>
                    @endif

                    @if(session('Read_5')==1)
                        <li class="{{ request()->is('Drivers') ? 'active' : '' }}"><a href="{{URL("/Drivers")}}"><i
                                    class="fa fa-automobile"></i> <span>{{__('nav.drivers')}}</span></a></li>
                    @endif
                    <!--It's Muhammad start -->

                    <li class="{{ request()->is('DriversAttendance') ? 'active' : '' }}"><a
                                href="{{URL("/DriversAttendance")}}"><i
                                    class="fa fa-clock-o"></i> <span>{{__('nav.drivers_attendance')}}</span></a></li>


                    <!-- It's Muhammad close-->


                    @if(session('Read_6')==1)
                        <li class="{{ request()->is('DriversJahiz') ? 'active' : '' }}">
                            <a href="{{URL("/DriversJahiz")}}"><i class="fa fa-automobile"></i> <span>{{__('nav.drivers_jahiz')}}</span></a>
                        </li>
                        <!-- <li class="{{ request()->is('DriversJahiz/import') ? 'active' : '' }}">
                            <a href="{{URL("/DriversJahiz/import")}}"><i class="fa fa-automobile"></i> <span>Import SANAD Clearing</span></a>
                        </li> -->
                    @endif
                    @if(session('Read_7')==1)
                        <li class="{{ request()->is('DriversJahizClearing') ? 'active' : '' }}"><a
                                href="{{URL("/DriversJahizClearing")}}"><i
                                    class="fa fa-automobile"></i> <span>{{__('nav.bander_clearing')}}</span></a></li>
                    @endif
                    @if(session('Read_29')==1)
                        <li class="{{ request()->is('DriversSANEDClearing') ? 'active' : '' }}"><a
                                href="{{URL("/DriversSANEDClearing")}}"><i
                                    class="fa fa-automobile"></i> <span>{{__('nav.SANED_clearing')}}</span></a></li>
                    @endif
                    @if(session('Read_35')==1)
                        <li class="{{ request()->is('DriversChefzClearing') ? 'active' : '' }}"><a
                                href="{{URL("/DriversChefzClearing")}}"><i
                                    class="fa fa-automobile"></i> <span>{{__('nav.Chefz_clearing')}}</span></a></li>
                    @endif
                    @if(session('Read_27')==1)
                        <li class="{{ request()->is('DriversJahizClaim') ? 'active' : '' }}"><a
                                href="{{URL("/DriversJahizClaim")}}"><i
                                    class="fa fa-automobile"></i> <span>{{__('nav.jahiz_claim')}}</span></a></li>
                    @endif

                    @if(session('Session_DriversCarrefour') == 'yes')
                        <!--<li class="{{ request()->is('DriversAttend') ? 'active' : '' }}"><a-->
                        <!--        href="{{URL("/DriversAttend")}}"><i class="fa fa-map-signs"></i>-->
                        <!--        <span>Drivers Attendance</span></a></li>-->
                    @endif
                    @if (Auth::user()->id == 15 || Auth::user()->id == 39)
                        <li class="treeview {{(request()->is('import_excel*')||request()->is('import_excel_zajil*')) ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>{{__('nav.import_excel_files')}}</span>
                                <span class="pull-right-container"><i
                                        class="fa fa-angle-left pull-right"></i></span></a>
                            <ul class="treeview-menu">
                                    <!-- <li class="{{ request()->is('I-Mile/Manthly-report') ? 'active' : '' }}"><a-->
                                    <!--        href="{{URL("/I-Mile/Manthly-report")}}"><i class="fa fa-ravelry"></i>-->
                                    <!--        <span>{{__('nav.salary_shipment_report')}}</span></a>-->
                                    <!--</li>-->
                            </ul>
                        </li>
                    @endif

                    @if(session('Read_8')==1 || session('Read_9')==1)
                        <!--<li class="treeview {{(request()->is('import_excel*')||request()->is('import_excel_zajil*')) ? 'active' : '' }}">-->
                        <!--    <a href="#">-->
                        <!--        <i class="fa fa-edit"></i> <span>{{__('nav.import_excel_files')}}</span>-->
                        <!--        <span class="pull-right-container"><i-->
                        <!--                class="fa fa-angle-left pull-right"></i></span></a>-->


                            <!--<ul class="treeview-menu">-->
                            @if(session('Read_9')==1)
                                    <!--<li class="{{ request()->is('import_excel_zajil') ? 'active' : '' }}">-->
                                    <!--    <a href="{{URL("/import_excel_zajil")}}"><i class="fa fa-circle-o"></i><span>{{__('nav.zajil')}}</span></a>-->
                                    <!--</li>-->
                                @endif
                                @if(session('Read_8')==1)
                                    <!--<li class="{{ request()->is('import_excel') ? 'active' : '' }}"><a-->
                                    <!--        href="{{URL("/import_excel")}}"><i class="fa fa-ravelry"></i>-->
                                    <!--        <span>Noon</span></a>-->
                                    <!--</li>-->

                                    <!--<li class="{{ request()->is('import_excel/noon') ? 'active' : '' }}"><a-->
                                    <!--        href="{{URL("/import_excel/noon")}}"><i class="fa fa-ravelry"></i>-->
                                    <!--        <span>Noon invoice </span></a>-->
                                    <!--</li>-->
                                    <!--<li class="{{ request()->is('import_excel/General-invoices') ? 'active' : '' }}"><a-->
                                    <!--         href="{{URL("/import_excel/General-invoices")}}"><i class="fa fa-ravelry"></i> -->
                                    <!--        <span> {{__('nav.general_invoices')}}</span></a>-->
                                    <!--</li>-->

                                    <!-- <li class="{{ request()->is('I-Mile/Manthly-report') ? 'active' : '' }}"><a-->
                                    <!--        href="{{URL("/I-Mile/Manthly-report")}}"><i class="fa fa-ravelry"></i>-->
                                    <!--        <span>{{__('nav.salary_shipment_report')}}</span></a>-->
                                    <!--</li>-->

                                    @if(session('Read_9')==1)
                                        <!--<li class="{{ request()->is('Import_DA_Dailyload') ? 'active' : '' }}">-->
                                        <!--    <a href="{{URL("/Import_DA_Dailyload/step/initialize")}}"><i class="fa fa-circle-o"></i><span>{{__('nav.import_DA_dailyload')}}</span></a>-->
                                        <!--</li>-->
                                    @endif

                                    <!--<li class="{{ request()->is('import_excel') ? 'active' : '' }}"><a-->
                                    <!--        href="{{URL("/import_excel")}}"><i class="fa fa-ravelry"></i>-->
                                    <!--        <span>Carrefour monthly</span></a>-->
                                    <!--</li>-->

                                @endif

                        <!--    </ul>-->
                        <!--</li>-->
                    @endif
                    @if(session('Read_10')==1)
                        <li class="{{ request()->is('Packages') ? 'active' : '' }}"><a href="{{URL("/Packages")}}"><i
                                    class="fa fa-briefcase"></i> <span>{{__('nav.packages')}}</span></a></li>
                    @endif

                    @if(session('Read_11')==1|| session('Read_12')==1||session('Read_13')==1||session('Read_14')==1)
                        <li class="header">{{__('nav.tracking')}}</li>
                    @endif

                    @if(session('Read_11')==1)
                        <li class="{{ request()->is('GoogleMap') ? 'active' : '' }}"><a href="{{URL("/GoogleMap")}}"><i
                                    class="fa fa-map"></i> <span>{{__('nav.google_map')}}</span></a></li>
                    @endif
                    @if(session('Read_12')==1)
                        <li class="{{ request()->is('GoogleMapTrack') ? 'active' : '' }}"><a
                                href="{{URL("/GoogleMapTrack")}}"><i class="fa fa-map-marker"></i>
                                <span>{{__('nav.google_map_track')}}</span></a>
                        </li>
                    @endif
                    @if(session('Read_13')==1)
                        <li class="{{ request()->is('GoogleMapAttend') ? 'active' : '' }}"><a
                                href="{{URL("/GoogleMapAttend")}}"><i class="fa fa-map-signs"></i>
                                <span>{{__('nav.supervisors_attendance')}}</span></a></li>
                    @endif
                    @if(session('Read_14')==1)
                        <li class="{{ request()->is('GoogleMapUser') ? 'active' : '' }}"><a
                                href="{{URL("/GoogleMapUser")}}"><i
                                    class="fa fa-map-pin"></i>
                                <span>{{__('nav.supervisors_attendance')}}</span></a></li>
                    @endif


                    <li class="header">{{__('nav.accounts')}}</li>
                    @if(session('Read_15')==1)
                        <li class="treeview {{(request()->is('import_excel*')||request()->is('import_excel_zajil*')) ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>{{__('nav.loans')}}</span>
                                <span class="pull-right-container"><i
                                        class="fa fa-angle-left pull-right"></i></span></a>

                            <ul class="treeview-menu">
                                    <li class="{{ request()->is('Loans') ? 'active' : '' }}"><a href="{{URL("/Loans")}}"><i class="fa fa-money"></i> <span>{{__('nav.loans')}}</span></a></li>
                                    <li class="{{ request()->is('Fuel-Loans') ? 'active' : '' }}"><a href="{{URL("/Fuel-Loans")}}"><i class="fa fa-ravelry"></i>
                                        <span>{{__('nav.loans_fuel')}} </span></a>
                                    </li>
                            </ul>
                        </li>

                    @endif

                    @if(session('Read_16')==1)
                        <li class="{{ request()->is('Journal') ? 'active' : '' }}"><a href="{{URL("/Journal")}}"><i
                                    class="fa fa-book"></i> <span>{{__('nav.journal')}}</span></a></li>
                        <li class="{{ request()->is('import-excel') ? 'active' : '' }}"><a href="{{URL("/import-excel")}}"><i
                                    class="fa fa-book"></i> <span>{{__('nav.import_to_journal')}}</span></a></li>

                    @endif
                    @if(session('Read_16')==1)
                        <li class="treeview {{(request()->is('Vehicles*')||request()->is('import_excel_zajil*')) ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>{{__('nav.vehicles')}} </span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                    <li class="{{ request()->is('Vehicles/Vehicles-Requests') ? 'active' : '' }}"><a href="{{URL("/Vehicles/Vehicles-Requests")}}"><i class="fa fa-money"></i> <span>{{__('nav.vehicles_requests')}}</span></a></li>
                                    <li class="{{ request()->is('Vehicles') ? 'active' : '' }}"><a href="{{URL("/Vehicles")}}"><i class="fa fa-money"></i> <span>{{__('nav.delegations')}}</span></a></li>
                                    <li class="{{ request()->is('Vehicles') ? 'active' : '' }}"><a href="{{URL("/Vehicles")}}"><i class="fa fa-money"></i> <span>{{__('nav.maintenance')}}</span></a></li>
                                    <li class="{{ request()->is('Vehicles') ? 'active' : '' }}"><a href="{{URL("/Vehicles")}}"><i class="fa fa-money"></i> <span>{{__('nav.vehicles_list')}}</span></a></li>
                                    <li class="{{ request()->is('Vehicles/Report') ? 'active' : '' }}"><a href="{{URL("/Vehicles/Report")}}"><i class="fa fa-money"></i> <span>{{__('nav.vehicles_report')}}</span></a></li>
                                    <li class="{{ request()->is('Vehicles/VehicleFuelSave') ? 'active' : '' }}"><a href="{{URL("/Vehicles/VehicleFuelSave")}}"><i class="fa fa-money"></i> <span>{{__('nav.vehicle_fuel_save')}}</span></a></li>
                                    <li class="{{ request()->is('Vehicles/VehicleOilSave') ? 'active' : '' }}"><a href="{{URL("/Vehicles/VehicleOilSave")}}"><i class="fa fa-money"></i> <span>{{__('nav.vehicle_oil_save')}}</span></a></li>

                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->id == 30 )
                        <li class="{{ request()->is('Vehicles') ? 'active' : '' }}"><a href="{{URL("/Vehicles")}}"><i class="fa fa-money"></i> <span>{{__('nav.vehicles_list')}}</span></a></li>
                    @endif
                    @if(session('Read_17')==1 || Auth::user()->id == 20 || Auth::user()->id == 90)
                        <li class="treeview {{(request()->is('ClaimsDeduction*')) ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>{{__('nav.sync_claims')}} </span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                    <li class="{{ request()->is('ClaimsDeduction') ? 'active' : '' }}"><a href="{{URL("/ClaimsDeduction")}}"><i class="fa fa-money"></i> <span>{{__('nav.claims_deduction')}}</span></a></li>
                                    <li class="{{ request()->is('ClaimsDeduction/SyncJahiz') ? 'active' : '' }}"><a href="{{URL("/ClaimsDeduction/SyncJahiz")}}"><i class="fa fa-money"></i> <span>{{__('nav.jahiz_sync_claims')}}</span></a></li>
                                </li>
                            </ul>
                        </li>

                    @endif

                    @if(session('Read_17')==1 )

                        <li class="{{ request()->is('Salary') ? 'active' : '' }}"><a href="{{URL("/Salary")}}"><i
                                    class="fa fa-money"></i> <span>{{__('nav.salary')}}</span></a></li>
                        <li class="{{ request()->is('Unpaid-Salary') ? 'active' : '' }}"><a href="{{URL("/Unpaid-Salary")}}"><i
                                    class="fa fa-money"></i> <span>{{__('nav.unpaid_salary')}}</span></a></li>
                    @endif
                    <!-- Ashraf History-->
                    @if(Auth::user()->user_type_id==1)
                        <li class="{{ request()->is('Transaction-History') ? 'active' : '' }}"><a href="{{URL("/Transaction-History")}}"><i
                            class="fa fa-money"></i> <span>{{__('nav.transactions_history')}}</span></a></li>
                    @endif


                        <!--<li class="{{ request()->is('Loans-Transaction-History') ? 'active' : '' }}"><a href="{{URL("/Loans-Transaction-History")}}"><i-->
                        <!--    class="fa fa-money"></i> <span>Loans Transactions History</span></a></li>-->

                        <!--<li class="{{ request()->is('Jahiz-Transaction-History') ? 'active' : '' }}"><a href="{{URL("/Jahiz-Transaction-History")}}"><i-->
                        <!--    class="fa fa-money"></i> <span>Jahiz Transactions History</span></a></li>-->
                    <!-- end of -->

                    @if(session('Read_18')==1)
                        <li class="{{ request()->is('CreditNotes') ? 'active' : '' }}"><a
                                href="{{URL("/CreditNotes")}}"><i
                                    class="fa fa-bookmark"></i> <span>{{__('nav.creditNotes')}}</span></a></li>
                    @endif


                    @if(session('Read_19')==1)
                        <li class="{{ request()->is('Settlements') ? 'active' : '' }}"><a
                                href="{{URL("/Settlements")}}"><i
                                    class="fa fa-money"></i> <span>{{__('nav.settlements')}}</span></a></li>
                    @endif
                    @if(session('Read_20')==1)
                        <li class="{{ request()->is('Attendance') ? 'active' : '' }}"><a
                                href="{{URL("/Attendance")}}"><i
                                    class="fa fa-address-card"></i> <span>{{__('nav.attendance')}}</span></a></li>
                    @endif
                    @if(session('Read_36')==1 || session('Session_DriversCarrefour') == 'yes')
                        <li class="{{ request()->is('AttendanceDrivers') ? 'active' : '' }}"><a
                                href="{{URL("/AttendanceDrivers")}}"><i
                                    class="fa fa-address-card"></i> <span>{{__('nav.report_drivers_attendance')}} </span></a></li>
                    @endif
                    @if(session('Read_21')==1)
                        <li class="{{ request()->is('Clearance') ? 'active' : '' }}"><a href="{{URL("/Clearance")}}"><i
                                    class="fa fa-clipboard"></i>
                                <span>{{__('nav.clearance')}}</span></a></li>
                    @endif
                    @if(session('Read_22')==1)
                        <li class="{{ request()->is('driverInvoices') ? 'active' : '' }}"><a
                                href="{{URL("/driverInvoices")}}"><i
                                    class="fa fa-file-excel-o"></i>
                                <span>{{__('nav.diver_invoices_supervisors')}}</span></a></li>
                    @endif
                    @if(session('Read_23')==1)
                        <li class="{{ request()->is('ExportInvoice') ? 'active' : '' }}"><a
                                href="{{URL("/ExportInvoice")}}"><i
                                    class="fa fa-file-excel-o"></i>
                                <span>{{__('nav.export_invoice')}}</span></a></li>
                    @endif
                    @if(session('Read_19') == 1)
                        <li class="treeview {{(request()->is('import_excel*')||request()->is('import_excel_zajil*')) ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>{{__('nav.utilities')}}</span>
                                <span class="pull-right-container"><i
                                        class="fa fa-angle-left pull-right"></i></span></a>


                            <ul class="treeview-menu">
                                    <li class="{{ request()->is('Landmark') ? 'active' : '' }}">
                                        <a href="{{URL("/Landmark")}}"><i class="fa fa-money">
                                            </i> <span>{{__('nav.landmark')}}</span>
                                        </a>
                                    </li>
                            </ul>
                        </li>
                    @endif
                    @if(session('Read_24')==1|| session('Read_25')==1|| session('Read_31')==1||session('Read_33')==1||session('Read_39')==1)
                        <li class="treeview {{(request()->is('Report_Loan*')||request()->is('Report_Salary*')||request()->is('Report_Attachment*')||request()->is('Report_Jahiz*')||request()->is('Report_Claim*')) ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>{{__('nav.reports')}}</span>
                                <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                @if(session('Read_24')==1)
                                    <li class="{{ request()->is('Report_Loan') ? 'active' : '' }}"><a
                                            href="{{URL("/Report_Loan")}}"><i class="fa fa-circle-o"></i>
                                            <span>{{__('nav.loan_report')}}</span></a></li>
                                @endif
                                @if(session('Read_25')==1)
                                    <li class="{{ request()->is('Report_Salary') ? 'active' : '' }}"><a
                                            href="{{URL("/Report_Salary")}}"><i class="fa fa-circle-o"></i>
                                            <span>{{__('nav.salary_report')}}</span></a></li>
                                @endif
                                @if(session('Read_31')==1)
                                    <li class="{{ request()->is('Report_Attachment') ? 'active' : '' }}"><a
                                            href="{{URL("/Report_Attachment")}}"><i class="fa fa-circle-o"></i>
                                            <span>{{__('nav.attachments_report')}}</span></a></li>
                                @endif
                                @if(session('Read_33')==1)
                                    <li class="{{ request()->is('Report_Jahiz') ? 'active' : '' }}"><a
                                            href="{{URL("/Report_Jahiz")}}"><i class="fa fa-circle-o"></i>
                                            <span>{{__('nav.jahiz_report')}}</span></a></li>
                                @endif
                                @if(session('Read_39')==1)
                                    <li class="{{ request()->is('Report_Claim') ? 'active' : '' }}"><a
                                            href="{{URL("/Report_Claim")}}"><i class="fa fa-circle-o"></i>
                                            <span>{{__('nav.claim_report')}}</span></a></li>
                                @endif
                            </ul>
                        </li>

                    @endif

                    @if(session('Read_26')==1)
                        <li class="header">{{__('nav.administration')}}</li>
                        <li class="{{ request()->is('versionControl') ? 'active' : '' }}"><a
                                href="{{URL("/versionControl")}}"><i
                                    class="fa fa-mobile"></i> <span>{{__('nav.version_control')}}</span></a></li>
                    @endif
                    <li class="header">{{__('nav.SANED')}}</li>

                    @if(session('Read_30')==1)
                        <li class="{{ request()->is('SANEDPaid') ? 'active' : '' }}"><a
                                href="{{URL("/SANEDPaid")}}"><i
                                    class="fa fa-mobile"></i> <span>{{__('nav.SANED_paid')}}</span></a></li>
                    @endif

                    @if(session('Read_34')==1)
                        <li class="{{ request()->is('ChefzImportInvoice') ? 'active' : '' }}"><a
                                href="{{URL("/ChefzImportInvoice")}}"><i
                                    class="fa fa-mobile"></i> <span>{{__('nav.chefz_import_invoice')}}</span></a></li>
                    @endif
                    @if(session('Read_37')==1)
                        <li class="{{ request()->is('LoansPaid') ? 'active' : '' }}"><a
                                href="{{URL("/LoansPaid")}}"><i
                                    class="fa fa-mobile"></i> <span>{{__('nav.loans_paid')}}</span></a></li>
                    @endif
                    @if(session('Read_38')==1)
                        <li class="{{ request()->is('SalaryPaid') ? 'active' : '' }}"><a
                                href="{{URL("/SalaryPaid")}}"><i
                                    class="fa fa-mobile"></i> <span>{{__('nav.salary_paid')}}</span></a></li>
                    @endif
                @endif
            </ul>

        </section>
        <!-- /.sidebar -->
    </aside>


    <div class="content-wrapper" style="padding:5px">
        <!-- Content Header (Page header) -->


    @include('pages.loader')
    @include('pages.messages')
    @yield('content')
    <!-- /.content -->
    </div>
    <!---Foter-------------------------------------------------------------------------------------------------------->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Bander</b>
        </div>
        <strong>Copyright &copy; 2021 Bander Company.</strong> All rights
        reserved.
    </footer>

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
@endif
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
<!-- RichTextEditor -->
<script src="{{asset("/AdminLTE/plugins/richtexteditor/rte.js")}}"></script>
<script src="{{asset("/AdminLTE/plugins/richtexteditor/plugins/all_plugins.js")}}"></script>
<!-- RichTextEditor -->

<!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>-->

<script>
    function set_lang(lang) {
        window.location.href = '/lang/'+lang;
    }
</script>

