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
    <!--begin::Navbar-->
    <div
        class="card mb-6 mb-xl-9 @if ($farm->status == 'pending') border border-dashed border-warning 
            @elseif ($farm->is_active == 0)
            border border-dashed border-danger @endif">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="row">
                <div class="col-md-6">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                        <!--begin::Image-->
                        <div
                            class="d-flex flex-center flex-shrink-0 bg-light rounded-circle w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                            <img class="mw-100px mw-lg-125px"
                                src="{{ $farm->photo_url ? asset($farm->photo_url) : asset('assets/img/dummy.png') }}"
                                alt="{{ $farm->name }}" />
                        </div>

                        <!--begin::Details-->
                        <div class="d-flex flex-column">
                            <!--begin::Farm Name-->
                            <div class="d-flex align-items-center mb-1">
                                <span
                                    class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{ $farm->farm_name }}</span>
                            </div>
                            <!--end::Farm Name-->

                            <div class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-500">
                                মালিকের নাম: &nbsp;<span class="text-gray-800">{{ $farm->owner_name }}</span>
                            </div>

                            <div class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-500">
                                মোবাইল নং: &nbsp;<span class="text-gray-800">{{ $farm->phone_number }}</span>
                            </div>

                            <div class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-500">
                                ঠিকানা: &nbsp;<span class="text-gray-800">{{ $farm->address }}</span>
                            </div>

                            <div class="d-flex flex-wrap fw-semibold mb-0 fs-5 text-gray-500">
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
                            <td class="text-gray-500">সর্বশেষ সেবা নিয়েছেন:</td>
                            <td class="text-gray-800">
                                @if (count($farm->serviceRecords) > 1)
                                    {{ en2bn($farm->serviceRecords()->latest()->value('created_at')->diffForHumans()) }}
                                    <span class="ms-1" data-bs-toggle="tooltip"
                                        title="{{ en2bn($farm->serviceRecords()->latest()->value('created_at')->format('d-M-Y h:m:s A')) }}">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
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

                <div class="col-md-1">
                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end mb-4">
                        <!--begin::Three Dots-->
                        <div class="me-0">
                            <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="ki-solid ki-dots-horizontal fs-2x"></i>
                            </button>
                            <!--begin::Three Dots-->

                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    @if ($farm->is_active == 0 && $farm->status == 'approved')
                                        <a href="#" class="menu-link px-3">সক্রিয় করুন</a>
                                    @elseif ($farm->is_active == 1 && $farm->status == 'pending')
                                        <a href="#" class="menu-link px-3">অনুমোদন করুন</a>
                                    @elseif ($farm->is_active == 1 && $farm->status == 'approved')
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
                                    <a href="#" class="menu-link text-danger px-3 delete-farm"
                                        data-farm-id={{ $farm->id }}>ডিলিট</a>
                                </div>
                                <!--end::Menu item-->

                            </div>
                            <!--end::Menu 3-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Actions-->
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
                <div class="d-flex align-items-center position-relative me-2">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5">
                    </i>
                    <input type="text" data-kt-farm-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="তথ্য অনুসন্ধান করুন" />
                </div>
                <!--end::Search-->

                <!--begin::Add user-->
                <a href="{{ route('farms.create') }}" class="btn btn-primary">
                    <i class="ki-outline ki-plus fs-2"></i>তথ্য যুক্ত করুন</a>
                <!--end::Add user-->
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
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
@endsection


@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@push('page-js')
    <script>
        const routeDeleteFarm = "{{ route('farms.destroy', ':id') }}";
        const routeToggleActive = "{{ route('farms.toggleActive', ':id') }}";
    </script>

    <script src="{{ asset('js/farms/show.js') }}"></script>

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
