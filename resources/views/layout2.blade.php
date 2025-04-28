<!doctype html>
<html lang="en">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="Best Bootstrap Admin Dashboards">
		<meta name="author" content="Bootstrap Gallery" />
		<link rel="canonical" href="https://www.bootstrap.gallery/">
		<meta property="og:url" content="https://www.bootstrap.gallery">
		<meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
		<meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
		<meta property="og:type" content="Website">
		<meta property="og:site_name" content="Bootstrap Gallery">
		<link rel="shortcut icon" href="{{asset('assets/images/logo.png')}}">
        <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

		<!-- Title -->

        <title>@yield('title')</title>

		<!-- *************
			************ Common Css Files *************
		************ -->

		<!-- Animated css -->
		<link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">

		<!-- Bootstrap font icons css -->
		<link rel="stylesheet" href="{{asset('assets/fonts/bootstrap/bootstrap-icons.css')}}">

		<!-- Main css -->
		<link rel="stylesheet" href="{{asset('assets/css/main.min.css')}}">


		<!-- *************
			************ Vendor Css Files *************
		************ -->

		<!-- Scrollbar CSS -->
		<link rel="stylesheet" href="{{asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css')}}">
        <!-- Date Range CSS -->
        <link rel="stylesheet" href="{{asset('assets/vendor/daterange/daterange.css')}}">
        <!-- Bootstrap Select CSS -->
        <link rel="stylesheet" href="{{asset('assets/vendor/bs-select/bs-select.css')}}" />
        <!-- Bootstrap Select CSS -->
		@yield('css')
        <!-- Data Tables -->
        <link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bs5.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bs5-custom.css')}}" />
        <link rel="stylesheet" href="https://btcdmins.com/AdminLTE/plugins/iCheck/all.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	</head>
    @php
    $array = [];
    @endphp
	<body>
		<!-- Loading wrapper start -->
		<div id="loading-wrapper">
			<div class="spinner">
				<div class="line1"></div>
				<div class="line2"></div>
				<div class="line3"></div>
				<div class="line4"></div>
				<div class="line5"></div>
				<div class="line6"></div>
			</div>
		</div>
		<!-- Loading wrapper end -->

		<!-- Page wrapper start -->
		<div class="page-wrapper">

			<!-- Sidebar wrapper start -->
			<nav class="sidebar-wrapper">

				<!-- Sidebar brand starts -->
				<div class="sidebar-brand">
					<a href="index.html" class="logo">
						<img src="{{asset('assets/images/logo.png')}}" alt="Admin Dashboards" />
					</a>
				</div>
				<!-- Sidebar brand starts -->

				<!-- Sidebar menu starts -->
				<div class="sidebar-menu">
					<div class="sidebarMenuScroll">
						<ul>
                            <li class="menu-title">
								<i class=""> &nbsp;&nbsp;</i>
								<span data-key="t-components">Operation</span>
							</li>
							<li class="sidebar-dropdown {{ (request()->is('New-Portal/Users')
                                || request()->is('New-Portal/Supervisors')) ? 'active' : '' }}">
								<a href="#">
									<i class="bi bi-credit-card-2-front"></i>
									<span class="menu-text">{{__('nav.accounts')}}</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
                                        @if(session('Read_2')==1)
                                            <li>
                                                <a href="{{url('New-Portal/Users')}}"><i class="bi bi-person-circle"></i> {{__('nav.administration')}}</a>
                                            </li>
                                        @endif
                                        @if(session('Read_3')==1)
                                            <li>
                                                <a href="{{url('New-Portal/Supervisors')}}"><i class="bi bi-person-video2"></i> {{__('nav.supervisors_areaManager')}}</a>
                                            </li>
                                        @endif
										<li>
											<a href="widgets.html"><i class="bi bi-person-badge"></i>Employee</a>
										</li>
									</ul>
								</div>
							</li>
                            @if(session('Read_16')==1 || Auth::user()->id == 127 || Auth::user()->id == 125)
                            <li class="sidebar-dropdown {{ (request()->is('New-Portal/delegatedVehicles')
                                || request()->is('New-Portal/Vehicles/Vehicles-Requests')
                                || request()->is('New-Portal/vehiclesMaintenance')
                                || request()->is('New-Portal/Vehicles*')
                                || request()->is('New-Portal/FleetCreditNotes')) ? 'active' : '' }}">
                                <a href="#">
                                    <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front" viewBox="0 0 16 16">
                                        <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.731c.91-.073 2.35-.17 3.597-.17s2.688.097 3.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 10.691 4H5.309a.5.5 0 0 0-.447.276"/>
                                        <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM4.82 3a1.5 1.5 0 0 0-1.379.91l-.792 1.847a1.8 1.8 0 0 1-.853.904.8.8 0 0 0-.43.564L1.03 8.904a1.5 1.5 0 0 0-.03.294v.413c0 .796.62 1.448 1.408 1.484 1.555.07 3.786.155 5.592.155s4.037-.084 5.592-.155A1.48 1.48 0 0 0 15 9.611v-.413q0-.148-.03-.294l-.335-1.68a.8.8 0 0 0-.43-.563 1.8 1.8 0 0 1-.853-.904l-.792-1.848A1.5 1.5 0 0 0 11.18 3z"/>
                                    </svg>
                                    </i>
                                    <span class="menu-text"> {{__('nav.vehicles')}}  </span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="{{URL("New-Portal/Vehicles/Vehicles-Requests")}}">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front" viewBox="0 0 16 16">
                                                        <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.731c.91-.073 2.35-.17 3.597-.17s2.688.097 3.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 10.691 4H5.309a.5.5 0 0 0-.447.276"/>
                                                        <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM4.82 3a1.5 1.5 0 0 0-1.379.91l-.792 1.847a1.8 1.8 0 0 1-.853.904.8.8 0 0 0-.43.564L1.03 8.904a1.5 1.5 0 0 0-.03.294v.413c0 .796.62 1.448 1.408 1.484 1.555.07 3.786.155 5.592.155s4.037-.084 5.592-.155A1.48 1.48 0 0 0 15 9.611v-.413q0-.148-.03-.294l-.335-1.68a.8.8 0 0 0-.43-.563 1.8 1.8 0 0 1-.853-.904l-.792-1.848A1.5 1.5 0 0 0 11.18 3z"/>
                                                    </svg>
                                                </i>
                                                {{__('nav.vehicles_requests')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{URL("New-Portal/vehiclesMaintenance")}}">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-truck-flatbed" viewBox="0 0 16 16">
                                                        <path d="M11.5 4a.5.5 0 0 1 .5.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-4 0 1 1 0 0 1-1-1v-1h11V4.5a.5.5 0 0 1 .5-.5M3 11a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2m1.732 0h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4a2 2 0 0 1 1.732 1"/>
                                                        </svg>
                                                </i>
                                                Vehicle Maintenance
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{URL("New-Portal/delegatedVehicles")}}">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front" viewBox="0 0 16 16">
                                                        <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.731c.91-.073 2.35-.17 3.597-.17s2.688.097 3.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 10.691 4H5.309a.5.5 0 0 0-.447.276"/>
                                                        <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM4.82 3a1.5 1.5 0 0 0-1.379.91l-.792 1.847a1.8 1.8 0 0 1-.853.904.8.8 0 0 0-.43.564L1.03 8.904a1.5 1.5 0 0 0-.03.294v.413c0 .796.62 1.448 1.408 1.484 1.555.07 3.786.155 5.592.155s4.037-.084 5.592-.155A1.48 1.48 0 0 0 15 9.611v-.413q0-.148-.03-.294l-.335-1.68a.8.8 0 0 0-.43-.563 1.8 1.8 0 0 1-.853-.904l-.792-1.848A1.5 1.5 0 0 0 11.18 3z"/>
                                                    </svg>
                                                </i>
                                                {{__('nav.delegations')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{URL("New-Portal/Vehicles")}}">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front" viewBox="0 0 16 16">
                                                        <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.731c.91-.073 2.35-.17 3.597-.17s2.688.097 3.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 10.691 4H5.309a.5.5 0 0 0-.447.276"/>
                                                        <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM4.82 3a1.5 1.5 0 0 0-1.379.91l-.792 1.847a1.8 1.8 0 0 1-.853.904.8.8 0 0 0-.43.564L1.03 8.904a1.5 1.5 0 0 0-.03.294v.413c0 .796.62 1.448 1.408 1.484 1.555.07 3.786.155 5.592.155s4.037-.084 5.592-.155A1.48 1.48 0 0 0 15 9.611v-.413q0-.148-.03-.294l-.335-1.68a.8.8 0 0 0-.43-.563 1.8 1.8 0 0 1-.853-.904l-.792-1.848A1.5 1.5 0 0 0 11.18 3z"/>
                                                    </svg>
                                                </i>
                                                {{__('nav.vehicles_list')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{URL("New-Portal/Vehicles/Report")}}">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front" viewBox="0 0 16 16">
                                                        <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.731c.91-.073 2.35-.17 3.597-.17s2.688.097 3.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 10.691 4H5.309a.5.5 0 0 0-.447.276"/>
                                                        <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM4.82 3a1.5 1.5 0 0 0-1.379.91l-.792 1.847a1.8 1.8 0 0 1-.853.904.8.8 0 0 0-.43.564L1.03 8.904a1.5 1.5 0 0 0-.03.294v.413c0 .796.62 1.448 1.408 1.484 1.555.07 3.786.155 5.592.155s4.037-.084 5.592-.155A1.48 1.48 0 0 0 15 9.611v-.413q0-.148-.03-.294l-.335-1.68a.8.8 0 0 0-.43-.563 1.8 1.8 0 0 1-.853-.904l-.792-1.848A1.5 1.5 0 0 0 11.18 3z"/>
                                                    </svg>
                                                </i>
                                                {{__('nav.vehicles_report')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{URL("New-Portal/Vehicles/VehicleFuelSave")}}">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ev-station" viewBox="0 0 16 16">
                                                        <path d="M3.5 2a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5zm2.131 10.46H4.14v-.893h1.403v-.505H4.14v-.855h1.49v-.54H3.485V13h2.146zm1.316.54h.794l1.106-3.333h-.733l-.74 2.615h-.031l-.747-2.615h-.764z"/>
                                                        <path d="M3 0a2 2 0 0 0-2 2v13H.5a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1H11v-4a1 1 0 0 1 1 1v.5a1.5 1.5 0 0 0 3 0V4a.5.5 0 0 0-.146-.354l-.5-.5a.5.5 0 0 0-.707 0l-.5.5A.5.5 0 0 0 13 4v3c0 .71.38 1.096.636 1.357l.007.008c.253.258.357.377.357.635v3.5a.5.5 0 1 1-1 0V12a2 2 0 0 0-2-2V2a2 2 0 0 0-2-2zm7 2v13H2V2a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
                                                    </svg>
                                                </i>
                                                {{__('nav.vehicle_fuel_save')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route("FleetCreditNotes.index")}}">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ev-front-fill" viewBox="0 0 16 16">
                                                        <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848Zm6.75.51a.186.186 0 0 0-.23.034L6.05 7.246a.188.188 0 0 0 .137.316h1.241l-.673 2.195a.19.19 0 0 0 .085.218c.075.043.17.03.23-.034l2.88-3.187a.188.188 0 0 0-.137-.316H8.572l.782-2.195a.19.19 0 0 0-.085-.218Z"/>
                                                    </svg>
                                                </i>
                                                Vehicle Deduction
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                            @if(Auth::user()->id == 30 || Auth::user()->id == 112 || Auth::user()->id == 118)
                                <li>
                                    <a href="{{url('/Vehicles')}}">
                                        <i class="bi bi-car-front-fill"></i>
                                        <span class="menu-text">{{__('nav.vehicles_list')}} </span>
                                    </a>
                                </li>
                            @endif
						</ul>
					</div>
				</div>
				<!-- Sidebar menu ends -->

			</nav>
			<!-- Sidebar wrapper end -->

			<!-- *************
				************ Main container start *************
			************* -->
			<div class="main-container">

				<!-- Page header starts -->
				<div class="page-header">

					<div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>
					<!-- Welcome start -->
					<div class="welcome-note ms-2">
						Welcome, <span>{{AUTH::user()->name}} </span>
					</div>
					<!-- Welcome end -->

					<!-- Header actions ccontainer start -->
					<div class="header-actions-container">

						<!-- Search container start -->
						<div class="search-container">

						</div>
						<!-- Search container end -->

						<!-- Leads start -->
						<a href="/New-Portal/Requires_action" class="leads d-none d-xl-flex">
							<div class="lead-details">You have <span class="count"> 21 </span> new Notification </div>
							<span class="lead-icon"><i
									class="bi bi-bell-fill animate__animated animate__swing animate__infinite infinite"></i><b
									class="dot animate__animated animate__heartBeat animate__infinite"></b></span>
						</a>
						<!-- Leads end -->

						<!-- Header actions start -->
						<ul class="header-actions">
							<li class="dropdown d-none d-md-block">
                                @if (App::isLocale('en'))
								<a href="#" onclick="set_lang('en')" id="countries" data-toggle="dropdown" aria-haspopup="true">
									<img src="{{asset('assets/images/flags/1x1/ca.svg')}}" class="flag-img" alt="Admin Panels" />
								</a>
								<div class="dropdown-menu dropdown-menu-end mini" aria-labelledby="countries">
									<div class="country-container">
										<a href="#" onclick="set_lang('ar')">
											<img src="{{asset('assets/images/flags/1x1/saudi-arabia.svg')}}" alt="Clean Admin Dashboards" />
										</a>
									</div>
								</div>
                                @elseif (App::isLocale('ar'))
                                <a href="#" onclick="set_lang('ar')" id="countries" data-toggle="dropdown" aria-haspopup="true">
									<img src="{{asset('assets/images/flags/1x1/saudi-arabia.svg')}}" class="flag-img" alt="Admin Panels" />
								</a>
								<div class="dropdown-menu dropdown-menu-end mini" aria-labelledby="countries">
									<div class="country-container">
										<a href="#" onclick="set_lang('en')">
											<img src="{{asset('assets/images/flags/1x1/ca.svg')}}" alt="Clean Admin Dashboards" />
										</a>
									</div>
								</div>
                                @endif
							</li>
							<li class="dropdown">
								<a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
									<span class="user-name d-none d-md-block">{{AUTH()->user()->name}}</span>
									<span class="avatar">
                                        @if(AUTH()->user()->profile_pic == '')
                                            <img src="{{asset('assets/images/user.png')}}" alt="Admin Templates">
                                            <span class="status online"></span>
                                        @else
                                            <img src="/storage/images/{{AUTH()->user()->profile_pic}}" alt="Admin Templates">
                                            <span class="status online"></span>
                                        @endif
									</span>
								</a>
								<div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
									<div class="header-profile-actions">
                                        <a href="#" onclick="img_modal()">Update Image</a>
										<a href="{{url('New-Portal/ChangePassword')}}">Reset Password</a>
										<a href="{{url('logout')}}">Logout</a>
									</div>
								</div>
							</li>
						</ul>
						<!-- Header actions end -->

					</div>
					<!-- Header actions ccontainer end -->

				</div>
				<!-- Page header ends -->

				<!-- Content wrapper scroll start -->
				<div class="content-wrapper-scroll">

					<!-- Content wrapper start -->
					<div class="content-wrapper">
                        @include('pages.messages')

						@yield('content')
					</div>
					<!-- Content wrapper end -->

					<!-- App Footer start -->
					<div class="app-footer">
						<span>© bander logistic company 2023</span>
					</div>
					<!-- App footer end -->

				</div>
				<!-- Content wrapper scroll end -->

			</div>
			<!-- *************
				************ Main container end *************
			************* -->

		</div>
		<!-- Page wrapper end -->

		<!-- *************
			************ Required JavaScript Files *************
		************* -->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
        <div class="modal fade" id="Image_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update Profile Pic </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('updateProfilePic')}}" enctype='multipart/form-data'>
                        @csrf
                        <div class="modal-body">
                            <input type="file" accept=".jpg, .jpeg, .png" class="form-control dropify" name="profile_pic" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
		<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('assets/js/modernizr.js')}}"></script>
		<script src="{{asset('assets/js/moment.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


		<!-- *************
			************ Vendor Js Files *************
		************* -->
        {{-- Loader cdn --}}
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        {{-- carousel cdn --}}
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

		<!-- Overlay Scroll JS -->
		<script src="{{asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js')}}"></script>
		<script src="{{asset('assets/vendor/overlay-scroll/custom-scrollbar.js')}}"></script>
        {{-- select2 --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<!-- Date Range JS -->
		<script src="{{asset('assets/vendor/daterange/daterange.js')}}"></script>
		<script src="{{asset('assets/vendor/daterange/custom-daterange.js')}}"></script>
		<!-- Data Tables -->
        <script src="{{asset('assets/vendor/datatables/dataTables.min.js')}}"></script>
        <script src="{{asset('assets/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>

        <!-- Custom Data tables -->
        <script src="{{asset('assets/vendor/datatables/custom/custom-datatables.js')}}"></script>
        <!-- iCheck 1.0.1 -->
        <script src="{{asset("/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
        {{-- !-- Dropify JS --> --}}
        <!-- Bootstrap Select JS -->
        <script src="{{asset('assets/vendor/bs-select/bs-select.min.js')}}"></script>
        <script src="{{asset('assets/vendor/bs-select/bs-select-custom.js')}}"></script>
		<!-- Bootstrap Select JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
        <script>
            $('.dropify').dropify();
            function set_lang(lang) {
                window.location.href = '/lang/'+lang;
            }
            var selected = [];
            function export_excel() {
                // $('#backButton').hide();
                $('#exportExcelBtn').prop('disabled', true);
                // $('.secondList').hide();
                $('#select_all_second').prop('checked', false);
                // $('#select_all').prop('checked', false);
                // $('.select_options').removeClass('active');
                $('#ExportExcel').modal('toggle');
            }

            function selectOption(args, name) {
                $('#forwardBtn').removeClass('disabled');
                $('#reverseBtn').addClass('disabled');

                var option_id = 'option' + args;
                var optionElement = document.getElementById(option_id);
                if (!optionElement) {
                    console.error('Element not found:', option_id);
                    return;
                }
                if (optionElement.classList.contains('active')) {
                    optionElement.classList.remove('active');
                    selected = selected.filter(item => item.name !== name);
                } else {
                    optionElement.classList.add('active');
                    selected.push({ id: args, name: name });
                }
            }
            function selectOptionSecond(args, name) {
                $('#forwardBtn').addClass('disabled');
                $('#reverseBtn').removeClass('disabled');

                var option_id = 'option_' + args;
                var optionElement = document.getElementById(option_id);
                if (!optionElement) {
                    console.error('Element not found:', option_id);
                    return;
                }
                if (optionElement.classList.contains('active')) {
                    optionElement.classList.remove('active');
                    selected = selected.filter(item => item.name !== name);
                } else {
                    optionElement.classList.add('active');
                    selected.push({ id: args, name: name });
                }
            }

            function pushSelected() {
                $('#totalSelected').html(selected.length);
                let html = '';
                selected.forEach(element => {
                    let id = element['id'];

                    $('#option'+id).hide();
                    let name = element['name'];
                    html += `<li class="list-group-item active unselect_options"  id="option_`+id+`" onclick="selectOptionSecond('`+id+`', '`+name+`')" style="cursor: pointer;">`+name+`</li>`;
                });
                if (html != '') {
                    $('#exportExcelBtn').prop('disabled', false);
                    $('.secondList').show();
                    $('#secondListContent').html(html);
                } else {
                    $('#exportExcelBtn').prop('disabled', true);
                    $('.secondList').hide();
                    $('#secondListContent').html('');
                }
            }
            function popSelected() {
                $('#totalSelected').html(selected.length);
                $('.select_options').removeClass('active');
                $('.select_options').show();
                $('.unselect_options').hide();

                selected.forEach(element => {
                    $('#option'+element['id']).addClass('active');
                    $('#option'+element['id']).hide();
                    $('#option_'+element['id']).show();
                });
            }
            function closeAlert() {
                $(".alert").alert('close');
            }
            $(document).ajaxStart(function() {
                $("#loader").show();
            });
            $(document).ajaxStop(function() {
                $("#loader").hide();
            });
            function img_modal() {
                $('#Image_modal').modal('toggle');
            }
        </script>
		@yield('javascript')
	</body>

</html>
