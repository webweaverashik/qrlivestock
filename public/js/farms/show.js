"use strict";

var KTFarmView = function () {
     // Define shared variables
     var table;
     var datatable;
     let quillInstances = {};

     // Private functions
     var initDatatable = function () {
          // Init datatable --- more info on datatables: https://datatables.net/manual/
          datatable = $(table).DataTable({
               "info": true,
               'order': [],
               "lengthMenu": [10, 25, 50, 100],
               "pageLength": 10,
               "lengthChange": true,
               "autoWidth": false,  // Disable auto width
               'columnDefs': [{ orderable: false, targets: [13] }]
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
     }

     // Delete farm
     var handleDeletion = function () {
          document.querySelectorAll('.delete-farm').forEach(item => {
               item.addEventListener('click', function (e) {
                    e.preventDefault();

                    let farmId = this.getAttribute('data-farm-id');
                    console.log('Farm ID:', farmId);

                    let url = routeDeleteFarm.replace(':id', farmId);  // Replace ':id' with actual student ID

                    Swal.fire({
                         title: 'আপনি কি নিশ্চিত ডিলিট করতে চান?',
                         text: "ডিলিট করার পর এই খামারির তথ্য আর পাওয়া যাবে না।",
                         icon: 'warning',
                         showCancelButton: true,
                         confirmButtonColor: '#3085d6',
                         cancelButtonColor: '#d33',
                         confirmButtonText: 'হ্যাঁ, ডিলিট করবো',
                         cancelButtonText: 'ক্যানসেল',
                    }).then((result) => {
                         if (result.isConfirmed) {
                              fetch(url, {
                                   method: "DELETE",
                                   headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                                   },
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
                                                  window.location.href = '/farms'; // Redirect to farms index page
                                             });
                                        } else {
                                             Swal.fire('ব্যর্থ!', 'খামারি ডিলিট করা যায়নি।',
                                                  'error');
                                        }
                                   })
                                   .catch(error => {
                                        console.error("Fetch Error:", error);
                                        Swal.fire('ব্যর্থ!',
                                             'একটি ত্রুটি হয়েছে। অনুগ্রহ করে সাপোর্টে যোগাযোগ করুন।',
                                             'error');
                                   });
                         }
                    });
               });
          });
     };

     // Toggle activation
     var handleToggleActivation = function () {
          const activateBtn = document.querySelector('.toggle-active');
          const deactivateBtn = document.querySelector('.toggle-inactive');

          const attachClickHandler = (btn, isActive) => {
               if (!btn) return;

               btn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const farmId = this.getAttribute('data-farm-id');
                    const url = routeToggleActive.replace(':id', farmId);

                    const swalOptions = isActive
                         ? {
                              title: 'নিশ্চিত?',
                              text: "আপনি কি নিশ্চিত এই খামার সক্রিয় করতে চান?",
                              icon: 'warning',
                              confirmButtonText: 'হ্যাঁ, সক্রিয় করবো',
                              confirmButtonColor: '#3085d6',
                              cancelButtonText: 'ক্যানসেল',
                              cancelButtonColor: '#d33',
                         }
                         : {
                              title: 'নিশ্চিত?',
                              text: "আপনি কি নিশ্চিত এই খামার নিষ্ক্রিয় করতে চান?",
                              icon: 'warning',
                              confirmButtonText: 'হ্যাঁ, নিষ্ক্রিয় করবো',
                              confirmButtonColor: '#f59e0b',
                              cancelButtonText: 'ক্যানসেল',
                              cancelButtonColor: '#d33',
                         };

                    Swal.fire({
                         ...swalOptions,
                         showCancelButton: true,
                    }).then((result) => {
                         if (result.isConfirmed) {
                              fetch(url, {
                                   method: 'POST',
                                   headers: {
                                        'Content-Type': 'application/json',
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
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
                                             toastr.success(data.message);
                                             setTimeout(() => location.reload(), 1000); // Reload after 1s
                                        } else {
                                             toastr.error(data.message);
                                        }
                                   })
                                   .catch(error => {
                                        console.error('Error:', error);
                                        toastr.error('একটি ত্রুটি ঘটেছে। পরে আবার চেষ্টা করুন।');
                                   });
                         }
                    });
               });
          };

          attachClickHandler(activateBtn, 1);
          attachClickHandler(deactivateBtn, 0);
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

     // Select2 input reset
     var handleResetButton = function () {
          document.querySelectorAll('form').forEach(form => {
               form.addEventListener('reset', function () {
                    // Slight delay to allow form reset to complete
                    setTimeout(function () {
                         document.querySelectorAll('select[data-control="select2"]').forEach(select => {
                              select.value = '';

                              // Create and dispatch a 'change' event
                              const event = new Event('change');
                              select.dispatchEvent(event);
                         });
                    }, 50);
               });
          });
     };

     // ------------------ kt_add_prescription_form ----------------
     // Init quill editor
     const initQuill = () => {
          const editors = [
               { selector: '#kt_disease_brief_editor', inputId: 'disease_brief_input' },
               { selector: '#kt_medication_editor', inputId: 'medication_input' }
          ];

          editors.forEach(({ selector, inputId }) => {
               let el = document.querySelector(selector);
               if (!el) return;

               let quill = new Quill(el, {
                    modules: {
                         toolbar: [
                              [{ header: [false] }],
                              ['italic', 'underline', 'strike'],
                              [{ list: 'ordered' }, { list: 'bullet' }, { list: 'check' }],
                              [{ align: [] }],
                         ]
                    },
                    placeholder: 'তথ্যসমূহ লিখুন...',
                    theme: 'snow'
               });

               quillInstances[inputId] = quill;
          });
     };

     document.querySelector('#kt_add_prescription_form').addEventListener('submit', function (e) {
          for (let inputId in quillInstances) {
               let quill = quillInstances[inputId];
               let html = quill.root.innerHTML;
               document.getElementById(inputId).value = html;
          }
     });

     //Update the value when the modal is opened
     const addPrescriptionModal = document.getElementById('kt_add_prescription_modal');

     addPrescriptionModal.addEventListener('show.bs.modal', function (event) {
          // Button that triggered the modal
          const button = event.relatedTarget;

          // Get the data-service-record-id value
          const serviceRecordId = button.getAttribute('data-service-record-id');

          // Set it to the hidden input inside the form
          document.getElementById('service_record_id_input').value = serviceRecordId;
     });

     // ------------------- kt_view_prescription_modal --------------
     var handlePrescriptionModalAJAX = function () {

          const viewPrescriptionModal = document.getElementById('kt_view_prescription_modal');

          viewPrescriptionModal.addEventListener('show.bs.modal', function (event) {
               const button = event.relatedTarget;
               const prescriptionId = button.getAttribute('data-prescription-id');

               // Optional: show loading spinner or placeholder
               document.getElementById('kt_disease_brief_data').innerHTML = '<p>লোড হচ্ছে...</p>';
               document.getElementById('kt_medication_data').innerHTML = '';
               document.getElementById('kt_additional_notes_data').innerHTML = '';

               // Make AJAX request to fetch prescription
               fetch(`/prescriptions/${prescriptionId}`)
                    .then(response => {
                         if (!response.ok) throw new Error('ডেটা লোড করতে ব্যর্থ হয়েছে।');
                         return response.json();
                    })
                    .then(data => {
                         const status = data.status; // 'pending' or 'approved'

                         let badgeClass = '';
                         let badgeText = '';

                         if (status === 'pending') {
                              badgeClass = 'badge badge-warning';
                              badgeText = 'পেন্ডিং';
                              document.getElementById('prescription_approve_button').setAttribute('data-prescription-id', data.id);
                              document.getElementById('prescription_approve_button').classList.remove('d-none');

                         } else if (status === 'approved') {
                              badgeClass = 'badge badge-success';
                              badgeText = 'অনুমোদিত';
                              document.getElementById('prescription_approve_button').classList.add('d-none');

                         } else {
                              badgeClass = 'badge badge-info';
                              badgeText = 'অজানা';
                         }

                         document.getElementById('kt_disease_brief_data').innerHTML = data.disease_brief;
                         document.getElementById('kt_medication_data').innerHTML = data.medication;
                         document.getElementById('kt_additional_notes_data').innerHTML = data.additional_notes || '<span class="text-muted">কোনো অতিরিক্ত তথ্য নেই।</span>';
                         document.getElementById('view_precription_status').innerHTML =
                              '<span class="' + badgeClass + '">' + badgeText + '</span>';
                    })
                    .catch(error => {
                         document.getElementById('kt_disease_brief_data').innerHTML = `<p class="text-danger">${error.message}</p>`;
                    });
          });
     };

     // ------------------- handlePrescriptionApprovalAJAX --------------
     var handlePrescriptionApprovalAJAX = function () {
          const button = document.getElementById('prescription_approve_button');

          if (!button) return;

          button.addEventListener('click', function () {
               const prescriptionId = this.getAttribute('data-prescription-id');

               if (!prescriptionId) {
                    toastr.error('প্রেসক্রিপশন আইডি পাওয়া যায়নি!');
                    return;
               }

               Swal.fire({
                    title: 'আপনি কি নিশ্চিত?',
                    text: 'এই প্রেসক্রিপশনটি অনুমোদন করতে চান?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ, অনুমোদন করুন',
                    cancelButtonText: 'ক্যানসেল',
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545'
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
                                   document.getElementById('view_precription_status').innerHTML =
                                        '<span class="badge badge-success">অনুমোদিত</span>';
                                   button.remove(); // Optional: Remove or disable button
                                   setTimeout(() => {
                                        location.reload();
                                   }, 3000); // Delay a bit to let user see the toast
                              })
                              .catch(error => {
                                   toastr.error('অনুমোদন ব্যর্থ হয়েছে। আবার চেষ্টা করুন।');
                                   console.error(error);
                              });
                    }
               });
          });
     };

     return {
          // Public functions  
          init: function () {
               table = document.getElementById('kt_service_records_table');

               if (!table) {
                    return;
               }

               initDatatable();
               handleSearch();
               handleDeletion();
               handleToggleActivation();
               handleFarmApproval();
               handleResetButton();

               // Init quill on modal forms
               initQuill();

               handlePrescriptionModalAJAX();
               handlePrescriptionApprovalAJAX();
          }
     }
}();


// On document ready
KTUtil.onDOMContentLoaded(function () {
     KTFarmView.init();
});