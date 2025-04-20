"use strict";

var KTPendingPrescriptionsList = function () {
     // Define shared variables
     var table;
     var datatable;
     const quillInstances = {};

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
          document.addEventListener('click', function (event) {
               const button = event.target.closest('.approve-prescription');
               if (!button) return;

               event.preventDefault();

               const prescriptionId = button.getAttribute('data-prescription-id');
               console.log('Prescription ID: ', prescriptionId);

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
                         const form = document.createElement('form');
                         form.method = 'POST';
                         form.action = `/prescriptions/${prescriptionId}/approve`;

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
          });
     };



     // ------------------ kt_add_prescription_form ----------------
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
                              [{ align: [] }]
                         ],
                         keyboard: {
                              bindings: {
                                   bold: {
                                        key: 'b',
                                        shortKey: true,
                                        handler: function () {
                                             return false;
                                        }
                                   }
                              }
                         }
                    },
                    placeholder: 'তথ্যসমূহ লিখুন...',
                    theme: 'snow'
               });

               quillInstances[inputId] = quill;
          });
     };

     const modal = document.getElementById('kt_edit_prescription_modal');
     const form = document.getElementById('kt_edit_prescription_form');

     modal.addEventListener('show.bs.modal', function (event) {
          const button = event.relatedTarget;
          const prescriptionId = button.getAttribute('data-prescription-id');
          const updateUrl = button.getAttribute('data-update-url');

          form.setAttribute('data-update-url', updateUrl);

          // Fetch prescription data
          fetch(`/prescriptions/${prescriptionId}`)
               .then(response => response.json())
               .then(data => {
                    document.querySelector('[name="service_record_id"]').value = data.service_record_id;
                    document.querySelector('[name="livestock_type_id"]').value = data.livestock_type_id;
                    document.querySelector('[name="livestock_age"]').value = data.livestock_age;
                    document.querySelector('[name="livestock_weight"]').value = data.livestock_weight;
                    document.querySelector('[name="livestock_temp"]').value = data.livestock_temp;
                    document.querySelector('[name="livestock_pulse"]').value = data.livestock_pulse;
                    document.querySelector('[name="livestock_rumen_motility"]').value = data.livestock_rumen_motility;
                    document.querySelector('[name="livestock_respiratory"]').value = data.livestock_respiratory;
                    document.querySelector('[name="livestock_other"]').value = data.livestock_other;
                    document.querySelector('[name="additional_notes"]').value = data.additional_notes;

                    quillInstances['disease_brief_input'].root.innerHTML = data.disease_brief ?? '';
                    quillInstances['medication_input'].root.innerHTML = data.medication ?? '';

                    // Reinitialize select2
                    $('[name="livestock_type_id"]').val(data.livestock_type_id).trigger('change');
               });
     });

     form.addEventListener('submit', function (e) {
          e.preventDefault();

          for (let inputId in quillInstances) {
               document.getElementById(inputId).value = quillInstances[inputId].root.innerHTML;
          }

          const formData = new FormData(form);
          const updateUrl = form.getAttribute('data-update-url');

          fetch(updateUrl, {
               method: 'POST',
               headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'X-Requested-With': 'XMLHttpRequest',
               },
               body: formData
          })
               .then(response => {
                    if (!response.ok) {
                         return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
               })
               .then(data => {
                    toastr.success('সফলভাবে আপডেট হয়েছে!');
                    setTimeout(() => {
                         window.location.reload();
                    }, 1000);
               })
               .catch(error => {
                    console.error(error);
                    toastr.error('আপডেট করতে ব্যর্থ হয়েছে। আবার চেষ্টা করুন।');
               });
     });



     return {
          // Public functions  
          init: function () {
               table = document.getElementById('kt_pending_prescriptions_table');

               if (!table) {
                    return;
               }

               initDatatable();
               handleSearch();

               // Init quill on modal forms
               initQuill();
               handlePrescriptionApprovalAJAX();
          }
     }
}();


// On document ready
KTUtil.onDOMContentLoaded(function () {
     KTPendingPrescriptionsList.init();
});