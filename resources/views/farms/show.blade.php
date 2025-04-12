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
            {{ $farm->farm_name }}, &nbsp; <span class="text-muted">{{ $farm->unique_id }}</span>
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
                                <span class="text-gray-800 fs-2 fw-bold me-3">{{ $farm->farm_name }},
                                    {{ $farm->unique_id }}</span>
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
                                    title="{{ en2bn($farm->created_at->format('d-M-Y h:i:s A')) }}">
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
                                        title="{{ en2bn($farm->approved_at->format('d-M-Y h:i:s A')) }}">
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
                                        title="{{ en2bn($farm->serviceRecords()->latest()->value('created_at')->format('d-M-Y h:i:s A')) }}">
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

                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-150px py-3"
                                data-kt-menu="true">
                                @if ($farm->status == 'approved')
                                    <div class="menu-item px-3">
                                        <a href="{{ route('farms.id-card', $farm->id) }}"
                                            class="menu-link px-3 text-hover-primary"><i class="bi bi-download fs-2 me-2"></i>
                                            কার্ড ডাউনলোড</a>
                                    </div>
                                @endif

                                <div class="menu-item px-3">
                                    <a href="{{ route('farms.edit', $farm->id) }}"
                                        class="menu-link px-3 text-hover-primary"><i class="las la-pen fs-2 me-2"></i>
                                        সংশোধন</a>
                                </div>

                                @if (auth()->user()->role == 'admin')
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        @if ($farm->is_active == 0 && $farm->status == 'approved')
                                            <a href="#" class="menu-link px-3 text-hover-success toggle-active"
                                                data-farm-id="{{ $farm->id }}"><i class="las la-check fs-2 me-2"></i>
                                                সক্রিয় করুন</a>
                                        @elseif ($farm->is_active == 1 && $farm->status == 'pending')
                                            <a href="#" class="menu-link px-3 text-hover-success approve-farm"
                                                data-farm-id="{{ $farm->id }}"><i class="las la-check fs-2 me-2"></i>
                                                অনুমোদন করুন</a>
                                        @elseif ($farm->is_active == 1 && $farm->status == 'approved')
                                            <a href="#" class="menu-link px-3 text-hover-warning toggle-inactive"
                                                data-farm-id="{{ $farm->id }}"><i class="las la-times fs-2 me-2"></i>
                                                নিষ্ক্রিয় করুন</a>
                                        @endif
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link text-hover-danger px-3 delete-farm"
                                            data-farm-id={{ $farm->id }}><i class="las la-trash fs-2 me-2"></i>
                                            ডিলিট</a>
                                    </div>
                                    <!--end::Menu item-->
                                @endif
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
                    class="table table-hover table-row-dashed align-middle fs-6 gy-5 qrlivestock-table">
                    <thead>
                        <tr class="fw-bold fs-5 gs-0">
                            <th class="w-30px" rowspan="2">ক্র:</th>
                            <th class="w-100px" rowspan="2">তারিখ</th>
                            <th class="w-25px" rowspan="2">সেবার<br>ধরণ</th>
                            <th colspan="3">প্রজাতির সংখ্যা</th>
                            <th colspan="4">প্রজাতির ধরণ</th>
                            <th class="w-150px" rowspan="2">রোগের লক্ষণ</th>
                            <th class="w-100px" rowspan="2">পরীক্ষার<br>ফলাফল</th>
                            <th class="w-100px" rowspan="2">সম্ভাব্য<br>রোগ</th>
                            <th class="w-100px" rowspan="2">প্রেসক্রিপশন</th>
                        </tr>
                        <tr class="fw-bold fs-5 gs-0">
                            <th class="w-50px">পাল/ঝাঁক</th>
                            <th class="w-50px">আক্রান্ত</th>
                            <th class="w-50px">মৃত</th>
                            <th class="w-50px">প্রজাতি</th>
                            <th class="w-50px">জাত</th>
                            <th class="w-50px">লিঙ্গ</th>
                            <th class="w-50px">বয়স</th>
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
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span>
                                </td>
                                <td>{{ $record->serviceCategory->name }}</td>
                                <td>{{ $record->species_number_flock }}</td>
                                <td>{{ $record->species_number_infected }}</td>
                                <td>{{ $record->species_number_dead }}</td>
                                <td>{{ $record->species_type_species }}</td>
                                <td>{{ $record->species_type_breed }}</td>
                                <td>{{ $record->species_type_gender }}</td>
                                <td>{{ $record->species_type_age }}</td>
                                <td>{{ $record->history_of_disease }}</td>
                                <td>{{ $record->microscopic_result }}</td>
                                <td>{{ $record->disease->name }}</td>
                                <td>
                                    <a href="#" class="btn btn-icon text-hover-info" data-bs-toggle="modal"
                                        data-bs-target="#kt_view_prescription_modal" title="প্রেসক্রিপশন দেখুন"><i
                                            class="ki-outline ki-eye fs-2x me-2"></i>
                                    </a>

                                    <a href="{{ $record->prescription_id ?? asset('cards/dummy.pdf') }}"
                                        class="btn btn-icon text-hover-info" data-bs-toggle="tooltip"
                                        title="প্রেসক্রিপশন ডাউনলোড করুন"><i
                                            class="ki-outline ki-file-down fs-2x me-2"></i>
                                    </a>
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

    <!--begin::Modal - View Prescription-->
    <div class="modal fade" id="kt_view_prescription_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Create App</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1">
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-lg-5">
                    <!--begin::Content-->
                    <div class="flex-row-fluid p-lg-5">
                        <!--begin::Step 1-->
                        <div>
                            <div class="w-100">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span class="required">App Name</span>
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            title="Specify your unique app name">
                                            <i class="ki-outline ki-information-5 text-gray-500 fs-6">
                                            </i>
                                        </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-lg form-control-solid"
                                        name="name" placeholder="" value="" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                        <span class="required">Category</span>
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Select your app category">
                                            <i class="ki-outline ki-information-5 text-gray-500 fs-6">
                                            </i>
                                        </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin:Options-->
                                    <div class="fv-row">
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack mb-5 cursor-pointer">
                                            <!--begin:Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin:Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="ki-outline ki-compass fs-1 text-primary">
                                                        </i>
                                                    </span>
                                                </span>
                                                <!--end:Icon-->
                                                <!--begin:Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">Quick Online Courses</span>
                                                    <span class="fs-7 text-muted">Creating a clear text structure
                                                        is just one SEO</span>
                                                </span>
                                                <!--end:Info-->
                                            </span>
                                            <!--end:Label-->
                                            <!--begin:Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="category"
                                                    value="1" />
                                            </span>
                                            <!--end:Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack mb-5 cursor-pointer">
                                            <!--begin:Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin:Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-danger">
                                                        <i class="ki-outline ki-element-11 fs-1 text-danger">
                                                        </i>
                                                    </span>
                                                </span>
                                                <!--end:Icon-->
                                                <!--begin:Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">Face to Face Discussions</span>
                                                    <span class="fs-7 text-muted">Creating a clear text structure
                                                        is just one aspect</span>
                                                </span>
                                                <!--end:Info-->
                                            </span>
                                            <!--end:Label-->
                                            <!--begin:Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="category"
                                                    value="2" />
                                            </span>
                                            <!--end:Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer">
                                            <!--begin:Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin:Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-success">
                                                        <i class="ki-outline ki-timer fs-1 text-success">
                                                        </i>
                                                    </span>
                                                </span>
                                                <!--end:Icon-->
                                                <!--begin:Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">Full Intro Training</span>
                                                    <span class="fs-7 text-muted">Creating a clear text structure
                                                        copywriting</span>
                                                </span>
                                                <!--end:Info-->
                                            </span>
                                            <!--end:Label-->
                                            <!--begin:Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="category"
                                                    value="3" />
                                            </span>
                                            <!--end:Input-->
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end:Options-->
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>
                        <!--end::Step 1-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Stepper-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - View Prescription-->

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
    @elseif ($farm->status == 'pending')
        <script>
            document.getElementById("farm_pending_approval_link").classList.add("active");
        </script>
    @endif
@endpush
