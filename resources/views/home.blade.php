@extends('AdminLTE')

{{--@if (session('status'))--}}
{{--    <div class="alert alert-success" role="alert">--}}
{{--        {{ session('status') }}--}}
{{--    </div>--}}
{{--@endif--}}

{{--You are logged in!--}}


@section('content')






        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small> <u>( <b>V:</b> {{ $app_version->version }} | <b>VC:</b> {{ $app_version->versionCode }}  ) </u></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        @if(Auth::user()->user_type_id==1)
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>{{ $totalUsers[0]->totalDrivers }}</h3>
                            <p>Total Drivers</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="#" class="small-box-footer"> &nbsp;</a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>{{ $totalUsers[0]->totalSupervisors }}<sup style="font-size: 20px"></sup></h3>
                            <p>Total Supervisors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="#" class="small-box-footer"> &nbsp;</a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>{{ $totalUsers[0]->totalAreaManagers }}</h3>
                            <p>Total Area Manager</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="#" class="small-box-footer"> &nbsp;</a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>{{ $totalUsers[0]->totalAdmins }}</h3>
                            <p>Total Admins</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="#" class="small-box-footer"> &nbsp;</a>
                    </div>
                </div><!-- ./col -->
            </div><!-- /.row -->
            @endif

            <h2 class="page-header"><img class="img-circle" src="{{ asset('/AdminLTE/img/drivers.png') }}" alt="User Avatar" style="width: 80px; height: 80px;">Vehicles Details <small > (in this portion Vehicles details are mentioned with Statuses)</small></h2>
            
            
            @if($totalUsers[0]->totalVehicles != 0)
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="ion ion-android-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Vehicles</span>
                            <span style="float: left" class="info-box-number">{{ $totalUsers[0]->totalVehicles }}</span>

                            <br><br><a href="#" onclick="vehicleInfo('total', 'Total Vehicles')"> view info</a>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                @if(Auth::user()->user_type_id==1)
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-android-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Available/Idol Vehicles</span>
                            <span style="float: left" class="info-box-number">{{ $totalUsers[0]->totalVehiclesAvailable }}</span>
                            <span style="float: right" class="info-box-number">{{ round(($totalUsers[0]->totalVehiclesAvailable / $totalUsers[0]->totalVehicles) * 100, 2) }}%</span>

                            <br><br><a href="#" onclick="vehicleInfo('available', 'Available/Idol Vehicles')"> view info</a>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                @endif
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-android-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" title="Vehicles Done Attendance">Vehicles Done Attendance</span>
                            <span style="float: left" class="info-box-number">{{ $delegatedAttendanceVehicles }}</span>
                            <span style="float: right" class="info-box-number">{{ round(($delegatedAttendanceVehicles / $totalUsers[0]->totalVehicles) * 100, 2) }}%</span>

                            <br><br><a href="#" onclick="vehicleInfo('done_attendance', 'Vehicles Done Attendance')"> view info</a>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-android-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" title="Vehicles Pending Attendance">Vehicles Pending Attendance</span>
                            <span style="float: left" class="info-box-number">{{ $delegatedNoAttendanceVehicles }}</span>
                            <span style="float: right" class="info-box-number">{{ round(($delegatedNoAttendanceVehicles / $totalUsers[0]->totalVehicles) * 100, 2) }}%</span>

                            <br><br><a href="#" onclick="vehicleInfo('pending_attendance', 'Vehicles Pending Attendance')"> view info</a>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon" style="background-color: #319931 !important;"><i class="ion ion-android-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" title="Total Present Vehicles">Total Present Vehicles</span>
                            <span style="float: left" class="info-box-number">{{ $delegatedAttendanceVehicles - ($delegatedAttendanceExcuseVehicles + $delegatedAttendanceNoExcuseVehicles) }}</span>
                            <span style="float: right" class="info-box-number">{{ round((($delegatedAttendanceVehicles - ($delegatedAttendanceExcuseVehicles + $delegatedAttendanceNoExcuseVehicles)) / $totalUsers[0]->totalVehicles) * 100, 2) }}%</span>

                            <br><br><a href="#" onclick="vehicleInfo('present', 'Total Present Vehicles')"> view info</a>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon " style="background-color: #c67e7e !important;"><i class="ion ion-android-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" title="Absent with Excuse">Absent with Excuse</span>
                            <span style="float: left" class="info-box-number">{{ $delegatedAttendanceExcuseVehicles }}</span>
                            <span style="float: right" class="info-box-number">{{ round(($delegatedAttendanceExcuseVehicles / $totalUsers[0]->totalVehicles) * 100, 2) }}%</span>

                            <br><br><a href="#" onclick="vehicleInfo('absent_ex', 'Absent with Excuse')"> view info</a>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-black"><i class="ion ion-android-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" title="Absent with No Excuse">Absent with No Excuse</span>
                            <span style="float: left" class="info-box-number">{{ $delegatedAttendanceNoExcuseVehicles }}</span>
                            <span style="float: right" class="info-box-number">{{ round(($delegatedAttendanceNoExcuseVehicles / $totalUsers[0]->totalVehicles) * 100, 2) }}%</span>

                            <br><br><a href="#" onclick="vehicleInfo('absent_no_ex', 'Absent with No Excuse')"> view info</a>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                @if(Auth::user()->user_type_id!=1)
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellowgreen" ><i class="ion ion-android-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" title="Vehicles in Maintenance">Vehicles in Maintenance</span>
                            <span style="float: left" class="info-box-number">{{ $maintenanceVehicles }}</span>
                            <span style="float: right" class="info-box-number">{{ round(($maintenanceVehicles / $totalUsers[0]->totalVehicles) * 100, 2) }}%</span>
                            <br><br><a href="#" onclick="vehicleInfo('maintenance_', 'Vehicles in Maintenance')"> view info</a>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                @endif
                @if(Auth::user()->user_type_id==1)
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellowgreen" ><i class="ion ion-android-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" title="Vehicles in Maintenance">Vehicles in Maintenance</span>
                            <span style="float: left" class="info-box-number">{{ $totalUsers[0]->maintenanceVehicles }}</span>
                            <span style="float: right" class="info-box-number">{{ round(($totalUsers[0]->maintenanceVehicles / $totalUsers[0]->totalVehicles) * 100, 2) }}%</span>

                            <br><br><a href="#" onclick="vehicleInfo('maintenance', 'Vehicles in Maintenance')"> view info</a>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-darkred" style="background-color: darkred !important;"><i class="ion ion-android-car"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" title="Damaged Vehicles">Damaged Vehicles</span>
                            <span style="float: left" class="info-box-number">{{ $totalUsers[0]->damgedVehicles }}</span>
                            <span style="float: right" class="info-box-number">{{ round(($totalUsers[0]->damgedVehicles / $totalUsers[0]->totalVehicles) * 100, 2) }}%</span><br><br>
                            <a href="#" onclick="vehicleInfo('damaged', 'Damaged Vehicles')"> view info</a>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                @endif
            </div>
            @endif
            <h2 class="page-header"><img class="img-circle" src="{{ asset('/AdminLTE/img/drivers.png') }}" alt="User Avatar" style="width: 80px; height: 80px;">Drivers Details <small > (in this portion Driver details are mentioned with Statuses)</small></h2>





            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-person"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Active Drivers</span>
                            <span class="info-box-number">{{ $totalUsers[0]->totalActiveDrivers }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-person"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">On Hold Drivers</span>
                            <span class="info-box-number">{{ $totalUsers[0]->totalOnHoldDrivers }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>


                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red-gradient"><i class="ion ion-person"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Terminated Drivers</span>
                            <span class="info-box-number">{{ $totalUsers[0]->totalTerminatedDrivers }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red-active"><i class="ion ion-person"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Resigned Drivers</span>
                            <span class="info-box-number">{{ $totalUsers[0]->totalResignedDrivers }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->

            </div><!-- /.row -->

            @if(Auth::user()->user_type_id==1)
            <h2 class="page-header"><img class="img-circle" src="{{ asset('/AdminLTE/img/supervisors.jpg') }}" alt="User Avatar" style="width: 80px; height: 80px;"> Supervisors & AreaManger Details <small > (in this portion Supervisors and AreaManger details are mentioned with Statuses)</small></h2>

            <div class="row">


                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-person"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Active Supervisors</span>
                            <span class="info-box-number">{{ $totalUsers[0]->totalActiveSupervisors }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-person"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Un-Active Supervisors</span>
                            <span class="info-box-number">{{ $totalUsers[0]->totalUnActiveSupervisors }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>


                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-person"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Active AreaManager</span>
                            <span class="info-box-number">{{ $totalUsers[0]->totalActiveAreaManagers }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red-active"><i class="ion ion-person"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Un-Active AreaManager</span>
                            <span class="info-box-number">{{ $totalUsers[0]->totalUnActiveAreaManagers }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->




            </div><!-- /.row -->

            @endif
            <h2 class="page-header"><img class="img-circle" src="{{ asset('/AdminLTE/img/warehouse.jpg') }}" alt="User Avatar" style="width: 80px; height: 80px;"> Warehouse Details <small > (in this portion Warehouse details are mentioned with Statuses)</small></h2>

            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-7">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-blue">
                            <div class="widget-user-image">
                                <img class="img-circle" src="{{ asset('/AdminLTE/img/logo.jpg') }}" alt="User Avatar">
                            </div><!-- /.widget-user-image -->
                            <h3 class="widget-user-username">Daily Records of All warehouses</h3>
                            <h5 class="widget-user-desc">All Warehouses</h5>





                        </div>
                        <div class="box-footer no-padding">

                            <ul class="nav nav-stacked">
                                <li>
                                    <table class="table m-0 search_table" style="width:10px!important;">
                                        <tr>
                                            <TH>CompanyName</TH>
                                            <td>
                                                <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                                        class="form-control" style="width:250px;" required>
                                                    <option value=""> Select Company After Warehouse</option>
                                                    @if(!empty($lkp_company))
                                                        @foreach($lkp_company as $lkpcompany)
                                                            <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>

                                            <TH>WarehouseName</TH>
                                            <td>
                                                <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                                        style="width:180px;" onchange="getDailyRecords(this.value)">
                                                </select>
                                            </td>

                                        </tr>
                                    </table>
                                </li>
                                <li><a href="#">Total Numbers of Drivers <span class="pull-right badge bg-blue" id="totalDriverSpan">{{ $drivers['totalDrivers'] }}</span></a></li>
                                <li><a href="#">Number of Attend Drivers <span class="pull-right badge bg-green" id="presentDriverSpan">{{ $drivers['presentDrivers'] }}</span></a></li>
                                <li><a href="#">Number of Drivers who Loaded <span class="pull-right badge bg-aqua" id="presentLoadedDriverSpan">{{ $drivers['presentLoadedDrivers'] }}</span></a></li>
                                <li><a href="#">Number of Driver with No Loads <span class="pull-right badge bg-red-gradient" id="driversHaveNoLoadSpan">{{ $drivers['driversHaveNoLoad'] }}</span></a></li>
                                <li><a href="#">Number of Driver who Absent <span class="pull-right badge bg-red" id="absentDriverSpan">{{ $drivers['absentDrivers'] }}</span></a></li>
                            </ul>
                        </div>
                    </div><!-- /.widget-user -->
                </div>


            </div>



        </section>
        <br>
        <br>
        <br>
        <br>
        <br>


    <script>
        function WarehouseName() {

            var filter_companyId = document.getElementById('filter_companyId').value;
            if (filter_companyId == "")
                $('#filter_warehouseId').empty();
            else {

                {{--$.ajax({--}}
                {{--    type: 'GET',--}}
                {{--    url: "{{URL('/getDailyCompanyRecords')}}" + "/" + filter_companyId,--}}
                {{--    contentType: "html",--}}
                {{--    dataType: 'html',--}}
                {{--    success: function (data) {--}}
                {{--        var obj=JSON.parse(data);--}}
                {{--        console.log(data);--}}
                {{--    }--}}
                {{--});--}}


                $.getJSON("<?php echo e(URL("/getWarehouseName")); ?>" + "/" + filter_companyId, function (json) {
                    $('#filter_warehouseId').empty();
                    $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });
            }


        }

        function getDailyRecords(warehouseId) {
            $.ajax({
                type: 'GET',
                url: "{{URL('/getDailyRecords')}}" + "/" + warehouseId,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                   var obj=JSON.parse(data);
                    document.getElementById('totalDriverSpan').textContent = obj.reports['totalDrivers'];
                    document.getElementById('presentDriverSpan').textContent = obj.reports['presentDrivers'];
                    document.getElementById('presentLoadedDriverSpan').textContent = obj.reports['presentLoadedDrivers'];
                    document.getElementById('driversHaveNoLoadSpan').textContent = obj.reports['driversHaveNoLoad'];
                    document.getElementById('absentDriverSpan').textContent = obj.reports['absentDrivers'];
                }
            });
        }
        
        function vehicleInfo(type, title) {
            document.getElementById('info_modal').style.display = 'block';
            document.getElementById('response').innerHTML = loader;
            $.ajax({
                type: 'POST',
                url: "{{url('Vehicles/VehicleInfo')}}",
                cache: false,
                data: {
                    title: title,
                    type: type,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }
        function show_vehicles(city_name, type = '', companyName = '', warehouseName = '') {
            myWindow1 = window.open("/Vehicles" + "/" + city_name + "/" + type + "/" + companyName + "/" + warehouseName, "",
                "height=1000,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
        }
    </script>
    
    <div id="info_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:850px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('info_modal').style.display='none'"
                    class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                    title="Close Modal">&times;
                </span>
            </div>
            <div style="width:100%;clear:both;" id="response">
    
            </div>
        </div>
    </div>


@endsection

