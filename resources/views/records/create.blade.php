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

    <!--begin::Form-->
    <form action="{{ route('records.store') }}" class="form d-flex flex-column flex-lg-row" method="POST">
        @csrf
        <div class="d-flex flex-wrap">
            <!--begin::Aside column-->
            <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-xxl-400px mb-7 me-lg-7">
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
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::farm Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="form-label required fs-4">খামার নির্বাচন</label>
                                    <!--end::Label-->

                                    <!--begin::Solid input group style-->
                                    <div class="input-group input-group-solid flex-nowrap">
                                        <span class="input-group-text">
                                            <i class="bi bi-house fs-3"></i>
                                        </span>
                                        <div class="overflow-hidden flex-grow-1">
                                            <select name="record_farm_id"
                                                class="form-select form-select-solid rounded-start-0 border-start"
                                                data-control="select2" data-placeholder="খামার বাছাই করুন" required>
                                                <option></option>
                                                @foreach ($farms as $farm)
                                                    <option value="{{ $farm->id }}">{{ $farm->farm_name }}
                                                        (ID: {{ $farm->unique_id }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @error('record_farm_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <!--end::Solid input group style-->
                                </div>
                                <!--end::farm Input group-->
                            </div>

                            <div class="col-lg-12">
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

                                <div class="image-input image-input-empty image-input-circle image-input-outline image-input-placeholder mb-3"
                                    data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                    <!--end::Preview existing avatar-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Thumbnail settings-->
            </div>
            <!--end::Aside column-->

            <!--begin::Right column-->
            <div class="d-flex flex-column flex-row-fluid gap-7 mb-7">
                <!--begin::খামারের তথ্য-->
                <div class="card card-flush py-4">
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
                            <div class="col-lg-12">
                                <!--begin::Input group-->
                                <div class="mb-8 fv-row">
                                    <label class="form-label required fs-4">সেবার ধরণ</label>
                                    <select name="record_service_cateogry" class="form-select" data-control="select2"
                                        data-placeholder="সেবার ধরণ বাছাই করুন" required>
                                        <option></option>
                                        @foreach ($serviceCategories as $cateogry)
                                            <option value="{{ $cateogry->id }}">{{ $cateogry->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('farm_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>

                            <div class="col-lg-12">
                                <!--begin::Input group-->
                                <div class="mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="required form-label">Quantity</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="d-flex gap-3">
                                        <input type="number" name="shelf" class="form-control mb-2"
                                            placeholder="On shelf" value="" />
                                        <input type="number" name="warehouse" class="form-control mb-2"
                                            placeholder="In warehouse" />
                                        <input type="number" name="warehouse" class="form-control mb-2"
                                            placeholder="In warehouse" />
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Enter the product quantity.</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::Input group-->
                                <div class="mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="required form-label">Quantity</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="d-flex gap-3">
                                        <input type="number" name="shelf" class="form-control mb-2"
                                            placeholder="On shelf" value="" />
                                        <input type="number" name="warehouse" class="form-control mb-2"
                                            placeholder="In warehouse" />
                                        <input type="number" name="warehouse" class="form-control mb-2"
                                            placeholder="In warehouse" />
                                        <input type="number" name="warehouse" class="form-control mb-2"
                                            placeholder="In warehouse" />
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Enter the product quantity.</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::খামারের তথ্য-->
            </div>
            <!--end::Right column-->

            <!--begin::Bottom Row-->
            <div class="d-flex flex-column w-100 mb-7">
                <div class="d-flex justify-content-end">
                    <!--begin::Button-->
                    <button type="reset" class="btn btn-secondary me-5">রিসেট</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                        <span class="indicator-label">সাবমিট</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
            <!--end::Bottom Row-->
        </div>
    </form>
    <!--end::Form-->
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
