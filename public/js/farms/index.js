"use strict";

var KTFarmsList = function () {
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
               'columnDefs': [{ orderable: false, targets: [4, 5, 6, 7, 8] }]
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

     // Filter Datatable
     var handleFilter = function () {
          // Select filter options
          const filterForm = document.querySelector('[data-kt-farm-table-filter="form"]');
          const filterButton = filterForm.querySelector('[data-kt-farm-table-filter="filter"]');
          const resetButton = filterForm.querySelector('[data-kt-farm-table-filter="reset"]');
          const selectOptions = filterForm.querySelectorAll('select');

          // Filter datatable on submit
          filterButton.addEventListener('click', function () {
               var filterString = '';

               // Get filter values
               selectOptions.forEach((item, index) => {
                    if (item.value && item.value !== '') {
                         if (index !== 0) {
                              filterString += ' ';
                         }

                         // Build filter value options
                         filterString += item.value;
                    }
               });

               // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
               datatable.search(filterString).draw();
          });

          // Reset datatable
          resetButton.addEventListener('click', function () {
               // Reset filter form
               selectOptions.forEach((item, index) => {
                    // Reset Select2 dropdown --- official docs reference: https://select2.org/programmatic-control/add-select-clear-items
                    $(item).val(null).trigger('change');
               });

               // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
               datatable.search('').draw();
          });
     }

     // Delete pending students
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
                         confirmButtonText: 'হ্যাঁ, ডিলিট করবো।',
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
                                                  location.reload(); // Reload to reflect changes
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
          const toggleInputs = document.querySelectorAll('.toggle-active');

          toggleInputs.forEach(input => {
               input.addEventListener('change', function () {
                    const farmId = this.value;
                    const isActive = this.checked ? 1 : 0;
                    const row = this.closest('tr'); // Get the parent <tr> element

                    console.log('Farm ID:', farmId);

                    let url = routeToggleActive.replace(':id', farmId);  // Replace ':id' with actual student ID


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
               table = document.getElementById('kt_farms_table');

               if (!table) {
                    return;
               }

               initDatatable();
               handleSearch();
               handleDeletion();
               handleFilter();
               handleToggleActivation();
          }
     }
}();


// On document ready
KTUtil.onDOMContentLoaded(function () {
     KTFarmsList.init();
});