@push('page-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush


@extends('layouts.app')

@section('title', 'সকল খামার')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            সকল খামারের তালিকা
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
                সকল খামার </li>
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
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Filter-->
                            <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <i class="ki-outline ki-filter fs-2">
                                </i>ফিল্টার</button>
                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Separator-->
                                <!--begin::Content-->
                                <div class="px-7 py-5" data-kt-user-table-filter="form">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <label class="form-label fs-6 fw-semibold">Role:</label>
                                        <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                            data-placeholder="Select option" data-allow-clear="true"
                                            data-kt-user-table-filter="role" data-hide-search="true">
                                            <option></option>
                                            <option value="Administrator">Administrator</option>
                                            <option value="Analyst">Analyst</option>
                                            <option value="Developer">Developer</option>
                                            <option value="Support">Support</option>
                                            <option value="Trial">Trial</option>
                                        </select>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <label class="form-label fs-6 fw-semibold">Two Step Verification:</label>
                                        <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                            data-placeholder="Select option" data-allow-clear="true"
                                            data-kt-user-table-filter="two-step" data-hide-search="true">
                                            <option></option>
                                            <option value="Enabled">Enabled</option>
                                        </select>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset"
                                            class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                            data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                                        <button type="submit" class="btn btn-primary fw-semibold px-6"
                                            data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Menu 1-->
                            <!--end::Filter-->

                            <!--begin::Add user-->
                            <a href="{{ route('farms.create') }}" class="btn btn-primary">
                                <i class="ki-outline ki-plus fs-2"></i>নতুন নিবন্ধন</a>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none"
                            data-kt-user-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                            </div>
                            <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete
                                Selected</button>
                        </div>
                        <!--end::Group actions-->

                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table table-hover table-row-bordered align-middle fs-6 gy-5" id="kt_table_farms">
                        <thead>
                            <tr class="fw-bold fs-5 text-uppercase gs-0">
                                <th class="w-50px text-center">ক্রঃ</th>
                                <th class="min-w-125px">খামারের নাম</th>
                                <th class="min-w-125px">খামারির তথ্য</th>
                                <th class="min-w-125px">নিবন্ধনের তারিখ</th>
                                <th class="min-w-125px">সর্বশেষ সেবা নিয়েছে</th>
                                <th class="min-w-125px">অনুমোদনের অবস্থা</th>
                                <th class="min-w-125px">একটিভ/ডিএকটিভ</th>
                                <th class="text-center min-w-100px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold fs-5">
                            @foreach ($farms as $farm)
                                <tr @if ($farm->is_active == 0) class="bg-light-danger" @endif>
                                    <td class=" text-center">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <!--begin::User details-->
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('farms.show', $farm->id) }}"
                                                class="text-gray-800 text-hover-primary mb-1">{{ $farm->farm_name }}</a>
                                            <span>ID: <strong>{{ $farm->unique_id }}</strong></span>
                                        </div>
                                        <!--begin::User details-->

                                    </td>
                                    <td class="d-flex align-items-center">
                                        <!--begin:: Avatar -->
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="{{ route('farms.show', $farm->id) }}">
                                                <div class="symbol-label">
                                                    <img src="{{ $farm->photo_url ?? asset('assets/media/avatars/300-5.jpg') }}"
                                                        alt="{{ $farm->owner_name }}" class="w-100" />
                                                </div>
                                            </a>
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::User details-->
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('farms.show', $farm->id) }}"
                                                class="text-gray-800 text-hover-primary mb-1">{{ $farm->owner_name }}</a>
                                        </div>
                                        <!--begin::User details-->
                                    </td>
                                    {{-- <td>{{ $farm->farm_name }}</td> --}}
                                    <td>{{ $farm->created_at }}</td>
                                    <td>
                                        @if (count($farm->serviceRecords) > 1)
                                            {{ $farm->serviceRecords()->latest()->value('created_at')->diffForHumans() }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($farm->status == 'pending')
                                            <div class="badge badge-warning fw-bold">অপেক্ষমাণ</div>
                                        @elseif ($farm->status == 'approved')
                                            <div class="badge badge-success fw-bold">অনুমোদিত</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($farm->status == 'pending')
                                            -
                                        @elseif ($farm->status == 'approved')
                                            <div class="form-check form-switch form-check-solid form-check-success">
                                                <input class="form-check-input toggle-active" type="checkbox"
                                                    value="{{ $farm->id }}"
                                                    @if ($farm->is_active == 1) checked @endif />
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('farms.show', $farm->id) }}"
                                            class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                            <i class="ki-outline ki-eye fs-3"></i>
                                        </a>
                                        <a href="{{ route('farms.edit', $farm->id) }}"
                                            class="btn btn-icon btn-active-light-warning w-30px h-30px me-3">
                                            <i class="ki-outline ki-pencil fs-3"></i>
                                        </a>
                                        <a href="#"
                                            class="btn btn-icon btn-active-light-danger w-30px h-30px me-3 delete-farm"
                                            data-farm-id="{{ $farm->id }}">
                                            <i class="ki-outline ki-trash fs-3"></i>
                                        </a>
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
            $('#kt_table_farms').DataTable();
        });
    </script>

    <script>
        document.getElementById("farms_info_menu").classList.add("here", "show");
        document.getElementById("all_farms_link").classList.add("active");
    </script>

    {{-- Delete button alert modal dialog --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-farm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const farmId = this.dataset.farmId;

                    Swal.fire({
                        title: 'আপনি কি নিশ্চিত ডিলিট করতে চান?',
                        text: "ডিলিট করার পর এই খামারির তথ্য আর পাওয়া যাবে না।",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'হ্যাঁ, ডিলিট করবো।',
                        cancelButtonText: 'ক্যানসেল',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch("{{ route('farms.destroy', '') }}/" + farmId, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        _method: 'DELETE'
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: 'সফল!',
                                            text: 'খামারি সফলভাবে ডিলিট করা হয়েছে।',
                                            icon: 'success',
                                            confirmButtonText: 'ঠিক আছে।'
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        Swal.fire('ব্যর্থ!', 'খামারি ডিলিট করা যায়নি।',
                                            'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('ব্যর্থ!', 'একটি ত্রুটি হয়েছে। অনুগ্রহ করে সাপোর্টে যোগাযোগ করুন।', 'error');
                                });
                        }
                    });
                });
            });
        });
    </script>

    {{-- Toggle active/inactive button --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleInputs = document.querySelectorAll('.toggle-active');

            toggleInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const farmId = this.value;
                    const isActive = this.checked ? 1 : 0;

                    fetch("{{ route('farms.toggleActive') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                farm_id: farmId,
                                is_active: isActive
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'সফল!',
                                    text: data.message,
                                    confirmButtonText: 'ঠিক আছে।'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ব্যর্থ!',
                                    text: data.message,
                                    confirmButtonText: 'ঠিক আছে।'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'ব্যর্থ!',
                                text: 'একটি ত্রুটি হয়েছে। অনুগ্রহ করে সাপোর্টে যোগাযোগ করুন।',
                                confirmButtonText: 'ঠিক আছে।'
                            });
                        });
                });
            });
        });
    </script>
@endpush
