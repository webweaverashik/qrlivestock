@push('page-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush


@extends('layouts.app')

@section('title', 'সেবা রেজিস্টার')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            সেবাপ্রদান রেজিস্টার
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
                সার্ভিস রেজিস্টার
            </li>
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
                    <input type="text" data-kt-service-records-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="সেবা অনুসন্ধান করুন" />
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
                        <div class="px-7 py-5" data-kt-service-records-table-filter="form">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">একটিভেশন অবস্থা:</label>
                                <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                    data-placeholder="সক্রিয়তা সিলেক্ট করুন" data-allow-clear="true"
                                    data-kt-service-records-table-filter="two-step" data-hide-search="true">
                                    <option></option>
                                    <option value="ActiveFarm">সক্রিয়</option>
                                    <option value="PausedFarm">নিষ্ক্রিয়</option>
                                </select>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                    data-kt-menu-dismiss="true" data-kt-service-records-table-filter="reset">রিসেট
                                    করুন</button>
                                <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true"
                                    data-kt-service-records-table-filter="filter">এপ্লাই
                                    করুন</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Menu 1-->
                    <!--end::Filter-->
                    <!--begin::Add user-->
                    <a href="{{ route('records.create') }}" class="btn btn-primary">
                        <i class="ki-outline ki-plus fs-2"></i>নতুন রেকর্ড</a>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table id="kt_service_records_table"
                class="table table-hover table-row-dashed align-middle fs-6 gy-5 qrlivestock-table">
                <thead>
                    <tr class="fw-bold fs-5 gs-0">
                        <th class="w-30px" rowspan="2">ক্র:</th>
                        <th class="w-30px" rowspan="2">তারিখ</th>
                        <th class="w-100px" rowspan="2">খামারের নাম</th>
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
                    @foreach ($serviceRecords as $record)
                        <tr>
                            <td>{{ en2bn($loop->index + 1) }}</td>
                            <td>
                                {{ en2bn($record->created_at->format('d M Y')) }}
                                <span class="ms-1" data-bs-toggle="tooltip"
                                    title="{{ en2bn($record->created_at->format('d-M-Y h:i:s A')) }}">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                            </td>
                            <td>
                                <!--begin::Farm details-->
                                <div class="d-flex flex-column">
                                    <a href="{{ route('farms.show', $record->farm_id) }}"
                                        class="text-gray-800 text-hover-primary mb-1">{{ $record->farm->farm_name }}</a>
                                    <span>ID: <strong>{{ $record->farm->unique_id }}</strong></span>
                                </div>
                                <!--begin::Farm details-->
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

                                    <a href="{{ route('prescriptions.download', $record->prescription_id) }}" class="btn btn-icon text-hover-info"
                                        data-bs-toggle="tooltip" title="প্রেসক্রিপশন ডাউনলোড করুন"><i
                                            class="ki-outline ki-file-down fs-2x"></i>
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
                                        data-service-record-id="{{ $record->id }}">
                                        <i class="bi bi-plus-circle fs-2"></i>
                                    </a>
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

    <!--begin::Modal - Add Prescription-->
    <div class="modal fade" id="kt_add_prescription_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>সেবা রেজিস্টার এর প্রেসক্রিপশন ফর্ম</h2>
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
                    <h2>সেবা রেজিস্টার এর প্রেসক্রিপশন ফর্ম
                        <span id="view_precription_status"></span>
                    </h2>
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
            <!--end::Modal Content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - View Prescription-->
@endsection


@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@push('page-js')
    <script src="{{ asset('js/records/index.js') }}"></script>

    <script>
        document.getElementById("treatment_menu").classList.add("here", "show");
        document.getElementById("all_records_link").classList.add("active");
    </script>
@endpush
