"use strict";

var KTCustomDatatableHandler = function () {
     var initDatatable = function (tableId, searchFilterAttr, nonOrderableTargets = []) {
          const table = document.getElementById(tableId);
          if (!table) return;

          const datatable = $(table).DataTable({
               "info": false,
               'order': [],
               "lengthMenu": [10, 25, 50, 100],
               "pageLength": 10,
               "lengthChange": false,
               "autoWidth": false,
               'columnDefs': [{ orderable: false, targets: nonOrderableTargets }]
          });

          // Set up search filter
          const filterSearch = document.querySelector(`[${searchFilterAttr}]`);
          if (filterSearch) {
               filterSearch.addEventListener('keyup', function (e) {
                    datatable.search(e.target.value).draw();
               });
          }
     }

     return {
          init: function () {
               initDatatable('kt_table_service_categories', 'data-kt-service-category-table-filter="search"', [1]);
               initDatatable('kt_table_diseases', 'data-kt-disease-table-filter="search"', [1]);
          }
     }
}();

KTUtil.onDOMContentLoaded(function () {
     KTCustomDatatableHandler.init();
});
