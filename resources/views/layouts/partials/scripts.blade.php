    <script>
        var hostUrl = "assets/";
    </script>

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script>
        function en2bnNumber(number) {
            const enToBnMap = {
                '0': '০',
                '1': '১',
                '2': '২',
                '3': '৩',
                '4': '৪',
                '5': '৫',
                '6': '৬',
                '7': '৭',
                '8': '৮',
                '9': '৯'
            };
            return number.toString().replace(/[0-9]/g, d => enToBnMap[d]);
        }
    </script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used for this page only)-->
    @stack('vendor-js')
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(used for this page only)-->
    @stack('page-js')
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script> --}}
    <!--end::Custom Javascript-->

    @include('layouts.partials.toastr')
