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
            সকল সক্রিয় খামারের তালিকা
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
                        <div class="px-7 py-5" data-kt-farm-table-filter="form">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">একটিভেশন অবস্থা:</label>
                                <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                    data-placeholder="সক্রিয়তা সিলেক্ট করুন" data-allow-clear="true"
                                    data-kt-farm-table-filter="two-step" data-hide-search="true">
                                    <option></option>
                                    <option value="ActiveFarm">সক্রিয়</option>
                                    <option value="PausedFarm">নিষ্ক্রিয়</option>
                                </select>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                    data-kt-menu-dismiss="true" data-kt-farm-table-filter="reset">রিসেট
                                    করুন</button>
                                <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true"
                                    data-kt-farm-table-filter="filter">এপ্লাই
                                    করুন</button>
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
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table table-hover table-row-dashed align-middle fs-6 gy-5 qrlivestock-table" id="kt_farms_table">
                <thead>
                    <tr class="fw-bold fs-5 gs-0">
                        <th class="w-50px text-center">ক্রঃ</th>
                        <th class="">খামারের নাম</th>
                        <th class="min-w-125px">খামারির তথ্য</th>
                        <th class="text-center w-250px">গবাদি প্রাণির তথ্য</th>
                        <th class="min-w-125px text-center">সর্বশেষ সেবা নিয়েছে</th>
                        <th class="min-w-125px text-center">অনুমোদনের অবস্থা</th>
                        <th class="d-none">সক্রিয়/নিষ্ক্রিয় (filter)</th>
                        <th class="min-w-125px text-center">সক্রিয়/নিষ্ক্রিয়</th>
                        <th class="text-center">কার্ড ডাউনলোড</th>
                        <th class="min-w-100px text-center">কার্যক্রম</th>
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
                            <td>
                                <div class="d-flex align-items-center">
                                    <!--begin:: Avatar -->
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                        <a href="{{ route('farms.show', $farm->id) }}">
                                            <div class="symbol-label">
                                                <img src="{{ $farm->photo_url ? asset($farm->photo_url) : asset('assets/img/dummy.png') }}"
                                                    alt="{{ $farm->owner_name }}" class="w-100" />
                                            </div>
                                        </a>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Owner details-->
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('farms.show', $farm->id) }}"
                                            class="text-gray-800 text-hover-primary mb-1">{{ $farm->owner_name }}</a>
                                        <span><i class="las la-phone"></i><strong>
                                                {{ en2bn($farm->phone_number) }}</strong></span>
                                    </div>
                                    <!--begin::Owner details-->
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="row">
                                    @foreach ($farm->livestockCounts as $livestockCount)
                                        <div class="col-md-6">
                                            {{ $livestockCount->livestockType->name }}:
                                            {{ en2bn($livestockCount->total) }}টি
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>
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
                            <td>
                                @if ($farm->status == 'pending')
                                    <div class="badge badge-light-warning fw-bold">অপেক্ষমাণ</div>
                                @elseif ($farm->status == 'approved')
                                    <div class="badge badge-light-success fw-bold">অনুমোদিত</div>
                                @endif
                            </td>
                            <td class="d-none">
                                @if ($farm->is_active == 0)
                                    PausedFarm
                                @elseif ($farm->is_active == 1)
                                    ActiveFarm
                                @endif
                            </td>
                            <td>
                                @if (auth()->user()->role == 'admin')
                                    <div
                                        class="form-check form-switch form-check-solid form-check-success d-flex justify-content-center">
                                        <input class="form-check-input toggle-active" type="checkbox"
                                            value="{{ $farm->id }}"
                                            @if ($farm->is_active == 1) checked @endif />
                                    </div>
                                @elseif (auth()->user()->role == 'staff')
                                    @if ($farm->is_active == 1)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-warning">নিষ্ক্রিয়</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($farm->qr_code)
                                    <a href="{{ route('farms.id-card', $farm->id) }}" class="text-muted text-hover-info"
                                        data-bs-toggle="tooltip" title="খামারের আইডি কার্ড ডাউনলোড করুন">
                                        <i class="bi bi-download fs-2"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (auth()->user()->role == 'admin')
                                    <a href="#" class="btn btn-light btn-sm" data-kt-menu-trigger="click"
                                        data-kt-menu-placement="bottom-end">কার্যক্রম
                                        <i class="ki-outline ki-down fs-5 m-0"></i></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('farms.edit', $farm->id) }}"
                                                class="menu-link px-3 text-hover-primary"><i
                                                    class="las la-pen fs-2 me-2"></i>সংশোধন</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3 text-hover-danger delete-farm"
                                                data-farm-id="{{ $farm->id }}"><i
                                                    class="las la-trash fs-2 me-2"></i>ডিলিট</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                @elseif (auth()->user()->role == 'staff')
                                    <a href="{{ route('farms.edit', $farm->id) }}"
                                        class="btn btn-icon btn-active-light-success w-30px h-30px me-3"
                                        title="সংশোধন করুন" data-bs-toggle="tooltip">
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
@endsection



@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@push('page-js')
    <script>
        const routeDeleteFarm = "{{ route('farms.destroy', ':id') }}";
        const routeToggleActive = "{{ route('farms.toggleActive', ':id') }}";
    </script>

    <script src="{{ asset('js/farms/index.js') }}"></script>

    <script>
        document.getElementById("farms_info_menu").classList.add("here", "show");
        document.getElementById("all_farms_link").classList.add("active");
    </script>
@endpush
