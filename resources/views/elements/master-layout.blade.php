<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.2.2
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="description" content="Trail Analytics" />
    <meta name="keywords" content="Trail Analytics" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Trail Analytics" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Metronic by Keenthemes" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{ asset('public/assets/media/logos/trail_banner.png') }}" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('public/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }} " rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('public/assets/plugins/custom/datatables/datatables.bundle.css') }} " rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('public/assets/plugins/global/plugins.bundle.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/css/style.bundle.css') }} " rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.min.css" rel="stylesheet" /> --}}

    {{-- <link class="js-stylesheet" href="{{ asset('css/light.css') }}" rel="stylesheet"> --}}
    <link class="js-stylesheet" href="{{ asset('public/assets/datatables/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet">
    <link class="js-stylesheet" href="{{ asset('public/assets/css/select2.min.css') }}" rel="stylesheet">
    <link class="js-stylesheet" href="{{ asset('public/assets/css/treeview.css') }}" rel="stylesheet">
    <link class="js-stylesheet" href="{{ asset('public/assets/css/sweetalert2.min.css') }}" rel="stylesheet">
    <link class="js-stylesheet" href="{{ asset('public/assets/flatpickr/flatpickr.bundle.css') }}" rel="stylesheet">
    <link class="js-stylesheet" href="{{ asset('public/assets/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    {{-- <link class="js-stylesheet" href="{{ asset('public/assets/css/custom.css') }}" rel="stylesheet"> --}}

    <!-- Select2 -->
    <link hrefx="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- end select2 -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.min.css" rel="stylesheet" /> --}}


    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="overflow-x: hidden">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">

            <!--begin::Aside-->
            @if (Auth::check())
                @include('elements.sidebar')
            @endif

            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                @auth
                    @include('elements.header')
                @endauth
                <!--end::Header-->

                <!--begin::Toolbar-->
                @auth
                    {{-- @include('elements.toolbar') --}}
                @endauth
                <!--end::Toolbar-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid mt-md-n20" stylex="background-color: #F2F3F7"  id="kt_content">
                    <!--begin::Container-->
                    <div id="kt_content_container" class="container-xxl- {{ auth()->user() ? 'pe-6 ps-6' : '' }}">
                        @yield('content')
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                @include('elements.footer')
                {{-- @stack('scripts') --}}



</body>
<!--end::Body-->

</html>
