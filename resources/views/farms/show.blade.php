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
    @if ($errors->any())
        <div
            class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
            <!--begin::Icon-->
            <i class="ki-duotone ki-information fs-2hx text-danger me-4 mb-5 mb-sm-0">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
            </i>
            <!--end::Icon-->

            <!--begin::Content-->
            <div class="d-flex flex-column pe-0 pe-sm-10">
                <h5 class="mb-1 text-danger">নিম্নোক্ত এররগুলো চেক করুন।</h5>
                @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </div>
            <!--end::Content-->

            <!--begin::Close-->
            <button type="button"
                class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                data-bs-dismiss="alert">
                <i class="ki-outline ki-cross fs-1 text-danger"></i>
            </button>
            <!--end::Close-->
        </div>
    @endif

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
                        <div class="d-flex flex-center flex-shrink-0 bg-light rounded-circle w-125px h-125px me-7 mb-4">
                            <img class="w-100 p-3"
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
                                মোবাইল নং: &nbsp;<span class="text-gray-800">{{ en2bn($farm->phone_number) }}</span>
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
                                @if (count($farm->serviceRecords) > 0)
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
                                            class="menu-link px-3 text-hover-primary"><i
                                                class="bi bi-download fs-2 me-2"></i>
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
                @if ($farm->is_active == 1 && $farm->status == 'approved')
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_add_record_modal">
                        <i class="ki-outline ki-plus fs-2"></i>নতুন রেকর্ড</a>
                    <!--end::Add user-->
                @endif
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
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
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
                                        <a href="#" class="btn btn-icon text-hover-info" data-bs-toggle="modal"
                                            data-bs-target="#kt_view_prescription_modal" title="প্রেসক্রিপশন দেখুন"
                                            data-prescription-id="{{ $record->prescription_id }}"><i
                                                class="ki-outline ki-eye fs-2x me-2"></i>
                                        </a>

                                        <a href="{{ route('prescriptions.download', $record->prescription_id) }}"
                                            class="btn btn-icon text-hover-info" data-bs-toggle="tooltip"
                                            title="প্রেসক্রিপশন ডাউনলোড করুন"><i class="ki-outline ki-file-down fs-2x"></i>
                                        </a>
                                    @elseif ($record->prescription && $record->prescription->status == 'pending')
                                        <span class="badge badge-warning">পেন্ডিং</span>
                                        <br>
                                        <a href="#" class="btn btn-icon text-hover-info" data-bs-toggle="modal"
                                            data-bs-target="#kt_view_prescription_modal" title="প্রেসক্রিপশন দেখুন"
                                            data-prescription-id="{{ $record->prescription_id }}"><i
                                                class="ki-outline ki-eye fs-2x me-2"></i>
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-icon text-hover-info" data-bs-toggle="modal"
                                            data-bs-target="#kt_add_prescription_modal" title="প্রেসক্রিপশন যুক্ত করুন"
                                            data-service-record-id="{{ $record->id }}"><i
                                                class="bi bi-plus-circle fs-2"></i>
                                        </a>
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

    <!--begin::Modal - Add Record-->
    <div class="modal fade" id="kt_add_record_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>{{ $farm->farm_name }} এর সেবা ফর্ম</h2>
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
                        <div>
                            <form action="{{ route('records.storeFromShow', $farm->id) }}"
                                class="form d-flex flex-column" method="POST">
                                @csrf
                                <!--begin::Left column-->
                                <div class="d-flex flex-column">

                                    <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <!--begin::Input group-->
                                            <div class="mb-8 fv-row">
                                                <label class="form-label required fs-4">সেবার ধরণ</label>
                                                <select name="service_category_id" class="form-select"
                                                    data-control="select2" data-placeholder="সেবার ধরণ বাছাই করুন"
                                                    required>
                                                    <option></option>
                                                    @foreach ($serviceCategories as $cateogry)
                                                        <option value="{{ $cateogry->id }}"
                                                            {{ old('service_category_id') == $cateogry->id ? 'selected' : '' }}>
                                                            {{ $cateogry->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <!--begin::Input group-->
                                            <div class="mb-8 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label fs-4">প্রজাতির সংখ্যা &nbsp;
                                                    <span class="text-muted fs-6">(প্রযোজ্য হলে)</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="d-flex gap-3">
                                                    <input type="number" name="species_number_flock"
                                                        class="form-control mb-2" placeholder="পাল/ঝাঁক"
                                                        value="{{ old('species_number_flock') }}" min="1" />
                                                    <input type="number" name="species_number_infected"
                                                        class="form-control mb-2" placeholder="আক্রান্ত"
                                                        value="{{ old('species_number_infected') }}" min="1" />
                                                    <input type="number" name="species_number_dead"
                                                        class="form-control mb-2" placeholder="মৃত"
                                                        value="{{ old('species_number_dead') }}" min="1" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <!--begin::Input group-->
                                            <div class="mb-8 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label fs-4">প্রজাতির ধরণ &nbsp; <span
                                                        class="text-muted fs-6">(প্রযোজ্য
                                                        হলে)</span></label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="d-flex gap-3">
                                                    <input type="text" name="species_type_species"
                                                        class="form-control mb-2" placeholder="প্রজাতি"
                                                        value="{{ old('species_type_species') }}" />
                                                    <input type="text" name="species_type_breed"
                                                        class="form-control mb-2" placeholder="জাত"
                                                        value="{{ old('species_type_breed') }}" />

                                                    <select name="species_type_gender" class="form-select mb-2"
                                                        data-control="select2" data-hide-search="true"
                                                        data-placeholder="লিঙ্গ বাছাই করুন">
                                                        <option></option>
                                                        <option value="male"
                                                            {{ old('species_type_gender') == 'male' ? 'selected' : '' }}>
                                                            মর্দা
                                                        </option>
                                                        <option value="female"
                                                            {{ old('species_type_gender') == 'female' ? 'selected' : '' }}>
                                                            মাদি
                                                        </option>
                                                    </select>

                                                    <input type="text" name="species_type_age"
                                                        class="form-control mb-2" placeholder="বয়স"
                                                        value="{{ old('species_type_age') }}" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-4 fw-semibold mb-2">রোগের ইতিহাস &nbsp; <span
                                                        class="text-muted fs-6">(প্রযোজ্য হলে)</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <textarea class="form-control" rows="3" name="history_of_disease" placeholder="এই রোগের পূর্ব বিবরণ লিখুন">{{ old('history_of_disease') }}</textarea>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        <div class="col-lg-6">
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-4 fw-semibold mb-2">রোগের লক্ষণ &nbsp; <span
                                                        class="text-muted fs-6">(প্রযোজ্য হলে)</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <textarea class="form-control" rows="3" name="symptoms_of_disease" placeholder="রোগের লক্ষণ সমূহ লিখুন">{{ old('symptoms_of_disease') }}</textarea>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-4 fw-semibold mb-2">আনুবিক্ষণিক পরীক্ষার ফলাফল
                                                    &nbsp; <span class="text-muted fs-6">(প্রযোজ্য হলে)</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="microscopic_result" class="form-control mb-2"
                                                    placeholder="ফলাফল লিখুন" value="{{ old('microscopic_result') }}" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        <div class="col-lg-6">
                                            <!--begin::Input group-->
                                            <div class="mb-8 fv-row">
                                                <label class="form-label fs-4">সম্ভাব্য রোগ নির্ণয় &nbsp; <span
                                                        class="text-muted fs-6">(প্রযোজ্য হলে)</span></label>
                                                <select name="disease_id" class="form-select" data-control="select2"
                                                    data-placeholder="রোগ বাছাই করুন">
                                                    <option></option>
                                                    @foreach ($diseases as $disease)
                                                        <option value="{{ $disease->id }}"
                                                            {{ old('disease_id') == $disease->id ? 'selected' : '' }}>
                                                            {{ $disease->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <!--begin::Button-->
                                        <button type="reset" class="btn btn-secondary me-5">রিসেট</button>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" id="kt_add_record_submit" class="btn btn-primary">
                                            <span class="indicator-label">সাবমিট করুন</span>
                                            <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                </div>
                                <!--end::Left column-->
                            </form>
                        </div>
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add Record-->

    <!--begin::Modal - Add Prescription-->
    <div class="modal fade" id="kt_add_prescription_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered mw-1000px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>{{ $farm->farm_name }} এর প্রেসক্রিপশন ফর্ম</h2>
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
                            <form action="{{ route('prescriptions.store') }}" class="form d-flex flex-column"
                                method="POST" id="kt_add_prescription_form">
                                @csrf
                                <!--begin::Left column-->
                                <div class="d-flex flex-column">

                                    <!--begin::Row-->
                                    <div class="row">
                                        <input type="hidden" name="service_record_id" id="service_record_id_input">

                                        <div class="col-lg-4">
                                            <!--begin::Input group-->
                                            <div class="mb-8 fv-row">
                                                <label class="form-label required fs-4">গবাদি প্রাণির ধরণ</label>
                                                <select name="livestock_type_id" class="form-select"
                                                    data-control="select2" data-hide-search="true"
                                                    data-placeholder="ধরণ বাছাই করুন" required>
                                                    <option></option>
                                                    @foreach ($livestockTypes as $type)
                                                        <option value="{{ $type->id }}"
                                                            {{ old('livestock_type_id') == $type->id ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        <div class="col-lg-4">
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-4 fw-semibold mb-2">বয়স
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="livestock_age" class="form-control mb-2"
                                                    placeholder="প্রাণির বয়স লিখুন" value="{{ old('livestock_age') }}" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        <div class="col-lg-4">
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-4 fw-semibold mb-2">ওজন
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="livestock_weight" class="form-control mb-2"
                                                    placeholder="প্রাণির ওজন লিখুন"
                                                    value="{{ old('livestock_weight') }}" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        <div class="col-lg-12">
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-4 fw-semibold mb-2 required">রোগের বিবরণ
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div id="kt_disease_brief_editor" class="min-h-150px mb-2"></div>
                                                <input type="hidden" name="disease_brief" id="disease_brief_input">
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        <div class="col-lg-12">
                                            <!--begin::Input group-->
                                            <div class="mb-8 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label fs-4">ডায়াগনোসিস তথ্য &nbsp;
                                                    <span class="text-muted fs-6">(প্রযোজ্য হলে)</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="d-flex gap-3">
                                                    <input type="text" name="livestock_temp" class="form-control mb-2"
                                                        placeholder="Temp" value="{{ old('livestock_temp') }}"
                                                        min="1" />
                                                    <input type="text" name="livestock_pulse"
                                                        class="form-control mb-2" placeholder="Pulse"
                                                        value="{{ old('livestock_pulse') }}" min="1" />
                                                    <input type="text" name="livestock_rumen_motility"
                                                        class="form-control mb-2" placeholder="Rumen Motility"
                                                        value="{{ old('livestock_rumen_motility') }}" min="1" />
                                                    <input type="text" name="livestock_respiratory"
                                                        class="form-control mb-2" placeholder="Respiratory Rate"
                                                        value="{{ old('livestock_respiratory') }}" min="1" />
                                                    <input type="text" name="livestock_other"
                                                        class="form-control mb-2" placeholder="Other"
                                                        value="{{ old('livestock_other') }}" min="1" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        <div class="col-lg-12">
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-4 fw-semibold mb-2 required">চিকিৎসাপত্র
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div id="kt_medication_editor" class="min-h-150px mb-2"></div>
                                                <input type="hidden" name="medication" id="medication_input">
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        <div class="col-lg-12">
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-4 fw-semibold mb-2">মন্তব্য
                                                    &nbsp; <span class="text-muted fs-6">(প্রযোজ্য হলে)</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="additional_notes" class="form-control mb-2"
                                                    placeholder="অন্য কোনো সাজেশন থাকলে লিখুন"
                                                    value="{{ old('additional_notes') }}" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>
                                    <!--end::Row-->

                                    <div class="d-flex justify-content-end">
                                        <!--begin::Button-->
                                        <button type="reset" class="btn btn-secondary me-5">রিসেট</button>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" id="kt_add_record_submit" class="btn btn-primary">
                                            <span class="indicator-label">সাবমিট করুন</span>
                                            <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                        <!--end::Button-->
                                    </div>

                                </div>
                                <!--end::Left column-->
                            </form>
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
    <!--end::Modal - Add Prescription-->

    <!--begin::Modal - View Prescription-->
    <div class="modal fade" id="kt_view_prescription_modal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>সেবা রেজিস্টার এর প্রেসক্রিপশন ফর্ম <span id="view_precription_status"></span></h2>
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
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-5 fv-row">
                        <!--begin::Label-->
                        <label class="fs-4 fw-semibold mb-2">রোগের বিবরণ
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div id="kt_disease_brief_data" class="mb-2"></div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-5 fv-row">
                        <!--begin::Label-->
                        <label class="fs-4 fw-semibold mb-2">চিকিৎসাপত্র
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <div id="kt_medication_data" class="mb-2"></div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-5 fv-row">
                        <!--begin::Label-->
                        <label class="fs-4 fw-semibold mb-2">মন্তব্য
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div id="kt_additional_notes_data" class="mb-2"></div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Modal body-->

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">বন্ধ করুন</button>

                    @if (auth()->user()->role == 'admin')
                        <button type="button" class="btn btn-success" id="prescription_approve_button"
                            data-prescription-id="">অনুমোদন করুন</button>
                    @else
                        {{-- Used to avoid js error for admin approval button --}}
                        <button type="button" style="display: none !important;"
                            id="prescription_approve_button">Demo</button>
                    @endif
                </div>
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
