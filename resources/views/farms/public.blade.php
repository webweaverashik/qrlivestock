<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>{{ $farm->farm_name }} | প্রাণি-সেবা সারথী</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="title" content="PraniShebaSharothi - Digital Livestock Service Management System">
    <meta name="description"
        content="PraniShebaSharothi is an innovative digital platform designed to streamline livestock service delivery and tracking. It enables livestock officers to record services, generate QR-based farm ID cards, and allows farm owners to access their data seamlessly through a mobile app.">
    <meta name="keywords"
        content="PraniShebaSharothi, livestock service management, farm QR ID, animal health tracking, digital livestock system, veterinary service software, farm management system, Livestock Office Bangladesh, farm data tracking, PraniSheba app, animal service record">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="bn_BD" />
    <meta property="og:type" content="website">
    <meta property="og:title" content="PraniShebaSharothi - Livestock Digital Service Platform">
    <meta property="og:url" content="https://ashikur-rahman.com" />
    <meta property="og:site_name" content="ParniShebaSharothi by Ashikur Rahman" />
    <link rel="canonical" href="https://ashikur-rahman.com" />
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Bengali:wght@100..900&display=swap"
        rel="stylesheet">
    <!--end::Fonts-->

    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
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
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="false"
    data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="false" data-kt-app-sidebar-fixed="false"
    data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="false" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" class="app-default">
    <!--begin::Theme mode setup on page load-->
    {{-- @include('layouts.partials.theme-mode') --}}
    <!--end::Theme mode setup on page load-->

    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">
            <!--begin::Header-->
            {{-- @include('layouts.partials.header') --}}
            <!--end::Header-->

            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid " id="kt_app_wrapper">

                <!--begin::Sidebar-->
                {{-- @include('layouts.partials.sidebar') --}}
                <!--end::Sidebar-->

                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Toolbar-->
                        <!--end::Toolbar-->

                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">




                                <!--begin::Navbar-->
                                <div class="card mb-6 mb-xl-9
                                        @if ($farm->status == 'pending') border border-dashed border-warning 
                                        @elseif ($farm->is_active == 0) border border-dashed border-danger @endif">
                                    <div class="card-body pt-9 pb-0">
                                        <!--begin::Details-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!--begin::Details-->
                                                <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                                                    <!--begin::Image-->
                                                    <div
                                                        class="d-flex flex-center flex-shrink-0 bg-light rounded-circle w-125px h-125px me-7 mb-4">
                                                        <img class="w-100 p-3"
                                                            src="{{ $farm->photo_url ? asset($farm->photo_url) : asset('assets/img/dummy.png') }}"
                                                            alt="{{ $farm->name }}" />
                                                    </div>

                                                    <!--begin::Details-->
                                                    <div class="d-flex flex-column">
                                                        <!--begin::Farm Name-->
                                                        <div class="d-flex align-items-center mb-1">
                                                            <span
                                                                class="text-gray-800 fs-2 fw-bold me-3">{{ $farm->farm_name }},
                                                                {{ $farm->unique_id }}</span>
                                                        </div>
                                                        <!--end::Farm Name-->

                                                        <div
                                                            class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-500">
                                                            মালিকের নাম: &nbsp;<span
                                                                class="text-gray-800">{{ $farm->owner_name }}</span>
                                                        </div>

                                                        <div
                                                            class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-500">
                                                            মোবাইল নং: &nbsp;<span
                                                                class="text-gray-800">{{ en2bn($farm->phone_number) }}</span>
                                                        </div>

                                                        <div
                                                            class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-500">
                                                            ইউনিয়ন/পৌরসভা: &nbsp;<span
                                                                class="text-gray-800">{{ $farm->union->name }}</span>
                                                        </div>

                                                        <div
                                                            class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-500">
                                                            গ্রাম/রাস্তা: &nbsp;<span
                                                                class="text-gray-800">{{ $farm->address }}</span>
                                                        </div>

                                                        <div
                                                            class="d-flex flex-wrap fw-semibold mb-0 fs-5 text-gray-500">
                                                            মন্তব্য: &nbsp;
                                                            @if ($farm->remarks)
                                                                <span class="text-gray-800">{{ $farm->remarks }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Details-->
                                            </div>

                                            <div class="col-md-2">
                                                <!--begin::Section-->
                                                <!--begin::Title-->
                                                <h4 class="mb-4">গবাদি প্রাণির তথ্য
                                                </h4>
                                                <!--end::Title-->

                                                <!--begin::Details-->
                                                <div class="mb-0">
                                                    <!--begin::Details-->
                                                    <table class="table fs-6 fw-semibold gs-0 gy-1 gx-0">
                                                        @foreach ($farm->livestockCounts as $livestockCount)
                                                            <!--begin::Row-->
                                                            <tr class="">
                                                                <td class="text-gray-500">
                                                                    {{ $livestockCount->livestockType->name }}:</td>
                                                                <td class="text-gray-800">
                                                                    {{ en2bn($livestockCount->total) }}টি</td>
                                                            </tr>
                                                            <!--end::Row-->
                                                        @endforeach

                                                        @if (count($farm->livestockCounts) == 0)
                                                            <span class="text-muted fst-italic">কোনো গবাদি প্রাণি
                                                                নেই</span>
                                                        @endif
                                                    </table>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--end::Section-->
                                            </div>

                                            <div class="col-md-3">
                                                <!--begin::Title-->
                                                <h4 class="mb-4">খামার এক্টিভেশন তথ্য</h4>
                                                <!--end::Title-->
                                                <!--begin::Details-->
                                                <table class="table fs-6 fw-semibold gs-0 gy-1 gx-0">
                                                    <!--begin::Row-->
                                                    <tr class="">
                                                        <td class="text-gray-500">অবস্থা:</td>
                                                        <td>
                                                            @if ($farm->is_active == 0)
                                                                <span
                                                                    class="badge badge-light-danger fs-6">নিষ্ক্রিয়</span>
                                                            @elseif ($farm->is_active == 1 && $farm->status == 'pending')
                                                                <span class="badge badge-light-warning fs-6">অনুমোদনের
                                                                    অপেক্ষায়</span>
                                                            @elseif ($farm->is_active == 1 && $farm->status == 'approved')
                                                                <span
                                                                    class="badge badge-light-success fs-6">সক্রিয়</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <!--end::Row-->

                                                    <!--begin::Row-->
                                                    <tr class="">
                                                        <td class="text-gray-500">নিবন্ধন:</td>
                                                        <td class="text-gray-800">
                                                            {{ en2bn($farm->created_at->format('d-M-Y')) }}
                                                            <span class="ms-1" data-bs-toggle="tooltip"
                                                                title="{{ en2bn($farm->created_at->format('d-M-Y h:i:s A')) }}">
                                                                <i
                                                                    class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <!--end::Row-->

                                                    @if ($farm->status == 'approved')
                                                        <!--begin::Row-->
                                                        <tr class="">
                                                            <td class="text-gray-500">অনুমোদিত:</td>
                                                            <td class="text-gray-800">
                                                                {{ en2bn($farm->approved_at->format('d-M-Y')) }}
                                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                                    title="{{ en2bn($farm->approved_at->format('d-M-Y h:i:s A')) }}">
                                                                    <i
                                                                        class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <!--end::Row-->
                                                    @endif

                                                    <!--begin::Row-->
                                                    <tr class="">
                                                        <td class="text-gray-500">সর্বশেষ সেবা নিয়েছেন:</td>
                                                        <td class="text-gray-800">
                                                            @if (count($farm->serviceRecords) > 0)
                                                                {{ en2bn($farm->serviceRecords()->latest()->value('created_at')->diffForHumans()) }}
                                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                                    title="{{ en2bn($farm->serviceRecords()->latest()->value('created_at')->format('d-M-Y h:i:s A')) }}">
                                                                    <i
                                                                        class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                                </span>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <!--end::Row-->
                                                </table>
                                                <!--end::Details-->
                                            </div>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                </div>
                                <!--end::Navbar-->

                                <!--begin::Table-->
                                <div class="card mt-6 mt-xl-9">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-title">
                                            <h2>সেবা গ্রহণের তালিকা</h2>
                                        </div>

                                        <!--end::Title-->
                                        <!--begin::Toolbar-->
                                        <div class="card-toolbar">
                                            <!--begin::Search-->
                                            <div class="d-flex align-items-center position-relative">
                                                <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5">
                                                </i>
                                                <input type="text" data-kt-farm-table-filter="search"
                                                    class="form-control form-control-solid w-250px ps-13"
                                                    placeholder="তথ্য অনুসন্ধান করুন" />
                                            </div>
                                            <!--end::Search-->
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pb-5">
                                        <!--begin::Tab panel-->
                                        <div class="py-0">
                                            <!--begin::Table-->
                                            <table id="kt_service_records_table"
                                                class="table table-hover table-row-dashed align-middle fs-6 gy-5 qrlivestock-table">
                                                <thead>
                                                    <tr class="fw-bold fs-5 gs-0">
                                                        <th class="w-30px" rowspan="2">ক্র:</th>
                                                        <th class="w-50px" rowspan="2">তারিখ</th>
                                                        <th class="w-100px" rowspan="2">সেবার ধরণ</th>
                                                        <th class="w-75px" colspan="3">প্রজাতির সংখ্যা</th>
                                                        <th class="w-75px" colspan="4">প্রজাতির ধরণ</th>
                                                        <th class="w-150px" rowspan="2">রোগের ইতিহাস</th>
                                                        <th class="w-150px" rowspan="2">রোগের লক্ষণ</th>
                                                        <th class="w-100px" rowspan="2">পরীক্ষার ফলাফল</th>
                                                        <th class="w-100px" rowspan="2">সম্ভাব্য রোগ</th>
                                                        <th class="w-100px" rowspan="2">প্রেসক্রিপশন</th>
                                                    </tr>
                                                    <tr class="fw-bold fs-5 gs-0">
                                                        <th class="w-25px">পাল/ ঝাঁক</th>
                                                        <th class="w-25px">আক্রান্ত</th>
                                                        <th class="w-25px">মৃত</th>
                                                        <th class="w-25px">প্রজাতি</th>
                                                        <th class="w-25px">জাত</th>
                                                        <th class="w-25px">লিঙ্গ</th>
                                                        <th class="w-25px">বয়স</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="text-gray-600 fw-semibold fs-5">
                                                    @foreach ($farm->serviceRecords as $record)
                                                        <tr>
                                                            <td>{{ en2bn($loop->index + 1) }}</td>
                                                            <td>
                                                                {{ en2bn($record->created_at->format('d M Y')) }}
                                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                                    title="{{ en2bn($record->created_at->format('d-M-Y h:i:s A')) }}">
                                                                    <i
                                                                        class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                                </span>
                                                            </td>
                                                            <td>{{ $record->serviceCategory->name }}</td>
                                                            <td>{{ en2bn($record->species_number_flock) }}</td>
                                                            <td>{{ en2bn($record->species_number_infected) }}</td>
                                                            <td>{{ en2bn($record->species_number_dead) }}</td>
                                                            <td>{{ $record->species_type_species }}</td>
                                                            <td>{{ $record->species_type_breed }}</td>
                                                            <td>
                                                                @if ($record->species_type_gender == 'male')
                                                                    মর্দা
                                                                @elseif ($record->species_type_gender == 'female')
                                                                    মাদি
                                                                @endif
                                                            </td>
                                                            <td>{{ $record->species_type_age }}</td>
                                                            <td>{{ $record->history_of_disease }}</td>
                                                            <td>{{ $record->symptoms_of_disease }}</td>
                                                            <td>{{ $record->microscopic_result }}</td>
                                                            <td>
                                                                @if ($record->disease)
                                                                    {{ $record->disease->name }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($record->prescription && $record->prescription->status == 'approved')
                                                                    <a href="{{ route('prescriptions.download', $record->prescription_id) }}"
                                                                        class="btn btn-icon text-hover-info"
                                                                        data-bs-toggle="tooltip"
                                                                        title="প্রেসক্রিপশন ডাউনলোড করুন"><i
                                                                            class="bi bi-download fs-2x"></i>
                                                                    </a>
                                                                @elseif ($record->prescription && $record->prescription->status == 'pending')
                                                                    <span
                                                                        class="badge badge-warning fs-5">পেন্ডিং</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-light-danger fs-5">নেই</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Tab panel-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->





                            </div>
                        </div>
                        <!--end::Content-->

                    </div>
                    <!--end::Content wrapper-->

                    <!--begin::Footer-->
                    @include('layouts.partials.footer')
                    <!--end::Footer-->

                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('js/farms/public.js') }}"></script>
    <!--end::Custom Javascript-->

    {{-- @include('layouts.partials.toastr') --}}

    <!--end::Javascript-->

    {{-- @include('layouts.partials.webcam-qr-scanner') --}}
</body>
<!--end::Body-->

</html>
