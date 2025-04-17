"use strict";

var KTPendingPrescriptionsList = function () {
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
                    { orderable: false, targets: [13] }
               ]
          });

          // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
          datatable.on('draw', function () {

          });
     }

     // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
     var handleSearch = function () {
          const filterSearch = document.querySelector('[data-kt-pending-prescriptions-table-filter="search"]');
          filterSearch.addEventListener('keyup', function (e) {
               datatable.search(e.target.value).draw();
          });
     };

     // Farm Approval popup
     // ------------------- handlePrescriptionApprovalAJAX --------------
     var handlePrescriptionApprovalAJAX = function () {
          const approveButtons = document.querySelectorAll('.approve-prescription');

          approveButtons.forEach(button => {
               button.addEventListener('click', function (event) {
                    event.preventDefault(); // Prevent the default action of the link

                    const prescriptionId = this.getAttribute('data-prescription-id'); // Get the farm ID
                    console.log('Prescription ID: ', prescriptionId);

                    // Show SweetAlert confirmation
                    Swal.fire({
                         title: 'নিশ্চিত?',
                         text: "আপনি কি নিশ্চিত এই প্রেসক্রিপশনটি অনুমোদন করবেন?",
                         icon: 'warning',
                         showCancelButton: true,
                         confirmButtonColor: '#3085d6',
                         cancelButtonColor: '#d33',
                         confirmButtonText: 'হ্যাঁ, অনুমোদন করবো',
                         cancelButtonText: 'ক্যানসেল',
                    }).then((result) => {
                         if (result.isConfirmed) {
                              fetch(`/prescriptions/${prescriptionId}/approve`, {
                                   method: 'POST',
                                   headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                   }
                              })
                                   .then(response => {
                                        if (!response.ok) {
                                             throw new Error('Approval failed');
                                        }
                                        return response.json();
                                   })
                                   .then(data => {
                                        toastr.success('প্রেসক্রিপশন সফলভাবে অনুমোদিত হয়েছে!');
                                        setTimeout(() => {
                                             location.reload();
                                        }, 2000); // Delay a bit to let user see the toast
                                   })
                                   .catch(error => {
                                        toastr.error('অনুমোদন ব্যর্থ হয়েছে। আবার চেষ্টা করুন।');
                                        console.error(error);
                                   });
                         }
                    });
               });
          });
     };

     return {
          // Public functions  
          init: function () {
               table = document.getElementById('kt_pending_prescriptions_table');

               if (!table) {
                    return;
               }

               initDatatable();
               handleSearch();
               handlePrescriptionApprovalAJAX();
          }
     }
}();


// On document ready
KTUtil.onDOMContentLoaded(function () {
     KTPendingPrescriptionsList.init();
});