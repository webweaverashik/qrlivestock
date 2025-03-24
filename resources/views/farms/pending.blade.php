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
                            <input type="text" data-kt-user-table-filter="search"
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
                    <table class="table table-hover align-middle fs-6 gy-5" id="kt_table_farms_pending">
                        <thead>
                            <tr class="fw-bold fs-5 text-uppercase gs-0">
                                <th class="w-50px text-center">ক্রঃ</th>
                                <th class="">খামারের নাম</th>
                                <th class="">খামারির তথ্য</th>
                                <th class="text-center">ঠিকানা</th>
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
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
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
                                                <span>ফোন: {{ $farm->phone_number }}</span>
                                            </div>
                                            <!--begin::Owner details-->
                                        </div>
                                    </td>
                                    <td class="text-center text-wrap">{{ $farm->address }}</td>
                                    <td class="text-center">
                                        @foreach ($farm->livestockCounts as $livestockCount)
                                            {{ $livestockCount->livestockType->name }}: {{ $livestockCount->total }}টি
                                            <br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">{{ $farm->created_at->format('d-M-Y') }}</td>
                                    <td class="text-center">
                                        <div class="badge badge-light-warning fw-bold">অপেক্ষমাণ</div>
                                    </td>
                                    <td class="text-center">
                                        {{-- <a href="#" title="অনুমোদন করুন" data-bs-toggle="tooltip"
                                            class="btn btn-icon btn-active-success w-30px h-30px me-3 approve-farm"
                                            data-farm-id="{{ $farm->id }}">
                                            <i class="ki-outline ki-double-check fs-2"></i>
                                        </a> --}}
                                        <form action="{{ route('farms.approve', $farm->id) }}" method="post">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-icon btn-active-success w-30px h-30px me-3"
                                                title="অনুমোদন করুন" data-bs-toggle="tooltip">
                                                <i class="ki-outline ki-double-check fs-2"></i>
                                            </button>
                                        </form>
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
    {{-- <script src="{{ asset('assets/js/custom/apps/user-management/users/list/table.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/apps/user-management/users/list/export-users.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/apps/user-management/users/list/add.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $('#kt_table_farms_pending').DataTable();
        });
    </script>

    <script>
        document.getElementById("farms_info_menu").classList.add("here", "show");
        document.getElementById("farm_pending_approval_link").classList.add("active");
    </script>

    {{-- Farm approval alert modal dialog --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const approveButtons = document.querySelectorAll('.approve-farm');

            approveButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default action of the link

                    const farmId = this.dataset.farmId; // Get the farm ID

                    // Show SweetAlert confirmation
                    Swal.fire({
                        title: 'আপনি কি নিশ্চিত এই খামার অনুমোদন করতে চান?',
                        text: "আপনি কি নিশ্চিত এই খামার অনুমোদন করতে চান?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'হ্যাঁ, অনুমোদন করবো।',
                        cancelButtonText: 'ক্যানসেল',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a hidden form element dynamically
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/farms/${farmId}/approve`;

                            // Add CSRF token input
                            const csrfTokenInput = document.createElement('input');
                            csrfTokenInput.type = 'hidden';
                            csrfTokenInput.name = '_token';
                            csrfTokenInput.value = document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content');
                            form.appendChild(csrfTokenInput);

                            // Add method field for POST (since we are using resource routes)
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'POST';
                            form.appendChild(methodInput);

                            // Append the form to the body and submit it
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
