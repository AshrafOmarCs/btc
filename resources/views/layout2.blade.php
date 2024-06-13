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
		@yield('css')
        <!-- Data Tables -->
        <link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bs5.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bs5-custom.css')}}" />
        <link rel="stylesheet" href="https://btcdmins.com/AdminLTE/plugins/iCheck/all.css">

	</head>

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
							<li class="sidebar-dropdown active">
								<a href="#">
									<i class="bi bi-house"></i>
									<span class="menu-text">Dashboards</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="{{url('/New-Portal')}}" class="{{ request()->is('New-Portal') ? 'current-page' : '' }}">Analytics</a>
										</li>
                                        @if(Auth::user()->id == 2 || Auth::user()->id == 73)
                                            <li>
                                                <a href="{{url('/New-Portal/Logs')}}" class="{{ request()->is('New-Portal/Logs') ? 'current-page' : '' }}">{{__('nav.system_logs')}}</a>
                                            </li>
                                        @endif
										<li>
											<a href="reports.html">Reports</a>
										</li>
										<li>
											<a href="reports.html">System timeline</a>
										</li>
									</ul>
								</div>
							</li>
							<li>
								<a href="{{url('New-Portal/Requires_action')}}">
									<i class="bi bi-align-top" style="color: #FF5722;"></i>
									<span class="menu-text">Requires action <span class="badge rounded-pill shade-red" style="margin-left: 6px;">3+</span></span>
								</a>
							</li>
							<li class="menu-title">
								<i class=""> &nbsp;&nbsp;</i>
								<span data-key="t-components">Operation</span>
							</li>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-credit-card-2-front"></i>
									<span class="menu-text">{{__('nav.accounts')}}</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
                                        @if(session('Read_2')==1)
                                            <li>
                                                <a href="{{url('New-Portal/Users')}}">{{__('nav.administration')}}</a>
                                            </li>
                                        @endif
                                        @if(session('Read_3')==1)
                                            <li>
                                                <a href="{{url('New-Portal/Supervisors')}}">{{__('nav.supervisors_areaManager')}} </a>
                                            </li>
                                        @endif
										<li>
											<a href="widgets.html">Employee</a>
										</li>
									</ul>
								</div>
							</li>
                            <li>
                                <a href="{{url('New-Portal/Documents')}}">
                                    <i class="bi bi-calendar4"></i>
                                    {{__('nav.documents')}}
                                </a>
                            </li>
                            @if(session('Read_4')==1)
                                <li class="sidebar-dropdown">
                                    <a href="#">
                                        <i class="bi bi-credit-card-2-front"></i>
                                        <span class="menu-text">Co & Warehouses</span>
                                    </a>
                                    <div class="sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{URL("New-Portal/Company")}}">{{__('nav.companies')}} </a>
                                            </li>
                                            <li>
                                                <a href="{{URL("New-Portal/Warehouses")}}">{{__('nav.warehouses')}} </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if(Auth::user()->id == 73 || Auth::user()->id == 49 || Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 15 || Auth::user()->id == 96 || Auth::user()->id == 104 || Auth::user()->id == 98)
                                <li>
                                    <a href="{{url('New-Portal/union')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text {{ request()->is('New-Portal/union') ? 'current-page' : '' }}">{{__('nav.union')}}</span>
                                    </a>
                                </li>
                            @endif
                            @if(session('Read_5')==1)
                                <li>
                                    <a href="{{url('New-Portal/Drivers')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text {{ request()->is('New-Portal/Drivers') ? 'current-page' : '' }}">{{__('nav.drivers')}}</span>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->id == 86 || session('Read_6') == 1)
							<li>
								<a href="{{url('New-Portal/DriversJahiz')}}">
									<i class="bi bi-calendar4"></i>
									<span class="menu-text" class="{{ request()->is('New-Portal/DriversJahiz') ? 'current-page' : '' }}">{{__('nav.drivers_jahiz')}}</span>
								</a>
							</li>
                            @endif
                            @if(session('Read_7')==1)
                                <li>
                                    <a href="{{url('New-Portal/DriversJahizClearing')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text" class="{{ request()->is('New-Portal/DriversJahizClearing') ? 'current-page' : '' }}">{{__('nav.bander_clearing')}}</span>
                                    </a>
                                </li>
                            @endif
                            @if(session('Read_29')==1)
                                <li>
                                    <a href="{{url('New-Portal/DriversSANEDClearing')}}" class="{{ request()->is('New-Portal/DriversSANEDClearing') ? 'active current-page' : '' }}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.SANED_clearing')}}</span>
                                    </a>
                                </li>
                            @endif
                            @if(session('Read_27')==1)
                                <li>
                                    <a href="{{url('New-Portal/DriversJahizClaim')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.jahiz_claim')}}</span>
                                    </a>
                                </li>
                            @endif
							<li class="menu-title">
								<i class=""> &nbsp;&nbsp;</i>
								<span data-key="t-components">Finance</span>
							</li>
                            @if(Auth::user()->user_type_id!=1 AND app('salaries') > 0)
                                <li>
                                    <a href="{{url('New-Portal/Salaries')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.salary')}}</span>
                                    </a>
                                </li>
                            @endif
                            @if(session('Read_15')==1)
                                <li>
                                    <a href="{{url('New-Portal/Loans')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.loans')}}</span>
                                    </a>
                                </li>
                            @endif

                            @if(session('Read_17')==1 )
                                <li>
                                    <a href="{{url('New-Portal/Salary')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.salary')}}</span>
                                    </a>
                                </li>
                            @endif
							{{-- <li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-bank"></i>
									<span class="menu-text">Money Transfer</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="orders.html">Salaries</a>
										</li>
										<li>
											<a href="products.html">Loans</a>
										</li>
										<li>
											<a href="view-cart.html">Jahiz</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-check2-circle"></i>
									<span class="menu-text">Confirm transfer  </span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="orders.html">Salaries</a>
										</li>
										<li>
											<a href="products.html">Loans</a>
										</li>
										<li>
											<a href="view-cart.html">Jahiz</a>
										</li>
								</div>
							</li> --}}
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-check2-circle"></i>
									<span class="menu-text">Sett & Deduction  </span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="orders.html">Settlement</a>
										</li>
										<li>
											<a href="products.html">Creditnote</a>
										</li>
								</div>
							</li>
                            @if(session('Read_16')==1)
                                <li>
                                    <a href="{{url('New-Portal/Journal')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.journal')}} </span>
                                    </a>
                                </li>
                            @endif
                            @if(session('Read_17')==1 || Auth::user()->id == 20 || Auth::user()->id == 90)
                                <li class="sidebar-dropdown">
                                    <a href="#">
                                        <i class="bi bi-check2-circle"></i>
                                        <span class="menu-text"> {{__('nav.sync_claims')}}  </span>
                                    </a>
                                    <div class="sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{URL("New-Portal/ClaimsDeduction")}}">{{__('nav.claims_deduction')}}</a>
                                            </li>
                                            {{-- <li>
                                                <a href="{{URL("New-Portal/ClaimsDeduction/SyncJahiz")}}">{{__('nav.jahiz_sync_claims')}}</a>
                                            </li> --}}
                                    </div>
                                </li>

                            @endif
                            @if(Auth::user()->user_type_id==1)
                                <li>
                                    <a href="{{url('New-Portal/Transaction-History')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.transactions_history')}} </span>
                                    </a>
                                </li>
                            @endif
                            @if(session('Read_18')==1)
                                <li>
                                    <a href="{{url('New-Portal/CreditNotes')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.creditNotes')}} </span>
                                    </a>
                                </li>
                            @endif

                            @if(session('Read_19')==1)
                                <li>
                                    <a href="{{url('New-Portal/Settlements')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.settlements')}} </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('New-Portal/Landmark')}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.landmark')}} </span>
                                    </a>
                                </li>
                            @endif

                            {{-- <li>
								<a href="calendar.html">
									<i class="bi bi-calendar4"></i>
									<span class="menu-text">Generate Sales.R </span>
								</a>
							</li> --}}
                            @if(Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 73 || Auth::user()->id == 18 || Auth::user()->id == 14 || Auth::user()->id == 98)
                                <li class="menu-title">
                                    <i class=""> &nbsp;&nbsp;</i>
                                    <span data-key="t-components">HR</span>
                                </li>
                                {{-- <li>
                                    <a href="calendar.html">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">Custody</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a href="{{URL("New-Portal/Properties/index")}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.properties')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{URL("New-Portal/ContractsQuotation")}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.contracts_quotations')}}</span>
                                    </a>
                                </li>
                                <li class="sidebar-dropdown">
                                    <a href="#">
                                        <i class="bi bi-collection"></i>
                                        <span class="menu-text">Docs & Tutorials</span>
                                    </a>
                                    <div class="sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{url('New-Portal/UploadDocuments')}}">{{__('nav.upload_documents')}}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
							{{-- <li class="menu-title">
								<i class=""> &nbsp;&nbsp;</i>
								<span data-key="t-components">Marketing </span>
							</li>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-stickies"></i>
									<span class="menu-text">CMS</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="profile.html">Companies</a>
										</li>
										<li>
											<a href="account-settings.html">Individuals </a>
										</li>
									</ul>
								</div>
							</li>
							<li>
								<a href="calendar.html">
									<i class="bi bi-calendar4"></i>
									<span class="menu-text">Quotations</span>
								</a>
							</li> --}}
							<li class="menu-title">
								<i class=""> &nbsp;&nbsp;</i>
								<span data-key="t-components">Tickets </span>
							</li>
							<li>
								<a href="calendar.html">
									<i class="bi bi-calendar4"></i>
									<span class="menu-text">Opened Tickets</span>
								</a>
								<a href="calendar.html">
									<i class="bi bi-calendar4"></i>
									<span class="menu-text">Closed Tickets</span>
								</a>
							</li>
                            <li class="menu-title">
								<i class=""> &nbsp;&nbsp;</i>
								<span data-key="t-components">{{__('nav.SANED')}} </span>
							</li>
							<li>
                                @if(session('Read_30')==1)
                                    <a href="{{URL("/New-Portal/SANEDPaid")}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.SANED_paid')}}</span>
                                    </a>
                                @endif
                                @if(session('Read_34')==1)
                                    {{-- <a href="{{URL("/New-Portal/ChefzImportInvoice")}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.chefz_import_invoice')}}</span>
                                    </a> --}}
                                @endif
                                @if(session('Read_37')==1)
                                    <a href="{{URL("/New-Portal/LoansPaid")}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.loans_paid')}}</span>
                                    </a>
                                @endif
                                @if(session('Read_38')==1)
                                    <a href="{{URL("/New-Portal/SalaryPaid")}}">
                                        <i class="bi bi-calendar4"></i>
                                        <span class="menu-text">{{__('nav.salary_paid')}}</span>
                                    </a>
                                @endif
							</li>

							{{-- <li class="menu-title">
								<i class=""> &nbsp;&nbsp;</i>
								<span data-key="t-components">Settings</span>
							</li>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-credit-card-2-front"></i>
									<span class="menu-text">Finance Period </span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="widgets.html">Jahiz Months</a>
										</li>
										<li>
											<a href="graph-widgets.html">Supervisors </a>
										</li>
										<li>
											<a href="widgets.html">Employee</a>
										</li>
									</ul>
								</div>
							</li> --}}
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

					<!-- Breadcrumb start -->
					{{-- <ol class="breadcrumb d-md-flex d-none">
						<li class="breadcrumb-item">
							<i class="bi bi-house"></i>
							<a href="index.html">Home</a>
						</li>
						<li class="breadcrumb-item breadcrumb-active" aria-current="page">Sales</li>
					</ol> --}}
					<!-- Breadcrumb end -->

					<!-- Header actions ccontainer start -->
					<div class="header-actions-container">

						<!-- Search container start -->
						<div class="search-container">

							<!-- Search input group start -->
							<!-- <div class="input-group">
								<input type="text" class="form-control" placeholder="Search anything">
								<button class="btn" type="button">
									<i class="bi bi-search"></i>
								</button>
							</div> -->
							<!-- Search input group end -->

						</div>
						<!-- Search container end -->

						<!-- Leads start -->
						<a href="orders.html" class="leads d-none d-xl-flex">
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
										<img src="{{asset('assets/images/user.png')}}" alt="Admin Templates">
										<span class="status online"></span>
									</span>
								</a>
								<div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
									<div class="header-profile-actions">
										{{-- <a href="profile.html">Profile</a>
										<a href="profile.html">Applications</a>
										<a href="account-settings.html">Settings</a> --}}
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

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
		<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('assets/js/modernizr.js')}}"></script>
		<script src="{{asset('assets/js/moment.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


		<!-- *************
			************ Vendor Js Files *************
		************* -->

		<!-- Overlay Scroll JS -->
		<script src="{{asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js')}}"></script>
		<script src="{{asset('assets/vendor/overlay-scroll/custom-scrollbar.js')}}"></script>

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
        <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
        <script>
            $('.dropify').dropify();
            function set_lang(lang) {
                window.location.href = '/lang/'+lang;
            }
        </script>
		@yield('javascript')
	</body>

</html>
