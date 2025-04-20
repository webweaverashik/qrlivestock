<head>
    <title>@yield('title', 'Dashboard') | প্রাণি-সেবা সারথী</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="title" content="PraniShebaSharothi - Digital Livestock Service Management System">
    <meta name="description" content="PraniShebaSharothi is an innovative digital platform designed to streamline livestock service delivery and tracking. It enables livestock officers to record services, generate QR-based farm ID cards, and allows farm owners to access their data seamlessly through a mobile app.">
    <meta name="keywords" content="PraniShebaSharothi, livestock service management, farm QR ID, animal health tracking, digital livestock system, veterinary service software, farm management system, Livestock Office Bangladesh, farm data tracking, PraniSheba app, animal service record">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="bn_BD" />
    <meta property="og:type" content="website">
    <meta property="og:title" content="PraniShebaSharothi - Livestock Digital Service Platform">
    <meta property="og:url" content="https://ashikur-rahman.com" />
    <meta property="og:site_name" content="ParniShebaSharothi by Ashikur Rahman" />
    <link rel="canonical" href="https://ashikur-rahman.com" />
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Bengali:wght@100..900&display=swap" rel="stylesheet">
    <!--end::Fonts-->

    <!--begin::Vendor Stylesheets(used for this page only)-->
    @stack('page-css')
    <!--end::Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>