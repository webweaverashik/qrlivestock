@push('page-css')
@endpush


@extends('layouts.app')

@section('title', 'সেবা প্রদান ফর্ম')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            নতুন সেবা এন্ট্রি ফর্ম
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
                সেবা প্রদান
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

    <div class="row">
        <!--begin::Form-->
        <div class="col-xl-9 mb-10 mb-xl-0">
            <form action="{{ route('records.store') }}" class="form d-flex flex-column" method="POST">
                @csrf
                <!--begin::Left column-->
                <div class="d-flex flex-column">
                    <!--begin::খামারের তথ্য-->
                    <div class="card card-flush mb-6 py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>সেবা ফর্ম</h2>
                            </div>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-lg-6">
                                    <!--begin::farm Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="form-label required fs-4">খামার নির্বাচন</label>
                                        <!--end::Label-->

                                        <!--begin::Solid input group style-->
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text">
                                                <i class="bi bi-house-door fs-3"></i>
                                            </span>
                                            <div class="overflow-hidden flex-grow-1">
                                                <select name="farm_id" class="form-select rounded-start-0 border-start"
                                                    data-control="select2" data-placeholder="খামার বাছাই করুন" required>
                                                    <option></option>
                                                    @foreach ($farms as $farm)
                                                        <option value="{{ $farm->id }}"
                                                            {{ old('farm_id') == $farm->id ? 'selected' : '' }}>
                                                            {{ $farm->farm_name }} (ID: {{ $farm->unique_id }})
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <!--end::Solid input group style-->
                                    </div>
                                    <!--end::farm Input group-->
                                </div>

                                <div class="col-lg-6">
                                    <!--begin::Input group-->
                                    <div class="mb-8 fv-row">
                                        <label class="form-label required fs-4">সেবার ধরণ</label>
                                        <select name="service_category_id" class="form-select" data-control="select2"
                                            data-placeholder="সেবার ধরণ বাছাই করুন" required>
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
                                            <input type="number" name="species_number_flock" class="form-control mb-2"
                                                placeholder="পাল/ঝাঁক" value="{{ old('species_number_flock') }}"
                                                min="1" />
                                            <input type="number" name="species_number_infected" class="form-control mb-2"
                                                placeholder="আক্রান্ত" value="{{ old('species_number_infected') }}"
                                                min="1" />
                                            <input type="number" name="species_number_dead" class="form-control mb-2"
                                                placeholder="মৃত" value="{{ old('species_number_dead') }}"
                                                min="1" />
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
                                            <input type="text" name="species_type_species" class="form-control mb-2"
                                                placeholder="প্রজাতি" value="{{ old('species_type_species') }}" />
                                            <input type="text" name="species_type_breed" class="form-control mb-2"
                                                placeholder="জাত" value="{{ old('species_type_breed') }}" />

                                            <select name="species_type_gender" class="form-select mb-2"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="লিঙ্গ বাছাই করুন">
                                                <option></option>
                                                <option value="male"
                                                    {{ old('species_type_gender') == 'male' ? 'selected' : '' }}>মর্দা
                                                </option>
                                                <option value="female"
                                                    {{ old('species_type_gender') == 'female' ? 'selected' : '' }}>মাদি
                                                </option>
                                            </select>

                                            <input type="text" name="species_type_age" class="form-control mb-2"
                                                placeholder="বয়স" value="{{ old('species_type_age') }}" />
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
                                        <label class="fs-4 fw-semibold mb-2">আনুবিক্ষণিক পরীক্ষার ফলাফল &nbsp; <span
                                                class="text-muted fs-6">(প্রযোজ্য হলে)</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="species_type_species" class="form-control mb-2"
                                            placeholder="প্রজাতি" value="{{ old('species_type_species') }}" />
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

                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::খামারের তথ্য-->

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
        <!--end::Form-->

        <!--begin::Aside column-->
        <div class="col-xl-3">
            <!--begin::Thumbnail settings-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>খামারের তথ্য</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="d-flex flex-column align-items-center mb-6">
                        <!--begin::Image-->
                        <div class="d-flex flex-center flex-shrink-0 bg-light rounded-circle w-125px h-125px me-7 mb-4">
                            <img class="w-100 p-3" src="{{ asset('assets/img/dummy.png') }}" alt="খামার"
                                id="ajax_photo" />
                        </div>

                        <!--begin::Details-->
                        <div class="d-flex flex-column">
                            <!--begin::Farm Name-->
                            <div class="d-flex align-items-center mb-1">
                                <span class="text-gray-800 fs-2 fw-bold" id="ajax_farm_name">সাহাদ জাহান ডেইরি ফার্ম,</span> &nbsp;
                                <span class="text-gray-800 fs-2 fw-bold me-3" id="ajax_unique_id">412033</span>
                            </div>
                            <!--end::Farm Name-->

                            <div class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-500">
                                মালিকের নাম: &nbsp;<span class="text-gray-800" id="ajax_owner_name">আবু সায়েম</span>
                            </div>

                            <div class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-500">
                                মোবাইল নং: &nbsp;<span class="text-gray-800" id="ajax_phone_number">০১৭৭৮২৬৬৮৮৫</span>
                            </div>

                            <div class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-500">
                                ঠিকানা: &nbsp;<span class="text-gray-800" id="ajax_address">চরনাপ্তা, ভোলা সদর</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Thumbnail settings-->
        </div>
        <!--end::Aside column-->
    </div>
@endsection


@push('vendor-js')
@endpush

@push('page-js')
    <script src="{{ asset('js/records/create.js') }}"></script>

    <script>
        document.getElementById("treatment_menu").classList.add("here", "show");
        document.getElementById("all_records_link").classList.add("active");
    </script>
@endpush
