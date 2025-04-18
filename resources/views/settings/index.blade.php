@push('page-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush


@extends('layouts.app')

@section('title', 'সেটিংস')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            সকল সেটিংস
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
                    সেটিংস </a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                সিস্টেম </li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
@endsection


@section('content')
    @if ($errors->any())
        <div class="alert alert-danger fs-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="row">
        <div class="col-xxl-2 col-lg-3 mb-5">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        {{-- <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5">
                            </i>
                            <input type="text" data-kt-user-table-filter="search"
                                class="form-control form-control-solid w-250px ps-13"
                                placeholder="সেবার ধরণ অনুসন্ধান করুন" />
                        </div>
                        <!--end::Search--> --}}
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_category">
                                <i class="ki-outline ki-plus fs-2"></i>নতুন প্রাণি</a>
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
                    <table class="table table-hover align-middle fs-6 gy-5 qrlivestock-table" id="kt_table_livestock_types">
                        <thead>
                            <tr class="fw-bold fs-5 gs-0">
                                <th>প্রাণির ধরণ</th>
                                <th class="w-75px">কার্যক্রম</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold fs-5">
                            @foreach ($livestock_types as $type)
                                <tr>
                                    <td>{{ $type->name }}</td>
                                    <td>
                                        @if (auth()->user()->role == 'admin')
                                            <a href="{{ route('settings.edit', $type->id) }}" title="সংশোধন"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_edit_category"
                                                data-category-id="{{ $type->id }}"
                                                class="btn btn-icon text-hover-primary w-30px h-30px me-3">
                                                <i class="ki-outline ki-pencil fs-2"></i>
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
        </div>

        <div class="col-xxl-5 col-lg-5 mb-5">
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
                            <input type="text" data-kt-service-category-table-filter="search"
                                class="form-control form-control-solid w-250px ps-13"
                                placeholder="সেবার ধরণ অনুসন্ধান করুন" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_category">
                                <i class="ki-outline ki-plus fs-2"></i>নতুন সেবা</a>
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
                    <table class="table table-hover align-middle fs-6 gy-5 qrlivestock-table"
                        id="kt_table_service_categories">
                        <thead>
                            <tr class="fw-bold fs-5 gs-0">
                                <th>সেবার ধরণ</th>
                                <th class="w-75px">কার্যক্রম</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold fs-5">
                            @foreach ($service_categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if (auth()->user()->role == 'admin')
                                            <a href="{{ route('settings.edit', $category->id) }}" title="সংশোধন"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_edit_category"
                                                data-category-id="{{ $category->id }}"
                                                class="btn btn-icon text-hover-success w-30px h-30px me-3">
                                                <i class="ki-outline ki-pencil fs-2"></i>
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
        </div>

        <div class="col-xxl-5 col-lg-4">
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
                            <input type="text" data-kt-disease-table-filter="search"
                                class="form-control form-control-solid w-250px ps-13" placeholder="রোগ অনুসন্ধান করুন" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <a href="#" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_category">
                                <i class="ki-outline ki-plus fs-2"></i>নতুন রোগ</a>
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
                    <table class="table table-hover align-middle fs-6 gy-5 qrlivestock-table" id="kt_table_diseases">
                        <thead>
                            <tr class="fw-bold fs-5 gs-0">
                                <th>রোগের ধরণ</th>
                                <th class="w-75px">কার্যক্রম</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold fs-5">
                            @foreach ($diseases as $disease)
                                <tr>
                                    <td>{{ $disease->name }}</td>
                                    <td>
                                        @if (auth()->user()->role == 'admin')
                                            <a href="{{ route('settings.edit', $disease->id) }}" title="সংশোধন"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_edit_category"
                                                data-category-id="{{ $disease->id }}"
                                                class="btn btn-icon text-hover-info w-30px h-30px me-3">
                                                <i class="ki-outline ki-pencil fs-2"></i>
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
        </div>
    </div>
@endsection


@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@push('page-js')
    <script src="{{ asset('js/settings/index.js') }}"></script>

    <script>
        document.getElementById("settings_link").classList.add("active");
    </script>
@endpush
