@push('page-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush


@extends('layouts.app')

@section('title', $farm->farm_name)

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            {{ $farm->farm_name }}
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
                    খামারের তথ্য </a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                সার্চ </li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
@endsection


@section('content')
    <!--begin::Layout-->
    <div class="d-flex flex-column flex-xl-row">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
            <!--begin::Card-->
            <div class="card card-flush mb-0 
            @if ($farm->status == 'pending') border border-dashed border-warning 
            @elseif ($farm->is_active == 0)
            border border-dashed border-danger @endif"
                data-kt-sticky="true" data-kt-sticky-name="farm-summary" data-kt-sticky-offset="{default: false, lg: 0}"
                data-kt-sticky-width="{lg: '250px', xl: '350px'}" data-kt-sticky-left="auto" data-kt-sticky-top="100px"
                data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>খামারের তথ্য</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::More options-->
                        <a href="#" class="btn btn-sm btn-light btn-icon" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-dots-horizontal fs-3">
                            </i>
                        </a>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-6 w-150px py-4"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                @if ($farm->is_active == 0)
                                    <a href="#" class="menu-link px-3">সক্রিয় করুন</a>
                                @else
                                    <a href="#" class="menu-link px-3">নিষ্ক্রিয় করুন</a>
                                @endif
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ route('farms.edit', $farm->id) }}" class="menu-link px-3">সংশোধন</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link text-danger px-3"
                                    data-kt-farm-view-action="delete">ডিলিট</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                        <!--end::More options-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0 fs-6">
                    <!--begin::Section-->
                    <div class="mb-7">
                        <!--begin::Details-->
                        <div class="d-flex align-items-center">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-60px symbol-circle me-3">
                                {{-- <img alt="Pic" src="{{ asset('assets/media/avatars/300-5.jpg') }}" /> --}}
                                <img src="{{ $farm->photo_url ? asset($farm->photo_url) : asset('assets/img/dummy.png') }}"
                                    alt="{{ $farm->name }}" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Info-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <span class="fs-4 fw-bold text-gray-900 me-2">{{ $farm->farm_name }}</span>
                                <!--end::Name-->
                                <!--begin::Farm ID-->
                                <span class="fw-bold text-gray-600">{{ $farm->unique_id }}</span>
                                <!--end::Farm ID-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Details-->
                    </div>
                    <!--end::Section-->

                    <!--begin::Seperator-->
                    <div class="separator separator-dashed mb-7"></div>
                    <!--end::Seperator-->

                    <!--begin::Section-->
                    <div class="mb-7">
                        <!--begin::Title-->
                        <h5 class="mb-4">খামারির তথ্য
                        </h5>
                        <!--end::Title-->
                        <!--begin::Details-->
                        <div class="mb-0">
                            <!--begin::Details-->
                            <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2">
                                <!--begin::Row-->
                                <tr class="">
                                    <td class="text-gray-500">মালিকের নাম:</td>
                                    <td class="text-gray-800">{{ $farm->owner_name }}</td>
                                </tr>
                                <!--end::Row-->

                                <!--begin::Row-->
                                <tr class="">
                                    <td class="text-gray-500">মোবাইল নং:</td>
                                    <td class="text-gray-800">{{ $farm->phone_number }}</td>
                                </tr>
                                <!--end::Row-->

                                <!--begin::Row-->
                                <tr class="">
                                    <td class="text-gray-500">ঠিকানা:</td>
                                    <td class="text-gray-800">{{ $farm->address }}</td>
                                </tr>
                                <!--end::Row-->
                            </table>
                            <!--end::Details-->
                        </div>
                        <!--end::Details-->
                    </div>
                    <!--end::Section-->

                    <!--begin::Seperator-->
                    <div class="separator separator-dashed mb-7"></div>
                    <!--end::Seperator-->

                    <!--begin::Section-->
                    <div class="mb-7">
                        <!--begin::Title-->
                        <h5 class="mb-4">গবাদি প্রাণির তথ্য
                        </h5>
                        <!--end::Title-->
                        <!--begin::Details-->
                        <div class="mb-0">
                            <!--begin::Details-->
                            <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2">
                                @foreach ($farm->livestockCounts as $livestockCount)
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-500">{{ $livestockCount->livestockType->name }}:</td>
                                        <td class="text-gray-800">{{ en2bn($livestockCount->total) }}টি</td>
                                    </tr>
                                    <!--end::Row-->
                                @endforeach

                                @if (count($farm->livestockCounts) == 0)
                                    <span class="text-muted fst-italic">কোনো গবাদি প্রাণি নেই</span>
                                @endif
                            </table>
                            <!--end::Details-->
                        </div>
                        <!--end::Details-->
                    </div>
                    <!--end::Section-->

                    <!--begin::Seperator-->
                    <div class="separator separator-dashed mb-7"></div>
                    <!--end::Seperator-->

                    <!--begin::Section-->
                    <div class="mb-10">
                        <!--begin::Title-->
                        <h5 class="mb-4">খামার এক্টিভেশন তথ্য</h5>
                        <!--end::Title-->
                        <!--begin::Details-->
                        <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2">
                            <!--begin::Row-->
                            <tr class="">
                                <td class="text-gray-500">অবস্থা:</td>
                                <td>
                                    @if ($farm->is_active == 0)
                                        <span class="badge badge-light-danger fs-6">নিষ্ক্রিয়</span>

                                    @elseif ($farm->is_active == 1 && $farm->status == 'pending')
                                        <span class="badge badge-light-warning fs-6">অনুমোদনের অপেক্ষায়</span>
                                        
                                    @elseif ($farm->is_active == 1 && $farm->status == 'approved')
                                        <span class="badge badge-light-success fs-6">সক্রিয়</span>
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
                                        title="{{ en2bn($farm->created_at->format('d-M-Y h:m:s A')) }}">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
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
                                        title="{{ en2bn($farm->approved_at->format('d-M-Y h:m:s A')) }}">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span>
                                </td>
                            </tr>
                            <!--end::Row-->
                            @endif

                            <!--begin::Row-->
                            <tr class="">
                                <td class="text-gray-500">মন্তব্য:</td>
                                <td class="text-gray-800">
                                    @if ($farm->remarks)
                                        {{ $farm->remarks }}
                                    @else
                                        <span class="text-gray-600">-</span>
                                    @endif
                                </td>
                            </tr>
                            <!--end::Row-->
                        </table>
                        <!--end::Details-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Sidebar-->

        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-10">
            <!--begin::Earnings-->
            <div class="card mb-6 mb-xl-9">
                <!--begin::Header-->
                <div class="card-header border-0">
                    <div class="card-title">
                        <h2>Earnings</h2>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-0">
                    <div class="fs-5 fw-semibold text-gray-500 mb-4">Last 30 day earnings calculated. Apart from
                        arranging the order of topics.</div>
                    <!--begin::Left Section-->
                    <div class="d-flex flex-wrap flex-stack mb-5">
                        <!--begin::Row-->
                        <div class="d-flex flex-wrap">
                            <!--begin::Col-->
                            <div class="border border-dashed border-gray-300 w-150px rounded my-3 p-4 me-6">
                                <span class="fs-1 fw-bold text-gray-800 lh-1">
                                    <span data-kt-countup="true" data-kt-countup-value="6,840"
                                        data-kt-countup-prefix="$">0</span>
                                    <i class="ki-outline ki-arrow-up fs-1 text-success">


                                    </i>
                                </span>
                                <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Net Earnings</span>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="border border-dashed border-gray-300 w-125px rounded my-3 p-4 me-6">
                                <span class="fs-1 fw-bold text-gray-800 lh-1">
                                    <span class="" data-kt-countup="true" data-kt-countup-value="16">0</span>%
                                    <i class="ki-outline ki-arrow-down fs-1 text-danger">


                                    </i></span>
                                <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Change</span>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="border border-dashed border-gray-300 w-150px rounded my-3 p-4 me-6">
                                <span class="fs-1 fw-bold text-gray-800 lh-1">
                                    <span data-kt-countup="true" data-kt-countup-value="1,240"
                                        data-kt-countup-prefix="$">0</span>
                                    <span class="text-primary">--</span>
                                </span>
                                <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Fees</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <a href="#" class="btn btn-sm btn-light-primary flex-shrink-0">Withdraw
                            Earnings</a>
                    </div>
                    <!--end::Left Section-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Earnings-->
            <!--begin::Statements-->
            <div class="card mb-6 mb-xl-9">
                <!--begin::Header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <div class="card-title">
                        <h2>Statement</h2>
                    </div>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Tab nav-->
                        <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs nav-line-tabs-2x border-transparent"
                            role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-active-primary active" data-bs-toggle="tab" role="tab"
                                    href="#kt_customer_view_statement_1">This Year</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab"
                                    href="#kt_customer_view_statement_2">2020</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab"
                                    href="#kt_customer_view_statement_3">2019</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab"
                                    href="#kt_customer_view_statement_4">2018</a>
                            </li>
                        </ul>
                        <!--end::Tab nav-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body pb-5">
                    <!--begin::Tab Content-->
                    <div id="kt_customer_view_statement_tab_content" class="tab-content">
                        <!--begin::Tab panel-->
                        <div id="kt_customer_view_statement_1" class="py-0 tab-pane fade show active" role="tabpanel">
                            <!--begin::Table-->
                            <table id="kt_customer_view_statement_table_1"
                                class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4">
                                <thead class="border-bottom border-gray-200">
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-125px">Date</th>
                                        <th class="w-100px">Order ID</th>
                                        <th class="w-300px">Details</th>
                                        <th class="w-100px">Amount</th>
                                        <th class="w-100px text-end pe-7">Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nov 01, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                        </td>
                                        <td>Darknight transparency 36 Icons Pack</td>
                                        <td class="text-success">$38.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 24, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-2.60</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 08, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Cartoon Mobile Emoji Phone Pack</td>
                                        <td class="text-success">$76.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sep 15, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                        <td class="text-success">$5.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>May 30, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-1.30</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apr 22, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                        </td>
                                        <td>Parcel Shipping / Delivery Service App</td>
                                        <td class="text-success">$204.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Feb 09, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                        </td>
                                        <td>Visual Design Illustration</td>
                                        <td class="text-success">$31.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                        </td>
                                        <td>Abstract Vusial Pack</td>
                                        <td class="text-success">$52.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jan 04, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-0.80</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                        </td>
                                        <td>Darknight transparency 36 Icons Pack</td>
                                        <td class="text-success">$38.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 24, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-2.60</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 08, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Cartoon Mobile Emoji Phone Pack</td>
                                        <td class="text-success">$76.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sep 15, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                        <td class="text-success">$5.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>May 30, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-1.30</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apr 22, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                        </td>
                                        <td>Parcel Shipping / Delivery Service App</td>
                                        <td class="text-success">$204.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Feb 09, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                        </td>
                                        <td>Visual Design Illustration</td>
                                        <td class="text-success">$31.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                        </td>
                                        <td>Abstract Vusial Pack</td>
                                        <td class="text-success">$52.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jan 04, 2021</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-0.80</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Tab panel-->
                        <!--begin::Tab panel-->
                        <div id="kt_customer_view_statement_2" class="py-0 tab-pane fade" role="tabpanel">
                            <!--begin::Table-->
                            <table id="kt_customer_view_statement_table_2"
                                class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4">
                                <thead class="border-bottom border-gray-200">
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-125px">Date</th>
                                        <th class="w-100px">Order ID</th>
                                        <th class="w-300px">Details</th>
                                        <th class="w-100px">Amount</th>
                                        <th class="w-100px text-end pe-7">Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>May 30, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-1.30</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apr 22, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                        </td>
                                        <td>Parcel Shipping / Delivery Service App</td>
                                        <td class="text-success">$204.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Feb 09, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                        </td>
                                        <td>Visual Design Illustration</td>
                                        <td class="text-success">$31.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                        </td>
                                        <td>Abstract Vusial Pack</td>
                                        <td class="text-success">$52.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jan 04, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-0.80</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                        </td>
                                        <td>Darknight transparency 36 Icons Pack</td>
                                        <td class="text-success">$38.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 24, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-2.60</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 08, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Cartoon Mobile Emoji Phone Pack</td>
                                        <td class="text-success">$76.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sep 15, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                        <td class="text-success">$5.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>May 30, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-1.30</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apr 22, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                        </td>
                                        <td>Parcel Shipping / Delivery Service App</td>
                                        <td class="text-success">$204.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Feb 09, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                        </td>
                                        <td>Visual Design Illustration</td>
                                        <td class="text-success">$31.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                        </td>
                                        <td>Abstract Vusial Pack</td>
                                        <td class="text-success">$52.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jan 04, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-0.80</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                        </td>
                                        <td>Darknight transparency 36 Icons Pack</td>
                                        <td class="text-success">$38.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 24, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-2.60</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 08, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Cartoon Mobile Emoji Phone Pack</td>
                                        <td class="text-success">$76.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sep 15, 2020</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                        <td class="text-success">$5.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Tab panel-->
                        <!--begin::Tab panel-->
                        <div id="kt_customer_view_statement_3" class="py-0 tab-pane fade" role="tabpanel">
                            <!--begin::Table-->
                            <table id="kt_customer_view_statement_table_3"
                                class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4">
                                <thead class="border-bottom border-gray-200">
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-125px">Date</th>
                                        <th class="w-100px">Order ID</th>
                                        <th class="w-300px">Details</th>
                                        <th class="w-100px">Amount</th>
                                        <th class="w-100px text-end pe-7">Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Feb 09, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                        </td>
                                        <td>Visual Design Illustration</td>
                                        <td class="text-success">$31.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                        </td>
                                        <td>Abstract Vusial Pack</td>
                                        <td class="text-success">$52.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jan 04, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-0.80</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sep 15, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                        <td class="text-success">$5.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                        </td>
                                        <td>Darknight transparency 36 Icons Pack</td>
                                        <td class="text-success">$38.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 24, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-2.60</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 08, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Cartoon Mobile Emoji Phone Pack</td>
                                        <td class="text-success">$76.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>May 30, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-1.30</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apr 22, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                        </td>
                                        <td>Parcel Shipping / Delivery Service App</td>
                                        <td class="text-success">$204.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Feb 09, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                        </td>
                                        <td>Visual Design Illustration</td>
                                        <td class="text-success">$31.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                        </td>
                                        <td>Abstract Vusial Pack</td>
                                        <td class="text-success">$52.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jan 04, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-0.80</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sep 15, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                        <td class="text-success">$5.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                        </td>
                                        <td>Darknight transparency 36 Icons Pack</td>
                                        <td class="text-success">$38.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 24, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-2.60</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 08, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Cartoon Mobile Emoji Phone Pack</td>
                                        <td class="text-success">$76.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>May 30, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-1.30</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apr 22, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                        </td>
                                        <td>Parcel Shipping / Delivery Service App</td>
                                        <td class="text-success">$204.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Tab panel-->
                        <!--begin::Tab panel-->
                        <div id="kt_customer_view_statement_4" class="py-0 tab-pane fade" role="tabpanel">
                            <!--begin::Table-->
                            <table id="kt_customer_view_statement_table_4"
                                class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-4">
                                <thead class="border-bottom border-gray-200">
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-125px">Date</th>
                                        <th class="w-100px">Order ID</th>
                                        <th class="w-300px">Details</th>
                                        <th class="w-100px">Amount</th>
                                        <th class="w-100px text-end pe-7">Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nov 01, 2018</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                        </td>
                                        <td>Darknight transparency 36 Icons Pack</td>
                                        <td class="text-success">$38.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 24, 2018</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-2.60</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2018</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                        </td>
                                        <td>Darknight transparency 36 Icons Pack</td>
                                        <td class="text-success">$38.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 24, 2018</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-2.60</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Feb 09, 2018</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                        </td>
                                        <td>Visual Design Illustration</td>
                                        <td class="text-success">$31.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2018</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                        </td>
                                        <td>Abstract Vusial Pack</td>
                                        <td class="text-success">$52.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jan 04, 2018</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-0.80</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 08, 2018</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Cartoon Mobile Emoji Phone Pack</td>
                                        <td class="text-success">$76.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 08, 2018</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Cartoon Mobile Emoji Phone Pack</td>
                                        <td class="text-success">$76.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Feb 09, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                        </td>
                                        <td>Visual Design Illustration</td>
                                        <td class="text-success">$31.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                        </td>
                                        <td>Abstract Vusial Pack</td>
                                        <td class="text-success">$52.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jan 04, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-0.80</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sep 15, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Iphone 12 Pro Mockup Mega Bundle</td>
                                        <td class="text-success">$5.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nov 01, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                        </td>
                                        <td>Darknight transparency 36 Icons Pack</td>
                                        <td class="text-success">$38.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 24, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-2.60</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oct 08, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                        </td>
                                        <td>Cartoon Mobile Emoji Phone Pack</td>
                                        <td class="text-success">$76.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>May 30, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                        </td>
                                        <td>Seller Fee</td>
                                        <td class="text-danger">$-1.30</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apr 22, 2019</td>
                                        <td>
                                            <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                        </td>
                                        <td>Parcel Shipping / Delivery Service App</td>
                                        <td class="text-success">$204.00</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Tab panel-->
                    </div>
                    <!--end::Tab Content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Statements-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Layout-->
@endsection


@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@push('page-js')
    <script>
        document.getElementById("farms_info_menu").classList.add("here", "show");
    </script>

    @if ($farm->status == 'approved')
        <script>
            document.getElementById("all_farms_link").classList.add("active");
        </script>
    @else
        <script>
            document.getElementById("farm_pending_approval_link").classList.add("active");
        </script>
    @endif
@endpush
