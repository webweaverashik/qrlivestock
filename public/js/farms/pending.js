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
          const approveButtons = document.querySelectorAll('.approve-farm');

          approveButtons.forEach(button => {
               button.addEventListener('click', function (event) {
                    event.preventDefault(); // Prevent the default action of the link

                    const farmId = this.dataset.farmId; // Get the farm ID
                    console.log('Farm ID: ', farmId);

                    // Show SweetAlert confirmation
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