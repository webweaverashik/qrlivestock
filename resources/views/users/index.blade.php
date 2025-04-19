@push('page-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush


@extends('layouts.app')

@section('title', 'ব্যবহারকারি')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            সকল ইউজার তালিকা
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
                ব্যবহারকারি </li>
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
                    <input type="text" data-kt-user-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="ইউজার অনুসন্ধান করুন" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Add user-->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <i class="ki-outline ki-plus fs-2"></i>নতুন ইউজার</a>
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
            <table class="table table-hover align-middle fs-6 gy-5 qrlivestock-table" id="kt_table_users">
                <thead>
                    <tr class="fw-bold fs-5 gs-0">
                        <th class="w-25px">ক্রঃ</th>
                        <th class="w-250px">ব্যবহারকারির তথ্য</th>
                        <th class="w-50px">রোল</th>
                        <th class="w-125px">সর্বশেষ লগিন</th>
                        <th class="w-50px">সক্রিয়/নিষ্ক্রিয়</th>
                        <th class="w-100px">কার্যক্রম</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold fs-5">
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ en2bn($loop->index + 1) }}</td>
                            <td>
                                <div class="d-flex">
                                    <!--begin:: Avatar -->
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                        <a href="{{ $user->photo_url ? asset($user->photo_url) : '#' }}">
                                            <div class="symbol-label">
                                                <img src="{{ $user->photo_url ? asset($user->photo_url) : asset('assets/img/dummy.png') }}"
                                                    alt="{{ $user->name }}" class="w-100" />
                                            </div>
                                        </a>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::user details-->
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800 mb-1">{{ $user->name }}</span>
                                        <span class="fw-semibold">{{ $user->email }}</span>
                                    </div>
                                    <!--begin::user details-->
                                </div>
                            </td>
                            <td>
                                @if ($user->role == 'staff')
                                    <div class="badge badge-light-info">স্টাফ</div>
                                @elseif ($user->role == 'admin')
                                    <div class="badge badge-light-success">এডমিন</div>
                                @endif
                            </td>
                            <td>
                                {{ en2bn(optional($user->loginActivities()->latest()->first())->created_at?->format('d-M-Y h:i:s A') ?? '-') }}
                            </td>
                            <td>
                                @if ($user->id != auth()->user()->id)
                                    @if ($user->is_active == 0)
                                        <div
                                            class="form-check form-switch form-check-solid form-check-success d-flex justify-content-center">
                                            <input class="form-check-input toggle-active" type="checkbox"
                                                value="{{ $user->id }}">
                                        </div>
                                    @elseif ($user->is_active == 1)
                                        <div
                                            class="form-check form-switch form-check-solid form-check-success d-flex justify-content-center">
                                            <input class="form-check-input toggle-active" type="checkbox"
                                                value="{{ $user->id }}" checked />
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('users.edit', $user->id) }}" title="সংশোধন" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_edit_user" data-user-id="{{ $user->id }}"
                                    class="btn btn-icon btn-active-light-warning w-30px h-30px me-3">
                                    <i class="ki-outline ki-pencil fs-2"></i>
                                </a>
                                @if ($user->id != auth()->user()->id)
                                    <a href="#" title="ডিলিট" data-bs-toggle="tooltip"
                                        class="btn btn-icon btn-active-light-danger w-30px h-30px me-3 delete-user"
                                        data-user-id="{{ $user->id }}">
                                        <i class="ki-outline ki-trash fs-2"></i>
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


    <!--begin::Modal - Add User-->
    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">নতুন ইউজার যুক্ত করুন</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1">
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body px-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_user_form" class="form" action="{{ route('users.store') }}"
                        enctype="multipart/form-data" method="POST">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_user_header"
                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="d-block fw-semibold fs-6 mb-5">প্রোফাইল ছবি</label>
                                <!--end::Label-->
                                <!--begin::Image placeholder-->
                                <style>
                                    .image-input-placeholder {
                                        background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}');
                                    }

                                    [data-bs-theme="dark"] .image-input-placeholder {
                                        background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}');
                                    }
                                </style>
                                <!--end::Image placeholder-->
                                <!--begin::Image input-->
                                <div class="image-input image-input-empty image-input-outline image-input-placeholder"
                                    data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="Change avatar">
                                        <i class="ki-outline ki-pencil fs-7">
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        title="Cancel avatar">
                                        <i class="ki-outline ki-cross fs-2">
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        title="Remove avatar">
                                        <i class="ki-outline ki-cross fs-2">
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Hint-->
                                <div class="form-text">Allowed file types: png, jpg, jpeg. Max 200kB</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">নাম</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="user_name_add"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="সম্পূর্ণ নাম লিখুন"
                                    value="{{ old('user_name') }}" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">ইমেইল</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="user_email_add"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com"
                                    value="{{ old('user_email') }}" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-5">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-5">রোল</label>
                                <!--end::Label-->
                                <!--begin::Roles-->
                                <!--begin::Input row-->
                                <div class="d-flex fv-row">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="user_role_add" type="radio"
                                            value="admin" id="kt_modal_add_role_admin"
                                            {{ old('user_role', 'staff') == 'admin' ? 'checked' : '' }} />
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_add_role_admin">
                                            <div class="fw-bold text-gray-800">এডমিন</div>
                                            <div class="text-gray-600">খামার অনুমোদন ও সংশোধন, প্রেস্ক্রিপশন অনুমোদন ও
                                                সংশোধন, সিস্টেম সেটিংস
                                            </div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Radio-->
                                </div>
                                <!--end::Input row-->
                                <div class='separator separator-dashed my-5'></div>
                                <!--begin::Input row-->
                                <div class="d-flex fv-row">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="user_role_add" type="radio"
                                            value="staff" id="kt_modal_add_role_staff"
                                            {{ old('user_role', 'staff') == 'staff' ? 'checked' : '' }} />
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_add_role_staff">
                                            <div class="fw-bold text-gray-800">স্টাফ</div>
                                            <div class="text-gray-600">খামার নিবন্ধন, রেজিস্টার এন্ট্রি, প্রেস্ক্রিপশন
                                                এন্ট্রি</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Radio-->
                                </div>
                                <!--end::Input row-->
                                <!--end::Roles-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-users-modal-action="cancel">বাতিল</button>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">যুক্ত করুন</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add User-->

    <!--begin::Modal - Edit User-->
    <div class="modal fade" id="kt_modal_edit_user" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_edit_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">ইউজার আপডেট করুন</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1">
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body px-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_edit_user_form" class="form" action="#" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_edit_user_header"
                            data-kt-scroll-wrappers="#kt_modal_edit_user_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="d-block fw-semibold fs-6 mb-5">প্রোফাইল ছবি</label>
                                <!--end::Label-->
                                <!--begin::Image placeholder-->
                                <style>
                                    .image-input-placeholder {
                                        background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}');
                                    }

                                    [data-bs-theme="dark"] .image-input-placeholder {
                                        background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}');
                                    }
                                </style>
                                <!--end::Image placeholder-->
                                <!--begin::Image input-->
                                <div class="image-input image-input-empty image-input-outline image-input-placeholder"
                                    data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px" id="kt_modal_edit_user_avatar"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="Change avatar">
                                        <i class="ki-outline ki-pencil fs-7">
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        title="Cancel avatar">
                                        <i class="ki-outline ki-cross fs-2">
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        title="Remove avatar">
                                        <i class="ki-outline ki-cross fs-2">
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Hint-->
                                <div class="form-text">Allowed file types: png, jpg, jpeg. Max 200kB</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">নাম</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="user_name"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="সম্পূর্ণ নাম লিখুন"
                                    value="{{ old('user_name') }}" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">ইমেইল</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="user_email"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="test@gmail.com"
                                    value="{{ old('user_email') }}" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-5">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-5">রোল</label>
                                <!--end::Label-->
                                <!--begin::Roles-->
                                <!--begin::Input row-->
                                <div class="d-flex fv-row">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="user_role" type="radio"
                                            value="admin" id="kt_modal_update_role_admin" />
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_role_admin">
                                            <div class="fw-bold text-gray-800">এডমিন</div>
                                            <div class="text-gray-600">খামার অনুমোদন ও সংশোধন, প্রেস্ক্রিপশন অনুমোদন ও
                                                সংশোধন, সিস্টেম সেটিংস
                                            </div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Radio-->
                                </div>
                                <!--end::Input row-->
                                <div class='separator separator-dashed my-5'></div>
                                <!--begin::Input row-->
                                <div class="d-flex fv-row">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="user_role" type="radio"
                                            value="staff" id="kt_modal_update_role_staff" />
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_role_staff">
                                            <div class="fw-bold text-gray-800">স্টাফ</div>
                                            <div class="text-gray-600">খামার নিবন্ধন, রেজিস্টার এন্ট্রি, প্রেস্ক্রিপশন
                                                এন্ট্রি</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Radio-->
                                </div>
                                <!--end::Input row-->
                                <!--end::Roles-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-users-modal-action="cancel">বাতিল</button>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">আপডেট</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Edit User-->
@endsection


@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@push('page-js')
    <script>
        const routeDeleteUser = "{{ route('users.destroy', ':id') }}";
        const routeToggleActive = "{{ route('users.toggleActive', ':id') }}";
    </script>

    <script src="{{ asset('js/users/index.js') }}"></script>

    <script>
        document.getElementById("users_link").classList.add("active");
    </script>

    <script>
        $(document).ready(function() {
            $(document).on("click", "[data-bs-target='#kt_modal_edit_user']", function() {
                let userId = $(this).data("user-id");
                let url = "/users/" + userId + "/edit"; // Adjust as per your route

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            let user = response.user;

                            // Set form action dynamically
                            $("#kt_modal_edit_user_form").attr("action", "/users/" + userId);

                            // Populate form fields
                            $("input[name='user_name']").val(user.name);
                            $("input[name='user_email']").val(user.email);
                            $("input[name='user_role'][value='" + user.role + "']").prop(
                                "checked", true);

                            // Profile image preview
                            if (user.photo_url) {
                                $("#kt_modal_edit_user_avatar").css("background-image", "url(" + user
                                    .photo_url + ")");
                            }
                        } else {
                            alert("User data not found!");
                        }
                    },
                    error: function() {
                        alert("Error fetching user data!");
                    },
                });
            });
        });
    </script>
@endpush
