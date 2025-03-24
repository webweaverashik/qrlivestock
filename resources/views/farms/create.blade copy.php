@push('page-css')
@endpush


@extends('layouts.app')

@section('title', 'নতুন নিবন্ধন')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            খামার নিবন্ধন ফর্ম
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
                খামার নিবন্ধন </li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
@endsection


@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Form-->
            <form action="{{ route('farms.store') }}" class="form d-flex flex-column flex-lg-row" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!--begin::Aside column-->
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>খামারির ছবি</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body text-center pt-0">
                            <!--begin::Image input-->
                            <!--begin::Image input placeholder-->
                            <style>
                                .image-input-placeholder {
                                    background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}');
                                }

                                [data-bs-theme="dark"] .image-input-placeholder {
                                    background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}');
                                }
                            </style>
                            <!--end::Image input placeholder-->

                            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                data-kt-image-input="true">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-150px h-150px"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="ki-outline ki-pencil fs-7">
                                    </i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="photo_url" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="ki-outline ki-cross fs-2">
                                    </i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="ki-outline ki-cross fs-2">
                                    </i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->

                            <!--begin::Description-->
                            <div class="text-muted fs-6">খামার মালিকের ছবি আপলোড করুন। শুধুমাত্র *.png, *.jpg and *.jpeg
                                ফরম্যাট গ্রহণযোগ্য এবং সর্বোচ্চ ফাইল সাইজ ২০০ কিলোবাইট।</div>
                            @error('photo_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!--end::Description-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Thumbnail settings-->
                </div>
                <!--end::Aside column-->

                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

                    <!--begin::খামারের তথ্য-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>খামারের তথ্য</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label fs-4">খামারের নাম</label>
                                <span class="ms-1" data-bs-toggle="tooltip"
                                    title="খামারের সম্পূর্ণ নাম এখানে এন্ট্রি দিন।">
                                    <i class="ki-outline ki-information fs-7"></i>
                                </span>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="farm_name" class="form-control mb-2"
                                    placeholder="যেমন: সাহাদ জাহান ডেইরি ফার্ম" value="{{ old('farm_name') }}" required />
                                @error('farm_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label fs-4">খামার মালিকের নাম</label>
                                <span class="ms-1" data-bs-toggle="tooltip"
                                    title="খামার মালিকের নাম এখানে এন্ট্রি দিন।">
                                    <i class="ki-outline ki-information fs-7"></i>
                                </span>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="owner_name" class="form-control mb-2"
                                    placeholder="যেমন: আবু সায়েম" value="{{ old('owner_name') }}" required />
                                @error('owner_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label fs-4">মোবাইল নং</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="phone_number" class="form-control mb-2" id="phone_number"
                                    placeholder="যেমন: ০১৯১২-৩৪৫৬৭৮" value="{{ old('phone_number') }}" required />
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Label-->
                                <label class="form-label">খামারের ঠিকানা</label>
                                <span class="ms-1" data-bs-toggle="tooltip"
                                    title="খামারের পরিপূর্ণ ঠিকানা এন্ট্রি দিন">
                                    <i class="ki-outline ki-information fs-7"></i>
                                </span>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="address" class="form-control mb-2"
                                    placeholder="যেমন: রাস্তা, গ্রাম, ইউনিয়ন, উপজেলা, জেলা"
                                    value="{{ old('address') }}" />
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::খামারের তথ্য-->

                    <!--begin::Variations-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>পশুপাখির বিবরণ</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="" data-kt-add-farm-repeater="auto-options">
                                <!--begin::Label-->
                                <label class="form-label fs-4">পশুপাখির সংখ্যা</label>
                                <!--end::Label-->

                                <!--begin::Repeater-->
                                <div id="livestock_count_options">
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="livestock_count_options"
                                            class="d-flex flex-column gap-3">
                                            <div data-repeater-item=""
                                                class="form-group d-flex flex-wrap align-items-center gap-5">
                                                <!--begin::Select2-->
                                                <div class="w-100 w-md-200px">
                                                    <select class="form-select" name="livestock_counts"
                                                        data-placeholder="প্রাণির ধরণ বাছাই করুন"
                                                        data-kt-add-farm-repeater="livestock_counts"
                                                        data-control="select2">
                                                        <option selected disabled>বাছাই করুন</option>
                                                        @foreach ($livestock_types as $livestock_type)
                                                            <option value="{{ $livestock_type->id }}">
                                                                {{ $livestock_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!--end::Select2-->

                                                <!--begin::Input-->
                                                <input type="number" class="form-control mw-100 w-200px"
                                                    name="livestock_counts_value" placeholder="সংখ্যা লিখুন" />
                                                <!--end::Input-->
                                                <button type="button" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-light-danger">
                                                    <i class="ki-outline ki-cross fs-1">
                                                    </i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form group-->
                                    <!--begin::Form group-->
                                    <div class="form-group mt-5">
                                        <button type="button" data-repeater-create=""
                                            class="btn btn-sm btn-light-primary">
                                            <i class="ki-duotone ki-plus fs-2"></i>আরেকটি তথ্য দিন</button>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                                <!--end::Repeater-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::Variations-->

                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <button type="reset" class="btn btn-secondary me-5">রিসেট</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label">সাবমিট</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Main column-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content container-->
    </div>
@endsection


@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
@endpush

@push('page-js')
    {{-- <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js') }}"></script> --}}

    <script>
        document.getElementById("farms_info_menu").classList.add("here", "show");
        document.getElementById("farm_registration_link").classList.add("active");
    </script>

    {{-- Form Validation --}}
    <script>
        // Phone
        /* Inputmask({
            "mask": "99999-999999",
        }).mask("#phone_number"); */

        $('#livestock_count_options').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                initConditionsSelect2();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        // Init condition select2
        const initConditionsSelect2 = () => {
            // Tnit new repeating condition types
            const allConditionTypes = document.querySelectorAll(
                '[data-kt-add-farm-repeater="livestock_counts"]');
            allConditionTypes.forEach(type => {
                if ($(type).hasClass("select2-hidden-accessible")) {
                    return;
                } else {
                    $(type).select2({
                        minimumResultsForSearch: -1
                    });
                }
            });
        }
    </script>
@endpush
