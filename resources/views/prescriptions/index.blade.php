@push('page-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush


@extends('layouts.app')

@section('title', 'অপেক্ষমাণ প্রেসক্রিপশন')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            অনুমোদনের অপেক্ষায় প্রেসক্রিপশন
        </h1>
        <!--end::Title-->
        <!--begin::Separator-->
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <!--end::Separator-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 ">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="#" class="text-muted text-hover-primary">
                    চিকিৎসা রেজিস্টার </a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                পেন্ডিং প্রেসক্রিপশন
            </li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
@endsection


@section('content')
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5">
                    </i>
                    <input type="text" data-kt-pending-prescriptions-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="প্রেসক্রিপশন অনুসন্ধান করুন" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-farm-table-toolbar="base">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-outline ki-filter fs-2">
                        </i>ফিল্টার
                    </button>
                    <!--begin::Menu 1-->
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                        <!--begin::Header-->
                        <div class="px-7 py-5">
                            <div class="fs-5 text-gray-900 fw-bold">ফিল্টার অপশন</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Separator-->
                        <div class="separator border-gray-200"></div>
                        <!--end::Separator-->
                        <!--begin::Content-->
                        <div class="px-7 py-5" data-kt-pending-prescriptions-table-filter="form">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">একটিভেশন অবস্থা:</label>
                                <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                    data-placeholder="সক্রিয়তা সিলেক্ট করুন" data-allow-clear="true"
                                    data-kt-pending-prescriptions-table-filter="two-step" data-hide-search="true">
                                    <option></option>
                                    <option value="ActiveFarm">সক্রিয়</option>
                                    <option value="PausedFarm">নিষ্ক্রিয়</option>
                                </select>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                    data-kt-menu-dismiss="true" data-kt-pending-prescriptions-table-filter="reset">রিসেট
                                    করুন</button>
                                <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true"
                                    data-kt-pending-prescriptions-table-filter="filter">এপ্লাই
                                    করুন</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Menu 1-->
                    <!--end::Filter-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table id="kt_pending_prescriptions_table"
                class="table table-hover table-row-dashed align-middle fs-6 gy-5 qrlivestock-table">
                <thead>
                    <tr class="fw-bold fs-5 gs-0">
                        <th class="w-30px" rowspan="2">ক্র:</th>
                        <th class="w-40px" rowspan="2">সেবা গ্রহণের<br>তারিখ</th>
                        <th class="w-100px" rowspan="2">খামারের নাম</th>
                        <th class="w-75px" colspan="3">গবাদি প্রাণির তথ্য</th>
                        <th class="w-75px" colspan="5">প্রজাতির ধরণ</th>
                        <th class="w-150px" rowspan="2">রোগের বিবরণ</th>
                        <th class="w-150px" rowspan="2">Rx</th>
                        <th class="w-100px" rowspan="2">কার্যক্রম</th>
                    </tr>
                    <tr class="fw-bold fs-5 gs-0">
                        <th class="w-25px">গবাদি প্রাণি</th>
                        <th class="w-25px">বয়স</th>
                        <th class="w-25px">ওজন</th>
                        <th class="w-25px">Temp</th>
                        <th class="w-25px">Pulse</th>
                        <th class="w-25px">Rumen Motility</th>
                        <th class="w-25px">Respiratory Rate</th>
                        <th class="w-25px">Other</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold fs-5">
                    @foreach ($prescriptions as $prescription)
                        <tr>
                            <td>{{ en2bn($loop->index + 1) }}</td>
                            <td>
                                {{ en2bn($prescription->serviceRecord->created_at->format('d M Y')) }}
                                <span class="ms-1" data-bs-toggle="tooltip"
                                    title="{{ en2bn($prescription->serviceRecord->created_at->format('d-M-Y h:i:s A')) }}">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                            </td>
                            <td>
                                <!--begin::Farm details-->
                                <div class="d-flex flex-column">
                                    <a href="{{ route('farms.show', $prescription->serviceRecord->farm->id) }}"
                                        class="text-gray-800 text-hover-primary mb-1">{{ $prescription->serviceRecord->farm->farm_name }}</a>
                                    <span>ID: <strong>{{ $prescription->serviceRecord->farm->unique_id }}</strong></span>
                                </div>
                                <!--begin::Farm details-->
                            </td>
                            <td>{{ $prescription->livestockType->name }}</td>
                            <td>{{ $prescription->livestock_age }}</td>
                            <td>{{ $prescription->livestock_weight }}</td>
                            <td>{{ $prescription->livestock_temp }}</td>
                            <td>{{ $prescription->livestock_pulse }}</td>
                            <td>{{ $prescription->livestock_rumen_motility }}</td>
                            <td>{{ $prescription->livestock_respiratory }}</td>
                            <td>{{ $prescription->livestock_other }}</td>
                            <td>{!! $prescription->disease_brief !!}</td>
                            <td>{!! $prescription->medication !!}</td>
                            <td>
                                @if (auth()->user()->role == 'admin')
                                    <button class="btn btn-icon btn-active-success w-30px h-30px me-3 approve-prescription"
                                        title="অনুমোদন করুন" data-bs-toggle="tooltip"
                                        data-prescription-id="{{ $prescription->id }}">
                                        <i class="ki-outline ki-double-check fs-2"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
@endsection


@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@push('page-js')
    <script src="{{ asset('js/prescriptions/index.js') }}"></script>

    <script>
        document.getElementById("treatment_menu").classList.add("here", "show");
        document.getElementById("prescriptions_pending_link").classList.add("active");
    </script>
@endpush
