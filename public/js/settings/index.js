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


     const handleEditModalSetup = () => {
          document.addEventListener('click', function (e) {
               const target = e.target.closest('[data-setting-id]');
               if (!target || !target.hasAttribute('data-bs-target') || target.getAttribute('data-bs-target') !== '#kt_edit_setting_modal') {
                    return;
               }

               const settingId = target.getAttribute('data-setting-id');
               const settingName = target.getAttribute('data-setting-name');
               let settingType, title, placeholder, btnClass, formTitle;

               if (target.classList.contains('text-hover-primary')) {
                    settingType = 1;
                    title = 'প্রাণির ধরণ';
                    placeholder = 'প্রাণির ধরণ লিখুন যেমন: গরু';
                    btnClass = 'btn-primary';
                    formTitle = 'প্রাণির ধরণ আপডেট';
               } else if (target.classList.contains('text-hover-success')) {
                    settingType = 2;
                    title = 'সেবার ধরণ';
                    placeholder = 'সেবার ধরণ লিখুন যেমন: টিকা প্রদান';
                    btnClass = 'btn-success';
                    formTitle = 'সেবার ধরণ আপডেট';
               } else if (target.classList.contains('text-hover-info')) {
                    settingType = 3;
                    title = 'রোগের ধরণ';
                    placeholder = 'রোগের ধরণ লিখুন যেমন: তড়কা';
                    btnClass = 'btn-info';
                    formTitle = 'রোগের ধরণ আপডেট';
               }

               // DOM elements
               const form = document.getElementById('kt_edit_setting_form');
               const settingNameInput = form.querySelector('input[name="setting_name"]');
               const typeInput = document.getElementById('edit_setting_type_input');
               const titleLabel = document.getElementById('kt_edit_setting_title');
               const formTitleHeading = document.getElementById('kt_modal_edit_setting_title');
               const submitButton = document.getElementById('kt_edit_setting_submit');

               // Set values
               form.action = `/settings/${settingId}`;
               typeInput.value = settingType;
               settingNameInput.value = settingName || '';
               settingNameInput.placeholder = placeholder;
               titleLabel.textContent = title;
               formTitleHeading.textContent = formTitle;

               // Button styling
               submitButton.classList.remove('btn-primary', 'btn-success', 'btn-info');
               submitButton.classList.add(btnClass);
          });
     };



     return {
          init: function () {
               initDatatable('kt_table_service_categories', 'data-kt-service-category-table-filter="search"', [1]);
               initDatatable('kt_table_diseases', 'data-kt-disease-table-filter="search"', [1]);
               handleModalSetup();
               handleEditModalSetup();
          }
     }
}();

KTUtil.onDOMContentLoaded(function () {
     KTCustomDatatableHandler.init();
});
