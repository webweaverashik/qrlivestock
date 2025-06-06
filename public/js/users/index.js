"use strict";

var KTUsersList = function () {
     // Define shared variables
     var table;
     var datatable;

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
               'columnDefs': [{ orderable: false, targets: [4, 5] }]
          });

          // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
          datatable.on('draw', function () {

          });
     }

     // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
     var handleSearch = function () {
          const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
          filterSearch.addEventListener('keyup', function (e) {
               datatable.search(e.target.value).draw();
          });
     }

     // Delete users
     var handleDeletion = function () {
          document.querySelectorAll('.delete-user').forEach(item => {
               item.addEventListener('click', function (e) {
                    e.preventDefault();

                    let userId = this.getAttribute('data-user-id');
                    console.log('User ID:', userId);

                    let url = routeDeleteUser.replace(':id', userId);  // Replace ':id' with actual user ID

                    Swal.fire({
                         title: 'আপনি কি নিশ্চিত ডিলিট করতে চান?',
                         text: "ডিলিট করার পর এই ইউজারের কোনো তথ্য থাকবে না। ",
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
                                                  text: 'ইউজারটি সফলভাবে ডিলিট করা হয়েছে।',
                                                  icon: 'success',
                                                  confirmButtonText: 'ঠিক আছে।'
                                             }).then(() => {
                                                  location.reload(); // Reload to reflect changes
                                             });
                                        } else {
                                             Swal.fire('ব্যর্থ!', 'ইউজার ডিলিট করা যায়নি।',
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
          const toggleInputs = document.querySelectorAll('.toggle-active');

          toggleInputs.forEach(input => {
               input.addEventListener('change', function () {
                    const userId = this.value;
                    const isActive = this.checked ? 1 : 0;
                    const row = this.closest('tr'); // Get the parent <tr> element

                    console.log('User ID:', userId);

                    let url = routeToggleActive.replace(':id', userId);  // Replace ':id' with actual student ID


                    fetch(url, {
                         method: 'POST',
                         headers: {
                              'Content-Type': 'application/json',
                              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                         },
                         body: JSON.stringify({
                              user_id: userId,
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
                              } else {
                                   toastr.error(data.message);
                              }
                         })
                         .catch(error => {
                              console.error('Error:', error);
                              toastr.error('Error occurred while toggling farm status');
                         });
               });
          });
     };

     return {
          // Public functions  
          init: function () {
               table = document.getElementById('kt_table_users');

               if (!table) {
                    return;
               }

               initDatatable();
               handleSearch();
               handleDeletion();
               handleToggleActivation();
          }
     }
}();

var KTUsersAddUser = function () {
     // Shared variables
     const element = document.getElementById('kt_modal_add_user');
     const form = element.querySelector('#kt_modal_add_user_form');
     const modal = new bootstrap.Modal(element);
 
     // Init add schedule modal
     var initAddUser = () => {
 
         // Cancel button handler
         const cancelButton = element.querySelector('[data-kt-users-modal-action="cancel"]');
         cancelButton.addEventListener('click', e => {
             e.preventDefault();
 
             form.reset(); // Reset form			
             modal.hide();
         });
 
         // Close button handler
         const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
         closeButton.addEventListener('click', e => {
             e.preventDefault();
 
             form.reset(); // Reset form			
             modal.hide();
         });
     }
 
     return {
         // Public functions
         init: function () {
             initAddUser();
         }
     };
 }();
 
 var KTUsersEditUser = function () {
     // Shared variables
     const element = document.getElementById('kt_modal_edit_user');
     const form = element.querySelector('#kt_modal_edit_user_form');
     const modal = new bootstrap.Modal(element);
 
     // Init add schedule modal
     var initEditUser = () => {
 
         // Cancel button handler
         const cancelButton = element.querySelector('[data-kt-users-modal-action="cancel"]');
         cancelButton.addEventListener('click', e => {
             e.preventDefault();
 
             form.reset(); // Reset form			
             modal.hide();
         });
 
         // Close button handler
         const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
         closeButton.addEventListener('click', e => {
             e.preventDefault();
 
             form.reset(); // Reset form			
             modal.hide();
         });
     }
 
     return {
         // Public functions
         init: function () {
             initEditUser();
         }
     };
 }();
 
 var KTUsersEditPassword = function () {
     // Shared variables
     const element = document.getElementById('kt_modal_edit_password');
     const form = element.querySelector('#kt_modal_edit_password_form');
     const modal = new bootstrap.Modal(element);
 
     // Init add schedule modal
     var initEditPassword = () => {
 
         // Cancel button handler
         const cancelButton = element.querySelector('[data-kt-edit-password-modal-action="cancel"]');
         cancelButton.addEventListener('click', e => {
             e.preventDefault();
 
             form.reset(); // Reset form			
             modal.hide();
         });
 
         // Close button handler
         const closeButton = element.querySelector('[data-kt-edit-password-modal-action="close"]');
         closeButton.addEventListener('click', e => {
             e.preventDefault();
 
             form.reset(); // Reset form			
             modal.hide();
         });
     }
 
     return {
         // Public functions
         init: function () {
          initEditPassword();
         }
     };
 }();

// On document ready
KTUtil.onDOMContentLoaded(function () {
     KTUsersList.init();
     KTUsersAddUser.init();
     KTUsersEditUser.init();
     KTUsersEditPassword.init();
});