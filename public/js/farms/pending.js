"use strict";

var KTPendingFarmsList = function () {
     // Define shared variables
     var table;
     var datatable;

     // Private functions
     var initDatatable = function () {
          // Init datatable --- more info on datatables: https://datatables.net/manual/
          datatable = $(table).DataTable({
               // responsive: true,                 // ✅ Make it responsive
               info: true,
               order: [],
               lengthMenu: [10, 25, 50, 100],
               pageLength: 10,
               lengthChange: true,
               autoWidth: false,                // Disable auto width
               columnDefs: [
                    { orderable: false, targets: [3, 4, 6, 7] }
               ]
          });

          // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
          datatable.on('draw', function () {

          });
     }

     // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
     var handleSearch = function () {
          const filterSearch = document.querySelector('[data-kt-farm-table-filter="search"]');
          filterSearch.addEventListener('keyup', function (e) {
               datatable.search(e.target.value).draw();
          });
     };

     // Farm Approval popup
     var handleFarmApproval = function () {
          document.addEventListener('click', function (event) {
               if (event.target.closest('.approve-farm')) {
                    event.preventDefault();

                    const button = event.target.closest('.approve-farm');
                    const farmId = button.dataset.farmId;
                    console.log('Farm ID: ', farmId);

                    Swal.fire({
                         title: 'নিশ্চিত?',
                         text: "আপনি কি নিশ্চিত এই খামার অনুমোদন করতে চান?",
                         icon: 'warning',
                         showCancelButton: true,
                         confirmButtonColor: '#3085d6',
                         cancelButtonColor: '#d33',
                         confirmButtonText: 'হ্যাঁ, অনুমোদন করবো',
                         cancelButtonText: 'ক্যানসেল',
                    }).then((result) => {
                         if (result.isConfirmed) {
                              const form = document.createElement('form');
                              form.method = 'POST';
                              form.action = `/farms/${farmId}/approve`;

                              const csrfTokenInput = document.createElement('input');
                              csrfTokenInput.type = 'hidden';
                              csrfTokenInput.name = '_token';
                              csrfTokenInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                              form.appendChild(csrfTokenInput);

                              const methodInput = document.createElement('input');
                              methodInput.type = 'hidden';
                              methodInput.name = '_method';
                              methodInput.value = 'POST';
                              form.appendChild(methodInput);

                              document.body.appendChild(form);
                              form.submit();
                         }
                    });
               }
          });
     };


     return {
          // Public functions  
          init: function () {
               table = document.getElementById('kt_pending_farms_table');

               if (!table) {
                    return;
               }

               initDatatable();
               handleSearch();
               handleFarmApproval();
          }
     }
}();


// On document ready
KTUtil.onDOMContentLoaded(function () {
     KTPendingFarmsList.init();
});