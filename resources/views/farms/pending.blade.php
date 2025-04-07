@push('page-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush


@extends('layouts.app')

@section('title', 'পেন্ডিং খামার')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            অনুমোদনের অপেক্ষায় খামার তালিকা
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
                পেন্ডিং খামার </li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
@endsection


@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
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
                            <input type="text" data-kt-farm-table-filter="search"
                                class="form-control form-control-solid w-250px ps-13" placeholder="খামার অনুসন্ধান করুন" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table table-hover table-row-dashed align-middle fs-6 gy-5" id="kt_pending_farms_table">
                        <thead>
                            <tr class="fw-bold fs-5 text-uppercase gs-0">
                                <th class="w-50px text-center">ক্রঃ</th>
                                <th class="">খামারের নাম</th>
                                <th class="">খামারির তথ্য</th>
                                <th class="text-center">খামারের ঠিকানা</th>
                                <th class="text-center">গবাদি প্রাণির তথ্য</th>
                                <th class="text-center">নিবন্ধনের তারিখ</th>
                                <th class="text-center">অবস্থা</th>
                                <th class="text-center">অনুমোদন</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold fs-5">
                            @foreach ($farms as $farm)
                                {{-- <tr @if ($farm->is_active == 0) class="bg-light-warning" @endif> --}}
                                <tr>
                                    <td class="text-center">{{ en2bn($loop->index + 1) }}</td>
                                    <td class="text-start">
                                        <!--begin::Farm details-->
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('farms.show', $farm->id) }}"
                                                class="text-gray-800 text-hover-primary mb-1">{{ $farm->farm_name }}</a>
                                            <span>ID: <strong>{{ $farm->unique_id }}</strong></span>
                                        </div>
                                        <!--begin::Farm details-->

                                    </td>
                                    <td class="">
                                        <div class="d-flex align-items-center">
                                            <!--begin:: Avatar -->
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <a href="{{ route('farms.show', $farm->id) }}">
                                                    <div class="symbol-label">
                                                        <img src="{{ $farm->photo_url ? asset($farm->photo_url) : asset('assets/media/avatars/300-5.jpg') }}"
                                                            alt="{{ $farm->owner_name }}" class="w-100" />
                                                    </div>
                                                </a>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Owner details-->
                                            <div class="d-flex flex-column ">
                                                <a href="{{ route('farms.show', $farm->id) }}"
                                                    class="text-gray-800 text-hover-primary mb-1">{{ $farm->owner_name }}</a>
                                                    <span><i class="las la-phone"></i><strong>
                                                        {{ en2bn($farm->phone_number) }}</strong></span>
                                            </div>
                                            <!--begin::Owner details-->
                                        </div>
                                    </td>
                                    <td class="text-center text-wrap">{{ $farm->address }}</td>
                                    <td class="text-center">
                                        @foreach ($farm->livestockCounts as $livestockCount)
                                            {{ $livestockCount->livestockType->name }}: {{ en2bn($livestockCount->total) }}টি
                                            <br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        {{ en2bn($farm->created_at->format('d-M-Y')) }}
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                        title="{{ en2bn($farm->created_at->format('d-M-Y h:m:s A')) }}">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span></td>
                                    <td class="text-center">
                                        <div class="badge badge-light-warning fw-bold">অপেক্ষমাণ</div>
                                    </td>
                                    <td class="text-center">
                                            <button class="btn btn-icon btn-active-success w-30px h-30px me-3 approve-farm" 
                                                title="অনুমোদন করুন" data-bs-toggle="tooltip" data-farm-id="{{ $farm->id }}">
                                                <i class="ki-outline ki-double-check fs-2"></i>
                                            </button>
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
        <!--end::Content container-->
    </div>
@endsection



@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@push('page-js')
    <script src="{{ asset('js/farms/pending.js') }}"></script>

    <script>
        document.getElementById("farms_info_menu").classList.add("here", "show");
        document.getElementById("farm_pending_approval_link").classList.add("active");
    </script>
@endpush
