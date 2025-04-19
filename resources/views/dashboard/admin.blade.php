@push('page-css')
@endpush


@extends('layouts.app')

@section('title', 'ড্যাশবোর্ড')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            ড্যাশবোর্ড
        </h1>
        <!--end::Title-->
        <!--begin::Separator-->
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <!--end::Separator-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 ">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="?page=index" class="text-muted text-hover-primary">
                    হোম </a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                ড্যাশবোর্ড </li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
@endsection

@section('content')
    <!--begin::Row-->
    <div class="row gy-5 gx-xl-10">
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <a href="{{ route('farms.index') }}">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="las la-tractor fs-3hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-4x text-gray-800 lh-1 ls-n2">{{ en2bn($registered_farms) }}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-3 text-gray-500">নিবন্ধিত খামারের সংখ্যা</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                    </div>
                </a>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-sm-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <a href="{{ route('farms.pending') }}">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="las la-hourglass-half fs-3hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-4x text-gray-800 lh-1 ls-n2">{{ en2bn($pending_farms) }}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-3 text-gray-500">পেন্ডিং খামার সংখ্যা</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                    </div>
                </a>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-sm-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <a href="{{ route('records.index') }}">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="bi bi-journal-text fs-3hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-4x text-gray-800 lh-1 ls-n2">{{ en2bn($service_records) }}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-3 text-gray-500">সেবা প্রদান সংখ্যা</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                    </div>
                </a>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-sm-6 col-xl-3 mb-xl-10 mb-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <a href="{{ route('prescriptions.index') }}">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="las la-notes-medical fs-3hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span
                                class="fw-semibold fs-4x text-gray-800 lh-1 ls-n2">{{ en2bn($pending_prescriptions) }}</span>
                            <!--end::Number-->
                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-3 text-gray-500">পেন্ডিং প্রেসক্রিপশন</span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->
                    </div>
                </a>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row g-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-xxl-5">
            <!--begin::Chart widget 38-->
            <div class="card card-flush mb-5 mb-xl-10">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="fs-2 card-label fw-bold text-gray-800">নিবন্ধিত গবাদি প্রাণির সংখ্যা</span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body d-flex align-items-end px-0">
                    <!--begin::Chart-->
                    <div id="registered_livestock_count_chart" class="w-100 min-h-auto ps-4 pe-6"></div>
                    <!--end::Chart-->
                </div>
                <!--end: Card Body-->
            </div>
            <!--end::Chart widget 38-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-xxl-7">
            <!--begin::Chart widget 20-->
            <div class="card card-flush">
                <!--begin::Header-->
                <div class="card-header py-5">
                    <!--begin::Title-->
                    <h3 class="card-title fw-bold text-gray-800 fs-2">সেবা প্রদানের সংখ্যা</h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-1">
                    <!--begin::Items-->
                    <div class="d-flex flex-wrap d-grid gap-5 px-9 mb-5">
                        <!--begin::Item-->
                        <div class="me-md-2">
                            <!--begin::Statistics-->
                            <div class="d-flex mb-2">
                                <span id="last-month-count"
                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">12,706</span>
                            </div>
                            <!--end::Statistics-->
                            <!--begin::Description-->
                            <span
                                class="fs-6 fw-semibold text-gray-500">{{ en2bn(\Carbon\Carbon::now()->subMonth()->format('M')) }}
                                মাসে</span>
                            <!--end::Description-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div
                            class="border-start-dashed border-end-dashed border-start border-end border-gray-300 px-5 ps-md-10 pe-md-7 me-md-5">
                            <!--begin::Statistics-->
                            <div class="d-flex mb-2">
                                <span id="this-month-count"
                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">8,035</span>
                            </div>
                            <!--end::Statistics-->
                            <!--begin::Description-->
                            <span class="fs-6 fw-semibold text-gray-500">{{ en2bn(\Carbon\Carbon::now()->format('M')) }}
                                মাসে</span>
                            <!--end::Description-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="m-0">
                            <div class="d-flex align-items-center mb-2">
                                <span id="total-diff" class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">–</span>
                                <span id="percent-diff" class="badge badge-light-success fs-base">
                                    <i class="ki-duotone ki-black-up fs-7 text-success ms-n1"></i><span
                                        class="percent-value">–</span>
                                </span>
                            </div>
                            <span class="fs-6 fw-semibold text-gray-500">পার্থক্য</span>
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Items-->
                    <!--begin::Chart-->
                    <div id="kt_service_record_count_chart" class="min-h-auto ps-4 pe-6"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Chart widget 20-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
@endsection


@push('vendor-js')
@endpush

@push('page-js')
    <script>
        // For registered-livestock-count-chart.js
        const livestockTypeChartData = @json($livestockCountByType);

        const serviceRecordChartData = {
            dates: @json($currentMonthDates),
            current: @json($currentMonthCounts),
            last: @json($lastMonthCounts)
        };


        // For service-record-count-chart.js
        const currentMonthTotal = serviceRecordChartData.current.reduce((acc, val) => acc + val, 0);
        const lastMonthTotal = serviceRecordChartData.last.reduce((acc, val) => acc + val, 0);
        const totalDifference = currentMonthTotal - lastMonthTotal;
        const percentDifference = lastMonthTotal === 0 ? 0 : ((totalDifference / lastMonthTotal) * 100).toFixed(1);



        // Update counts
        document.getElementById("this-month-count").innerText = en2bnNumber(currentMonthTotal);
        document.getElementById("last-month-count").innerText = en2bnNumber(lastMonthTotal);
        document.getElementById("total-diff").innerText = en2bnNumber(Math.abs(totalDifference));
        document.querySelector("#percent-diff .percent-value").innerText = en2bnNumber(Math.abs(percentDifference)) + "%";

        // Update arrow direction and color
        const icon = document.querySelector("#percent-diff i");
        const percentBadge = document.getElementById("percent-diff");

        if (totalDifference > 0) {
            icon.classList.remove("ki-black-down", "text-danger");
            icon.classList.add("ki-black-up", "text-success");
            percentBadge.classList.remove("badge-light-danger");
            percentBadge.classList.add("badge-light-success");
        } else if (totalDifference < 0) {
            icon.classList.remove("ki-black-up", "text-success");
            icon.classList.add("ki-black-down", "text-danger");
            percentBadge.classList.remove("badge-light-success");
            percentBadge.classList.add("badge-light-danger");
        } else {
            icon.classList.remove("ki-black-up", "ki-black-down", "text-success", "text-danger");
            percentBadge.classList.remove("badge-light-success", "badge-light-danger");
        }
    </script>

    <script src="{{ asset('js/dashboard/registered-livestock-count-chart.js') }}"></script>
    <script src="{{ asset('js/dashboard/service-record-count-chart.js') }}"></script>
    <script>
        document.getElementById("dashboard_link").classList.add("active");
    </script>
@endpush
