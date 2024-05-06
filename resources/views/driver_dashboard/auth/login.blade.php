<!DOCTYPE html>
<html lang="ar" direction="rtl" dir="rtl" style="direction: rtl">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>
        @yield('title')
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('dashboard') }}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.rtl.css"
        rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('dashboard') }}/assets/plugins/global/plugins.bundle.rtl.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dashboard') }}/assets/plugins/custom/prismjs/prismjs.bundle.rtl.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dashboard') }}/assets/css/style.bundle.rtl.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dashboard') }}/assets/css/pages/login/login-1.css" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('dashboard') }}/assets/css/themes/layout/header/base/light.rtl.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dashboard') }}/assets/css/themes/layout/header/menu/light.rtl.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dashboard') }}/assets/css/themes/layout/brand/dark.rtl.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dashboard') }}/assets/css/themes/layout/aside/dark.rtl.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dashboard') }}/assets/css/custom.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    @yield('styles')
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset('dashboard') }}/assets/media/logos/favicon.ico" />

    <style>
        body{
            direction: ltr !important;
            text-align: left;
        }
        label{
            
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->
@php  
    app()->setLocale('ar');

// dd(app()->getlocale());

@endphp
<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #0f246a;">
            <!--begin::Aside Bottom-->
            <div class="d-flex flex-row-fluid d-flex-center flex-column flex-column pt-lg-40 pt-15 text-center">
                
                <div> 
                    @if(app()->getlocale() == 'en')
                        <a href="#">
                            <img src="https://btcdmins.com/images/logo.jpeg" style="max-width: 200px;" />
                        </a>
                    @else 
                        <a href="#">
                            <img src="https://btcdmins.com/images/logo.jpeg" style="max-width: 200px;" />
                        </a>
                    @endif
                   
                </div>
                <div class="mt-15">
                    <h1 style="    color: white; font-size: 30px;">شركة بندر التجارية</h1>
                </div>

            </div>
            <!--end::Aside Bottom-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div
            class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form login-signin p-10">
                    <!--begin::Form-->
                    <form class="form" action="{{ route('login') }}" method="POST">
                        @csrf
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                        
                            {{-- <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">
                                BANDER DA-Portal dashboard</h3> --}}
                                <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg" style="text-align: right;">
                                    تسجيل دخول المناديب</h3>

                                
                        </div>
                        <!--begin::Title-->
                        <!--begin::Form group-->
                        <div class="form-group" style="text-align: right;">
                            <label class="font-size-h6 text-dark" >رقم المندوب التعريفي</label>
                            <input
                                class="form-control form-control-solid h-auto py-4 px-4 rounded-sm {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                type="text" name="AMP_ID" autocomplete="off" placeholder="رقم الايدي " tabindex="1"/>
                                <input type="hidden" name="user_type" value="DA">
                            
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group" >
                            <div class="d-flex justify-content-between mt-n5"  style="text-align: right;">
                                <label class="font-size-h6 text-dark pt-5" style="width: 100%;">رقم الهوية </label>
                                <!-- <a href="javascript:;"
                                    class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5"
                                    id="kt_login_forgot">{{ __('app.forget_password') }}</a> -->
                            </div>
                            <input
                                class="form-control form-control-solid h-auto py-4 px-4 rounded-sm {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                type="text" name="IdentityID" autocomplete="off" tabindex="2"
                                placeholder="رقم الهوية/الاقامة" />
                            
                        </div>
                        <!--end::Form group-->
                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5 text-center">
                            <button type="submit"
                                class="btn font-size-h6 px-4 py-2 my-3 mr-3 text-white" style="background-color: #333333">دخول</button>

                                @include('pages.messages')
                        </div>
                        <!--end::Action-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
            </div>
            <!--end::Content body-->

        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>

<!--end::Main-->
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('dashboard') }}/assets/plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('dashboard') }}/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/scripts.bundle.js"></script>
    <!--end::Global Theme Bundle-->

    <!--end::Page Scripts-->
    @stack('scripts')
</body>
<!--end::Body-->

</html>






 