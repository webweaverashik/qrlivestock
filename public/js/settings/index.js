"use strict";

var KTCustomDatatableHandler = function () {
     var initDatatable = function (tableId, searchFilterAttr, nonOrderableTargets = []) {
          const table = document.getElementById(tableId);
          if (!table) return;

          const datatable = $(table).DataTable({
               "info": true,
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

     var handleModalSetup = function () {
          const settingTitle = document.getElementById("kt_add_setting_title");
          const settingNameInput = document.querySelector("input[name='setting_name']");
          const settingTypeInput = document.getElementById("setting_type_input");
          const submitBtn = document.getElementById("kt_add_setting_submit");
          const modalHeading = document.getElementById("kt_modal_add_setting_title");

          function updateModal(titleText, placeholderText, settingValue, btnClass, headingText) {
               settingTitle.innerText = titleText;
               settingNameInput.placeholder = placeholderText;
               settingTypeInput.value = settingValue;

               // Update submit button class
               submitBtn.className = 'btn ' + btnClass;

               // Update modal heading
               modalHeading.innerText = headingText;
          }

          document.getElementById("addLivestockType")?.addEventListener("click", function () {
               updateModal("প্রাণির ধরণ", "প্রাণির ধরণ লিখুন যেমন: গরু", "1", "btn-primary", "নতুন প্রাণির ধরণ যুক্ত করুন");
          });

          document.getElementById("addServiceCategory")?.addEventListener("click", function () {
               updateModal("সেবার ধরণ", "সেবার ধরণ লিখুন যেমন: টিকা প্রদান", "2", "btn-success", "নতুন সেবা যুক্ত করুন");
          });

          document.getElementById("addDisease")?.addEventListener("click", function () {
               updateModal("রোগের ধরণ", "রোগের ধরণ লিখুন যেমন: তড়কা", "3", "btn-info", "নতুন রোগ যুক্ত করুন");
          });
     }


     return {
          init: function () {
               initDatatable('kt_table_service_categories', 'data-kt-service-category-table-filter="search"', [1]);
               initDatatable('kt_table_diseases', 'data-kt-disease-table-filter="search"', [1]);
               handleModalSetup();
          }
     }
}();

KTUtil.onDOMContentLoaded(function () {
     KTCustomDatatableHandler.init();
});
